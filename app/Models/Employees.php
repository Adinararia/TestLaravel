<?php

namespace App\Models;

use App\Models\Positions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Employees extends Model
{
    use HasFactory;



    protected $fillable = [
        'id',
        'name',
        'reception',
        'phone',
        'email',
        'salary',
        'manager_id',
        'position_id',
        'image',
        'admin_created_id',
        'admin_updated_id',
        'created_at',
        'updated_at'
    ];
    public function position()
    {
        return $this->belongsTo(Positions::class);
    }
    public function getManagerName($manager_id){
        return Employees::select('name')->where('id', $manager_id)->first();
    }
}
