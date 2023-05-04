<?php

namespace App\Http\Controllers;

class Helpers extends Controller
{
    public function fechaCompleta($fecha)
    {
        $meses = ["enero","febrero","marzo","abril","mayo","junio","julio","agosto","setiembre","octubre","noviembre","diciembre"];
        $dias = ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado"];
        $strtotime = strtotime($fecha);
        $mesFecha = $meses[date('n',$strtotime) - 1];
        $diaFecha = $dias[date('w')];
        return $diaFecha . ' '. date('d',$strtotime) . ' de ' . $mesFecha . ' del ' . date('Y',$strtotime);
    }
}
