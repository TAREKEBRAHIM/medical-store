<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;

class PagesController extends AppController
{
   public function display(string ...$path): ?Response
{
    if (!$path) {
        return $this->redirect('/');
    }

    if (in_array('..', $path, true) || in_array('.', $path, true)) {
        throw new ForbiddenException();
    }

    $page = $subpage = null;

    if (!empty($path[0])) {
        $page = $path[0];
    }

    if (!empty($path[1])) {
        $subpage = $path[1];
    }

    if ($page === 'home') {

        // Get active categories
        $categories = $this->fetchTable('Categories')
            ->find()
            ->where(['is_active' => 1])
            ->all();

        // Get active featured products with their categories
        $products = $this->fetchTable('Products')
            ->find()
            ->contain(['Categories'])
            ->where([
                'Products.is_active' => 1,
                'Products.is_featured' => 1,
            ])
            ->limit(4)
            ->all();

        $this->set(compact('categories', 'products'));
    }

    $this->set(compact('page', 'subpage'));

    try {
        return $this->render(implode('/', $path));
    } catch (MissingTemplateException $exception) {
        if (Configure::read('debug')) {
            throw $exception;
        }

        throw new NotFoundException();
    }
}

}
