<?php

declare(strict_types=1);

namespace App\Controller\Customer;

use Cake\Http\Response;

class ProductsController extends AppController
{
    protected function getPublicActions(): array
    {
        return [
            'index',
            'view',
            'addToCart',
        ];
    }

    public function index(): void
    {
        $query = $this->fetchTable('Products')
            ->find()
            ->contain(['Categories'])
            ->where(['Products.is_active' => 1]);

        $categoryId = $this->request->getQuery('category_id');

        if ($categoryId !== null && ctype_digit((string)$categoryId)) {
            $query->where([
                'Products.category_id' => (int)$categoryId,
            ]);
        }

        $products = $this->paginate($query, [
            'limit' => 12,
            'order' => ['Products.created' => 'DESC'],
        ]);

        $categories = $this->fetchTable('Categories')
            ->find()
            ->where(['Categories.is_active' => 1])
            ->all();

        $this->set(compact('products', 'categories'));
    }



    /**
     * Add a product to the shopping cart.
     */

    public function addToCart(string $id)
    {
        $this->request->allowMethod(['post']);

        $product = $this->fetchTable('Products')
            ->find()
            ->where([
                'Products.id' => $id,
                'Products.is_active' => 1,
            ])
            ->first();

        if (!$product) {
            return $this->cartJson([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        if ((int)$product->stock <= 0) {
            return $this->cartJson([
                'success' => false,
                'message' => 'This product is out of stock.',
            ], 400);
        }

        $session = $this->request->getSession();
        $cart = $session->read('Cart', []);

        $productId = (string)$product->id;
        $currentQuantity = (int)($cart[$productId] ?? 0);

        if ($currentQuantity >= (int)$product->stock) {
            return $this->cartJson([
                'success' => false,
                'message' => 'You cannot add more than the available stock.',
            ], 400);
        }

        $cart[$productId] = $currentQuantity + 1;
        $session->write('Cart', $cart);

        $cartCount = array_sum($cart);

        return $this->cartJson([
            'success' => true,
            'message' => $product->name . ' added to your cart.',
            'cartCount' => $cartCount,
        ]);
    }

    /**
     * Return a JSON response for cart AJAX requests.
     */
    private function cartJson(array $data, int $status = 200): Response
    {
        return $this->response
            ->withType('application/json')
            ->withStatus($status)
            ->withStringBody(json_encode($data));
    }


    public function view(string $id): void
    {
        $product = $this->fetchTable('Products')
            ->find()
            ->contain(['Categories'])
            ->where(['Products.id' => $id])
            ->firstOrFail();

        $this->set(compact('product'));
    }
}
