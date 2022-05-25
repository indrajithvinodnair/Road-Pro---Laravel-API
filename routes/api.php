<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//importing custom controllers
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VehicleController;
use App\Http\Controllers\API\LicenceController;
use App\Http\Controllers\API\CrimeController;
use App\Http\Controllers\API\crimeandpunishmentController;
use App\Http\Controllers\API\traffic_crimesController;

//custom routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('validate-email', [AuthController::class, 'validateEmail']);
Route::get('validate-user/{id}', [AuthController::class, 'validateUser']);

Route::post('test', [AuthController::class, 'test']);
// no route with same url on mulitple middleware groups can not be accessed, will give errors


Route::middleware(['auth:sanctum', 'adminCheck'])->group(function () {

    Route::get('checkingauthenticated', function () {
        return response()->json(['message' => "successfull", 'status' => 200]);
    });
    // to list all civil users information
    Route::get('view-civil-users', [UserController::class, 'indexCivilan']);
    // to list all users except civilian users
    Route::get('view-users/{value}', [UserController::class, 'viewUsers']);

    // verify a civilan user 
    Route::get('verify-user/{id}', [UserController::class, 'verifyUser']);

    // add new user of offical capacity
    Route::post('add-user', [UserController::class, 'addUser']);
    // get user information
    Route::get('get-user/{id}', [UserController::class, 'getUser']);
    // update user information based on userId
    Route::post('update-user/{id}', [UserController::class, 'updateUser']);
    // delete a user from db
    Route::delete('delete-user/{id}', [UserController::class, 'deleteUser']);

    // get usercount 
    Route::get('get-user-count', [UserController::class, 'getUserCount']);

    // get license stats
    Route::get('get-license-stats', [UserController::class, 'getLicenseStats']);

    // get officals information
    Route::get('get-official-info/{id}', [UserController::class, 'getOfficialsInfo']);

    //update officals information
    Route::post('update-official-info/{id}', [UserController::class, 'updateOfficalsInfo']);

    //get all aadhar information of verifed users
    Route::get('get-aadhar-info', [UserController::class, 'getAadharInfo']);

    // register vehicle for verified user
    Route::post('register-vehicle-nonuser/{id}', [VehicleController::class, 'registerVehicle']);

    // display all vehicles information
    Route::get('view-vehicle/{id}', [VehicleController::class, 'getVehicle']);

    // verify a civilian vehicle for database
    Route::get('verify-vehicle/{id}', [VehicleController::class, 'verifyVehicle']);

    // get vehicle informaiton 
    Route::get('get-vehicle-info/{id}/{type}', [VehicleController::class, 'getVehicleInfo']);

    // get vehicle information for chart, vehicle count and types
    Route::get('get-vehicle-data', [VehicleController::class, 'getVehicleData']);

    // update vehicle information
    Route::post('update-vehicle-info/{id}/{type}', [VehicleController::class, 'updateVehicleInfo']);

    // delete a user from db
    Route::delete('delete-vehicle/{id}', [VehicleController::class, 'deleteVehicle']);

    // get vehicle owner Information
    Route::get('get-owner/{aadhar}', [UserController::class, 'getOwner']);

    // get licence count Information
    Route::get('get-lice-count', [LicenceController::class, 'getCount']);

    // get licence information 
    Route::get('get-lice-info/{id}', [LicenceController::class, 'getLicenceInfo']);

    // handle licence status 
    Route::get('handle-licence-status/{id}', [LicenceController::class, 'handleStatus']);
    // added a new comment
});

// api routes for normal user

Route::middleware(['auth:sanctum', 'userCheck'])->group(function () {

    Route::get('authCheckUser', function () {
        return response()->json(['message' => "successfull", 'status' => 200]);
    });
    Route::post('getProfile', [UserController::class, 'getProfile']);
    // update profile information
    Route::post('/user/updateProfile', [UserController::class, 'updateProfile']);
    // get vehicle information using username
    Route::get('get-vehicle-info/{userName}', [VehicleController::class, 'getUsersVehicle']);

    // update vehicle information
    Route::post('update-vehicle-info', [VehicleController::class, 'updateUserVehicleInfo']);

    // get users aadhar number from auth_name
    Route::get('get-user-aadhar/{userName}', [UserController::class, 'getUsersAadhar']);

    // register vehicle for verified user
    Route::post('register-vehicle-user/{id}', [VehicleController::class, 'registerVehicle']);
});

