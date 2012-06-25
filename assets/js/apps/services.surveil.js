var SURV = {};

SURV.showAlert = function(title, msg, c){
	$('div[data-name="alert-surveil"]').removeClass().addClass(c);
	$('div[data-name="alert-surveil"] h4').html(title);
	$('div[data-name="alert-surveil"] p').html(msg);
};

SURV.doCheck = function()
{
	var _vn 						= $('input[data-name="vn"]').val(),
			_diag_code 			= $('input[data-name="surveil_diag_code"]').val(),
			_code_506 			= $('input[data-name="surveil_506_code"]').val(),
			_ill_date 			= $('input[data-name="surveil-date"]').val(),
			_ill_addr				= $('input[data-name="address"]').val(),
			_ill_moo 				= $('select[data-name="mooban"]').val(),
			_ill_tmb 				= $('input[data-name="tmb_code"]').val(),
			_ill_amp 				= $('input[data-name="amp_code"]').val(),
			_ill_chw 				= $('input[data-name="chw_code"]').val(),
			_patient_status = $('select[data-name="patient_status"]').val(),
			_death_date 		= $('input[data-name="surveil-death-date"]').val(),
			_comp 					= $('input[data-name="surveil-complication-code"]').val(),
			_organ 					= $('input[data-name="surveil-organism-code"]').val();

	if( ! _vn ) {
		SURV.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ <code> รหัสการให้บริการ (VN) </code>',  'alert alert-error');
	} else if( ! _diag_code ) {
		SURV.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>รหัสการวินิจฉัยโรค</code>',  'alert alert-error');
	} else if( ! _ill_date ) {
		SURV.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>วันที่ป่วย</code>',  'alert alert-error');
	} else if( ! _patient_status ) {
		SURV.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>สถานภาพผู้ป่วย</code>',  'alert alert-error');
	} else if ( _patient_status == '2' && ! _death_date ) {
		SURV.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>วันที่เสียชีวิต</code>',  'alert alert-error');
	}else if( ! _code_506 ) {
		SURV.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>รหัส 506</code>',  'alert alert-error');
	} else if( ! _comp ) {
		SURV.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>สาเหตุการป่วย</code>',  'alert alert-error');
	} else if( ! _organ ) {
		SURV.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>ชนิดของเชื้อโรค</code>',  'alert alert-error');
	} else if( ! _ill_chw ) {
		SURV.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>จังหวัด</code>',  'alert alert-error');
	} else if( ! _ill_amp ) {
		SURV.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>อำเภอ</code>',  'alert alert-error');
	} else if( ! _ill_tmb ) {
		SURV.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>ตำบล</code>',  'alert alert-error');
	} else if( ! _ill_addr ) {
		SURV.showAlert('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>บ้านเลขที่</code>',  'alert alert-error');
	} else {
		var obj = {};
		obj.vn = _vn;
		obj.diag_code = _diag_code;
		obj.code_506 = _code_506;
		obj.ill_date = _ill_date;
		obj.ill_addr = _ill_addr;
		obj.ill_moo = _ill_moo;
		obj.ill_tmb = _ill_tmb;
		obj.ill_amp = _ill_amp;
		obj.ill_chw = _ill_chw;
		obj.patient_status = _patient_status;
		obj.death_date = _death_date;
		obj.comp = _comp;
		obj.organ = _organ;
		
		SURV.doSave( obj );
	}		
};

SURV.getMooban = function( _tmb ) {
	$.ajax({
		url: _base_url + 'basic/getmooban',
    dataType: 'json',
    type: 'POST',
    data: {
			chw_code: $('input[data-name="chw_code"]').val(),
			amp_code: $('input[data-name="amp_code"]').val(),
			tmb_code: _tmb,
      csrf_token: $.cookie('csrf_cookie_cloudhis')
    },
    success: function(data){
    	$('select[data-name="mooban"]').empty();
			$.each(data, function(i, v){
				$('select[data-name="mooban"]').append(
					'<option value="' + v.moo + '">หมู่ ' + v.moo + ' ' + v.name + '</option>'
				);
			});
    }
	});	
};
SURV.clearMooban = function() 
{
	$('select[data-name="mooban"]').empty();
}

