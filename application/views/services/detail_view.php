<?php foreach ($rows as $row); ?>
<?php foreach ($screenings as $sc); ?>

<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#svdetail-patient-info"><i class="icon-user"></i> ข้อมูลการรับบริการ</a></li>
	<li><a data-toggle="tab" href="#svdetail-patient-history"><i class="icon-time"></i> ประวัติการรับบริการ</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="svdetail-patient-info">
		<div class="row-fluid">
			<div class="span2">
				<?php echo img(array(
												'src' => 'assets/img/no_person.jpg',
												'width' => '60',
												'height' => '75'
											)); 
					?>
			</div>
			<div class="span3">
				<input type="hidden" data-name="vn" value="<?php echo $row->vn; ?>" id="vn">
				<input type="hidden" data-name="cid" value="<?php echo $row->cid; ?>">
				<input type="hidden" data-name="date_serv" value="<?php echo $row->date_serv; ?>">
				<input type="hidden" data-name="service_place_id" value="<?php echo $row->service_place_id; ?>">
				<strong>บัตรประชาชน</strong>:
				<?php echo $row->cid; ?> <br />
				<strong>ชื่อ - สกุล</strong>: 
				<?php echo $row->fname. ' '. $row->lname; ?> <br />
				<strong>อายุ</strong>: <?php echo $row->age; ?> ปี
			</div>
			<div class="span4">
				<strong>วันที่</strong>: 
				<?php echo to_thai_date ( $row->date_serv ) . ' '. $row->time_serv; ?> <br />
				<strong>แผนก</strong>:
				<?php echo $row->clinic_name; ?> <br />
				<strong>สิทธิการรักษา</strong>:
				<?php echo $row->ins_name; ?> <br />
			</div>
		</div>
	</div>
	<div class="tab-pane" id="svdetail-patient-history">
		<p>History</p>	
	</div>
</div><!-- /tab-content -->

<div class="form-actions" style="min-height: 50px;">
<div class="btn-toolbar">
			<div class="btn-group">
			<a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="icon-list icon-white"></i> ข้อมูล LAB
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="#" data-name="btnLabOrder"> <i class="icon-eye-open"></i> สั่ง LAB</a></li>
				<li><a href="#" data-name="btnLabResult"><i class="icon-random"></i> รายงานผล LAB</a></li>
			</ul>
		</div>
		<div class="btn-group">
			<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="icon-folder-open icon-white"></i> บริการส่งเสริม
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="#" data-name="service-fp"><i class="icon-eye-open"></i>  วางแผนครอบครัว (FP)</a></li>
				<li><a href="#" data-name="service-epi"><i class="icon-random"></i>  สร้างเสริมภูมิคุ้มกันโรค (EPI)</a></li>
				<li><a href="#" data-name="service-anc"><i class="icon-envelope"></i>  ฝากครรภ์ (ANC)</a></li>
				<li class="divider"></li>
				<li><a href="#" data-name="service-pp"><i class="icon-lock"></i>  ดุแลเด็กหลังคลอด (PP)</a></li>
				<li><a href="#" data-name="service-mch-pre"><i class="icon-book"></i>  ตรวจก่อนคลอด</a></li>
				<li><a href="#" data-name="service-mch-post"><i class="icon-book"></i>  ดูแลแม่หลังคลอด</a></li>
			</ul>
		</div>
		<div class="btn-group">
			<a class="btn btn-warning dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="icon-check icon-white"></i> การคัดกรอง
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="#" data-name="service-ncd"><i class="icon-check"></i>  ตรวจคัดกรองเบาหวานและความดัน</a></li>
				
				<li><a href="#" data-name="service-chronicfu"><i class="icon-lock"></i>  ตรวจติดตามผู้ป่วยโรคเรื้อรัง</a></li>
			</ul>
		</div>
		<div class="btn-group">
			<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="icon-comment icon-white"></i> บริการอื่นๆ
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="#" data-name="service-506"><i class="icon-fire"></i> บันทึกระบาดวิทยา (506)</a></li>
				
				<li><a href="#" data-name="service-appoint" data-toggle="modal"><i class="icon-tags"></i>  ลงทะเบียนนัด (Appoint)</a></li>
			</ul>
		</div>
	</div><!-- /btn-toolbar -->
</div>

<!-- alert -->
<div class="row-fluid">
	<div class="span12">
		<div id="alert-block" class="alert alert-info">
			<a class="close" data-dismiss="alert" href="#">&times;</a>
			<h4 class="alert-heading">คำแนะนำ</h4>
			<p>กรุณากรอกข้อมูลให้ถูกต้องและสมบูรณ์ ไม่เช่นนั้นโปรแกรมจะไม่ทำการบันทึกข้อมูลการให้บริการของผู้รับบริการ</p>
	</div>
	</div>
</div>
<!-- /alert -->

	<!-- main tab -->
<ul class="nav nav-tabs">
	<li class="active">
		<a data-toggle="tab" href="#tabCC"> <i class="icon-check"></i> ข้อมูลคัดกรอง</a>
	</li>
	<li>
		<a data-toggle="tab" data-name="btnTabDiag" href="#tabDiags"> <i class="icon-edit"></i> การวินิจฉัยโรค</a>
	</li>
	<li>
		<a data-toggle="tab" href="#tab-proced" data-name="btnTabProced"> <i class="icon-eye-open"></i> การทำหัตถการ</a>
	</li>
	<li>
		<a data-toggle="tab" href="#tab-drug" data-name="btnTabDrug"> <i class="icon-check"></i> การจ่ายยา</a>
	</li>
	<li>
		<a data-toggle="tab" href="#tab-income" data-name="btnTabIncome"> <i class="icon-shopping-cart"></i>  ค่าบริการอื่นๆ</a>
	</li>
</ul>
<!-- tab content -->
<!-- tabs data -->

