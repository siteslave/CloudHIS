var FP = {};

FP.getList = function() {
	var _vn = $('input[data-name="vn"]').val();
	
	$.ajax({
		url: _base_url + 'services/getfp',
		dataType: 'json',
		type: 'POST',
		
		data: {
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			vn: _vn
		},
		
		success: function( data ) 
		{
			$('table[data-name="tblServiceFPHistoryList"] > tbody').empty();
			
			if( data.success )	 
			{
				$.each(data.rows, function(i, v)
				{
          i++;

					$('table[data-name="tblServiceFPHistoryList"] > tbody').append(
						'<tr>'
							+ '<td>' + i  + '</td>'
							+ '<td>' + toThaiDate(v.date_serv)  + '</td>'
							+ '<td>' + v.type_name + '</td>'
							+ '<td>' + v.pcu_name + '</td>'
							+ '<td>' +
                '<a href="#" class="btn" data-name="fpdetail-selected" ' +
                'data-pcucode="'+ v.pcucode +'" data-pcuname="'+ v.pcu_name +'" ' +
                'data-typeid="'+ v.fp_type_id +'" data-typename="'+ v.type_name+'" ' +
                'data-id="'+ v.id + '"><i class="icon-edit"></i></a> ' +
                '<a href="#" class="btn" data-name="fpremove-selected" data-id="'+ v.id + '"><i class="icon-trash"></i></a>' +
                '</td>'
						+ '</tr>'
					);
				});
			} 
			else 
			{
				alert('เกิดข้อผิดพลาด: ' + data.msg);
			}
		},
		
		error: function(xhr, status, errorThrown) 
		{
			alert('Server error: '  + xhr.status + ' ' + xhr.statusText );
		}
	});
};

FP.getFPTypeList = function() {
  $.ajax({
    url: _base_url + 'basic/getfptype_list',
    dataType: 'json',
    type: 'POST',

    data: {
      csrf_token: $.cookie('csrf_cookie_cloudhis')
    },

    success: function( data )
    {
      $('table[data-name="tblNewFPSearchTypeList"] > tbody').empty();

      if( data.success )
      {
        $.each(data.rows, function(i, v)
        {
          i++;

          $('table[data-name="tblNewFPSearchTypeList"] > tbody').append(
              '<tr>'
                  + '<td>' + i  + '</td>'
                  + '<td>' + v.name + '</td>'
                  + '<td><a href="#" data-name="fptype-selected" class="btn" data-id="'+ v.id + '" data-vname="'+ v.name +'"><i class="icon-check"></i></a>' +
                  '</td>'
                  + '</tr>'
          );
        });
      }
      else
      {
        alert('เกิดข้อผิดพลาด: ' + data.msg);
      }
    },

    error: function(xhr, status, errorThrown)
    {
      alert('Server error: '  + xhr.status + ' ' + xhr.statusText );
    }
  });
};

FP.doSearchHospital = function( query ) {
  $.ajax({
    url: _base_url + 'basic/search_hospital',
    dataType: 'json',
    type: 'POST',

    data: {
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      query: query
    },

    success: function( data )
    {
      $('table[data-name="tblNewFPSearchHospitalResult"] > tbody').empty();

      if( data.success )
      {
        $.each(data.rows, function(i, v)
        {
          $('table[data-name="tblNewFPSearchHospitalResult"] > tbody').append(
              '<tr>'
                  + '<td>' + v.code  + '</td>'
                  + '<td>' + v.name + '</td>'
                  + '<td><a href="#" data-name="fpplace-selected" class="btn" data-code="'+ v.code + '" data-vname="'+ v.name +'"><i class="icon-check"></i></a>' +
                  '</td>'
                  + '</tr>'
          );
        });
      }
      else
      {
        alert('เกิดข้อผิดพลาด: ' + data.msg);
      }
    },

    error: function(xhr, status, errorThrown)
    {
      alert('Server error: '  + xhr.status + ' ' + xhr.statusText );
    }
  });
};

FP.doSave = function( items )
{
	$.ajax({
		url: _base_url + 'services/dofp',
		dataType: 'json',
		type: 'POST',
		
		data: {
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			vn: items.vn,
			fp_type_id: items.type_id,
			fp_pcucode: items.pcucode
		},
		
		success: function(data)
		{
			if(data.success)
			{
        alert('บันทึกข้อมูลเสร็จเรียบร้อย');

        $('div[data-name="mdlNewFP"]').modal('hide');
        FP.clearForm();
				FP.getList();
			}
			else
			{
				alert('เกิดข้อผิดพลาดในการบันทึก : ' + data.msg);
			}
		},
		
		error: function(xhr, status, errorThrown){
			alert('Server error: ' + xhr.status + ' ' + xhr.statusText);
	  }	
	});// ajax
};

FP.doUpdate = function( items )
{
  $.ajax({
    url: _base_url + 'services/dofp_update',
    dataType: 'json',
    type: 'POST',

    data: {
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      fp_pcucode: items.pcucode,
      id: items.id
    },

    success: function(data)
    {
      if(data.success)
      {
        alert('ปรับปรุงข้อมูลเสร็จเรียบร้อยแล้ว');

        $('div[data-name="mdlNewFP"]').modal('hide');
        FP.clearForm();
        FP.getList();
      }
      else
      {
        alert('เกิดข้อผิดพลาดในการบันทึก : ' + data.msg);
      }
    },

    error: function(xhr, status, errorThrown){
      alert('Server error: ' + xhr.status + ' ' + xhr.statusText);
    }
  });// ajax
};

