<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Crm Contacts
    Route::apiResource('crm-contacts', 'CrmContactsApiController');

    // Task Status
    Route::apiResource('task-statuses', 'TaskStatusApiController');

    // Task Tag
    Route::apiResource('task-tags', 'TaskTagApiController');

    // Task
    Route::post('tasks/media', 'TaskApiController@storeMedia')->name('tasks.storeMedia');
    Route::apiResource('tasks', 'TaskApiController');

    // Crm Products
    Route::post('crm-products/media', 'CrmProductsApiController@storeMedia')->name('crm-products.storeMedia');
    Route::apiResource('crm-products', 'CrmProductsApiController');

    // Product Categories
    Route::apiResource('product-categories', 'ProductCategoriesApiController');

    // Deal Stage
    Route::apiResource('deal-stages', 'DealStageApiController');

    // Deals
    Route::post('deals/media', 'DealsApiController@storeMedia')->name('deals.storeMedia');
    Route::apiResource('deals', 'DealsApiController');

    // Deal Source
    Route::apiResource('deal-sources', 'DealSourceApiController');
});
