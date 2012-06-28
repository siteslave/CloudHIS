var EPI = {};

EPI.doSave = function( items )
{
	$.ajax({
		url: _base_url + '/services/doepi',
		dataType: 'json',
		type: 'POST',
		
		data: 
		{
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			vn: items.vn,
			vcctype: items.vcctype,
			vccplace: items.vccplace
		},
		
		success: function(data)
		{
			if(data.success)
			{
				alert('บันทึกข้อมูลเรียบร้อยแล้ว');
        $('div[data-name="mdlNewEPI"]').modal('hide');
				EPI.getList();
			}
			else
			{
				alert('เกิดข้อผิดพลาดในการบันทึก: ' + data.msg);
			}
		  
		},
		
		error: function(xhr, status, errorThrown){
      alert('Server error: [ '  + xhr.status + ' ' + xhr.statusText +' ]');
	  }	
	});
};

EPI.doUpdate = function( items )
{
  $.ajax({
    url: _base_url + '/services/doepi_update',
    dataType: 'json',
    type: 'POST',

    data:
    {
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      id: items.id,
      vccplace: items.vccplace
    },

    success: function(data)
    {
      if(data.success)
      {
        alert('ปรับปรุงข้อมูลเรียบร้อยแล้ว');
        $('div[data-name="mdlNewEPI"]').modal('hide');
        EPI.getList();
      }
      else
      {
        alert('เกิดข้อผิดพลาดในการบันทึก: ' + data.msg);
      }

    },

    error: function(xhr, status, errorThrown){
      alert('Server error: [ '  + xhr.status + ' ' + xhr.statusText +' ]');
    }
  });
};

