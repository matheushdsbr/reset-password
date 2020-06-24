<!doctype html>
<html lang="pt-br">
  <head>
	<title>Recuperar Senha - Pessoa Física</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
		<div class="container">
			<div class="row justify-content-center mt-5">
				<div class="col-5">
					<h2 class="text-align-center">Recuperar Senha</h2>

					<?php
						if (isset($_GET["reset"])) {
							if ($_GET["reset"] == "success") {
								echo '<p class="text-success text-center">Verifique seu e-mail!</p>';
							}
							elseif ($_GET["reset"] == "fail") {
								echo '<p class="text-danger text-center">Digite um E-mail cadastrado!</p>';
							}
						}
					?>

          <form action="includes/reset-password-inc-pf.php" method="POST">
						<p class="my-4">Informe seu email cadastrado e nós enviaremos um link para você resetar sua senha.</p>
            <input type="text" name="email" placeholder="Insira aqui seu endereço de E-mail" class="form-control"><br>
            <button type="submit" name="reset-password-submit" class="btn btn-success col-4 offset-4">Enviar</button><br><br>
            <a href="login-pf.php">Voltar para fazer Login</a><br><br>
          </form>
				</div>
      </div>
		</div>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>