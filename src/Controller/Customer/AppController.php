<?php
declare(strict_types=1);

namespace App\Controller\Customer;

use App\Controller\AppController as BaseAppController;
use Authentication\Authenticator\UnauthenticatedException;
use Cake\Event\EventInterface;

class AppController extends BaseAppController
{
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        $this->viewBuilder()->setLayout('customer');

        $publicActions = $this->getPublicActions();
        $this->Authentication->addUnauthenticatedActions($publicActions);

        $action = (string)$this->request->getParam('action');
        $identity = $this->Authentication->getIdentity();

        if (
            $identity &&
            !in_array($action, $publicActions, true) &&
            $identity->get('role') !== 'customer'
        ) {
            throw new UnauthenticatedException('Customer access is required.');
        }
    }

    protected function getPublicActions(): array
    {
        return [];
    }
}
