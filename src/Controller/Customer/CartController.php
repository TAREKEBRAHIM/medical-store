<?php

declare(strict_types=1);

namespace App\Controller\Customer;

use Cake\Http\Response;

class CartController extends AppController
{
    protected function getPublicActions(): array
    {
        return [
            'index',
            'update',
            'remove',
        ];
    }

    public function index(): void
    {
        $cart = $this->request->getSession()->read('Cart', []);

        $products = [];
        $total = 0;
        $cartCount = array_sum($cart);

        if (!empty($cart)) {
            $products = $this->fetchTable('Products')
                ->find()
                ->where([
                    'Products.id IN' => array_keys($cart),
                    'Products.is_active' => 1,
                ])
                ->all()
                ->toArray();

            foreach ($products as $product) {
                $quantity = (int)$cart[(string)$product->id];

                $product->cart_quantity = $quantity;
                $product->subtotal = (float)$product->price * $quantity;

                $total += $product->subtotal;
            }
        }

        $this->set(compact('products', 'total', 'cartCount'));
    }




    public function checkout()
    {
        // Get the currently logged-in user.
        $identity = $this->Authentication->getIdentity();

        // Allow checkout for customers only.
        if (!$identity || $identity->get('role') !== 'customer') {
            $this->Flash->error('Please log in as a customer before checkout.');
            return $this->redirect('/login');
        }

        $session = $this->request->getSession();
        $cart = $session->read('Cart', []);

        // Prevent checkout with an empty cart.
        if (empty($cart)) {
            $this->Flash->error('Your cart is empty.');
            return $this->redirect(['_name' => 'customerCart']);
        }

        $productsTable = $this->fetchTable('Products');
        $ordersTable = $this->fetchTable('Orders');
        $orderItemsTable = $this->fetchTable('OrderItems');

        // Load active products from the database.
        $products = $productsTable->find()
            ->where([
                'Products.id IN' => array_keys($cart),
                'Products.is_active' => 1,
            ])
            ->all()
            ->toArray();

        // Make sure every cart product is still available.
        if (count($products) !== count($cart)) {
            $this->Flash->error('Some products in your cart are no longer available.');
            return $this->redirect(['_name' => 'customerCart']);
        }

        // Handle order submission.
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $customerName = trim((string)($data['customer_name'] ?? ''));
            $phone = trim((string)($data['phone'] ?? ''));
            $city = trim((string)($data['city'] ?? ''));
            $address = trim((string)($data['address'] ?? ''));

            // Validate required delivery information.
            if (
                $customerName === '' ||
                $phone === '' ||
                $city === '' ||
                $address === ''
            ) {
                $this->Flash->error('Please complete all delivery information.');
                return $this->redirect(['_name' => 'customerCheckout']);
            }

            // Recalculate the order total using database prices.
            $total = 0;

            foreach ($products as $product) {
                $quantity = (int)$cart[(string)$product->id];

                if ($quantity < 1 || $quantity > (int)$product->stock) {
                    $this->Flash->error(
                        'Insufficient stock for ' . $product->name . '.'
                    );
                    return $this->redirect(['_name' => 'customerCart']);
                }

                $total += (float)$product->price * $quantity;
            }

            $connection = $ordersTable->getConnection();

            try {
                // Save the order and its items as one database transaction.
                $orderId = $connection->transactional(
                    function () use (
                        $ordersTable,
                        $orderItemsTable,
                        $productsTable,
                        $products,
                        $cart,
                        $identity,
                        $customerName,
                        $phone,
                        $city,
                        $address,
                        $total
                    ) {
                        $order = $ordersTable->newEntity([
                            'user_id' => $identity->getIdentifier(),
                            'customer_name' => $customerName,
                            'phone' => $phone,
                            'city' => $city,
                            'address' => $address,
                            'total' => $total,
                            'payment_method' => 'cod',
                            'status' => 'pending',
                        ]);

                        $ordersTable->saveOrFail($order);

                        foreach ($products as $product) {
                            $quantity = (int)$cart[(string)$product->id];
                            $unitPrice = (float)$product->price;
                            $subtotal = $unitPrice * $quantity;

                            // Decrease stock only if enough stock is still available.
                            $result = $productsTable->getConnection()->execute(
                                'UPDATE products
                             SET stock = stock - :quantity
                             WHERE id = :id AND stock >= :requiredQuantity',
                                [
                                    'quantity' => $quantity,
                                    'id' => $product->id,
                                    'requiredQuantity' => $quantity,
                                ],
                                [
                                    'quantity' => 'integer',
                                    'id' => 'integer',
                                    'requiredQuantity' => 'integer',
                                ]
                            );

                            if ($result->rowCount() !== 1) {
                                throw new \RuntimeException(
                                    'Insufficient stock for ' . $product->name
                                );
                            }

                            $item = $orderItemsTable->newEntity([
                                'order_id' => $order->id,
                                'product_id' => $product->id,
                                'product_name' => $product->name,
                                'quantity' => $quantity,
                                'unit_price' => $unitPrice,
                                'subtotal' => $subtotal,
                            ]);

                            $orderItemsTable->saveOrFail($item);
                        }

                        return $order->id;
                    }
                );

                // Clear the cart only after the transaction succeeds.
                $session->delete('Cart');

                return $this->redirect([
                    '_name' => 'customerOrderConfirmation',
                    'id' => $orderId,
                ]);

                return $this->redirect('/');
            } catch (\Throwable $exception) {
                $this->log($exception->getMessage(), 'error');

                $this->Flash->error(
                    'Unable to place your order. Please check your cart and try again.'
                );

                return $this->redirect(['_name' => 'customerCart']);
            }
        }

