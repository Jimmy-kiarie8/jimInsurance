<?php


Route::get('sms', 'SmsController@sms')->name('sms');

Route::get('myCronMethod', 'SmsController@myCronMethod')->name('myCronMethod');





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
Route::get('signup/activate/{token}', 'AuthController@signupActivate');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

	Route::get('/logoutOther', 'UserController@logoutOther')->name('logoutOther');
	Route::post('/logOtherDevices', 'UserController@logOtherDevices')->name('logOtherDevices');
	// Route::get('/insurance/{name}', function () {
	// 	return redirect('/');
	// })->where('name', '[A-Za-z]+');

	Route::get('/home', function () {
		return redirect('/');
	});

	// Route::get('/', function () {
	// 	$companies = Company::where('id', Auth::user()->company_id)->get();
	// 	foreach ($companies as $company) {
	// 		$company_logo = $company->logo;
	// 	}
	// 	$newrole = Auth::user()->roles;
	// 	foreach ($newrole as $name) {
	// 		$rolename = $name->name;
	// 	}
	// 	return view('welcome', compact('rolename', 'company_logo'));
	// });
	Route::get('/', 'HomeController@insurance')->name('insurance');
	Route::get('/insurance', 'HomeController@insurance')->name('insurance');
	Route::resource('users', 'UserController');
	Route::resource('roles', 'RoleController');
	Route::resource('branches', 'BranchController');
	Route::resource('email', 'EmailController');
	Route::resource('policy', 'PolicyController');
	Route::resource('certificates', 'CertificateController');
	Route::resource('companyprofile', 'CompanyprofileController');
	Route::resource('companies', 'CompanyController');
	Route::resource('coverage', 'CoverageController');
	Route::resource('clients', 'ClientController');
	Route::resource('insuracetype', 'InsuranceTypeController');
	Route::resource('policystatus', 'PolicyStatusController');
	Route::resource('insuraceclass', 'InsuranceClassController');
    Route::resource('roles', 'RoleController');
    Route::resource('sms', 'SmscontactController');
    Route::resource('groups', 'GroupController');


    Route::post('sendSms', 'SmscontactController@sendSms')->name('sendSms');
    Route::post('importContacts', 'UploadController@importContacts')->name('importContacts');
	Route::get('/sms_contact/{search}', 'SmscontactController@sms_contact')->name('sms_contact');

	Route::get('getUsersRole', 'RoleController@getUsersRole')->name('getUsersRole');
	Route::get('getRoles', 'RoleController@getRoles')->name('getRoles');
	Route::get('getPermissions', 'RoleController@getPermissions')->name('getPermissions');
	Route::post('getRolesPerm/{id}', 'RoleController@getRolesPerm')->name('getRolesPerm');
	Route::get('getRoles', 'RoleController@getRoles')->name('getRoles');

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

	Route::get('/file_no', 'PolicyController@file_no')->name('file_no');
	Route::get('/getPolicy', 'PolicyController@getPolicy')->name('getPolicy');
	Route::get('/policy_search/{search}', 'PolicyController@policy_search')->name('policy_search');

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
	Route::post('/premium', 'ReportController@premium')->name('premium');
	Route::post('/products', 'ReportController@products')->name('products');
	Route::post('/reminder', 'ReportController@reminder')->name('reminder');


	Route::post('getCompanies', 'CompanyController@getCompanies')->name('getCompanies');
	Route::post('getCompanyAdmin', 'CompanyController@getCompanyAdmin')->name('getCompanyAdmin');
	Route::post('companupdate/{id}', 'CompanyController@companupdate')->name('companupdate');
	Route::post('logo/{id}', 'CompanyController@logo')->name('logo');
	Route::post('getLogo', 'CompanyController@getLogo')->name('getLogo');
	Route::post('getLogoOnly', 'CompanyController@getLogoOnly')->name('getLogoOnly');

	Route::post('profilelogo/{id}', 'CompanyprofileController@profilelogo')->name('profilelogo');

	Route::get('getClients', 'ClientController@getClients')->name('getClients');
	Route::get('client_no', 'ClientController@client_no')->name('client_no');
	Route::get('clientSearch/{search}', 'ClientController@clientSearch')->name('clientSearch');

	Route::any('user_count', 'DashboardController@user_count')->name('user_count');
	Route::any('client_count', 'DashboardController@client_count')->name('client_count');
	Route::any('t_policies_count', 'DashboardController@t_policies_count')->name('t_policies_count');
	Route::any('policies_count', 'DashboardController@policies_count')->name('policies_count');
	Route::any('certificate_batch', 'DashboardController@certificate_batch')->name('certificate_batch');
	Route::any('t_certificate_batch', 'DashboardController@t_certificate_batch')->name('t_certificate_batch');
	Route::any('branches_count', 'DashboardController@branches_count')->name('branches_count');
	Route::any('t_policy_count', 'DashboardController@t_policy_count')->name('t_policy_count');
	Route::any('branches_count', 'DashboardController@branches_count')->name('branches_count');
});
