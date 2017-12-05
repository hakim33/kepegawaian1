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
Route::get('/',"index_controller@index");
Route::post('/login',"index_controller@login");
Route::get('/logout',"index_controller@logout");


Route::get('/admin',"admin_controller@index");
Route::get("/admin/show-project/{no}","admin_controller@detail_project");
Route::get("/admin/delete-berkas/{filename}/{nip}/{sts}","admin_controller@delete_berkas");
Route::get('/admin/show-berkas/{nip}/{sts}',"admin_controller@show_berkas");
Route::get('/admin/show-int-change-pass',"change_password_controller@index");
Route::get('/admin/download-berkas/{file_name}/{nip}',"admin_controller@download_berkas");
Route::get('/admin/next-absen/{date}',"admin_controller@next_absen");
Route::get('/admin/search-employee/{val}/{sts}',"admin_controller@search_employee");
Route::get('/admin/search-username/{val}',"admin_controller@search_username");
Route::get('/admin/search-nip/{val}',"admin_controller@search_nip");
Route::get('/admin/add-new-data',"admin_controller@add_new_data");
Route::get('/admin/tampil-data/{sts}',"admin_controller@show_data");
Route::get('/admin/edit-data/{nip}',"admin_controller@edit_data");
Route::get('/admin/detail-pegawai/{nip}/{sts}',"admin_controller@detail_data");
Route::get('/admin/next-data-employees/{no}/{skip}/{sts}',"admin_controller@next_data_employees");
Route::get('/admin/next-data-employees-with-page/{no}/{skip}/{sts}/{val}',"admin_controller@next_data_employees_with_page");
Route::post('/admin/hapus-data/{nip}/{sts}',"admin_controller@delete_data");
Route::post('/admin/restore-data/{nip}',"admin_controller@restore_data");
Route::post('/admin/make-absence/{date}',"admin_controller@make_absence");
Route::post('/admin/delete-absence/{date}',"admin_controller@delete_absence");
Route::post("/admin/save-data","admin_controller@save_data");
Route::post("/admin/save-new-data","admin_controller@save_new_data");
Route::post("/admin/save-absensi/{nip}/{sts}/{date}","admin_controller@save_absensi");
Route::post("/admin/save-password","change_password_controller@save_new_password");

Route::get("/pegawai","pegawai_controller@index");
Route::get("/pegawai/show-project/{no}","pegawai_controller@show_project");
Route::get("/pegawai/edit-project/{no}","pegawai_controller@edit_project");
Route::get("/pegawai/delete-berkas/{filename}","pegawai_controller@delete_berkas");
Route::get("/pegawai/set-tanggal/{bulan}/{tahun}","pegawai_controller@set_tanggal");
Route::get("/pegawai/tampil-data/{sts}","pegawai_controller@show_data");
Route::get("/pegawai/edit-data","pegawai_controller@edit_data");
Route::post("/pegawai/save-data","pegawai_controller@save_data");
Route::get('/pegawai/download-berkas/{file_name}',"pegawai_controller@download_berkas");
Route::post("/pegawai/update-project/{sts}/{no}","pegawai_controller@update_project");
Route::post("/pegawai/delete-project/{no}","pegawai_controller@delete_project");
Route::post("/pegawai/save-project/{sts}","pegawai_controller@save_project");
Route::post("/pegawai/done-project/{no}","pegawai_controller@done_project");
Route::post("/pegawai/upload-berkas","pegawai_controller@upload_berkas");
