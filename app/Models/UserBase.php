<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBase extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    public function garage()
    {
        return $this->hasMany(UserGarage::class, 'ub_id', 'ub_id');
    }
}
