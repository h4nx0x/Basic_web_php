<?php
include 'inc/header.php';

Session::CheckSession();

$logMsg = Session::get('logMsg');
if (isset($logMsg)) {
  echo $logMsg;
}
$msg = Session::get('msg');
if (isset($msg)) {
  echo $msg;
}
Session::set("msg", NULL);
Session::set("logMsg", NULL);
?>
<?php

if (isset($_GET['remove'])) {
  $remove = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['remove']);
  $removeUser = $users->deleteUserById($remove);
}

if (isset($removeUser)) {
  echo $removeUser;
}
if (isset($_GET['deactive'])) {
  $deactive = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['deactive']);
  $deactiveId = $users->userDeactiveByAdmin($deactive);
}

if (isset($deactiveId)) {
  echo $deactiveId;
}
if (isset($_GET['active'])) {
  $active = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['active']);
  $activeId = $users->userActiveByAdmin($active);
}

if (isset($activeId)) {
  echo $activeId;
}


 ?>
      <div class="card ">
        <div class="card-header">
          <h3> <span class="float-right">Xin chào  <strong>
            <span class="badge badge-lg badge-secondary text-white">
<?php
$username = Session::get('username');
if (isset($username)) {
  echo $username;
}
 ?></span>

          </strong></span></h3>
        </div>

<?php if(Session::get("roleid") == '1' || Session::get("roleid") == '2'){ ?>        
        <div class="card-body pr-2 pl-2">

          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th  class="text-center">STT</th>
                      <th  class="text-center">Tên đăng nhập</th>
                      <th  class="text-center"> Địa chỉ Email</th>
                      <th  class="text-center">Số điện thoại</th>
                      <th  class="text-center">Địa chỉ</th>
                      <th  class="text-center">Trạng thái</th>
                      <th  class="text-center">Thời gian tạo</th>
                      <th  width='25%' class="text-center">Chức năng</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if(Session::get("roleid") == '1'){
                      $allUser = $users->selectAllUserData();
                      }
                      else{
                      $allUser = $users->selectFilterUserData();
                      }
                      if ($allUser) {
                        $i = 0;
                        foreach ($allUser as  $value) {
                          $i++;

                     ?>

                      <tr class="text-center"
                      <?php if (Session::get("id") == $value->id) {
                        echo "style='background:#d9edf7' ";
                      } ?>
                      >

                        <td><?php echo $i; ?></td>
                        <td><?php echo $value->username; ?><br>
                        <?php if ($value->roleid  == '1'){
                          echo "<span class='badge badge-lg badge-info text-white'>Administrator</span>";
                        } elseif ($value->roleid == '2') {
                          echo "<span class='badge badge-lg badge-dark text-white'>Nhân viên</span>";
                        }elseif ($value->roleid == '3') {
                            echo "<span class='badge badge-lg badge-dark text-white'>Khách hàng</span>";
                        } ?>
                        </td>
                        <td><?php echo $value->email; ?> <br>
                          </td>
                        <td><span class=""><?php echo $value->mobile; ?></span></td>

                        <td><?php echo $value->address; ?></td>
                        <td>
                          <?php if ($value->isActive == '0') { ?>
                          <span class="badge badge-lg badge-info text-white">Hoạt động</span>
                        <?php }else{ ?>
                    <span class="badge badge-lg badge-danger text-white">Chưa được xác nhận</span>
                        <?php } ?>

                        </td>
                        <td><span class="badge badge-lg badge-secondary text-white"><?php echo $users->formatDate($value->created_at);  ?></span></td>

                        <td>
                          <?php if ( Session::get("roleid") == '1') {?>
<!--                             <a class="btn btn-success btn-sm" href="profile.php?id=<?php echo $value->id;?>">View</a> -->
                            <a class="btn btn-success btn-sm " href="profile.php?id=<?php echo $value->id;?>">Sửa</a>
                            <a onclick="return confirm('Bạn có chắc chắn muốn xoá tài khoản ?')" class="btn btn-danger
                    <?php if (Session::get("id") == $value->id) {
                      echo "disabled";
                    } ?>
                             btn-sm " href="?remove=<?php echo $value->id;?>">Xoá</a>

                             <?php if ($value->isActive == '0') {  ?>
                               <a onclick="return confirm('Bạn có chắc chắn muốn vô hiệu hoá của tài khoản?')" class="btn btn-warning
                       <?php if (Session::get("id") == $value->id) {
                         echo "disabled";
                       } ?>
                                btn-sm " href="?deactive=<?php echo $value->id;?>">Vô hiệu hoá</a>
                             <?php } elseif($value->isActive == '1'){?>
                               <a onclick="return confirm('Xác nhận kích hoạt tài khoản ?')" class="btn btn-secondary
                       <?php if (Session::get("id") == $value->id) {
                         echo "disabled";
                       } ?>
                                btn-sm " href="?active=<?php echo $value->id;?>">Kích hoạt</a>
                             <?php } ?>




                        <?php  }elseif(Session::get("id") == $value->id  && Session::get("roleid") == '2'){ ?>
<!--                           <a class="btn btn-success btn-sm " href="profile.php?id=<?php echo $value->id;?>">Sửa</a> -->
                          <a class="btn btn-info btn-sm " href="profile.php?id=<?php echo $value->id;?>">Sửa</a>
                        <?php  }elseif( Session::get("roleid") == '2'){ ?>
<!--                           <a class="btn btn-success btn-sm
                          <?php if ($value->roleid == '1') {
                            echo "disabled";
                          } ?>
                          " href="profile.php?id=<?php echo $value->id;?>">Xem</a> -->
                          <a class="btn btn-info btn-sm
                          <?php if ($value->roleid == '1') {
                            echo "disabled";
                          } ?>
                          " href="profile.php?id=<?php echo $value->id;?>">Sửa</a>
                        <?php }elseif(Session::get("id") == $value->id  && Session::get("roleid") == '3'){ ?>
                          <a class="btn btn-success btn-sm " href="profile.php?id=<?php echo $value->id;?>">View</a>
                          <a class="btn btn-info btn-sm " href="profile.php?id=<?php echo $value->id;?>">Edit</a>
                        <?php }else{ ?>
                          <a class="btn btn-success btn-sm
                          <?php if ($value->roleid == '1') {
                            echo "disabled";
                          } ?>
                          " href="profile.php?id=<?php echo $value->id;?>">View</a>

                        <?php } ?>

                        </td>
                      </tr>
                    <?php }}else{ ?>
                      <tr class="text-center">
                      <td>Hiện không có người dùng nào !</td>
                    </tr>
                    <?php }

                  ?>

                  </tbody>

              </table>









        </div>

      <?php } ?>

      </div>



  <?php
  include 'inc/footer.php';

  ?>
