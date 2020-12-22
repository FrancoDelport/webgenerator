<?php
include 'database.php';
session_start();
function agregar_dom($dominio){
  		include 'database.php';
  		$idUser=$_SESSION['idUsuario'];
        $dominio=$dominio.$idUser;
		$buscardom=mysqli_query($conexion,"SELECT * FROM Webs WHERE dominio= '$dominio'");
		
			if ($resultado=mysqli_fetch_array($buscardom)>0) 
			{
				echo "<script type='text/javascript'>alert('Sitio Web ya existente');</script>";
			}
		
		else
		{
				$sql = "INSERT INTO Webs (idUsuario,dominio) 
				VALUES ('$idUser','$dominio')";
				$result=mysqli_query($conexion,$sql);
				if ($result)
				{
					//se crea la carpeta del dominio web
					$cmd=shell_exec("./wix.sh $dominio");
					echo "<pre>".$cmd."</pre>";
					//se recarga para actualizar la tabla de dominios web
					header("Location: panel.php");
				}
				else
				{
					echo "<script type='text/javascript'>alert('ERROR AL CREAR SITIO WEB');</script>";
				}		
		}
		
		
}
function descarga($web){
	//se crea el comprimido
$cmd=shell_exec("./bachup.sh $web");
echo '<script type="text/javascript">alert('.$cmd.');</script>';
}
?>
<!DOCTYPE html>
<html lang="es">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
	<title>Panel</title>
	<?php
if (isset($_POST['ingresar'])) 
{
	if ($_POST['dominio'] == "") 
	{
		echo "<script type='text/javascript'>alert('Ingrese nombre de la web');</script>";
	}
	else
	{
		agregar_dom($_POST['dominio']);
	}
	}
?>
</table>
<style type="text/css">
	table, td, th { border: 1px solid; }
</style>
</head>
<body>
	<?php
     if(isset($_SESSION['idUsuario'])){
	$usuario=$_SESSION['idUsuario'];
  echo '<h2>Bienvenido '.$usuario.'</h2><br>';
  echo "<a href='logout.php'>Salir</a><br>";
$result = mysqli_query($conexion,"SELECT * FROM Webs WHERE idUsuario= '$usuario'");    
echo "<table>";  
echo "<tr>";  
echo "<th>IDweb</th>";  
echo "<th>idUsuario</th>"; 
echo "<th>Dominio</th>"; 
echo "<th>Fechacreacion</th>";
echo "<th>Descargas</th>";  
echo "</tr>";  
if ($result) {
	while (($row = mysqli_fetch_array($result))!=NULL){


 echo "<tr>";  
    echo "<td>".$row["idWeb"]."</td>";  
    echo "<td>".$row["idUsuario"]."</td>";  
    echo "<td>".$row["dominio"]."</td>";
    echo "<td>".$row["fechaCreacion"]."</td>";
    echo '<td><form method="get" >';
    echo '<input name="web" type="hidden" value="'.$row["dominio"].'" />';
    echo '<input  type="submit" value="Descargar" name="enviar">';
   echo  ' </form></td>';
    echo "</tr>";  
} 
}
echo "</table>";
}else{echo "Problema no hay SESSION activa";}
?><?php
if (isset($_GET["enviar"])) {
 descarga($_GET["web"]);
 $file=$_GET["web"].".zip";
 echo '<a href="'.$file.'">Archivo comprimido</a>';}
?>
<legend>Crear web de:</legend>
	<form method="post">
		<input type="text" name="dominio" placeholder="nombre de la web">
		<br>
		<input type="submit" value="Crear web" name="ingresar">
		<br>
    </form>
</body>
</html>