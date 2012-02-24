  <div class="inner">
    <form class="form-actions span5">
      <div class="row">
        <div class="span5">
          <label for="">ชื่อผู้ใช้งาน</label>
          <input data-name="user_name" type="text" class="span3" placeholder="ชื่อผู้ใช้งาน (Username)">
        </div>
        <div class="span5">
          <label for="">รหัสผ่าน</label>
          <input data-name="user_pass" type="password" class="span3" placeholder="รหัสผ่าน (Password)">  
        </div>
      </div>
      <button data-name="btnuser-login"
      data-toggle="button" data-loading-text="Logging in..."
      data-complete-text="Redirecting..." type="button" class="btn btn-primary">ล๊อกอินเข้าสู่ระบบ </button>
      <a href="<?php echo base_url(); ?>users/forgot">ลืมรหัสผ่าน </a>
    </form>
  </div>
  
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/apps/users.login.js"></script>