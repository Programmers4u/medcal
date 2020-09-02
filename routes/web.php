<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//////////////////
// ROOT CONTEXT //
//////////////////

Route::group(
    [
        'as'         => 'root.',
        'prefix'     => 'root',
        'namespace'  => 'Root',
        'middleware' => ['role:root'],
    ],
    function () {
        Route::get('dashboard', [
            'as'   => 'dashboard',
            'uses' => 'RootController@getIndex',
        ]);

        Route::get('sudo/{userId}', [
            'as'   => 'sudo',
            'uses' => 'RootController@getSudo',
        ])->where('userId', '\d*');
    }
);

//////////////////
// REGULAR AUTH //
//////////////////

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

//////////
// AJAX //
//////////

Route::group(['namespace' => 'API'], function () {

    Route::post('booking', [
        'as'   => 'api.booking.action',
        'uses' => 'BookingController@postAction',
    ]);

    Route::post('book', [
        'as'   => 'api.book.action',
        'uses' => 'BookingController@postBooking',
    ]);
    
    Route::post('getaxajcallendar', [
        'as'   => 'api.calendar.ajax',
        'uses' => 'BookingController@ajaxgetCallendar',
    ]);

    Route::post('getaxajcontact', [
        'as'   => 'api.contact.ajax.get',
        'uses' => 'BookingController@ajaxGetContact',
    ]);

    Route::post('getaxajservice', [
        'as'   => 'api.service.ajax.get',
        'uses' => 'BookingController@ajaxGetService',
    ]);
    
    Route::post('bookchange', [
        'as'   => 'api.calendar.bookingChange',
        'uses' => 'BookingController@bookingChange',
    ]);
    
    Route::get('sms/{clientId}/insert',[
        'uses' => 'SmsServerController@insert',
    ]);

    Route::get('sms/{clientId}/check',[
        'uses' => 'SmsServerController@checkToSend',
    ]);
    
    Route::get('sms/{clientId}/setstatus',[
        'uses' => 'SmsServerController@setStatus',
    ]);

    Route::get('sms/{clientId}/getstatus',[
        'uses' => 'SmsServerController@getStatus',
    ]);
    
    Route::post('sms/{clientId}/insert',[
        'uses' => 'SmsServerController@insert',
    ]);

    Route::post('sms/{clientId}/check',[
        'uses' => 'SmsServerController@checkClient',
    ]);
    
    Route::post('sms/{clientId}/setstatus',[
        'uses' => 'SmsServerController@setStatus',
    ]);

    Route::post('sms/{clientId}/getstatus',[
        'uses' => 'SmsServerController@getStatus',
    ]);

    Route::get('getappointments/{business}',[
        'as' => 'api.get.appointments',
        'uses' => 'AroundBusinessController@getAppointments',
    ]);
});


///////////////////
// GUEST CONTEXT //
///////////////////

Route::group([], function () {

    ///////////////////////////
    // PRIVATE HOME / WIZARD //
    ///////////////////////////

    Route::get('home', ['as' => 'home', 'uses' => 'User\WizardController@getWizard'])->middleware('auth');

    ///////////////////////
    // LANGUAGE SWITCHER //
    ///////////////////////

    Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);

    /////////////////
    // SOCIAL AUTH //
    /////////////////

    Route::get('social/login/redirect/{provider}', [
        'as'   => 'social.login',
        'uses' => 'Auth\OAuthController@redirectToProvider',
    ]);

    Route::get('social/login/{provider}', 'Auth\OAuthController@handleProviderCallback');

    /////////////////
    // PUBLIC HOME //
    /////////////////

    Route::get('/', 'WelcomeController@index');

    /////////////////
    // PUBLIC CONTACT FORM //
    /////////////////

    Route::post('contactform', 'WelcomeController@contactForm');

    ///////////////////////////////////////
    // WHOOPS USER FRIENDLY ERROR SCREEN //
    ///////////////////////////////////////

    Route::get('whoops', [
        'as'   => 'whoops',
        'uses' => 'WhoopsController@display',
    ]);
});

