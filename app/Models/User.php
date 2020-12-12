<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password', 
        'username',
        'is_landlord',
        'profile_image',
        'krapin'       
    ];

     protected static function boot()
         {
             parent::boot();

             static::created(function ($user) {
                 $user->contact()->create([
                     'title' => $user->username,
                 ]);

                 Mail::to($user->email)->send(new NewUserWelcomeMail());
             });
         }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_landlord' => 'boolean',
        'is_admin'=>'boolean'
    ];

    public function houses()
    {
        return $this->hasMany('App\Models\House');
    }
    public function agents()
    {
         return $this->hasMany('App\Models\Agent');
    }
    public function contact(){
        return $this->hasOne('App\Models\Contact');
    }
}
