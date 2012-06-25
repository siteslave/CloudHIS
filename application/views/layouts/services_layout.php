<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Enterprise CloudHIS</title>
	<!--[if lt IE 9]> <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/bootstrap.css" />
	 <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>

	<script type="text/javascript">
		var _base_url = '<?php echo site_url(); ?>';
	</script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.numeric.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/underscore-min.js"></script>
	
  <script type="text/javascript" src="<?php echo base_url() ?>assets/js/application.js"></script>

  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/bootstrap-responsive.css" />

</head>
	<body>
	  <div id="#loader" style="display: none;"></div>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="brand" href="#">CloudHIS</a>
					<div class="nav-collapse">
						<ul class="nav">
							<li><a href="<?php echo site_url(); ?>">หน้าหลัก</a></li>
							<li class="dropdown" id="menu-basic-data">
						    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
						      ข้อมูลพื้นฐาน
						      <b class="caret"></b>
						    </a>
						    <ul class="dropdown-menu">
                  <li class="nav-header">BASIC DATA</li>
						      <li><a href="<?php echo site_url('house'); ?>"><i class="icon-home"></i> ประชากร และ หมู่บ้าน</a></li>
						      <li class="divider"></li>
						      <li><a href="<?php echo site_url('drugs'); ?>"><i class="icon-tags"></i> ข้อมูลยาและเวชภัณฑ์</a></li>
						    </ul>
						  </li>
							<li class="dropdown active">
						    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
						      การให้บริการ
						      <b class="caret"></b>
						    </a>
						    <ul class="dropdown-menu">
                  <li class="nav-header">MAIN SERVICES</li>
						      <li><a href="<?php echo site_url('services'); ?>"><i class="icon-home"></i> การให้บริการหลัก</a></li>
						      <li><a href="<?php echo site_url('refers'); ?>"><i class="icon-tags"></i> ระบบงานรับส่งต่อ</a></li>
									<li><a href="<?php echo site_url('ttms'); ?>ttms"><i class="icon-tags"></i> ระบบงานแผทย์แผนไทย</a></li>
									<li><a href="<?php echo site_url('dents'); ?>"><i class="icon-tags"></i> ระบบงานทันตกรรม</a></li>
						    </ul>
						  </li>
  						<li class="dropdown">
						    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
						      เครื่องมือ
						      <b class="caret"></b>
						    </a>
						    <ul class="dropdown-menu">
                  <li class="nav-header">USER INFO</li>
						      <li><a href="#">ส่งออกข้อมูล 21 แฟ้ม</a></li>
						      <li><a href="#">xxxxxx</a></li>
						      <li class="divider"></li>
						      <li><a href="#">ข้อมูลยาและเวชภัณฑ์</a></li>
						    </ul>
						  </li>
						</ul>
            <?php
            if( get_current_user() ) {
              ?>
              <div class="btn-group pull-right">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                  <i class="icon-user"></i> <?php echo get_user_fullname(); ?>
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">

                  <li><a href="#" data-name="chk-pass" data-toggle="modal"><i class="icon-edit"></i> เปลี่ยนรหัสผ่าน</a></li>
                  <li class="divider"></li>
                  <li><a href="<?php echo site_url('users/logout'); ?>"><i class="icon-off"></i>  ออกจากระบบ</a></li>
                </ul>
              </div>

              <?php
            }
            ?>
					</div>
				</div>
			</div>
		</div><!-- /navbar navbar-fixed-top -->
		
		<!-- content -->
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span3">
					<div class="well sidebar-nav">
						<ul class="nav nav-list">
							<li class="nav-header">เมนูหลัก</li>
							<li><a href="<?php echo base_url(); ?>"><i class="icon-home"></i> หน้าหลัก</a></li>
							<li class="active"><a href="#"><i class="icon-share icon-white"></i>  การให้บริการหลัก</a></li>
							<li><a href="<?php echo site_url('dents'); ?>"><i class="icon-qrcode"></i> ระบบงานทันตกรรม</a></li>
							<li><a href="<?php echo site_url('ttms'); ?>"><i class="icon-leaf"></i> ระบบงานแพทย์แผนไทย</a></li>
							<li><a href="<?php echo site_url('refers'); ?>"><i class="icon-leaf"></i> ระบบงานรับส่งต่อ</a></li>
							<li class="nav-header">ระบบงานส่งเสริมสุขภาพ</li>
							<li><a href="<?php echo site_url('anc'); ?>"><i class="icon-folder-close"></i> ทะเบียนฝากครรภ์</a></li>
							<li><a href="<?php echo site_url(); ?>"><i class="icon-user"></i> ข้อมูลหญิงเจริญพันธ์</a></li>
							<li><a href="<?php echo site_url(); ?>"><i class="icon-file"></i> การดูแลเด็กหลังคลอด</a></li>
							<li><a href="<?php echo site_url(); ?>"><i class="icon-eye-open"></i> การดูแลมารดาหลังคลอด</a></li>
							<li><a href="#"><i class="icon-home"></i>  เยี่ยมบ้าน (HHC)</a></li>
							<li class="nav-header">ระบบงานคัดกรอง</li>
							<li><a href="<?php echo site_url(); ?>ncd"><i class="icon-th-list"></i> ทะเบียนผู้ป่วยโรคเรื้อรัง</a></li>
							<li><a href="<?php echo site_url(); ?>ncd/screening"><i class="icon-th-list"></i> คัดกรองเบาหวานความดัน</a></li>
							<li><a href="<?php echo site_url(); ?>"><i class="icon-th"></i> คัดกรองมะเร็งปากมดลูก</a></li>
						</ul>
					</div><!-- /wel -->
					<div class="well sidebar-nav">
						<ul class="nav nav-list">
							<li class="nav-header">อื่นๆ</li>
							<li><a href="<?php echo site_url(); ?>"><i class="icon-home"></i> หน้าหลัก</a></li>
							<li class="active"><a href="#"><i class="icon-share icon-white"></i>  การให้บริการหลัก</a></li>
							<li><a href="<?php echo site_url(); ?>"><i class="icon-qrcode"></i> ระบบงานทันตกรรม</a></li>
							<li><a href="<?php echo site_url(); ?>"><i class="icon-leaf"></i> ระบบงานแพทย์แผนไทย</a></li>
						</ul>
					</div><!-- /wel -->
				</div><!-- /span3 -->

				<div class="span9">
					<?php echo $content_for_layout; ?>	
				</div><!-- /row-fluid -->	
			</div><!-- /row-fluid -->	
		</div> <!-- /container-fluid -->
    
	</body>
</html>
