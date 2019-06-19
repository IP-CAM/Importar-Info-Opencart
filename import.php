<?php 
error_reporting(E_ALL);
ini_set('max_execution_time', 99999999999999999999999999999999999999999999999999999999999);
$fecha1 = date('Ymd'); 
$fecha = date('Ymd H:i:s');  

$serverName1 = "10.17.1.38,1433";
$connectionInfo1 = array( "Database"=>"adn", "UID"=>"opencart", "PWD"=>"Op3nc4rt!");
$conn1 = sqlsrv_connect( $serverName1, $connectionInfo1 );
if( $conn1 === false ) {
    die( print_r( sqlsrv_errors(), true));
} 

$serverName = "10.17.1.180,1433";
$connectionInfo = array( "Database"=>"MicrosoftDynamicsAX", "UID"=>"magento", "PWD"=>"M4g3nt0!2019");
$conn = sqlsrv_connect( $serverName, $connectionInfo );
if( $conn === false ) {
    die( print_r( sqlsrv_errors(), true));
} 

$con = mysqli_connect("127.0.0.1","magento2","magento2","oc_inalarmdb");
           // $_SESSION['uid'] = 1;
            if(!$con){
                echo"connection failed";
            }
            if (mysqli_connect_errno())
              {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
              }   


$sql_srv0 = "SELECT COUNT(ModID) total from Model_Product";
$stm0 = sqlsrv_query( $conn1, $sql_srv0 );
$Data0 = sqlsrv_fetch_array( $stm0, SQLSRV_FETCH_ASSOC);
echo$total = $Data0['total']." Registros en SQL<br>";



 $sq = "SELECT COUNT(product_id) totals from oc_product ";  
 $re = mysqli_query($con, $sq); 
 $ro = mysqli_fetch_array($re);
 echo$total1 = $ro['totals']." Registros en Opencart <br><br><hr>";

//$top3="TOP 3";
$sql_srv1 = " 
Select distinct  t1.ModID as sku,t4.ClassID as Jearquia1,t4.Product as Jearquia2,t4.Type as Jearquia3,
t1.TitleProduct as DescCorta,t1.MSRP as Precio,t2.BrandName as Marca,t1.DescSmall as DescTecnica,t1.Benefits as Beneficios,t1.Commercial as DescComecial,t1.Usability as Usabilidad,t1.Notes as Notas,t1.Compatibility as Compatibilidad,
t1.FileCommercial as FichaComercial,t1.FileTechnique as FichaTecnica,t1.Installation as ManualInstalacion,t1.UserManual as ManualDeUsuario,
t3.MainPicture as ImagenPrincipal,t3.Picture1 as ImagenSecundaria1,t3.Picture2 as ImagenSecundaria2,t3.Picture3 as ImagenSecundaria3,t3.Picture4 as ImagenSecundaria4,t3.Picture5 as ImagenSecundaria5
from Model t1 
inner join Brand t2 on t2.BrandID = t1.BrandID 
left  join Resources t3 on t3.ModID = t1.ModID 
inner join Model_Product t4 on t4.ModID=t1.ModID  order by t1.ModID DESC";

