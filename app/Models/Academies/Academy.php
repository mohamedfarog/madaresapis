<?php

namespace App\Models\Academies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Academies\Branch;
use App\Models\User;


class Academy extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name' , 'website','contact_number' , 'contact_email' ,'bio' ];

    protected $hidden = ['updated_at'];


    public function user(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function branches(): hasMany
    {
        return $this->hasMany(Branch::class);
    }
}
