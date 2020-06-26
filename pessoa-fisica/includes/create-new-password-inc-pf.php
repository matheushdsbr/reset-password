<?php
  if (isset($_POST["reset-password-submit"])) {
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];

    if (empty($password) || empty($passwordRepeat)) {
      header("Location: ../create-new-password-pf.php?newpwd=empty");
      exit();
    } else if ($password != $passwordRepeat) {
      header("Location: ../create-new-password-pf.php?newpwd=pwdnotsame");
      exit();
    }

    $currentDate = date("U");

    require 'conexao.php';

    $sql = "SELECT * FROM pwdResetPF WHERE pwdResetSelector=? AND pwdResetExpires >= ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo "Ocorreu um erro!";
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
      mysqli_stmt_execute($stmt);

      $result = mysqli_stmt_get_result($stmt);
      if (!$row = mysqli_fetch_assoc($result)) {
        echo "Você precisa re-enviar sua solicitação de redefinição de senha. 1";
        exit();
      } else {
        $tokenBin = hex2bin($validator);
        $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

        if ($tokenCheck === false) {
          echo "Você precisa re-enviar sua solicitação de redefinição de senha. 2";
          exit();
        } elseif ($tokenCheck === true) {
          $tokenEmail = $row['pwdResetEmail'];
          $sql = "SELECT * FROM usuariosPF WHERE email=?;";
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "Ocorreu um erro!";
            exit();
          } else {
            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (!$row = mysqli_fetch_assoc($result)) {
              echo "Ocorreu um erro!";
              exit();
            } else {
              $sql = "UPDATE usuariosPF SET senha=? WHERE email=?";
              $stmt = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "Ocorreu um erro!";
                exit();
              } else {
                $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                mysqli_stmt_execute($stmt);

                $sql = "DELETE FROM pwdResetPF WHERE pwdResetEmail=?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                  echo "Ocorreu um erro!";
                  exit();
                } else {
                  mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                  mysqli_stmt_execute($stmt);
                  header("Location: ../login-pf.php?newpwd=passwordupdated");
                }
              }
            }
          }
        }
      }
    }
  } else {
    header("Location: ../login-pf.php");
  }