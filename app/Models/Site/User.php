<?php

namespace App\Models\Site;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'type', 'ip', 'last_login', 'provider', 'provider_id', 'activated', 'activation_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function individual()
    {
        return $this->hasOne('App\Models\Site\Individual');
    }

    public function company()
    {
        return $this->hasOne('App\Models\Site\Company');
    }

    public function credit_cards()
    {
        return $this->hasMany('App\Models\Site\Credit_card');
    }

    public function blog_comments()
    {
        return $this->hasMany('App\Models\Site\Blog_comment');
    }

    public function bookingInfo()
    {
        return $this->hasMany('App\Models\Site\BookingInfo');
    }

    public function wishLists()
    {
        return $this->hasMany('App\Models\Site\WishList');
    }

    public function checkUserType()
    {
        if($this->activated === 1)
        {
            if($this->type === 'individual')
            {
                return route('dashboard-user');
            } elseif($this->type === 'company')
            {
                return route('dashboard-company');
            }
        } else {
            session()->flash('msg-error', 'Account not active');
            Auth::logout($this);
            return route('login');
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function reviews(){
        return $this->hasMany('App\Models\Site\Review' , 'user_id');
    }
}