<div class="tab-content" style="min-height: 350px;">
	<div class="tab-pane active" id="tabCC">
    <form class="form-inline">
      <blockquote>
        บันทึกข้อมูลการตรวจคัดกรองเบื้องต้น โดยควรกรอกข้อมูลให้ครบทุกช่อง (ถ้ามี)
      </blockquote>
    <table class="table">
      <tr>
        <td>น้ำหนัก</td>
        <td>
          <div class="input-append">
            <input type="text" data-name="weight" class="input-mini" data-type="number" value="<?php echo ! empty($sc) ? $sc->weight : ''; ?>">
            <span class="add-on">กก.</span>
          </div>
        </td>
        <td>ส่วนสูง</td>
        <td>
          <div class="input-append">
            <input type="text" data-name="height" class="input-mini" data-type="number" value="<?php echo ! empty($sc) ? $sc->height : ''; ?>">
            <span class="add-on">ซม.</span>
        </div>
        </td>
        <td>รอบเอว</td>
        <td>
          <div class="input-append">
            <input type="text" data-name="waistline" class="input-mini" data-type="number" value="<?php echo ! empty($sc) ? $sc->waistline : ''; ?>">
            <span class="add-on">นิ้ว.</span>
        </div>
        </td>
      </tr>
      <tr>
        <td>BMI</td>
        <td>
          <div class="input-append">
            <input type="text" data-name="bmi" class="input-mini" data-type="number" value="<?php echo ! empty($sc) ? $sc->bmi : ''; ?>">
            <span class="add-on">นิ้ว.</span>
          </div>
        </td>
        <td>ความดัน (บน)</td>
        <td>
          <div class="input-append">
          <input type="text" data-name="bp1" class="input-mini" data-type="number" value="<?php echo ! empty($sc) ? $sc->bp1 : ''; ?>">
            <span class="add-on">mm/hg</span>
            </div>
        </td>
        <td>ความดัน (ล่าง)</td>
        <td>
          <div class="input-append">
            <input type="text" data-name="bp2" class="input-mini" data-type="number" value="<?php echo ! empty($sc) ? $sc->bp2 : ''; ?>">
            <span class="add-on">mm/hg</span>
          </div>
        </td>
      </tr>
      <tr>
        <td>ชีพจร</td>
        <td>
          <div class="input-append">
            <input type="text" data-name="pulse" class="input-mini" data-type="number" value="<?php echo ! empty($sc) ? $sc->pulse : ''; ?>">
            <span class="add-on">mm/hg</span>
          </div>
        </td>
        <td>อุณหภูมิ</td>
        <td>
          <div class="input-append">
            <input type="text" data-name="temperature" class="input-mini" data-type="number" value="<?php echo ! empty($sc) ? $sc->temperature : ''; ?>">
            <span class="add-on">C</span>
          </div>
        </td>
        <td>DTX1</td>
        <td>
          <div class="input-append">
            <input type="text" data-name="dtx1" class="input-mini" data-type="number" value="<?php echo ! empty($sc) ? $sc->dtx1 : ''; ?>">
            <span class="add-on">...</span>
          </div>
        </td>
      </tr>
      <tr>
        <td>DTX2</td>
        <td>
          <div class="input-append">
            <input type="text" data-name="dtx2" class="input-mini" data-type="number" value="<?php echo ! empty($sc) ? $sc->dtx2 : ''; ?>">
            <span class="add-on">...</span>
          </div>
        </td>
        <td>FBS</td>
        <td>
          <div class="input-append">
            <input type="text" data-name="fbs" class="input-mini" data-type="number" value="<?php echo ! empty($sc) ? $sc->fbs : ''; ?>">
            <span class="add-on">...</span>
          </div>
        </td>
        <td>หัวใจ</td>
        <td>
          <div class="input-append">
            <input type="text" data-name="heartbeat" class="input-mini" data-type="number" value="<?php echo ! empty($sc) ? $sc->heartbeat : ''; ?>">
            <span class="add-on">m.</span>
          </div>
        </td>
      </tr>
      <tr>
        <td>การสูบบุหรี่</td>
        <td>
          <input type="text" class="input-small" value="<?php echo !empty($sc) ? $sc->smoking_name : ''; ?>" disabled data-name="txtSmokingName" />
          <input type="hidden" data-name="txtSmokingId" value="<?php echo !empty($sc) ? $sc->smoking_id : ''; ?>" />
          <button type="button" data-name="btnSelectSmoking" class="btn btn-info"><i class="icon-search icon-white"></i></button>
        </td>
        <td>การดื่มสุรา</td>
        <td>
          <input type="text" class="input-small" value="<?php echo !empty($sc) ? $sc->drinking_name : '' ?>" disabled data-name="txtDrinkingName" />
          <input type="hidden" data-name="txtDrinkingId" value="<?php echo !empty($sc) ? $sc->drinking_id : ''; ?>" />
          <button type="button" data-name="btnSelectDrinking" class="btn btn-info"><i class="icon-search icon-white"></i></button>
        </td>
        <td>แพ้ยา</td>
        <td>
          <input type="text" class="input-small" value="<?php echo !empty($sc) ? $sc->allergics_name : ''; ?>" disabled data-name="txtAllergicsName" />
          <input type="hidden" data-name="txtAllergicsId" value="<?php echo !empty($sc) ? $sc->allergics_id : ''; ?>" />
          <button type="button" data-name="btnSelectAllergics" class="btn btn-info"><i class="icon-search icon-white"></i></button>
        </td>
      </tr>
      <tr>
        <td>อาการ (CC)</td>
        <td colspan="6">
          <textarea class="input-xxlarge" rows="3" data-name="cc"><?php echo ! empty($sc) ? $sc->cc : ''; ?></textarea>
        </td>
      </tr>
    </table>
    </form>
		
		<div style="padding: 5px;">
      <a href="#" class="btn btn-large"><i class="icon-refresh"></i> ยกเลิก/ย้อนกลับ</a>
			<a href="#" class="btn btn-large btn-primary" data-loading-text="Saving..." data-name="btnSaveScreen">
				<i class="icon-tags icon-white"></i> บันทึกการคัดกรอง</a>
		</div>
			
	</div> <!-- /tab-cc -->
	<div class="tab-pane" id="tabDiags">
    <blockquote>
      บันทึกการให้รหัสโรค โดยใช้รหัส ICD10-TM เป็นหลัก
    </blockquote>
		<table class="table table-striped" data-name="tblDiagList">
			<thead>
				<tr>
					<th>#</th>
					<th>รหัส</th>
					<th>คำอธิบาย</th>
					<th>Diag type</th>
					<th>ดำเนินการ</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	  <a href="#" data-name="btnsv-add-diag" class="btn btn-success"> <i class="icon-plus icon-white"></i> เพิ่มใหม่... </a>
	</div><!-- /tab-diag -->

	<div class="tab-pane" id="tab-proced">
    <blockquote>
      บันทึกข้อมูลการให้บริการหัตถการ ซึ่งควรเป็นหัตถการที่เป็นการรักษาเท่านั้น
    </blockquote>
		<table class="table table-striped" data-name="tblProcedList">
			<thead>
				<tr>
					<th>#</th>
					<th>รหัส</th>
					<th>คำอธิบาย</th>
					<th>ราคา</th>
					<th>ผู้ให้หัตถการ</th>
					<th>ดำเนินการ</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
			<a href="#" data-name="btnsv-add-procedure" class="btn btn-success"> <i class="icon-plus icon-white"></i> เพิ่มใหม่... </a>
	</div><!-- /tab-proced -->
	<div class="tab-pane" id="tab-drug">
    <blockquote>
      บันทึกข้อมูลการจ่ายยา โดยสามารถกำหนดเป็นชุดได้
    </blockquote>
		<table class="table table-striped" data-name="tblDrug">
			<thead>
				<tr>
					<th>#</th>
					<th>ชื่อยา</th>
					<th>วิธีการใช้</th>
					<th>ราคา</th>
					<th>จำนวน</th>
					<th>รวมเงิน</th>
					<th>จัดการ</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
			<a href="#" data-name="btnsv-add-drug" class="btn btn-success"> <i class="icon-plus icon-white"></i> เพิ่มใหม่... </a>
	</div>
	<div class="tab-pane" id="tab-income">
    <blockquote>
      บันทึกค่าใช้จ่ายต่างๆ เพิ่มเติมนอกเหนือจากค่ายา
    </blockquote>
		<table class="table table-striped" data-name="tblIncomeList">
			<thead>
				<tr>
					<th>#</th>
					<th>รายการ</th>
					<th>หน่วย</th>
					<th>ราคา</th>
					<th>จำนวน</th>
					<th>รวมเงิน</th>
					<th>จัดการ</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
		<a href="#" data-name="btnsv-add-income" class="btn btn-success"> <i class="icon-plus icon-white"></i> เพิ่มใหม่... </a>
		
	</div>
</div>

