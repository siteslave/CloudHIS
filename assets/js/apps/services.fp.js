var FP = {};

FP.showAlert = function (title, msg, c)
{
	$('div[data-name="alert-fp"]').removeClass().addClass(c);
	$('div[data-name="alert-fp"] h4').html(title);
	$('div[data-name="alert-fp"] p').html(msg);
};

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
			$('table[data-name="tblFPList"] > tbody').empty();
			
			if( data.success )	 
			{
				$.each(data.rows, function(i, v)
				{
					$('table[data-name="tblFPList"] > tbody').append(
						'<tr>'
							+ '<td>' + toThaiDate(v.date_serv)  + '</td>'
							+ '<td>' + v.type_name + '</td>'
							+ '<td>' + v.drug_name + '</td>'
							+ '<td>' + v.amount + '</td>'
							+ '<td>' + v.place_name + '</td>'
						+ '</tr>'
					);
				});
			} 
			else 
			{
				$('table[data-name="tblFPList"] > tbody').append(
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

FP.doCheckInsert = function()
{
	var _vn 			= $('input[data-name="vn"]').val(),
	_drug_id 			= $('input[data-name="fp-drug-code"]').val(),
	_amount 			= $('input[data-name="fp-drug-amount"]').val(),
	_fp_type_id 	= $('select[data-name="fp-type"]').val(),
	_fp_place_id 	= $('select[data-name="fp-place"]').val();
	//_add_income		= $('input[data-name="drug_qty"]').val(),
	
	if( ! _vn ) 
	{
		FP.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ <code> รหัสการให้บริการ (VN) </code>',  'alert alert-error');
	} 
	else if( ! _drug_id ) 
	{
		FP.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>รายการเวชภัณฑ์</code>',  'alert alert-error');
	} 
	else if( ! _amount ) 
	{
		FP.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>จำนวน</code>',  'alert alert-error');
	} 
	else 
	{ // save fp
		FP.doSave( _vn, _drug_id, _amount, _fp_type_id, _fp_place_id );
	}	
};

FP.doSave = function( _vn, _drug_id, _amount, _fp_type_id, _fp_place_id ) 
{
	$.ajax({
		url: _base_url + 'services/dofp',
		dataType: 'json',
		type: 'POST',
		
		data: {
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			vn: _vn,
			drug_id: _drug_id,
			amount: _amount,
			fp_type_id: _fp_type_id,
			fp_place_id: _fp_place_id
		},
		
		success: function(data)
		{
			if(data.success)
			{
				FP.showAlert(' บันทึกข้อมูล',  ' บันทึกข้อมูลเสร็จเรียบร้อยแล้ว', 'alert alert-success');
				// reset form
				$('button[data-name="btnreset"]').click();
				// refresh fp list
				FP.getList();
			}
			else
			{
				FP.showAlert('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล:  ' + data.status,  'alert alert-error');
			}
		},
		
		error: function(xhr, status, errorThrown){
			FP.showAlert('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
	  }	
	});// ajax
};
	
$(function() {
	$('input[data-name="fp-drug-amount"]').numeric();
	
	$('a[data-name="service-fp"]').click(function()
	{
		FP.getList();
	});
	// auto complete for drug search
	$('input[data-name="fp-drug-name"]').autocomplete({
		source: function(request, response){
			$.ajax({
          url: _base_url + 'basic/search_drug_fp',
          dataType: 'json',
          type: 'POST',
          
          data: 
          {
              query: request.term,
              csrf_token: $.cookie('csrf_cookie_cloudhis')
          },
          
          success: function(data)
          {
              response($.map(data, function(i)
              {
                  return {
                      label: i.name,
                      value: i.name,
                      id: i.id
                  }
              }));
          }
   	 	});
		},
		minLength: 2,
		select: function(event, ui){
			$('input[data-name="fp-drug-code"]').val(ui.item.id);
		}
	});
		// check fp detail
	$( 'button[data-name="btn-save-fp"]' ).click( function() {
		FP.doCheckInsert();
	});
});