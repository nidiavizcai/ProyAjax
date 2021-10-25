<?php

use App\Http\Controllers\StudentController;
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

Route::get('/', function () {
    return view('welcome');
  });
//Rutas planteadas para el ejercicio del CRUD
Route::get('student', [StudentController::class, 'index']);  //Con metodo get
Route::post('student', [StudentController::class, 'store'])->name('student.store');  //Con metodo post
Route::get('student/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
Route::post('student/update', [StudentController::class, 'update'])->name('student.update');
Route::get('student/{id}/delete', [StudentController::class, 'destroy'])->name('student.delete');