<!-- end tab content -->
<!--  add diag -->
<div class="modal hide fade" data-name="mdlSearchDiags">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>เพิ่มข้อมูลการวินิจฉัย</h3>
	</div>
	<div class="modal-body">
    <blockquote>
      ค้นหา ICD10 เพื่อบันทึกข้อมูลผลการให้บริการ
    </blockquote>
		<p>
    <form class="form-search form-actions">
      <input type="text" data-name="txtICDQuery" class="input-xlarge search-query" placeholder="พิมพืชื่อ หรือ ICD10  บางส่วน เแล้วคลิกปุ่มค้หา...">
      <button type="button" data-name="btnSearchDiag" class="btn"><i class="icon-search"></i> ค้นหา</button>
    <span class="help-inline"><i class="icon-info-sign"></i> คลิกที่ปุ่มค้นหาแล้วเลือกรายการด้านล่าง</span>
    </form>
    <ul class="nav nav-tabs">
      <li class="active">
        <a href="#tabDiagSearchResult" data-toggle="tab"><i class="icon-th-list"></i> ผลการค้นหา</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tabDiagSearchResult">
        <table class="table table-striped" data-name="tblICDResult">
          <thead>
          <tr>
            <th>รหัส</th>
            <th>คำอธิบาย</th>
            <th></th>
          </tr>
          </thead>
          <tbdy>
            <td>...</td>
            <td>...</td>
            <td><a href="#" data-name="bntSelectedDiagForSave" title="เลือกรายการนี้" class="btn"><i class="icon-check"></i></a></td>
          </tbdy>
        </table>
      </div>
    </div>
		</p>
	</div>

	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
	</div>
</div>

<div class="modal hide fade" data-name="modalSelectedDiagForSave">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>ประเภทการวินิจฉัย</h3>
  </div>
  <div clas="modal-body">
    <input type="hidden" data-name="txtICDCode" />
    <table class="table table-striped" data-name="tblDiagTypeList">
      <thead>
      <tr>
        <th>#</th>
        <th>ประเภทการวินิจฉัย</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ยกเลิก</a>
  </div>

</div>
<!-- /add diag -->
<!-- add proced -->
<div class="modal hide fade" data-name="mdlSearchProced">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>เพิ่มข้อมูลการให้หัตถการ</h3>
  </div>
  <div class="modal-body">
    <blockquote>
      ค้นหา ICD9 เพื่อบันทึกข้อมูลผลการให้บริการ
    </blockquote>
    <p>
    <form class="form-search form-actions">
      <input type="text" data-name="txtProcedQuery" class="input-xlarge search-query" placeholder="พิมพืชื่อ หรือ ICD9 บางส่วน เแล้วคลิกปุ่มค้หา...">
      <button type="button" data-name="btnSearchProced" class="btn"><i class="icon-search"></i> ค้นหา</button>
      <span class="help-inline"><i class="icon-info-sign"></i> คลิกที่ปุ่มค้นหาแล้วเลือกรายการด้านล่าง</span>
    </form>
    <ul class="nav nav-tabs">
      <li class="active">
        <a href="#tabProcedSearchList" data-toggle="tab"><i class="icon-th-list"></i> ผลการค้นหา</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tabProcedSearchList">
        <table class="table table-striped" data-name="tblProcedSearchList">
          <thead>
          <tr>
            <th>รหัส</th>
            <th>คำอธิบาย</th>
            <th></th>
          </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
    </p>
  </div>

  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>

<div class="modal hide fade" data-name="mdlProcedSelectUserPrice">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3>กำหนดรายละเอียดเพิ่มเติม</h3>
  </div>
  <div class="modal-body">
    <p>
    <input type="hidden" data-name="txtProcedCode" />

    <ul class="nav nav-tabs">
      <li class="active">
        <a href="#tabProcedSearchListResult" data-toggle="tab"><i class="icon-th-list"></i> ข้อมูลการให้บริการ</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tabProcedSearchListResult">
        <form class="form-inline">
        <table class="table table-striped" data-name="tblProcedSearchListResult">
          <tbody>
          <tr>
            <td>ผู้ให้บริการ</td>
            <td>
              <input type="hidden" data-name="txtDoctorId" />
              <input type="text" class="input-xlarge uneditable-input" disabled data-name="txtDoctorName" />
              <button type="button" class="btn btn-info" data-name="btnSearchDoctor"><i class="icon-search icon-white"></i></button>
            </td>
          </tr>
          <tr>
            <td>ราคา</td>
            <td>
              <div class="input-prepend input-append">
                <input type="text" data-type="number" value="0" class="input-mini" data-name="txtProcedPrice" />
                <span class="add-on">บาท</span>
              </div>
          </tr>
          </tbody>
        </table>
        </form>
      </div>
    </div>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-primary" data-name="btnSaveProced"><i class="icon-tags icon-white"></i> บันทึกข้อมูลการให้บริการ</a>
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-refresh"></i> ปิดหน้าต่าง</a>
  </div>
</div>

<div class="modal hide fade" data-name="mdlSelectDoctor">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>ข้อมูลผู้ให้บริการ</h3>
  </div>
  <div class="modal-body">
    <p>
      <table class="table table-striped" data-name="tblDoctorsVisitList">
    <thead>
    <tr>
      <th>#</th>
      <th>ชื่อ - สกุล</th>
      <th>เลขที่ใบประกอบวิชาชีพ</th>
    </tr>
    </thead>
    <tbody></tbody>
      </table>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>

<!-- /add proced -->
<!-- add drug -->
<div class="modal hide fade" data-name="mdlSearchDrug">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>เพิ่มข้อมูลการให้จ่ายยา</h3>
	</div>
	<div class="modal-body">
		<blockquote>
      เพิ่มข้อมูลการใช้ยา
		</blockquote>
		<p>
      <form class="form-inline">
        <input type="hidden" data-name="drug_id" />
        <div class="tabbable">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tabDrugMain" data-toggle="tab"><i class="icon-th-list"></i> เพิ่มรายการยา</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tabDrugMain">
              <p>
            <table class="table">
              <tr>
                <td>ชื่อยา</td>
                <td>
                  <input type="hidden" data-name="txtDrugId" />
                  <input type="text" data-name="txtDrugName" class="input-xxlarge uneditable-input" disabled />
                  <button type="button" data-name="btnSearchDrug" class="btn btn-info">
                    <i class="icon-search icon-white"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <td>วิธีใช้ยา</td>
                <td>
                  <input type="hidden" data-name="txtUsageId" />
                  <input type="text" data-name="txtUsageName" class="input-xxlarge uneditable-input" disabled />
                  <button type="button" data-name="btnSearchUsage" class="btn btn-info">
                    <i class="icon-search icon-white"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <td>ราคาต่อหน่วย</td>
                <td>
                  <input type="text" data-type="number" data-name="txtDrugPrice" value="0.00" class="input-mini" />
                </td>
              </tr>
              <tr>
                <td>จำนวน</td>
                <td>
                  <input type="text" data-type="number" data-name="txtDrugQty" value="1" class="input-mini" />
                </td>
              </tr>
            </table>
              </p>
            </div>
          </div>
        </div>
      </form>
    </p>
  </div>
	<div class="modal-footer">
		<a href="#" class="btn btn-warning disabled" data-name="btnAddRemed"><i class="icon-refresh icon-white"></i> Remed.</a>
		<a href="#" class="btn btn-primary" data-name="btnDoSaveDrug"><i class="icon-tags icon-white"></i> บันทึกข้อมูลการจ่ายยา</a>
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
	</div>
</div>

