<?php
use App\Company;

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
	// Socialite
// Route::get('login/{service}', 'Auth\LoginController@redirectToProvider');
// Route::get('login/{service}/callback', 'Auth\LoginController@handleProviderCallback');
// Route::get('/search', 'ShipmentController@search')->name('search');
// Route::get('/algoria', function () {
// 	return view('search');
// });
Route::get('verifyEmailFirst', 'Auth\RegisterController@verifyEmailFirst')->name('verifyEmailFirst');
Route::get('/verify/{verifyToken}', 'EmailController@verify')->name('verify');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
	Route::get('/insurance/{name}', function () {
		return redirect('/');
	})->where('name', '[A-Za-z]+');

	Route::get('/insurance', function () {
	    $companies = Company::where('id', Auth::user()->company_id)->get();
	    foreach ($companies as $company) {
	        $company_logo = $company->logo;
	    }
		$newrole = Auth::user()->roles;
		foreach ($newrole as $name) {
			$rolename = $name->name;
		}
		return view('welcome', compact('rolename', 'company_logo'));
	});

	Route::get('/home', 'HomeController@index')->name('home');
	Route::resource('users', 'UserController');
	Route::resource('roles', 'RoleController');
	Route::resource('branches', 'BranchController');
	Route::resource('email', 'EmailController');
	Route::resource('policy', 'PolicyController');
	Route::resource('certificates', 'CertificateController');
	Route::resource('companies', 'CompanyController');

	Route::get('getUsers', 'UserController@getUsers')->name('getUsers');
	Route::get('getDrivers', 'UserController@getDrivers')->name('getDrivers');
	Route::get('getCustomer', 'UserController@getCustomer')->name('getCustomer');
	Route::get('getLogedinUsers', 'UserController@getLogedinUsers')->name('getLogedinUsers');
	Route::post('profile/{id}', 'UserController@profile')->name('profile');
	Route::post('getSorted', 'UserController@getSorted')->name('getSorted');


	Route::get('getUsersRole', 'RoleController@getUsersRole')->name('getUsersRole');
	Route::get('getRoles', 'RoleController@getRoles')->name('getRoles');

	Route::get('getBranch', 'BranchController@getBranch')->name('getBranch');
	Route::post('getBranchShip/{id}', 'BranchController@getBranchShip')->name('getBranchShip');

	// E-MAILS
	Route::post('/sendmail', 'EmailController@sendmail')->name('sendmail');
	Route::post('/getsubscribers', 'EmailController@getsubscribers')->name('getsubscribers');
	Route::post('/subscribe', 'EmailController@subscribe')->name('subscribe');
	Route::post('/refresh/{id}', 'EmailController@refresh')->name('refresh');

	Route::get('/getPolicy', 'PolicyController@getPolicy')->name('getPolicy');

	Route::get('/getunsubscribed', 'EmailController@getunsubscribed')->name('getunsubscribed');

	// Invoices
	// Reports
	// Route::get('/displayReport', 'ReportController@displayReport')->name('displayReport');

	// Insurance Classes
	Route::get('/getStatus', 'ClassesController@getStatus')->name('getStatus');
	Route::get('/getinsuranceClass', 'ClassesController@getinsuranceClass')->name('getinsuranceClass');
	Route::get('/getinsuranceType', 'ClassesController@getinsuranceType')->name('getinsuranceType');

	// Certificates
	Route::get('/getCertificates', 'CertificateController@getCertificates')->name('getCertificates');

	Route::get('/certs', 'CertificateController@certs')->name('certs');
	// Route::get('/customers/pdf','CustomerController@export_pdf');


	// Reports
	Route::post('/report', 'ReportController@report')->name('report');

	
	Route::post('getCompanies', 'CompanyController@getCompanies')->name('getCompanies');
	Route::post('getCompanyAdmin', 'CompanyController@getCompanyAdmin')->name('getCompanyAdmin');
	Route::post('companupdate/{id}', 'CompanyController@companupdate')->name('companupdate');
	Route::post('logo/{id}', 'CompanyController@logo')->name('logo');
	Route::post('getLogo', 'CompanyController@getLogo')->name('getLogo');
	Route::post('getLogoOnly', 'CompanyController@getLogoOnly')->name('getLogoOnly');
	
	
});