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
							<li class="active"><a href="<?php echo base_url(); ?>services">การให้บริการ</a></li>
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
							<li><a href="<?php echo base_url(); ?>"><i class="icon-home"></i>หน้าหลัก</a></li>
							<li class="active"><a href="#"><i class="icon-share icon-white"></i>การให้บริการ</a></li>
							<li><a href="#">Link</a></li>
							<li class="nav-header">การให้บริการ</li>
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