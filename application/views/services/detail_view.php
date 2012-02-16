<?php foreach ($rows as $row); ?>
<?php foreach ($screenings as $sc); ?>
<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>">หน้าหลัก</a><span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>services">การให้บริการ</a><span class="divider">/</span></li>
  <li class="active">บันทึกการให้บริการ</li>
</ul>

<div class="patient-detail">
		<div class="rows">
			<div class="span2">
				<?php echo img(array(
												'src' => 'assets/img/no_person.jpg',
												'width' => '75',
												'height' => '100'
											)); 
					?>
			</div>
			<div class="span4">
				<strong>เลขที่รับบริการ</strong> :  <?php echo $row->vn; ?> <br />
				<input type="hidden" data-name="vn" value="<?php echo $row->vn; ?>" id="vn">
				<input type="hidden" data-name="cid" value="<?php echo $row->cid; ?>">
				<strong>เลขบัตรประชาชน</strong>: <?php echo $row->cid; ?> <br />
				<strong>ชื่อ - สกุล</strong>: <?php echo $row->fname. ' '. $row->lname; ?> <br />
				<strong>วันเกิด</strong>: <?php echo to_thai_date ( $row->birthdate ); ?> <br /> <br />
				<a href="<?php echo base_url(); ?>people/detail/<?php echo $row->cid; ?>" class="btn btn-primary"><i class="icon-user icon-white"></i>  แก้ไขข้อมูล »</a>
			</div>
			<div class="span5">
				<strong>วันที่รับบริการ</strong>: <?php echo to_thai_date ( $row->date_serv ) . ' '. $row->time_serv; ?> <br />
				<strong>แผนก</strong>: <?php echo $row->clinic_name; ?> <br />
				<strong>สิทธิการรักษา</strong>: <?php echo $row->ins_name; ?> <br />
				<strong>เลขที่สิทธิ</strong>: <?php echo $row->ins_code; ?> <br /> <br />
				
				<a href="<?php echo base_url(); ?>people/detail/<?php echo $row->cid; ?>" class="btn btn-success"><i class="icon-calendar icon-white"></i> ประวัติการรับบริการ  »</a>
			</div>
		</div>
		<br />
</div>

<div class="form-actions" style="height: 30px;">
	<div style="float: left; padding: 5px;">
		<a href="#" class="btn btn-primary"><i class="icon-edit icon-white"></i> รายงานผล LAB</a>
		<a href="#" class="btn btn-inverse"><i class="icon-share icon-white"></i>  ส่งต่อผู้ป่วย</a>
		<a href="#modal-506" class="btn btn-danger" data-name="show-506" data-toggle="modal"><i class="icon-fire icon-white"></i> บันทึก 506</a>
		<a href="#modal-appoint" data-name="show-appoint" data-toggle="modal" class="btn btn-info"><i class="icon-tags icon-white"></i>  ลงทะเบียนนัด</a>
	</div>
	<div style="float: left; padding: 5px;">
		<div class="btn-group">
			<a class="btn btn-primary" href="#"> <i class="icon-folder-open icon-white"></i>  ส่งเสริมสุขภาพ</a>
			<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="#modal-fp" data-toggle="modal" data-name="service-fp"> <i class="icon-eye-open"></i>  วางแผนครอบครัว (Family Planing)</a></li>
				<li><a href="#modal-epi" data-toggle="modal" data-name="service-epi"><i class="icon-random"></i> สร้างเสริมภูมิคุ้มกันโรค (EPI)</a></li>
				<li><a href="#">เยี่ยมมารดาหลังคลอด</a></li>
				<li><a href="#">เยี่ยมเด็กหลังคลอด</a></li>
				<li class="divider"></li>
				<li><a href="#">ฉีดวัคซีน</a></li>
				<li><a href="#">อนามัยโรงเรียน</a></li>
			</ul>
		</div>
	</div>
	<div style="float: left; padding: 5px;">
		<div class="btn-group">
			<a class="btn btn-success" href="#">บริการอื่นๆ</a>
			<a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="#">บริการทันตกรรม</a></li>
				<li><a href="#">แพทย์แผนไทย</a></li>
				<li class="divider"></li>
				<li><a href="#">เบาหวาน/ความดัน</a></li>
				<li><a href="#">คัดกรองมะเร็ง</a></li>
			</ul>
		</div>
	</div>
