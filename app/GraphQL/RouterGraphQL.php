<?php
namespace App\GraphQL;

use Illuminate\Http\Request;
use GraphQL\Schema;
use GraphQL\GraphQL;

class RouterGraphQL
{
    /**
     * The GraphQL schema
     * @var \GraphQL\Schema
     */
    private $schema;

    /**
     * Query string
     * @var [type]
     */
    private $query;

    public function __construct(array $data)
    {
        $this->query = $data['query'];
    }

    /**
     * Query Result
     * @return JSon
     */
    public function result()
    {
        $this->createSchema();
        return GraphQL::execute(
            $this->schema,
            $this->query
        );
    }

    protected function createSchema()
    {
        $this->schema = new Schema([
               'query' => SchemaBuilder::query(),
               'mutation' => SchemaBuilder::mutation(),
           ]);

    }
}
