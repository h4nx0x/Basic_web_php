<?php
include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId === '1') { ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addUser'])) {

  $userAdd = $users->addNewUserByAdmin($_POST);
}

if (isset($userAdd)) {
  echo $userAdd;
}


 ?>


 <div class="card ">
   <div class="card-header">
          <h3 class='text-center'>Tạo tài khoản mới</h3>
        </div>
        <div class="cad-body">



            <div style="width:600px; margin:0px auto">

            <form class="" action="" method="post">
                <div class="form-group">
                  <label for="username">Tên tài khoản</label>
                  <input type="text" name="username"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="email">Địa chỉ Email</label>
                  <input type="email" name="email"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="mobile">Số điện thoại</label>
                  <input type="text" name="mobile"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="password">Mật khẩu</label>
                  <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                  <label for="password">Nhập lại mật khẩu</label>
                  <input type="password" name="repassword" class="form-control">
                </div>
                <div class="form-group">
                  <label for="address">Địa chỉ</label>
                  <input type="text" name="address"  class="form-control">
                </div>
                <div class="form-group">
                  <div class="form-group">
                    <label for="sel1">Vai trò</label>
                    <select class="form-control" name="roleid" id="roleid">
                      <option value="1">Administrator</option>
                      <option value="2">Nhân viên</option>
                      <option value="3">Khách hàng</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" name="addUser" class="btn btn-success">Tạo tài khoản</button>
                </div>


            </form>
          </div>


        </div>
      </div>

<?php
}else{

  header('Location:index.php');



}
 ?>

  <?php
  include 'inc/footer.php';

  ?>