$stm1 = sqlsrv_query( $conn1, $sql_srv1 );
while($Data1 = sqlsrv_fetch_array( $stm1, SQLSRV_FETCH_ASSOC)){

$Sku = $Data1['sku'];
$Jerarquia1 = $Data1['Jearquia1'];
$Jerarquia2 = $Data1['Jearquia2'];
$Jerarquia3 = $Data1['Jearquia3'];
$DescCorta = $Data1['DescCorta'];
$Precio = $Data1['Precio'];
$Marca_name = $Data1['Marca'];
$DescTecnica = $Data1['DescTecnica'];
$Beneficios = $Data1['Beneficios'];
$DescComercial = $Data1['DescComecial'];
$Usabilidad = $Data1['Usabilidad'];
$Notas = $Data1['Notas'];
$Img = $Data1['ImagenPrincipal'];

if (strpos($DescCorta, "'") !== false) {
    $DescComercial = str_replace(array("'",","), array(""," "), $DescCorta);
}

if (strpos($Marca_name, "'") !== false) {
    $Marca_name = str_replace(array("'",","), array(""," "), $Marca_name);
}

 $sql5 = "SELECT * from oc_manufacturer where name = '".$Marca_name."'";
 $result5 = mysqli_query($con, $sql5); 
 $row5 = mysqli_fetch_array($result5);
 $manufacturerID=$row5['manufacturer_id'];

 if ($manufacturerID =="") {
  echo"INSERT INTO oc_manufacturer (name,image,sort_order) VALUES ('$Marca_name', '', 0)<br> ";
  echo"INSERT INTO oc_manufacturer_to_store (store_id) VALUES (0) <br>";
$sqln0 = mysqli_query($con, "INSERT INTO oc_manufacturer (name,image,sort_order) VALUES ('$Marca_name', '', 0) ")or die('Error de conexión6: ' . mysqli_connect_error($sqln0));
$sqln1 = mysqli_query($con, "INSERT INTO oc_manufacturer_to_store (store_id) VALUES (0) ")or die('Error de conexión7: ' . mysqli_connect_error($sqln1));

 echo$sql6 = "SELECT * from oc_manufacturer where name = '".$Marca_name."'";
 $result6 = mysqli_query($con, $sql6); 
 $row6 = mysqli_fetch_array($result6);
 $manufacturerID1=$row6['manufacturer_id'];

 }else{
  echo"<br>Manufacturer id ya existente<br>";
  $manufacturerID1=$row5['manufacturer_id'];
 }

if ($DescComecial=="" || $DescComecial == "NULL" || $DescComecial=="-") {
  $DescComecial=$DescCorta;
}

if (strpos($DescComecial, "'") !== false) {
    $DescComercial = str_replace(array("'",","), array(""," "), $DescComecial);
}

 $Pro=$Sku;
 $query_info =  "EXECUTE usp_MgArticulo @Product = ?";  
 $build= sqlsrv_prepare($conn, $query_info, array(&$Pro));
 $build1 = sqlsrv_execute($build);   
 $Datann = sqlsrv_fetch_array($build);
 $Marca= $Datann['IDBrand'];
 $precio= $Datann['MSRP'];
 $almacen_total =$Datann['AvailPhysical'];
 $Es_Kit=$Datann['Kit'];
	//echo$info_existencias=$Datann['JsonLocation'];


 $sql2 = "SELECT * from oc_product where model = '".$Marca."' AND sku = '".$Sku."'";
 $result2 = mysqli_query($con, $sql2); 
 $row2 = mysqli_fetch_array($result2);
 $IDsku_insertado1=$row2['product_id'];
 $sku_insertado1=$row2['sku'];

 if ($sku_insertado1 == $Sku) {

 echo"Modelo: ".$Sku." Ya existe ID: ".$IDsku_insertado1."<br><hr>";

 }else{

$descipcion_completa="";
 $sql_srv_v = "SELECT *  FROM Videos_Modelos,Videos where Videos_Modelos.IdVideo = Videos.IdVideo AND Videos_Modelos.ModID ='".$Sku."' ";
 $stm_v = sqlsrv_query( $conn1, $sql_srv_v );
 while($Data_v = sqlsrv_fetch_array( $stm_v, SQLSRV_FETCH_ASSOC)){
 $videon_v=$Data_v['Embed'];
 $Name_v=$Data_v['Name'];
 $Desc_tec_v=$Data_v['Description'];

 if (strpos($Desc_tec_v, "'") !== false) {
    $Desc_tec_v = str_replace(array("'"), array(""), $Desc_tec_v);
}
 if (strpos($Name_v, "'") !== false) {
    $Name_v = str_replace(array("'"), array(""), $Name_v);
}

 $video='<iframe width="560" height="315" src="'.$videon_v.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
 $descipcion_completa.= $Name_v . ' <br><br> ' .$Desc_tec_v . ' <br><br>' .$video.'<br><br>';

 }
if ($almacen_total="") {
  $almacen_total="0";
}
echo"<strong>MODELO:</strong> ".$Sku."<br><br>";  

echo"INSERT INTO oc_product (model,sku,quantity,stock_status_id,image,manufacturer_id,shipping,price,tax_class_id,date_available,weight,weight_class_id,length,width,height,length_class_id,subtract,minimum,sort_order,status,viewed,date_added,date_modified) 
VALUES 
('$Marca','$Sku', ".$almacen_total.", 7, 'catalog/Productos/$Img', ".$manufacturerID1.", 0, ".$precio.", 9, '$fecha1', 0.0, '1', 0.0, 0.0, 0.0, 1, 1, 1, 1, 1, 0, '$fecha', '$fecha')<br>";

$sql = mysqli_query($con,"INSERT INTO oc_product (model,sku,quantity,stock_status_id,image,manufacturer_id,shipping,price,tax_class_id,date_available,weight,weight_class_id,length,width,height,length_class_id,subtract,minimum,sort_order,status,viewed,date_added,date_modified) 
VALUES 
('$Marca','$Sku', 2, 7, 'catalog/Productos/$Img', ".$manufacturerID1.", 0, ".$precio.", 9, '$fecha1', 0.0, '1', 0.0, 0.0, 0.0, 1, 1, 1, 1, 1, 0, '$fecha', '$fecha') ")or die('Error de conexión00: ' . mysqli_connect_error($sql));

$sql3 = "SELECT * from oc_product where model = '".$Marca."' AND sku = '".$Sku."'";
$result3 = mysqli_query($con, $sql3); 
$row3 = mysqli_fetch_array($result3);
$IDsku_insertado2=$row3['product_id'];

$sku_insertado2=$row3['sku'];


echo"INSERT INTO oc_product_description (product_id,language_id,name,description,meta_title) VALUES (".$IDsku_insertado2.", 1, '$Sku', '".$DescComercial." <br><br>".$descipcion_completa."', '$Sku' ) <br><br>";
echo"<br><br>";

$sql1 = mysqli_query($con, "INSERT INTO oc_product_description (product_id,language_id,name,description,meta_title) VALUES (".$IDsku_insertado2.", 1, '$Sku', '".$DescComercial." <br><br>".$descipcion_completa."', '$Sku' ) ")or die('Error de conexión1: ' . mysqli_connect_error($sql1));

echo"INSERT INTO oc_product_description (product_id,language_id,name,description,meta_title) VALUES (".$IDsku_insertado2.", 2, '$Sku', '".$DescComercial." <br><br>".$descipcion_completa."', '$Sku' ) <br><br>";

$sql11 = mysqli_query($con, "INSERT INTO oc_product_description (product_id,language_id,name,description,meta_title) VALUES (".$IDsku_insertado2.", 2, '$Sku', '".$DescComercial." <br><br>".$descipcion_completa."', '$Sku' ) ")or die('Error de conexión2: ' . mysqli_connect_error($sql11));

echo"INSERT INTO oc_product_to_layout (product_id,store_id,layout_id) VALUES (".$IDsku_insertado2.",0,0) <br><br>";
$sql2 = mysqli_query($con, "INSERT INTO oc_product_to_layout (product_id,store_id,layout_id) VALUES (".$IDsku_insertado2.",0,0) ") or die('Error de conexión3: ' . mysqli_connect_error($sql2));

echo"INSERT INTO oc_product_to_store (product_id,store_id) VALUES (".$IDsku_insertado2.",0) <br><br>";
$sql3 = mysqli_query($con, "INSERT INTO oc_product_to_store (product_id,store_id) VALUES (".$IDsku_insertado2.",0) ") or die('Error de conexión4: ' . mysqli_connect_error($sql3));


echo"INSERT INTO oc_seo_url (store_id,language_id,query,keyword) VALUES (0,2,'product_id=".$IDsku_insertado2."','$Sku')<br><br> ";
$sql4 = mysqli_query($con, "INSERT INTO oc_seo_url (store_id,language_id,query,keyword) VALUES (0,2,'product_id=".$IDsku_insertado2."','$Sku') ") or die('Error de conexión5: ' . mysqli_connect_error($sql4));

echo"Registro Insertado, Modelo:".$Sku."<br><hr>";
echo"<br><br><br><hr>";


 }







}





/*
$sql4 = mysqli_query($con, "INSERT INTO oc_product_to_store () VALUES () ") or oiError(mysqli_error($con));
$ret4 = mysqli_fetch_array($sql4); */

/*
 $qu = "SELECT  * FROM CUSTTABLE WHERE VATNUM = 'CAED831001B55'";
            $stmt3 = sqlsrv_query( $conn, $qu )or die( print_r( sqlsrv_errors(), true));
            while( $rownn = sqlsrv_fetch_array( $stmt3, SQLSRV_FETCH_ASSOC) ) {
                 echo"Cliente: ".$idCliente= $rownn['ACCOUNTNUM']; 
                 echo"Subsegmento: ".$subsegmento_= $rownn['SUBSEGMENTID']; 
                } 
*/



?>