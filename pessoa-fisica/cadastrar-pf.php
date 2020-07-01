<?php
session_start();
ob_start();

$errors = array();

$nome = "";
$email = "";
$cpf = "";
$rg = "";
$crmv = "";
$telefone = "";
$cep = "";
$rua = "";
$numerocasa = "";
$complemento = "";
$estado = "";
$cidade = "";
$bairro = "";

$btnCadUsuario = filter_input(INPUT_POST, 'btnCadUsuario', FILTER_SANITIZE_STRING);
if($btnCadUsuario){
	include_once 'includes/conexao.php';

	$nome = $_POST['nome'];
  $email = $_POST['email'];
  $cpf = $_POST['cpf'];
  $rg = $_POST['rg'];
  $crmv = $_POST['crmv'];
  $telefone = $_POST['telefone'];
  $cep = $_POST['cep'];
  $rua = $_POST['rua'];
  $numerocasa = $_POST['numerocasa'];
  $complemento = $_POST['complemento'];
  $estado = $_POST['estado'];
  $cidade = $_POST['cidade'];
  $bairro = $_POST['bairro'];
	$senha = $_POST['senha'];
	$confsenha = $_POST['confsenha'];

	$dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	$erro = false;

	$dados_st = array_map('strip_tags', $dados_rc);
	$dados = array_map('trim', $dados_st);

	if(in_array('',$dados)){
		$erro = true;
		$_SESSION['msg'] = "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>swal('Atenção', 'VOCÊ PRECISA PREENCHER TODOS OS CAMPOS!', 'warning');</SCRIPT>";

		if (empty($nome)) {
			$bordaErroNome = 'border: 2px solid red;';
			$errors['nome'] = '<p class="text-danger">*Preencha o campo Nome</p>';
		}
		if (empty($email)) {
			$bordaErroEmail = 'border: 2px solid red;';
			$errors['email'] = '<p class="text-danger">*Preencha o campo E-mail</p>';
		}

    if (empty($cpf)) {
			$bordaErroCPF = 'border: 2px solid red;';
			$errors['cpf'] = '<p class="text-danger">*Preencha o campo de CPF</p>';
		}

		if (empty($rg)) {
			$bordaErroRG = 'border: 2px solid red;';
			$errors['rg'] = '<p class="text-danger">*Preencha o campo de RG</p>';
    }

    if (empty($crmv)) {
			$bordaErroCRMV = 'border: 2px solid red;';
			$errors['crmv'] = '<p class="text-danger">*Preencha o campo CRMV</p>';
    }

    if (empty($telefone)) {
			$bordaErroTelefone = 'border: 2px solid red;';
			$errors['telefone'] = '<p class="text-danger">*Preencha o campo telefone</p>';
    }

    if (empty($cep)) {
			$bordaErroCEP = 'border: 2px solid red;';
			$errors['cep'] = '<p class="text-danger">*Preencha o campo CEP</p>';
    }

    if (empty($rua)) {
			$bordaErroRua = 'border: 2px solid red;';
			$errors['rua'] = '<p class="text-danger">*Preencha o campo rua</p>';
    }

    if (empty($numerocasa)) {
			$bordaErroNCASA = 'border: 2px solid red;';
			$errors['numerocasa'] = '<p class="text-danger">*Preencha o campo numerocasa</p>';
    }

    if (empty($complemento)) {
			$bordaErroComplemento = 'border: 2px solid red;';
			$errors['email'] = '<p class="text-danger">*Preencha o campo E-mail</p>';
    }

    if (empty($estado)) {
			$bordaErroEstado = 'border: 2px solid red;';
			$errors['estado'] = '<p class="text-danger">*Preencha o campo estado</p>';
    }

    if (empty($cidade)) {
			$bordaErroCidade = 'border: 2px solid red;';
			$errors['cidade'] = '<p class="text-danger">*Preencha o campo cidade</p>';
    }

    if (empty($bairro)) {
			$bordaErroBairro = 'border: 2px solid red;';
			$errors['bairro'] = '<p class="text-danger">*Preencha o campo bairro</p>';
		}

		if (empty($senha)) {
			$bordaErroSenha = 'border: 2px solid red;';
			$errors['senha'] = '<p class="text-danger">*Preencha o campo Senha</p>';
		}

		if (empty($confsenha)) {
			$bordaErroConfSenha = 'border: 2px solid red;';
			$errors['confsenha'] = '<p class="text-danger">*Preencha o campo Confirmar Senha</p>';
		}

		if ($dados['senha'] !== $dados['confsenha']) {
			$bordaErroSenha = 'border: 2px solid red;';
			$bordaErroConfSenha = 'border: 2px solid red;';
			$errors['senha'] = '<p class="text-danger">*Senhas não combinam</p>';
		}

	}

	elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$erro = true;
		$bordaErroEmail = 'border: 2px solid red;';
		$errors['email'] = '<p class="text-danger">*E-mail Inválido</p>';
		$_SESSION['msg'] = "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>swal('Atenção', 'E-MAIL INVÁLIDO', 'warning');</SCRIPT>";
	}

	elseif ($dados['senha'] !== $dados['confsenha']) {
		$erro = true;
		$bordaErroSenha = 'border: 2px solid red;';
		$bordaErroConfSenha = 'border: 2px solid red;';
		$errors['senha'] = '<p class="text-danger">*Senhas não combinam</p>';
		$_SESSION['msg'] = "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>swal('Atenção', 'SENHAS NÃO COMBINAM', 'warning');</SCRIPT>";
	}

	else{
    $erroEmail = "";
    $erroCPF = "";
    $erroRG = "";

		$result_usuario = "SELECT id FROM usuariosPF WHERE email='". $dados['email'] ."'";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
			$erro = true;
			$errors['email'] = '<p class="text-danger">Este e-mail já está cadastrado</p>';

			$bordaErroEmail = 'border: 2px solid red;';
			$erroEmail = "EMAIL,";
    }

    $result_usuario = "SELECT id FROM usuariosPF WHERE cpf='". $dados['cpf'] ."'";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
			$erro = true;
			$errors['cpf'] = '<p class="text-danger">Este CPF já está cadastrado</p>';

			$bordaErroCPF = 'border: 2px solid red;';
			$erroCPF = "CPF,";
		}

    $result_usuario = "SELECT id FROM usuariosPF WHERE rg='". $dados['rg'] ."'";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
			$erro = true;
			$errors['rg'] = '<p class="text-danger">Este RG já está cadastrado</p>';

			$bordaErroRG = 'border: 2px solid red;';
			$erroRG = "RG,";
		}

		if ($erro) {
			$_SESSION['msg'] = "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>swal('Atenção', ' $erroEmail $erroCPF $erroRG JÁ CADASTRADO', 'warning');</SCRIPT>";
		}
	}

	if(!$erro){

		$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

		$result_usuario = "INSERT INTO usuariosPF (nome, email, senha, cpf, rg, crmv, telefone, cep, rua, numerocasa, complemento, estado, cidade, bairro) VALUES (
						'" .$dados['nome']. "',
						'" .$dados['email']. "',
						'" .$dados['senha']. "',
            '" .$dados['cpf']. "',
            '" .$dados['rg']. "',
            '" .$dados['crmv']. "',
            '" .$dados['telefone']. "',
            '" .$dados['cep']. "',
            '" .$dados['rua']. "',
            '" .$dados['numerocasa']. "',
            '" .$dados['complemento']. "',
            '" .$dados['estado']. "',
            '" .$dados['cidade']. "',
            '" .$dados['bairro']. "'
						)";
		$resultado_usario = mysqli_query($conn, $result_usuario);
		if(mysqli_insert_id($conn)){
			$_SESSION['msgcad'] = '<p class="text-success">Usuário cadastrado com sucesso</p>';
			header("Location: login-pf.php");
		}else{
			$_SESSION['msg'] = '<p class="text-danger">Erro ao cadastrar o usuário</p>';
		}
	}

}
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<title>Celke - Cadastrar</title>
	</head>
	<body class="mx-2 mt-2">
		<h2>Cadastro</h2>
		<?php
			if(isset($_SESSION['msg'])){
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
		?>

		<?php if(count($errors) > 0): ?>
				<?php foreach($errors as $error): ?>
					<?php echo $error ?>
				<?php endforeach; ?>
		<?php endif; ?>

		<form method="POST" action="">
			<label>Nome</label>
			<input type="text" style="<?php echo $bordaErroNome; ?>" name="nome" value="<?php echo $nome; ?>" placeholder="Digite o nome e o sobrenome" ><br><br>

			<label>E-mail</label>
			<input type="text" style="<?php echo $bordaErroEmail; ?>" name="email" value="<?php echo $email; ?>" placeholder="Digite o seu e-mail" ><br><br>

			<label>CPF</label>
			<input type="text" style="<?php echo $bordaErroCPF; ?>" name="cpf" value="<?php echo $cpf; ?>" placeholder="Digite o seu CPF" ><br><br>

			<label>RG</label>
			<input type="text" style="<?php echo $bordaErroRG; ?>" name="rg" value="<?php echo $rg; ?>" placeholder="Digite o seu RG" ><br><br>

      <label>CRMV</label>
			<input type="text" style="<?php echo $bordaErroCRMV; ?>" name="crmv" value="<?php echo $crmv; ?>" placeholder="Digite o seu CRMV" ><br><br>

      <label>Telefone</label>
			<input type="text" style="<?php echo $bordaErroTelefone; ?>" name="telefone" value="<?php echo $telefone; ?>" placeholder="Digite seu número para contato" ><br><br>

      <label>CEP</label>
			<input type="text" style="<?php echo $bordaErroCEP; ?>" name="cep" value="<?php echo $cep; ?>" placeholder="Digite o seu CEP" ><br><br>

      <label>Rua</label>
			<input type="text" style="<?php echo $bordaErroRua; ?>" name="rua" value="<?php echo $rua; ?>" placeholder="Digite a sua Rua" ><br><br>

      <label>N° Casa</label>
			<input type="text" style="<?php echo $bordaErroNCASA; ?>" name="numerocasa" value="<?php echo $numerocasa; ?>" placeholder="Digite o numero da sua casa" ><br><br>

      <label>Complemento</label>
			<input type="text" style="<?php echo $bordaErroComplemento; ?>" name="complemento" value="<?php echo $complemento; ?>" placeholder="Digite o complemento da sua residencia" ><br><br>

      <label>Estado</label>
			<input type="text" style="<?php echo $bordaErroEstado; ?>" name="estado" value="<?php echo $estado; ?>" placeholder="Digite o seu estado" ><br><br>

      <label>Cidade</label>
			<input type="text" style="<?php echo $bordaErroCidade; ?>" name="cidade" value="<?php echo $cidade; ?>" placeholder="Digite o sua Cidade" ><br><br>

      <label>Bairro</label>
			<input type="text" style="<?php echo $bordaErroBairro; ?>" name="bairro" value="<?php echo $bairro; ?>" placeholder="Digite o seu bairro" ><br><br>

			<label>Senha</label>
			<input type="password" style="<?php echo $bordaErroSenha; ?>" name="senha" placeholder="Digite a senha" ><br><br>

			<label>Confirme sua senha</label>
			<input type="password" style="<?php echo $bordaErroConfSenha; ?>" name="confsenha" placeholder="Repita sua senha" ><br><br>

			<input type="submit" name="btnCadUsuario" value="Cadastrar"><br><br>

			<p>Lembrou? <a href="login-pf.php">Clique aqui</a> para logar</p>

		</form>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	</body>
</html>