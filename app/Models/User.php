<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Filters\Filterable;
use App\Http\Filters\UserFilter;
use App\Http\Resources\UserResource;
use App\Traits\HasActivation;
use App\Traits\HasActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\InteractsWithMedia;
class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles,HasActivation,Filterable, HasActivityLog;

    use InteractsWithMedia;


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_images')->singleFile();
    }

    public function getProfileImageUrl()
    {
        return $this->getFirstMediaUrl('profile_images') ?: asset('assets-admin/assets/avatars/face-3.png');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        "phone",
        "role",
        "added_by_id",
        "is_active",
        "code",
        "expire_code"
    ];

    protected string $filter = UserFilter::class;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getResource(): UserResource
    {
        return new UserResource($this->fresh());
    }
}
