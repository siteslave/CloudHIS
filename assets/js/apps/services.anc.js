toggleAlertANC = function (title, msg, c){
	$('div[data-name="alert-anc"]').removeClass().addClass(c);
	$('div[data-name="alert-anc"] h4').html(title);
	$('div[data-name="alert-anc"] p').html(msg);
}
$(function(){
	$('input[data-name="anc-ga"]').numeric();
	//search hospital name
	$('input[data-name="anc-service-place-name"]').autocomplete({
		source: function(request, response){
			$.ajax({
	            url: _base_url + 'basic/search_hospital',
	            dataType: 'json',
	            type: 'POST',
	            data: {
	                query: request.term,
	                csrf_token: $.cookie('csrf_cookie_cloudhis')
	            },
	            success: function(data){
	                response($.map(data, function(i){
	                    return {
	                        label: i.code + ' ' + i.name,
	                        value: i.name,
	                        code: i.code
	                    }
	                }));
	            }
       	 	});
		},
		minLength: 2,
		select: function(event, ui){
			$('input[data-name="anc-service-place-code"]').val(ui.item.code);
		}
	});
	$( 'button[data-name="btn-save-anc"]' ).click( function() {
		var _vn 	= $('input[data-name="vn"]').val(),
		_anc_place= $('input[data-name="anc-service-place-code"]').val(),
		_gravida 	= $('input[data-name="anc-gravida"]').val(),
		_ga 			= $('input[data-name="anc-ga"]').val(),
		_anc_res	= $('select[data-name="anc-res"]').val();
		
		if( ! _vn ) {
			toggleAlertANC('กรุณาตรวจสอบข้อมูล', 'ไม่พบ <code> รหัสการให้บริการ (VN) </code>',  'alert alert-error');
		} else if( ! _anc_place ) {
			toggleAlertANC('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>สถานที่ตรวจ</code>',  'alert alert-error');
		} else if( ! _ga ) {
			toggleAlertANC('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>อายุครรภ์</code>',  'alert alert-error');
		} else { // save anc
			doSaveANC( _vn, _anc_place, _gravida, _ga, _anc_res );
		}
	} );
	
	$('a[data-name="service-anc"]').click(function(){
		getANCList();
	});
	//remove anc
	$('a[data-name="remove-anc"]').live('click', function() {
		var _id = $(this).attr("data-anc");
		if ( confirm( 'คุณต้องการลบรายการนี้ใช่หรือไม่?' )  ) {
			doRemoveANC( _id);
			// delete row
			$(this).parent().parent().remove();
		}
	} );
	var getANCList = function() {
		var _cid = $('input[data-name="cid"]').val();
		
		$.ajax({
			url: _base_url + 'services/getanc',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				cid: _cid
			},
			success: function( data ) {
				$('table[data-name="tblANCList"] > tbody').empty();
				
				if( data.success )	 {
					//console.log(data.rows);
					$.each(data.rows, function(i, v){
						var result = '';
						if( v.anc_res == '1') {
							result = 'ปกติ';
						} else {
							result = 'ผิดปกติ';
						}
						$('table[data-name="tblANCList"] > tbody').append(
							'<tr>'
								+ '<td>' + toThaiDate(v.date_serv)  + '</td>'
								+ '<td>' + v.place_name + '</td>'
								+ '<td>' + v.gravida + '</td>'
								+ '<td>' + v.ga + '</td>'
								+ '<td>' + result + '</td>'
								+ '<td>'
								+ '<a href="#" class="btn" data-name="remove-anc" data-anc="'+ v.id +'"><i class="icon-trash"></i></a>'
								+ '</td>'
							+ '</tr>'
						);
					});
				} else {
					$('table[data-name="tblANCList"] > tbody').append(
							'<tr>' 
							+ '<td colspan="6"> ไม่สามารถแสดงรายการได้ </td>'
							+ '</tr>'
						);
				}
			},
			error: function(xhr, status, errorThrown) {
				$('table[data-name="tblANCList"] > tbody').append(
					'<tr>' 
					+ '<td colspan="6"> ไม่สามารถแสดงรายการได้ </td>'
					+ '</tr>'
				);
			}
		});
	},
	doSaveANC = function( _vn, _anc_place, _gravida, _ga, _anc_res ) {
		// do save
		$.ajax({
			url: _base_url + 'services/doanc',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				vn: _vn,
				anc_place: _anc_place,
				gravida: _gravida,
				ga: _ga,
				anc_res: _anc_res
			},
			success: function(data){
				if(data.success){
					toggleAlertANC(' บันทึกข้อมูล',  ' บันทึกข้อมูลเสร็จเรียบร้อยแล้ว', 'alert alert-success');
					// reset form
					$('button[data-name="btnreset"]').click();
					// refresh fp list
					getANCList();
				}else{
					toggleAlertANC('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล:  ' + data.status,  'alert alert-error');
				}
			  
			},
			error: function(xhr, status, errorThrown){
				toggleAlertANC('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
				console.log(xhr);
		  }	
		});// ajax
	}, 
	doRemoveANC = function( _id) {
		$.ajax({
			url: _base_url + 'services/removeanc',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				id: _id
			},
			success: function(data){
				if(data.success){
					toggleAlertANC(' ผลการลบ',  ' ลบรายการที่ไม่ต้องการเรียบร้อยแล้ว ', 'alert alert-success');
				}else{
					toggleAlertANC('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล:  ' + data.status,  'alert alert-error');
				}
			  
			},
			error: function(xhr, status, errorThrown){
				toggleAlertANC('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
		  }	
		});// ajax
	};// end doRemoveDrug
});