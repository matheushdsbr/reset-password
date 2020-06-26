<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<title>Celke - Login</title>
	</head>
	<body class="mx-2 mt-2">
		<h2>Área restrita</h2>
		<?php
			if(isset($_SESSION['msg'])){
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
			if(isset($_SESSION['msgcad'])){
				echo $_SESSION['msgcad'];
				unset($_SESSION['msgcad']);
			}
		?>

		<?php
			if (isset($_GET["newpwd"])) {
				if ($_GET["newpwd"] == "passwordupdated") {
					echo '<p class="text-success">Sua senha foi redefinida!</p>';
				}
			}
		?>

		<form method="POST" action="valida.php">
			<label>Usuário</label>
			<input type="text" name="usuario" placeholder="Digite o seu usuário"><br><br>

			<label>Senha</label>
			<input type="password" name="senha" placeholder="Digite a sua senha"><br><br>

			<input type="submit" name="btnLogin" value="Acessar">

			<br><br>Você ainda não possui uma conta?
			<a href="cadastrar-pj.php">Crie grátis</a>


			<p class="mt-2"><a href="reset-password-pj.php">Esqueceu sua senha?</a></p>


		</form>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>