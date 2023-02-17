<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';
    protected $fillable = ['nombreArea'];
    const CREATED_AT = 'fechaCreada';
    const UPDATED_AT = 'fechaActualizada';
    
    protected function serializeDate($date)
    {
        return $date->format('d/m/Y h:i a');
    }
    
    public function usuarios()
    {
        return $this->hasMany(User::class,'areaFk');
    }
}
