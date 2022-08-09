<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Task;
use Facade\FlareClient\Http\Client as HttpClient;
use Illuminate\Http\Request;
use Twilio\Http\Client;


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

         $sql = "SELECT  '' otro, ad.* FROM ad_mstr ad where  UPPER(ad_type) = 'CUSTOMER' and rownum < 65 and ad_domain = 'SCO' order by AD_NAME ";
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

   public function getClientByUser(Request $request)
   {
      try {

         $sql = "SELECT usr_alias,usr_firstname, usr_lastname, usr_name, det_ad_add from users, det_user_add where det_usr_index= usr_alias ";
         $task = DB::connection("sqlsrv2")->select($sql);
         return $task;
      } catch (\Exception $e) {
         die(" Exception: " . $e);
      }
   }



   public function getSO()
   {
      try {


         
 
         $sql = "select * from so_mstr1 order by so_date";
         $task = DB::connection("sqlsrv2")->select($sql);
        
           return response()->json($task);
      } catch (\Exception $e) {
         die(" Exception: " . $e);
      }
   }
   public function getSObyID(Request $request)
   {
      try {
 
         $sql = "select det_so_part, det_so_price, det_so_qty, det_so_sub from det_sod where det_so_nbr = '$request->idSo' ";
         $task = DB::connection("sqlsrv2")->select($sql);
        
           return response()->json($task);
      } catch (\Exception $e) {
         die(" Exception: " . $e);
      }
   }
   public function getItems()
   {
      try {

         $sql = "select * from pi_mstr, pt_mstr, pid_det where pt_part = pi_part_code and PI_LIST_ID = PID_LIST_ID and pi_curr = 'MN' and pi_um = 'PZ' ";
         $task = DB::connection("oracle")->select($sql);
         return $task;
      } catch (\Exception $e) {
         die(" Exception: " . $e);
      }
   }

   public function saveSo()
   {
      try {

         $sql = "select * from pi_mstr, pt_mstr, pid_det where pt_part = pi_part_code and PI_LIST_ID = PID_LIST_ID and pi_curr = 'MN' and pi_um = 'PZ' ";
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

   public function soAdd(Request $request)
   {
      
      try {
       
         $fechaActual = date('d/m/y'); 
        // DB::connection("sqlsrv2")->insert('insert into so_mstr1(so_addr,so_vend) values (?,?)', [$request->addr, $request->vend]);
         $id = DB::connection("sqlsrv2")->table('so_mstr1')->insertGetId([
            'so_addr' => $request->addr,
            'so_vend' => $request->vend
           // 'so_date' => $fechaActual
        ]);
        
        foreach ($request->array as $clave=>$value) {
           

         DB::connection("sqlsrv2")->table('det_sod')->insert([
            'det_so_nbr' => $id,
            'det_so_part' => $value['det_so_part'],
            'det_so_price' => $value['det_so_price'],
            'det_so_qty' => $value['det_so_qty'],
            'det_so_sub' => $value['det_so_sub']
         ]);
      }
        
    
      
         return response()->json("operación exitosa");
      } catch (\Exception $e) {
         die(" Exception: " . $e);
      }
   }
  

   public function Chart(Request $request)
   {

      try {
         $sql = "
        SELECT *
          FROM (SELECT f.FE_TRANSACCION,
                       NVL (f.TOTAL_CN_CONV, 0) TOTAL_CN_CONV,
                       NVL (f.CN_ORDENADA, 0) CN_ORDENADA,
                       NVL (f.CUMPLIMIENTO, 0) CUMPLIMIENTO,
                       NVL (G.TOTAL_MATSEG, 0) TOTAL_MATSEG,
                       NVL (g.TOTAL_MATTER, 0) TOTAL_MATTER,
                       NVL (f.TOTAL_CN_DESP, 0) TOTAL_CN_DESP,
                       NVL (f.TOTAL_FO_MTS, 0) TOTAL_FO_MTS
                  FROM    (SELECT TO_CHAR (b.FE_TRANSACCION, 'dd/mm/yyyy')
                                     FE_TRANSACCION,
                                  a.TOTAL_CN_CONV,
                                  b.CN_ORDENADA,
                                  0 CUMPLIMIENTO,
                                  A.TOTAL_CN_DESP,
                                  A.TOTAL_FO_MTS
                             FROM (  SELECT FE_TRANSACCION,
                                            ROUND (SUM (CN_TRANSACCION_CONV), 2)
                                               TOTAL_CN_CONV,
                                            ROUND (SUM (CN_DESPERDICIO_CONV), 2)
                                               TOTAL_CN_DESP,
                                            ROUND (SUM (FO_MTS), 2) TOTAL_FO_MTS
                                       FROM (SELECT FE_TRANSACCION,
                                                    CN_TRANSACCION_CONV,
                                                    CN_DESPERDICIO_CONV,
                                                    CASE
                                                       WHEN CL_UM = 'PZ'
                                                       THEN
                                                          CN_TRANSACCION_PZ * MTS
                                                       ELSE
                                                          CN_REAL * MTS
                                                    END
                                                       FO_MTS
                                               FROM (SELECT FE_TRANSACCION,
                                                            CASE
                                                               WHEN fnisnumeric (
                                                                       SUBSTR (
                                                                          CL_PRODUCTO,
                                                                          10,
                                                                          4)) = 1
                                                               THEN
                                                                  TO_NUMBER (
                                                                     SUBSTR (
                                                                        CL_PRODUCTO,
                                                                        10,
                                                                        4))
                                                                  / 10
                                                                  * 0.0254
                                                               ELSE
                                                                  0
                                                            END
                                                               MTS,
                                                            CASE
                                                               WHEN UPPER (CL_USUARIO) LIKE
                                                                       UPPER ('$request->maquina%')
                                                               THEN
                                                                  CN_TRANSACCION_CONV
                                                               ELSE
                                                                  0
                                                            END
                                                               CN_TRANSACCION_CONV,
                                                            CN_TRANSACCION_PZ,
                                                            CN_REAL,
                                                            CN_DESPERDICIO_CONV,
                                                            CL_UM
                                                       FROM IC_D_WO_##_QAD
                                                      WHERE CL_MAQUINA = '$request->maquina'
                                                            AND CL_TIPO_TRANSACC =
                                                                   'RCT-WO'
                                                            AND CL_GRUPO_PRODUCTO <>
                                                                   'PRO'
                                                            AND CL_GRUPO_PRODUCTO <>
                                                                   'SEG'
                                                            AND FE_TRANSACCION BETWEEN TO_DATE (
                                                                                          '01/07/2022',
                                                                                          'DD/MM/YYYY')
                                                                                   AND TO_DATE (
                                                                                          '23/07/2022',
                                                                                          'DD/MM/YYYY')))
                                   GROUP BY FE_TRANSACCION
                                   ORDER BY FE_TRANSACCION) a,
                                  (  SELECT xxprbg_date FE_TRANSACCION,
                                            xxprbg_qty CN_ORDENADA
                                       FROM qad.xxprbg_hist
                                      WHERE UPPER (xxprbg_mch) = '$request->maquina'
                                            AND xxprbg_date BETWEEN TO_DATE (
                                                                       '01/07/2022',
                                                                       'DD/MM/YYYY')
                                                                AND TO_DATE (
                                                                       '23/07/2022',
                                                                       'DD/MM/YYYY')
                                   ORDER BY xxprbg_date) b
                            WHERE a.FE_TRANSACCION(+) = b.FE_TRANSACCION) f
                       JOIN
                          (SELECT FE_TRANSACCION, TOTAL_MATSEG, TOTAL_MATTER
                             FROM (  SELECT TO_CHAR (FE_TRANSACCION, 'dd/mm/yyyy')
                                               FE_TRANSACCION,
                                            ROUND (SUM (MATSEG), 2) TOTAL_MATSEG,
                                            ROUND (SUM (MATTER), 2) TOTAL_MATTER
                                       FROM (SELECT FE_TRANSACCION,
                                                    CASE
                                                       WHEN    SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TG2'
                                                            OR SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TF2'
                                                            OR SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TC2'
                                                       THEN
                                                          CN_TRANSACCION_CONV
                                                       ELSE
                                                          0
                                                    END
                                                       MATSEG,
                                                    CASE
                                                       WHEN    SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TG3'
                                                            OR SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TF3'
                                                            OR SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TC3'
                                                       THEN
                                                          CN_TRANSACCION_CONV
                                                       ELSE
                                                          0
                                                    END
                                                       MATTER
                                               FROM IC_D_WO_##_QAD
                                              WHERE CL_MAQUINA = '$request->maquina'
                                                    AND CL_TIPO_TRANSACC = 'RCT-WO'
                                                    AND CL_GRUPO_PRODUCTO IN
                                                           ('PRO', 'SEG')  /*= 'PRO'*/
                                                    AND FE_TRANSACCION BETWEEN TO_DATE (
                                                                                  '01/07/2022',
                                                                                  'DD/MM/YYYY')
                                                                           AND TO_DATE (
                                                                                  '23/07/2022',
                                                                                  'DD/MM/YYYY'))
                                   GROUP BY FE_TRANSACCION
                                   ORDER BY FE_TRANSACCION)) g
                       ON f.FE_TRANSACCION = g.FE_TRANSACCION(+))
        UNION
        SELECT *
          FROM (SELECT f.FE_TRANSACCION,
                       NVL (f.TOTAL_CN_CONV, 0) TOTAL_CN_CONV,
                       NVL (f.CN_ORDENADA, 0) CN_ORDENADA,
                       NVL (f.CUMPLIMIENTO, 0) CUMPLIMIENTO,
                       NVL (G.TOTAL_MATSEG, 0) TOTAL_MATSEG,
                       NVL (g.TOTAL_MATTER, 0) TOTAL_MATTER,
                       NVL (f.TOTAL_CN_DESP, 0) TOTAL_CN_DESP,
                       NVL (f.TOTAL_FO_MTS, 0) TOTAL_FO_MTS
                  FROM    (SELECT TO_CHAR (a.FE_TRANSACCION, 'dd/mm/yyyy')
                                     FE_TRANSACCION,
                                  a.TOTAL_CN_CONV,
                                  b.CN_ORDENADA,
                                  0 CUMPLIMIENTO,
                                  A.TOTAL_CN_DESP,
                                  A.TOTAL_FO_MTS
                             FROM (  SELECT FE_TRANSACCION,
                                            ROUND (SUM (CN_TRANSACCION_CONV), 2)
                                               TOTAL_CN_CONV,
                                            ROUND (SUM (CN_DESPERDICIO_CONV), 2)
                                               TOTAL_CN_DESP,
                                            ROUND (SUM (FO_MTS), 2) TOTAL_FO_MTS
                                       FROM (SELECT FE_TRANSACCION,
                                                    CN_TRANSACCION_CONV,
                                                    CN_DESPERDICIO_CONV,
                                                    CASE
                                                       WHEN CL_UM = 'PZ'
                                                       THEN
                                                          CN_TRANSACCION_PZ * MTS
                                                       ELSE
                                                          CN_REAL * MTS
                                                    END
                                                       FO_MTS
                                               FROM (SELECT FE_TRANSACCION,
                                                            CASE
                                                               WHEN fnisnumeric (
                                                                       SUBSTR (
                                                                          CL_PRODUCTO,
                                                                          10,
                                                                          4)) = 1
                                                               THEN
                                                                  TO_NUMBER (
                                                                     SUBSTR (
                                                                        CL_PRODUCTO,
                                                                        10,
                                                                        4))
                                                                  / 10
                                                                  * 0.0254
                                                               ELSE
                                                                  0
                                                            END
                                                               MTS,
                                                            CASE
                                                               WHEN UPPER (CL_USUARIO) LIKE
                                                                       UPPER ('$request->maquina%')
                                                               THEN
                                                                  CN_TRANSACCION_CONV
                                                               ELSE
                                                                  0
                                                            END
                                                               CN_TRANSACCION_CONV,
                                                            CN_TRANSACCION_PZ,
                                                            CN_REAL,
                                                            CN_DESPERDICIO_CONV,
                                                            CL_UM
                                                       FROM IC_D_WO_##_QAD
                                                      WHERE CL_MAQUINA = '$request->maquina'
                                                            AND CL_TIPO_TRANSACC =
                                                                   'RCT-WO'
                                                            AND CL_GRUPO_PRODUCTO <>
                                                                   'PRO'
                                                            AND CL_GRUPO_PRODUCTO <>
                                                                   'SEG'
                                                            AND FE_TRANSACCION BETWEEN TO_DATE (
                                                                                          '01/07/2022',
                                                                                          'DD/MM/YYYY')
                                                                                   AND TO_DATE (
                                                                                          '21/07/2022',
                                                                                          'DD/MM/YYYY')))
                                   GROUP BY FE_TRANSACCION
                                   ORDER BY FE_TRANSACCION) a,
                                  (  SELECT xxprbg_date FE_TRANSACCION,
                                            xxprbg_qty CN_ORDENADA
                                       FROM qad.xxprbg_hist
                                      WHERE UPPER (xxprbg_mch) = '$request->maquina'
                                            AND xxprbg_date BETWEEN TO_DATE (
                                                                       '01/07/2022',
                                                                       'DD/MM/YYYY')
                                                                AND TO_DATE (
                                                                       '21/07/2022',
                                                                       'DD/MM/YYYY')
                                   ORDER BY xxprbg_date) b
                            WHERE a.FE_TRANSACCION = b.FE_TRANSACCION(+)) f
                       JOIN
                          (SELECT FE_TRANSACCION, TOTAL_MATSEG, TOTAL_MATTER
                             FROM (  SELECT TO_CHAR (FE_TRANSACCION, 'dd/mm/yyyy')
                                               FE_TRANSACCION,
                                            ROUND (SUM (MATSEG), 2) TOTAL_MATSEG,
                                            ROUND (SUM (MATTER), 2) TOTAL_MATTER
                                       FROM (SELECT FE_TRANSACCION,
                                                    CASE
                                                       WHEN    SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TG2'
                                                            OR SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TF2'
                                                            OR SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TC2'
                                                       THEN
                                                          CN_TRANSACCION_CONV
                                                       ELSE
                                                          0
                                                    END
                                                       MATSEG,
                                                    CASE
                                                       WHEN    SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TG3'
                                                            OR SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TF3'
                                                            OR SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TC3'
                                                       THEN
                                                          CN_TRANSACCION_CONV
                                                       ELSE
                                                          0
                                                    END
                                                       MATTER
                                               FROM IC_D_WO_##_QAD
                                              WHERE CL_MAQUINA = '$request->maquina'
                                                    AND CL_TIPO_TRANSACC = 'RCT-WO'
                                                    AND CL_GRUPO_PRODUCTO IN
                                                           ('PRO', 'SEG')  /*= 'PRO'*/
                                                    AND FE_TRANSACCION BETWEEN TO_DATE (
                                                                                  '01/07/2022',
                                                                                  'DD/MM/YYYY')
                                                                           AND TO_DATE (
                                                                                  '21/07/2022',
                                                                                  'DD/MM/YYYY'))
                                   GROUP BY FE_TRANSACCION
                                   ORDER BY FE_TRANSACCION)) g
                       ON f.FE_TRANSACCION = g.FE_TRANSACCION(+))
        union
        SELECT *
          FROM (SELECT CASE
                          WHEN f.FE_TRANSACCION IS NULL THEN g.FE_TRANSACCION
                          ELSE f.FE_TRANSACCION
                       END
                          FE_TRANSACCION,
                       NVL (f.TOTAL_CN_CONV, 0) TOTAL_CN_CONV,
                       NVL (f.CN_ORDENADA, 0) CN_ORDENADA,
                       NVL (f.CUMPLIMIENTO, 0) CUMPLIMIENTO,
                       NVL (G.TOTAL_MATSEG, 0) TOTAL_MATSEG,
                       NVL (g.TOTAL_MATTER, 0) TOTAL_MATTER,
                       NVL (f.TOTAL_CN_DESP, 0) TOTAL_CN_DESP,
                       NVL (f.TOTAL_FO_MTS, 0) TOTAL_FO_MTS
                  FROM    (SELECT TO_CHAR (b.FE_TRANSACCION, 'dd/mm/yyyy')
                                     FE_TRANSACCION,
                                  a.TOTAL_CN_CONV,
                                  b.CN_ORDENADA,
                                  0 CUMPLIMIENTO,
                                  A.TOTAL_CN_DESP,
                                  A.TOTAL_FO_MTS
                             FROM (  SELECT FE_TRANSACCION,
                                            ROUND (SUM (CN_TRANSACCION_CONV), 2)
                                               TOTAL_CN_CONV,
                                            ROUND (SUM (CN_DESPERDICIO_CONV), 2)
                                               TOTAL_CN_DESP,
                                            ROUND (SUM (FO_MTS), 2) TOTAL_FO_MTS
                                       FROM (SELECT FE_TRANSACCION,
                                                    CN_TRANSACCION_CONV,
                                                    CN_DESPERDICIO_CONV,
                                                    CASE
                                                       WHEN CL_UM = 'PZ'
                                                       THEN
                                                          CN_TRANSACCION_PZ * MTS
                                                       ELSE
                                                          CN_REAL * MTS
                                                    END
                                                       FO_MTS
                                               FROM (SELECT FE_TRANSACCION,
                                                            CASE
                                                               WHEN fnisnumeric (
                                                                       SUBSTR (
                                                                          CL_PRODUCTO,
                                                                          10,
                                                                          4)) = 1
                                                               THEN
                                                                  TO_NUMBER (
                                                                     SUBSTR (
                                                                        CL_PRODUCTO,
                                                                        10,
                                                                        4))
                                                                  / 10
                                                                  * 0.0254
                                                               ELSE
                                                                  0
                                                            END
                                                               MTS,
                                                            CASE
                                                               WHEN UPPER (CL_USUARIO) LIKE
                                                                       UPPER ('$request->maquina%')
                                                               THEN
                                                                  CN_TRANSACCION_CONV
                                                               ELSE
                                                                  0
                                                            END
                                                               CN_TRANSACCION_CONV,
                                                            CN_TRANSACCION_PZ,
                                                            CN_REAL,
                                                            CN_DESPERDICIO_CONV,
                                                            CL_UM
                                                       FROM IC_D_WO_##_QAD
                                                      WHERE CL_MAQUINA = '$request->maquina'
                                                            AND CL_TIPO_TRANSACC =
                                                                   'RCT-WO'
                                                            AND CL_GRUPO_PRODUCTO <>
                                                                   'PRO'
                                                            AND CL_GRUPO_PRODUCTO <>
                                                                   'SEG'
                                                            AND FE_TRANSACCION BETWEEN TO_DATE (
                                                                                          '01/07/2022',
                                                                                          'DD/MM/YYYY')
                                                                                   AND TO_DATE (
                                                                                          '23/07/2022',
                                                                                          'DD/MM/YYYY')))
                                   GROUP BY FE_TRANSACCION
                                   ORDER BY FE_TRANSACCION) a,
                                  (  SELECT xxprbg_date FE_TRANSACCION,
                                            xxprbg_qty CN_ORDENADA
                                       FROM qad.xxprbg_hist
                                      WHERE UPPER (xxprbg_mch) = '$request->maquina'
                                            AND xxprbg_date BETWEEN TO_DATE (
                                                                       '01/07/2022',
                                                                       'DD/MM/YYYY')
                                                                AND TO_DATE (
                                                                       '23/07/2022',
                                                                       'DD/MM/YYYY')
                                   ORDER BY xxprbg_date) b
                            WHERE a.FE_TRANSACCION = b.FE_TRANSACCION) f
                       JOIN
                          (SELECT FE_TRANSACCION, TOTAL_MATSEG, TOTAL_MATTER
                             FROM (  SELECT TO_CHAR (FE_TRANSACCION, 'dd/mm/yyyy')
                                               FE_TRANSACCION,
                                            ROUND (SUM (MATSEG), 2) TOTAL_MATSEG,
                                            ROUND (SUM (MATTER), 2) TOTAL_MATTER
                                       FROM (SELECT FE_TRANSACCION,
                                                    CASE
                                                       WHEN    SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TG2'
                                                            OR SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TF2'
                                                            OR SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TC2'
                                                       THEN
                                                          CN_TRANSACCION_CONV
                                                       ELSE
                                                          0
                                                    END
                                                       MATSEG,
                                                    CASE
                                                       WHEN    SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TG3'
                                                            OR SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TF3'
                                                            OR SUBSTR (CL_PRODUCTO,
                                                                       0,
                                                                       3) = 'TC3'
                                                       THEN
                                                          CN_TRANSACCION_CONV
                                                       ELSE
                                                          0
                                                    END
                                                       MATTER
                                               FROM IC_D_WO_##_QAD
                                              WHERE CL_MAQUINA = '$request->maquina'
                                                    AND CL_TIPO_TRANSACC = 'RCT-WO'
                                                    AND CL_GRUPO_PRODUCTO IN
                                                           ('PRO', 'SEG')  /*= 'PRO'*/
                                                    AND FE_TRANSACCION BETWEEN TO_DATE (
                                                                                  '01/07/2022',
                                                                                  'DD/MM/YYYY')
                                                                           AND TO_DATE (
                                                                                  '23/07/2022',
                                                                                  'DD/MM/YYYY'))
                                   GROUP BY FE_TRANSACCION
                                   ORDER BY FE_TRANSACCION)) g
                       ON f.FE_TRANSACCION(+) = g.FE_TRANSACCION)
        
        
        
        ";
         $task = DB::connection("oracle2")->select($sql);
         return response()->json($task);
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

   public function deleteSO(Request $request)
   {
      try {

        

         
        
      

         DB::connection("sqlsrv2")->delete('delete from so_mstr1 where id_so = ?', [$request->id]);
        
         DB::connection("sqlsrv2")->delete('delete from det_sod where det_so_nbr = ?', [$request->id]);

         DB::connection("sqlsrv2")->commit();

         return response()->json('Operación Exitosa');
        
      } catch (\Exception $e) {
         die(" Exception: " . $e);
      }
   }
   public function deleteSOD($id)
   {
      DB::connection("sqlsrv2")->delete('delete from det_sod where det_so_nbr = ?', [$id]);
    
   }



   public function sendMessage(Request $request)
   {
      $account_sid = getenv("TWILIO_SID");
      $auth_token = getenv("TWILIO_AUTH_TOKEN");
      $twilio_number = getenv("TWILIO_NUMBER");
      $client = New Client($account_sid, $auth_token);

      $client->messages->create($request->receiverNumber, [
         'from' => $twilio_number, 
         'body' => $request->message]);

         dd('SMS Sent Successfully.');
     
   }
}
