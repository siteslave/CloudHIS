<input type="hidden" data-name="svrefero-vn">
<input type="hidden" data-name="svrefero-cid">
<input type="hidden" data-name="svrefero-dateserv">		
<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>">หน้าหลัก</a><span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>services">การให้บริการ</a><span class="divider">/</span></li>
  <li class="active">ระบบงานรับส่งต่อ (Refer)</li>
</ul>

<ul class="nav nav-pills">
  <li class="active">
    <a href="#tab-refer-list" data-toggle="tab">
    	<i class="icon-share icon-white"></i>
    	ทะเบียนส่งต่อ (Refer Out)
  	</a>
  </li>
  <li>
    <a href="#tab-refer-list2" data-toggle="tab">
    	<i class="icon-download icon-white"></i>
    	ทะเบียนรับ (Refer In)
  	</a>
  </li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="tab-refer-list">
		<div class="btn-toolbar">
				<div class="row">
					<div class="span5">
						<form action="#" class="form-inline">
						<label for="">วันที่ส่งต่อ</label>
						<input type="text" class="span2" data-name="svrefero-date-list">
						<button class="btn btn-primary" type="button" data-name="svrefero-btn-getlist"><i class="icon-zoom-in icon-white"></i> </button>
						</form>
					</div>
					<div class="span3">
						<div class="btn-group">
							<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="icon-th icon-white"></i>
								เมนูใช้งาน
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#" data-name="ref-out-new-register"><i class="icon-plus-sign"></i> ลงทะเบียนส่งต่อ</a></li>
								<li><a href="#"><i class="icon-refresh"></i> รีเฟรชข้อมูล</a> </li>
							</ul>
						</div>
					</div>
				</div>
		</div><!-- /btn-toolbar -->
		<table class="table table-striped" data-name="tblrefer-out-list">
	    <thead>
		    <tr>
					<th>เลขที่</th>
					<th>วันที่ส่งต่อ</th>
					<th>เลขบัตรประชาชน</th>
					<th>ชื่อ - สกุล</th>
					<th>อายุ (ปี)</th>
					<th>ส่งต่อไปที่</th>
		    </tr>
		    </thead>
	    <tbody></tbody>
    </table>
	</div><!-- /tab-refer-list -->
	<div class="tab-pane" id="tab-refer-list2">
		<div class="btn-toolbar">
				<div class="row">
					<div class="span5">
						<form action="#" class="form-inline">
						<label for="">วันที่ส่งต่อ</label>
						<input type="text" class="span2" data-name="svreferi-date-list">
						<button class="btn btn-primary" type="button" data-name="svreferi-btn-getlist"><i class="icon-zoom-in icon-white"></i> </button>
						</form>
					</div>
				</div>
		</div><!-- /btn-toolbar -->
		<table class="table table-striped" data-name="tblrefer-in-list">
	    <thead>
		    <tr>
					<th>เลขที่</th>
					<th>วันที่ส่งต่อ</th>
					<th>เลขบัตรประชาชน</th>
					<th>ชื่อ - สกุล</th>
					<th>ส่งมาจาก</th>
					<th>สถานะ</th>
		    </tr>
		    </thead>
	    <tbody></tbody>
    </table>
	</div><!-- /tab-refer-list2 -->
</div>

