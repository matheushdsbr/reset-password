<?php
  require 'conexao.php';

  if (isset($_POST["reset-password-submit"])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $query = "SELECT * FROM usuariosPF WHERE email='$email'";
    $run = mysqli_query($conn, $query);
    if(mysqli_num_rows($run)>0){
      $selector = bin2hex(random_bytes(8));
      $token = random_bytes(32);

      $url = "https://www.hagile.com.br/projetos/teste-sistema-matheus/complexo-seguro/pessoa-fisica/create-new-password-pf.php?selector=" . $selector . "&validator=" . bin2hex($token);

      $expires = date("U") + 3600;

      $usuarioEmail = $_POST["email"];

      $sql = "DELETE FROM pwdResetPF WHERE pwdResetEmail=?;";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
      } else {
        mysqli_stmt_bind_param($stmt, "s", $usuarioEmail);
        mysqli_stmt_execute($stmt);
      }

      $sql = "INSERT INTO pwdResetPF (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
      } else {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $usuarioEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
      }

      mysqli_stmt_close($stmt);
      mysqli_close($conn);

      $to = $usuarioEmail;
      $subject = 'Redefina sua senha';

      $message = '<p>Nós recebemos uma solicitação para redefinição de senha. O link para redefinir sua senha está logo abaixo, se você não solicitou a redefinição da sua senha, ignore este email.</p>';

      $message .= '<p>Clique ';
      $message .= '<a href="' . $url . '">aqui</a>';
      $message .= ' para Redefinir sua senha.</p>';

      $headers = "From: Hagile Agência Digital <matheushds.br@gmail.com> \r\n";
      $headers .= "Reply-To: matheushds.br@gmail.com\r\n";
      $headers .= "Content-type: text/html\r\n";

      mail($to, $subject, $message, $headers);

      header("Location: ../reset-password-pf.php?reset=success");

    }else {
      header("Location: ../reset-password-pf.php?reset=fail");
    }
  }else {
    header("Location: ../login-pf.php");
  }