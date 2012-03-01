var toggleAlertReferOut = function (title, msg, c){
	$('div[data-name="alert-refer-out-register"]').removeClass().addClass(c);
	$('div[data-name="alert-refer-out-register"] h4').html(title);
	$('div[data-name="alert-refer-out-register"] p').html(msg);
}

$(function(){
	
	// modal 
	// show modal register new refer out
	$('a[data-name="ref-out-new-register"]').click(function() {
		referModal.showRegister();
	});
	// hide and clear form
	$('div[data-name="modal-refer-out-new"]').on('hidden', function() {	
		$('button[data-name="svrefero-btn-clear-register"]').trigger('click');
	});
	// end modal
	// show register detail
	$('button[data-name="svrefer-btn-get-register-detail"]').click(function(){
		if($('input[data-name="svrefero-search-patient"]').val()) {
			var _vn = $('input[data-name="svrefero-vn"]').val();
			
			if ( _vn )
			{
				referOutOperation.vn = _vn;
				var x = referOutOperation.checkOutExist();
				
				if( referOutOperation.chk )
				{
					toggleAlertReferOut('ข้อมูลซ้ำ!', 'Visit นี้ได้เคยถูกลงทะเบียนไว้แล้ว กรุณาตรวจสอบ ด้วยเอกสารเอกที่ ' + referOutOperation.refer_id ,  'alert alert-error');
				}
				else
				{
					referOutOperation.getvisitDetail();
				}
					
			}
		}
	});	
	// auto complete for diag
	$('input[data-name="svrefero-register-diag"]').autocomplete({
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
			$('input[data-name="svrefero-register-diag-code"]').val(ui.item.code);
		}
	});
	//search hospital name
	$('input[data-name="svrefero-register-tohosp-name"]').autocomplete({
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
	                        label: i.name,
	                        value: i.name,
	                        code: i.code
	                    }
	                }));
	            }
       	 	});
		},
		minLength: 2,
		select: function(event, ui){
			$('input[data-name="svrefero-register-tohosp-code"]').val(ui.item.code);
		}
	});
	// save refer out
	$('button[data-name="svrefero-btn-save-register"]').click(function(){
		// check valid data
		var _vn = $('input[data-name="svrefero-vn"]').val(),
				_diag = $('input[data-name="svrefero-register-diag-code"]').val(), 
				_treatment = $('textarea[data-name="svrefero-register-treatment"]').val(), 
				_refer_cause = $('select[data-name="svrefero-register-cause"]').val(), 
				_appoint_date = $('input[data-name="svrefero-appoint-date"]').val(), 
				_other_detail = $('textarea[data-name="svrefero-other-detail"]').val(), 
				_to_hospital = $('input[data-name="svrefero-register-tohosp-code"]').val(),
				_refer_date = $('input[data-name="svrefero-register-refer-date"]').val(),
				_refer_type = $('select[data-name="svrefero-register-type"]').val();
		if ( ! _vn ) {
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', 'ไม่พบ<code>รหัสการรับบริการ [vn]</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [รหัสการรับบริการ]');
		}  else if ( ! _refer_date ) {
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', '<code>วันที่ส่งต่อ</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [วันที่ส่งต่อ]');
		} else if ( ! _diag ) {
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', '<code>การวินิจฉัย</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [การวินิจฉัย]');
		} else if ( ! _refer_cause ) {
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', '<code>เหตุผลการส่งต่อ</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [เหตุผลการส่งต่อ]');
		}  else if ( ! _refer_type ) {
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', '<code>ประเภทการส่งต่อ</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [ประเภทการส่งต่อ]');
		} else if ( ! _to_hospital ) {
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', '<code>สถานพยาบาลที่จะส่งต่อ</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [สถานพยาบาลส่งต่อ]');
		} else if ( ! _treatment ) {
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', '<code>การให้การรักษาเบื้องต้น</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [การให้การรักษาเบื้องต้น]');
		} else if ( ! _appoint_date ) {
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', '<code>วันที่นัดผู้ป่วยเข้ารับบริการที่สถานบริการ</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [วันนัดผู้ป่วยเข้ารับบริการครั้งต่อไป]');
		} else {
			// do save register
			var data = {
				diag: _diag,
				treatment: _treatment,
				refer_type: _refer_type,
				refer_cause: _refer_cause,
				refer_date: _refer_date,
				appoint_date: _appoint_date,
				other_detail: _other_detail,
				to_hospital: _to_hospital
			}
			referOutOperation.vn = _vn;
			referOutOperation.register( data );
		}
	});

	$('input[data-name="svrefero-appoint-date"]').datepicker({ dateFormat: 'd/m/yy' });
	$('input[data-name="svrefero-register-refer-date"]').datepicker({
		dateFormat: 'd/m/yy'
	}).datepicker('setDate', new Date());
						
	$('input[data-name="svrefero-search-patient-date"]').datepicker({
		dateFormat: 'd/m/yy'
	}).datepicker('setDate', new Date());

	// hide register detail
	$('button[data-name="svrefero-btn-clear-register"]').click(function(){
		
		$('div[data-name="svrefero-register-search-panel"]').fadeIn('slow');
		$('div[data-name="svrefero-register-detail-panel"]').fadeOut('slow');
		$('div[data-name="svrefero-register-detail-panel"]').css('display', 'none');
		
		$('input[data-name="svrefero-cid"]').val('');
		$('input[data-name="svrefero-vn"]').val('');
		$('input[data-name="svrefero-dateserv"]').val('');
		$('input[data-name="svrefero-search-patient"]').val('');
		
		toggleAlertReferOut('บันทึกข้อมูลการให้บริการส่งต่อ!', 'กรุณากรอกข้อมูลให้ถูกต้อง และสมบูรณ์',  'alert alert-info');
	});
	
	$('input[data-name="svrefero-search-patient"]').autocomplete({
		source: function(request, response){
			$.ajax({
	            url: _base_url + 'refers/search_patient_service',
	            dataType: 'json',
	            type: 'POST',
	            data: {
	                query: request.term,
	                date_serv: $('input[data-name="svrefero-search-patient-date"]').val(),
	                csrf_token: $.cookie('csrf_cookie_cloudhis')
	            },
	            success: function(data){
								if (data.success) {
									response($.map(data.rows, function(i){
	                    return {
	                        label: i.time_serv + ' ' + i.patient_name,
	                        value: i.patient_name,
	                        cid: i.cid,
	                        vn: i.vn,
	                        date_serv: i.date_serv
	                    }
	                }));
								} else {
									console.log(data.status);
								}
	            }
       	 	});
		},
		minLength: 2,
		select: function(event, ui){
			$('input[data-name="svrefero-cid"]').val(ui.item.cid);
			$('input[data-name="svrefero-vn"]').val(ui.item.vn);
			$('input[data-name="svrefero-dateserv"]').val(ui.item.date_serv);
		}
	});
	// refer operation
	var referOutOperation = {
		vn: null,
		refer_id: null,
		
		getlist: function() {
			$.ajax({
				url: _base_url + 'refers/getoutlist',
				dataType: 'json',
				type: 'POST',
				data:
				{
					csrf_token: $.cookie('csrf_cookie_cloudhis'),
					date_refer: _date_refer
				},
				success: function( data )
				{
					$('table[data-name="tblrefer-out-list"] > tbody').empty();
					
					if( data.success )
					{
						//console.log(data.rows);
						$.each(data.rows, function(i, v){
							var result = '';
							if( v.anc_res == '1')
							{
								result = 'ปกติ';
							}
							else
							{
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
					}
					else
					{
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
		// register new service
		register: function( config ) {
			$.ajax({
				url: _base_url + 'refers/doout',
				dataType: 'json',
				type: 'POST',
				data: {
					csrf_token: $.cookie('csrf_cookie_cloudhis'),
					vn: this.vn,
					diag: config.diag,
					treatment: config.treatment,
					refer_type: config.refer_type,
					refer_cause: config.refer_cause,
					refer_date: config.refer_date,
					appoint_date: config.appoint_date,
					other_detail: config.other_detail,
					to_hospital: config.to_hospital
				},
				success: function( data ) {
					$('table[data-name="tblrefer-out-list"] > tbody').empty();
					if( data.success )	 {
						alert('การบันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
						toggleAlertReferOut('การบันทึก ['+data.status+']', 'บันทึกข้อมูลการส่งต่อ (Refer) เสร็จเรียบร้อยแล้ว',  'alert alert-success');
						// show tab
						 $('a[data-name="svrrefotab-patient-detail"]').tab('show');
					} else {
						toggleAlertReferOut('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาตรวจสอบ',  'alert alert-error');
					}
				},
				error: function(xhr, status, errorThrown) {
					toggleAlertReferOut('เกิดข้อผิดพลาด!',  xhr.status + ': ' + xhr.statusText,  'alert alert-error');
				}
			});
		},
		
		getVisitDetail: function() {
			$.ajax({
				url: _base_url + 'refers/getregister_service',
				dataType: 'json',
				type: 'POST',
				data: {
					vn: this.vn,
					csrf_token: $.cookie('csrf_cookie_cloudhis')
				},
				success: function(data){
					if(data.rows.length == 0)
					{
						alert('ไม่พบข้อมูล การรับบริการ');
						$('div[data-name="svrefero-register-detail-panel"]').fadeOut('slow');
					}
					else
					{
						var fullname = data.rows[0].fname + ' ' + data.rows[0].lname;
	
						toggleAlertReferOut('กรุณาบันทึกข้อมูล', 'กรุณากรอกรายละเอียดการส่งต่อ', 'alert alert-success');
	
						// refer date
						$('input[data-name="svrefer-register-visit-date"]').val(toThaiDate(data.rows[0].date_serv));
						$('input[data-name="svrefer-register-visit-time"]').val(data.rows[0].time_serv);
						$('input[data-name="svrefer-register-visit-fullname"]').val(fullname);
						$('input[data-name="svrefer-register-visit-right"]').val(data.rows[0].ins_name)
						$('div[data-name="svrefero-register-detail-panel"]').fadeIn('slow');
						$('div[data-name="svrefero-register-search-panel"]').fadeOut('slow');
					}
				},
				
				error: function( xhr, status, errorThrown )
				{
					alert( xhr.status + ' : ' + xhr.statusText );
				}
	   	});
		},
		
		/**
		 * Check referout  exist
		 * @param string _vn The visit number
		 * @return mixed The referal id or false if no id
		 **/
		checkOutExist: function()
		{
			$.ajax({
				url: _base_url + 'refers/checkout',
				dataType: 'json',
				type: 'POST',
				
				data:
				{
					csrf_token: $.cookie('csrf_cookie_cloudhis'),
					vn: this.vn
				},
				
				success: function( data )
				{
					if( data.success )
					{
						return true;
					}
					else
					{
						return false;
					}
				},
				
				error: function( xhr, status, errorThrown )
				{
					console.log( xhr.status + ' : ' + xhr.statusText );
				}
				
			});
		},
	/**
	 *	Get Refer out detail if visit exist
	 *
	 *	@param string id Refer out number
	 *	@return void
	 **/
		getReferOutDetail: function()
		{
			$.ajax({
				url: _base_url + 'refers/get_refer_out_detail',
				dataType: 'json',
				type: 'POST',
				
				data:
				{
					csrf_token: $.cookie('csrf_cookie_cloudhis'),
					id: this.refer_id
				},
				
				success: function( data )
				{
					if( data.success )
					{
						// set refer detail
						console.log( data.rows );
					}
					else
					{
						alert( 'ไม่สามารถแสดงข้อมูลการส่งต่อได้' );
					}
				},
				
				error: function( xhr, status, errorThrown )
				{
					alert( xhr.status + ': ' + xhr.statusText );
				}
				
			});
		}
	}
	
	// modal config
	referModal = {
		showRegister: function() {
			$('div[data-name="modal-refer-out-new"]').modal('show').css({
        width: 700,
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    	});
		}
	} /*  end refer modal */
})