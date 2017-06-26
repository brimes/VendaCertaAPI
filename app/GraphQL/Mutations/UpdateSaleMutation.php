<?php
namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use App\GraphQL\MutationAbstract;

class UpdateSaleMutation extends MutationAbstract
{
    public function name()
    {
        return 'updateSale';
    }

    public function description()
    {
        return "Create a new sale";
    }

    public function args()
    {
        return [
            'id' => ['type' => Type::string()],
            'status' => ['type' => Type::string()],
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
            if (empty($args['id'])) {
                return [];
            }
            foreach ($salesData as $saleKey => $sale) {
                if (empty($sale['id'])) {
                    continue;
                }
                if ($args['id'] == $sale['id']) {
                    $newElement = $args;
                    foreach ($sale as $key => $value) {
                        $newElement[$key] = (!empty($args[$key])) ? $args[$key] : $value;
                    }
                    $salesData[$saleKey] = $newElement;
                    break;
                }
            }
            $salesContents  = json_encode($salesData);
            file_put_contents($storageFileName, $salesContents);
            return [
                'id'   => isset($newElement['id']) ? $newElement['id'] : null,
                'status' => isset($newElement['status']) ? $newElement['status'] : null,
                'code'   => isset($newElement['code']) ? $newElement['code'] : null,
                'date'   => isset($newElement['date']) ? $newElement['date'] : null,
                'cpf'    => isset($newElement['cpf']) ? $newElement['cpf'] : null,
                'cnpj'   => isset($newElement['cnpj']) ? $newElement['cnpj'] : null,
            ];
        };
    }
}
