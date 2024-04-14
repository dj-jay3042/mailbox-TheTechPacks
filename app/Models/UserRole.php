<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'tblUserRole';
    protected $primaryKey = 'userRoleId';
    public $timestamps = false; // Set to false if you don't have created_at and updated_at columns

    // Define relationship with User model (one-to-many)
    public function users()
    {
        return $this->hasMany(User::class, 'userRole', 'userRoleId');
    }
}