// api route for rto officers

Route::middleware(['auth:sanctum', 'rtoCheck'])->group(function () {

    Route::get('authCheckRto', function () {
        return response()->json(['message' => "successfull", 'status' => 200]);
    });
});

// api routes for traffic police 

Route::middleware(['auth:sanctum', 'trafficCheck'])->group(function () {

    Route::get('authCheckTraffic', function () {
        return response()->json(['message' => "successfull", 'status' => 200]);
    });

    // view crime info
    Route::get('get-crime-info/{crimeId}/', [crimeandpunishmentController::class, 'getCrimeInfo']);
    // update crime information
    Route::post('update-crime-info/{crimeId}', [crimeandpunishmentController::class, 'updateCrimeInfo']);
    // add new crime information
    Route::get('add-crime-info/{crimeId}', [crimeandpunishmentController::class, 'addCrime']);
    // to add new crime information 
    Route::post('add-crime-info/{infraction_id}', [crimeandpunishmentController::class, 'addCrime']);
    // view all added crime data traffic_crimes table
    Route::get('get-crime-data/{id}', [traffic_crimesController::class, 'getCrimeData']);
    // log a new crime 
    Route::post('log-crime-info', [traffic_crimesController::class, 'logCrime']);
    // change crime status
    Route::post('change-crime-status/{Id}', [traffic_crimesController::class, 'closeCrime']);
    // search a particular vehicle
    Route::get('search-vehicle-traffic/{criteria}/{item}', [VehicleController::class, 'searchVehicle']);
    // get infraction details
    Route::get('get-infractions',[traffic_crimesController::class, 'getInfractions']);
    // add a new traffic crime 
    Route::post('add-traffic-case',[traffic_crimesController::class, 'addTraficCase']);
    // rotue to delete infration
    Route::delete('delete-infraction/{id}',[traffic_crimesController::class, 'deleteInfractions']);
    // get vehicle information for chart, vehicle count and types
    Route::get('get-vehicle-data-traffic', [VehicleController::class, 'getVehicleData']);
    // get usercount 
    Route::get('get-user-count-traffic', [UserController::class, 'getUserCount']);
     // get usercount 
     Route::get('get-crime-stats-traffic', [traffic_crimesController::class, 'getcrimeStats']);

    // get license stats
    Route::get('get-license-stats-traffic', [UserController::class, 'getLicenseStats']);
});

// api route for civil police 

Route::middleware(['auth:sanctum', 'civilCheck'])->group(function () {

    Route::get('authCheckCivilPolice', function () {
        return response()->json(['message' => "successfull", 'status' => 200]);
    });
    // search a particular vehicle
    Route::get('search-vehicle/{criteria}/{item}', [VehicleController::class, 'searchVehicle']);
    // get officer information
    Route::get('get-official-details/{name}', [UserController::class, 'getOfficialsInfo_two']);
    // log a new theft
    Route::post('log-new-theft', [CrimeController::class, 'registerTheft']);
    // check if vehicle is logged or not
    Route::get('check-logged/{id}', [CrimeController::class, 'checkLogged']);
    // to get all case information
    Route::get('get-case-all/{id}', [CrimeController::class, 'indexCase']);
    // update case Status 
    Route::get('update-case-status/{id}', [CrimeController::class, 'updateTheftCaseStatus']);
    // get registered ownership
    Route::get('get-reg-owner/{aadhar}', [CrimeController::class, 'getRegOwner']);
    // get official owner
    Route::get('get-official-owner/{id}', [CrimeController::class, 'getOfficialOwner']);
    // register accident
    Route::post('log-new-accident/{type}', [CrimeController::class, 'registerAccident']);
    // get accident information, categorized by type of accident
    Route::get('get-accident-all/{type}', [CrimeController::class, 'indexAccident']);
    // get theft count
    Route::get('get-theft-count', [CrimeController::class, 'countTheft']);
    // get accidetn count
    Route::get('get-accident-count', [CrimeController::class, 'countAccident']);
    // search a particular vehicle
    Route::get('search-vehicle-case-based/{criteria}/{item}', [CrimeController::class, 'searchVehicleCases']);
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
