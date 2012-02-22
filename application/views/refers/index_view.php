<input type="hidden" data-name="svrefer-vn">
<input type="hidden" data-name="svrefer-cid">
<input type="hidden" data-name="svrefer-dateserv">		
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
			<form action="#" class="form-inline">
				<input type="text" class="span2">
				<label for="">ถึง</label>
				<input type="text" class="span2">
				<a href="button" class="btn btn-info"><i class="icon-zoom-in icon-white"></i> แสดงรายการ</a>
				<a href="#modal-refer-out-new" data-toggle="modal" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i> ลงทะเบียนส่งต่อ</a>
				<a href="button" class="btn btn-success"><i class="icon-refresh icon-white"></i> รีเฟรชข้อมูล</a>
			</form>
		</div><!-- /btn-toolbar -->
		<table class="table table-striped">
	    <thead>
		    <tr>
		    <th>เลขที่เอกสาร</th>
		    <th>เลขบัตรประชาชน</th>
		    <th>ชื่อ - สกุล</th>
		    <th>อายุ</th>
		    <th>สถานที่รับส่งต่อ</th>
		    <th>อาการ</th>
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
<div class="modal hide fade" id="modal-refer-out-new" style="width: 700px;">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>ลงทะเบียนส่งต่อ (Refer Out)</h3>
	</div>
	<div class="modal-body">
		<div class="form-actions">
			<form action="#" class="form-inline">
				<label for="">วันที่รับบริการ</label>
				<input type="text" data-name="svrefer-search-patient-date" class="input-small">
				<label for="">ค้นหา</label>
				<input type="text" data-name="svrefer-search-patient" class="span3" placeholder="พิมพ์ชื่อ หรือ เลขบัตรประชาชน ">
				<button type="button" class="btn btn-primary" data-name="svrefer-btn-get-register-detail"><i class="icon-zoom-in icon-white"></i> ลงทะเบียน &rarr;</button>
			</form>
		</div>
		<div data-name="svrefer-register-detail-panel" style="display: none;">
			<form action="#">
			<!-- display register information -->
			<div class="row">
				<div class="span3">
					<label for="">เหตุผลการส่งต่อ</label>
					<select data-name="svrefer-register-refer-cause">
						<option value="option1">option1</option>
						<option value="option2">option2</option>
					</select>
				</div>
				<div class="span5">
					<label for="">การวินิจฉัย</label>
					<input type="text" data-name="svrefer-register-diag" class="span5" placeholder="พิมพ์รหัส หรือ ชื่อ การวินิจฉัย เพื่อค้นหา...">
				</div>
			</div>
			<div class="row">
				<div class="span5">
					<label for="">ส่งต่อไปที่</label>
					<input type="text" data-name="svrefer-register-diag" class="span5" placeholder="พิมพ์ชื่อ หรือ รหัส สถานบริการ เพื่อค้นหา...">
				</div>
				<div class="span3">
					<label for="">ประเภทการส่งต่อ</label>
					<select data-name="svrefer-register-refer-cause">
						<option value="option1">ในจังหวัด</option>
						<option value="option2">นอกจังหวัด</option>
					</select>
				</div>
			</div>
				<button type="button" class="btn btn-primary" data-name="svrefer-btn-save-register-out"><i class="icon-plus-sign icon-white"></i> บันทึกส่งต่อ</button> 
				<button type="reset" class="btn" data-name="svrefer-btn-clear-register"><i class="icon-refresh"></i> ยกเลิก</button>
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