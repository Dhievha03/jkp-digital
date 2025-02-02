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


Auth::routes([
    'register' => false
]);

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('home');
        }
    }

    return redirect()->route('login');
});

Route::get('/home', 'HomeController@index')->name('home');


// Admin
Route::prefix('admin')->name('admin.')->middleware('auth', 'role:admin')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::view('rayon', 'admin.rayon.index')->name('rayon');
    Route::view('major', 'admin.major.index')->name('major');
    Route::view('rombel', 'admin.rombel.index')->name('rombel');
    Route::view('student', 'admin.student.index')->name('student');

    Route::resource('pembimbing', 'Admin\PembimbingController');
    Route::get('cek-nip', 'Admin\PembimbingController@cekNip')->name('pembimbing.cek-nip');
    Route::post('pembimbing/datatables', 'Admin\PembimbingController@datatables')->name('pembimbing.datatables');
    Route::post('pembimbing/import', 'Admin\PembimbingController@import')->name('pembimbing.import');

    Route::resource('student', 'Admin\StudentController');
    Route::get('cek-nis', 'Admin\StudentController@cekNis')->name('student.cek-nis');
    Route::post('student/datatables', 'Admin\StudentController@datatables')->name('student.datatables');
    Route::post('student/import', 'Admin\StudentController@import')->name('student.import');

    Route::view('assignment', 'admin.assignment.index')->name('assignment');
});