//////////////////
// USER CONTEXT //
//////////////////

Route::group(['prefix' => 'user', 'middleware' => ['auth']], function () {

    // USER PREFERENCES
    Route::get('preferences', [
        'as'   => 'user.preferences',
        'uses' => 'User\UserPreferencesController@getPreferences',
        ]);
    Route::post('preferences', [
        'as'   => 'user.preferences',
        'uses' => 'User\UserPreferencesController@postPreferences',
        ]);

    Route::get('agenda', [
        'as'   => 'user.agenda',
        'uses' => 'User\AgendaController@getIndex',
    ]);
    Route::get('businesses/register/{plan?}', [
        'as'   => 'manager.business.register',
        'uses' => 'Manager\BusinessController@create',
    ]);
    Route::post('businesses/register', [
        'as'   => 'manager.business.store',
        'uses' => 'Manager\BusinessController@store',
    ]);
    Route::get('businesses', [
        'as'   => 'manager.business.index',
        'uses' => 'Manager\BusinessController@index',
    ]);
    Route::get('directory', [
        'as'   => 'user.directory.list',
        'uses' => 'User\BusinessController@getList',
    ]);
    Route::get('subscriptions', [
        'as'   => 'user.subscriptions',
        'uses' => 'User\BusinessController@getSubscriptions',
    ]);
    Route::get('dashboard', [
        'as'   => 'user.dashboard',
        'uses' => 'User\WizardController@getDashboard',
    ]);

    ////////////
    // WIZARD //
    ////////////
    Route::group(['as' => 'wizard.'], function () {
        Route::get('terms', [
            'as'   => 'terms',
            'uses' => 'User\WizardController@getTerms',
        ]);
        Route::get('wizard', [
            'as'   => 'welcome',
            'uses' => 'User\WizardController@getWelcome',
        ]);
        Route::get('pricing', [
            'as'   => 'pricing',
            'uses' => 'User\WizardController@getPricing',
        ]);
    });
});

////////////////////////////////////
// SELECTED BUSINESS SLUG CONTEXT //
////////////////////////////////////