</div>

<!-- alert -->
<div id="alert-block" class="alert alert-info">
	<!-- <a class="close" data-dismiss="alert" href="#">&times;</a> -->
	<h4 class="alert-heading">คำแนะนำ</h4>
	<p>กรุณากรอกข้อมูลให้ถูกต้องและสมบูรณ์ ไม่เช่นนั้นโปรแกรมจะไม่ทำการบันทึกข้อมูลการให้บริการของผู้รับบริการ</p>
</div>
<!-- /alert -->

	<!-- main tab -->
<ul class="nav nav-pills">
	<li class="active">
		<a data-toggle="tab" href="#tab-cc"> <i class="icon-check icon-white"></i> ข้อมูลคัดกรอง</a>
	</li>
	<li>
		<a data-toggle="tab" href="#tab-diag"> <i class="icon-edit icon-white"></i> การวินิจฉัยโรค</a>
	</li>
	<li>
		<a data-toggle="tab" href="#tab-proced"> <i class="icon-eye-open icon-white"></i> การทำหัตถการ</a>
	</li>
	<li>
		<a data-toggle="tab" href="#tab-drug"> <i class="icon-check icon-white"></i> การจ่ายยา</a>
	</li>
	<li>
		<a data-toggle="tab" href="#tab-income"> <i class="icon-shopping-cart icon-white"></i>  ค่าบริการอื่นๆ</a>
	</li>
</ul>
<!-- tab content -->
<!-- tabs data -->

