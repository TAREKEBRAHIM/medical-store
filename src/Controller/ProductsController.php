<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\ForbiddenException;

class ProductsController extends AppController
{
    public function index(): void
    {
        // Get active products and their categories
        $query = $this->fetchTable('Products')
            ->find()
            ->contain(['Categories'])
            ->where([
                'Products.is_active' => 1,
            ]);

        // Get category filter from URL
        $categoryId = $this->request->getQuery('category_id');

        if ($categoryId !== null && ctype_digit((string)$categoryId)) {
            $query->where([
                'Products.category_id' => (int)$categoryId,
            ]);
        }

        // Get products with pagination
        $products = $this->paginate($query, [
            'limit' => 12,
            'order' => [
                'Products.created' => 'DESC',
            ],
        ]);

        // Get active categories for the filter
        $categories = $this->fetchTable('Categories')
            ->find()
            ->where([
                'Categories.is_active' => 1,
            ])
            ->all();

        $this->set(compact('products', 'categories'));
    }

    public function add()
    {
        $productsTable = $this->fetchTable('Products');

        $product = $productsTable->newEmptyEntity();

        if ($this->request->is('post')) {

            // Get form data
            $data = $this->request->getData();

            // Get uploaded image
            $imageFile = $this->request->getUploadedFile('image');

            // Remove image from normal form data
            unset($data['image']);

            // Fill product entity
            $product = $productsTable->patchEntity($product, $data);

            $canSave = true;

            // Check if an image was uploaded
            if (
                $imageFile !== null &&
                $imageFile->getError() !== UPLOAD_ERR_NO_FILE
            ) {

                if ($imageFile->getError() !== UPLOAD_ERR_OK) {

                    $this->Flash->error('Image upload failed.');
                    $canSave = false;
                } else {

                    // Get original file extension
                    $originalName = $imageFile->getClientFilename();
                    $extension = strtolower(
                        pathinfo($originalName, PATHINFO_EXTENSION)
                    );

                    // Allowed image extensions
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

                    // Check file size (5 MB maximum)
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

                        // Generate a unique file name
                        $fileName = bin2hex(random_bytes(8)) . '.' . $extension;

                        // Set upload directory
                        $uploadDirectory = WWW_ROOT . 'img' . DS . 'products' . DS;

                        // Create directory if it does not exist
                        if (!is_dir($uploadDirectory)) {
                            mkdir($uploadDirectory, 0755, true);
                        }

                        // Move uploaded image to products folder
                        $imageFile->moveTo($uploadDirectory . $fileName);

                        // Save image path in database
                        $product->image = 'products/' . $fileName;
                    }
                }
            }

            // Save product
            if ($canSave) {

                if ($productsTable->save($product)) {

                    $this->Flash->success('Product added successfully.');

                    return $this->redirect(['action' => 'index']);
                }

                $this->Flash->error('Unable to add product.');
            }
        }

        // Get active categories
        $categories = $this->fetchTable('Categories')
            ->find('list')
            ->where(['is_active' => 1])
            ->toArray();

        $this->set(compact('product', 'categories'));
    }

    public function edit(string $id)
    {
        // Get the Products table
        $productsTable = $this->fetchTable('Products');

        // Find the product by its ID
        $product = $productsTable->get($id);

        // Check if the form was submitted
        if ($this->request->is(['patch', 'post', 'put'])) {

            // Update product data
            $product = $productsTable->patchEntity(
                $product,
                $this->request->getData()
            );

            // Save updated product
            if ($productsTable->save($product)) {

                $this->Flash->success('Product updated successfully.');

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error('Unable to update product.');
        }

        // Get categories for the dropdown
        $categories = $this->fetchTable('Categories')
            ->find('list')
            ->where(['is_active' => 1])
            ->toArray();

        $this->set(compact('product', 'categories'));
    }

    public function delete(string $id)
    {
        // Allow only POST and DELETE requests
        $this->request->allowMethod(['post', 'delete']);

        // Get the Products table
        $productsTable = $this->fetchTable('Products');

        // Find the product by ID
        $product = $productsTable->get($id);

        // Delete the product
        if ($productsTable->delete($product)) {

            $this->Flash->success('Product deleted successfully.');
        } else {

            $this->Flash->error('Unable to delete product.');
        }

        // Redirect to products list
        return $this->redirect(['action' => 'index']);
    }

    public function view(): \Cake\Http\Response
    {
        return $this->redirect(['action' => 'index']);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // Allow guests to browse products
        $this->Authentication->addUnauthenticatedActions([
            'index',
            'view'
        ]);

        // Get logged-in user
        $user = $this->Authentication->getIdentity();

        // Get current action
        $action = $this->request->getParam('action');

        // Only admin can add, edit, or delete products
        $adminOnlyActions = ['add', 'edit', 'delete'];

        if (in_array($action, $adminOnlyActions, true)) {

            if (!$user || $user->get('role') !== 'admin') {

                throw new ForbiddenException(
                    'You are not authorized to perform this action.'
                );
            }
        }
    }
}