<div class="modal hide fade" data-name="mdlDoSearchDrug">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>ค้หาข้อมูลยา</h3>
  </div>
  <div class="modal-body">
    <blockquote>
      ค้นหาข้อมูลยา
    </blockquote>
    <p>
    <form class="form-search form-actions">
      <input type="text" data-name="txtDrugSearchQuery" class="input-xlarge search-query" placeholder="พิมพ์ชื่อยาที่ต้องการค้หา...">
      <button type="button" data-name="btnDoSearchDrug" class="btn"><i class="icon-search"></i> ค้นหา</button>
    </form>

    <table class="table table-striped" data-name="tblDrugSearchResultList">
      <thead>
      <tr>
        <th>#</th>
        <th>ชื่อยา</th>
        <th>หน่วย</th>
        <th>ความแรง</th>
        <th>ราคาต่อหน่วย</th>
      </tr>
      </thead>
      <tbody></tbody>
    </table>

    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>

<div class="modal hide fade" data-name="mdlDoSearchUsage">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>ค้นหาข้อมูลการใช้ยา</h3>
  </div>
  <div class="modal-body">
    <blockquote>
      ค้นหาข้อมูลการใช้ยาเพื่อประกอบการจ่ายยา
    </blockquote>
    <p>
    <form class="form-search form-actions">
      <input type="text" data-name="txtUsageSearchQuery" class="input-xlarge search-query" placeholder="พิมพ์ข้อความที่ต้องการค้หา...">
      <button type="button" data-name="btnDoSearchUsage" class="btn"><i class="icon-search"></i> ค้นหา</button>
    </form>

    <table class="table table-striped" data-name="tblUsageSearchResultList">
      <thead>
      <tr>
        <th>#</th>
        <th>วิธีการใช้ยา</th>
        <th>เพิ่มเติม</th>
      </tr>
      </thead>
      <tbody></tbody>
    </table>

    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-success" data-name="btnNewUsageDetail"><i class="icon-plus icon-white"></i> เพิ่มวิธีใช้ใหม่...</a>
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>

  <!-- new usage -->
<div class="modal hide fade" data-name="mdlNewUsage">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>เพิ่มวิธีการใช้ยาใหม่</h3>
  </div>
  <div class="modal-body">
    <blockquote>
      เพิ่มรายละเอียดวิธีการใช้ยา
    </blockquote>
    <p>
    <form class="form-inline form-actions">
      <table class="table">
        <tr>
          <td>ชื่อ 1</td>
          <td><input type="text" class="input-xxlarge" data-name="txtNewUsageName1"></td>
        </tr>
        <tr>
          <td>ชื่อ 2</td>
          <td><input type="text" class="input-xxlarge" data-name="txtNewUsageName2"></td>
        </tr>
      </table>
    </form>

    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-primary" data-name="btnDoSaveNewUsage"><i class="icon-tags icon-white"></i> บันทึกวิธีใช้ยาใหม่</a>
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>
  <!-- /new usage -->
<!-- /add drug -->
<!-- add income -->
<div class="modal hide fade" data-name="modal-income">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>เพิ่มข้อมูลค่าใช้จ่าย</h3>
	</div>
	<div class="modal-body">
		<p>
			<form class="form-horizontal" data-name="frmSaveIncome">

				<div class="row-fluid">
          <div class="span6">
            <label for="">รายการค่าใช้จ่าย</label>
            <input type="hidden" data-name="txtIncomeId">
            <input type="hidden" data-name="txtIncomeUpdateId">
            <input type="text" class="input-xlarge uneditable-input" disabled data-name="txtIncomeName" >
            <button type="button" data-name="btnIncomeSearch" class="btn btn-info"><i class="icon-search icon-white"></i></button>
          </div>
					<div class="span2">
						<label for="">ราคา</label>
						<input type="text" class="input-mini" data-name="txtIncomePrice" value="0.00" placeholder="0.00">
					</div>
					<div class="span2">
						<label for="">จำนวน</label>
						<input type="text" class="input-mini" data-name="txtIncomeQty" value="1" placeholder="0">
					</div>
				</div>

			</form>
		</p>
	</div>
	<div class="modal-footer">
    <a href="#" class="btn btn-primary" data-name="btnSaveIncome"><i class="icon-tags icon-white"></i> บันทึกค่าใช้จ่าย</a>
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
	</div>
</div>

<!-- add income -->
<div class="modal hide fade" data-name="mdlSearchIncome">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>ค้นหาข้อมูลค่าใช้จ่าย</h3>
  </div>
  <div class="modal-body">
    <p>
    <form class="form-search">
      <input type="text" data-name="txtIncomeSearchQuery" class="input-xlarge search-query">
      <button type="submit" class="btn" data-name="btnDoSearchIncome"><i class="icon-search"></i> ค้นหา</button>
    </form>
    <table class="table table-striped" data-name="tblIncomeSearchResult">
      <thead>
      <tr>
        <th>#</th>
        <th>รายการ</th>
        <th>ราคา</th>
        <th>หน่วย</th>
        <th></th>
      </tr>
      </thead>
      <tbody></tbody>
    </table>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>

<!-- /add income -->
<!-- add appointment -->
<div class="modal hide fade" data-name="modal-appoint">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>รายละเอียดการนัดหมาย</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-appoint">
			<h4>คำแนะนำ</h4>
			<p>กรุณากรอกรายละเอียดให้ถูกต้องและสมบูรณ์</p>
		</div>
		<p>
		<div class="tabbable">
			<ul class="nav nav-pills">
				<li class="active"><a href="#tab-appoint-list" data-toggle="tab"><i class="icon-time icon-white"></i> ประวัติการนัด</a></li>
				<li><a href="#tab-appoint-new" data-toggle="tab"><i class="icon-plus-sign icon-white"></i> เพิ่มการนัด</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-appoint-list">
					<div style="overflow: auto; display:block;">
						<table class="table table-striped" data-name="tblAppointList">
							<thead>
								<tr>
									<th>วันที่</th>
									<th>วันที่นัด</th>
									<th>กิจกรรม</th>
									<th>รหัสการวินิจฉัย</th>
									<th></th>
								</tr>
								<tbody>
								</tbody>
							</thead>
						</table>
					</div>
				</div>
				<div class="tab-pane" id="tab-appoint-new">
					<form>
						<label for="">รหัสโรค (ควรเป็นรหัส Z)</label>
						<input type="hidden" data-name="appoint_diag_code" autocomplete="off">
						<input type="text" data-name="appoint_diag_name" class="input-xlarge" placeholder="รหัสการวินิจฉัยโรค (ICD10-TM) ควรเป็นรหัส Z..">
						<label for="">กิจกรรมการนัด</label>
						<select data-name="appoint_id" class="span3">
							<?php
								foreach ($appoints as $key => $value) {
									echo '<option value="'.$key.'">'.$value.'</option>';
								}
							?>
						</select>
						<label for="appoint_date">วันที่นัด</lable> <br />
						<input type="text" class="input-small" data-name="appoint_date"> <br />
						<button class="btn btn-primary" type="button" data-name="btn-save-appoint"><i class="icon-plus-sign icon-white"></i> เพิ่มรายการ</button>
						<button data-name="btnreset" class="btn" type="reset"><i class="icon-refresh"></i> ยกเลิก</button>
					</form>
				</div><!-- /appoint-new -->
			</div>
		</div> <!-- /tabbable -->
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
		
	</div>
</div>
<!-- /add appoinment -->

