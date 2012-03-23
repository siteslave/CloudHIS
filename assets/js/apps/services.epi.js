EPI = {};

EPI.showAlert = function (title, msg, c)
{
	$('div[data-name="alert-epi"]').removeClass().addClass(c);
	$('div[data-name="alert-epi"] h4').html(title);
	$('div[data-name="alert-epi"] p').html(msg);
};

EPI.doCheckInsert = function()
{
	var _vn 			= $('input[data-name="vn"]').val(),
	_vcctype 			= $('select[data-name="epi-vcctype"]').val(),
	_vccplace 		= $('select[data-name="epi-vccplace"]').val();
	
	if( ! _vn ) 
	{
		EPI.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ <code> รหัสการให้บริการ (VN) </code>',  'alert alert-error');
	} 
	else if( ! _vcctype ) 
	{
		EPI.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>วัคซีนที่ได้รับ</code>',  'alert alert-error');
	} 
	else if( ! _vccplace ) 
	{
		EPI.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>สถานที่รับวัคซีน</code>',  'alert alert-error');
	} 
	else 
	{ 
		EPI.doSave( _vn, _vcctype, _vccplace );
	}	
};

EPI.doSave = function( _vn, _vcctype, _vccplace )
{
	$.ajax({
		url: _base_url + 'services/doepi',
		dataType: 'json',
		type: 'POST',
		
		data: 
		{
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			vn: _vn,
			vcctype: _vcctype,
			vccplace: _vccplace
		},
		
		success: function(data)
		{
			if(data.success)
			{
				EPI.showAlert(' บันทึกข้อมูล',  ' บันทึกข้อมูลเสร็จเรียบร้อยแล้ว', 'alert alert-success');
				// reset form
				$('button[data-name="btnreset"]').click();
				// refresh fp list
				EPI.getList();
			}
			else
			{
				EPI.showAlert('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล:  ' + data.status,  'alert alert-error');
			}
		  
		},
		
		error: function(xhr, status, errorThrown){
			EPI.showAlert('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
	  }	
	});
};

EPI.getList = function() {
	var _cid = $('input[data-name="cid"]').val();
	
	$.ajax({
		url: _base_url + 'services/getepi',
		dataType: 'json',
		type: 'POST',
		data: 
		{
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			cid: _cid
		},
		
		success: function( data ) 
		{
			$('table[data-name="tblEPIList"] > tbody').empty();
			
			if( data.success )	 
			{
				$.each(data.rows, function(i, v)
				{
					$('table[data-name="tblEPIList"] > tbody').append(
						'<tr>'
							+ '<td>' + toThaiDate(v.date_serv)  + '</td>'
							+ '<td>' + v.eng_name + '</td>'
							+ '<td>' + v.place_name + '</td>'
							+ '<td>'
							+ '<a href="#" class="btn" data-name="remove-epi" data-epi="'+ v.vcctype +'"><i class="icon-trash"></i></a>'
							+ '</td>'
						+ '</tr>'
					);
				});
			} 
			else 
			{
				$('table[data-name="tblEPIList"] > tbody').append(
						'<tr>' 
						+ '<td colspan="5"> ไม่สามารถแสดงรายการได้ </td>'
						+ '</tr>'
					);
			}
		},
		
		error: function(xhr, status, errorThrown) 
		{
			alert('ไม่สามารถแสดงข้อมูลการนัดได้: [ '  + xhr.status + ' ' + xhr.statusText +' ]')
		}
	});
};

EPI.doRemove = function( _vn, _vcctype) {
	$.ajax({
		url: _base_url + 'services/removeepi',
		dataType: 'json',
		type: 'POST',
		
		data: 
		{
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			vn: _vn,
			vcctype: _vcctype
		},
		
		success: function(data)
		{
			if(data.success)
			{
				EPI.showAlert(' ผลการลบ',  ' ลบรายการที่ไม่ต้องการเรียบร้อยแล้ว ', 'alert alert-success');
				EPI.getList();
			}else{
				EPI.showAlert('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล:  ' + data.status,  'alert alert-error');
			}
		},
		
		error: function(xhr, status, errorThrown){
			EPI.showAlert('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
	  }	
	});
};
	
$(function(){
		// check fp detail
	$( 'button[data-name="btn-save-epi"]' ).click( function() {
		EPI.doCheckInsert();
	});
	
	$('a[data-name="service-epi"]').click(function(){
		EPI.getList();
	});
	//remove epi
	$('a[data-name="remove-epi"]').live('click', function() {
		var _vcctype = $(this).attr("data-epi"),
			_vn = $('input[data-name="vn"]').val();
					
		if ( confirm( 'คุณต้องการลบรายการนี้ใช่หรือไม่?' )  ) {
			EPI.doRemove( _vn, _vcctype);
		}
	});
});