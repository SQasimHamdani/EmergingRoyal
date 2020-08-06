<?php

Route::get('/', 'FrontEndController@FrontEndIndex')->name('/');

Route::get('/login', 'FrontEndController@showFrontEndLoginForm')->name('FrontEndlogin');
Route::post('/login', 'FrontEndController@actionLogin')->name('FrontEndactionLogin');

Route::get('/register', 'FrontEndController@showFrontEndRegisterForm')->name('FrontEndRegister');
Route::post('/register', 'FrontEndController@actionRegister')->name('FrontEndactionRegister');

Route::post('/logout', 'FrontEndController@logout')->name('logout');

Route::get('/advertiser', 'FrontEndController@FrontEndAdvertiserIndex');
Route::get('/member', 'FrontEndController@FrontEndMemberIndex');

Route::post('/forgot/password', 'FrontEndController@forgotPass')->name('forget.password.user');
Route::get('/reset/{token}', 'FrontEndController@resetLink')->name('reset.passlink');
Route::post('/reset/password', 'FrontEndController@passwordReset')->name('reset.passw');
Route::get('pagenotfound', 'FrontEndController@pageNotFound')->name('pagenot.found');

//Authorization
// Route::get('/authorization', 'FrontEndController@authorization')->name('authorization');
// Route::post('/sendemailver', 'FrontEndController@sendemailver')->name('sendemailver');
// Route::post('/emailverify', 'FrontEndController@emailverify')->name('emailverify');
// Route::post('/sendsmsver', 'FrontEndController@sendsmsver')->name('sendsmsver');
// Route::post('/smsverify', 'FrontEndController@smsverify')->name('smsverify');
// Route::post('/g2fa-verify', 'FrontEndController@verify2fa')->name('go2fa.verify');


// Auth::routes();

