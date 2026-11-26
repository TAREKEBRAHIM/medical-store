<?php

declare(strict_types=1);

namespace App\Controller\Admin;

class ProductsController extends AppController
{
public function index(): void
{
    $productsTable = $this->fetchTable('Products');

    // Get products with their categories.
    $query = $productsTable
        ->find()
        ->contain(['Categories']);

    // Search products by name.
    $search = trim((string)$this->request->getQuery('q'));

    if ($search !== '') {
        $query->where([
            'Products.name LIKE' => '%' . $search . '%',
        ]);
}

    // Filter products by category.
    $categoryId = $this->request->getQuery('category_id');

    if ($categoryId !== null && ctype_digit((string)$categoryId)) {
        $query->where([
            'Products.category_id' => (int)$categoryId,
        ]);
    }

    // Paginate products.
    $products = $this->paginate($query, [
        'limit' => 10,
        'order' => ['Products.created' => 'DESC'],
    ]);

    // Get categories for the filter.
    $categoriesTable = $this->fetchTable('Categories');

    $categories = $categoriesTable
        ->find('list')
        ->toArray();

    // Dashboard statistics.
    $totalProducts = $productsTable->find()->count();

    $activeProducts = $productsTable->find()
        ->where(['is_active' => 1])
        ->count();

    $inactiveProducts = $productsTable->find()
        ->where(['is_active' => 0])
        ->count();

    $lowStockProducts = $productsTable->find()
        ->where([
            'stock <=' => 5,
            'is_active' => 1,
        ])
        ->count();

    $totalCategories = $categoriesTable
        ->find()
        ->count();

    $totalCustomers = $this->fetchTable('Users')
        ->find()
        ->where(['role' => 'customer'])
        ->count();

    // Get product counts grouped by category.
    $categoryQuery = $productsTable->find();

    $categoryStats = $categoryQuery
        ->select([
            'category_name' => 'Categories.name',
            'product_count' => $categoryQuery->func()->count('Products.id'),
        ])
        ->leftJoinWith('Categories')
        ->group([
            'Categories.id',
            'Categories.name',
        ])
        ->enableAutoFields(false)
        ->all();

    // Prepare chart data.
    $categoryChartLabels = [];
    $categoryChartData = [];

    foreach ($categoryStats as $stat) {
        $categoryChartLabels[] = $stat->category_name ?? 'Uncategorized';
        $categoryChartData[] = (int)$stat->product_count;
    }

    $statusChartData = [
        $activeProducts,
        $inactiveProducts,
    ];

    $this->set(compact(
        'products',
        'categories',
        'totalProducts',
        'activeProducts',
        'inactiveProducts',
        'lowStockProducts',
        'totalCategories',
        'totalCustomers',
        'search',
        'categoryId',
        'categoryChartLabels',
        'categoryChartData',
        'statusChartData'
    ));
}




    /**
     * Add a new product.
     */
    public function add()
    {
        $productsTable = $this->fetchTable('Products');
        $product = $productsTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $imageFile = $this->request->getUploadedFile('image');
            unset($data['image']);

            $product = $productsTable->patchEntity($product, $data);

            $canSave = true;

            if (
                $imageFile !== null &&
                $imageFile->getError() !== UPLOAD_ERR_NO_FILE
            ) {
                if ($imageFile->getError() !== UPLOAD_ERR_OK) {
                    $this->Flash->error('Image upload failed.');
                    $canSave = false;
                } else {
                    $originalName = $imageFile->getClientFilename();

                    $extension = strtolower(
                        pathinfo($originalName, PATHINFO_EXTENSION)
                    );

                    $allowedExtensions = [
                        'jpg',
                        'jpeg',
                        'png',
                        'webp',
                    ];

                    $fileSize = $imageFile->getSize() ?? 0;

                    if (
                        !in_array($extension, $allowedExtensions, true) ||
                        $fileSize <= 0 ||
                        $fileSize > 5 * 1024 * 1024
                    ) {
                        $this->Flash->error(
                            'Please upload a valid image (JPG, PNG, WEBP) up to 5 MB.'
                        );

                        $canSave = false;
                    } else {
                        $fileName = bin2hex(random_bytes(8)) . '.' . $extension;

                        $uploadDirectory = WWW_ROOT . 'img' . DS . 'products' . DS;

                        if (!is_dir($uploadDirectory)) {
                            mkdir($uploadDirectory, 0755, true);
                        }

                        $imageFile->moveTo(
                            $uploadDirectory . $fileName
                        );

                        $product->image = 'products/' . $fileName;
                    }
                }
            }

            if ($canSave) {
                if ($productsTable->save($product)) {
                    $this->Flash->success('Product added successfully.');

                    return $this->redirect([
                        'prefix' => 'Admin',
                        'controller' => 'Products',
                        'action' => 'index',
                    ]);
                }

                $this->Flash->error('Unable to add product.');
            }
        }

