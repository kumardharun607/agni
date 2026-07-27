<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ProfileController;

// Masters (all ported from dharun_agni, folder structure unchanged)
use App\Http\Controllers\Country\CountryController;
use App\Http\Controllers\State\StateController;
use App\Http\Controllers\City\CityController;
use App\Http\Controllers\Pincode\PincodeController;
use App\Http\Controllers\Dealer\DealerController;
use App\Http\Controllers\DealerMapping\DealerMappingController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\PermissionDropdown\PermissionDropdownController;
use App\Http\Controllers\SalesStage\SalesStageController;
use App\Http\Controllers\Brand\BrandController;
use App\Http\Controllers\FloorStage\FloorStageController;
use App\Http\Controllers\BuildingStage\BuildingStageController;
use App\Http\Controllers\DealerRegistration\DealerRegistrationController;


// Masters (ported from sharvin_agni, folder structure unchanged)
use App\Http\Controllers\ScrapDistributor\ScrapDistributorController;
use App\Http\Controllers\ScrapDistributor\ScrapDistributorImportController;
use App\Http\Controllers\ScrapSeller\ScrapSellerController;
use App\Http\Controllers\ScrapSeller\ScrapSellerImportController;
use App\Http\Controllers\BdeHomeLocation\BdeHomeLocationController;
use App\Http\Controllers\BdeHomeLocation\BdeHomeLocationImportController;
use App\Http\Controllers\SoHomeLocation\SoHomeLocationController;
use App\Http\Controllers\SoHomeLocation\SoHomeLocationImportController;

// Settings
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Permission\PermissionController;

Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| Guest
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