<div class="tab-content" style="min-height: 350px;">
	<div class="tab-pane active" id="tab-cc">
		<div class="row">
			<div class="span2">
				<label>น้ำหนัก</label>
				<input data-name="weight" class="" style="width: 90px;" type="text" value="<?php echo ! empty($sc) ? $sc->weight : ''; ?>">
				<label>รอบเอว (ซม.)</label>
				<input data-name="waistline" class="" style="width: 90px;" type="text" value="<?php echo ! empty($sc) ? $sc->waistline : ''; ?>">
				<label>BMI</label>
				<input data-name="bmi" style="width: 90px;" type="text" value="<?php echo ! empty($sc) ? $sc->bmi : ''; ?>">
			</div>
			<div class="span2">
				<label>ส่วนสูง (ซม.)</label>
				<input data-name="height" style="width: 90px;" type="text" value="<?php echo ! empty($sc) ? $sc->height : ''; ?>">
				<label>ความดัน (บน)</label>
				<input data-name="bp1" style="width: 90px;" type="text" value="<?php echo ! empty($sc) ? $sc->bp1 : ''; ?>">
				<label>ความดัน (ล่าง)</label>
				<input data-name="bp2" style="width: 90px;" type="text" value="<?php echo ! empty($sc) ? $sc->bp2 : ''; ?>">
			</div>
			<div class="span2">
				<label>ชีพจร (m.)</label>
				<input data-name="pulse" style="width: 90px;" type="text" value="<?php echo ! empty($sc) ? $sc->pulse : ''; ?>">
				<label>อุณหภูมิ </label>
				<input data-name="temperature" style="width: 90px;" type="text" value="<?php echo ! empty($sc) ? $sc->temperature : ''; ?>">
				<label>DTX1</label>
				<input data-name="dtx1" style="width: 90px;" type="text" value="<?php echo ! empty($sc) ? $sc->dtx1 : ''; ?>" >
			</div>
			
			<div class="span2">
				<label>หัวใจ (m.)</label>
				<input data-name="heartbeat" style="width: 90px;" type="text" value="<?php echo ! empty($sc) ? $sc->heartbeat : ''; ?>">
				<label>FBS</label>
				<input data-name="fbs" style="width: 90px;" type="text" value="<?php echo ! empty($sc) ? $sc->fbs : ''; ?>">
				<label>DTX2</label>
				<input data-name="dtx2" style="width: 90px;" type="text" value="<?php echo ! empty($sc) ? $sc->dtx2 : ''; ?>">
			</div>
				
		</div><!-- /row -->
		<div class="row">
			<div class="span3">
				<label for="cigarate">การสูบบุหรี่</label>
				<select data-name="smoking" id="cigarate" style="width: 140px;">
					<?php
						foreach ( $smokings as $key => $value ) {
							if( $sc->smoking == $key ) {
								echo '<option value="'.$key.'" selected="selected">'. $value . '</option>';
							}else {
								echo '<option value="'.$key.'">'. $value . '</option>';
							}
						}
					?>
				</select>
			</div>
			<div class="span3">
				<label for="drink">การดื่่มสุรา</label>
				<select data-name="drinking" id="drink" style="width: 140px;">
					<?php
						foreach ( $drinkings as $key => $value ) {
							if( $sc->drinking == $key ) {
								echo '<option value="'.$key.'" selected="selected">'. $value . '</option>';
							}else {
								echo '<option value="'.$key.'">'. $value . '</option>';
							}
						}
					?>
				</select>
			</div>
			<div class="span3">
				<label for="drug-error">การแพ้ยา</label>
				<select data-name="allergic" id="drug-error" style="width: 140px;">
					<?php
						foreach ( $allergics as $key => $value ) {
							if( $sc->allergic == $key ) {
								echo '<option value="'.$key.'" selected="selected">'. $value . '</option>';
							}else {
								echo '<option value="'.$key.'">'. $value . '</option>';
							}
						}
					?>
				</select>
			</div>
		</div><!-- /row -->
		
		<div class="row">
			<div class="span3">
				<label for="cc">อาการแรกรับ</label>
				<textarea style="width: 610px;" rows="4" id="cc" data-name="cc"><?php echo ! empty($sc) ? $sc->cc : ''; ?></textarea>
			</div>
		</div>
		
		<div style="padding: 5px;">
			<a href="#" class="btn btn-primary" data-loading-text="Saving..." data-name="btnSaveScreen">
				<i class="icon-ok-sign icon-white"></i> บันทึกการคัดกรอง</a>
		</div>
			
	</div> <!-- /tab-cc -->
	<div class="tab-pane" id="tab-diag">

		<table class="table table-striped" data-name="tblDiag">
			<thead>
				<tr>
					<th>รหัส</th>
					<th>คำอธิบาย</th>
					<th>Diag type</th>
					<th>ดำเนินการ</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if( !empty($diags) ) {
						foreach ($diags as $diag) {
							echo '<tr>';
							echo '<td>'. $diag->diag_code .'</td>';
							echo '<td>'. $diag->name .'</td>';
							echo '<td>';
							switch ($diag->diag_type) {
								case '1':
									echo 'PRINCIPLE (การวินิจฉัยโรคหลัก)';
									break;
								case '2':
									echo 'CO-MORBIDITY (การวินิจฉัยโรคร่วม)';
									break;
								case '3':
									echo 'COMPLICATION (การวินิจฉัยโรคแทรก)';
									break;
								case '4':
									echo 'OTHER (อื่นๆ)';
									break;	
								case '5':
									echo 'EXTERNAL CAUSE  (สาเหตุภายนอก)';
									break;	
								default:
									echo 'ไม่ระบุ';
									break;
							}
							echo '</td>';
							echo '<td><a href="#" data-name="remove-icd" data-diag="' . $diag->diag_code . '" class="btn"> <i class="icon-trash"></i> </a></td>';
							echo '</tr>';
						}	
					}
				?>
			</tbody>
		</table>
		<div class="span2 offset9">
			<a href="#modal-diag" data-toggle="modal" class="btn btn-primary"> <i class="icon-plus-sign icon-white"></i> เพิ่มใหม่ </a>
		</div>
	</div><!-- /tab-diag -->
	<div class="tab-pane" id="tab-proced">
		<table class="table table-striped" data-name="tblProced">
			<thead>
				<tr>
					<th>รหัสหัตถการ</th>
					<th>คำอธิบาย</th>
					<th>ราคา</th>
					<th>ผู้ให้หัตถการ</th>
					<th>ดำเนินการ</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if( ! empty($procedures) ) { 
					foreach ($procedures as $proced) {
						echo '<tr><td>' . $proced->code . '</td><td>' . $proced->name . '</td><td style="text-align: right;">' . number_format($proced->price, 2) . '</td><td>' . $proced->fullname  . '</td>';
						echo '<td><a href="#" data-name="remove-proced" data-proced="' . $proced->code . '" class="btn"> <i class="icon-trash"></i> </a></td>';
						echo '</tr>';
					}
				} ?>
			</tbody>
		</table>
		<div class="span2 offset9">
			<a href="#modal-proced" data-toggle="modal" class="btn btn-primary"> <i class="icon-plus-sign icon-white"></i> เพิ่มใหม่ </a>
		</div>
	</div><!-- /tab-proced -->
	<div class="tab-pane" id="tab-drug">
		<table class="table table-striped" data-name="tblDrug">
			<thead>
				<tr>
					<th>ชื่อยา</th>
					<th>วิธีการใช้</th>
					<th>ราคา</th>
					<th>จำนวน</th>
					<th>รวมเงิน</th>
					<th>จัดการ</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if( ! empty($drugs) ) {
					foreach ($drugs as $drug) {
						echo '<tr>';
						echo '<td>' . $drug->drug_name . '</td>';
						echo '<td>' . $drug->usage_name . '</td>';
						echo '<td style="text-align: right;">' . number_format($drug->price,2) . '</td>';
						echo '<td style="text-align: right;">' . number_format($drug->qty, 2) . '</td>';
						echo '<td style="text-align: right;">' . number_format($drug->price * $drug->qty, 2) . '</td>';
						echo '<td><a href="#" data-name="remove-drug" data-drug="' . $drug->drug_id . '" class="btn"> <i class="icon-trash"></i> </a></td>';
						echo '</tr>';
					}
				}
				?>
			</tbody>
		</table>
		<div class="span2 offset9">
			<a href="#modal-drug" data-toggle="modal" class="btn btn-primary"> <i class="icon-plus-sign icon-white"></i> เพิ่มใหม่ </a>
		</div>
	</div>
	<div class="tab-pane" id="tab-income">
		<table class="table table-striped" data-name="tblIncome">
			<thead>
				<tr>
					<th>รายการค่าใช้จ่าย</th>
					<th>หน่วย</th>
					<th>ราคา</th>
					<th>จำนวน</th>
					<th>รวมเงิน</th>
					<th>จัดการ</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if( ! empty($incomes) ) {
					foreach ($incomes as $income) {
						echo '<tr>';
						echo '<td>' . $income->name . '</td>';
						echo '<td>' . $income->unit . '</td>';
						echo '<td style="text-align: right;">' . number_format($income->price,2) . '</td>';
						echo '<td style="text-align: right;">' . number_format($income->qty, 2) . '</td>';
						echo '<td style="text-align: right;">' . number_format($income->price * $income->qty, 2) . '</td>';
						echo '<td><a href="#" data-name="remove-income" data-income="' . $income->income_id . '" class="btn"> <i class="icon-trash"></i> </a></td>';
						echo '</tr>';
					}
				}
				?>
			</tbody>
		</table>
		<div class="span2 offset9">
			<a href="#modal-income" data-toggle="modal" class="btn btn-primary"> <i class="icon-plus-sign icon-white"></i> เพิ่มใหม่ </a>
		</div>
	</div>
