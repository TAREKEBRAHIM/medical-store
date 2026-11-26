<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController as BaseAppController;
use Authentication\Authenticator\UnauthenticatedException;
use Cake\Event\EventInterface;

class AppController extends BaseAppController
{
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        $this->viewBuilder()->setLayout('admin');

        $identity = $this->Authentication->getIdentity();
        if ($identity && $identity->get('role') !== 'admin') {
            throw new UnauthenticatedException('Administrator access is required.');
        }
    }
}
