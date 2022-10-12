<?php

include 'lib/Database.php';
include_once 'lib/Session.php';


class Users{


  // Db Property
  private $db;

  // Db __construct Method
  public function __construct(){
    $this->db = new Database();
  }

  // Date formate Method
   public function formatDate($date){
     // date_default_timezone_set('Asia/Dhaka');
      $strtime = strtotime($date);
    return date('Y-m-d H:i:s', $strtime);
   }



  // Check Exist Email Address Method
  public function checkExistUsername($email){
    $sql = "SELECT username from  tbl_users WHERE username = :username";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':username', $email);
     $stmt->execute();
    if ($stmt->rowCount()> 0) {
      return true;
    }else{
      return false;
    }
  }



  // User Registration Method
  public function userRegistration($data){
    $address=$_POST['address'];
    $username = $data['username'];
    $email = $data['email'];
    $mobile = $data['mobile'];
    $roleid = $data['roleid'];
    $password = $data['password'];
    $repassword=$_POST['repassword'];

    $checkUsername = $this->checkExistUsername($username);

    $pattern = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";
    if ($username == "" || $email == "" || $repassword == "" || $password == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Hãy điền đầy đủ thông tin !!! </div>';
        return $msg;
    }elseif (strlen($username) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Tên người dùng quá ngắn, ít nhất 3 ký tự !</div>';
        return $msg;
    }elseif (preg_match('/[^a-z_\-0-9]/i', $username)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Không được nhập kí tự. Vui lòng nhập lai....</div>';
        return $msg;
    }
    elseif ($password != $repassword) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Mật khẩu không trùng khớp!</div>';
        return $msg;
    }elseif (!preg_match('/^[0-9]{10,}/', $mobile)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Số điện thoại không đúng định dạng !</div>';
        return $msg;

//     }elseif(strlen($password) < 8) {
//       $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
// <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
// <strong>Error !</strong> Mật khẩu có ít nhất 8 ký tự !</div>';
//         return $msg;
//     }elseif(!preg_match("#[0-9]+#",$password)) {
//       $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
// <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
// <strong>Error !</strong> Mật khẩu của bạn phải chứa ít nhất 1 số !</div>';
//         return $msg;
    }elseif(!preg_match($pattern, $password, $matchs)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Mật khẩu không đúng định dạng (ít nhất 8 kí tự trong đó chứa ít nhất 1 số 1 chữ và 1 kí tự đặc biệt)!!</div>';
        return $msg;
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Địa chỉ email không hợp lệ ! </div>';
        return $msg;
    }elseif ($checkUsername == TRUE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Tên đăng nhập đã tồn tại, vui lòng thử một tên đăng nhập khác ...!</div>';
        return $msg;
    }else{

      $sql = "INSERT INTO tbl_users(address, username, email, password, mobile, roleid) VALUES(:address, :username, :email, :password, :mobile, :roleid)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':address', $address);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':password', SHA1($password));
      $stmt->bindValue(':mobile', $mobile);
      $stmt->bindValue(':roleid', $roleid);
      $result = $stmt->execute();
      if ($result) {
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success !</strong> Chúc mừng bạn đã đăng ký thành công !</div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Đăng ký thất bại !</div>';
          return $msg;
      }



    }





  }
  // Add New User By Admin
  public function  addNewUserByAdmin($data){
    $address=$data['address'];
    $username = $data['username'];
    $email = $data['email'];
    $mobile = $data['mobile'];
    $roleid = $data['roleid'];
    $password = $data['password'];
    $repassword=$data['repassword'];


    $checkUsername = $this->checkExistUsername($username);

    $pattern = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";
    if ($username == "" || $email == "" || $repassword == "" || $password == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Hãy điền đầy đủ thông tin !!! </div>';
        return $msg;
    }elseif (strlen($username) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Tên người dùng quá ngắn, ít nhất 3 ký tự !</div>';
        return $msg;
    }elseif (preg_match('/[^a-z_\-0-9]/i', $username)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Không được nhập kí tự. Vui lòng nhập lai....</div>';
        return $msg;
    }
    elseif ($password != $repassword) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Mật khẩu không trùng khớp!</div>';
        return $msg;
    }elseif (!preg_match('/^[0-9]{10,}/', $mobile)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Số điện thoại không đúng định dạng !</div>';
        return $msg;

//     }elseif(strlen($password) < 8) {
//       $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
// <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
// <strong>Error !</strong> Mật khẩu có ít nhất 8 ký tự !</div>';
//         return $msg;
//     }elseif(!preg_match("#[0-9]+#",$password)) {
//       $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
// <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
// <strong>Error !</strong> Mật khẩu của bạn phải chứa ít nhất 1 số !</div>';
//         return $msg;
    }elseif(!preg_match($pattern, $password, $matchs)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Mật khẩu không đúng định dạng (ít nhất 8 kí tự trong đó chứa ít nhất 1 số 1 chữ và 1 kí tự đặc biệt)!!</div>';
        return $msg;
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Địa chỉ email không hợp lệ ! </div>';
        return $msg;
    }elseif ($checkUsername == TRUE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Tên đăng nhập đã tồn tại, vui lòng thử một tên đăng nhập khác ...!</div>';
        return $msg;
    }else{

      $sql = "INSERT INTO tbl_users(address, username, email, password, mobile, roleid) VALUES(:address, :username, :email, :password, :mobile, :roleid)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':address', $address);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':password', SHA1($password));
      $stmt->bindValue(':mobile', $mobile);
      $stmt->bindValue(':roleid', $roleid);
      $result = $stmt->execute();
      if ($result) {
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success !</strong> Chúc mừng bạn đã đăng ký thành công !</div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Đăng ký thất bại !</div>';
          return $msg;
      }



    }





  }



  // Select All User Method
  public function selectAllUserData(){
    $sql = "SELECT * FROM tbl_users ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function selectFilterUserData(){
    $sql = "SELECT * FROM tbl_users WHERE roleid= 3 ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


  // User login Autho Method
  public function userLoginAutho($username, $password){
    $password = SHA1($password);
    $sql = "SELECT * FROM tbl_users WHERE username = :username and password = :password LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }
  // Check User Account Satatus
  public function CheckActiveUser($username){
    $sql = "SELECT * FROM tbl_users WHERE username = :username and isActive = :isActive LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':isActive', 1);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }




    // User Login Authotication Method
    public function userLoginAuthotication($data){
      $username = $data['username'];
      $password = $data['password'];


      $checkUsername = $this->checkExistUsername($username);

      if ($username == "" || $password == "" ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Hãy đền đầy đủ thông tin !!</div>';
          return $msg;

      }elseif (preg_match('/[^a-z_\-0-9]/i', $username)) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Không được nhập kí tự. Vui lòng nhập lai ! </div>';
          return $msg;
      }elseif ($checkUsername == FALSE) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Tài khoản không chính xác !</div>';
          return $msg;
      }else{


        $logResult = $this->userLoginAutho($username, $password);
        $chkActive = $this->CheckActiveUser($username);

        if ($chkActive == TRUE) {
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Xin lỗi, tài khoản của bạn chưa được kích hoạt, hãy liên hệ với quản trị viên !</div>';
            return $msg;
        }elseif ($logResult) {

          Session::init();
          Session::set('login', TRUE);
          Session::set('id', $logResult->id);
          Session::set('roleid', $logResult->roleid);
          Session::set('address', $logResult->address);
          Session::set('email', $logResult->email);
          Session::set('username', $logResult->username);
          Session::set('logMsg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> Bạn đã đăng nhập thành công !</div>');
          echo "<script>location.href='index.php';</script>";

        }else{
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Tài khoản hoặc mật khẩu không đúng !</div>';
            return $msg;
        }

      }


    }



    // Get Single User Information By Id Method
    public function getUserInfoById($userid){
      $sql = "SELECT * FROM tbl_users WHERE id = :id LIMIT 1";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $userid);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_OBJ);
      if ($result) {
        return $result;
      }else{
        return false;
      }


    }



  //
  //   Get Single User Information By Id Method
    public function updateUserByIdInfo($userid, $data){
      $address = $data['address'];
      // $username = $data['username'];
      $email = $data['email'];
      $mobile = $data['mobile'];
      $roleid = $data['roleid'];



      if ( $email == "" || $mobile == ""  ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Input Fields must not be Empty !</div>';
          return $msg;
        }

    //     }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
    //       $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    // <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    // <strong>Error !</strong> Enter only Number Characters for Mobile number field !</div>';
    //         return $msg;


      elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Error !</strong> Địa chỉ email không hợp lệ ! </div>';
              return $msg;
      }elseif (!preg_match('/^[0-9]{10,}/', $mobile)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Error !</strong> Số điện thoại không đúng định dạng !</div>';
              return $msg;

      }else{

        $sql = "UPDATE tbl_users SET
          address = :address,
          email = :email,
          mobile = :mobile,
          roleid = :roleid
          WHERE id = :id";
          $stmt= $this->db->pdo->prepare($sql);
          $stmt->bindValue(':address', $address);
          $stmt->bindValue(':email', $email);
          $stmt->bindValue(':mobile', $mobile);
          $stmt->bindValue(':roleid', $roleid);
          $stmt->bindValue(':id', $userid);
        $result =   $stmt->execute();

        if ($result) {
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong>  Thông tin của bạn đã được cập nhật Thành công !</div>');



        }else{
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Đã có lỗi xảy ra ! </div>');


        }


      }


    }




    // Delete User by Id Method
    public function deleteUserById($remove){
      $sql = "DELETE FROM tbl_users WHERE id = :id ";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $remove);
        $result =$stmt->execute();
        if ($result) {
          $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> Tài khoản người dùng đã được xóa thành công !</div>';
            return $msg;
        }else{
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Đã có lỗi xảy ra !</div>';
            return $msg;
        }
    }

    // User Deactivated By Admin
    public function userDeactiveByAdmin($deactive){
      $sql = "UPDATE tbl_users SET

       isActive=:isActive
       WHERE id = :id";

       $stmt = $this->db->pdo->prepare($sql);
       $stmt->bindValue(':isActive', 1);
       $stmt->bindValue(':id', $deactive);
       $result =   $stmt->execute();
        if ($result) {
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> Vô hiệu hoá tài khoản thành công !</div>');

        }else{
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Đã có lỗi xảy ra ! </div>');

            return $msg;
        }
    }


    // User Deactivated By Admin
    public function userActiveByAdmin($active){
      $sql = "UPDATE tbl_users SET
       isActive=:isActive
       WHERE id = :id";

       $stmt = $this->db->pdo->prepare($sql);
       $stmt->bindValue(':isActive', 0);
       $stmt->bindValue(':id', $active);
       $result =   $stmt->execute();
        if ($result) {
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> Tài khoản người dùng được kích hoạt thành công !</div>');
        }else{
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Có lỗi xảy ra !</div>');
        }
    }




    // Check Old password method
    public function CheckOldPassword($userid, $old_pass){
      $old_pass = SHA1($old_pass);
      $sql = "SELECT password FROM tbl_users WHERE password = :password AND id =:id";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':password', $old_pass);
      $stmt->bindValue(':id', $userid);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        return true;
      }else{
        return false;
      }
    }



    // Change User pass By Id
    public  function changePasswordBysingelUserId($userid, $data){

      $old_pass = $data['old_password'];
      $new_pass = $data['new_password'];
      $re_new_pass = $data['re_new_password'];

      $pattern = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";

      if ($old_pass == "" || $new_pass == "" || $re_new_pass == "" ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Trường mật khẩu không được để trống !</div>';
          return $msg;
      }
      elseif ($new_pass != $re_new_pass) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Mật khẩu không trùng khớp!</div>';
          return $msg;
      }elseif(!preg_match($pattern, $new_pass, $matchs)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Mật khẩu không đúng định dạng (ít nhất 8 kí tự trong đó chứa ít nhất 1 số 1 chữ và 1 kí tự đặc biệt)!!</div>';
        return $msg;
      }

         $oldPass = $this->CheckOldPassword($userid, $old_pass);
         if ($oldPass == FALSE) {
           $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     <strong>Error !</strong> Mật khẩu cũ không đúng !</div>';
             return $msg;
         }else{
           $new_pass = SHA1($new_pass);
           $sql = "UPDATE tbl_users SET

            password=:password
            WHERE id = :id";

            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':password', $new_pass);
            $stmt->bindValue(':id', $userid);
            $result =   $stmt->execute();

          if ($result) {
            echo "<script>location.href='index.php';</script>";
            Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success !</strong> Mật khẩu đã thay đổi thành công !</div>');

          }else{
            $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Error !</strong> Thay đổi mật khẩu không thành công!</div>';
              return $msg;
          }

         }



    }








}