EPI.getList = function() {
	var _cid = $('input[data-name="cid"]').val();
	
	$.ajax({
		url: _base_url + '/services/getepi',
		dataType: 'json',
		type: 'POST',
		data: 
		{
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			cid: _cid
		},
		
		success: function( data ) 
		{
			$('table[data-name="tblServiceEPIHistoryList"] > tbody').empty();
			
			if( data.success )	 
			{
				$.each(data.rows, function(i, v)
				{
          i++;
					$('table[data-name="tblServiceEPIHistoryList"] > tbody').append(
						'<tr>'
							+ '<td>' + i  + '</td>'
							+ '<td>' + toThaiDate(v.date_serv)  + '</td>'
							+ '<td>' + v.eng_name + '</td>'
							+ '<td>' + v.description + '</td>'
							+ '<td>' + v.place_name + '</td>'
							+ '<td>'
							+ '<a href="#" title="แก้ไข" class="btn" data-name="detail-epi" data-id="' + v.id +'" ' +
                'data-typeid="'+ v.vcctype +'" data-typename="'+ v.eng_name + ' : ' + v.description +'" ' +
                'data-placename="'+ v.place_name +'" data-placeid="'+ v.vccplace +'">' +
                '<i class="icon-edit"></i></a>'
							+ ' <a href="#" title="ลบทิ้ง" class="btn" data-name="remove-epi" data-id="'+ v.id +'"><i class="icon-trash"></i></a>'
							+ '</td>'
						+ '</tr>'
					);
				});
			} 
			else 
			{
				$('table[data-name="tblServiceEPIHistoryList"] > tbody').append(
						'<tr>' 
						+ '<td colspan="6"> ไม่พบข้อมูล </td>'
						+ '</tr>'
					);
			}
		},
		
		error: function(xhr, status, errorThrown) 
		{
			alert('Server error: [ '  + xhr.status + ' ' + xhr.statusText +' ]')
		}
	});
};
EPI.getVCCTypeList = function() {
  $.ajax({
    url: _base_url + '/basic/getepi',
    dataType: 'json',
    type: 'POST',
    data:
    {
      csrf_token: $.cookie('csrf_cookie_cloudhis')
    },

    success: function( data )
    {
      $('table[data-name="tblNewEPISearchTypeList"] > tbody').empty();

      if( data.success )
      {
        $.each(data.rows, function(i, v)
        {
          i++;
          $('table[data-name="tblNewEPISearchTypeList"] > tbody').append(
              '<tr>'
                  + '<td>' + i  + '</td>'
                  + '<td>' + v.eng_name  + '</td>'
                  + '<td>' + v.description + '</td>'
                  + '<td>'
                  + '<a href="#" class="btn" data-typedesc="'+ v.description +'" data-typename="'+ v.eng_name +'" data-name="selected-vcctype" data-id="'+ v.id +'"><i class="icon-check"></i></a>'
                  + '</td>'
                  + '</tr>'
          );
        });
      }
      else
      {
        $('table[data-name="tblNewEPISearchTypeList"] > tbody').append(
            '<tr>'
                + '<td colspan="4"> ไม่พบข้อมูล </td>'
                + '</tr>'
        );
      }
    },

    error: function(xhr, status, errorThrown)
    {
      alert('Server error: [ '  + xhr.status + ' ' + xhr.statusText +' ]');
    }
  });
};
EPI.doSearchHospital = function( query ) {
  $.ajax({
    url: _base_url + '/basic/search_hospital',
    dataType: 'json',
    type: 'POST',

    data: {
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      query: query
    },

    success: function( data )
    {
      $('table[data-name="tblNewEPISearchHospitalResult"] > tbody').empty();

      if( data.success )
      {
        $.each(data.rows, function(i, v)
        {
          $('table[data-name="tblNewEPISearchHospitalResult"] > tbody').append(
              '<tr>'
                  + '<td>' + v.code  + '</td>'
                  + '<td>' + v.name + '</td>'
                  + '<td><a href="#" data-name="epiplace-selected" class="btn" data-code="'+ v.code + '" data-vname="'+ v.name +'"><i class="icon-check"></i></a>' +
                  '</td>'
                  + '</tr>'
          );
        });
      }
      else
      {
        $('table[data-name="tblNewEPISearchHospitalResult"] > tbody').append(
          '<tr>'
            + '<td colspan="3"> ไม่พบข้อมูล </td>'
            + '</tr>'
        );
      }
    },

    error: function(xhr, status, errorThrown)
    {
      alert('Server error: '  + xhr.status + ' ' + xhr.statusText );
    }
  });
};
EPI.doRemove = function( id ) {
	$.ajax({
		url: _base_url + '/services/removeepi',
		dataType: 'json',
		type: 'POST',
		
		data: 
		{
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			id: id
		},
		
		success: function(data)
		{
			if(data.success)
			{
				alert('ลบรายการเสร็จเรียบร้อย');
				EPI.getList();
			}else{
				alert('เกิดข้อผิดพลาดในการลบ : ' + data.msg);
			}
		},
		
		error: function(xhr, status, errorThrown){
      alert('Server error: [ '  + xhr.status + ' ' + xhr.statusText +' ]');
	  }	
	});
};

EPI.modal = {
  showEpi: function() {
    $('div[data-name="mdlServiceEPI"]').modal('show').css({
      width: 740,
      'margin-left': function () {
        return -($(this).width() / 2);
      }
    });
  },
  showNewEpi: function() {
    $('div[data-name="mdlNewEPI"]').modal('show').css({
      width: 640,
      'margin-left': function () {
        return -($(this).width() / 2);
      }
    });
  },
  showEpiSearchType: function() {
    $('div[data-name="mdlNewEPISearchType"]').modal('show').css({
      width: 480,
      'margin-left': function () {
        return -($(this).width() / 2);
      }
    });
  },
  showEpiSearchPlace: function() {
    $('div[data-name="mdlNewEPISearchHospital"]').modal('show').css({
      width: 480,
      'margin-left': function () {
        return -($(this).width() / 2);
      }
    });
  }
};

