<?php
namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use App\GraphQL\MutationAbstract;

class VendaMutation extends MutationAbstract
{
    public function name()
    {
        return 'venda';
    }

    public function description()
    {
        return "Cria uma nova venda no banco de dados";
    }

    public function args()
    {
        return [
            'CPFBalconista' => ['type' => Type::string()],
            'CNPJLoja' => ['type' => Type::string()],
            'NumeroAutorizacao' => ['type' => Type::int()],
            'DataAutorizacao' => ['type' => Type::string()],
        ];
    }

    public function getType($prefix = '')
    {
        return Type::int();
    }

    public function fields()
    {
        return [];
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
            $salesData      = json_decode($salesContents, true);
            $args['id']     = uniqid();
            $args['status'] = "Em análise";
            $salesData[]    = $args;
            $salesContents  = json_encode($salesData);
            file_put_contents($storageFileName, $salesContents);
            return count($salesContents) + 1;
        };
    }
}
