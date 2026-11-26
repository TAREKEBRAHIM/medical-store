<?php

declare(strict_types=1);

namespace App\Controller\Customer;

class OrdersController extends AppController
{
    public function index()
    {
        // Get logged-in customer
        $identity = $this->Authentication->getIdentity();

        if (!$identity) {
            return $this->redirect('/login');
        }

        $userId = $identity->getIdentifier();

        // Get only orders belonging to this customer
        $orders = $this->fetchTable('Orders')
            ->find()
            ->where(['Orders.user_id' => $userId])
            ->orderBy(['Orders.created' => 'DESC'])
            ->all();

        $this->set(compact('orders'));
    }

    public function view($id = null)
    {
        // Get logged-in customer
        $identity = $this->Authentication->getIdentity();

        if (!$identity) {
            return $this->redirect('/login');
        }

        $userId = $identity->getIdentifier();

        // Get order only if it belongs to this customer
        $order = $this->fetchTable('Orders')
            ->find()
            ->where([
                'Orders.id' => $id,
                'Orders.user_id' => $userId
            ])
            ->contain([
                'OrderItems' => ['Products']
            ])
            ->firstOrFail();

        $this->set(compact('order'));
    }
}
