<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Profile;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'sa';
        $role->description = 'Súper Administrador';
        $role->save();
        $role = new Role();
        $role->name = 'admin';
        $role->description = 'Administrador';
        $role->save();
        $role = new Role();
        $role->name = 'user';
        $role->description = 'Usuario';
        $role->save();

        $usuario = User::create(['name'     => 'TI',
                                 'email'    => 'desarrollo@lob.com.mx',
                                 'password' => Hash::make('Jn_2024!')]);

        $usuario->roles()->attach(Role::where('name', 'sa')->first());

        Profile::create(['user_id'         => $usuario->id,
                         'nombres'         => 'Usuario',
                         'apellidos'       => 'Master',
                         'genero'          => 'H',
                         'nacimiento'      => date('Y-m-d'),
                         'ingreso'         => date('Y-m-d'),
                         'puesto'          => 'Desarrollador Web',
                         'no_empleado'     => '00',
                         'departamento_id' => 1,
                         'estatus'         => 1]);
    }
}
