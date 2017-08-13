<?php
namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use App\GraphQL\QueryAbstract;

class VendaQuery extends QueryAbstract
{
    public function name()
    {
        return 'venda';
    }

    public function description()
    {
        return "The information of sale";
    }

    public function fields()
    {
        return [
            'status' => [
                'type' => Type::string(),
                'description' => 'The status of sale',
            ],
            'NumeroAutorizacao' => [
                'type' => Type::string(),
                'description' => 'The authorization code',
            ],
            'DataAutorizacao' => [
                'type' => Type::string(),
                'description' => 'The authorization name.'
            ],
            'CPFBalconista' => [
                'type' => Type::string(),
                'description' => 'The user CPF code',
            ],
            'CNPJLoja' => [
                'type' => Type::string(),
                'description' => 'The CNPJ code',
            ],
        ];
    }

    public function args()
    {
        return [
            'id' => ['type' => Type::string()],
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

            if (empty($args['id'])) {
                return json_decode($salesContents, true);
            }

            foreach (json_decode($salesContents, true) as $key => $value) {
                if (empty($value['id'])) {
                    continue;
                }

                if ($value['id'] == $args['id']) {
                    return [$value];
                }
            }
        };
    }
}
