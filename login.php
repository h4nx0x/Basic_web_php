<?php
include 'inc/header.php';
Session::CheckLogin();
?>


<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
   $userLog = $users->userLoginAuthotication($_POST);
}
if (isset($userLog)) {
  echo $userLog;
}

$logout = Session::get('logout');
if (isset($logout)) {
  echo $logout;
}



 ?>
<!-- <html>
<style>
img {
  display: block;
  margin-left: auto;
  margin-right: auto;
}
</style>
<div class="card ">
  <div class="card-header">
          <h3 class='text-center'><i class="fas fa-sign-in-alt mr-2"></i>User login</h3>
          <img src="https://scontent.fhan5-9.fna.fbcdn.net/v/t39.30808-6/306564751_1792761487733159_4203876894507020347_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=09cbfe&_nc_ohc=CVWevZ_hZJMAX-Ajxdc&_nc_ht=scontent.fhan5-9.fna&oh=00_AT9ovrZH_07r-IoyQZkUzDTgGu18qga2JpEgzTI85VE5kQ&oe=63480FAA" alt="Trulli" class="center" width="100" height="100">
        </div>
        <div class="card-body">


            <div style="width:450px; margin:0px auto">
            
            <form class="" action="" method="post">
                <div class="form-group">
                  <label for="email">Email address</label>
                  <input type="email" name="email"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" name="password"  class="form-control">
                </div>
                <div class="form-group">
                  <button type="submit" name="login" class="btn btn-success">Login</button>
                </div>


            </form>
          </div>


        </div>
      </div>
      </html> -->


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
      <div class="row justify-content-md-center h-100">
        <div class="card-wrapper">
          <div class="brand">
            <img src="img/logo.jpg" alt="logo">
          </div>
          <div class="card fat">
            <div class="card-body">
              <h4 class="mt-4 text-center">Đăng nhập</h4>
              <form method="POST" class="my-login-validation" novalidate="">
                <div class="form-group">
                  <label for="username">Tên đăng nhập</label>
                  <input id="username" type="text" class="form-control" name="username" value="" required autofocus>
                  <div class="invalid-feedback">
                    Tên đăng nhập không hợp lệ
                  </div>
                </div>

                <div class="form-group">
                  <label for="password">Mật khẩu
                    <a href="forgot.php" class="float-right">
                      Quên mật khẩu?
                    </a>
                  </label>
                  <input id="password" type="password" class="form-control" name="password" required data-eye>
                    <div class="invalid-feedback">
                      Mật khẩu không hợp lệ
                    </div>
                </div>

<!--                 <div class="form-group">
                  <div class="custom-checkbox custom-control">
                    <input type="checkbox" name="remember" id="remember" class="custom-control-input">
                    <label for="remember" class="custom-control-label">Ghi nhớ</label>
                  </div>
                </div> -->

                <div class="form-group m-0">
                <div class="form-group m-0">
                  <input type="submit" class="btn btn-primary btn-block" name="login" value="Đăng nhập">
                </div>
                </div>
                <div class="mt-4 text-center">
                  Bạn chưa có tài khoản? <a href="register.php">Tạo tải khoản</a>
                </div>
              </form>
            </div>
          </div>
<!--          <div class="footer">
            Copyright &copy; 2017 &mdash; Your Company 
          </div> -->
        </div>
      </div>
    </div>
  </section>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="js/my-login.js"></script>
</body>
</html>

  <?php
  include 'inc/footer.php';

  ?>
