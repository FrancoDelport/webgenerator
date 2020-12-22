<?php
$alert ="";
if (isset($_POST['registrar'])) 
{
	if ($_POST['email'] == "" && $_POST['contraseña']== "" && $_POST['r-contraseña']=="") 
	{
		$alert = "<p>Por favor llene todos los campos</p>";
	}
	else
	{
		include 'database.php';

		$email =$_POST['email'];
		$password =$_POST['contraseña'];
		$rep_password =$_POST['r-contraseña'];

		$buscaremail=mysqli_query($conexion,"SELECT * FROM usuarios WHERE email= '$email'");
		
		if ($resultado=mysqli_fetch_array($buscaremail)>0) 
		{
			$alert = "<p>Email registrado</p>";
		}
		else
		{
			if ($password == $rep_password) 
			{
				$sql = "INSERT INTO usuarios (email,password) 
				VALUES ('$email','$password')";
				$result=mysqli_query($conexion,$sql);
				if ($result)
				{
					header ("Location: login.php");
				}
				else
				{
					$alert = "<p>Error al crear el usuario</p>";
				}		
			}
			else
			{
				$alert = "<p>La contraseña no coinciden</p>";
			}
		}
		
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register</title>
</head>
<body>
<center>
	<h1>Registrarse es Simple</h1>
	<div class="alert">
		<?php 
		echo isset($alert) ? $alert :''; 
		?>		
	</div>
	<form action="" method="POST">
		<input type="email" name="email" placeholder="Email" checked>
		<br>
		<input type="password" name="contraseña" placeholder="Contraseña" checked>
		<br>
		<input type="password" name="r-contraseña" placeholder="Repetir Contraseña" checked>
		<br>
		<input type="submit" name="registrar" value="Registrar">
	</form>
</center>
</body>
</html>