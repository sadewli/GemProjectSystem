<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tbl_user';
    protected $primaryKey = 'idtbl_user';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'tbl_user_type_idtbl_user_type',
        'status',
        'insertdatetime',
        'updatedatetime',
        'updateuser',
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
        // NOTE: password cast is intentionally NOT 'hashed' here.
        // This system uses MD5 passwords (legacy CI migration).
        // WelcomeController uses md5($input) + where('password', $md5) to authenticate.
    ];

    public function type()
    {
        return $this->belongsTo(UserType::class, 'tbl_user_type_idtbl_user_type', 'idtbl_user_type');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
