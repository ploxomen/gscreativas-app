<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rol extends Model
{
    protected $table = 'rol';
    public $timestamps = false;
    protected $fillable = ['rol'];

    public static function getRolArea($id_area)
    {
        return DB::select('CALL sp_get_roles_area(?)',[$id_area]);
    }
}
