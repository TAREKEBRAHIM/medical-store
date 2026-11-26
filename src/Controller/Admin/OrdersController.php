<?php

declare(strict_types=1);

namespace App\Controller\Admin;

class OrdersController extends AppController
{
    public function index()
    {
        $ordersTable = $this->fetchTable('Orders');

        $orders = $ordersTable->find()
            ->contain(['Users'])
            ->orderBy(['Orders.created' => 'DESC'])
            ->all();

        $this->set(compact('orders'));
    }

    public function view($id = null)
    {
        $ordersTable = $this->fetchTable('Orders');

        $order = $ordersTable->find()
            ->where(['Orders.id' => $id])
            ->contain([
                'Users',
                'OrderItems' => ['Products']
            ])
            ->firstOrFail();

        $this->set(compact('order'));
    }

    public function updateStatus($id = null)
    {
        $this->request->allowMethod(['post']);

        $ordersTable = $this->fetchTable('Orders');
        $order = $ordersTable->get($id);

        $allowedStatuses = [
            'pending',
            'processing',
            'shipped',
            'delivered',
            'cancelled'
        ];

        $newStatus = $this->request->getData('status');

        if (in_array($newStatus, $allowedStatuses, true)) {
            $order->status = $newStatus;

            if ($ordersTable->save($order)) {
                $this->Flash->success('Order status updated successfully.');
            } else {
                $this->Flash->error('Unable to update order status.');
            }
        } else {
            $this->Flash->error('Invalid order status.');
        }

        return $this->redirect([
            'action' => 'view',
            $id
        ]);
    }
}
