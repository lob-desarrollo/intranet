<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Icon;

class DepartmentTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $departamentos = ['TECNOLOGIAS DE LA INFORMACION',
                          'ALMACEN DE ACCESORIOS',
                          'CAPITAL HUMANO',
                          'TESORERIA',
                          'PROTOTIPOS DAMA',
                          'CENTRO DE DISTRIBUCION',
                          'PLANEACION DE LA DEMANDA OP',
                          'VISUAL',
                          'COMERCIO INTERNACIONAL',
                          'DISEÑO DAMA',
                          'COMERCIALIZACION',
                          'ALMACEN DE TELAS',
                          'ALMACEN DE AVIOS',
                          'ALMACEN DE PRODUCTO TERMINADO',
                          'VENTAS MAYOREO',
                          'DIRECCION GENERAL',
                          'CANAL WEB',
                          'PROTOTIPOS CABALLERO',
                          'CONTROL DE CALIDAD',
                          'FINANZAS Y ADMINISTRACION',
                          'DIRECCION PRODUCTO CABALLERO',
                          'ADMINISTRACION DE INMUEBLES',
                          'PRODUCCION DAMA',
                          'PRODUCCION CABALLERO',
                          'JURIDICO',
                          'MERCADOTECNIA',
                          'COMPRAS PT DAMA',
                          'ARQUITECTURA',
                          'MANTENIMIENTO',
                          'DISEÑO CABALLERO'];

        foreach ($departamentos as $key => $value) {
            $departamento = Department::create(['departamento' => $value]);
        }

        $archivo = fopen('C:/wamp64/www/git/intranet/extras/iconos.csv', 'r');
        while (($datos = fgetcsv($archivo, 1000, ",")) == true) {
            Icon::create(['icono' => trim($datos[0])]);
        }
        fclose($archivo);
    }
}