<ul class="nav nav-pills">
  <li class="active"><a href="#house" data-toggle="tab"><i class="icon-home icon-white"></i> หมู่บ้านในเขตรับผิดชอบ</a></li>
  <li><a href="#people" data-toggle="tab"><i class="icon-user icon-white"></i> ประชากรในเขตรับผิดชอบ</a></li>
</ul>
<div class="tab-content">
  <div class="tab-pane active" id="house">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>รหัสหมู่บ้าน</th>
          <th>หมู่ที่</th>
          <th>ชื่อหมู่บ้าน</th>
          <th>หลังคาเรือน</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $i = 1;
        foreach( $villages as $v ):
      ?>
        <tr>
          <td><?php echo $i; ?></td>
          <td><?php echo $v->village_code; ?></td>
          <td style="text-align: center;"><?php echo substr($v->village_code, -2); ?></td>
          <td><?php echo $v->village_name; ?></td>
          <td style="text-align: right;"><?php echo number_format( $v->total_house ); ?></td>
        </tr>
        <?php
          $i++;
          endforeach;
        ?>
      </tbody>
    </table>
  </div>
  <div class="tab-pane" id="people">
    <div  class="btn-toolbar">
      <form>
        <div class="row">
          <div class="span3">
            <label for="">เลือกหมู่บ้าน</label>
            <select data-name="house-sel-village" class="span3">
            <option value="">---</option>
            <?php
            foreach( $villages_dropdown as $k => $v )
            {
              echo '<option value="' . $k . '">' . $v . '</option>';
            }
            ?>
            </select>
          </div>
          <div class="span4">
            <label for="">เลขที่</label>
            <select data-name="house-sel-house" class="span2"></select>

          </div>
        </div>

      </form>

      <table class="table table-striped" data-name="house-tbl-people-list">
        <thead>
          <tr>
            <th>เลขบัตรประชาชน</th>
            <th>ชื่อ - สกุล</th>
            <th>เพศ</th>
            <th>วันเกิด</th>
            <th>อายุ (ปี)</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
      <div class="btn-toolbar" >
        <a style="display: none;" data-name="house-btn-add-person-to-house" href="#" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i> เพิ่มคนในบ้าน</a>
      </div>
    </div>
  </div>
</div>

<!-- modal -->
<!-- house list -->
<div class="modal hide fade" data-name="house-modal-house-list">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>รายการบ้านในหมู่บ้าน</h3>
	</div>
	<div class="modal-body">
    <table class="table table-striped" data-name="house-tbl-address-list">
      <thead>
        <tr>
          <th>#</th>
          <th>บ้านเลขที่</th>
          <th>ชาย</th>
          <th>หญิง</th>
          <th>รวม</th>
          <th></th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่างๆ</a>
	</div>
