<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $alarms
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alarm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alarm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alarm query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alarm whereAlarms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alarm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alarm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alarm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Alarm whereUserId($value)
 */
	class Alarm extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @mixin IdeHelperAllergen
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Food> $foods
 * @property-read int|null $foods_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Allergen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Allergen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Allergen query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Allergen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Allergen whereName($value)
 */
	class Allergen extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $uri
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookmarkedMeal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookmarkedMeal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookmarkedMeal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookmarkedMeal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookmarkedMeal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookmarkedMeal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookmarkedMeal whereUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookmarkedMeal whereUserId($value)
 */
	class BookmarkedMeal extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $provider
 * @property string $provider_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConnectedAccount whereUserId($value)
 */
	class ConnectedAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $full_name
 * @property string $relationship
 * @property string $phone_number
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact whereRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmergencyContact withoutTrashed()
 */
	class EmergencyContact extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $author_id
 * @property int $category_id
 * @property string $title
 * @property string $description
 * @property string|null $cover_image
 * @property string|null $references
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $author
 * @property-read \App\Models\FactCategory $category
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fact query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fact whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fact whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fact whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fact whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fact whereReferences($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fact whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Fact whereUpdatedAt($value)
 */
	class Fact extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Fact> $facts
 * @property-read int|null $facts_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FactCategory whereName($value)
 */
	class FactCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $food_id
 * @property string $display_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Allergen> $allergens
 * @property-read int|null $allergens_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereFoodId($value)
 */
	class Food extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $food_id
 * @property int $allergen_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodAllergen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodAllergen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodAllergen query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodAllergen whereAllergenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodAllergen whereFoodId($value)
 */
	class FoodAllergen extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $token
 * @property int $user_id
 * @property string $expires_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResetPasswordTicket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResetPasswordTicket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResetPasswordTicket query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResetPasswordTicket whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResetPasswordTicket whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ResetPasswordTicket whereUserId($value)
 */
	class ResetPasswordTicket extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @mixin IdeHelperUser
 * @property int $id
 * @property string|null $anon_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $email
 * @property string|null $password
 * @property string|null $avatar
 * @property string|null $birthday
 * @property string|null $phone_number
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Allergen> $allergens
 * @property-read int|null $allergens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookmarkedMeal> $bookmarkedMeals
 * @property-read int|null $bookmarked_meals_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ConnectedAccount> $connectedAccounts
 * @property-read int|null $connected_accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmergencyContact> $emergencyContacts
 * @property-read int|null $emergency_contacts_count
 * @property-read string $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAnonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @mixin IdeHelperUserAllergen
 * @property int $user_id
 * @property int $allergen_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAllergen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAllergen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAllergen query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAllergen whereAllergenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAllergen whereUserId($value)
 */
	class UserAllergen extends \Eloquent {}
}

