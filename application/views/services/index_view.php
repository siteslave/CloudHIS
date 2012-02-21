<div class="tabbable">
	<ul class="nav nav-pills">
		<li class="active">
			<a href="#servicelist" data-toggle="tab"><i class="icon-th-large icon-white"></i>  การให้บริการ</a>
		</li>
		<li>
			<a href="#servicehistory" data-toggle="tab"><i class="icon-th-list icon-white"></i>  ประวัติการให้บริการ</a>
		</li>
	</ul>

	<!-- tabs data -->

	<div class="tab-content">
		<div class="tab-pane active" id="servicelist">
			<div class="row">
				<div class="span4">
					<div class="btn-group" data-toggle="buttons-radio">
					  <button class="btn btn-success"><i class="icon-th icon-white"></i> ทั้งหมด</button>
					  <button class="btn btn-info"><i class="icon-check icon-white"></i> ตรวจแล้ว</button>
					  <button class="btn btn-primary"><i class="icon-th-list icon-white"></i> ยังไม่ตรวจ</button>
					</div>
				</div>
				<div class="span3 offset4">
					<div class="btn-group" style="float: right;">
							<a class="btn btn-primary" href="#"><i class="icon-th-large icon-white"></i> เครื่องมือ</a>
							<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#">ค้นหา...</a></li>
								<li class="divider"></li>
								<li><a href="#">รีเฟรชข้อมูลใหม่</a></li>
							</ul>
					</div>
					<div style="float: right; padding: 0 5px;">
						<a href="<?php echo base_url(); ?>services/register" class="btn btn-success">
						<i class="icon-share icon-white"></i>
						ส่งตรวจ
						</a>
					</div>
						
				</div>
			</div>
			<br />
			<table class="table table-striped" data-rel="tblservice-main">
        <thead>
          <tr>
          	<th>วันที่มา</th>
            <th>เลขบัตรประชาชน</th>
            <th>ชื่อ - สกุล</th>
            <th>วันเกิด</th>
            <th>สิทธิการรักษา</th>
            <th>แผนก</th>
            <th>อาการแรกรับ</th>
            <th>เจ้าหน้าที่</th>
          </tr>
        </thead>
        <tbody>
        	<?php foreach($services as $row): ?>
				<tr data-vn="<?php echo $row->vn; ?>">
					<td><?php echo to_thai_date( $row->date_serv ); ?></td>
          <td><?php echo $row->cid; ?></td>
          <td><?php echo $row->fname .' '. $row->lname; ?></td>
          <td><?php echo to_thai_date( $row->birthdate ); ?></td>
          <td><?php echo $row->ins_name; ?> </td>
          <td><?php echo $row->clinic_name; ?> </td>
          <td><?php echo $row->cc; ?></td>
          <td><?php echo $row->doctor_name; ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
  		</div>
		<div class="tab-pane" id="servicehistory">
			lkfdldsfjl
		</div>
	</div>

</div>

<script type="text/javascript" src="<?php echo base_url() ?>assets/js/apps/services.index.js"></script>