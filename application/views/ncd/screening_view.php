<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>">หน้าหลัก</a><span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>services">การให้บริการ</a><span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>ncd">ทะเบียนผู้ป่วยโรคเรื้อรัง</a><span class="divider">/</span></li>
  <li class="active">คัดกรองเบาหวานความดันโลหิตสูง</li>
</ul>

<ul class="nav nav-tabs">
  <li class="active">
    <a href="#tab-anc-list" data-toggle="tab">
    	<i class="icon-th"></i>
    	รายชื่อกลุ่มเป้าหมาย
  	</a>
  </li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="tab-ncd-target">
		<div class="btn-toolbar">
			<div class="btn-group">
		    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
		    ปีงบประมาณ
		    <span class="caret"></span>
		    </a>
		    <ul class="dropdown-menu">
		    	<li><a href="#">2555</a></li>
		    	<li><a href="#">2556</a></li>
		    </ul>
	    </div>
	    
			<div class="btn-group">
				<a class="btn btn-info" href="#">ทั้งหมด</a>
		    <a class="btn btn-success" href="#">ยังไม่คัดกรอง</a>
		    <a class="btn btn-primary" href="#">คัดกรองแล้ว</a>
	    </div>
		</div>

		<table class="table table-striped">
			<thead>
				<tr>
					<th>เลขบัตรประชาชน</th>
					<th>ชื่อ - สกุล</th>
					<th>วันเดือนปี เกิด</th>
					<th>อายุ (ปี)</th>
					<th>เพศ</th>
					<th>ที่อยู่</th>
					<th>สถานะ</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($targets as $target) :
				?>
				<tr>
					<td><?php echo $target->cid; ?></td>
					<td><?php echo $target->fname . ' ' . $target->lname; ?></td>
					<td><?php echo to_thai_date($target->birthdate); ?></td>
					<td><?php echo $target->age; ?></td>
					<td><?php echo $target->sex == '1' ? 'ชาย' : 'หญิง'; ?></td>
					<td></td>
					<td></td>
					<td><a href="#" class="btn"><i class="icon-check"></i></a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>