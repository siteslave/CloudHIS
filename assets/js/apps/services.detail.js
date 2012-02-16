toggleAlert = function (title, msg, c){
	$('#alert-block').removeClass().addClass(c);
	$('#alert-block h4').html(title);
	$('#alert-block p').html(msg);
}
$( function() {
	$( 'a[data-name="btnSaveScreen"]' ).click( function() {
		checkScreening();
	} );

	$('input[data-name="proced_price"]').numeric();

	// select text in txt-icd
	$("input, textarea").focus(
	 	function()
	 	{
	  	// only select if the text has not changed
	  	if($(this).value == $(this).defaultValue)
	  	{
	   		$(this).select();
	  	}
	 	}
	);
	// modal diag hide.
	$('div#modal-diag').on('hidden', function () {
  	// reset form
		$('button[data-name="btnreset"]').click();
	});
					
	// botton save diag click
	$( 'a[data-name="btn-save-diag"]' ).click( function() {
		var _vn 		= $('input[data-name="vn"]').val(),
		_diag_code 		= $('input[data-name="diag_code"]').val(),
		_diag_name 		= $('input[data-name="diag_name"]').val(),
		_diag_type 		= $('select[data-name="diag_type"]').val();
		_diag_type_name	= $('select[data-name="diag_type"] option:selected').text();
		
		if( ! _vn ) {
			toggleAlertDiag('กรุณาตรวจสอบข้อมูล', 'ไม่พบ <code> รหัสการให้บริการ (VN) </code>',  'alert alert-error');
		} else if( ! _diag_code ) {
			toggleAlertDiag('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>รหัสการวินิจฉัยโรค</code>',  'alert alert-error');
		} else { // save diag
			doSaveDiag( _vn, _diag_code, _diag_type, _diag_name, _diag_type_name );
		}		
	} );

	// remove diag
	$('a[data-name="remove-icd"]').live('click', function() {
		//console.log( $(this).attr("data-diag") );
		var _diag_code = $(this).attr("data-diag"),
			_vn = $('input[data-name="vn"]').val();	
		if ( confirm( 'คุณต้องการลบรายการนี้ใช่หรือไม่?' )  ) {
			//if( $('table[data-name="tblDiag"] tbody tr').size() > 1 ) {
				$(this).parent().parent().remove();
			//}	
			doRemoveDiag( _vn, _diag_code);
		}
	} );

	// auto complete
	$('input[data-name="diag_name"]').autocomplete({
		source: function(request, response){
			$.ajax({
	            url: _base_url + 'basic/search_diag',
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
			$('input[data-name="diag_code"]').val(ui.item.code);
		}
	});

	// alert toggle
	var toggleAlertDiag = function (title, msg, c){
		$('div[data-name="alert-diag"]').removeClass().addClass(c);
		$('div[data-name="alert-diag"] h4').html(title);
		$('div[data-name="alert-diag"] p').html(msg);
	},
		toggleAlertProced = function (title, msg, c){
		$('div[data-name="alert-proced"]').removeClass().addClass(c);
		$('div[data-name="alert-proced"] h4').html(title);
		$('div[data-name="alert-proced"] p').html(msg);
	},
	// check valid form.
	checkScreening = function() {
		var _vn 			= $('input[data-name="vn"]').val(),
			_weight 		= $('input[data-name="weight"]').val(),
			_height 		= $('input[data-name="height"]').val(),
			_heartbeat 		= $('input[data-name="heartbeat"]').val(),
			_pulse 			= $('input[data-name="pulse"]').val(),
			_waistline 		= $('input[data-name="waistline"]').val(),
			_temperature 	= $('input[data-name="temperature"]').val(),
			_fbs			= $('input[data-name="fbs"]').val(),
			_bp1 			= $('input[data-name="bp1"]').val(),
			_bp2 			= $('input[data-name="bp2"]').val(),
			_dtx1	 		= $('input[data-name="dtx1"]').val(),	
			_dtx2 			= $('input[data-name="dtx2"]').val(),
			_smoking 		= $('select[data-name="smoking"]').val(),
			_drinking 		= $('select[data-name="drinking"]').val(),
			_allergic 		= $('select[data-name="allergic"]').val(),
			_cc 			= $('textarea[data-name="cc"]').val(),
			_new_height 	= _height / 100,
			_bmi 			= (_weight / (_new_height * _new_height)).toFixed(2);
		
		// check if data empty	
		var _str_error = '';
		var _check = false;
		
		if ( ! _vn ) {
			_str_error 	= '<code>เลขที่รับบริการ</code> ';
			_check 		= true;
		} 
		if ( ! _weight ||  isNaN(_weight) ) {
			_str_error 	+= '<code> น้ำหนัก </code> ' ;
			_check 		= true;
		} 
		if ( ! _height || isNaN( _height ) ) {
			_str_error += '<code> ส่วนสูง </code> ';
			_check = true;
		} 
		if ( ! _heartbeat ) {
			_str_error += '<code>อัตราการเต้นของหัวใจ</code>';
			_check = true;
		} 
		if ( ! _pulse ) {
			_str_error += '<code> ชีพจร </code> ';
			_check = true;
		} 
		if ( ! _waistline || isNaN( _waistline ) ) {
			_str_error += '<code> รอบเอว </code> ';
			_check = true;
		}
		if ( ! _temperature || isNaN( _temperature ) ) {
			_str_error += '<code> อุณหภูมิ </code> ';
			_check = true;
		}
		if ( ! _bp1 || isNaN( _bp1 ) ) {
			_str_error += '<code> ความดัน (บน) </code> ';
			_check = true;
		}
		if ( ! _bp2 || isNaN( _bp2 ) ) {
			_str_error += '<code> ความดัน (ล่าง) </code> ';
			_check = true;
		}
		if ( ! _cc ) {
			_str_error += ' <code>อาการแรกรับ</code> ';
			_check = true;
		} 
		// if errors.
		if( _check ) {
			toggleAlert(' เกิดข้อผิดพลาด ',  ' กรุณาตรวจสอบข้อมูลเหล่านี้  '  + _str_error  , 'alert alert-error');
		} else { // no error.
			// save data
			// set bmi data
			$('input[data-name="bmi"]').val(_bmi);
			
			$.ajax({
				url: _base_url + 'services/doscreening',
				dataType: 'json',
				type: 'POST',
				data: {
					csrf_token: $.cookie('csrf_cookie_cloudhis'),
					vn: _vn,
					weight: _weight ,
					height: _height,
					heartbeat: _heartbeat,
					pulse: _pulse,
					waistline: _waistline,
					temperature: _temperature,
					fbs: _fbs,
					bp1: _bp1,
					bp2: _bp2,
					dtx1: _dtx1,	
					dtx2: _dtx2,
					smoking: _smoking,
					drinking: _drinking,
					allergic: _allergic,
					cc: _cc,
					bmi: _bmi
				},
				success: function(data){
					if(data.success){
						//window.location = _base_url + 'services';
						toggleAlert(' บันทึกข้อมูล ['+data.msg+']',  ' การบันทึกข้อมูลเสร็จเรียบร้อยแล้ว ', 'alert alert-success');
						_check = false;
					}else{
						toggleAlert('Server Error!', 'เกิดข้อผิดพลาดในการส่งข้อมูล กรุณาตรวจสอบ',  'alert alert-error');
					}
				  
				},
				error: function(xhr, status, errorThrown){
					toggleAlert('Server Error!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
					//console.log(xhr);
			  }
			}); // $.ajax
		}
		
	},
	// save diag
	doSaveDiag = function( _vn, _diag_code, _diag_type, _diag_name, _diag_type_name ) {		
		// do save
		$.ajax({
			url: _base_url + 'services/dodiag',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				vn: _vn,
				diag_code: _diag_code ,
				diag_type: _diag_type
			},
			success: function(data){
				if(data.success){
					//window.location = _base_url + 'services';
					toggleAlert(' บันทึกข้อมูล',  ' การบันทึกข้อมูลเสร็จเรียบร้อยแล้ว ', 'alert alert-success');
					
					// add new row
					var _tr = '<tr><td>' + _diag_code  + '</td><td>' + _diag_name + '</td><td>' + _diag_type_name + '</td><td><a href="#" data-name="remove-icd" data-diag="' + _diag_code + '" class="btn"> <i class="icon-trash"></i> </a></td></tr>';
					$('table[data-name="tblDiag"] tbody').append(_tr).fadeIn('slow');
					// reset form
					$('button[data-name="btnreset"]').click();
					// hide dialog
					$('div#modal-diag').modal('hide');
					
				}else{
					toggleAlertDiag('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล:  ' + data.status,  'alert alert-error');
				}
			  
			},
			error: function(xhr, status, errorThrown){
				toggleAlertDiag('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
				//console.log(xhr);
		  }	
		});// ajax
	},
		// remove diag
	doRemoveDiag = function( _vn, _diag_code ) {
		// do save
		$.ajax({
			url: _base_url + 'services/removediag',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				vn: _vn,
				diag_code: _diag_code
			},
			success: function(data){
				if(data.success){
					toggleAlert(' ผลการลบ',  ' ลบรายการที่ไม่ต้องการเรียบร้อยแล้ว ', 'alert alert-success');
				}else{
					toggleAlert('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล:  ' + data.status,  'alert alert-error');
				}
			  
			},
			error: function(xhr, status, errorThrown){
				toggleAlert('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
				//console.log(xhr);
		  }	
		});// ajax
	};
	
	// procedure
	// auto complete for proced
	$('input[data-name="proced_name"]').autocomplete({
		source: function(request, response){
			$.ajax({
	            url: _base_url + 'basic/search_proced',
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
			$('input[data-name="proced_code"]').val(ui.item.code);
		}
	});
	// button save procedure click
	$( 'a[data-name="btn-save-proced"]' ).click( function() {
		var _vn = $('input[data-name="vn"]').val(),
		_code 	= $('input[data-name="proced_code"]').val(),
		_name 	= $('input[data-name="proced_name"]').val(),
		_price 	= $('input[data-name="proced_price"]').val();
		
		if( ! _vn ) {
			toggleAlertProced('กรุณาตรวจสอบข้อมูล', 'ไม่พบ <code> รหัสการให้บริการ (VN) </code>',  'alert alert-error');
		} else if( ! _code ) {
			toggleAlertProced('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>รหัสหัตถการ</code>',  'alert alert-error');
		} else if( ! _price ) {
			toggleAlertProced('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>ราคา</code>',  'alert alert-error');
		} else { // save diag
			doSaveProced( _vn, _code, _price, _name );
		}		
	} );
	// end procedure
	// remove proced
	$('a[data-name="remove-proced"]').live('click', function() {
		//console.log( $(this).attr("data-diag") );
		var _code = $(this).attr("data-proced"),
				_vn = $('input[data-name="vn"]').val();
					
		if ( confirm( 'คุณต้องการลบรายการนี้ใช่หรือไม่?' )  ) {
			//if( $('table[data-name="tblDiag"] tbody tr').size() > 1 ) {
				$(this).parent().parent().remove();
			//}
							
			doRemoveProced( _vn, _code);
		}
	} );
	// end remove proced
	var doSaveProced = function( _vn, _code, _price, _name ) {
		// do save
		$.ajax({
			url: _base_url + 'services/doproced',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				vn: _vn,
				code: _code,
				price: _price
			},
			success: function(data){
				if(data.success){
					toggleAlert(' บันทึกข้อมูล',  ' บันทึกข้อมูลเสร็จเรียบร้อยแล้ว', 'alert alert-success');
					// add new row
					var _tr = '<tr><td>' + _code  + '</td><td>' + _name + '</td><td style="text-align: right;">' + addCommas(parseFloat(_price).toFixed(2)) + '</td><td>' + data.username + '</td><td><a href="#" data-name="remove-proced" data-proced="' + _code + '" class="btn"> <i class="icon-trash"></i> </a></td></tr>';
					$('table[data-name="tblProced"] tbody').append(_tr).fadeIn('slow');
					// reset form
					$('button[data-name="btnreset"]').click();
					// hide dialog
					$('div#modal-proced').modal('hide');
				}else{
					toggleAlert('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล:  ' + data.status,  'alert alert-error');
				}
			  
			},
			error: function(xhr, status, errorThrown){
				toggleAlertProced('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
				//console.log(xhr);
		  }	
		});// ajax
	},
	doRemoveProced = function(_vn, _code) {
		$.ajax({
			url: _base_url + 'services/removeproced',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				vn: _vn,
				code: _code
			},
			success: function(data){
				if(data.success){
					toggleAlert(' ผลการลบ',  ' ลบรายการที่ไม่ต้องการเรียบร้อยแล้ว ', 'alert alert-success');
				}else{
					toggleAlert('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล:  ' + data.status,  'alert alert-error');
				}
			  
			},
			error: function(xhr, status, errorThrown){
				toggleAlert('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
				//console.log(xhr);
		  }	
		});// ajax
	};
	
} );
