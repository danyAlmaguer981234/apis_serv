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
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Mostrar usuarios",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todos los usuarios."
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function index()
    {

        try {

            $sql = "SELECT * FROM tr_hist where tr_userid = 'dalmague' and tr_domain ='SCO'";
            $task = DB::select($sql);
            return $task;
            return response()->json(['success' => 'Contact form submitted successfully']);
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

            $sql = "SELECT * FROM ad_mstr where  UPPER(ad_type) = 'CUSTOMER' and rownum < 65 and ad_domain = 'SCO' order by AD_NAME ";
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

            foreach ($task as $p) {
                echo "<table>";
                echo "<tr>";
                echo "<td>" . $p->wo_nbr . "</td>";
                echo "<td>" . $p->wo_part . "</td>";
                echo "<td>" . $p->wod_part . "</td>";


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

            foreach ($request->array as $e) {
                echo "<br>" . $e;

                DB::connection("sqlsrv2")->insert('insert into det_user_add(det_usr_index,det_ad_add) values (?, ?)', [$request->alias, $e]);
            }
            return response()->json('Registro Exitoso');
        } catch (\Exception $e) {
            die(" Exception: " . $e);
        }
    }
    public function updateAdd(Request $request)
    {
        try {

            DB::connection("sqlsrv2")->update("update det_user_add set det_ad_add='$request->addr' where id_det= '$request->id'");

            return response()->json('Operación Exitosa');
        } catch (\Exception $e) {
            die(" Exception: " . $e);
        }
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            DB::connection("sqlsrv2")->delete('delete from det_user_add where id_det = ?', [$request->id]);
            DB::connection("sqlsrv2")->commit();
            return response()->json('Operación Exitosa');
        } catch (\Exception $e) {
            die(" Exception: " . $e);
        }
    }
}
