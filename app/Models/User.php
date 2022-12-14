<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Teachers\Teacher;
use App\Models\Academies\Academy;
use App\Models\Role;
use App\Models\Locations;
use Illuminate\Database\Eloquent\Relations\HasOne;
//use App\Models\UserType;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'remember_token',
        'is_active',
        'is_verified'

    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',

    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function properties()
    {
        return $this->hasMany(Property::class, 'product_id', 'id');
    }

    public function hasAnyRoles($roles)
    {
        if ($this->roles()->whereIn('name', $roles)->first()) {
            return true;
        }
        return false;
    }
    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }
    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class, 'user_id', 'id');
    }
    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class, 'user_id', 'id');
    }
    public function academies(): HasMany
    {
        return $this->hasMany(Academy::class, 'user_id', 'id');
    }
    public function getFollowedataAttribute()
    {
        $followers = FollowData::where('following', $this->id)->get()->pluck('id');
        $following = FollowData::where('followers', $this->id)->get()->pluck('id');
        $data['followers'] = User::whereIn('id', $followers)->get();
        $data['following'] = User::whereIn('id', $following)->get();

        return $data;
    }
}
