<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UsuarioRol;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AreasSeeder::class,
            RolesSeeder::class
        ]);
        User::create([
            'correo' => 'jeanpi.jpct@gmail.com',
            'nombres' => 'Jean Pier',
            'apellidos' => 'Carrasco Tamariz',
            'password' => bcrypt('jeanpier04'),
            'estado' => 1,
            'areaFk' => 1
        ]);
        UsuarioRol::create([
            'usuarioFk' => 1,
            'rolFk' => 1
        ]);
    }
}