<!-- add 506 -->
<div class="modal hide fade" data-name="modal-506">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>บันทึกข้อมูลโรคเฝ้าระวัง (Surveil)</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-surveil">
			<h4>คำแนะนำ</h4>
			<p>ระบบบันทึกรายงานโรคเฝ้าระวัง (506)</p>
		</div>
		<p>
		<div class="tabbable">
			<ul class="nav nav-pills">
				<li class="active"><a href="#tab-surveil-list" data-toggle="tab"><i class="icon-time icon-white"></i> ประวัติการป่วย</a></li>
				<li><a href="#tab-surveil-new" data-toggle="tab"><i class="icon-plus-sign icon-white"></i> เพิ่มข้อมูลใหม่</a></li>
			</ul>
			<form action="#">
			<div class="tab-content">
				<div class="tab-pane active" id="tab-surveil-list">
					<table class="table table-striped" data-name="tblSurveilList">
						<thead>
							<tr>
								<th>วันที่รับบริการ</th>
								<th>รหัส 506</th>
								<th>รหัสวินิจฉัย</th>
								<th>วันที่เริ่มป่วย</th>
								<th>สภาพผู้ป่วย</th>
							</tr>
							<tbody>
							</tbody>
						</thead>
					</table>
				</div>
				<div class="tab-pane" id="tab-surveil-new">
					<div class="tabbable">
						<ul class="nav nav-tabs">
							<li class="active"> <a href="#surveil_ill" data-toggle="tab"><i class="icon-th"></i> ข้อมูลการเจ็บป่วย</a> </li>
							<li><a href="#surveil_addr" data-toggle="tab"><i class="icon-th-list"></i> ที่อยู่ขณะเจ็บป่วย</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="surveil_ill">
								<div class="row">
									<div class="span4">
										<label for="">รหัสการวินิจฉัย</label>
										<input type="text" class="span4" data-name="surveil_diag_name" placeholder="พิมพ์รหัส icd-10 เพื่อค้นหา...">
										<input type="hidden" data-name="surveil_diag_code">
									</div>
									<div class="span4">
										<label for="">รหัส 506</label>
										<input type="text" class="span4" data-name="surveil_506_name" placeholder="พิมพ์รหัส 506 เพื่อค้นหา...">
										<input type="hidden" data-name="surveil_506_code">
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<label>วันที่เริ่มป่วย</label>
										<input type="text" class="span2" data-name="surveil-date">
									</div>
									<div class="span4">
										<label>สภาพผู้ป่วย</label>
										<select data-name="patient_status">
											<?php 
											foreach($patient_status as $key => $value)
												echo '<option value="'.$key.'">'.$value.'</option>';
											?>
										</select>
									</div>
									<div class="span2">
										<label>วันที่เสียชีวิต</label>
										<input type="text" class="span2" data-name="surveil-death-date">
									</div>
								</div>
								<div class="row">
									<div class="span4">
									<label>ชนิดของเชื้อโรค</label>
									<input type="text" class="span4" data-name="surveil-organism" placeholder="พิมพ์ชนิดของเชื่อโรค เพื่อค้นหา...">
									<input type="hidden" data-name="surveil-organism-code">
									</div>
									<div class="span4">
										<label>สาเหตุการป่วย</label>
										<input type="text" class="span4" data-name="surveil-complication" placeholder="พิมพ์สาเหตุการเจ็บป่วย เพื่อค้นหา...">
										<input type="hidden" data-name="surveil-complication-code">
									</div>
								</div>
							</div>
							<div class="tab-pane" id="surveil_addr">
								<div class="row">
									<div class="span4">
										<label for="">จังหวัด</label>
										<input type="hidden" data-name="chw_code"></input> 
										<input type="text" class="span4" data-name="chw_name" placeholder="พิมพ์ชื่อจังหวัด เพื่อค้นหา.." >
										<label for="">อำเภอ</label>
										<input type="hidden" data-name="amp_code"> 
										<input type="text" class="span4" data-name="amp_name" placeholder="พิมพ์ชื่ออำเภอ เพื่อค้นหา.." >
										<label for="">ตำบล</label>
										<input type="hidden" data-name="tmb_code"> 
										<input type="text" class="span4" data-name="tmb_name" placeholder="พิมพ์ชื่อตำบล เพื่อค้นหา.." >
									</div>
									<div class="span4">
										<label for="">หมู่บ้าน</label>
										<select data-name="mooban"></select>  
										<label for="">บ้านเลขที่</label>
										<input type="text" class="span2" data-name="address"> 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<button type="button" class="btn btn-primary" data-name="btn-save-surveil"><i class="icon-plus-sign icon-white"></i> เพิ่มรายการ</button>
			<button data-name="btnreset" class="btn" type="reset"> <i class="icon-refresh"></i> ยกเลิก</button>
			</form>
		</div>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
	</div>
</div>
<!-- /add 506 -->

<!-- add fp -->
<div class="modal hide fade" data-name="modal-fp">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>บันทึกข้อมูลการวางแผนครอบครัว (Family Planing)</h3>
	</div>
	<div class="modal-body">
		<p>
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab-fp-list" data-toggle="tab"><i class="icon-time"></i> ประวัติการรับบริการ</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-fp-list">
          <table class="table" data-name="tblServiceFPHistoryList">
            <thead>
            <tr>
              <th>#</th>
              <th>วันที่</th>
              <th>วิธีคุมกำเนิด</th>
              <th>สถานที่</th>
              <th></th>
            </tr>
            </thead>
            <tbody></tbody>
          </table>
				</div>
			</div>
		</div>
    <button data-name="btnNewFP" class="btn btn-success" type="button">
      <i class="icon-plus icon-white"></i> เพิ่มใหม่...
    </button>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
	</div>
</div>

<div class="modal hide fade" data-name="mdlNewFP">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>บันทึกข้อมูลการวางแผนครอบครัว (Family Planing)</h3>
  </div>
  <div class="modal-body">
    <p>
    <form class="form-inline">
    <input type="hidden" data-name="txtFPVisitID" />
      <blockquote>
        <i class="icon-warning-sign"></i> ข้อมูลการจ่ายยาสำหรับการวางแผนครอบครัวให้ลงในข้อมุลการจ่ายยา
      </blockquote>
      <table class="table">
        <tr>
          <td>วิธีคุมกำเนิด</td>
          <td>
            <input type="hidden" data-name="txtFPTypeId" />
            <input type="text" data-name="txtFPTypeName" class="input-xlarge uneditable-input" disabled />
            <button data-name="btnSearchFPType" type="button" class="btn btn-info">
              <i class="icon-search icon-white"></i>
            </button>
          </td>
        </tr>
        <tr>
          <td>สถานที่ร้บบริการ</td>
          <td>
            <input type="hidden" data-name="txtFPPlaceId" />
            <input type="text" data-name="txtFPPlaceName" class="input-xlarge uneditable-input" disabled />
            <button data-name="btnSearchFPPlace" type="button" class="btn btn-info">
              <i class="icon-search icon-white"></i>
            </button>
          </td>
        </tr>
      </table>

    </form>
    </p>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-primary" data-name="btnDoSaveFP"><i class="icon-tags icon-white"></i> เพิ่มรายการ</button>
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>

