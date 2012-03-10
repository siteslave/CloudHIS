<ul class="breadcrumb">
	<li>
	<a href="<?php echo base_url(); ?>">หน้าหลัก</a> <span class="divider">/</span>
	</li>
	<li>
	<a href="<?php echo base_url(); ?>services">การให้บริการ</a> <span class="divider">/</span>
	</li>
	<li class="active">
	<a href="#">ลงทะเบียน</a>
	</li>
</ul>

<!-- alert error -->
<div id="svreg-error-msg" class="alert alert-info">
  <!-- <a class="close" data-dismiss="alert" href="#">&times;</a> -->
	<strong>กรุณากรอกข้อมูลให้ถูกต้อง!</strong> <br />
	<em>กรุณากรอกคำที่ต้องการค้นหา เช่น เลขบัตรประชาชน หรือชื่อของผู้มารับบริการ</em>
</div>
<!-- end alert error -->
<!-- search form -->
<div data-rel="service-search-form">
      <form class="well form-search">
  	 <input class="input-large search-query" type="text" data-rel="txtquery-search" placeholder="ชื่อ หรือ เลขบัตรประชาชน">
      	<a href="#" class="btn btn-primary" data-rel="search-patient"><i class="icon-search icon-white"></i>แสดงข้อมูล</a>
      	<!-- <button type="button" class="btn" id="btn-service-search-patient">เลือกจากรายการ →</button> -->
    </form>
</div>
<!-- /service form -->

<div data-rel="service-register-pt-detail" style="display: none;">
	<form class="form-horizontal">
		<input type="hidden" data-rel="hmain_code" id="hmain_code">
		<input type="hidden" data-rel="hsub_code" id="hsub_code">
		<input type="hidden" data-rel="ins_id" id="ins_id">
		<legend>ข้อมูลการลงทะเบียน</legend>
		<div class="tabbable tabs-bottom">
			<ul class="nav nav-pills">
				<li class="active"><a href="#patientdetail" data-toggle="tab"><i class="icon-user icon-white"></i>  ข้อมูลผู้ป่วย</a></li>
				<li><a href="#registerdetail" data-toggle="tab"><i class="icon-edit icon-white"></i>  ข้อมูลการรับบริการ</a></li>
				<li><a href="#rightdetail" data-toggle="tab"><i class="icon-qrcode icon-white"></i>  สิทธิการรักษา</a></li>
			</ul>

			<div class="tab-content" style="min-height: 260px;">
				<div class="tab-pane active" id="patientdetail">
					<fieldset class="control-group">
						<label class="control-label" for="cid">เลขบัตรประชาชน</label>
						<div class="controls">
							<input data-rel="cid" type="text" class="medium" name="cid" disabled>
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label" for="patient-name">ชื่อ - สกุล</label>
						<div class="controls">
							<input data-rel="patient-name" type="text" name="patient-name" disabled>
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label" for="txtbirth">วัน เดือน ปี เกิด</label>
						<div class="controls">
							<input data-rel="birthdate" type="text" name="birthdate" disabled>
						</div>
					</fieldset>
				</div>
				<div class="tab-pane" id="registerdetail">
					<fieldset class="control-group">
						<label class="control-label" for="date_serv">วันที่รับบริการ</label>
						<div class="controls">
							<input type="text" data-rel="date_serv" value="" class="input-small" placeholder="12/02/2012">
							<input type="text" data-rel="time_serv" value="" placeholder="12:30:11" class="input-small">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label" for="intime">เวลามารับบริการ</label>
						<div class="controls">
						  <select name="intime" data-rel="intime">
						  	<option value="1">ในเวลาราชการ</option>
						  	<option value="2">นอกเวลาราชการ</option>
						  </select>
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label" for="clinic_id">แผนกที่รับบริการ</label>
						<div class="controls">
							<select name="clinic_id" data-rel="clinic_id">
							<?php 
								foreach ($clinics as $key => $value) {
									echo '<option value="'.$key.'">'.$value.'</option>';
								}
							?>
							</select>
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label" for="pttype_id">ประเภทผู้รับบริการ</label>
						<div class="controls">
							<select name="pttype_id" data-rel="pttype_id">
							<?php 
								foreach ($pttypes as $key => $value) {
									echo '<option value="'.$key.'">'.$value.'</option>';
								}
							?>
							</select>
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label" for="location_id">สถานที่รับบริการ</label>
						<div class="controls">
							<select name="location_id" data-rel="location_id">
							<?php 
								foreach ($locations as $key => $value) {
									echo '<option value="'.$key.'">'.$value.'</option>';
								}
							?>
							</select>
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label" for="service_place_id">ชนิดผู้ป่วย</label>
						<div class="controls">
							<select name="service_place_id" data-rel="service_place_id">
							<?php 
								foreach ($places as $key => $value) {
									echo '<option value="'.$key.'">'.$value.'</option>';
								}
							?>
							</select>
						</div>
					</fieldset>
				</div>
				<div class="tab-pane" id="rightdetail">
					<fieldset class="control-group">
						<label class="control-label" for="insurance_name">สิทธิการรักษา</label>
						<div class="controls">
							<input type="text" data-rel="insurance_name" name="insurance_name" placeholder="พิมพ์ชื่อของสิทธิ เช่น บัตรประกันสขุภาพ"  class="input-xlarge">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label" for="ins_code">รหัสสิทธิการรักษา</label>
						<div class="controls">
							<input type="text" placeholder="พิมพ์ชื่อสถานบริการ"  data-rel="ins_code" class="input-xlarge">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label" for="hmainname">สถานบริการหลัก</label>
						<div class="controls">
							<input type="text" placeholder="พิมพ์ชื่อสถานบริการ" data-rel="hmainname" class="input-xlarge">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label" for="hsubname">สถานบริการรอง</label>
						<div class="controls">
							<input type="text" placeholder="พิมพ์ชื่อสถานบริการ" data-rel="hsubname" class="input-xlarge">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<label class="control-label" for="ins_start">วันเริมสิทธิ/หมดอายุุ</label>
						<div class="controls">
							<input type="text" placeholder="12/01/2012" data-rel="ins_start" class="input-small">
							<input type="text" placeholder="12/01/2012" data-rel="ins_expire" class="input-small">
						</div>
					</fieldset>
					<fieldset class="control-group">
						<div class="controls">
							<button type="button" class="btn btn-info" disabled>เลือกจากประวัติที่ผ่านมา</button>
						</div>
					</fieldset>
				</div>
			</div>
			<fieldset class="form-actions" style="padding: 17px 20px 18px;">
				<a href="#" data-rel="doregister" class="btn btn-large btn-success"><i class="icon-ok-sign icon-white"></i> บันทึกข้อมูล</a>
				<a data-rel="doclear" href="#" class="btn btn-large btn-danger"><i class="icon-refresh icon-white"></i> ยกเลิก</a>
			</fieldset>
		</div>
		</form>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/apps/services.register.js"></script>