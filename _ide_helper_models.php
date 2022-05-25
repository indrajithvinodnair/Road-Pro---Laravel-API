<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $uId
 * @property string $userName
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int $userRole
 * @property int $userStatus
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserStatus($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\accidentdocs
 *
 * @property int $accidentId
 * @property string $accidentPic1
 * @property string $accidentPic2
 * @method static \Illuminate\Database\Eloquent\Builder|accidentdocs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|accidentdocs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|accidentdocs query()
 * @method static \Illuminate\Database\Eloquent\Builder|accidentdocs whereAccidentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentdocs whereAccidentPic1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentdocs whereAccidentPic2($value)
 */
	class accidentdocs extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\accidentinfo
 *
 * @property int $accidentId
 * @property int $vehicleID
 * @property int $officerId
 * @property string $date
 * @property string $cause
 * @property string $place
 * @property string $primaryInfo
 * @property int $accidentType
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|accidentinfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|accidentinfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|accidentinfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|accidentinfo whereAccidentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentinfo whereAccidentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentinfo whereCause($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentinfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentinfo whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentinfo whereOfficerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentinfo wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentinfo wherePrimaryInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentinfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentinfo whereVehicleID($value)
 */
	class accidentinfo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\accidentpersonparty
 *
 * @property int $accidentId
 * @property string $victimFirstName
 * @property string $victimLastName
 * @property int $victimAge
 * @property string $damage
 * @method static \Illuminate\Database\Eloquent\Builder|accidentpersonparty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|accidentpersonparty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|accidentpersonparty query()
 * @method static \Illuminate\Database\Eloquent\Builder|accidentpersonparty whereAccidentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentpersonparty whereDamage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentpersonparty whereVictimAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentpersonparty whereVictimFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentpersonparty whereVictimLastName($value)
 */
	class accidentpersonparty extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\accidentvehicleparty
 *
 * @property int $accidentId
 * @property string $plateNo
 * @property string $ownerFirst
 * @property string $ownerLast
 * @property string $damage
 * @method static \Illuminate\Database\Eloquent\Builder|accidentvehicleparty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|accidentvehicleparty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|accidentvehicleparty query()
 * @method static \Illuminate\Database\Eloquent\Builder|accidentvehicleparty whereAccidentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentvehicleparty whereDamage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentvehicleparty whereOwnerFirst($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentvehicleparty whereOwnerLast($value)
 * @method static \Illuminate\Database\Eloquent\Builder|accidentvehicleparty wherePlateNo($value)
 */
	class accidentvehicleparty extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\crimeandpunishment
 *
 * @property int $infraction_id
 * @property string $punishment_type
 * @property int $punishment_amount
 * @property string $infraction_name
 * @method static \Illuminate\Database\Eloquent\Builder|crimeandpunishment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|crimeandpunishment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|crimeandpunishment query()
 * @method static \Illuminate\Database\Eloquent\Builder|crimeandpunishment whereInfractionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|crimeandpunishment whereInfractionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|crimeandpunishment wherePunishmentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|crimeandpunishment wherePunishmentType($value)
 */
	class crimeandpunishment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\officialsinfo
 *
 * @property int $uId
 * @property string $firstName
 * @property string $lastName
 * @property string $jurisdiction
 * @property string $station
 * @property string $phone
 * @method static \Illuminate\Database\Eloquent\Builder|officialsinfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|officialsinfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|officialsinfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|officialsinfo whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|officialsinfo whereJurisdiction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|officialsinfo whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|officialsinfo wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|officialsinfo whereStation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|officialsinfo whereUId($value)
 */
	class officialsinfo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\officialvehicles
 *
 * @property int $vehicleID
 * @property string $ownership
 * @property string $vehicleUsage
 * @method static \Illuminate\Database\Eloquent\Builder|officialvehicles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|officialvehicles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|officialvehicles query()
 * @method static \Illuminate\Database\Eloquent\Builder|officialvehicles whereOwnership($value)
 * @method static \Illuminate\Database\Eloquent\Builder|officialvehicles whereVehicleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|officialvehicles whereVehicleUsage($value)
 */
	class officialvehicles extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\theftInformation
 *
 * @property int $crimeId
 * @property int $officerId
 * @property int $vehicleID
 * @property string $reportDate
 * @property int $crimeStatus
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|theftInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|theftInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|theftInformation query()
 * @method static \Illuminate\Database\Eloquent\Builder|theftInformation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|theftInformation whereCrimeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|theftInformation whereCrimeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|theftInformation whereOfficerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|theftInformation whereReportDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|theftInformation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|theftInformation whereVehicleID($value)
 */
	class theftInformation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\traffic_crimes
 *
 * @property int $Id
 * @property int $infraction_id
 * @property string $date_issued
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int $status
 * @property int $vehicle_id
 * @property int $officer_id
 * @property string $Aadhar
 * @method static \Illuminate\Database\Eloquent\Builder|traffic_crimes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|traffic_crimes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|traffic_crimes query()
 * @method static \Illuminate\Database\Eloquent\Builder|traffic_crimes whereAadhar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|traffic_crimes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|traffic_crimes whereDateIssued($value)
 * @method static \Illuminate\Database\Eloquent\Builder|traffic_crimes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|traffic_crimes whereInfractionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|traffic_crimes whereOfficerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|traffic_crimes whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|traffic_crimes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|traffic_crimes whereVehicleId($value)
 */
	class traffic_crimes extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\userbasicinfo
 *
 * @property int $uId
 * @property string $firstName
 * @property string $lastName
 * @property string $aadharNo
 * @property string $dob
 * @property string $gender
 * @property string $phone
 * @property string $address
 * @property int $pinCode
 * @property string $state
 * @method static \Illuminate\Database\Eloquent\Builder|userbasicinfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|userbasicinfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|userbasicinfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|userbasicinfo whereAadharNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userbasicinfo whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userbasicinfo whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userbasicinfo whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userbasicinfo whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userbasicinfo whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userbasicinfo wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userbasicinfo wherePinCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userbasicinfo whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userbasicinfo whereUId($value)
 */
	class userbasicinfo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\userlicenceinfo
 *
 * @property int $uId
 * @property string $licenceNo
 * @property int $licenceStatus
 * @method static \Illuminate\Database\Eloquent\Builder|userlicenceinfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|userlicenceinfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|userlicenceinfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|userlicenceinfo whereLicenceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userlicenceinfo whereLicenceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|userlicenceinfo whereUId($value)
 */
	class userlicenceinfo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\vehicledocs
 *
 * @property int $vehicleID
 * @property string $vehicleFront
 * @property string $vehicleRear
 * @property string $vehicleSideLeft
 * @property string $vehicleSideRight
 * @method static \Illuminate\Database\Eloquent\Builder|vehicledocs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|vehicledocs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|vehicledocs query()
 * @method static \Illuminate\Database\Eloquent\Builder|vehicledocs whereVehicleFront($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicledocs whereVehicleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicledocs whereVehicleRear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicledocs whereVehicleSideLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicledocs whereVehicleSideRight($value)
 */
	class vehicledocs extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\vehicleinformation
 *
 * @property int $vehicleID
 * @property string|null $aadharNo
 * @property string $plateNumber
 * @property string $engineNumber
 * @property string $regDate
 * @property string $manDate
 * @property string $chasisNumber
 * @property string $modelName
 * @property string $vechicleCategory
 * @property string $subCategory
 * @property string $emissionCategory
 * @property int $seatingCapacity
 * @property int $standingCapacity
 * @property int $cyclinderCount
 * @property string $fuelType
 * @property string $color
 * @property int $vehicleAccess
 * @property int $vechicleStatus
 * @property int $vehicleCost
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation query()
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereAadharNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereChasisNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereCyclinderCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereEmissionCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereEngineNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereFuelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereManDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereModelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation wherePlateNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereRegDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereSeatingCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereStandingCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereSubCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereVechicleCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereVechicleStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereVehicleAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereVehicleCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|vehicleinformation whereVehicleID($value)
 */
	class vehicleinformation extends \Eloquent {}
}