        // Prepare the checkout page for GET requests.
        $total = 0;

        foreach ($products as $product) {
            $quantity = (int)$cart[(string)$product->id];
            $product->cart_quantity = $quantity;
            $product->subtotal = (float)$product->price * $quantity;
            $total += $product->subtotal;
        }

        $this->set(compact('products', 'total'));
    }



    public function confirmation(string $id)
    {
        // Get the currently logged-in customer.
        $identity = $this->Authentication->getIdentity();

        if (!$identity || $identity->get('role') !== 'customer') {
            $this->Flash->error('Please log in to view your order.');
            return $this->redirect('/login');
        }

        // Find the order and its items for this customer only.
        $order = $this->fetchTable('Orders')
            ->find()
            ->contain(['OrderItems'])
            ->where([
                'Orders.id' => $id,
                'Orders.user_id' => $identity->getIdentifier(),
            ])
            ->first();

        if (!$order) {
            $this->Flash->error('Order not found.');
            return $this->redirect('/');
        }

        $this->set(compact('order'));
    }




    public function update(string $id): Response
    {
        $this->request->allowMethod(['post']);

        $session = $this->request->getSession();
        $cart = $session->read('Cart', []);

        $product = $this->fetchTable('Products')
            ->find()
            ->where([
                'Products.id' => $id,
                'Products.is_active' => 1,
            ])
            ->first();

        if (!$product || !isset($cart[$id])) {
            return $this->cartJson([
                'success' => false,
                'message' => 'Product not found in cart.',
            ], 404);
        }

        $quantity = filter_var(
            $this->request->getData('quantity'),
            FILTER_VALIDATE_INT
        );

        if ($quantity === false || $quantity < 1) {
            return $this->cartJson([
                'success' => false,
                'message' => 'Invalid quantity.',
            ], 400);
        }

        if ($quantity > (int)$product->stock) {
            return $this->cartJson([
                'success' => false,
                'message' => 'Only ' . $product->stock . ' items are available.',
            ], 400);
        }

        $cart[$id] = $quantity;
        $session->write('Cart', $cart);

        $total = $this->calculateTotal($cart);
        $cartCount = array_sum($cart);

        return $this->cartJson([
            'success' => true,
            'quantity' => $quantity,
            'subtotal' => (float)$product->price * $quantity,
            'total' => $total,
            'cartCount' => $cartCount,
            'message' => 'Cart updated.',
        ]);
    }

    public function remove(string $id): Response
    {
        $this->request->allowMethod(['post']);

        $session = $this->request->getSession();
        $cart = $session->read('Cart', []);

        if (!isset($cart[$id])) {
            return $this->cartJson([
                'success' => false,
                'message' => 'Product not found in cart.',
            ], 404);
        }

        unset($cart[$id]);

        $session->write('Cart', $cart);

        return $this->cartJson([
            'success' => true,
            'total' => $this->calculateTotal($cart),
            'cartCount' => array_sum($cart),
            'message' => 'Product removed from cart.',
        ]);
    }

    private function calculateTotal(array $cart): float
    {
        if (empty($cart)) {
            return 0;
        }

        $products = $this->fetchTable('Products')
            ->find()
            ->where([
                'Products.id IN' => array_keys($cart),
                'Products.is_active' => 1,
            ])
            ->all();

        $total = 0;

        foreach ($products as $product) {
            $quantity = (int)$cart[(string)$product->id];
            $total += (float)$product->price * $quantity;
        }

        return $total;
    }

    private function cartJson(array $data, int $status = 200): Response
    {
        return $this->response
            ->withType('application/json')
            ->withStatus($status)
            ->withStringBody(json_encode($data));
    }
}
