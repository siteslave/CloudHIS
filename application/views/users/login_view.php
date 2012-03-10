  <div class="inner">
    <form class="form-actions span4">
      <fieldset>
        <legend>ลงชื่อเข้าใช้งาน</legend>
        <div class="row">
          <div class="span4">
            <label for="">ชื่อผู้ใช้งาน</label>
            <input data-name="user_name" autocomplete="off" type="text" class="span4" placeholder="ชื่อผู้ใช้งาน (Username)">
          </div>
        </div>
        <div class="row">
          <div class="span4">
            <label for="">รหัสผ่าน</label>
            <input data-name="user_pass" autocomplete="off" type="password" class="span4" placeholder="รหัสผ่าน (Password)">  
          </div>
        </div>
        <button data-name="btnuser-login"
        data-loading-text="Logging in..."
        data-complete-text="Redirecting..." type="button" class="btn btn-primary"> ลงชื่อเข้าใช้ </button> หรือ 
        <a href="<?php echo base_url(); ?>users/forgot">ลืมรหัสผ่าน </a> <br /><br />
      <p><a href="<?php echo base_url(); ?>help#login">มีปัญหาการใช้งาน หรือใช้งานไม่ได้</a></p>
      </fieldset>
    </form>
  </div>
  
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/apps/users.login.js"></script>