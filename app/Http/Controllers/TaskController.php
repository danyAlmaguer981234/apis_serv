<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {

            $sql = "SELECT * FROM tr_hist where tr_userid = 'dalmague' and tr_domain ='SCO'";
            $task = DB::select($sql);
            return $task;
            return response()->json(['success'=>'Contact form submitted successfully']);
        } catch (\Exception $e) {
            

        }
    }
    public function getArt(Request $request)
    {
        try {

            $sql = "SELECT * FROM tr_hist where tr_part = '$request->id' and tr_domain = '$request->domain' order by tr_date desc";
            $task = DB::select($sql);
            return $task;
        } catch (\Exception $e) {
            die(" Exception: " . $e);
        }
    }
    public function getArtUbi(Request $request)
    {
        try {

            $sql = "SELECT * FROM ld_det where ld_part = '$request->id' and ld_domain = '$request->domain'order by ld_date desc";
            $task = DB::select($sql);
            echo json_encode($task);
            /* return $task;*/
        } catch (\Exception $e) {
            die(" Exception: " . $e);
        }
    }
    public function getAllClient()
    {
        try {

            $sql = "SELECT * FROM ad_mstr where  UPPER(ad_type) = 'CUSTOMER' and rownum < 10 and ad_domain = 'SCO' order by AD_NAME ";
            $task = DB::connection("oracle")->select($sql);
           
             return $task;
        } catch (\Exception $e) {
            die(" Exception: " . $e);
        }
    }

    public function getClient(Request $request)
    {
        try {

            $sql = "SELECT * FROM ad_mstr where ad_addr = '$request->id' and UPPER(ad_type) = 'CUSTOMER'  and ad_domain = '$request->domain' order by AD_NAME";
            $task = DB::connection("oracle")->select($sql);
            return $task;
           
        } catch (\Exception $e) {
            die(" Exception: " . $e);
        }
    }
    
    public function getWoMstr(Request $request)
    {
        try {

            $sql = "SELECT * FROM wo_mstr, wod_det where wo_nbr = wod_nbr and wo_nbr = '$request->id' and wo_domain = '$request->domain' ";
            $task = DB::select($sql);

            foreach($task as $p){
                echo "<table>";
                 echo "<tr>";
                echo "<td>" . $p->wo_nbr ."</td>";
                echo "<td>" . $p->wo_part ."</td>";
                echo "<td>" . $p->wod_part ."</td>";
               

                echo "<tr>";
                echo "</table>";
            }
         
        } catch (\Exception $e) {
            die(" Exception: " . $e);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {

        foreach ($request->array as $e)
        {
            echo "<br>".$e;
       
        DB::connection("sqlsrv2")->insert('insert into det_user_ad(det_ad_add, det_usr_index ) values (?, ?)', [$request->alias,$e]);
      
    }
    return response()->json('Registro Exitoso');
         } catch (\Exception $e) {
            die(" Exception: " . $e);
        }  

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
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