SURV.doSave = function( obj ) {
	$.ajax({
		url: _base_url + 'services/dosurveil',
		dataType: 'json',
		type: 'POST',
		data: {
			vn: obj.vn,
			diag_code: obj.diag_code,
			code_506: obj.code_506,
			ill_date: obj.ill_date,
			ill_addr: obj.ill_addr,
			ill_moo: obj.ill_moo,
			ill_tmb: obj.ill_tmb,
			ill_amp: obj.ill_amp,
			ill_chw: obj.ill_chw,
			patient_status: obj.patient_status,
			death_date: obj.death_date,
			comp: obj.comp,
			organ: obj.organ,
			csrf_token: $.cookie('csrf_cookie_cloudhis')
		},
		success: function( data ) {
			if ( data.success ) {
				SURV.showAlert('ผลการบันทึก', 'บันทึกข้อมูลเสร็จเรียบร้อยแล้ว',  'alert alert-success');
				// load surveil list
				var _cid = $('input[data-name="cid"]').val();
				SURV.getList( obj.cid ) ;
			} else {
				SURV.showAlert('เกิดข้อผิดพลาด',  ata.status, 'alert alert-success');
			}
		},
		error: function(xhr, status, errorThrown) {
			SURV.showAlert('Server error!', 'Error: <code>' + xhr.status + '- ' + xhr.statusText + '</code>',  'alert alert-error');
		}
	});
};

