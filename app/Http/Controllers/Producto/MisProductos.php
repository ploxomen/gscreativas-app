<?php

namespace App\Http\Controllers\Producto;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Usuario;
use App\Models\Area;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Productos;
use App\Models\Rol;
use App\Models\Unidades;
use Exception;
use Illuminate\Http\Request;

class MisProductos extends Controller
{
    private $moduloArea = "admin.producto.index";
    private $usuarioController;
    
    function __construct()
    {
        $this->usuarioController = new Usuario();
    }
    public function index()
    {
        $verif = $this->usuarioController->validarXmlHttpRequest($this->moduloArea);
        if(isset($verif['session'])){
            return redirect()->route("home"); 
        }
        $modulos = $this->usuarioController->obtenerModulos();
        return view("intranet.productos.proagregar",compact("modulos"));
    }
}