</div>

<!-- end tab content -->
<!--  add diag -->
<div class="modal hide fade" id="modal-diag">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>เพิ่มข้อมูลการวินิจฉัย</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-diag">
			<h4>คำแนะนำ</h4>
			<p>กรุณากรอกรายละเอียดให้ถูกต้องและสมบูรณ์</p>
		</div>
		<p>
			<form class="form-horizontal" data-name="frmSaveDiag">
				<label for="">รหัสวินิจฉัย</label>
				<input class="input-small" type="text" disabled="disabled" data-name="diag_code" autocomplete="off"> 
				<input type="text" class="input-xlarge focused" data-name="diag_name" placeholder="พิมพ์รายละเอียด หรือ รหัส icd10..." autocomplete="off">
				<label for="">ประเภทการวินิจฉัย</label>
				<select data-name="diag_type" id="diag_type" style="width: 385px;">
					<?php
						foreach ($diag_types as $key => $value) {
							if ($key == '1')
								echo '<option value="'.$key.'" selected="selected">'.$value.'</option>';
								
							echo '<option value="'.$key.'">'.$value.'</option>';
						}
					?>
				</select>
				<button data-name="btnreset" class="btn" type="reset"><i class="icon-refresh"></i> ยกเลิก</button>
			</form>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
		<a href="#" class="btn btn-primary" data-name="btn-save-diag"><i class="icon-plus-sign icon-white"></i> เพิ่มรายการ</a>
	</div>