SURV.getList = function( _cid ) {
	$.ajax({
		url: _base_url + 'services/getsurveil',
		dataType: 'json',
		type: 'POST',
		data: {
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			cid: _cid
		},
		success: function( data ) {
			$('table[data-name="tblSurveilList"] > tbody').empty();
			
			if( data.success )	 {
				//console.log(data.rows);
				$.each(data.rows, function(i, v){
					var illdate = v.ill_date.length > 0 ? toThaiDate(v.ill_date) : ' ';
					
					$('table[data-name="tblSurveilList"] > tbody').append(
						'<tr>'
							+ '<td>' + toThaiDate(v.date_serv)  + '</td>'
							+ '<td>' + v.tname + '</td>'
							+ '<td>' + v.diag_code + ' ' + v.diag_name + '</td>'
							+ '<td>' + illdate + '</td>'
							+ '<td>' + v.status_name + '</td>'
						+ '</tr>'
					);
				});
			} else {
				$('table[data-name="tblSurveilList"] > tbody').append(
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
};
	
$(function() {	
	$('input[data-name="surveil-death-date"]').datepicker({ dateFormat: 'd/m/yy' });
	$('input[data-name="surveil-date"]').datepicker({ dateFormat: 'd/m/yy' });
	
	$('a[data-name="service-506"]').click(function() {
		var _cid = $('input[data-name="cid"]').val();
		SURV.getList( _cid ) ;
	});
	
	$('input[data-name="chw_name"]').autocomplete({
		source: function(request, response){
			$.ajax({
	            url: _base_url + 'basic/getchw',
	            dataType: 'json',
	            type: 'POST',
	            data: {
	                query: request.term,
	                csrf_token: $.cookie('csrf_cookie_cloudhis')
	            },
	            success: function(data){
	                response($.map(data, function(i){
	                    return {
	                        label: i.name,
	                        value: i.name,
	                        code: i.chw
	                    }
	                }));
	            }
       	 	});
		},
		minLength: 2,
		select: function(event, ui){
			$('input[data-name="chw_code"]').val(ui.item.code);
			SURV.clearMooban();
		}
	});	
	// search ampur
	$('input[data-name="amp_name"]').autocomplete({
		source: function(request, response){
			$.ajax({
	            url: _base_url + 'basic/getamp',
	            dataType: 'json',
	            type: 'POST',
	            data: {
	                query: request.term,
									chw_code: $('input[data-name="chw_code"]').val(),
	                csrf_token: $.cookie('csrf_cookie_cloudhis')
	            },
	            success: function(data){
	                response($.map(data, function(i){
	                    return {
	                        label: i.name,
	                        value: i.name,
	                        code: i.amp
	                    }
	                }));
	            },
							error: function(xhr, status, errorThrown) {
								alert('ไม่สามารถแสดงข้อมูลได้: [ '  + xhr.status + ' ' + xhr.statusText +' ]')
							}
       	 	});
		},
		minLength: 2,
		select: function(event, ui){
			$('input[data-name="amp_code"]').val(ui.item.code);
			SURV.clearMooban();
		}
	});
// search tambon
	$('input[data-name="tmb_name"]').autocomplete({
		source: function(request, response){
			$.ajax({
          url: _base_url + 'basic/gettmb',
          dataType: 'json',
          type: 'POST',
          data: {
              query: request.term,
							chw_code: $('input[data-name="chw_code"]').val(),
							amp_code: $('input[data-name="amp_code"]').val(),
              csrf_token: $.cookie('csrf_cookie_cloudhis')
          },
          success: function(data){
              response($.map(data, function(i){
                  return {
                      label: i.name,
                      value: i.name,
                      code: i.tmb
                  }
              }));
          },
					error: function(xhr, status, errorThrown) {
						alert('ไม่สามารถแสดงข้อมูลได้: [ '  + xhr.status + ' ' + xhr.statusText +' ]')
					}
   	 	});
		},
		minLength: 2,
		select: function(event, ui){
			$('input[data-name="tmb_code"]').val(ui.item.code);
			SURV.getMooban( ui.item.code );
		}
	});
	// search surveil diag
	$('input[data-name="surveil_diag_name"]').autocomplete({
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
			$('input[data-name="surveil_diag_code"]').val(ui.item.code);
		}
	});
	// search 506 code
	$('input[data-name="surveil_506_name"]').autocomplete({
		source: function(request, response){
			$.ajax({
          url: _base_url + 'basic/search_surveil',
          dataType: 'json',
          type: 'POST',
          data: {
              query: request.term,
              csrf_token: $.cookie('csrf_cookie_cloudhis')
          },
          success: function(data){
              response($.map(data, function(i){
                  return {
                      label: i.tname,
                      value: i.tname,
                      id: i.id
                  }
              }));
          }
   	 	});
		},
		minLength: 2,
		select: function(event, ui){
			$('input[data-name="surveil_506_code"]').val(ui.item.id);
		}
	});
	// surveil complication search
	$('input[data-name="surveil-complication"]').autocomplete({
		source: function(request, response){
			$.ajax({
          url: _base_url + 'basic/search_surveil_comp',
          dataType: 'json',
          type: 'POST',
          data: {
              query: request.term,
              csrf_token: $.cookie('csrf_cookie_cloudhis')
          },
          success: function(data){
              response($.map(data, function(i){
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
			$('input[data-name="surveil-complication-code"]').val(ui.item.id);
		}
	});
	// surveil oganism search
	$('input[data-name="surveil-organism"]').autocomplete({
		source: function(request, response){
			$.ajax({
          url: _base_url + 'basic/search_surveil_organ',
          dataType: 'json',
          type: 'POST',
          data: {
              query: request.term,
              csrf_token: $.cookie('csrf_cookie_cloudhis')
          },
          success: function(data){
              response($.map(data, function(i){
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
			$('input[data-name="surveil-organism-code"]').val(ui.item.id);
		}
	});
	
	$('button[data-name="btn-save-surveil"]').click(function() {
		SURV.doCheck();	
	});
});