<div class="modal hide fade" data-name="mdlNewFPSearchHospital">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>ค้นหาสถานบริการ</h3>
  </div>
  <div class="modal-body">
    <p>
    <form class="form-search">
      <input type="text" class="input-xlarge search-query" data-name="txtNewFPHospitalQuery" placeholder="พิมพ์ชื่อ หรือ รหัส" />
      <button type="button" data-name="btnNewFPHospitalDoSearch" class="btn"><i class="icon-search"></i> ค้นหา</button>
    </form>
      <table class="table table-striped" data-name="tblNewFPSearchHospitalResult">
        <thead>
        <tr>
          <th>รหัสสถานบริการ</th>
          <th>ชื่อหน่วยบริการ</th>
        </tr>
        </thead>
        <tbody></tbody>
      </table>

    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>

<div class="modal hide fade" data-name="mdlNewFPSearchType">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>เลือกประเภทการคุมกำเนิด</h3>
  </div>
  <div class="modal-body">
    <p>

    <table class="table table-striped" data-name="tblNewFPSearchTypeList">
      <thead>
      <tr>
        <th>#</th>
        <th>ประเภทการคุมกำเนิด</th>
      </tr>
      </thead>
      <tbody></tbody>
    </table>

    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>

<!-- /add fp -->
<!-- add epi -->
<div class="modal hide fade" data-name="mdlServiceEPI">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>บันทึกข้อมูลการให้บริการสร้างเสริมภูมิคุ้มกันโรค (EPI)</h3>
  </div>
  <div class="modal-body">
    <p>
    <blockquote>
    บันทึกข้อมูลการให้บริการสร้างเสริมภูมิคุ้มกันโรค
    </blockquote>
    <div class="tabbable">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tabServiceEPIHistory" data-toggle="tab"><i class="icon-time"></i> ประวัติการรับบริการ</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tabServiceEPIHistory">
          <table class="table" data-name="tblServiceEPIHistoryList">
            <thead>
            <tr>
              <th>#</th>
              <th>วันที่</th>
              <th>รหัส</th>
              <th>รายละเอียด</th>
              <th>สถานที่</th>
              <th></th>
            </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
    <button data-name="btnNewEPI" class="btn btn-success" type="button">
      <i class="icon-plus icon-white"></i> เพิ่มใหม่...
    </button>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>

<div class="modal hide fade" data-name="mdlNewEPI">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>บันทึกข้อมูลการให้บริการสร้างเสริมภูมิคุ้มกันโรค
  </div>
  <div class="modal-body">
    <p>
    <form class="form-inline">
      <input type="hidden" data-name="txtEPIVisitID" />
      <blockquote>
        <i class="icon-warning-sign"></i> บันทึกข้อมูลการให้บริการส่งเสริมป้องกันโรค
      </blockquote>
      <table class="table">
        <tr>
          <td>กิจกรรมวัคซีน</td>
          <td>
            <input type="hidden" data-name="txtVCCTypeId" />
            <input type="text" data-name="txtVCCTypeName" class="input-xlarge uneditable-input" disabled />
            <button data-name="btnSearchVCCType" type="button" class="btn btn-info">
              <i class="icon-search icon-white"></i>
            </button>
          </td>
        </tr>
        <tr>
          <td>สถานที่ร้บบริการ</td>
          <td>
            <input type="hidden" data-name="txtVCCPlaceId" />
            <input type="text" data-name="txtVCCPlaceName" class="input-xlarge uneditable-input" disabled />
            <button data-name="btnSearchVCCPlace" type="button" class="btn btn-info">
              <i class="icon-search icon-white"></i>
            </button>
          </td>
        </tr>
      </table>
    </form>
    </p>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-primary" data-name="btnDoSaveVCC"><i class="icon-tags icon-white"></i> เพิ่มรายการ</button>
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>

<div class="modal hide fade" data-name="mdlNewEPISearchHospital">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>ค้นหาสถานบริการ</h3>
  </div>
  <div class="modal-body">
    <p>
    <form class="form-search">
      <input type="text" class="input-xlarge search-query" data-name="txtNewEPIHospitalQuery" placeholder="พิมพ์ชื่อ หรือ รหัส" />
      <button type="button" data-name="btnNewEPIHospitalDoSearch" class="btn"><i class="icon-search"></i> ค้นหา</button>
    </form>
    <table class="table table-striped" data-name="tblNewEPISearchHospitalResult">
      <thead>
      <tr>
        <th>รหัสสถานบริการ</th>
        <th>ชื่อหน่วยบริการ</th>
      </tr>
      </thead>
      <tbody></tbody>
    </table>

    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>

<div class="modal hide fade" data-name="mdlNewEPISearchType">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>เลือกกิจกรรมวัคซีนที่ให้บริการ</h3>
  </div>
  <div class="modal-body">
    <p>

    <table class="table table-striped" data-name="tblNewEPISearchTypeList">
      <thead>
      <tr>
        <th>#</th>
        <th>รหัส</th>
        <th>กิจกรรมวัคซีน</th>
      </tr>
      </thead>
      <tbody></tbody>
    </table>

    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>

<!-- /add epi -->
<!-- add anc -->
<div class="modal hide fade" data-name="modal-anc">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>บันทึกข้อมูลการฝากครรภ์ (ANC)</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-anc">
			<h4>เงื่อนไขการให้บริการ</h4>
			<p>
				1. หญิงตั้งครรภ์ทุกคนที่มารับบริการ <br />
				2. การตั้งครรภ์ 1 ครั้งสามารถรับบริการฝากครรภ์ได้มากกว่า 1 ครั้ง (Record)
			</p>
		</div>
		<p>
		<div class="tabbable">
			<ul class="nav nav-pills">
				<li class="active"><a href="#tab-anc-list" data-toggle="tab"><i class="icon-time icon-white"></i> ประวัติการรับบริการ</a></li>
				<li><a href="#tab-anc-new" data-toggle="tab"><i class="icon-plus-sign icon-white"></i> เพิ่มข้อมูลใหม่</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-anc-list">
					<table class="table table-striped" data-name="tblANCList">
						<thead>
							<tr>
								<th>วันที่รับบริการ</th>
								<th>สถานที่ตรวจ</th>
								<th>ครรภ์ที่</th>
								<th>อายุครรภ์</th>
								<th>ผลการตรวจ</th>
								<th></th>
							</tr>
							<tbody>
							</tbody>
						</thead>
					</table>
				</div>
				<div class="tab-pane" id="tab-anc-new">
				<form>
					<div class="row">
						<div class="span5">
							<label for="">สถานที่ตรวจ</label>
							<input type="text" data-name="anc-service-place-name" class="span5">		
							<input type="hidden" data-name="anc-service-place-code">		
						</div>
					</div>
					<div class="row">
						<div class="span2">
							<label for="">ครรภ์ที่</label>
							<input type="number" data-name="anc-gravida" class="span2">
						</div>
						<div class="span2">
							<label for="">อายุครรภ์</label>
							<input type="number" data-name="anc-ga" class="span2">
						</div>
						<div class="span2">
							<label for="">ผลการตรวจ</label>
							<select data-name="anc-res" class="span2">
								<option value="1" selected="selected">ปกติ</option>
								<option value="2">ผิดปกติ</option>
							</select>
						</div>
						</div>
					<button type="button" class="btn btn-primary" data-name="btn-save-anc"><i class="icon-plus-sign icon-white"></i> เพิ่มรายการ</button>
					<button data-name="btnreset" class="btn" type="reset"> <i class="icon-refresh"></i> ยกเลิก</button>
				</form>
				</div>
			</div>
		</div>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
	</div>
