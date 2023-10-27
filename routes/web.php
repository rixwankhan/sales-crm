<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/kanban', 'KanbanController@index')->name('kanban.index');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Crm Contacts
    Route::delete('crm-contacts/destroy', 'CrmContactsController@massDestroy')->name('crm-contacts.massDestroy');
    Route::post('crm-contacts/parse-csv-import', 'CrmContactsController@parseCsvImport')->name('crm-contacts.parseCsvImport');
    Route::post('crm-contacts/process-csv-import', 'CrmContactsController@processCsvImport')->name('crm-contacts.processCsvImport');
    Route::resource('crm-contacts', 'CrmContactsController');

    // Task Status
    Route::delete('task-statuses/destroy', 'TaskStatusController@massDestroy')->name('task-statuses.massDestroy');
    Route::post('task-statuses/parse-csv-import', 'TaskStatusController@parseCsvImport')->name('task-statuses.parseCsvImport');
    Route::post('task-statuses/process-csv-import', 'TaskStatusController@processCsvImport')->name('task-statuses.processCsvImport');
    Route::resource('task-statuses', 'TaskStatusController');

    // Task Tag
    Route::delete('task-tags/destroy', 'TaskTagController@massDestroy')->name('task-tags.massDestroy');
    Route::post('task-tags/parse-csv-import', 'TaskTagController@parseCsvImport')->name('task-tags.parseCsvImport');
    Route::post('task-tags/process-csv-import', 'TaskTagController@processCsvImport')->name('task-tags.processCsvImport');
    Route::resource('task-tags', 'TaskTagController');

    // Task
    Route::delete('tasks/destroy', 'TaskController@massDestroy')->name('tasks.massDestroy');
    Route::post('tasks/media', 'TaskController@storeMedia')->name('tasks.storeMedia');
    Route::post('tasks/ckmedia', 'TaskController@storeCKEditorImages')->name('tasks.storeCKEditorImages');
    Route::resource('tasks', 'TaskController');

    // Tasks Calendar
    Route::resource('tasks-calendars', 'TasksCalendarController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    // Crm Products
    Route::delete('crm-products/destroy', 'CrmProductsController@massDestroy')->name('crm-products.massDestroy');
    Route::post('crm-products/media', 'CrmProductsController@storeMedia')->name('crm-products.storeMedia');
    Route::post('crm-products/ckmedia', 'CrmProductsController@storeCKEditorImages')->name('crm-products.storeCKEditorImages');
    Route::post('crm-products/parse-csv-import', 'CrmProductsController@parseCsvImport')->name('crm-products.parseCsvImport');
    Route::post('crm-products/process-csv-import', 'CrmProductsController@processCsvImport')->name('crm-products.processCsvImport');
    Route::resource('crm-products', 'CrmProductsController');

    // Product Categories
    Route::delete('product-categories/destroy', 'ProductCategoriesController@massDestroy')->name('product-categories.massDestroy');
    Route::post('product-categories/parse-csv-import', 'ProductCategoriesController@parseCsvImport')->name('product-categories.parseCsvImport');
    Route::post('product-categories/process-csv-import', 'ProductCategoriesController@processCsvImport')->name('product-categories.processCsvImport');
    Route::resource('product-categories', 'ProductCategoriesController');

    // Deal Stage
    Route::delete('deal-stages/destroy', 'DealStageController@massDestroy')->name('deal-stages.massDestroy');
    Route::post('deal-stages/parse-csv-import', 'DealStageController@parseCsvImport')->name('deal-stages.parseCsvImport');
    Route::post('deal-stages/process-csv-import', 'DealStageController@processCsvImport')->name('deal-stages.processCsvImport');
    Route::resource('deal-stages', 'DealStageController');

    // Deals
    Route::delete('deals/destroy', 'DealsController@massDestroy')->name('deals.massDestroy');
    Route::post('deals/media', 'DealsController@storeMedia')->name('deals.storeMedia');
    Route::post('deals/ckmedia', 'DealsController@storeCKEditorImages')->name('deals.storeCKEditorImages');
    Route::post('deals/parse-csv-import', 'DealsController@parseCsvImport')->name('deals.parseCsvImport');
    Route::post('deals/process-csv-import', 'DealsController@processCsvImport')->name('deals.processCsvImport');
    Route::resource('deals', 'DealsController');

    // Deal Source
    Route::delete('deal-sources/destroy', 'DealSourceController@massDestroy')->name('deal-sources.massDestroy');
    Route::resource('deal-sources', 'DealSourceController');

    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
