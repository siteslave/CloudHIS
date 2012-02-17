<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Enterprise CloudHIS</title>
	<!--[if lt IE 9]> <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/ui/jquery-ui.css" />
	
	<script type="text/javascript">
		var _base_url = '<?php echo base_url(); ?>';
	</script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.numeric.js"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/js/application.js"></script>
  <link rel="stylesheet/less" type="text/css" href="<?php echo base_url(); ?>assets/css/services.less">
</head>
	<body>
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
							<li><a href="<?php echo base_url(); ?>">หน้าหลัก</a></li>
							<li class="dropdown" id="menu-basic-data">
						    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-basic-data">
						      ข้อมูลพื้นฐาน
						      <b class="caret"></b>
						    </a>
						    <ul class="dropdown-menu">
						      <li><a href="#">หมู่บ้านในเขตรับผิดชอบ</a></li>
						      <li><a href="#">ข้อมูลประชากร</a></li>
						      <li class="divider"></li>
						      <li><a href="#">ข้อมูลยาและเวชภัณฑ์</a></li>
						    </ul>
						  </li>
  						<li class="dropdown" id="menu-tools">
						    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-tools">
						      เครื่องมือ
						      <b class="caret"></b>
						    </a>
						    <ul class="dropdown-menu">
						      <li><a href="#">ส่งออกข้อมูล 21 แฟ้ม</a></li>
						      <li><a href="#">xxxxxx</a></li>
						      <li class="divider"></li>
						      <li><a href="#">ข้อมูลยาและเวชภัณฑ์</a></li>
						    </ul>
						  </li>
						</ul>
						<ul class="nav pull-right">
							<li class="dropdown" id="menu-users">
						    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-users">
						      ข้อมูลส่วนตัว
						      <b class="caret"></b>
						    </a>
						    <ul class="dropdown-menu">
						      <li><a href="#"><i class="icon-user"></i> ข้อมูลส่วนตัว</a></li>
						      <li><a href="#"><i class="icon-time"></i>  ประวัติการใช้งาน</a></li>
						      <li><a href="#"><i class="icon-edit"></i>  เปลี่ยนรหัสผ่าน</a></li>
						      <li class="divider"></li>
						      <li><a href="#"><i class="icon-off"></i> ออกจากระบบ</a></li>
						    </ul>
						  </li>
						</ul>
						<p class="navbar-text pull-right">Logged in as <a href="#">Username</a></p>
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
							<li><a href="<?php echo base_url(); ?>"><i class="icon-qrcode"></i> ระบบงานทันตกรรม</a></li>
							<li><a href="<?php echo base_url(); ?>"><i class="icon-leaf"></i> ระบบงานแพทย์แผนไทย</a></li>
							<li class="nav-header">ระบบงานส่งเสริมสุขภาพ</li>
							<li><a href="<?php echo base_url(); ?>anc"><i class="icon-folder-close"></i> บริการฝากครรภ์ (ANC)</a></li>
							<li><a href="<?php echo base_url(); ?>"><i class="icon-user"></i> ข้อมูลหญิงเจริญพันธ์ (Women)</a></li>
							<li><a href="<?php echo base_url(); ?>"><i class="icon-file"></i> การดูแลเด็กหลังคลอด (PP)</a></li>
							<li><a href="<?php echo base_url(); ?>"><i class="icon-eye-open"></i> การดูแลมารดาหลังคลอด (MCH)</a></li>
							<li class="nav-header">ระบบงานคัดกรอง</li>
							<li><a href="<?php echo base_url(); ?>"><i class="icon-th-list"></i> คัดกรองเบาหวานและความดันโลหิตสูง</a></li>
							<li><a href="<?php echo base_url(); ?>"><i class="icon-th"></i> คัดกรองมะเร็งปากมดลูก</a></li>
						</ul>
					</div><!-- /wel -->	
					<div class="well sidebar-nav">
						<ul class="nav nav-list">
							<li class="nav-header">อื่นๆ</li>
							<li><a href="<?php echo base_url(); ?>"><i class="icon-home"></i> หน้าหลัก</a></li>
							<li class="active"><a href="#"><i class="icon-share icon-white"></i>  การให้บริการหลัก</a></li>
							<li><a href="<?php echo base_url(); ?>"><i class="icon-qrcode"></i> ระบบงานทันตกรรม</a></li>
							<li><a href="<?php echo base_url(); ?>"><i class="icon-leaf"></i> ระบบงานแพทย์แผนไทย</a></li>
						</ul>
					</div><!-- /wel -->	
				</div><!-- /span3 -->	
				
				<div class="span9">
					<?php echo $content_for_layout; ?>	
				</div><!-- /row-fluid -->	
			</div><!-- /row-fluid -->	
		</div> <!-- /container-fluid -->
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/less.min.js"></script>
	</body>
</html>