</div>
<!-- /add diag -->
<!-- add proced -->
<div class="modal hide fade" id="modal-proced">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>เพิ่มข้อมูลการให้หัตถการ</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-proced">
			<h4>คำแนะนำ</h4>
			<p>กรุณากรอกรายละเอียดให้ถูกต้องและสมบูรณ์</p>
		</div>
		<p>
			<form class="form-horizontal" data-name="frmSaveProced">
				<label for="">รหัสหัตถการ</label>
				<input class="input-small" type="hidden" disabled="disabled" data-name="proced_code" autocomplete="off"> 
				<input type="text" class="input-xlarge focused" data-name="proced_name" placeholder="พิมพ์รายละเอียด หรือ รหัส icd9..." autocomplete="off">
				<label for="">ราคา</label>
				<input type="number" class="input-small" name="proced_price" data-name="proced_price">
				<button data-name="btnreset" class="btn" type="reset"><i class="icon-refresh"></i> ยกเลิก</button>
			</form>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
		<a href="#" class="btn btn-primary" data-name="btn-save-proced"><i class="icon-plus-sign icon-white"></i> เพิ่มรายการ</a>
	</div>
</div>
<!-- /add proced -->
<!-- add drug -->
<div class="modal hide fade" id="modal-drug">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>เพิ่มข้อมูลการให้จ่ายยา</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-drug">
			<h4>คำแนะนำ</h4>
			<p>กรุณากรอกรายละเอียดให้ถูกต้องและสมบูรณ์</p>
		</div>
		<p>
			<form class="form-horizontal" data-name="frmSaveDrug">
				<label for="">ชื่อยา</label>
				<input type="hidden" data-name="drug_id"> 
				<input type="text" class="input-xlarge focused" data-name="drug_name" placeholder="พิมพ์ชื่อยาเพื่อค้นหา.." >
				<label for="">วิธีการใช้ยา</label>
				<input type="hidden" data-name="usage_id">
				<input type="text" class="input-xlarge" data-name="usage_name" placeholder="พิมพ์วิธีการใช้เพื่อค้นหา.." > 
				<a href="#" class="btn"><i class="icon-plus-sign"></i></a>
				<div class="row">
					<div class="span3">
						<label for="">ราคา</label>
						<input type="number" class="input-small" data-name="drug_price" value="0.00" placeholder="0.00">  
					</div>
					<div class="span3">
						<label for="">จำนวน</label>
						<input type="number" class="input-small" data-name="drug_qty" value="1" placeholder="0">
					</div>
				</div>
				<button data-name="btnreset" class="btn" type="reset" style="display: none;"><i class="icon-refresh"></i> ยกเลิก</button>
			</form>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
		<a href="#" class="btn btn-primary" data-name="btn-save-drug"><i class="icon-plus-sign icon-white"></i> เพิ่มรายการ</a>
	</div>
</div>
<!-- /add drug -->
<!-- add income -->
<div class="modal hide fade" id="modal-income">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>เพิ่มข้อมูลค่าใช้จ่าย</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-income">
			<h4>คำแนะนำ</h4>
			<p>กรุณากรอกรายละเอียดให้ถูกต้องและสมบูรณ์</p>
		</div>
		<p>
			<form class="form-horizontal" data-name="frmSaveIncome">
				<label for="">รายการค่าใช้จ่าย</label>
				<input type="hidden" data-name="income_id"> 
				<input type="hidden" data-name="income_unit">
				<input type="text" class="input-xlarge focused" data-name="income_name" placeholder="พิมพ์ชื่อค่าใช้จ่าย เพื่อค้นหา.." >
				<div class="row">
					<div class="span3">
						<label for="">ราคา</label>
						<input type="number" class="input-small" data-name="income_price" value="0.00" placeholder="0.00">  
					</div>
					<div class="span3">
						<label for="">จำนวน</label>
						<input type="number" class="input-small" data-name="income_qty" value="1" placeholder="0">
					</div>
				</div>
				<button data-name="btnreset" class="btn" type="reset" style="display: none;"><i class="icon-refresh"></i> ยกเลิก</button>
			</form>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
		<a href="#" class="btn btn-primary" data-name="btn-save-income"><i class="icon-plus-sign icon-white"></i> เพิ่มรายการ</a>
	</div>
