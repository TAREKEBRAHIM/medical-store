<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProductsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setPrimaryKey('id');
        $this->setDisplayField('name');

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
        ]);
    }

   public function validationDefault(Validator $validator): Validator
{
    // Product name is required
    $validator
        ->scalar('name')
        ->maxLength('name', 200)
        ->requirePresence('name', 'create')
        ->notEmptyString('name', 'Product name is required.');

    // Product slug is required
    $validator
        ->scalar('slug')
        ->maxLength('slug', 220)
        ->requirePresence('slug', 'create')
        ->notEmptyString('slug', 'Product slug is required.');

    // Price must be a valid decimal and cannot be negative
    $validator
        ->decimal('price')
        ->requirePresence('price', 'create')
        ->notEmptyString('price', 'Price is required.')
        ->greaterThanOrEqual('price', 0, 'Price cannot be negative.');

    // Stock must be an integer and cannot be negative
    $validator
        ->integer('stock')
        ->greaterThanOrEqual('stock', 0, 'Stock cannot be negative.');

    return $validator;
}
}