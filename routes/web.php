<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', function () {
    return view('Home.home');
})->name('/');

Route::get('/home', 'InventoryController@stats')->name('home')->middleware('auth');



Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => 'admin_routes'], function () {
        //Rutas de usuario
        Route::get('/users', 'UserController@index')->name('users');
        Route::match(['put', 'patch'], 'edit_user_modal', ['as' => 'edit.user.modal', 'uses' => 'UserController@edit_user']);
        Route::match(['put', 'patch'], 'update_user', ['as' => 'update.user', 'uses' => 'UserController@update']);
        Route::match(['put', 'patch'], 'status_user', ['as' => 'status.user', 'uses' => 'UserController@status_user']);
        Route::match(['put', 'patch'], 'add_user', ['as' => 'add.user', 'uses' => 'UserController@store']);
        
        //Rutas de categorias 
        Route::get('/categories', 'ProductCategoryController@index')->name('categories');
        Route::match(['put', 'patch'], 'edit_category_modal', ['as' => 'edit.category.modal', 'uses' => 'ProductCategoryController@edit_category']);
        Route::match(['put', 'patch'], 'update_category', ['as' => 'update.category', 'uses' => 'ProductCategoryController@update']);
        Route::match(['put', 'patch'], 'status_category', ['as' => 'status.category', 'uses' => 'ProductCategoryController@status_category']);
        Route::match(['put', 'patch'], 'delete_category', ['as' => 'delete.category', 'uses' => 'ProductCategoryController@delete_category']);
        Route::match(['put', 'patch'], 'add_category', ['as' => 'add.category', 'uses' => 'ProductCategoryController@store']);
        
        //Rutas de productos
        Route::get('/products', 'ProductController@index')->name('products');
        Route::post('/exist', 'ProductController@exist')->name('exist');
        Route::match(['put', 'patch'], 'edit_product_modal', ['as' => 'edit.product.modal', 'uses' => 'ProductController@edit_product']);
        Route::match(['put', 'patch','post'], 'update_product', ['as' => 'update.product', 'uses' => 'ProductController@update']);
        Route::match(['put', 'patch'], 'status_product', ['as' => 'status.product', 'uses' => 'ProductController@status_product']);
        Route::match(['put', 'patch', 'post'], 'add_product', ['as' => 'add.product', 'uses' => 'ProductController@store']);
        Route::match(['put', 'patch', 'post'], 'add_product_stock', ['as' => 'add.product.stock', 'uses' => 'ProductController@store_stock']);
        
        //Rutas de productos de bodega
        Route::get('/products_ware', 'ProductWarehouseController@index')->name('products_ware');
        Route::post('/exist_ware', 'ProductWarehouseController@exist')->name('exist_ware');
        Route::match(['put', 'patch'], 'edit_product_ware_modal', ['as' => 'edit.product_ware.modal', 'uses' => 'ProductWarehouseController@edit_product']);
        Route::match(['put', 'patch','post'], 'update_product_ware', ['as' => 'update.product_ware', 'uses' => 'ProductWarehouseController@update']);
        Route::match(['put', 'patch'], 'status_product_ware', ['as' => 'status.product_ware', 'uses' => 'ProductWarehouseController@status_product']);
        Route::match(['put', 'patch', 'post'], 'add_product_ware', ['as' => 'add.product_ware', 'uses' => 'ProductWarehouseController@store']);
        Route::match(['put', 'patch', 'post'], 'add_product_ware_stock', ['as' => 'add.product_ware.stock', 'uses' => 'ProductWarehouseController@store_stock']);

        //Reportes
        
        Route::get('/reports', 'ReportController@index')->name('reports');
        Route::post('/get_sales_month', 'ReportController@get_sales_month')->name('get_sales_month');
        Route::post('/sales_users', 'ReportController@sales_users')->name('sales_users');
        Route::post('/year_search', 'ReportController@year_search')->name('year_search');
        Route::post('/get_search', 'ReportController@get_search')->name('get_search');
        Route::post('/quincena_search', 'ReportController@quincena_search')->name('quincena_search');
        
        
    });

    //Reportes
    Route::post('/more_product', 'ReportController@more_product')->name('more_product');

    //Rutas de ventas
    Route::get('/ventas', 'SaleController@index')->name('ventas');
    Route::post('/add_p', 'SaleController@store_product')->name('add_p');
    Route::post('/less_more', 'SaleController@less_more')->name('less_more');
    Route::post('/more', 'SaleController@more')->name('more');
    Route::post('/delete_p_sale', 'SaleController@destroyproduct')->name('delete_p_sale');
    Route::post('/get_edit_product', 'SaleController@get_edit_product')->name('get_edit_product');
    Route::post('/get_edit_product', 'SaleController@get_edit_product')->name('get_edit_product');
    Route::post('/updateproduct', 'SaleController@updateproduct')->name('updateproduct');
    Route::post('/create/sale', 'SaleController@create')->name('create_sale');
    Route::post('/finalize', 'SaleController@finalize')->name('finalize');
    Route::get('sales/{sale}', ['as' => 'sales.show', 'uses' => 'SaleController@show']);
    Route::post('/prods', 'SaleController@get_p')->name('prods');
    Route::post('/add_scann', 'SaleController@scann')->name('add_scann');
    


    //Otras
    Route::resources([
        'providers' => 'ProviderController',
        'inventory/products' => 'ProductController',
        'clients' => 'ClientController',
        'inventory/categories' => 'ProductCategoryController',
        'transactions/transfer' => 'TransferController',
        'methods' => 'MethodController',
    ]);
    
    Route::resource('transactions', 'TransactionController')->except(['create', 'show']);
    Route::get('transactions/stats/{year?}/{month?}/{day?}', ['as' => 'transactions.stats', 'uses' => 'TransactionController@stats']);
    Route::get('transactions/{type}', ['as' => 'transactions.type', 'uses' => 'TransactionController@type']);
    Route::get('transactions/{type}/create', ['as' => 'transactions.create', 'uses' => 'TransactionController@create']);
    Route::get('transactions/{transaction}/edit', ['as' => 'transactions.edit', 'uses' => 'TransactionController@edit']);

    Route::get('inventory/stats/{year?}/{month?}/{day?}', ['as' => 'inventory.stats', 'uses' => 'InventoryController@stats']);
    Route::resource('inventory/receipts', 'ReceiptController')->except(['edit', 'update']);
    Route::get('inventory/receipts/{receipt}/finalize', ['as' => 'receipts.finalize', 'uses' => 'ReceiptController@finalize']);
    Route::get('inventory/receipts/{receipt}/product/add', ['as' => 'receipts.product.add', 'uses' => 'ReceiptController@addproduct']);
    Route::get('inventory/receipts/{receipt}/product/{receivedproduct}/edit', ['as' => 'receipts.product.edit', 'uses' => 'ReceiptController@editproduct']);
    Route::post('inventory/receipts/{receipt}/product', ['as' => 'receipts.product.store', 'uses' => 'ReceiptController@storeproduct']);
    Route::match(['put', 'patch'], 'inventory/receipts/{receipt}/product/{receivedproduct}', ['as' => 'receipts.product.update', 'uses' => 'ReceiptController@updateproduct']);
    Route::delete('inventory/receipts/{receipt}/product/{receivedproduct}', ['as' => 'receipts.product.destroy', 'uses' => 'ReceiptController@destroyproduct']);

    //Route::resource('sales', 'SaleController')->except(['edit', 'update']);
    Route::get('sales/{sale}/finalize', ['as' => 'sales.finalize', 'uses' => 'SaleController@finalize']);
    //Route::get('sales/{sale}/product/add', ['as' => 'sales.product.add', 'uses' => 'SaleController@addproduct']);
    //Route::get('sales/{sale}/product/{soldproduct}/edit', ['as' => 'sales.product.edit', 'uses' => 'SaleController@editproduct']);
    //Route::post('sales/{sale}/product', ['as' => 'sales.product.store', 'uses' => 'SaleController@storeproduct']);
    Route::match(['put', 'patch'], 'sales/{sale}/product/{soldproduct}', ['as' => 'sales.product.update', 'uses' => 'SaleController@updateproduct']);
    Route::delete('sales/{sale}/product/{soldproduct}', ['as' => 'sales.product.destroy', 'uses' => 'SaleController@destroyproduct']);

    Route::get('clients/{client}/transactions/add', ['as' => 'clients.transactions.add', 'uses' => 'ClientController@addtransaction']);

    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::match(['put', 'patch'], 'profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::match(['put', 'patch'], 'profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('icons', ['as' => 'pages.icons', 'uses' => 'PageController@icons']);
    Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'PageController@notifications']);
    Route::get('tables', ['as' => 'pages.tables', 'uses' => 'PageController@tables']);
    Route::get('typography', ['as' => 'pages.typography', 'uses' => 'PageController@typography']);
});
