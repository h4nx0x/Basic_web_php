<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>h4nx0x</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center align-items-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="img/logo.jpg" alt="bootstrap 4 login page">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Quên mật khẩu</h4>
							<form method="POST" class="my-login-validation" novalidate="">
								<div class="form-group">
									<label for="email">Địa chỉ E-Mail </label>
									<input id="email" type="email" class="form-control" name="email" value="" required autofocus>
									<div class="invalid-feedback">
										Địa chỉ email không hợp lệ
									</div>
									<div class="form-text text-muted">
										
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Reset mật khẩu
									</button>
								</div>
								<div class="mt-4 text-center">
									Bạn chưa có tài khoản? <a href="register.php">Tạo tải khoản</a>
								</div>

								<div class="mt-4 text-center">
									<a href="login.php">Đăng nhập</a>
								</div>

							</form>
						</div>
					</div>
<!-- 					<div class="footer">
						Copyright &copy; 2017 &mdash; Your Company 
					</div> -->
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="js/my-login.js"></script>
</body>
</html>

<?php
  require 'lib/dbconnect.php';
  session_start();

  if (  isset($_POST['email']) ) {
    
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email không hợp lệ!!'); window.location= 'forgot.php'</script>";
        exit();
    }

    
    $query = $conn->prepare("SELECT email FROM tbl_users WHERE email=?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

     if($result->num_rows == 0) {    
        echo "<script>alert('Vui lòng kiểm tra Email !'); window.location= 'forgot.php'</script>";
        exit();
    }
    else {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
       
        $new_pass = generate_string($permitted_chars, 8);
        $query = $conn->prepare("UPDATE tbl_users SET password =? WHERE email=?");
        $pass_new = sha1($new_pass);
        $query->bind_param("ss",  $pass_new, $email);
        $query->execute();
        
        if(SendMail($email, $new_pass)){
            echo "<script>alert('Vui lòng kiểm tra Email !'); window.location= 'forgot.php'</script>";
        }

    } 
  }
?>
<?php 
     function generate_string($input, $strength = 16) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
         }
?>

<?php

    function SendMail($email, $new_pass){
        
        require "PHPMailer-master/src/PHPMailer.php"; 
        require "PHPMailer-master/src/SMTP.php"; 
        require 'PHPMailer-master/src/Exception.php'; 
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);//true:enables exceptions
        try {
            $mail->SMTPDebug = 0; //0,1,2: chế độ debug
            $mail->isSMTP();  
            $mail->CharSet  = "utf-8";
            $mail->Host = 'smtp.gmail.com';  //SMTP servers
            $mail->SMTPAuth = true; // Enable authentication
            $mail->Username = 'portswigger1009@gmail.com'; // SMTP username
            $mail->Password = 'szxgvlxiwtnkawzl';   // SMTP password
            $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
            $mail->Port = 465;  // port to connect to                
            $mail->setFrom('portswigger1009@gmail.com', 'WEB' ); 
            $mail->addAddress($email); 
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = 'Mật khẩu mới';
            $noidungthu = "Mật khẩu mới của bạn sau khi reset là : {$new_pass}"; 
            $mail->Body = $noidungthu;
            $mail->smtpConnect( array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true
                )
            ));
            $mail->send();
            return 1;
        } catch (Exception $e) {
            echo 'Error: ', $mail->ErrorInfo;
            return 0;
        }
    }
?>