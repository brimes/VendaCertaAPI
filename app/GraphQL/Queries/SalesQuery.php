<?php
namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use App\GraphQL\QueryAbstract;

class SalesQuery extends QueryAbstract
{
    public function name()
    {
        return 'sales';
    }

    public function description()
    {
        return "The list of sales";
    }

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'The status of sale',
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'The status of sale',
            ],
            'code' => [
                'type' => Type::string(),
                'description' => 'The authorization code',
            ],
            'date' => [
                'type' => Type::string(),
                'description' => 'The authorization name.'
            ],
            'cpf' => [
                'type' => Type::string(),
                'description' => 'The user CPF code',
            ],
            'cnpj' => [
                'type' => Type::string(),
                'description' => 'The CNPJ code',
            ],
        ];
    }

    protected function resolve()
    {
        return function ($root, $args) {
            $storageFileName = __DIR__ . "/../../../storage/sales.json";
            
            if (file_exists($storageFileName)) {
                $salesContents = file_get_contents($storageFileName);
            } else {
                $salesContents = json_encode([]);
                file_put_contents($storageFileName, $salesContents);
            }

            $salesData = json_decode($salesContents, true);
            return $salesData;
        };
    }
}