        $categories = $this->fetchTable('Categories')
            ->find('list')
            ->where(['is_active' => 1])
            ->toArray();

        $this->set(compact('product', 'categories'));
    }

    /**
     * Edit an existing product.
     */

    /**
     * Edit an existing product.
     */
    public function edit(string $id)
    {
        $productsTable = $this->fetchTable('Products');
        $product = $productsTable->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();

            // Get uploaded image separately.
            $imageFile = $this->request->getUploadedFile('image');

            // Prevent the uploaded file from being patched as a normal field.
            unset($data['image']);

            $product = $productsTable->patchEntity($product, $data);

            $canSave = true;

            // Process image only if a new file was selected.
            if (
                $imageFile !== null &&
                $imageFile->getError() !== UPLOAD_ERR_NO_FILE
            ) {
                if ($imageFile->getError() !== UPLOAD_ERR_OK) {
                    $this->Flash->error('Image upload failed.');
                    $canSave = false;
                } else {
                    $originalName = $imageFile->getClientFilename();

                    $extension = strtolower(
                        pathinfo($originalName, PATHINFO_EXTENSION)
                    );

                    $allowedExtensions = [
                        'jpg',
                        'jpeg',
                        'png',
                        'webp',
                    ];

                    $fileSize = $imageFile->getSize() ?? 0;

                    if (
                        !in_array($extension, $allowedExtensions, true) ||
                        $fileSize <= 0 ||
                        $fileSize > 5 * 1024 * 1024
                    ) {
                        $this->Flash->error(
                            'Please upload a valid image (JPG, PNG, WEBP) up to 5 MB.'
                        );

                        $canSave = false;
                    } else {
                        $fileName = bin2hex(random_bytes(8)) . '.' . $extension;

                        $uploadDirectory = WWW_ROOT . 'img' . DS . 'products' . DS;

                        if (!is_dir($uploadDirectory)) {
                            mkdir($uploadDirectory, 0755, true);
                        }

                        $imageFile->moveTo(
                            $uploadDirectory . $fileName
                        );

                        // Update image path only when a new image is uploaded.
                        $product->image = 'products/' . $fileName;
                    }
                }
            }

            if ($canSave) {
                if ($productsTable->save($product)) {
                    $this->Flash->success('Product updated successfully.');

                    return $this->redirect([
                        'prefix' => 'Admin',
                        'controller' => 'Products',
                        'action' => 'index',
                    ]);
                }

                $this->Flash->error('Unable to update product.');
            }
        }

        $categories = $this->fetchTable('Categories')
            ->find('list')
            ->where(['is_active' => 1])
            ->toArray();

        $this->set(compact('product', 'categories'));
    }


    /**
     * Delete a product.
     */
    public function delete(string $id)
    {
        $this->request->allowMethod(['post', 'delete']);

        $productsTable = $this->fetchTable('Products');
        $product = $productsTable->get($id);

        if ($productsTable->delete($product)) {
            $this->Flash->success('Product deleted successfully.');
        } else {
            $this->Flash->error('Unable to delete product.');
        }

        return $this->redirect([
            'prefix' => 'Admin',
            'controller' => 'Products',
            'action' => 'index',
        ]);
    }

    /**
     * View product details.
     */
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
