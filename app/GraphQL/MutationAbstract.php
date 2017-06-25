<?php
namespace App\GraphQL;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

abstract class MutationAbstract
{
    /**
     * Query name
     * @return String
     */
    abstract public function name();

    /**
     * Query description
     * @return String Query description
     */
    abstract public function description();

    /**
     * Attributes of query
     * @return Array
     */
    public function attributes()
    {
        return [
            'type' => $this->getType(),
            'description' => $this->description(),
            'args' => $this->args(),
            'resolve' => $this->resolve()
        ];
    }

    /**
     * The Query interface
     * @return Array [description]
     */
    public function getType($prefix = '')
    {
        $name = $this->name();
        if (!empty($prefix)) {
            $name = $prefix . '_' . $name;
        }
        return new ObjectType([
            'name' => $name,
            'description' => $this->description(),
            'fields' => $this->fields(),
            'resolveField' => function ($value, $args, $context, $info) {
                return  $this->resolveField($value, $args, $context, $info);
            },
         ]);
    }

    protected function resolveField($value, $args, $context, $info)
    {
        return $value[$info->fieldName];
    }
}
