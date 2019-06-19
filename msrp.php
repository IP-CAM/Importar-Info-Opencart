<?php 
ini_set('max_execution_time', 99999999999999999999999999999999999999999999999999999999999);
$fecha1 = date('Ymd'); 
$fecha = date('Ymd H:i:s');  

$serverName1 = "10.17.1.38,1433";
$connectionInfo1 = array( "Database"=>"adn", "UID"=>"opencart", "PWD"=>"Op3nc4rt!");
$conn1 = sqlsrv_connect( $serverName1, $connectionInfo1 );
if( $conn1 === false ) {
    die( print_r( sqlsrv_errors(), true));
} 
$con = mysqli_connect("127.0.0.1","magento2","magento2","msrp");
           // $_SESSION['uid'] = 1;
            if(!$con){
                echo"connection failed";
            }
            if (mysqli_connect_errno())
              {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
              }   
$con1 = mysqli_connect("127.0.0.1","magento2","magento2","mes_seguro");
           // $_SESSION['uid'] = 1;
            if(!$con1){
                echo"connection failed";
            }
            if (mysqli_connect_errno())
              {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
              }                 
echo"1<br>";


$sql_srv1 = " 
Select distinct  t1.ModID as sku,t4.ClassID as Jearquia1,t4.Product as Jearquia2,t4.Type as Jearquia3,
t1.TitleProduct as DescCorta,t1.MSRP as Precio,t2.BrandName as Marca,t1.DescSmall as DescTecnica,t1.Benefits as Beneficios,t1.Commercial as DescComecial,t1.Usability as Usabilidad,t1.Notes as Notas,t1.Compatibility as Compatibilidad,
t1.FileCommercial as FichaComercial,t1.FileTechnique as FichaTecnica,t1.Installation as ManualInstalacion,t1.UserManual as ManualDeUsuario,
t3.MainPicture as ImagenPrincipal,t3.Picture1 as ImagenSecundaria1,t3.Picture2 as ImagenSecundaria2,t3.Picture3 as ImagenSecundaria3,t3.Picture4 as ImagenSecundaria4,t3.Picture5 as ImagenSecundaria5
from Model t1 
inner join Brand t2 on t2.BrandID = t1.BrandID 
left  join Resources t3 on t3.ModID = t1.ModID 
inner join Model_Product t4 on t4.ModID=t1.ModID  order by t1.ModID ASC";

$stm1 = sqlsrv_query( $conn1, $sql_srv1 );
while($Data1 = sqlsrv_fetch_array( $stm1, SQLSRV_FETCH_ASSOC)){

$Sku = $Data1['sku'];
$Precio = $Data1['Precio'];

$sq = 'SELECT * from descuento_rem where Producto = "'.$Sku.'"';  
$re = mysqli_query($con1, $sq); 
$ro = mysqli_fetch_array($re);
$prod = $ro['Producto'];
$descuento = $ro['Descuento'];

$precio_c_descu=$Precio * $descuento / 100;
$precio_real0=($precio_c_descu) - ($Precio);
$precio_real=substr($precio_real0,1);



//SIN DESCUENTO

if ($descuento=="" || $prod=="") {

$sql = 'SELECT * from precio_art where Producto = "'.$Sku.'"';  
$res = mysqli_query($con, $sql); 
$row = mysqli_fetch_array($res);
$produ = $row['Producto'];
$descuenton = $row['Descuento'];

if (!$produ=="") {
	echo"Producto ".$produ." Ya Existe<br>";
}

if ($produ=="") {

	echo"este producto no cuenta con Descuento: ".$Sku."<br>";
	$sql5 = mysqli_query($con, "INSERT INTO precio_art (Producto,MSRP1) VALUES ('".$Sku."','".$Precio."') ") or die('Error de ejecución1: ' . mysqli_connect_error($sql5));

}

	
}



//CON DESCUENTO

if (!$descuento=="" || !$prod=="") {


$sql = 'SELECT * from precio_art where Producto = "'.$Sku.'"';  
$res = mysqli_query($con, $sql); 
$row = mysqli_fetch_array($res);
$produ = $row['Producto'];
$descuenton = $row['Descuento'];

if (!$produ=="") {
	echo"Producto ".$produ." Ya Existe<br>";
}

if ($produ=="") {

	echo"Producto <strong>".$prod."</strong> insertado, MSRP: <strong>".$Precio."</strong> Descuento: <strong>".$descuento."%</strong> PRecio Final: <strong>".$precio_real."</strong><br>";
	$sql5 = mysqli_query($con, "INSERT INTO precio_art (Producto,MSRP1,Descuento,MSRP2) VALUES ('".$prod."','".$Precio."','".$descuento."','".$precio_real."') ") or die('Error de ejecución2: ' . mysqli_connect_error($sql5));
}

	
}




 


}


















/*

 $sq = '
SELECT DISTINCT sku,value FROM catalog_product_entity,catalog_product_entity_decimal WHERE catalog_product_entity.entity_id = catalog_product_entity_decimal.entity_id AND catalog_product_entity_decimal.value is not NULL
 ';  
 $re = mysqli_query($con, $sq); 
 while($ro = mysqli_fetch_array($re)){
 echo$sku = $ro['sku']."<br>";
 echo$precio = $ro['value']."<br><br><br>";
}
*/

?>