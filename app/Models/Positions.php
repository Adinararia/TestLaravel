<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'admin_created_id',
        'admin_updated_id',
        'created_at',
        'updated_at'
    ];
    public function employees()
    {
        return $this->hasMany(Employees::class, 'id', 'position_id');
    }
}
