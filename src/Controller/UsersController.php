<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        // Allow guests to access login
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {

            $user = $this->Authentication->getIdentity();
            $role = $user->get('role');

            if ($role === 'admin') {
                return $this->redirect([
                    'controller' => 'Products',
                    'action' => 'index'
                ]);
            }

            if ($role === 'customer') {
                return $this->redirect('/');
            }

            $this->Authentication->logout();

            $this->Flash->error('Your account has an invalid role.');

            return $this->redirect([
                'controller' => 'Users',
                'action' => 'login'
            ]);
        }

        if ($this->request->is('post')) {
            $this->Flash->error(__('Invalid email or password.'));
        }
    }

    public function logout(): Response
    {
        $this->request->allowMethod(['post']);
        $this->Authentication->logout();

        $this->Flash->success('You have been logged out successfully.');

        return $this->redirect([
            'controller' => 'Users',
            'action' => 'login'
        ]);
    }
}
