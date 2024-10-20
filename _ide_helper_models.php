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
 * @mixin IdeHelperAllergen
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Allergen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Allergen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Allergen query()
 * @method static \Illuminate\Database\Eloquent\Builder|Allergen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Allergen whereName($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkedMeal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkedMeal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkedMeal query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkedMeal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkedMeal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkedMeal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkedMeal whereUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookmarkedMeal whereUserId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|ConnectedAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConnectedAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConnectedAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConnectedAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConnectedAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConnectedAccount whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConnectedAccount whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConnectedAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConnectedAccount whereUserId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact withoutTrashed()
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
 * @method static \Illuminate\Database\Eloquent\Builder|Fact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fact whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fact whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fact whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fact whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fact whereReferences($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fact whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fact whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|FactCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FactCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FactCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|FactCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FactCategory whereName($value)
 */
	class FactCategory extends \Eloquent {}
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
 * @property mixed|null $password
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmergencyContact> $emergencyContacts
 * @property-read int|null $emergency_contacts_count
 * @property-read string $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAnonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|UserAllergen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAllergen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAllergen query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAllergen whereAllergenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAllergen whereUserId($value)
 */
	class UserAllergen extends \Eloquent {}
}

