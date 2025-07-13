<?php

use App\Http\Controllers\ErrorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get("/", [UploadController::class, "index"]);
Route::post("/import", [UploadController::class, "import"]);
Route::get("/employees", [EmployeeController::class, "index"]);
Route::post("/employees", [EmployeeController::class, "filter"]);
Route::get("/employees/{name}", [EmployeeController::class, "summary"]);
Route::post("/shifts", [ShiftController::class, "index"]);
Route::get("/shifts/create", [ShiftController::class, "indexCreate"]);
Route::post("/shifts/create/new", [ShiftController::class, "createShift"]);
Route::get("/shifts/edit/{id}", [ShiftController::class, "indexEdit"]);
Route::post("/shifts/edit/{id}/update", [ShiftController::class, "editShift"]);
Route::get("/shifts/delete/{id}", [ShiftController::class, "indexDelete"]);
Route::post("/shifts/delete/{id}/confirmed", [ShiftController::class, "deleteShift"]);
Route::get("/400", [ErrorController::class, "index400"]);

