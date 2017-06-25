<?php

use Illuminate\Http\Request;
use App\GraphQL\RouterGraphQL;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/query', function (Request $request) {
    return (new RouterGraphQL($request))->result();
});

Route::post('/query', function (Request $request) {

    if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
        $raw = file_get_contents('php://input') ?: '';
        $data = json_decode($raw, true);
    } else if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/graphql') !== false) {
		$raw = file_get_contents('php://input') ?: '';
		$data = [
			'query' => $raw
		];
    } else {
        $data = $_REQUEST;
    }
    $data += ['query' => null, 'variables' => null];
    if (null === $data['query']) {
        $data['query'] = '{hello}';
    }
    return (new RouterGraphQL($data))->result();
});