<!-- modal -->
<!-- new referout  -->
<div class="modal hide fade" data-name="modal-refer-out-new">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>บันทึกข้อมูลการส่งต่อ (Refer Out)</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-refer-out-register">
			<h4>ข้อแนะนำ</h4>
			<p>
				กรุณาบันทึกข้อมูลให้ถูกต้อง และ สมบูรณ์
			</p>
		</div>
		
		<div class="form-actions" data-name="svrefero-register-search-panel">
			<form action="#" class="form-inline">
				<label for="">วันที่รับบริการ</label>
				<input type="text" data-name="svrefero-search-patient-date" class="span1">
				<input type="text" data-name="svrefero-search-patient" class="span3" placeholder="พิมพ์ชื่อหรือเลขบัตรประชาชนเพื่อค้นหา">
				<button type="button" class="btn btn-primary" data-name="svrefer-btn-get-register-detail"><i class="icon-zoom-in icon-white"></i> ลงทะเบียน &rarr;</button>
			</form>
		</div>
		<div data-name="svrefero-register-detail-panel" style="display: none;">
			<form action="#">
			<!-- display register information -->
			<ul class="nav nav-pills">
				<li class="active"><a data-name="svrrefotab-patient-detail" data-toggle="tab" href="#tabrefero-register-patient-detail"><i class="icon-user icon-white"></i> เข้อมูลการรับบริการ</a></li>
				<li><a data-toggle="tab" href="#tabrefero-register-detail-1"><i class="icon-share icon-white"></i> ข้อมูลการส่งต่อ</a></li>
				<li><a data-toggle="tab" href="#tabrefero-register-detail-2"><i class="icon-eye-open icon-white"></i> การให้การรักษาเบื้องต้น</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tabrefero-register-patient-detail">
					<div class="row">
						<div class="span2">
							<label for="">วันที่รับบริการ</label>
							<input type="text" data-name="svrefer-register-visit-date" class="span2">
						</div>
						<div class="span2">
							<label for="">เวลา</label>
							<input type="text" data-name="svrefer-register-visit-time" class="span2">
						</div>
					</div>
					<div class="row">
						<div class="span4">
							<label for="">ชื่อ - สกุล</label>
							<input type="text" data-name="svrefer-register-visit-fullname" class="span4">
						</div>
						<div class="span4">
							<label for="">สิทธิ์การรักษา</label>
							<input type="text" data-name="svrefer-register-visit-right" class="span4">
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tabrefero-register-detail-1">
					<div class="row">
						<div class="span2">
							<label for="">วันที่ส่งต่อ</label>
							<input type="text" class="span2" data-name="svrefero-register-refer-date">
						</div>
					</div>
					<div class="row">
						<div class="span3">
							<label for="">สาเหตุการส่งต่อ</label>
							<select data-name="svrefero-register-refer-cause" class="span3">
								<?php 
								$i = 1;
								foreach($refer_causes as $key => $value){
									if ($i == 1) {
										echo '<option value="'.$key.'" selected="selected">'.$value.'</option>';
									} else {
										echo '<option value="'.$key.'">'.$value.'</option>';
									}
									$i++;
								}
								?>
							</select>
						</div>
						<div class="span5">
							<label for="">การวินิจฉัยเบื้องต้น</label>
							<input type="text" data-name="svrefero-register-diag" class="span5" placeholder=" พิมพ์รหัสหรือชื่อ icd-10...">
							<input type="hidden" data-name="svrefero-register-diag-code">
						</div>
					</div><!-- /row -->
					<div class="row">
						<div class="span3">
							<label for="">ประเภทการส่งต่อ</label>
							<select data-name="svrefero-register-type" class="span3">
								<option value="2">ภายใน CUP</option>
								<option value="1">ในจังหวัด</option>
								<option value="2">นอกจังหวัด</option>
							</select>
						</div>
						<div class="span5">
							<label for="">สถานพยาบาลปลายทาง</label>
							<input type="text" data-name="svrefero-register-tohosp-name" class="span5" placeholder=" พิมพ์ชื่อหรือรหัสหน่วยบริการ..">
							<input type="hidden" data-name="svrefero-register-tohosp-code">
						</div>
					</div> <!-- /row -->
				</div>
				<div class="tab-pane" id="tabrefero-register-detail-2">
					<div class="row">
						<div class="span4">
							<label for="">การรักษาเบื้องต้น</label>
							<textarea data-name="svrefero-register-treatment" class="span4" rows="2"></textarea>
						</div>
						<div class="span4">
							<label for="">ข้อมูลอื่นๆ</label>
							<textarea data-name="svrefero-other-detail" class="span4" rows="2"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="span4">
							<label for="">วันนัดเข้ารับบริการที่สถานบริการรับส่งต่อ</label>
							<input type="text" data-name="svrefero-appoint-date" class="span2">
						</div>
					</div>
				</div>
			</div>
				<button type="button" class="btn btn-primary" data-name="svrefero-btn-save-register"><i class="icon-plus-sign icon-white"></i> บันทึกข้อมูลการส่งต่อ </button> 
				<button type="reset" class="btn" data-name="svrefero-btn-clear-register"><i class="icon-refresh"></i> ยกเลิกรายการ</button>
			</form>
		</div> <!-- /svrefer-register-detail-panel -->
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่างๆ</a>
	</div>
</div>
<!-- /new refer out -->
<!-- confirm  -->
<div class="modal hide fade" data-name="modal-refer-in-confirm">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>บันทึกข้อมูลการลงทะเบียนรับ</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-refer-out-register">
			<h4>คำเตือน</h4>
			<p>
				เมื่อท่านได้ทำการยืนยันการรับส่งต่อแล้ว โปรแกรมจะสร้าง Visit ให้ท่านโดยอัตโนมัติในวันที่ยืนยันการรับ
			</p>
		</div>
		<input type="hidden" data-name="svrefer-confirm-refer-id"> 
		<label for="">วันที่รับ</label>
		<input type="text" class="span2" data-name="svrefer-confirm-date" required="required">
		<label for="">รายละเอียดเพิ่มเติม</label>
		<textarea data-name="svrefer-confirm-other-detail" rows="2" class="span5"></textarea>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-primary" data-name="btnrefer-confirm-save"><i class="icon-plus-sign icon-white"></i> ยืนยันการรับ </button> 
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่างๆ</a>
	</div>
</div>
<!-- / confirm -->
<!-- refer detail  -->
<div class="modal hide fade" data-name="modal-refer-in-confirm-detail">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>บันทึกข้อมูลการลงทะเบียนรับ</h3>
	</div>
	<div class="modal-body">
		<label for="">วันที่รับ</label>
		<input type="text" class="span2" data-name="svrefer-confirm-detail-date">
		<label for="">รายละเอียดเพิ่มเติม</label>
		<textarea data-name="svrefer-confirm-detail-other" rows="2" class="span5"></textarea>
		<label for="">ผู้บันทึกข้อมูล</label>
		<input type="text" data-name="svrefer-confirm-detail-user" class="span3">
		<label for="">วันที่บันทึก</label>
		<input type="text" class="span2" data-name="svrefer-confirm-detail-date-update">
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่างๆ</a>
	</div>
</div>
<!-- / refer detail -->
<!-- /modal -->
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.refer.js"></script>