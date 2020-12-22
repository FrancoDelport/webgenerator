<?php 
session_start();
$alert ="";
if (isset($_POST['ingresar'])) 
{
	if ($_POST['email']=="" && $_POST['password']=="") 
	{
		$alert = "<p>Por favor llene todos los campos</p>";
	}
	else
	{
		include 'database.php';

		$email =$_POST['email'];
		$password =$_POST['password'];
		$sql = "SELECT * FROM usuarios WHERE email= '$email' AND password='$password'";
		if ($result = mysqli_query($conexion, $sql)) 
		{
		  	while ($row = mysqli_fetch_row($result)) 
		  	{
		    	$_SESSION['idUsuario'] = $row[0];
				header ("Location: panel.php");	
  			}
  			mysqli_free_result($result);
		}
			$alert = "<p>Error al ingresar a la cuenta verifique si el email 
			y la contraseña este bien puesta</p>";
		
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<center>
	<h1>Webgenerator</h1>
	<form action="" method="POST">
		<div class="alert">
			<?php 
			echo isset($alert) ? $alert :''; 
			?>		
		</div>
		<input type="email" name="email" placeholder="Email">
		<br>
		<input type="password" name="password" placeholder="Contraseña">
		<br>
		<input type="submit" value="Ingresar" name="ingresar">
		<br>
		<a href="register.php">Registrate</a>
	</form>
</center>
</body>
</html>