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

Route::get('/', 'WelcomeController@welcome');

/* Contacto */
Route::get('contact-us', 'ContactUsController@contactUs');
Route::post('contact-us',[
'as'=>'contactus.store',
'uses'=>'ContactUsController@contactUsPost'
]);


Route::get('/faq', function () {
  return view('faq');
});

Route::get('/property/{id}', 'UserProfile@showProperty');
Route::get('/semana_propiedad/{id}', 'UserProfile@showSemanaPropiedad');
Route::get('/semana_propiedad_unica/{id}', 'UserProfile@showSemanaPropiedadUnica');

Route::get('/subasta/{id}', 'SubastaController@show');

Route::get('/properties', 'PropertiesController@welcome');
Route::get('/properties_disponibles', 'PropertiesController@propertiesDisponibles');

Route::get('/residencias', 'ResidenciasController@show');

Route::get('/profile', function () {
  return view('profile');
});

Route::get('/search', function () {
  return view('search');
});

Auth::routes();

// Profile
Route::get('/profile/{id}', 'UserProfile@show')->name('usuario');

Route::resource('/change_password','UserProfile@changePassword');
Route::post('/change_password','UserProfile@changePassword');
Route::resource('/update_profile','UserProfile@changeProfile');
Route::post('/update_profile','UserProfile@changeProfile');
Route::resource('/change_creditcard','UserProfile');
Route::post('/change_creditcard','UserProfile@changeCreditCard');

Route::get('/show_reset_password', function () {
  return view('reset_password');
});

Route::resource('/reset_password','ResetPasswordController');
Route::post('/reset_password','ResetPasswordController@resetPassword');

Route::get('/home', 'HomeController@index');
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

Route::prefix('admin')->group(function() {
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
  Route::get('/', 'AdminController@index')->name('admin.dashboard');
  Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

  // Password reset routes
  Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
  Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
  Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});


//Premium uploads
Route::resource('premium_updown', 'SuscripcionController');
Route::post('premium_updown', 'SuscripcionController@store');

Route::resource('/change_status','SuscripcionController');
Route::post('/change_status','SuscripcionController@changeStatus');


//Propiedades
Route::resource('upload_property', 'PropertyController');
Route::post('upload_property', 'PropertyController@store');

Route::resource('generar_semana', 'PropertyController');
Route::post('generar_semana', 'PropertyController@generarSemana');

//Hotsales
Route::resource('open_hotsale', 'PropertyController');
Route::post('open_hotsale', 'PropertyController@openHotsale');

Route::resource('close_hotsale', 'PropertyController');
Route::post('close_hotsale', 'PropertyController@closeHotsale');

//Subastas
Route::resource('open_subasta', 'SubastaController');
Route::post('open_subasta', 'SubastaController@openSubasta');
Route::resource('close_subasta', 'SubastaController');
Route::post('close_subasta', 'SubastaController@closeSubasta');

Route::post('push_bid', 'SubastaController@push_bid');
Route::post('logic_drop_subasta', 'SubastaController@logic_drop');
Route::post('delete_subasta', 'SubastaController@delete');

//Cobrar suscripcion
Route::resource('cobrar_suscripcion', 'AdminController');
Route::post('cobrar_suscripcion', 'AdminController@cobrarSuscripcion');

//Cambiar valores
Route::resource('change_valores_suscripcion', 'AdminController');
Route::post('change_valores_suscripcion', 'AdminController@changeValoresSuscripcion');

Route::get('/modify_property/{id}', 'AdminController@showmodify');
Route::resource('modify_property_send', 'AdminController');
Route::post('modify_property_send', 'AdminController@modifySend');

//Añadir a favoritos
Route::resource('/add_favorito','PropertyController');
Route::post('/add_favorito','PropertyController@addFavorito');

//Busqueda
Route::resource('/make_search','UserProfile');
Route::get('/make_search','UserProfile@makeSearch');

//Delete Users / Admins
Route::resource('drop_user', 'AdminController');
Route::post('drop_user', 'AdminController@dropUser');

//Add new admin
Route::resource('new_admin', 'AdminController');
Route::post('new_admin', 'AdminController@newAdmin');

//Delete BD
Route::resource('delete_db', 'AdminController');
Route::post('delete_db', 'AdminController@deleteDB');



//Alquileres
Route::resource('alquilar_propiedad', 'UserProfile');
Route::post('alquilar_propiedad', 'UserProfile@alquilarPropiedad');

Route::resource('ingresar_hotsale', 'UserProfile');
Route::post('ingresar_hotsale', 'UserProfile@ingresarHotsale');

Route::resource('participar_subasta', 'UserProfile');
Route::post('participar_subasta', 'UserProfile@participarSubasta');

Route::resource('pujar_subasta', 'UserProfile');
Route::post('pujar_subasta', 'UserProfile@pujarSubasta');