</div>
<!-- /add income -->
<!-- add appointment -->
<div class="modal hide fade" id="modal-appoint" style="width: 780px;">
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
					<div style="overflow: auto; display:block; height: 190px;">
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
						<select data-name="appoint_id" style="width: 270px;">
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
<div class="modal hide fade" id="modal-506" style="width: 700px;">
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
										<input type="text" class="input-xlarge" data-name="surveil_diag_name" placeholder="พิมพ์รหัส icd-10 เพื่อค้นหา...">
										<input type="hidden" data-name="surveil_diag_code">
									</div>
									<div class="span4">
										<label for="">รหัส 506</label>
										<input type="text" class="input-xlarge" data-name="surveil_506_name" placeholder="พิมพ์รหัส 506 เพื่อค้นหา...">
										<input type="hidden" data-name="surveil_506_code">
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<label>วันที่เริ่มป่วย</label>
										<input type="text" class="input-small" data-name="surveil-date">
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
										<input type="text" class="input-small" data-name="surveil-death-date">
									</div>
								</div>
								<div class="row">
									<div class="span4">
									<label>ชนิดของเชื้อโรค</label>
									<input type="text" class="input-xlarge" data-name="surveil-organism">
									<input type="hidden" data-name="surveil-organism-code">
									</div>
									<div class="span4">
										<label>สาเหตุการป่วย</label>
										<input type="text" class="input-xlarge" data-name="surveil-complication">
										<input type="hidden" data-name="surveil-complication-code">
									</div>
								</div>
							</div>
							<div class="tab-pane" id="surveil_addr">
								<div class="row">
									<div class="span4">
										<label for="">จังหวัด</label>
										<input type="hidden" data-name="chw_code"></input> 
										<input type="text" class="input-xlarge" data-name="chw_name" placeholder="พิมพ์ชื่อจังหวัด เพื่อค้นหา.." >
										<label for="">อำเภอ</label>
										<input type="hidden" data-name="amp_code"> 
										<input type="text" class="input-xlarge" data-name="amp_name" placeholder="พิมพ์ชื่ออำเภอ เพื่อค้นหา.." >
										<label for="">ตำบล</label>
										<input type="hidden" data-name="tmb_code"> 
										<input type="text" class="input-xlarge" data-name="tmb_name" placeholder="พิมพ์ชื่อตำบล เพื่อค้นหา.." >
									</div>
									<div class="span4">
										<label for="">หมู่บ้าน</label>
										<select data-name="mooban"></select>  
										<label for="">บ้านเลขที่</label>
										<input type="text" class="input-small" data-name="address"> 
										<br />
										<button type="button" class="btn btn-primary" data-name="btn-save-surveil"><i class="icon-plus-sign icon-white"></i> เพิ่มรายการ</button>
										<button data-name="btnreset" class="btn" type="reset"> <i class="icon-refresh"></i> ยกเลิก</button>
									</div>
								</div>
				
							</div>
						</div>
					</div>
					</div>
			</div>
		</div>
		</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่าง</a>
	</div>
</div>
<!-- /add 506 -->

