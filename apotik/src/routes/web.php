<?php

Route::get('/', 'FrontendController@home');
Route::get('/pengajuan', 'FrontendController@pengajuan');
Route::get('/pesanan', 'FrontendController@pesanan');
Route::get('/pesananresep', 'FrontendController@pesananresep');
Route::get('/profile', 'FrontendController@profile');

Route::redirect('/loginadmin', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // // Sosial Media
    // Route::delete('sosial-media/destroy', 'SosialMediaController@massDestroy')->name('sosial-media.massDestroy');
    // Route::resource('sosial-media', 'SosialMediaController');

    // // Beasiswa
    // Route::delete('beasiswas/destroy', 'BeasiswaController@massDestroy')->name('beasiswas.massDestroy');
    // Route::post('beasiswas/media', 'BeasiswaController@storeMedia')->name('beasiswas.storeMedia');
    // Route::post('beasiswas/ckmedia', 'BeasiswaController@storeCKEditorImages')->name('beasiswas.storeCKEditorImages');
    // Route::resource('beasiswas', 'BeasiswaController');

    // // Pendaftaran
    // Route::delete('pendaftarans/destroy', 'PendaftaranController@massDestroy')->name('pendaftarans.massDestroy');
    // Route::resource('pendaftarans', 'PendaftaranController');

    // // Gallery
    // Route::delete('galleries/destroy', 'GalleryController@massDestroy')->name('galleries.massDestroy');
    // Route::post('galleries/media', 'GalleryController@storeMedia')->name('galleries.storeMedia');
    // Route::post('galleries/ckmedia', 'GalleryController@storeCKEditorImages')->name('galleries.storeCKEditorImages');
    // Route::resource('galleries', 'GalleryController');

    // golongan
    Route::delete('golongans/destroy', 'GolonganController@massDestroy')->name('golongans.massDestroy');
    Route::resource('golongans', 'GolonganController');

    // jenis
    Route::delete('jenise/destroy', 'JenisController@massDestroy')->name('jenise.massDestroy');
    Route::resource('jenise', 'JenisController');

    // Obat
    Route::delete('obats/destroy', 'ObatController@massDestroy')->name('obats.massDestroy');
    Route::post('obats/media', 'ObatController@storeMedia')->name('obats.storeMedia');
    Route::post('obats/ckmedia', 'ObatController@storeCKEditorImages')->name('obats.storeCKEditorImages');
    Route::resource('obats', 'ObatController');

    // Profile
    Route::delete('profiles/destroy', 'ProfileController@massDestroy')->name('profiles.massDestroy');
    Route::post('profiles/media', 'ProfileController@storeMedia')->name('profiles.storeMedia');
    Route::post('profiles/ckmedia', 'ProfileController@storeCKEditorImages')->name('profiles.storeCKEditorImages');
    Route::resource('profiles', 'ProfileController');

    // pesanan
    Route::delete('pesanans/destroy', 'PesananController@massDestroy')->name('pesanans.massDestroy');
    Route::resource('pesanans', 'PesananController');

    // Pengajuan
    Route::delete('pengajuans/destroy', 'PengajuanController@massDestroy')->name('pengajuans.massDestroy');
    Route::post('pengajuans/media', 'PengajuanController@storeMedia')->name('pengajuans.storeMedia');
    Route::post('pengajuans/ckmedia', 'PengajuanController@storeCKEditorImages')->name('pengajuans.storeCKEditorImages');
    Route::resource('pengajuans', 'PengajuanController');

    // pesanan Item
    Route::delete('pesananitems/destroy', 'PesananItemController@massDestroy')->name('pesananitems.massDestroy');
    Route::resource('pesananitems', 'PesananItemController');

    // pengirim
    Route::delete('pengirims/destroy', 'PengirimController@massDestroy')->name('pengirims.massDestroy');
    Route::resource('pengirims', 'PengirimController');

    // pengiriman
    Route::delete('pengirimans/destroy', 'PengirimanController@massDestroy')->name('pengirimans.massDestroy');
    Route::resource('pengirimans', 'PengirimanController');
    
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
