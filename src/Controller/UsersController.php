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

        // Allow guests to access login and registration.
        $this->Authentication->addUnauthenticatedActions([
            'login',
            'register'
        ]);
    }

    public function register()
    {
        $this->request->allowMethod(['get', 'post']);

        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Check password confirmation.
            if (($data['password'] ?? '') !== ($data['confirm_password'] ?? '')) {
                $this->Flash->error('Passwords do not match.');
                $this->set(compact('user'));
                return;
            }

            // Check if the email already exists.
            $existingUser = $usersTable->find()
                ->where(['email' => $data['email'] ?? ''])
                ->first();

            if ($existingUser) {
                $this->Flash->error('This email is already registered.');
                $this->set(compact('user'));
                return;
            }

            
            $user = $usersTable->newEntity([
                'name' => $data['name'] ?? '',
                'email' => $data['email'] ?? '',
                'password' => $data['password'] ?? '',
                'role' => 'customer'
            ]);

            if (!$user->getErrors()) {

                // Hash the password before saving.

                if ($usersTable->save($user)) {
                    $this->Flash->success('Your account has been created successfully.');

                    return $this->redirect([
                        'controller' => 'Users',
                        'action' => 'login'
                    ]);
                }
            }

            $this->Flash->error('Unable to create your account. Please check your information.');
        }

        $this->set(compact('user'));
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {

            $user = $this->Authentication->getIdentity();
            $role = $user->get('role');

            // Redirect administrators to the admin products dashboard.
            if ($role === 'admin') {
                return $this->redirect([
                    'prefix' => 'Admin',
                    'controller' => 'Products',
                    'action' => 'index'
                ]);
            }

            // Redirect customers to the storefront homepage.
            if ($role === 'customer') {
                return $this->redirect('/');
            }

            // Reject accounts with an invalid role.
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