<!-- add fp -->
<div class="modal hide fade" id="modal-fp" style="width: 700px;">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>บันทึกข้อมูลการวางแผนครอบครัว (Family Planing)</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-fp">
			<h4>คำแนะนำ</h4>
			<p>ผู้มารับบริการ 1 คน สามารถใช้บริการได้มากกว่า 1 ครั้ง </p>
		</div>
		<p>
		<div class="tabbable">
			<ul class="nav nav-pills">
				<li class="active"><a href="#tab-fp-list" data-toggle="tab"><i class="icon-time icon-white"></i> ประวัติการรับบริการ</a></li>
				<li><a href="#tab-fp-new" data-toggle="tab"><i class="icon-plus-sign icon-white"></i> เพิ่มข้อมูลใหม่</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-fp-list">
					<table class="table table-striped" data-name="tblFPList">
						<thead>
							<tr>
								<th>วันที่รับบริการ</th>
								<th>วิธีคุมกำเนิด</th>
								<th>เวชภัณฑ์</th>
								<th>จำนวน</th>
								<th>สถานที่</th>
							</tr>
							<tbody>
							</tbody>
						</thead>
					</table>
				</div>
				<div class="tab-pane" id="tab-fp-new">
				<form>
					<div class="row">
						<div class="span4">
							<label for="">วิธีคุมกำเนิด</label>
							<select data-name="fp-type">
								<?php 
								$i = 1;
								foreach($fptypes as $key => $value){
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
						<div class="span4">
							<label for="">เวชภัณฑ์</label>
							<input type="text" data-name="fp-drug-name" class="input-xlarge">
							<input type="hidden" data-name="fp-drug-code">
						</div>
					</div>
					<div class="row">
						<div class="span4">
							<label for="">สถานที่รับบริการ</label>
							<select data-name="fp-place">
								<?php 
								$i = 1;
								foreach($fpplaces as $key => $value){
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
						<div class="span4">
							<label for="">จำนวน</label>
							<input type="number" class="input-small" data-name="fp-drug-amount">
							<label class="checkbox">
								<input type="checkbox" data-name="fp-add-income" checked="checked"> โอนค่าใช้จ่าย
							</label>
							<label class="checkbox">
								<input type="checkbox" data-name="fp-add-drug" checked="checked"> โอนรายการยา
							</label>
						</div>
					</div>
					<button type="button" class="btn btn-primary" data-name="btn-save-fp"><i class="icon-plus-sign icon-white"></i> เพิ่มรายการ</button>
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
<!-- /add fp -->
<!-- add epi -->
<div class="modal hide fade" id="modal-epi" style="width: 700px;">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>ยันทึกงานสร้างเสริมภูมิคุ้มกันโรค (EPI)</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-epi">
			<h4>เงื่อนไขการให้บริการ</h4>
			<p>
				1). เด็กอายุต่ำกว่า 7 ปี,  2). หญิงตั้งครรภ์, 3). นักเรียน ป.1, ป.2, ป.6, 4). ประชาชนกลุ่มทั่วไป		<br />
				สามารถรับวัคซีนได้มากกว่า 1 ชนิด
			</p>
		</div>
		<p>
		<div class="tabbable">
			<ul class="nav nav-pills">
				<li class="active"><a href="#tab-epi-list" data-toggle="tab"><i class="icon-time icon-white"></i> ประวัติการรับบริการ</a></li>
				<li><a href="#tab-epi-new" data-toggle="tab"><i class="icon-plus-sign icon-white"></i> เพิ่มข้อมูลใหม่</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-epi-list">
					<table class="table table-striped" data-name="tblEPIList">
						<thead>
							<tr>
								<th>วันที่รับบริการ</th>
								<th>วัคซีนที่ได้รับ</th>
								<th>สถานที่รับวัคซีน</th>
								<th></th>
							</tr>
							<tbody>
							</tbody>
						</thead>
					</table>
				</div>
				<div class="tab-pane" id="tab-epi-new">
				<form>
					<label for="">วัคซีนที่ได้รับ</label>
					<select data-name="epi-vcctype">
						<?php 
						$i = 1;
						foreach($vcctypes as $key => $value){
							if ($i == 1) {
								echo '<option value="'.$key.'" selected="selected">'.$value.'</option>';
							} else {
								echo '<option value="'.$key.'">'.$value.'</option>';
							}
							$i++;
						}
						?>
					</select>
					<label for="">สถานที่รับบริการ</label>
					<select data-name="epi-vccplace">
						<?php 
						$i = 1;
						foreach($vccplaces as $key => $value){
							if ($i == 1) {
								echo '<option value="'.$key.'" selected="selected">'.$value.'</option>';
							} else {
								echo '<option value="'.$key.'">'.$value.'</option>';
							}
							$i++;
						}
						?>
					</select>
					<label class="checkbox">
						<input type="checkbox" data-name="epi-add-income" checked="checked"> โอนค่าใช้จ่าย
					</label>
					<label class="checkbox">
						<input type="checkbox" data-name="epi-add-drug" checked="checked"> โอนรายการยา
					</label>
							
					<button type="button" class="btn btn-primary" data-name="btn-save-epi"><i class="icon-plus-sign icon-white"></i> เพิ่มรายการ</button>
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
<!-- /add epi -->
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.detail.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.drug.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.income.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.appoint.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.surveil.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.fp.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url(); ?>assets/js/apps/services.epi.js"></script>
