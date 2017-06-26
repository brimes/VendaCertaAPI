<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $list = [];
    $storageFileName = __DIR__ . "/../storage/sales.json";

    if (file_exists($storageFileName)) {
        $list = json_decode(file_get_contents($storageFileName), true);
    }

    return view('welcome', [
        'sales' => array_reverse($list), 
        'statusIcon' => [
            'Em análise' => 'help_outline',
            'Válida' => 'done',
            'Inválida' => 'block',
            'Confirmado' => 'done'
        ]
    ]);
});
