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
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="<?php echo base_url(); ?>services/register" class="btn btn-success"><i class="icon-share icon-white"></i> ส่งตรวจ </a>
				<a href="#" class="btn btn-primary"><i class="icon-refresh icon-white"></i> รีเฟรช</a>
				<a href="#" class="btn btn-warning"><i class="icon-zoom-out icon-white"></i> ค้นหา...</a>		
			</div>
		</div>
			<br />
			<table class="table table-striped" data-rel="tblservice-main">
        <thead>
          <tr>
          	<th>วันที่มา</th>
            <th>บัตรประชาชน</th>
            <th>ชื่อ - สกุล</th>
            <th>อายุ (ปี)</th>
            <th>แผนก</th>
          </tr>
        </thead>
        <tbody>
        	<?php foreach($services as $row): ?>
				<tr data-vn="<?php echo $row->vn; ?>">
					<td><?php echo to_thai_date( $row->date_serv ); ?></td>
          <td><?php echo $row->cid; ?></td>
          <td><?php echo $row->fname .' '. $row->lname; ?></td>
          <td><?php echo $row->age; ?></td>
          <td><?php echo $row->clinic_name; ?> </td>
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