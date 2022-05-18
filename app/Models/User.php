<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Teacher\Teacher;
use App\Models\Academies\Academy;
use App\Models\Role;


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
        'name',
        'email',
        'password',
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


    public function hasAnyRoles($roles)
     {
         if($this->roles()->whereIn('name', $roles)->first()){
             return true ;
         }
         return false;
     }


    public function hasRole($role)
     {
         if( $this->roles()->where('name', $role)->first() )
         {
             return true ;
         }
             return false;
     }


     public function teachers(): hasMany
    {
        return $this->hasMany(Teacher::class, 'user_id', 'id');
    }


     public function academies(): hasMany
    {
        return $this->hasMany(Academy::class, 'user_id', 'id');
    }
     
}