</div>
<!-- /add anc -->
<!-- add ncd -->
<div class="modal hide fade" data-name="modal-ncd">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>บันทึกข้อมูลการคัดกรองเบาหวานความดัน</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-ncd">
			<h4>เงื่อนไขการให้บริการ</h4>
			<p>
				1. อายุ 15 ปีขึ้นไป ไม่ป่วยเป็นโรคเบาหวาน ความดันโลหิตสูง <br />
				2.คัดกรองปีละ 1 ครั้ง 
			</p>
		</div>
		<p>
		<div class="tabbable">
			<ul class="nav nav-pills">
				<li class="active"><a href="#tab-ncd-list" data-toggle="tab"><i class="icon-time icon-white"></i> ประวัติการรับบริการ</a></li>
				<li><a href="#tab-ncd-new" data-toggle="tab"><i class="icon-plus-sign icon-white"></i> เพิ่มข้อมูลใหม่</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-ncd-list">
					<table class="table table-striped" data-name="tblNCDList">
						<thead>
							<tr>
								<th>วันที่คัดกรอง</th>
								<th>สถานที่คัดกรอง</th>
								<th>พื้นที่บริการ</th>
								<th>ปีงบประมาณ</th>
								<th></th>
							</tr>
							<tbody>
							</tbody>
						</thead>
					</table>
				</div>
				<div class="tab-pane" id="tab-ncd-new">
				<form>
					<div class="row">
						<div class="span2">
							<label for="">การสูบบุหรี่</label>
							<select data-name="ncd-smoke" class="span2">
						<?php 
						$i = 1;
						foreach($smokes as $key => $value){
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
						<div class="span2">
							<label for="">ดื่มแอลกอฮอล์</label>
							<select data-name="ncd-alcohol" class="span2">
						<?php 
						$i = 1;
						foreach($alcohols as $key => $value){
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
						<div class="span3">
							<label for="">เบาหวานในญาติสายตรง</label>
							<select data-name="ncd-dmfamily" class="span3">
								<option value="1" selected="selected">มีประวัติ</option>
								<option value="2">ไม่มี</option>
								<option value="2">ไม่ทราบ</option>
							</select>
						</div>
						<div class="span3">
							<label for="">ความดันสูงในญาติสายตรง</label>
							<select data-name="ncd-htfamily" class="span3">
								<option value="1" selected="selected">มีประวัติ</option>
								<option value="2">ไม่มี</option>
								<option value="2">ไม่ทราบ</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="span1">
							<label for="">น้ำหนัก</label>
							<input type="text" data-name="ncd-weight" value="" class="span1">
						</div>
						<div class="span1">
							<label for="">ส่วนสูง</label>
							<input type="text" data-name="ncd-height" class="span1">
						</div>
						<div class="span1">
							<label for="">รอบเอว</label>
							<input type="text" data-name="ncd-waist" class="span1">
						</div>
						<div class="span1">
							<label for="">BPH 1</label>
							<input type="text" data-name="ncd-bph1" class="span1">
						</div>
						<div class="span1">
							<label for="">BPL 1</label>
							<input type="text" data-name="ncd-bpl1" class="span1">
						</div>
						<div class="span1">
							<label for="">BPH 2</label>
							<input type="text" data-name="ncd-bph2" class="span1">
						</div>
						<div class="span1">
							<label for="">BPL 2</label>
							<input type="text" data-name="ncd-bpl2" class="span1">
						</div>
					</div>
					<div class="row">
						<div class="span1">
							<label for="">น้ำตาล</label>
							<input type="text" data-name="ncd-bslevel" class="span1">
						</div>
						<div class="span5">
							<label for="">วิธีการตรวจน้ำตาลในเลือด</label>
							<select data-name="ncd-bstest" style="width: 350px;">
						<?php 
						$i = 1;
						foreach($blood_screens as $key => $value){
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
					</div>
					<button type="button" class="btn btn-primary" data-name="btn-save-ncd"><i class="icon-plus-sign icon-white"></i> เพิ่มรายการ</button>
					<button data-name="btnreset" class="btn" type="reset"> <i class="icon-refresh"></i> ยกเลิก</button>
				</form>
				</div>
			</div>
		</div>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
	</div>
</div>
<!-- /add ncd -->
<!-- chronic fu  -->
<div class="modal hide fade" data-name="modal-chronicfu" style="width: 700px;">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>บันทึกข้อมูลการตรวจติดตามผู้ป่วยโรคเรื้อรัง (เบาหวาน, ความดันโลหิตสูง)</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-chronicfu">
			<h4>เงื่อนไขการให้บริการ</h4>
			<p>
				1. เป็นผู้ป่วยโรคเรื้อรัง (เบาหวาน และ ความดันโลหิตสูง)
			</p>
		</div>
		<p>
		<div class="tabbable">
			<ul class="nav nav-pills">
				<li class="active"><a href="#tab-chronicfu-list" data-toggle="tab"><i class="icon-time icon-white"></i> ประวัติการรับบริการ</a></li>
				<li><a href="#tab-chronicfu-new" data-toggle="tab"><i class="icon-plus-sign icon-white"></i> เพิ่มข้อมูลใหม่</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-chronicfu-list">
					<table class="table table-striped" data-name="tblChronicFuList">
						<thead>
							<tr>
								<th>วันที่ตรวจ</th>
								<th>ความดันซิสโตลิก</th>
								<th>ความดันไดแอสโตลิก</th>
								<th>ตรวจจอประสาทตา</th>
								<th>ตรวจเท้า</th>
								<th></th>
							</tr>
							<tbody>
							</tbody>
						</thead>
					</table>
				</div>
				<div class="tab-pane" id="tab-chronicfu-new">
				<form>
					<div class="row">
						<div class="span1">
							<label for="">น้ำหนัก</label>
							<input type="text" data-name="chronicfu-weight" value="" class="span1">
						</div>
						<div class="span1">
							<label for="">ส่วนสูง</label>
							<input type="text" data-name="chronicfu-height" class="span1">
						</div>
						<div class="span1">
							<label for="">รอบเอว</label>
							<input type="text" data-name="chronicfu-waist" class="span1">
						</div>
						<div class="span1">
							<label for="">SBP</label>
							<input type="text" data-name="chronicfu-sbp" class="span1">
						</div>
						<div class="span1">
							<label for="">DBP</label>
							<input type="text" data-name="chronicfu-dbp" class="span1">
						</div>
					</div>
					<div class="row">
						<div class="span4">
							<label for="">การตรวจเท้า</label>
							<select data-name="chronicfu-foot">
								<option value="1" selected="selected">ตรวจ</option>
								<option value="2">ไม่ตรวจ</option>
							</select>
						</div>
						<div class="span4">
							<label for="">การตรวจจอประสาทตา</label>
							<select data-name="chronicfu-eye">
								<option value="1" selected="selected">ตรวจ</option>
								<option value="2">ไม่ตรวจ</option>
							</select>
						</div>
					</div>
					<button type="button" class="btn btn-primary" data-name="btn-save-chronicfu"><i class="icon-plus-sign icon-white"></i> เพิ่มรายการ</button>
					<button data-name="btnreset" class="btn" type="reset"> <i class="icon-refresh"></i> ยกเลิก</button>
				</form>
				</div>
			</div>
		</div>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
	</div>
</div>
<!-- /chronic fu -->
<!-- lab order  -->
<div class="modal hide fade" data-name="mdlServiceLabOrder">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>สั่ง LAB</h3>
	</div>
	<div class="modal-body">
		<p>
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tabServiceNewLabGroup" data-toggle="tab"><i class="icon-check"></i> สั่ง LAB</a></li>
				<li><a href="#tabServiceLabOrderHistory" data-toggle="tab"><i class="icon-time"></i> ประวัติวันนี้</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tabServiceNewLabGroup">
					<blockquote>
            เลือกกลุ่มของ LAB ที่ต้องการ
					</blockquote>
					<table class="table table-striped" data-name="tblServiceLabOrderList">
            <thead>
            <tr>
              <th>#</th>
              <th>กลุ่ม LAB</th>
            </tr>
            </thead>
            <tbody></tbody>
          </table>
				</div>
				<div class="tab-pane" id="tabServiceLabOrderHistory">
          <blockquote>
            ประวัติการส่ง LAB ในครั้งนี้
          </blockquote>
          <table class="table table-stripped" data-name="tblServiceLabOrderHistoryList">
            <thead>
              <tr>
                <th>#</th>
                <th>กลุ่ม LAB</th>
                <th></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
				</div>
			</div>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
	</div>
</div>
<!-- /lab order -->
<!-- lab result  -->
<div class="modal hide fade" data-name="mdlServiceLabResult">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>สั่ง LAB</h3>
	</div>
	<div class="modal-body">
		<p>
    <div data-name="divServiceLabVisitGroup">
    <blockquote>
      เลือกกลุ่ม LAB ที่ต้องการบันทึกผล
    </blockquote>
    <table class="table table-stripped" data-name="tblServiceLabOrderForResult">
      <thead>
      <tr>
        <th>#</th>
        <th>กลุ่ม LAB</th>
        <th></th>
      </tr>
      </thead>
      <tbody></tbody>
    </table>
    </div>
		</p>
    <div style="display: none; overflow: auto;" data-name="divSaveLabItemList">
      <div class="tabbable">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tabServiceLabOrderItemList" data-toggle="tab"><i class="icon-edit"></i> บันทึกผล LAB</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tabServiceLabOrderItemList">
            <blockquote>บันทึกรายงานผล LAB: <span class="label label-info" data-name="spanLabName"></span></blockquote>
            <table class="table table-striped" data-name="tblServiceLabItemResultList">
              <thead>
              <tr>
                <th>#</th>
                <th>รายการ LAB</th>
                <th>ผล</th>
                <th>หน่วย</th>
                <th></th>
              </tr>
              </thead>
              <tbody></tbody>
            </table>
            <a href="#" class="btn" data-name="btnHideDivLabItemResult"><i class="icon-chevron-up"></i> ปิด/ซ่อน (Close/Hide)</a><br />
          </div>
        </div>
      </div>
    </div>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
	</div>
</div>
<!-- /lab result -->
<!-- post mch  -->
<div class="modal hide fade" data-name="modal-mch-post">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>ข้อมูลการดูแลแม่หลังคลอด</h3>
  </div>
  <div class="modal-body">
    <p>
      <ul class="nav nav-pills">
        <li class="active"><a href="#tab-mch-new" data-toggle="tab"><i class="icon-plus-sign icon-white"></i> เพิ่มการบริการ</a></li>
        <li><a href="#tab-mch-history" data-toggle="tab"><i class="icon-time icon-white"></i> ประวัติการรับบริการ</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab-mch-new">
          new
        </div>
        <div class="tab-pane" id="tab-mch-history">
          history
        </div>
      </div>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>
<!-- /post mch -->
<!-- pre mch  -->
<div class="modal hide fade" data-name="modal-mch-pre">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h3>ข้อมูลการดูแลแม่ก่อนคลอด</h3>
  </div>
  <div class="modal-body">
    <p>
      <ul class="nav nav-pills">
        <li class="active"><a href="#tab-premch-new" data-toggle="tab"><i class="icon-plus-sign icon-white"></i> เพิ่มการบริการ</a></li>
        <li><a href="#tab-premch-history" data-toggle="tab"><i class="icon-time icon-white"></i> ประวัติการรับบริการ</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab-premch-new">
          <form action="#">
						<div class="row">
							<div class="span2">
								<label for="">Albumin</label>
								<select data-name="pre-mch-place" class="span2">
									<option valu="Normal">Normal</option>
									<option valu="+1">+1</option>
									<option valu="+2">+2</option>
									<option valu="+3">+3</option>
									<option valu="+4">+4</option>
									<option valu="Trace">Trace</option>
								</select>
							</div>
							<div class="span2">
								<label for="">ระดับมดลูก</label>
								<select data-name="pre-mch-place" class="span2">
									<option valu="0">SP</option>
									<option valu="1">1/3 มากกว่า SP</option>
									<option valu="2">2/3 มากกว่า SP</option>
									<option valu="3">ระดับสะดือ</option>
									<option valu="4">1/4 มากกว่าสะดือ</option>
									<option valu="5">2/4 มากกว่าสะดือ</option>
									<option valu="6">3/4 มากกว่าสะดือ</option>
								</select>
							</div>
							<div class="span2">
								<label for="">ระดับน้ำตาบ</label>
								<select data-name="pre-mch-sugar" class="span2">
									<option valu="Normal">Normal</option>
									<option valu="+1">+1</option>
									<option valu="+2">+2</option>
									<option valu="+3">+3</option>
									<option valu="+4">+4</option>
									<option valu="Trace">Trace</option>
								</select>
							</div>
						</div>
					</form>
        </div>
        <div class="tab-pane" id="tab-premch-history">
          history
        </div>
      </div>
    </p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
  </div>
</div>
<!-- /pre mch -->

<!-- search smoking --->
<div data-name="mdlSearchSmoking" class="modal hide fade in">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3>การสูบบุหรี่</h3>
  </div>
  <div class="modal-body">
    <table class="table table-striped" data-name="tblSmokingList">
      <thead>
      <tr>
        <th>#</th>
        <th>รายการ</th>
        <th></th>
      </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>

  <div class="modal-footer">
    <button class="btn" type="button" data-dismiss="modal">
      <i class="icon-off"></i> ปิดหน้าต่าง
    </button>
  </div>
</div>
<!-- /search smoking -->

<!-- search drinking --->
<div data-name="mdlSearchDrinking" class="modal hide fade in">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3>การดื่มสุรา</h3>
  </div>
  <div class="modal-body">
    <table class="table table-striped" data-name="tblDrinkingList">
      <thead>
      <tr>
        <th>#</th>
        <th>รายการ</th>
        <th></th>
      </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>

  <div class="modal-footer">
    <button class="btn" type="button" data-dismiss="modal">
      <i class="icon-off"></i> ปิดหน้าต่าง
    </button>
  </div>
</div>
<!-- /search drinking -->

<!-- search allergics --->
<div data-name="mdlSearchAllergics" class="modal hide fade in">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3>การดื่มสุรา</h3>
  </div>
  <div class="modal-body">
    <table class="table table-striped" data-name="tblAllergicsList">
      <thead>
      <tr>
        <th>#</th>
        <th>รายการ</th>
        <th></th>
      </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>

  <div class="modal-footer">
    <button class="btn" type="button" data-dismiss="modal">
      <i class="icon-off"></i> ปิดหน้าต่าง
    </button>
  </div>
</div>
<!-- /search drinking -->

<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.detail.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.diag.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.proced.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.drug.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.income.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.lab.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.fp.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.epi.js"></script>

<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.appoint.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.surveil.js"></script>


<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.anc.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.ncd.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.chronicfu.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.mch.js"></script>
