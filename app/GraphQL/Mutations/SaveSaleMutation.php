<?php
namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use App\GraphQL\MutationAbstract;

class SaveSaleMutation extends MutationAbstract
{
    public function name()
    {
        return 'saveSale';
    }

    public function description()
    {
        return "The list of sales";
    }

    public function args()
    {
        return [
            'cpf' => ['type' => Type::string()],
            'cnpj' => ['type' => Type::string()],
            'code' => ['type' => Type::string()],
            'date' => ['type' => Type::string()],
        ];
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
            $salesData      = json_decode($salesContents, true);
            $args['id']     = uniqid();
            $args['status'] = "Em análise";
            $salesData[]    = $args;
            $salesContents  = json_encode($salesData);
            file_put_contents($storageFileName, $salesContents);
            return [
                'id'   => isset($args['id']) ? $args['id'] : null,
                'status' => isset($args['status']) ? $args['status'] : null,
                'code'   => isset($args['code']) ? $args['code'] : null,
                'date'   => isset($args['date']) ? $args['date'] : null,
                'cpf'    => isset($args['cpf']) ? $args['cpf'] : null,
                'cnpj'   => isset($args['cnpj']) ? $args['cnpj'] : null,
            ];
        };
    }
}
