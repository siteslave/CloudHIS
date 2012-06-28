<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
    <blockquote>
    เก็บรายละเอียดของข้อมูลโรคที่ต้องเฝ้าระวังจากบุคคลที่มารับบริการ
    </blockquote>
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tabServiceSurveilList" data-toggle="tab">
          <i class="icon-time"></i> ประวัติการป่วย</a></li>
				<li><a href="#tabNewSurveil" data-toggle="tab">
          <i class="icon-plus-sign"></i> เพิ่มข้อมูลใหม่</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tabServiceSurveilList">
					<table class="table table-striped" data-name="tblServiceSurveilList">
						<thead>
							<tr>
								<th>#</th>
								<th>วันที่รับบริการ</th>
								<th>รหัส 506</th>
								<th>วันที่เริ่มป่วย</th>
								<th>สภาพผู้ป่วย</th>
								<th></th>
							</tr>
							<tbody>
							</tbody>
						</thead>
					</table>
				</div>
				<div class="tab-pane" id="tabNewSurveil">
          <blockquote>บันทึกข้อมูลเกี่ยวกับโรค</blockquote>
					<div class="tabbable">
						<ul class="nav nav-tabs">
							<li class="active"> <a href="#surveil_ill" data-toggle="tab"><i class="icon-th"></i> ข้อมูลการเจ็บป่วย</a> </li>
							<li><a href="#surveil_addr" data-toggle="tab"><i class="icon-th-list"></i> ที่อยู่ขณะเจ็บป่วย</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="surveil_ill">
                <blockquote>ข้อมูลการเจ็บป่วยของคนไข้</blockquote>
                <form action="#" class="form-inline">
                  <table class="table table-striped">
                    <tr>
                      <td>รหัสการวินิจฉัย</td>
                      <td colspan="5">
                        <input type="text" class="input-xlarge uneditable-input" disabled data-name="surveil_diag_name" placeholder="คลิกปุ่มค้นหา...">
                        <button type="button" data-name="btnSearchSurveilDiag" class="btn btn-info">
                          <i class="icon-search icon-white"></i>
                        </button>
                        <input type="hidden" data-name="surveil_diag_code">
                      </td>
                    </tr>
                    <tr>
                      <td>รหัส 506</td>
                      <td colspan="3">
                        <input type="text" class="input-xlarge uneditable-input" disabled data-name="surveil_diag_name" placeholder="คลิกปุ่มค้นหา...">
                        <button type="button" data-name="btnSearchSurveil506Code" class="btn btn-info">
                          <i class="icon-search icon-white"></i>
                        </button>
                        <input type="hidden" data-name="surveil_diag_code">
                      </td>
                    </tr>
                    <tr>
                      <td>สภาพผู้ป่วย</td>
                      <td colspan="3">
                        <input type="text" class="input-xlarge uneditable-input" disabled data-name="surveil_diag_name" placeholder="คลิกปุ่มค้นหา...">
                        <button type="button" data-name="btnSearchSurveil506Code" class="btn btn-info">
                          <i class="icon-search icon-white"></i>
                        </button>
                        <input type="hidden" data-name="surveil_diag_code">
                      </td>
                    </tr>
                    <tr>
                      <td>วันที่เริ่มป่วย</td>
                      <td><input type="text" data-type="date" class="input-small" data-name="surveil-date"></td>
                      <td>วันที่เสียชีวิต</td>
                      <td>
                        <input type="text" class="input-small" data-name="surveil_diag_name">
                      </td>
                    </tr>
                    <tr>
                      <td>ชนิดของเชื้อโรค</td>
                      <td colspan="3">
                        <input type="text" class="input-xlarge uneditable-input" disabled data-name="surveil_diag_name" placeholder="คลิกปุ่มค้นหา...">
                        <button type="button" data-name="btnSearchSurveil506Code" class="btn btn-info">
                          <i class="icon-search icon-white"></i>
                        </button>
                        <input type="hidden" data-name="surveil_diag_code">
                      </td>
                    </tr>
                    <tr>
                      <td>สาเหตุการป่วย</td>
                      <td colspan="3">
                        <input type="text" class="input-xlarge uneditable-input" disabled data-name="surveil_diag_name" placeholder="คลิกปุ่มค้นหา...">
                        <button type="button" data-name="btnSearchSurveil506Code" class="btn btn-info">
                          <i class="icon-search icon-white"></i>
                        </button>
                        <input type="hidden" data-name="surveil_diag_code">
                      </td>
                    </tr>
                  </table>
                </form>
							</div>
							<div class="tab-pane" id="surveil_addr">
								<div class="row-fluid">
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
		</div>
    </body>
</html>
