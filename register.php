<?php
include 'inc/header.php';
Session::CheckLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {

  $register = $users->userRegistration($_POST);
}

if (isset($register)) {
  echo $register;
}


 ?>


<!--  <div class="card ">
   <div class="card-header">
          <h3 class='text-center'>User Registration</h3>
        </div>
        <div class="cad-body">



            <div style="width:600px; margin:0px auto">

            <form class="" action="" method="post">
                <div class="form-group pt-3">
                  <label for="name">Your name</label>
                  <input type="text" name="name"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="username">Your username</label>
                  <input type="text" name="username"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="email">Email address</label>
                  <input type="email" name="email"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="mobile">Mobile Number</label>
                  <input type="text" name="mobile"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" name="password" class="form-control">
                  <input type="hidden" name="roleid" value="3" class="form-control">
                </div>
                <div class="form-group">
                  <button type="submit" name="register" class="btn btn-success">Register</button>
                </div>


            </form>
          </div>


        </div>
      </div>
 -->
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
      <div class="row justify-content-md-center h-100">
        <div class="card-wrapper">
          <div class="brand">
            <img src="img/logo.jpg" alt="bootstrap 4 login page">
          </div>
          <div class="card fat">
            <div class="card-body">
              <h4 class="mt-4 text-center">Đăng ký</h4>
              <form method="POST" class="my-login-validation" novalidate="">
                <div class="form-group">
                  <label for="username" >Tên đăng nhập</label>
                  <input id="username" type="text" class="form-control" name="username" required autofocus>
                  <div class="invalid-feedback">
                    Tên đăng nhập không hợp lệ
                  </div>
                </div>

                <div class="form-group">
                  <label for="password">Mật khẩu</label>
                  <input id="password" type="password" class="form-control" name="password" required data-eye>
                  <div class="invalid-feedback">
                    Mật khẩu không hợp lệ
                  </div>
                </div>

                <div class="form-group">
                  <label for="repassword">Nhập lại mật khẩu</label>
                  <input id="repassword" type="password" class="form-control" name="repassword" required data-eye>
                  <div class="invalid-feedback">
                    Mật khẩu không hợp lệ
                  </div>
                </div>

                <div class="form-group">
                  <label for="email">Địa chỉ email</label>
                  <input id="email" type="email" class="form-control" name="email" required>
                  <div class="invalid-feedback">
                    Địa chỉ email không hợp lệ
                  </div>
                </div>

                <div class="form-group">
                  <label for="phone">Số điện thoại</label>
                  <input id="phone" type="tel" class="form-control" name="mobile" >
<!--                  <div class="invalid-feedback">
                    Vui lòng nhập số điện thoại
                  </div> -->
                </div>


<!--                <div class="form-group">
                  <div class="custom-checkbox custom-control">
                    <input type="checkbox" name="agree" id="agree" class="custom-control-input" required="">
                    <label for="agree" class="custom-control-label">I agree to the <a href="#">Terms and Conditions</a></label>
                    <div class="invalid-feedback">
                      You must agree with our Terms and Conditions
                    </div>
                  </div>
                </div> -->

                <label for="address" >Địa chỉ</label>
                  <input id="address" type="text" class="form-control" name="address" >
<!--                  <div class="invalid-feedback">
                    Vui lòng điền tên đăng nhập 
                  </div> -->
                </div>

                <div class="form-group m-0">
                  <input type="submit" class="btn btn-primary btn-block" name="register" value="Đăng ký">
                </div>
                <div class="mt-4 text-center">
                  Bạn đã có tài khoản? <a href="login.php">Đăng nhập</a>
                </div>

                <div class="form-group">
                  <input type="hidden" name="roleid" value="3" class="form-control">
                </div>
              </form>
            </div>
          </div>
          <div class="footer">

          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="js/my-login.js"></script>
</body>
</html>

  <?php
  include 'inc/footer.php';

  ?>
