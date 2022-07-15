<?php

$json = file_get_contents("http://127.0.0.1:8000/api/users");
$arreglo = json_decode($json,"false");

// Define sqlsrv connections
//$server="TXKAPPAZU036";
$server="PS-MTY-TIN-01\HPWJA";
	$database="db_api_serv";
$user="root";
//$password="Scott@1234";
$password="12345678";
	

$connectionInfo = array( "Database"=>$database, "UID"=>$user, "PWD"=>$password,"CharacterSet" => "UTF-8",'ReturnDatesAsStrings'=>true);
$conn = sqlsrv_connect( $server, $connectionInfo);
if (!$conn){
	echo "<span style='color:red;font-weight:bold;'>Connection could not be established.<br /></span>";
	die( print_r( sqlsrv_errors(), true));
}else{
    echo "<span style='color:green;font-weight:bold;'>Connection  established.<br /></span>";
}








echo "<table><thead><tr><td>Fecha</td><td>Título</td><td>Enlace</td></tr></thead><tbody>";
foreach($arreglo as $post){
    echo "<tr><td>".$post['usr_name']."</td><td>".$post['usr_alias']."</td><td>".$post['usr_firstname']."</td></tr>";
}
echo "</tbody></table>";
$usuario = "qad";
 $pass = "QAD";
  $cadenaConexion = "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=10.4.1.1)(PORT=1521)))(CONNECT_DATA=(SID=qadsc)))";


$conexion = oci_connect($usuario, $pass, $cadenaConexion) or die ( "Error al conectar : ".oci_error() );


if (!$conexion) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conexion, 'SELECT * FROM usr_mstr');
oci_execute($stid);

echo "<table border='1'>\n";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
    foreach ($row as $item) {
        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
    }
    echo "</tr>\n";
}
echo "</table>\n";

?>  