EPI.clearForm = function()
{
  $('input[data-name="txtVCCPlaceId"]').val('');
  $('input[data-name="txtVCCPlaceName"]').val('');
  $('input[data-name="txtEPIVisitID"]').val('');

  $('input[data-name="txtVCCTypeId"]').val('');
  $('input[data-name="txtVCCTypeName"]').val('');

  $('button[data-name="btnSearchVCCType"]').css('display', 'inline');
};
$(function(){

  // EPI
  $('a[data-name="service-epi"]').click(function(){
    doLoading();
    EPI.getList();
    EPI.modal.showEpi();
    doUnLoading();
  });

  // new epi
  $('button[data-name="btnNewEPI"]').click(function(){
    EPI.clearForm();
    EPI.modal.showNewEpi();
  });
  // search vcctype
  $('button[data-name="btnSearchVCCType"]').click(function(){
    EPI.getVCCTypeList();
    EPI.modal.showEpiSearchType();
  });
  // selected vcctype
  $('a[data-name="selected-vcctype"]').live('click', function(){
    var type_id = $(this).attr('data-id'),
        type_name = $(this).attr('data-typename'),
        description = $(this).attr('data-typedesc');

    //set result
    $('input[data-name="txtVCCTypeId"]').val(type_id);
    $('input[data-name="txtVCCTypeName"]').val(type_name + ' : ' + description);

    $('div[data-name="mdlNewEPISearchType"]').modal('hide');
  });

  //search hospital
  $('button[data-name="btnSearchVCCPlace"]').click(function(){
    EPI.modal.showEpiSearchPlace();
  });

  //do search hospital
  $('button[data-name="btnNewEPIHospitalDoSearch"]').click(function(){
    var query = $('input[data-name="txtNewEPIHospitalQuery"]').val();
    if(!query){
      alert('กรุณากรอกข้อมูลเพื่อค้นหา');
    }else{
      EPI.doSearchHospital( query );
    }
  });

  // selected place
  $('a[data-name="epiplace-selected"]').live('click', function(){
    var code = $(this).attr('data-code'),
        name = $(this).attr('data-vname');

    $('input[data-name="txtVCCPlaceId"]').val(code);
    $('input[data-name="txtVCCPlaceName"]').val(name);
    $('div[data-name="mdlNewEPISearchHospital"]').modal('hide');
  });
  //save vaccine
  $('button[data-name="btnDoSaveVCC"]').click(function(){
    var items = {};
    items.vcctype = $('input[data-name="txtVCCTypeId"]').val();
    items.vccplace = $('input[data-name="txtVCCPlaceId"]').val();
    items.vn = $('input[data-name="vn"]').val();

    if(!items.vcctype){
      alert('กรุณากำหนดกิจกรรมวัคซีน');
    }else if(!items.vccplace){
      alert('กรุณากำหนดสถานที่ให้บริการ');
    }else{
      var id = $('input[data-name="txtEPIVisitID"]').val();

      if(id){
        items.id = id;
        // do update
        EPI.doUpdate( items );
      }else{
        //do add
        EPI.doSave( items );
      }
    }

  });

  // remove vaccine
  $('a[data-name="remove-epi"]').live('click', function(){
    var id = $(this).attr('data-id');
    if(confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')){
      EPI.doRemove( id );
    }
  });
  // detail vaccine
  $('a[data-name="detail-epi"]').live('click', function(){

    var id = $(this).attr('data-id'),
        type_id = $(this).attr('data-typeid'),
        type_name = $(this).attr('data-typename'),
        place_id = $(this).attr('data-placeid'),
        place_id = $(this).attr('data-placename');

    $('input[data-name="txtVCCPlaceId"]').val(place_id);
    $('input[data-name="txtVCCPlaceName"]').val(place_id);
    $('input[data-name="txtEPIVisitID"]').val(id);

    $('input[data-name="txtVCCTypeId"]').val(type_id);
    $('input[data-name="txtVCCTypeName"]').val(type_name);

    $('button[data-name="btnSearchVCCType"]').css('display', 'none');
    EPI.modal.showNewEpi();

  });
});