FP.doRemove = function( id )
{
  $.ajax({
    url: _base_url + 'services/dofp_remove',
    dataType: 'json',
    type: 'POST',

    data: {
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      id: id
    },

    success: function(data)
    {
      if(data.success)
      {
        alert('ลบรายการเสร็จเรียบร้อย');
        FP.getList();
      }
      else
      {
        alert('เกิดข้อผิดพลาดในการบันทึก : ' + data.msg);
      }
    },

    error: function(xhr, status, errorThrown){
      alert('Server error: ' + xhr.status + ' ' + xhr.statusText);
    }
  });// ajax
};

FP.modal = {
  showFp: function() {
    $('div[data-name="modal-fp"]').modal('show').css({
      width: 680,
      'margin-left': function () {
        return -($(this).width() / 2);
      }
    });
  },
  showNewFp: function() {
    $('div[data-name="mdlNewFP"]').modal('show').css({
      width: 640,
      'margin-left': function () {
        return -($(this).width() / 2);
      }
    });
  },
  showNewFpTypeSearch: function() {
    $('div[data-name="mdlNewFPSearchType"]').modal('show').css({
      width: 480,
      'margin-left': function () {
        return -($(this).width() / 2);
      }
    });
  },
  showNewFpHospitalSearch: function() {
    $('div[data-name="mdlNewFPSearchHospital"]').modal('show').css({
      width: 480,
      'margin-left': function () {
        return -($(this).width() / 2);
      }
    });
  }
};

FP.clearForm = function()
{
  $('input[data-name="txtFPTypeId"]').val();
  $('input[data-name="txtFPTypeName"]').val('');
  $('input[data-name="txtFPPlaceId"]').val('');
  $('input[data-name="txtFPPlaceName"]').val('');
  $('input[data-name="txtFPVisitID"]').val('');
  $('button[data-name="btnSearchFPType"]').css('display', 'inline');

};
$(function() {
  $('button[data-name="btnNewFP"]').click(function(){
    FP.clearForm();
    FP.modal.showNewFp();
  });

  $('a[data-name="fpdetail-selected"]').live('click', function(){
    var id = $(this).attr('data-id'),
        type_id = $(this).attr('data-typeid'),
        type_name = $(this).attr('data-typename'),
        pcu_code = $(this).attr('data-pcucode'),
        pcu_name = $(this).attr('data-pcuname');

    $('input[data-name="txtFPVisitID"]').val( id );
    $('input[data-name="txtFPTypeId"]').val( type_id );
    $('input[data-name="txtFPTypeName"]').val( type_name );
    $('input[data-name="txtFPPlaceId"]').val( pcu_code );
    $('input[data-name="txtFPPlaceName"]').val( pcu_name );

    $('button[data-name="btnSearchFPType"]').css('display', 'none');
    FP.modal.showNewFp();
  });


  $('a[data-name="fptype-selected"]').live('click', function(){
    var id = $(this).attr('data-id'),
        name = $(this).attr('data-vname');

    $('input[data-name="txtFPTypeId"]').val(id);
    $('input[data-name="txtFPTypeName"]').val(name);

    $('div[data-name="mdlNewFPSearchType"]').modal('hide');
  });

  $('a[data-name="fpplace-selected"]').live('click', function(){
    var code = $(this).attr('data-code'),
        name = $(this).attr('data-vname');

    $('input[data-name="txtFPPlaceId"]').val(code);
    $('input[data-name="txtFPPlaceName"]').val(name);

    $('div[data-name="mdlNewFPSearchHospital"]').modal('hide');
  });


  $('button[data-name="btnSearchFPPlace"]').click(function(){
    FP.modal.showNewFpHospitalSearch();
  });

  $('button[data-name="btnNewFPHospitalDoSearch"]').click(function(){
    var query = $('input[data-name="txtNewFPHospitalQuery"]').val();
    if(!query){
      alert('กรุณาพิมพ์ชื่อ หรือ รหัส สถานพยาบาลเพื่อค้นหา');
    }else{
      FP.doSearchHospital( query );
    }
  });

  $('button[data-name="btnSearchFPType"]').click(function(){
    FP.getFPTypeList();
    FP.modal.showNewFpTypeSearch();
  });

	$('a[data-name="service-fp"]').click(function()
	{
		FP.getList();
    FP.modal.showFp();
	});

  $('a[data-name="fpremove-selected"]').live('click', function(){
    if(confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?'))
    {
      var id = $(this).attr('data-id');
      FP.doRemove( id );
    }
  });

  $('button[data-name="btnDoSaveFP"]').click(function(){
    var items = {};
    items.vn = $('input[data-name="vn"]').val();
    items.type_id = $('input[data-name="txtFPTypeId"]').val();
    items.pcucode = $('input[data-name="txtFPPlaceId"]').val();

    if(!items.vn){
      alert('ไม่พบรหัสการรับบริการ (VN)');
    }else if(!items.type_id){
      alert('กรุณากำหนดประเภทการคุมกำเนิด');
    }else if(!items.pcucode){
      alert('กรุณาเลือกสถานที่รับบริการ');
    }else{
      // do save
      var id = $('input[data-name="txtFPVisitID"]').val();
      if(id){
        //update
        items.id = id;
        FP.doUpdate( items );
      }else{
        FP.doSave( items );
      }
    }
  });

});