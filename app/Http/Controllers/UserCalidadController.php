<?php

namespace App\Http\Controllers;

use App\Models\userCalidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserCalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = userCalidad::all();
   
        foreach($users as $p){
            echo "Nombre: " . $p->usr_alias . " ". $p->usr_firstname . "</br>";
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\userCalidad  $userCalidad
     * @return \Illuminate\Http\Response
     */
    public function show(userCalidad $userCalidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\userCalidad  $userCalidad
     * @return \Illuminate\Http\Response
     */
    public function edit(userCalidad $userCalidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\userCalidad  $userCalidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, userCalidad $userCalidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\userCalidad  $userCalidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(userCalidad $userCalidad)
    {
        //
    }
}
