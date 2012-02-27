<input type="hidden" data-name="svrefero-vn">
<input type="hidden" data-name="svrefero-cid">
<input type="hidden" data-name="svrefero-dateserv">		
<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>">หน้าหลัก</a><span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>services">การให้บริการ</a><span class="divider">/</span></li>
  <li class="active">ข้อมูลการรับส่งต่อ (Refer)</li>
</ul>

<ul class="nav nav-pills">
  <li class="active">
    <a href="#tab-refer-list" data-toggle="tab">
    	<i class="icon-th icon-white"></i>
    	ทะเบียนส่งต่อ (Refer Out)
  	</a>
  </li>
  <li>
    <a href="#tab-refer-list2" data-toggle="tab">
    	<i class="icon-th icon-white"></i>
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
						<label for="">วันที่</label>
						<input type="text" class="span2">
						<button class="btn btn-primary" type="button"><i class="icon-zoom-in icon-white"></i> แสดงรายการ</button>
						</form>
					</div>
					<div class="span3">
						<div class="btn-group">
							<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="icon-th icon-white"></i>
								เมนูระบบงานหลัก
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
		    <th>เลขที่เอกสาร</th>
		    <th>เลขบัตรประชาชน</th>
		    <th>ชื่อ - สกุล</th>
		    <th>อายุ</th>
		    <th>สถานที่ส่งต่อ</th>
		    </tr>
		    </thead>
	    <tbody></tbody>
    </table>
	</div><!-- /tab-refer-list -->
	<div class="tab-pane" id="tab-refer-list2">
		
	</div><!-- /tab-refer-list2 -->
</div>

<!-- modal -->
<!-- new referout  -->
<div class="modal hide fade" data-name="modal-refer-out-new">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>ลงทะเบียนส่งต่อ (Refer Out)</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-refer-out-register">
			<h4>บันทึกข้อมูลการให้บริการส่งต่อ</h4>
			<p>
				กรุณากรอกข้อมูลให้ถูกต้อง และสมบูรณ์
			</p>
		</div>
		
		<div class="form-actions" data-name="svrefero-register-search-panel">
			<form action="#" class="form-inline">
				<label for="">วันที่รับบริการ</label>
				<input type="text" data-name="svrefero-search-patient-date" class="span1">
				<input type="text" data-name="svrefero-search-patient" class="span3" placeholder="พิมพ์ชื่อ หรือ เลขบัตรประชาชน ">
				<button type="button" class="btn btn-primary" data-name="svrefer-btn-get-register-detail"><i class="icon-zoom-in icon-white"></i> ลงทะเบียน &rarr;</button>
			</form>
		</div>
		<div data-name="svrefero-register-detail-panel" style="display: none;">
			<form action="#">
			<!-- display register information -->
			<ul class="nav nav-pills">
				<li class="active"><a data-name="svrrefotab-patient-detail" data-toggle="tab" href="#tabrefero-register-patient-detail"><i class="icon-user icon-white"></i> ข้อมูลทั่วไปและการรับบริการ</a></li>
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
							<label for="">สิทธิการรักษา</label>
							<input type="text" data-name="svrefer-register-visit-right" class="span4">
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tabrefero-register-detail-1">
					<div class="row">
						<div class="span2">
							<label for="">วันที่ส่ง</label>
							<input type="text" class="span2" data-name="svrefero-register-refer-date">
						</div>
					</div>
					<div class="row">
						<div class="span3">
							<label for="">เหตุผลการส่งต่อ</label>
							<select data-name="svrefero-register-cause" class="span3">
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
							<label for="">การวินิจฉัย</label>
							<input type="text" data-name="svrefero-register-diag" class="span5" placeholder="พิมพ์รหัส หรือ ชื่อ การวินิจฉัย เพื่อค้นหา...">
							<input type="hidden" data-name="svrefero-register-diag-code">
						</div>
					</div><!-- /row -->
					<div class="row">
						<div class="span3">
							<label for="">ประเภทการส่งต่อ</label>
							<select data-name="svrefero-register-type" class="span3">
								<option value="2">ในเครือข่าย CUP</option>
								<option value="1">ในจังหวัด</option>
								<option value="2">นอกจังหวัด</option>
							</select>
						</div>
						<div class="span5">
							<label for="">ส่งต่อไปที่</label>
							<input type="text" data-name="svrefero-register-tohosp-name" class="span5" placeholder="พิมพ์ชื่อ หรือ รหัส สถานบริการ เพื่อค้นหา...">
							<input type="hidden" data-name="svrefero-register-tohosp-code">
						</div>
					</div> <!-- /row -->
				</div>
				<div class="tab-pane" id="tabrefero-register-detail-2">
					<div class="row">
						<div class="span4">
							<label for="">การให้การรักษาเบื้องต้น</label>
							<textarea data-name="svrefero-register-treatment" class="span4" rows="2"></textarea>
						</div>
						<div class="span4">
							<label for="">รายละเอียดอื่นๆ</label>
							<textarea data-name="svrefero-other-detail" class="span4" rows="2"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="span4">
							<label for="">วันที่นัดผู้ป่วยเข้ารับบริการที่สถานบริการ</label>
							<input type="text" data-name="svrefero-appoint-date" class="span2">
						</div>
					</div>
				</div>
			</div>
				<button type="button" class="btn btn-primary" data-name="svrefero-btn-save-register"><i class="icon-plus-sign icon-white"></i> บันทึกส่งต่อ</button> 
				<button type="reset" class="btn" data-name="svrefero-btn-clear-register"><i class="icon-refresh"></i> ยกเลิก</button>
			</form>
		</div> <!-- /svrefer-register-detail-panel -->
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
	</div>
</div>
<!-- /new refer out -->
<!-- /modal -->
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.refer.js"></script>