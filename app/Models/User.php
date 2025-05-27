<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Profile;
use App\Models\Account;
use App\Models\Transaction;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'active',
        'email_verified_at'
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

    protected $appends = [
        "wallet",
        "assigned_roles"
    ];

    /**
     * Always encrypt the password when it is updated.
     *
     * @param $value
    * @return string
    */
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getEmailForVerification() {
        return $this->email;
    }

    public function profile() {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function account() {
        return $this->hasMany(Account::class, 'user_id');
    }


    public function getAssignedRolesAttribute() {
        return $this->getRoleNames();
    }

    public function getWalletAttribute() {
        $account = $this->account->where('type', 'wallet')->first();
        return ($account != NULL ) ? $account->balance : 0.00;
    }

    public function transactions() {
        return $this->hasMany(Transaction::class, 'user_id');
    }
}