Route::group(['middleware' => 'web'], function() {

    
    Route::get('/home', 'UserPanelController@index')->name('home');

    Route::get('/security', 'UserPanelController@securityIndex')->name('security.index');
    Route::post('/update/password', 'UserPanelController@changePassword')->name('change.password.user');


    Route::get('/profile', 'UserPanelController@profileIndex')->name('profile.index');
    Route::put('/update/profile', 'UserPanelController@updateProfile')->name('update.profile');

    Route::get('create/advertise', 'UserPanelController@CreateMyAds')->name('my.advertise');

    Route::post('buy/pack', 'UserPanelController@buyPack')->name('package.buy');
    Route::post('create/add', 'UserPanelController@createAdvertise')->name('create.user.add');

    Route::get('my/advertises', 'UserPanelController@myAdvertise')->name('manage.advertise');

    Route::post('/get/advertise', 'UserPanelController@submitAdVerification')->name('get.advertise.id');

    Route::get('/advertises', 'UserPanelController@AvailableAdsIndex')->name('ptc.add.index');
    Route::get('clicked/advertise/{token}', 'UserPanelController@getIframe')->name('iframe.open');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminAuth\LoginController@showLoginForm');


    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');

    Route::middleware(['admin'])->group(function () {


        Route::get('/general', "GeneralController@index")->name('general.index')->middleware('admin');
        Route::put('/general-update/{id}', "GeneralController@update")->name('general.update')->middleware('admin');


        
        Route::get('logo/icon', 'LogoController@logoIndex')->name('logo.icon')->middleware('admin');
        Route::put('logo_update', 'LogoController@updateLogo')->name('logo.update')->middleware('admin');
        Route::put('icon_update', 'LogoController@updateIcon')->name('icon.update')->middleware('admin');


        Route::get('/about', "GeneralController@indexAbout")->name('about.admin.index')->middleware('admin');
        Route::put('/about/update/{id}', "GeneralController@updateAbout")->name('about.admin.update')->middleware('admin');

        Route::get('/footer', "GeneralController@indexFooter")->name('footer.index.admin')->middleware('admin');
        Route::put('/footer/update', "GeneralController@updateFooter")->name('footer.update')->middleware('admin');



        Route::GET('user/search', 'AdminController@userSearch')->name('username.search')->middleware('admin');
        Route::GET('user/search/email', 'AdminController@userSearchEmail')->name('email.search')->middleware('admin');

        Route::get('users', 'AdminController@usersIndex')->name('user.manage')->middleware('admin');
        Route::post('/users/amount/{id}', 'AdminController@indexBalanceUpdate')->name('user.balance.update')->middleware('admin');
        Route::get('/users/send/mail/{id}', 'AdminController@userSendMail')->name('user.mail.send')->middleware('admin');
        Route::post('/send/mail/{id}', 'AdminController@userSendMailUser')->name('send.mail.user')->middleware('admin');
        Route::get('/users/balance/{id}', 'AdminController@indexUserBalance')->name('add.subs.index')->middleware('admin');
        Route::get('/users/detail/{id}', 'AdminController@indexUserDetail')->name('user.view')->middleware('admin');
        Route::put('/users/update/{id}', 'AdminController@userUpdate')->name('user.detail.update')->middleware('admin');
        Route::post('/users/delete/{id}', 'AdminController@userDelete')->name('users.delete')->middleware('admin');
        


        Route::get('paid/user', 'AdminController@paidUser')->name('paid.user.index')->middleware('admin');
        Route::get('free/user', 'AdminController@freeUser')->name('free.user.index')->middleware('admin');



        Route::get('buy/package/history', 'AdminController@buyPackageHistory')->name('buy.package.user')->middleware('admin');
        Route::put('limitation/update/{id}', 'GeneralController@limitUpdate')->name('manage.limit')->middleware('admin');
        Route::get('ptc/limitation', 'AdminController@limitIndex')->name('ptc.limit')->middleware('admin');


        Route::get('/charge/commission', "GeneralController@indexCommision")->name('charge.commission')->middleware('admin');
        Route::put('/charge/commission/{id}', "GeneralController@UpdateCommision")->name('commission.update')->middleware('admin');


        Route::get('add/new', 'AdminController@newAddvertise')->name('add.addvertise')->middleware('admin');
        Route::post('add/new', 'AdminController@newAddvertiseStore')->name('create.addvertise')->middleware('admin');
        Route::get('add/view/{id}', 'AdminController@newAddvertiseEdit')->name('add.view.admin')->middleware('admin');
        Route::put('add/update/{id}', 'AdminController@newAddvertiseUpdate')->name('update.addvertise')->middleware('admin');
        Route::post('add/delete/{id}', 'AdminController@newAddvertiseDelete')->name('add.delete')->middleware('admin');


        Route::get('ptc/packages', 'AdminController@packageIndex')->name('package.index')->middleware('admin');
        Route::post('ptc/packages/create', 'AdminController@packageStore')->name('create.package')->middleware('admin');
        Route::post('ptc/packages/delete/{id}', 'AdminController@packageDelete')->name('package.delete')->middleware('admin');
        Route::get('ptc/packages/edit/{id}', 'AdminController@packageEdit')->name('package.edit')->middleware('admin');
        Route::put('ptc/packages/update/{id}', 'AdminController@packageUpdate')->name('package.update')->middleware('admin');
        Route::get('detail', 'AdminController@packageDetailDelete')->name('detail.delete')->middleware('admin');

        


        Route::get('request/advertise', 'AdminController@reqAddIndex')->name('req.add.index')->middleware('admin');
        Route::post('approve/advertise', 'AdminController@approveAdd')->name('aprove.ad')->middleware('admin');
        Route::post('reject/advertise', 'AdminController@rejectAdd')->name('reject.ad')->middleware('admin');
        Route::get('reject/advertise', 'AdminController@rejectAddIndex')->name('reject.add.index')->middleware('admin');
        Route::get('advertises', 'AdminController@allAddIndex')->name('all.add.index')->middleware('admin');

/////////////////////////////////////////////////////////////        
        
        Route::get('send/money/{id}', 'AdminController@sendMoneyView')->name('user.total.send.money')->middleware('admin');
        Route::get('withdraw/view/{id}', 'AdminController@withDrawView')->name('user.total.withdraw')->middleware('admin');
        Route::get('add/fund/view/{id}', 'AdminController@depositView')->name('user.total.deposit')->middleware('admin');
        Route::get('transaction/view/{id}', 'AdminController@transView')->name('user.total.trans')->middleware('admin');
        Route::get('add/fund/user', 'AdminController@depositLog')->name('index.deposit.user')->middleware('admin');
        
/////////////////////////////////////////////////////////////


        Route::post('change-password', 'AdminController@saveResetPassword')->name('change.password');

        // Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
        // Route::post('/register', 'AdminAuth\RegisterController@register');


        // Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
        // Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
        // Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        // Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
        });

});

