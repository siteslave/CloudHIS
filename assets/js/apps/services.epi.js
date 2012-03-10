toggleAlertEPI = function (title, msg, c){
	$('div[data-name="alert-epi"]').removeClass().addClass(c);
	$('div[data-name="alert-epi"] h4').html(title);
	$('div[data-name="alert-epi"] p').html(msg);
}
$(function(){
		// check fp detail
	$( 'button[data-name="btn-save-epi"]' ).click( function() {
		// $vn, $drug_id, $amount, $fp_type_id, $fp_place_id
		var _vn 			= $('input[data-name="vn"]').val(),
		_vcctype 			= $('select[data-name="epi-vcctype"]').val(),
		_vccplace 			= $('select[data-name="epi-vccplace"]').val();
		
		if( ! _vn ) {
			toggleAlertEPI('กรุณาตรวจสอบข้อมูล', 'ไม่พบ <code> รหัสการให้บริการ (VN) </code>',  'alert alert-error');
		} else if( ! _vcctype ) {
			toggleAlertEPI('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>วัคซีนที่ได้รับ</code>',  'alert alert-error');
		} else if( ! _vccplace ) {
			toggleAlertEPI('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>สถานที่รับวัคซีน</code>',  'alert alert-error');
		} else { // save fp
			doSaveEPI( _vn, _vcctype, _vccplace );
		}
	} );
	
	$('a[data-name="service-epi"]').click(function(){
		getEPIList();
	});
	//remove epi
	$('a[data-name="remove-epi"]').live('click', function() {
		var _vcctype = $(this).attr("data-epi"),
			_vn = $('input[data-name="vn"]').val();
					
		if ( confirm( 'คุณต้องการลบรายการนี้ใช่หรือไม่?' )  ) {
			doRemoveEpi( _vn, _vcctype);
			// delete row
			$(this).parent().parent().remove();
		}
	} );
	var getEPIList = function() {
		var _cid = $('input[data-name="cid"]').val();
		
		$.ajax({
			url: _base_url + 'services/getepi',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				cid: _cid
			},
			success: function( data ) {
				$('table[data-name="tblEPIList"] > tbody').empty();
				
				if( data.success )	 {
					//console.log(data.rows);
					$.each(data.rows, function(i, v){
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
				} else {
					$('table[data-name="tblEPIList"] > tbody').append(
							'<tr>' 
							+ '<td colspan="5"> ไม่สามารถแสดงรายการได้ </td>'
							+ '</tr>'
						);
				}
			},
			error: function(xhr, status, errorThrown) {
				alert('ไม่สามารถแสดงข้อมูลการนัดได้: [ '  + xhr.status + ' ' + xhr.statusText +' ]')
			}
		});
	},
	doSaveEPI = function( _vn, _vcctype, _vccplace ) {
		// do save
		$.ajax({
			url: _base_url + 'services/doepi',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				vn: _vn,
				vcctype: _vcctype,
				vccplace: _vccplace
			},
			success: function(data){
				if(data.success){
					toggleAlertEPI(' บันทึกข้อมูล',  ' บันทึกข้อมูลเสร็จเรียบร้อยแล้ว', 'alert alert-success');
					// reset form
					$('button[data-name="btnreset"]').click();
					// refresh fp list
					getEPIList();
				}else{
					toggleAlertEPI('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล:  ' + data.status,  'alert alert-error');
				}
			  
			},
			error: function(xhr, status, errorThrown){
				toggleAlertEPI('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
				//console.log(xhr);
		  }	
		});// ajax
	}, 
	doRemoveEpi = function( _vn, _vcctype) {
		$.ajax({
			url: _base_url + 'services/removeepi',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				vn: _vn,
				vcctype: _vcctype
			},
			success: function(data){
				if(data.success){
					toggleAlertEPI(' ผลการลบ',  ' ลบรายการที่ไม่ต้องการเรียบร้อยแล้ว ', 'alert alert-success');
					// refresh epi list
					// getEPIList();
				}else{
					toggleAlertEPI('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล:  ' + data.status,  'alert alert-error');
				}
			  
			},
			error: function(xhr, status, errorThrown){
				toggleAlertEPI('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
		  }	
		});// ajax
	};// end doRemoveDrug
})