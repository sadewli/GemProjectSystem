<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'tbl_login_log';
    protected $primaryKey = 'idtbl_login_log';
    public $timestamps = false;
    protected $guarded = [];

    protected $dates = ['login_datetime', 'logout_datetime'];

    public function user() {
        return $this->belongsTo(User::class, 'tbl_user_idtbl_user', 'idtbl_user');
    }
}