$(function() {	
	$('input[data-name="surveil-death-date"]').datepicker({ dateFormat: 'd/m/yy' });
	$('input[data-name="surveil-date"]').datepicker({ dateFormat: 'd/m/yy' });
	$('a[data-name="service-506"]').click(function() {
		var _cid = $('input[data-name="cid"]').val();
		getSurveilList( _cid ) ;
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
			clearMooban();
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
			clearMooban();
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
			getMooban( ui.item.code );
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
	// save data
	// params $vn, $code_506, $diag_code, $ill_date, $ill_address, $ill_moo, $ill_tmb, $ill_amp, $ill_chw, $patient_status, $death_date, $comp, $organ
	$('button[data-name="btn-save-surveil"]').click(function() {
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
			toggleAlertSurveil('กรุณาตรวจสอบข้อมูล', 'ไม่พบ <code> รหัสการให้บริการ (VN) </code>',  'alert alert-error');
		} else if( ! _diag_code ) {
			toggleAlertSurveil('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>รหัสการวินิจฉัยโรค</code>',  'alert alert-error');
		} else if( ! _ill_date ) {
			toggleAlertSurveil('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>วันที่ป่วย</code>',  'alert alert-error');
		} else if( ! _patient_status ) {
			toggleAlertSurveil('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>สถานภาพผู้ป่วย</code>',  'alert alert-error');
		} else if ( _patient_status == '2' && ! _death_date ) {
			toggleAlertSurveil('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>วันที่เสียชีวิต</code>',  'alert alert-error');
		}else if( ! _code_506 ) {
			toggleAlertSurveil('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>รหัส 506</code>',  'alert alert-error');
		} else if( ! _comp ) {
			toggleAlertSurveil('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>สาเหตุการป่วย</code>',  'alert alert-error');
		} else if( ! _organ ) {
			toggleAlertSurveil('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>ชนิดของเชื้อโรค</code>',  'alert alert-error');
		} else if( ! _ill_chw ) {
			toggleAlertSurveil('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>จังหวัด</code>',  'alert alert-error');
		} else if( ! _ill_amp ) {
			toggleAlertSurveil('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>อำเภอ</code>',  'alert alert-error');
		} else if( ! _ill_tmb ) {
			toggleAlertSurveil('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>ตำบล</code>',  'alert alert-error');
		} else if( ! _ill_addr ) {
			toggleAlertSurveil('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>บ้านเลขที่</code>',  'alert alert-error');
		} else { // save surveil
			doSaveSurveil( _vn, _diag_code, _code_506, _ill_date, _ill_addr, _ill_moo, _ill_tmb, _ill_amp, _ill_chw, _patient_status, _death_date, _comp, _organ );
		}		
	});
	
	var toggleAlertSurveil = function (title, msg, c){
			$('div[data-name="alert-surveil"]').removeClass().addClass(c);
			$('div[data-name="alert-surveil"] h4').html(title);
			$('div[data-name="alert-surveil"] p').html(msg);
		}
		, getMooban = function( _tmb ) {
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
	}
	// clear Mooban list
	, clearMooban = function() {
		$('select[data-name="mooban"]').empty();
	}
	// save Surveil
	,	doSaveSurveil = function( _vn, _diag_code, _code_506, _ill_date, _ill_addr, _ill_moo, _ill_tmb, _ill_amp, _ill_chw, _patient_status, _death_date, _comp, _organ ) {
		$.ajax({
			url: _base_url + 'services/dosurveil',
			dataType: 'json',
			type: 'POST',
			data: {
				vn: _vn,
				diag_code: _diag_code,
				code_506: _code_506,
				ill_date: _ill_date,
				ill_addr: _ill_addr,
				ill_moo: _ill_moo,
				ill_tmb: _ill_tmb,
				ill_amp: _ill_amp,
				ill_chw: _ill_chw,
				patient_status: _patient_status,
				death_date: _death_date,
				comp: _comp,
				organ: _organ,
				csrf_token: $.cookie('csrf_cookie_cloudhis')
			},
			success: function( data ) {
				if ( data.success ) {
					toggleAlertSurveil('ผลการบันทึก', 'บันทึกข้อมูลเสร็จเรียบร้อยแล้ว',  'alert alert-success');
					// load surveil list
					var _cid = $('input[data-name="cid"]').val();
					getSurveilList( _cid ) ;
				} else {
					toggleAlertSurveil('เกิดข้อผิดพลาด',  ata.status, 'alert alert-success');
				}
			},
			error: function(xhr, status, errorThrown) {
				toggleAlertSurveil('Server error!', 'Error: <code>' + xhr.status + '- ' + xhr.statusText + '</code>',  'alert alert-error');
			}
		});
	},
	getSurveilList = function( _cid ) {
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
	}
});