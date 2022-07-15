<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DummysController extends Controller
{
    public function index()
    {

        try {
            if(DB::connection()->getDatabaseName())
            {
                echo "Si conecto a la base de datos" .  DB::connection()->getDatabaseName();
                 DB::connection()->getDatabaseName();
            }else {
                echo "No se encuentra la base de datos" ;
            }
        } catch (\Exception $e) {
            die(" No se pudó realizar la conexion a la base de datos" . $e);
        }
    }

}
