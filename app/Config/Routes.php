<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
// $routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index');
$routes->get('lang/{locale}', 'Language::index');

$routes->add('admin/logout', 'Login::logout');
$routes->add('login/forgot-password', 'Login::forgot_password');
$routes->add('login/verify-code', 'Login::check_reset_tokon');
$routes->add('login/reset-password', 'Login::change_password');
$routes->get('/delete-account', 'DeleteAccount::index');

$routes->group('', ['filter' => 'AdminAuth'], function($routes){
    /**
     * DASHBOARD CONTROLLER ROUTES
     */
    $routes->add('admin/profile', 'Admin/Dashboard::profile');
    $routes->add('admin/reset-password', 'Admin/Dashboard::reset_password');
    /**
     * Contests
     */
    $routes->add('admin/contests/contest-result', 'Admin/Contests::contest_result');
    /**
     * points
     */
    $routes->add('admin/settings/point-settings', 'Admin/Settings::points_setting');
    /**
     * Settings
     */
    $routes->add('admin/settings/payment-settings', 'Admin/Settings::payment_settings');
    $routes->add('admin/settings/firebase-settings', 'Admin/Settings::firebase_settings');
    /**
     * CMS
     */
    $routes->add('admin/cms/new-page', 'Admin/Cms::new_page');
    //$routes->add('admin/cms/edit-page', 'Admin/Cms::edit_page');
    
    $routes->get('admin/cms/edit-page', 'Admin/Cms::edit_page');
    $routes->get('admin/payments/point-transaction', 'Admin/Payments::point_transaction');
});


/**API ROUTES START */
$routes->add('api/userapi/register-user', 'Api/UserApi::register_user');
$routes->add('api/userapi/login', 'Api/UserApi::user_login');
$routes->add('api/userapi/logout', 'Api/UserApi::logout_user');
$routes->add('api/userapi/getuser', 'Api/UserApi::get_user_details');
$routes->add('api/userapi/edituser', 'Api/UserApi::edit_user_details');
$routes->add('api/userapi/reset-password', 'Api/UserApi::reset_password');
$routes->add('api/userapi/forgot-password', 'Api/UserApi::forgot_password');
$routes->add('api/userapi/change-password', 'Api/UserApi::change_password');
$routes->add('api/userapi/notificationaccess', 'Api/UserApi::notificationaccess');
$routes->add('api/userapi/user-profile', 'Api/UserApi::user_profile');
$routes->add('api/paymentapi/promocodelist', 'Api/PaymentApi::get_promocodes');
$routes->add('api/paymentapi/get-payment-settings', 'Api/PaymentApi::get_payment_settings');
$routes->add('api/paymentapi/confirm-payment', 'Api/PaymentApi::confirm_payment');
$routes->add('api/paymentapi/redeem-points', 'Api/PaymentApi::redeem_points');
$routes->add('api/userapi/social-login', 'Api/UserApi::social_login');
$routes->add('api/homeapi', 'Api/HomeApi::homeApi');
$routes->add('api/get-setting-pages', 'Api/HomeApi::cms_api');
$routes->add('api/getnotifications', 'Api/HomeApi::getnotifications');
$routes->add('api/userapi/add-user-following', 'Api/UserApi::add_user_following');
$routes->add('api/userapi/get-user-follower-and-following-info', 'Api/UserApi::get_followers_and_following_info');
$routes->add('api/contact-us', 'Api/HomeApi::contact_us');
$routes->add('api/contestapi/join-contest', 'Api/ContestApi::JoinContest');
$routes->add('api/contestapi/contests', 'Api/ContestApi::contests');
$routes->add('api/contestapi/deleteparticipant', 'Api/ContestApi::deleteParticipant');
$routes->add('api/contestapi/leaderboard', 'Api/ContestApi::current_contest');
$routes->add('api/contestapi/getcontests', 'Api/ContestApi::getContest');
$routes->add('api/contestapi/editcontest', 'Api/ContestApi::editContest');
$routes->add('api/contestapi/contest-archive', 'Api/ContestApi::contest_archive');
$routes->add('api/contestapi/current-submission', 'Api/ContestApi::current_submission');
$routes->add('api/reviewerapi/get-user-score', 'Api/ReviewerApi::get_user_score');
$routes->add('api/reviewerapi/get-participant-details', 'Api/ReviewerApi::get_participant_details');
$routes->add('api/reviewerapi/give-score', 'Api/ReviewerApi::give_score');
$routes->add('api/reviewersupervisorapi/get-user-score-all', 'Api/ReviewerSupervisourApi::get_user_score_all');
$routes->add('api/reviewersupervisorapi/give-score', 'Api/ReviewerSupervisourApi::give_score');
$routes->add('api/reviewersupervisorapi/get-participant-details', 'Api/ReviewerSupervisourApi::get_participant_details');
$routes->add('api/reviewersupervisorapi/disqualify', 'Api/ReviewerSupervisourApi::disqualify');
$routes->add('api/reviewersupervisorapi/accept-decline', 'Api/ReviewerSupervisourApi::accept_decline');
$routes->add('api/participanthistory/history', 'Api/ParticipantHistory::participanthistory');
$routes->add('api/userapi/deleteUser', 'Api/UserApi::deleteUser');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
