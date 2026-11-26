<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrdersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('orders');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);

        $this->hasMany('OrderItems', [
            'foreignKey' => 'order_id',
            'dependent' => true,
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->requirePresence('customer_name', 'create')
            ->notEmptyString('customer_name');

        $validator
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone');

        $validator
            ->requirePresence('address', 'create')
            ->notEmptyString('address');

        $validator
            ->requirePresence('city', 'create')
            ->notEmptyString('city');

        return $validator;
    }
}