/*
|--------------------------------------------------------------------------
| Authenticated
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |----------------------------------------------------------------------
    | Masters -> Countries / States / Cities / Pincodes  (dharun_agni)
    |----------------------------------------------------------------------
    */
    Route::middleware('permission:Countries,view')->group(function () {
        Route::get('countries', [CountryController::class, 'index'])->name('countries.index');
        Route::get('countries-data', [CountryController::class, 'data'])->name('countries.data');
        Route::get('countries/export', [CountryController::class, 'export'])->name('countries.export');
    });
    Route::middleware('permission:Countries,add')->group(function () {
        Route::get('countries/create', [CountryController::class, 'create'])->name('countries.create');
        Route::post('countries', [CountryController::class, 'store'])->name('countries.store');
        Route::get('countries/import', [CountryController::class, 'importForm'])->name('countries.import');
        Route::post('countries/import', [CountryController::class, 'import'])->name('countries.import.store');
    });
    Route::middleware('permission:Countries,edit')->group(function () {
        Route::get('countries/{country}/edit', [CountryController::class, 'edit'])->name('countries.edit');
        Route::put('countries/{country}', [CountryController::class, 'update'])->name('countries.update');
    });
    Route::delete('countries/{country}', [CountryController::class, 'destroy'])->name('countries.destroy')->middleware('permission:Countries,delete');

    Route::middleware('permission:States,view')->group(function () {
        Route::get('states', [StateController::class, 'index'])->name('states.index');
        Route::get('states-data', [StateController::class, 'data'])->name('states.data');
        Route::get('states/export', [StateController::class, 'export'])->name('states.export');
    });
    Route::middleware('permission:States,add')->group(function () {
        Route::get('states/create', [StateController::class, 'create'])->name('states.create');
        Route::post('states', [StateController::class, 'store'])->name('states.store');
        Route::get('states/import', [StateController::class, 'importForm'])->name('states.import');
        Route::post('states/import', [StateController::class, 'import'])->name('states.import.store');
    });
    Route::middleware('permission:States,edit')->group(function () {
        Route::get('states/{state}/edit', [StateController::class, 'edit'])->name('states.edit');
        Route::put('states/{state}', [StateController::class, 'update'])->name('states.update');
    });
    Route::delete('states/{state}', [StateController::class, 'destroy'])->name('states.destroy')->middleware('permission:States,delete');

    Route::middleware('permission:Cities,view')->group(function () {
        Route::get('cities', [CityController::class, 'index'])->name('cities.index');
        Route::get('cities-data', [CityController::class, 'data'])->name('cities.data');
        Route::get('cities/export', [CityController::class, 'export'])->name('cities.export');
    });
    Route::middleware('permission:Cities,add')->group(function () {
        Route::get('cities/create', [CityController::class, 'create'])->name('cities.create');
        Route::post('cities', [CityController::class, 'store'])->name('cities.store');
        Route::get('cities/import', [CityController::class, 'importForm'])->name('cities.import');
        Route::post('cities/import', [CityController::class, 'import'])->name('cities.import.store');
    });
    Route::middleware('permission:Cities,edit')->group(function () {
        Route::get('cities/{city}/edit', [CityController::class, 'edit'])->name('cities.edit');
        Route::put('cities/{city}', [CityController::class, 'update'])->name('cities.update');
    });
    Route::delete('cities/{city}', [CityController::class, 'destroy'])->name('cities.destroy')->middleware('permission:Cities,delete');

    Route::middleware('permission:Pincodes,view')->group(function () {
        Route::get('pincodes', [PincodeController::class, 'index'])->name('pincodes.index');
        Route::get('pincodes-data', [PincodeController::class, 'data'])->name('pincodes.data');
        Route::get('pincodes/export', [PincodeController::class, 'export'])->name('pincodes.export');
    });
    Route::middleware('permission:Pincodes,add')->group(function () {
        Route::get('pincodes/create', [PincodeController::class, 'create'])->name('pincodes.create');
        Route::post('pincodes', [PincodeController::class, 'store'])->name('pincodes.store');
        Route::get('pincodes/import', [PincodeController::class, 'importForm'])->name('pincodes.import');
        Route::post('pincodes/import', [PincodeController::class, 'import'])->name('pincodes.import.store');
    });
    Route::middleware('permission:Pincodes,edit')->group(function () {
        Route::get('pincodes/{pincode}/edit', [PincodeController::class, 'edit'])->name('pincodes.edit');
        Route::put('pincodes/{pincode}', [PincodeController::class, 'update'])->name('pincodes.update');
    });
    Route::delete('pincodes/{pincode}', [PincodeController::class, 'destroy'])->name('pincodes.destroy')->middleware('permission:Pincodes,delete');

    // cascading location dropdown endpoints (used on Dealer & User forms)
    Route::get('ajax/states/{country}', [DealerController::class, 'statesByCountry'])->name('ajax.states');
    Route::get('ajax/cities/{state}', [DealerController::class, 'citiesByState'])->name('ajax.cities');
    Route::get('ajax/pincodes/{city}', [DealerController::class, 'pincodesByCity'])->name('ajax.pincodes');

    /*
    |----------------------------------------------------------------------
    | Masters -> Dealers / Dealer Mapping / View Hierarchy (dharun_agni)
    |----------------------------------------------------------------------
    */
    Route::middleware('permission:Dealer,view')->group(function () {
        Route::get('dealers', [DealerController::class, 'index'])->name('dealers.index');
        Route::get('dealers-data', [DealerController::class, 'data'])->name('dealers.data');
        Route::get('dealers/export', [DealerController::class, 'export'])->name('dealers.export');
        Route::get('dealers/{dealer}/view', [DealerController::class, 'show'])->name('dealers.show');
    });
    Route::middleware('permission:Dealer,add')->group(function () {
        Route::get('dealers/create', [DealerController::class, 'create'])->name('dealers.create');
        Route::post('dealers', [DealerController::class, 'store'])->name('dealers.store');
        Route::get('dealers/import', [DealerController::class, 'importForm'])->name('dealers.import');
        Route::post('dealers/import', [DealerController::class, 'import'])->name('dealers.import.store');
    });
    Route::middleware('permission:Dealer,edit')->group(function () {
        Route::get('dealers/{dealer}/edit', [DealerController::class, 'edit'])->name('dealers.edit');
        Route::put('dealers/{dealer}', [DealerController::class, 'update'])->name('dealers.update');
    });
    Route::delete('dealers/{dealer}', [DealerController::class, 'destroy'])->name('dealers.destroy')->middleware('permission:Dealer,delete');

    Route::middleware('permission:Mapping,view')->group(function () {
        Route::get('dealer-mapping', [DealerMappingController::class, 'index'])->name('dealer-mapping.index');
        Route::get('dealer-mapping-data', [DealerMappingController::class, 'data'])->name('dealer-mapping.data');
        Route::get('dealer-mapping/export', [DealerMappingController::class, 'export'])->name('dealer-mapping.export');
        Route::get('dealer-mapping/hierarchy/view', [DealerMappingController::class, 'hierarchy'])->name('dealer-mapping.hierarchy');
        Route::get('dealer-mapping/{dealer_mapping}/view', [DealerMappingController::class, 'show'])->name('dealer-mapping.show');
    });
    Route::middleware('permission:Mapping,add')->group(function () {
        Route::get('dealer-mapping/create', [DealerMappingController::class, 'create'])->name('dealer-mapping.create');
        Route::post('dealer-mapping', [DealerMappingController::class, 'store'])->name('dealer-mapping.store');
        Route::get('dealer-mapping/import', [DealerMappingController::class, 'importForm'])->name('dealer-mapping.import');
        Route::post('dealer-mapping/import', [DealerMappingController::class, 'import'])->name('dealer-mapping.import.store');
        Route::get('dealer-mapping/hierarchy/map', [DealerMappingController::class, 'mapUserForm'])->name('dealer-mapping.map-user');
        Route::post('dealer-mapping/hierarchy/map', [DealerMappingController::class, 'mapUserStore'])->name('dealer-mapping.map-user.store');
    });
    Route::middleware('permission:Mapping,edit')->group(function () {
        Route::get('dealer-mapping/{dealer_mapping}/edit', [DealerMappingController::class, 'edit'])->name('dealer-mapping.edit');
        Route::put('dealer-mapping/{dealer_mapping}', [DealerMappingController::class, 'update'])->name('dealer-mapping.update');
    });
    Route::delete('dealer-mapping/{dealer_mapping}', [DealerMappingController::class, 'destroy'])->name('dealer-mapping.destroy')->middleware('permission:Mapping,delete');

    /*
    |----------------------------------------------------------------------
    | Masters -> Users (dharun_agni)
    |----------------------------------------------------------------------
    */
    Route::middleware('permission:Users,view')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users-data', [UserController::class, 'data'])->name('users.data');
        Route::get('users/export', [UserController::class, 'export'])->name('users.export');
        Route::get('users/{user}/view', [UserController::class, 'show'])->name('users.show');
    });
    Route::middleware('permission:Users,add')->group(function () {
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users/import', [UserController::class, 'importForm'])->name('users.import');
        Route::post('users/import', [UserController::class, 'import'])->name('users.import.store');
    });
    Route::middleware('permission:Users,edit')->group(function () {
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    });
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:Users,delete');

    /*
    |----------------------------------------------------------------------
    | Masters -> Permission Dropdown (dharun_agni)
    |----------------------------------------------------------------------
    */
    Route::middleware('permission:Permission Dropdown,view')->group(function () {
        Route::get('permission-dropdown', [PermissionDropdownController::class, 'index'])->name('permission-dropdown.index');
        Route::get('permission-dropdown-data', [PermissionDropdownController::class, 'data'])->name('permission-dropdown.data');
        Route::get('permission-dropdown/export', [PermissionDropdownController::class, 'export'])->name('permission-dropdown.export');
        Route::get('permission-dropdown/{permission_dropdown}/view', [PermissionDropdownController::class, 'show'])->name('permission-dropdown.show');
    });
    Route::middleware('permission:Permission Dropdown,add')->group(function () {
        Route::get('permission-dropdown/create', [PermissionDropdownController::class, 'create'])->name('permission-dropdown.create');
        Route::post('permission-dropdown', [PermissionDropdownController::class, 'store'])->name('permission-dropdown.store');
        Route::get('permission-dropdown/import', [PermissionDropdownController::class, 'importForm'])->name('permission-dropdown.import');
        Route::post('permission-dropdown/import', [PermissionDropdownController::class, 'import'])->name('permission-dropdown.import.store');
    });
    Route::middleware('permission:Permission Dropdown,edit')->group(function () {
        Route::get('permission-dropdown/{permission_dropdown}/edit', [PermissionDropdownController::class, 'edit'])->name('permission-dropdown.edit');
        Route::put('permission-dropdown/{permission_dropdown}', [PermissionDropdownController::class, 'update'])->name('permission-dropdown.update');
    });
    Route::delete('permission-dropdown/{permission_dropdown}', [PermissionDropdownController::class, 'destroy'])->name('permission-dropdown.destroy')->middleware('permission:Permission Dropdown,delete');

    /*
    |----------------------------------------------------------------------
    | Masters -> Sales Stage (dharun_agni)
    |----------------------------------------------------------------------
    */
    Route::middleware('permission:Sales Stage,view')->group(function () {
        Route::get('sales-stage', [SalesStageController::class, 'index'])->name('sales-stage.index');
        Route::get('sales-stage-data', [SalesStageController::class, 'data'])->name('sales-stage.data');
        Route::get('sales-stage/export', [SalesStageController::class, 'export'])->name('sales-stage.export');
        Route::get('sales-stage/{sales_stage}/view', [SalesStageController::class, 'show'])->name('sales-stage.show');
    });
    Route::middleware('permission:Sales Stage,add')->group(function () {
        Route::get('sales-stage/create', [SalesStageController::class, 'create'])->name('sales-stage.create');
        Route::post('sales-stage', [SalesStageController::class, 'store'])->name('sales-stage.store');
        Route::get('sales-stage/import', [SalesStageController::class, 'importForm'])->name('sales-stage.import');
        Route::post('sales-stage/import', [SalesStageController::class, 'import'])->name('sales-stage.import.store');
    });
    Route::middleware('permission:Sales Stage,edit')->group(function () {
        Route::get('sales-stage/{sales_stage}/edit', [SalesStageController::class, 'edit'])->name('sales-stage.edit');
        Route::put('sales-stage/{sales_stage}', [SalesStageController::class, 'update'])->name('sales-stage.update');
    });
    Route::delete('sales-stage/{sales_stage}', [SalesStageController::class, 'destroy'])->name('sales-stage.destroy')->middleware('permission:Sales Stage,delete');

    /*
    |----------------------------------------------------------------------
    | Masters -> Scrap Distributor / Scrap Seller / BDE / SO (sharvin_agni)
    |----------------------------------------------------------------------
    */
    Route::get('scrap-distributors/import', [ScrapDistributorImportController::class, 'index'])->name('scrap-distributors.import')->middleware('permission:ScrapDistributor,add');
    Route::post('scrap-distributors/import', [ScrapDistributorImportController::class, 'store'])->name('scrap-distributors.import.store')->middleware('permission:ScrapDistributor,add');
    Route::get('scrap-distributors/export', [ScrapDistributorImportController::class, 'export'])->name('scrap-distributors.export')->middleware('permission:ScrapDistributor,view');
    Route::resource('scrap-distributors', ScrapDistributorController::class)->middleware([
        'index' => 'permission:ScrapDistributor,view',
        'show' => 'permission:ScrapDistributor,view',
        'create' => 'permission:ScrapDistributor,add',
        'store' => 'permission:ScrapDistributor,add',
        'edit' => 'permission:ScrapDistributor,edit',
        'update' => 'permission:ScrapDistributor,edit',
        'destroy' => 'permission:ScrapDistributor,delete',
    ]);

    Route::get('scrap-sellers/import', [ScrapSellerImportController::class, 'index'])->name('scrap-sellers.import')->middleware('permission:ScrapSeller,add');
    Route::post('scrap-sellers/import', [ScrapSellerImportController::class, 'store'])->name('scrap-sellers.import.store')->middleware('permission:ScrapSeller,add');
    Route::get('scrap-sellers/export', [ScrapSellerImportController::class, 'export'])->name('scrap-sellers.export')->middleware('permission:ScrapSeller,view');
    Route::resource('scrap-sellers', ScrapSellerController::class)->middleware([
        'index' => 'permission:ScrapSeller,view',
        'show' => 'permission:ScrapSeller,view',
        'create' => 'permission:ScrapSeller,add',
        'store' => 'permission:ScrapSeller,add',
        'edit' => 'permission:ScrapSeller,edit',
        'update' => 'permission:ScrapSeller,edit',
        'destroy' => 'permission:ScrapSeller,delete',
    ]);

    Route::get('bde-home-locations/import', [BdeHomeLocationImportController::class, 'index'])->name('bde-home-locations.import')->middleware('permission:BdeHomeLocation,add');
    Route::post('bde-home-locations/import', [BdeHomeLocationImportController::class, 'store'])->name('bde-home-locations.import.store')->middleware('permission:BdeHomeLocation,add');
    Route::get('bde-home-locations/export', [BdeHomeLocationImportController::class, 'export'])->name('bde-home-locations.export')->middleware('permission:BdeHomeLocation,view');
    Route::resource('bde-home-locations', BdeHomeLocationController::class)->middleware([
        'index' => 'permission:BdeHomeLocation,view',
        'show' => 'permission:BdeHomeLocation,view',
        'create' => 'permission:BdeHomeLocation,add',
        'store' => 'permission:BdeHomeLocation,add',
        'edit' => 'permission:BdeHomeLocation,edit',
        'update' => 'permission:BdeHomeLocation,edit',
        'destroy' => 'permission:BdeHomeLocation,delete',
    ]);

    Route::get('so-home-locations/import', [SoHomeLocationImportController::class, 'index'])->name('so-home-locations.import')->middleware('permission:SoHomeLocation,add');
    Route::post('so-home-locations/import', [SoHomeLocationImportController::class, 'store'])->name('so-home-locations.import.store')->middleware('permission:SoHomeLocation,add');
    Route::get('so-home-locations/export', [SoHomeLocationImportController::class, 'export'])->name('so-home-locations.export')->middleware('permission:SoHomeLocation,view');
    Route::resource('so-home-locations', SoHomeLocationController::class)->middleware([
        'index' => 'permission:SoHomeLocation,view',
        'show' => 'permission:SoHomeLocation,view',
        'create' => 'permission:SoHomeLocation,add',
        'store' => 'permission:SoHomeLocation,add',
        'edit' => 'permission:SoHomeLocation,edit',
        'update' => 'permission:SoHomeLocation,edit',
        'destroy' => 'permission:SoHomeLocation,delete',
    ]);

    /*
    |----------------------------------------------------------------------
    | Settings -> Roles / Permissions (dharun_agni workflow)
    |----------------------------------------------------------------------
    */
    Route::middleware('permission:Roles,view')->group(function () {
        Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('roles-data', [RoleController::class, 'data'])->name('roles.data');
        Route::get('roles/export', [RoleController::class, 'export'])->name('roles.export')->middleware('permission:Roles,export');
    });
    Route::middleware('permission:Roles,add')->group(function () {
        Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('roles/import', [RoleController::class, 'importForm'])->name('roles.import')->middleware('permission:Roles,import');
        Route::post('roles/import', [RoleController::class, 'import'])->name('roles.import.store')->middleware('permission:Roles,import');
    });
    Route::middleware('permission:Roles,edit')->group(function () {
        Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    });
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:Roles,delete');

    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:Permissions,view');
        Route::get('/{role}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('permission:Permissions,edit');
        Route::put('/{role}', [PermissionController::class, 'update'])->name('permissions.update')->middleware('permission:Permissions,edit');
    });


    /*
    |----------------------------------------------------------------------
    | Masters -> Brands / Floor Stage / Building Stage / Dealer Registration (selva)
    |----------------------------------------------------------------------
    */
    Route::middleware('permission:Brands,view')->group(function () {
        Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('brands-data', [BrandController::class, 'data'])->name('brands.data');
        Route::get('brands/export', [BrandController::class, 'export'])->name('brands.export');
        Route::get('brands/{brand}/view', [BrandController::class, 'show'])->name('brands.show');
    });
    Route::middleware('permission:Brands,add')->group(function () {
        Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
        Route::get('brands/import', [BrandController::class, 'importForm'])->name('brands.import');
        Route::post('brands/import', [BrandController::class, 'import'])->name('brands.import.store');
    });
    Route::middleware('permission:Brands,edit')->group(function () {
        Route::get('brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    });
    Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy')->middleware('permission:Brands,delete');

    Route::middleware('permission:Floor Stage,view')->group(function () {
        Route::get('floor-stages', [FloorStageController::class, 'index'])->name('floor-stages.index');
        Route::get('floor-stages-data', [FloorStageController::class, 'data'])->name('floor-stages.data');
        Route::get('floor-stages/export', [FloorStageController::class, 'export'])->name('floor-stages.export');
        Route::get('floor-stages/{floor_stage}/view', [FloorStageController::class, 'show'])->name('floor-stages.show');
    });
    Route::middleware('permission:Floor Stage,add')->group(function () {
        Route::get('floor-stages/create', [FloorStageController::class, 'create'])->name('floor-stages.create');
        Route::post('floor-stages', [FloorStageController::class, 'store'])->name('floor-stages.store');
        Route::get('floor-stages/import', [FloorStageController::class, 'importForm'])->name('floor-stages.import');
        Route::post('floor-stages/import', [FloorStageController::class, 'import'])->name('floor-stages.import.store');
    });
    Route::middleware('permission:Floor Stage,edit')->group(function () {
        Route::get('floor-stages/{floor_stage}/edit', [FloorStageController::class, 'edit'])->name('floor-stages.edit');
        Route::put('floor-stages/{floor_stage}', [FloorStageController::class, 'update'])->name('floor-stages.update');
    });
    Route::delete('floor-stages/{floor_stage}', [FloorStageController::class, 'destroy'])->name('floor-stages.destroy')->middleware('permission:Floor Stage,delete');

    Route::middleware('permission:Building Stage,view')->group(function () {
        Route::get('building-stages', [BuildingStageController::class, 'index'])->name('building-stages.index');
        Route::get('building-stages-data', [BuildingStageController::class, 'data'])->name('building-stages.data');
        Route::get('building-stages/export', [BuildingStageController::class, 'export'])->name('building-stages.export');
        Route::get('building-stages/{building_stage}/view', [BuildingStageController::class, 'show'])->name('building-stages.show');
    });
    Route::middleware('permission:Building Stage,add')->group(function () {
        Route::get('building-stages/create', [BuildingStageController::class, 'create'])->name('building-stages.create');
        Route::post('building-stages', [BuildingStageController::class, 'store'])->name('building-stages.store');
        Route::get('building-stages/import', [BuildingStageController::class, 'importForm'])->name('building-stages.import');
        Route::post('building-stages/import', [BuildingStageController::class, 'import'])->name('building-stages.import.store');
    });
    Route::middleware('permission:Building Stage,edit')->group(function () {
        Route::get('building-stages/{building_stage}/edit', [BuildingStageController::class, 'edit'])->name('building-stages.edit');
        Route::put('building-stages/{building_stage}', [BuildingStageController::class, 'update'])->name('building-stages.update');
    });
    Route::delete('building-stages/{building_stage}', [BuildingStageController::class, 'destroy'])->name('building-stages.destroy')->middleware('permission:Building Stage,delete');

    // Static paths first so they are not swallowed by {dealerRegistration}
    Route::get('dealer-registrations/datatable', [DealerRegistrationController::class, 'datatable'])->name('dealer-registrations.datatable')->middleware('permission:Dealer Registration,view');
    Route::get('dealer-registrations/export', [DealerRegistrationController::class, 'export'])->name('dealer-registrations.export')->middleware('permission:Dealer Registration,view');
    Route::get('dealer-registrations/create', [DealerRegistrationController::class, 'create'])->name('dealer-registrations.create')->middleware('permission:Dealer Registration,add');
    Route::get('dealer-registrations/import', [DealerRegistrationController::class, 'importForm'])->name('dealer-registrations.import')->middleware('permission:Dealer Registration,add');
    Route::post('dealer-registrations/import', [DealerRegistrationController::class, 'import'])->name('dealer-registrations.import.store')->middleware('permission:Dealer Registration,add');
    Route::get('dealer-registrations', [DealerRegistrationController::class, 'index'])->name('dealer-registrations.index')->middleware('permission:Dealer Registration,view');
    Route::post('dealer-registrations', [DealerRegistrationController::class, 'store'])->name('dealer-registrations.store')->middleware('permission:Dealer Registration,add');
    Route::get('dealer-registrations/{dealerRegistration}/edit', [DealerRegistrationController::class, 'edit'])->name('dealer-registrations.edit')->middleware('permission:Dealer Registration,edit');
    Route::get('dealer-registrations/{dealerRegistration}/pdf', [DealerRegistrationController::class, 'pdf'])->name('dealer-registrations.pdf')->middleware('permission:Dealer Registration,view');
    Route::get('dealer-registrations/{dealerRegistration}', [DealerRegistrationController::class, 'show'])->name('dealer-registrations.show')->middleware('permission:Dealer Registration,view');
    Route::put('dealer-registrations/{dealerRegistration}', [DealerRegistrationController::class, 'update'])->name('dealer-registrations.update')->middleware('permission:Dealer Registration,edit');
    Route::delete('dealer-registrations/{dealerRegistration}', [DealerRegistrationController::class, 'destroy'])->name('dealer-registrations.destroy')->middleware('permission:Dealer Registration,delete');


    /*
    |----------------------------------------------------------------------
    | Profile & Logout
    |----------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
