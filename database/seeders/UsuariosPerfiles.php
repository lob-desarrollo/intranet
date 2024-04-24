<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Profile;
use App\Models\Department;

class UsuariosPerfiles extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $archivo = fopen('C:/wamp64/www/git/intranet/extras/personal-corporativo.csv', 'r');
        $fila = 0;
        while (($datos = fgetcsv($archivo, 1000, ",")) == true) {
            if($fila>0) {
                $empleado = trim($datos[0]);
                $usuario = User::create(['name'     => trim($datos[1]),
                                         'email'    => $empleado,
                                         'password' => Hash::make($empleado)]);
                $departamento = Department::select('id')->where('departamento', '=', trim($datos[4]))->first();

                $usuario->roles()->attach(Role::where('name', 'user')->first());

                Profile::create(['user_id'         => $usuario->id,
                                 'nombres'         => trim($datos[1]),
                                 'apellidos'       => trim($datos[2]),
                                 'genero'          => trim($datos[5]),
                                 'nacimiento'      => \Carbon\Carbon::CreateFromFormat('d/m/Y', $datos[6])->format('Y-m-d'),
                                 'ingreso'         => \Carbon\Carbon::CreateFromFormat('d/m/Y', $datos[7])->format('Y-m-d'),
                                 'puesto'          => trim($datos[3]),
                                 'no_empleado'     => $empleado,
                                 'departamento_id' => $departamento->id,
                                 'estatus'         => 1]);
            }
            $fila++;
        }
        fclose($archivo);
    }
}