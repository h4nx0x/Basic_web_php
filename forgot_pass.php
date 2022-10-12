<!DOCTYPE html>
<html lang="en">

<?php
  require 'lib/dbconnect.php';
  session_start();

  if (  isset($_POST['email']) ) {
    
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email không hợp lệ!!'); window.location= 'forgot_pass.php'</script>";
        exit();
    }

    
    $query = $conn->prepare("SELECT email FROM tbl_users WHERE email=?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

     if($result->num_rows == 0) {    
        echo "<script>alert('Email chưa đăng kí thành viên!!'); window.location= 'forgot_pass.php'</script>";
        exit();
    }
    else {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
       
        $new_pass = generate_string($permitted_chars, 8);
        $query = $conn->prepare("UPDATE tbl_users SET password =? WHERE email=?");
        $pass_new = SHA1($new_pass); 
        $query->bind_param("ss",  $pass_new, $email);
        $query->execute();
        
        if(SendMail($email, $new_pass)){
            echo "<script>alert('Thay đổi mật khẩu thành công, vui lòng kiểm tra mail!!'); window.location= 'forgot_pass.php'</script>";
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
            $noidungthu = "Mật khẩu mới của bạn {$new_pass}"; 
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
<head>
    <title>Register</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/3.3/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>


<div class="container">
    <div class="header">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation" class="active"><a href="/webshop">Home</a>
                </li>
                <li role="presentation"><a href="login.php" class="btn btn-link pull-right">Login</a>
                </li>
            </ul>
        </nav>
        <h1 class="text-muted">Forgot Password</h1>
    </div>

    <div class="jumbotron" style="color: red !important;">
        <p class="lead"></p>
        <div class="login-form">
            <form role="form" action="forgot_pass.php" method="post">
               
                <div class="form-group">
                    <input type="text" name="email" id="email" class="form-control input-lg" placeholder="Email">
                </div>
               
        </div>
        <div class="row" >
            <div class="col-xs-13 col-sm-13 col-md-13" style="color: red;">
                <input type="submit" class="btn btn-lg btn-success btn-block" value="Send Mail">
            </div>
        </div>
        </form>
        <?php
            if(isset($_SESSION['user'])) {
                echo "<script>alert('Bạn đã đăng nhập rồi!!'); window.location='index.php';</script>";
            }
        ?>
    </div>

</div>
</body>

</html>