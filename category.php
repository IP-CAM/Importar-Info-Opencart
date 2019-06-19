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


$sql_srv1 = " 
Select distinct t1.ModID as sku,t4.ClassID as Jearquia1,t4.Product as Jearquia2,t4.Type as Jearquia3,
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
$Marca = $Data1['Marca'];
$DescTecnica = $Data1['DescTecnica'];
$Beneficios = $Data1['Beneficios'];
$DescComercial = $Data1['DescComecial'];
$Usabilidad = $Data1['Usabilidad'];
$Notas = $Data1['Notas'];
$Img = $Data1['ImagenPrincipal'];

//echo"<br><br><br>";
//echo"SELECT * from oc_product where  sku = '".$Sku."'";
$sql1 = "SELECT * from oc_product where sku = '".$Sku."'";
$result1 = mysqli_query($con, $sql1); 
$row1 = mysqli_fetch_array($result1);
$IDsku=$row1['product_id'];

$sql2 = "SELECT * from oc_category_description where  name like '%".$Jerarquia1."%'";
$result2 = mysqli_query($con, $sql2); 
$row2 = mysqli_fetch_array($result2);
$category_id=$row2['category_id'];

$sql22 = "SELECT * from oc_category_description where  name like '%".$Jerarquia2."%'";
$result22 = mysqli_query($con, $sql22); 
$row22 = mysqli_fetch_array($result22);
$category_id1=$row22['category_id'];

$sql222 = "SELECT * from oc_category_description where  name like '%".$Jerarquia3."%'";
$result222 = mysqli_query($con, $sql222); 
$row222 = mysqli_fetch_array($result222);
$category_id2=$row222['category_id'];

 $sql4 = "SELECT * from oc_product_to_category where  product_id = '".$IDsku."'";  
 $result4 = mysqli_query($con, $sql4); 
 $row4 = mysqli_fetch_array($result4);
 $id_product_cat=$row4['product_id'];
 $id__cat=$row4['category_id'];


 if ($IDsku==$id_product_cat && $category_id== $id__cat) {
  
  echo"Articulo:".$Sku." Con categoria:".$category_id." YA EXISTE <br><br>";

 }else{

  if ( !$category_id=="") {
  echo"<hr><br>";  
  echo"<strong>MODELO:</strong> ".$Sku."<br>";    
  echo"INSERT INTO oc_product_to_category (product_id,category_id) VALUES (".$IDsku.",".$category_id.")<br>";

  if ($IDsku=="") {
    echo"<br>Producto: ".$Sku." No existe en tabla: 'oc_product'<br>";
    break;
  }


// EVALUA JERARQUIA 3

   if ($category_id2 == "") {

  $sql5 = mysqli_query($con, "INSERT INTO oc_product_to_category (product_id,category_id) VALUES (".$IDsku.",".$category_id.") ") or die('Error de ejecución1: ' . mysqli_connect_error($sql5));
    echo"INSERT INTO oc_product_to_category (product_id,category_id) VALUES (".$IDsku.",".$category_id1.")<br> ";
    $sql6 = mysqli_query($con, "INSERT INTO oc_product_to_category (product_id,category_id) VALUES (".$IDsku.",".$category_id1.") ") or die('Error de ejecución2: ' . mysqli_connect_error($sql6));
    echo"Jerarquia3 no coincide con categoria en E-commerce<br>";

    }
   if (!$category_id2 == "") {
      
       $sql5 = mysqli_query($con, "INSERT INTO oc_product_to_category (product_id,category_id) VALUES (".$IDsku.",".$category_id.") ") or die('Error de ejecución1: ' . mysqli_connect_error($sql5));
  echo"INSERT INTO oc_product_to_category (product_id,category_id) VALUES (".$IDsku.",".$category_id1.")<br> ";
    $sql6 = mysqli_query($con, "INSERT INTO oc_product_to_category (product_id,category_id) VALUES (".$IDsku.",".$category_id1.") ") or die('Error de ejecución2: ' . mysqli_connect_error($sql6));
     echo"INSERT INTO oc_product_to_category (product_id,category_id) VALUES (".$IDsku.",".$category_id2.")<br><br> ";
    $sql7 = mysqli_query($con, "INSERT INTO oc_product_to_category (product_id,category_id) VALUES (".$IDsku.",".$category_id2.") ") or die('Error de ejecución3: ' . mysqli_connect_error($sql7));  
      
    }  

  echo"Producto: ".$Sku." insertado con categoria ".$category_id." <br>";
  echo"Producto: ".$Sku." insertado con categoria ".$category_id1." <br>";
  echo"Producto: ".$Sku." insertado con categoria ".$category_id2." <br>";
  echo"<hr>";  

  }else{
    echo"<br>no se encontro la categoria del producto :( <br>";
  }

 //echo"INSERTADO:".$Sku." Con categoria:".$category_id;
 }

/*
$sql4 = mysqli_query($con, "INSERT INTO oc_product_to_category (product_id,category_id) VALUES (64,33) ") or die('Error de conexión5: ' . mysqli_connect_error($sql4));
echo"Articulo".$Sku." Insertado";

*/



}


?>