</div>
<!-- / house list -->
<!-- new person -->
<div class="modal hide fade" data-name="house-modal-new-person">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>เพิ่มคนในบ้าน</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-info" data-name="alert-refer-out-register">
			<h4>ข้อแนะนำ</h4>
			<p>
				กรุณาบันทึกข้อมูลให้ถูกต้อง และ สมบูรณ์
			</p>
		</div>
    <div class="tabbable">
      <ul class="nav nav-pills">
        <li class="active">
          <a href="#house-person-new-basic1" data-toggle="tab">ข้อมูลทั่วไป</a>
        </li>
        <li>
          <a href="#house-person-new-basic2" data-toggle="tab">ที่อยู่ตามทะเบียนบ้าน</a>
        </li>
        <li>
          <a href="#house-person-new-basic3" data-toggle="tab">ข้อมูลอื่นๆ</a>
        </li>
      </ul>
      <form>
      <div class="tab-content">
        <div class="tab-pane active" id="house-person-new-basic1">
          <div class="row">
            <div class="span4">
              <label for="">เลขบัตรประชาชน</label>
              <input type="text" data-name="house-person-new-cid" required="required" span="3" />
            </div>
          </div>
          <div class="row">
            <div class="span2">
              <label for="">คำนำ</label>
              <select class="span2" data-name="house-person-new-title">
                <?php
                  foreach( $titles as $k => $v )
                  {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                  }
                ?>
              </select>
            </div>
            <div class="span2">
              <label for="">ชื่อ</label>
              <input type="text" data-name="house-person-new-fname" class="span2" />
            </div>
            <div class="span2">
              <label for="">สกุล</label>
              <input type="text" data-name="house-person-new-lname" class="span2" />
            </div>
          </div>
          <div class="row">
            <div class="span2">
              <label for="">เพศ</label>
              <select data-name="house-person-new-sex" class="span2" >
                <option value="1">ชาย</option>
                <option value="2">หญิง</option>
              </select>
            </div>
            <div class="span2">
              <label for="">วันเกิด</label>
              <input type="text" data-name="house-person-new-birthdate" class="span2" />
            </div>
            <div class="span2">
              <label for="">หมู่เลือด</label>
              <select data-name="house-person-new-blood-group" class="span2" >
                <?php
                  foreach( $blood_groups as $k => $v )
                  {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="span2">
              <label for="">สถานะ</label>
              <select data-name="house-person-new-marry" class="span2" >
                <?php
                  foreach( $married_status as $k => $v )
                  {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                  }
                ?>
              </select>
            </div>
            <div class="span4">
              <label for="">อาชีพ</label>
              <select data-name="house-person-new-occupation" class="span4" >
                <?php
                  foreach( $occupations as $k => $v )
                  {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="span3">
              <label for="">เชื้อชาติ</label>
              <select data-name="house-person-new-race" class="span3" >
                <?php
                  foreach( $races as $k => $v )
                  {
                    if ( $k == 98 ) echo '<option value="' . $k . '" selected="selected">' . $v . '</option>';
                    else echo '<option value="' . $k . '">' . $v . '</option>';
                  }
                ?>
              </select>
            </div>
            <div class="span3">
              <label for="">สัญชาติ</label>
              <select data-name="house-person-new-nation" class="span3" >
                <?php
                  foreach( $nations as $k => $v )
                  {
                    if ( $k == 98 ) echo '<option value="' . $k . '" selected="selected">' . $v . '</option>';
                    else echo '<option value="' . $k . '">' . $v . '</option>';
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="span3">
              <label for="">การศึกษา</label>
              <select data-name="house-person-new-education" class="span3" >
                <?php
                  foreach( $educations as $k => $v )
                  {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                  }
                ?>
              </select>
            </div>
            <div class="span3">
              <label for="">ศาสนา</label>
              <select data-name="house-person-new-religion" class="span3" >
                <?php
                  foreach( $religions as $k => $v )
                  {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                  }
                ?>
              </select>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="house-person-new-basic2">
          <div class="row">
            <div class="span3">
              <label for="">จังหวัด</label>
              <select data-name="house-person-new-chw" class="span3" >
                <?php
                  foreach( $changwats as $k => $v )
                  {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                  }
                ?>
              </select>
              <label for="">อำเภอ</label>
              <select data-name="house-person-new-amp" class="span3" ></select>
              <label for="">ตำบล</label>
              <select data-name="house-person-new-tmb" class="span3" ></select>
            </div>
            <div class="span3">
              <label for="">หมู่บ้าน</label>
              <select data-name="house-person-new-moo" class="span3"></select>
              <label for="">บ้านเลขที่</label>
              <input type="text" class="span2" data-name="house-person-new-address">
            </div>
          </div>
        </div>
        <div class="tab-pane" id="house-person-new-basic3">
          <div class="row">
            <div class="span2">
              <label for="">CID บิดา</label>
              <input type="text" class="span2" data-name="house-person-new-father-cid">
            </div>
            <div class="span2">
              <label for="">CID มารดา</label>
              <input type="text" class="span2" data-name="house-person-new-mother-cid">
            </div>
            <div class="span2">
              <label for="">CID คู่สมรส</label>
              <input type="text" class="span2" data-name="house-person-new-couple-cid">
            </div>
          </div>
          <div class="row">
            <div class="span3">
              <label for="">สถานะในครอบครัว</label>
              <select data-name="house-person-new-fstatus" class="span3" >
                <option value="1">เจ้าบ้าน</option>
                <option value="2">ผู้อาศัย</option>
              </select>
            </div>
            <div class="span3">
              <label for="">ความเป็นต่างด้าว</label>
              <select data-name="house-person-new-labor" class="span3" >
                <?php
                  foreach( $labor_types as $k => $v )
                  {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="span2">
              <label for="">วันที่ย้ายเข้า</label>
              <input type="text" class="span2" data-name="house-person-new-movein-date" />
            </div>
            <div class="span2">
              <label for="">วันที่จำหน่าย</label>
              <input type="text" class="span2" data-name="house-person-new-discharge-date" />
            </div>
            <div class="span3">
              <label for="">สถานะการจำหน่าย</label>
              <select data-name="house-person-new-discharge-status" class="span2">
                <?php
                  foreach( $discharge_status as $k => $v )
                  {
                    if ( $k == 4 ) echo '<option value="' . $k . '" selected="selected">' . $v . '</option>';
                    else echo '<option value="' . $k . '">' . $v . '</option>';
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="span4">
              <label for="">สถานะบุคคล</label>
              <select data-name="house-person-new-typearea" class="span4" >
                <?php
                  foreach( $type_areas as $k => $v )
                  {
                    echo '<option value="' . $k . '">' . $v . '</option>';
                  }
                ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <input type="reset" style="display:none" data-name="house-btn-new-reset">
    </form>
    </div>
	</div>
	<div class="modal-footer">
    <a href="#" class="btn btn-primary" data-name="house-btn-save-new-person"><i class="icon-plus-sign icon-white"></i>  บันทึกรายการ</a>
		<a href="#" class="btn" data-dismiss="modal"><i class="icon-off"></i>  ปิดหน้าต่างๆ</a>
	</div>
</div>
<!-- / new person -->
<!-- /modal -->

<script src="<?php echo base_url(); ?>assets/js/apps/house.js"></script>