<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::Welcome');
$routes->get('/Confirm/(:any)', 'AuthController::ConfirmEmail/$1');
$routes->get('/Login', 'AuthController::Login');
$routes->post('/LoginAccount', 'AuthController::LoginAccount');
$routes->get('/Register', 'AuthController::Register');
$routes->post('/RegisterAccount', 'AuthController::RegisterAccount');
$routes->get('/Hello', 'AuthController::Index');
$routes->get('/Logout', 'AuthController::Logout');
$routes->get('/Users', 'UserController::Index');
$routes->get('/Users/Info/(:any)', 'UserController::UserInfo/$1');
$routes->get('/Users/Create', 'UserController::CreateUser');
$routes->post('/Users/Save', 'UserController::SaveUser');
$routes->get('/Users/Edit/(:any)', 'UserController::EditUser/$1');
$routes->post('/Users/Update/(:any)', 'UserController::UpdateUser/$1');
$routes->get('/Users/Delete/(:any)', 'UserController::DeleteUser/$1');
$routes->post('/Users/Search', 'UserController::SearchUser');
$routes->get('/Users/UserSelfDelete/(:any)','UserController::UserSelfDelete/$1');
$routes->get('/Account', 'AccountController::Index');
$routes->get('/Account/ChangeSomethingForm/(:any)', 'AccountController::ChangeSomethingForm/$1');
$routes->post('/Account/UpdateField/Nombre', 'AccountController::UpdateAccountname');
$routes->post('/Account/UpdateField/Mail', 'AccountController::UpdateAccountemail');
$routes->get('/Account/ChangePasswordForm', 'AccountController::ChangePasswordForm');
$routes->post('/Account/ChangePassword', 'AccountController::ChangePassword');
$routes->get('/Account/DeleteAccount', 'AccountController::SendDeleteMail');
$routes->get('/Account/GoToDelete/(:any)', 'AccountController::GoToDelete/$1');
$routes->post('/Account/DeleteAccount/(:any)', 'AccountController::DeleteAccount/$1');
$routes->get('/Devices', 'DeviceController::Index');
$routes->get('/Devices/Create', 'DeviceController::CreateDevice');
$routes->post('/Devices/Save', 'DeviceController::SaveDevice');
$routes->get('/Devices/Edit/(:any)', 'DeviceController::EditDevice/$1');
$routes->post('/Devices/Update/(:any)', 'DeviceController::UpdateDevice/$1');
$routes->get('/Devices/Delete/(:any)', 'DeviceController::DeleteDevice/$1');
$routes->get('/Devices/Info/(:any)', 'DeviceController::DeviceInfo/$1');
$routes->get('/Device/GetStatus', 'ApiController::GetStatus');
$routes->get('/Password/ShowRecoveryForm', 'PasswordController::ShowRecoveryForm');
$routes->post('/Password/RequestRecovery', 'PasswordController::RequestRecovery');
$routes->get('/Password/ShowResetForm/(:any)', 'PasswordController::ShowResetForm/$1');
$routes->post('/Password/Update/(:any)', 'PasswordController::Update/$1');
$routes->get('/Logs','LogController::Index');
$routes->get('/Logs/DeleteAuto','LogController::DeleteLogsAuto');
$routes->post('/Logs/Search', 'LogController::SearchUserLogs');
$routes->post('/Board/CheckTag', 'ApiController::CheckTag');
$routes->post('/Board/SetStatus', 'ApiController::SetStatus');
$routes->post('/Board/FirstConnection', 'ApiController::FirstConnection');
$routes->get('/Shop','ShopController::Index');
$routes->get('/Shop/History','ShopController::History');
$routes->get('/Shop/Product/(:any)','ShopController::Product/$1');
$routes->get('/Shop/Buy/(:any)','ShopController::Buy/$1');
$routes->group('Shop', function($routes){
    $routes->get('getCitiesByProvince/(:num)', 'ShopController::getCitiesByProvince/$1');
    $routes->post('CreatePurchase/(:num)', 'ShopController::CreatePurchase/$1');
});
$routes->post('/Paypal/Create/(:any)', 'PaypalController::CreatePayment/$1');
$routes->get('/Paypal/Success/(:any)', 'PaypalController::Success/$1');
$routes->get('/Paypal/Error', 'PaypalController::PaymentError');
$routes->get('/Paypal/Cancel', 'PaypalController::Cancel');
$routes->get('/Admin', 'AdminController::AdminDashboard');
$routes->get('/Admin/Clear', 'AdminController::RunAccountCleanupManually');
$routes->get('/Admin/ClearAuto', 'AdminController::RunAccountCleanupAuto');
$routes->get('/Admin/Search', 'AdminController::SearchAccount');
$routes->post('/Admin/UpdateAccountRole', 'AdminController::UpdateAccountRole');
$routes->get('/verify-2fa', 'AuthController::Verify2FA');
$routes->post('/Process2FA', 'AuthController::Process2FA');
$routes->get('/setup-2fa', 'AuthController::ShowSetup2FA');
$routes->get('/disable-2fa', 'AuthController::Disable2FA');