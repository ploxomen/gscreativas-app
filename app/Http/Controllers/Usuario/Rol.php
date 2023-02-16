<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Rol extends Controller
{
    public function viewRol(Request $request) : View
    {
        return view("intranet.users.roles");
    }
}
