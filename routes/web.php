<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {

    Route::redirect('/', '/home');
    Route::redirect('/index', '/home');

    Route::get('/invoices/archive', 'InvoicesController@show_archive')->name('invoices.show_archive');

    Route::get('/invoices/getProducts/{id}', 'InvoicesController@getProducts')->name('getProducts');

    Route::delete('/invoices/force_delete', 'InvoicesController@force_delete');

    Route::post('/invoices/archive_item', 'InvoicesController@destroy')->name('invoices.archive_invoice');

    Route::post('/invoices/restore_item', 'InvoicesController@restore_invoice')->name('invoices.restore_invoice');

    Route::get('/invoices/custom', 'InvoicesController@show_custom')->name('invoices.custom');

    Route::get('/invoices/print/{id}', 'InvoicesController@print')->name('invoices.print');

    Route::get('/invoices/excel_export', 'InvoicesController@excel_export')->name('invoices.excel_export');

    Route::resource('invoices', 'InvoicesController');

    Route::get('/invoice_details/{id}', 'InvoicesDetailsController@show')->name('invoice_info')->where('id', '^[0-9]+$');

    Route::get('/veiw_attachment/{file}', 'InvoicesAttachmentsController@show')->name('attachment.view');

    Route::get('/download_attachment/{file}', 'InvoicesAttachmentsController@download')->name('attachment.download');

    Route::delete('/delete_attachment', 'InvoicesAttachmentsController@destroy')->name('attachment.delete');

    Route::post('/store_attachment/{id}', 'InvoicesAttachmentsController@store')->name('attachment.store');

    Route::resource('sections', 'SectionsController');

    Route::resource('products', 'ProductsController');

    Route::resource('/roles', 'RoleController');

    Route::resource('/users', 'UserController');

    Route::group(['prefix' => 'reports'], function () {
        Route::get('/invoices', 'InvoicesReportsController@index')->name('reports.invoices.index');
        Route::post('/invoices/show', 'InvoicesReportsController@show')->name('reports.invoices.show');

        Route::get('/customers', 'CustomersReportsController@index')->name('reports.customers.index');
        Route::post('/customers/show', 'CustomersReportsController@show')->name('reports.customers.show');
    });

    Route::get('/home', 'HomeController@index');

    // Route::get('/{page}', 'AdminController@index');
});