Route::group(['prefix' => '{business}'], function ($business) {

    Route::get('ical/{token}', [
        'as'   => 'business.ical.download',
        'uses' => 'User\ICalController@download',
    ]);
    
    ///////////////////
    // MEDICAL CONTEXT //
    ///////////////////
    Route::group(['prefix' => 'medical', 'namespace' => 'Medical'], function () {

            //MEDICAL MODULE
            Route::get('document/{contact}',[
                'as'   => 'medical.document',
                'uses' => 'MedicalController@index',
            ]);
            Route::get('document/link/{link}',[
                'as'   => 'medical.document.link',
                'uses' => 'MedicalController@indexLink',
            ]);
            Route::get('group/create',[
                'as'   => 'medical.group.create',
                'uses' => 'MedicalController@groupCreate',
            ]);
            Route::get('group/edit/{group_id}',[
                'as'   => 'medical.group.edit',
                'uses' => 'MedicalController@groupEdit',
            ]);
            Route::get('group',[
                'as'   => 'medical.group.index',
                'uses' => 'MedicalController@groupIndex',
            ]);
            
            Route::get('template',[
                'as'   => 'medical.template.index',
                'uses' => 'TemplateController@show',
            ]);

            Route::get('template/create',[
                'as'   => 'medical.template.create',
                'uses' => 'TemplateController@create',
            ]);

            Route::get('template/edit/{tmp_id}',[
                'as'   => 'medical.template.edit',
                'uses' => 'TemplateController@edit',
            ]);

            Route::get('template/delete/{tmp_id}',[
                'as'   => 'medical.template.delete',
                'uses' => 'TemplateController@delete',
            ]);

            Route::post('template/store',[
                'as'   => 'medical.template.store',
                'uses' => 'TemplateController@store',
            ]);

            Route::post('group/store',[
                'as'   => 'medical.group.store',
                'uses' => 'MedicalController@putGroup',
            ]);

            Route::post('group/delete',[
                'as'   => 'medical.group.delete',
                'uses' => 'MedicalController@deleteGroup',
            ]);

            Route::post('group/update',[
                'as'   => 'medical.group.update',
                'uses' => 'MedicalController@updateGroup',
            ]);

            Route::post('group/add',[
                'as'   => 'medical.group.add',
                'uses' => 'MedicalController@addToGroup',
            ]);

            Route::post('group/del',[
                'as'   => 'medical.group.del',
                'uses' => 'MedicalController@delFromGroup',
            ]);

            Route::post('interview/update',[
                'as'   => 'medical.interview.update',
                'uses' => 'MedicalController@putInterview',
            ]);
            Route::post('permission/update',[
                'as'   => 'medical.permission.update',
                'uses' => 'MedicalController@putPermission',
            ]);
            Route::post('history/update',[
                'as'   => 'medical.history.update',
                'uses' => 'MedicalController@putHistory',
            ]);
            Route::post('history/export',[
                'as'   => 'medical.history.export',
                'uses' => 'MedicalController@exportHistory',
            ]);
            Route::get('history/export/{contact}',[
                'as'   => 'medical.history.export.get',
                'uses' => 'MedicalController@exportHistory',
            ]);
            Route::post('file/put',[
                'as'   => 'medical.file.put',
                'uses' => 'MedicalController@putFile',
            ]);
            Route::post('file/delete',[
                'as'   => 'medical.file.delete',
                'uses' => 'MedicalController@deleteFile',
            ]);

            Route::post('file/permission/put',[
                'as'   => 'medical.file.permission.put',
                'uses' => 'MedicalController@putPermissionFile',
            ]);
            
            Route::post('history/note/add',[
                'as'   => 'medical.history.note.add',
                'uses' => 'MedicalController@ajaxAddNoteMedHistory',
            ]);
            

            Route::post('note/get',[
                'as'   => 'medical.note.get',
                'uses' => 'MedicalController@ajaxGetNote',
            ]);

            Route::post('note/put',[
                'as'   => 'medical.note.put',
                'uses' => 'MedicalController@ajaxPutNote',
            ]);
    });
    

    ///////////////////////////
    // BUSINESS USER CONTEXT //
    ///////////////////////////

    Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User'], function () {

        // BOOKINGS
        Route::group(['prefix' => 'agenda', 'as' => 'booking.'], function () {
            Route::post('store', [
                'as'   => 'store',
                'uses' => 'AgendaController@postStore',
            ]);
            Route::get('book', [
                'as'   => 'book',
                'uses' => 'AgendaController@getAvailability',
            ]);
            Route::get('validate', [
                'as'   => 'validate',
                'uses' => 'AgendaController@getValidate',
            ]);            
        });

        // BUSINESSES
        Route::group(['prefix' => 'businesses', 'as' => 'businesses.'], function () {
            Route::get('home', [
                'as'   => 'home',
                'uses' => 'BusinessController@getHome',
            ]);
        });
    });

    ////////////////////
    // USER RESOURCES //
    ////////////////////

    Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User'], function () {

        Route::get('profile', [
            'as'   => 'business.profile.edit',
            'uses' => 'ProfileController@edit',
        ]);

        Route::put('profile/{contact}', [
            'as'   => 'business.profile.update',
            'uses' => 'ProfileController@update',
        ]);

        Route::get('profile/reset', [
            'as'   => 'business.profile.reset',
            'uses' => 'ProfileController@passwordReset',
        ]);
        
        Route::get('contact', [
            'as'   => 'business.contact.index',
            'uses' => 'ContactController@index',
        ]);
        
        Route::get('contact/create', [
            'as'   => 'business.contact.create',
            'uses' => 'ContactController@create',
        ]);
        
        Route::post('contact', [
            'as'   => 'business.contact.store',
            'uses' => 'ContactController@store',
        ]);
        
        Route::get('contact/{contact}', [
            'as'   => 'business.contact.show',
            'uses' => 'ContactController@show',
        ]);
        
        Route::get('contact/{contact}/edit', [
            'as'   => 'business.contact.edit',
            'uses' => 'ContactController@edit',
        ]);
        
        Route::put('contact/{contact}', [
            'as'   => 'business.contact.update',
            'uses' => 'ContactController@update',
        ]);
        
        Route::delete('contact/{contact}', [
            'as'   => 'business.contact.destroy',
            'uses' => 'ContactController@destroy',
        ]);
    });

    //////////////////////////////
    // BUSINESS MANAGER CONTEXT //
    //////////////////////////////

    Route::group(['prefix' => 'manage', 'namespace' => 'Manager'], function () {

        
        // BUSINESS PREFERENCES
        Route::get('preferences', [
            'as'   => 'manager.business.preferences',
            'uses' => 'BusinessPreferencesController@getPreferences',
            ]);
        Route::post('preferences', [
            'as'   => 'manager.business.preferences',
            'uses' => 'BusinessPreferencesController@postPreferences',
            ]);

        // AGENDA
        Route::get('agenda', [
            'as'   => 'manager.business.agenda.index',
            'uses' => 'BusinessAgendaController@getIndex',
        ]);

        Route::get('calendar/{hr?}', [
            'as'   => 'manager.business.agenda.calendar',
            'uses' => 'BusinessAgendaController@getCalendar',
        ]);
        
        // BUSINESS MANAGEMENT
        Route::get('dashboard', [
            'as'   => 'manager.business.show',
            'uses' => 'BusinessController@show',
        ]);
        Route::get('edit', [
            'as'   => 'manager.business.edit',
            'uses' => 'BusinessController@edit',
        ]);
        Route::put('', [
            'as'   => 'manager.business.update',
            'uses' => 'BusinessController@update',
        ]);
        Route::delete('', [
            'as'   => 'manager.business.destroy',
            'uses' => 'BusinessController@destroy',
        ]);

        // BUSINESS NOTIFICATIONS
        Route::get('notifications', [
            'as'   => 'manager.business.notifications.show',
            'uses' => 'BusinessNotificationsController@show',
            ]);

        // SEARCH
        Route::post('search', [
            'as'   => 'manager.search',
            'uses' => 'Search@postSearch',
        ]);

        // ADDRESSBOOK / CONTACT RESOURCE
        Route::group(['prefix' => 'contact'], function () {
            Route::get('', [
                'as'   => 'manager.addressbook.index',
                'uses' => 'AddressbookController@index',
            ]);
            Route::get('create', [
                'as'   => 'manager.addressbook.create',
                'uses' => 'AddressbookController@create',
            ]);
            Route::get('contact2profil/{contact}', [
                'as'   => 'manager.addressbook.contact2profil',
                'uses' => 'AddressbookController@transformContactToUser',
            ]);
            Route::post('store', [
                'as'   => 'manager.addressbook.store',
                'uses' => 'AddressbookController@store',
            ]);
            Route::post('ministore', [
                'as'   => 'manager.addressbook.ministore',
                'uses' => 'AddressbookController@miniStore',
            ]);
            
            Route::get('{contact}', [
                'as'   => 'manager.addressbook.show',
                'uses' => 'AddressbookController@show',
            ]);
            Route::get('{contact}/edit', [
                'as'   => 'manager.addressbook.edit',
                'uses' => 'AddressbookController@edit',
            ]);
            Route::put('{contact}', [
                'as'   => 'manager.addressbook.update',
                'uses' => 'AddressbookController@update',
            ]);
            Route::delete('{contact}', [
                'as'   => 'manager.addressbook.destroy',
                'uses' => 'AddressbookController@destroy',
            ]);
        });

        // HUMAN RESOURCE
        Route::group(['prefix' => 'humanresources'], function () {

            Route::get('', [
                'as'   => 'manager.business.humanresource.index',
                'uses' => 'HumanresourceController@index',
            ]);
            Route::get('create', [
                'as'   => 'manager.business.humanresource.create',
                'uses' => 'HumanresourceController@create',
            ]);
            Route::post('', [
                'as'   => 'manager.business.humanresource.store',
                'uses' => 'HumanresourceController@store',
            ]);
            Route::get('{humanresource}', [
                'as'   => 'manager.business.humanresource.show',
                'uses' => 'HumanresourceController@show',
            ]);
            Route::get('{humanresource}/edit', [
                'as'   => 'manager.business.humanresource.edit',
                'uses' => 'HumanresourceController@edit',
            ]);
            Route::put('{humanresource}', [
                'as'   => 'manager.business.humanresource.update',
                'uses' => 'HumanresourceController@update',
            ]);
            Route::delete('{humanresource}', [
                'as'   => 'manager.business.humanresource.destroy',
                'uses' => 'HumanresourceController@destroy',
            ]);
        });

        // SERVICE RESOURCE
        Route::group(['prefix' => 'service'], function () {

            // SERVICE TYPE
            Route::group(['prefix' => 'type'], function () {
                Route::get('edit', [
                    'as'   => 'manager.business.servicetype.edit',
                    'uses' => 'ServiceTypeController@edit',
                ]);
                Route::put('', [
                    'as'   => 'manager.business.servicetype.update',
                    'uses' => 'ServiceTypeController@update',
                ]);
            });

            Route::get('', [
                'as'   => 'manager.business.service.index',
                'uses' => 'BusinessServiceController@index',
            ]);
            Route::get('create', [
                'as'   => 'manager.business.service.create',
                'uses' => 'BusinessServiceController@create',
            ]);
            Route::post('', [
                'as'   => 'manager.business.service.store',
                'uses' => 'BusinessServiceController@store',
            ]);
            Route::get('{service}', [
                'as'   => 'manager.business.service.show',
                'uses' => 'BusinessServiceController@show',
            ]);
            Route::get('{service}/edit', [
                'as'   => 'manager.business.service.edit',
                'uses' => 'BusinessServiceController@edit',
            ]);
            Route::put('{service}', [
                'as'   => 'manager.business.service.update',
                'uses' => 'BusinessServiceController@update',
            ]);
            Route::delete('{service}', [
                'as'   => 'manager.business.service.destroy',
                'uses' => 'BusinessServiceController@destroy',
            ]);
        });

        // VACANCY RESOURCE
        Route::group(['prefix' => 'vacancy'], function () {
            Route::get('show', [
                'as'   => 'manager.business.vacancy.show',
                'uses' => 'BusinessVacancyController@show',
            ]);
            Route::get('create', [
                'as'   => 'manager.business.vacancy.create',
                'uses' => 'BusinessVacancyController@create',
            ]);
            Route::post('storeBatch', [
                'as'   => 'manager.business.vacancy.storeBatch',
                'uses' => 'BusinessVacancyController@storeBatch',
            ]);
            Route::post('', [
                'as'   => 'manager.business.vacancy.store',
                'uses' => 'BusinessVacancyController@store',
            ]);
            Route::post('update', [
                'as'   => 'manager.business.vacancy.update',
                'uses' => 'BusinessVacancyController@update',
            ]);
        });
    });
});

Route::get('{slug}', [
    'as'   => 'guest.business.home',
    'uses' => 'Guest\BusinessController@getHome',
])->where('slug', '[^_]+.*');
