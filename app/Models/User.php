<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'tblUser';
    protected $primaryKey = 'userId';
    public $timestamps = false; // Set to false if you don't have created_at and updated_at columns

    // Define relationship with UserRole model (many-to-one)
    public function role()
    {
        return $this->belongsTo(UserRole::class, 'userRole', 'userRoleId');
    }
}
