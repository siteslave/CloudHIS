var toggleAlertReferOut = function (title, msg, c){
	$('div[data-name="alert-refer-out-register"]').removeClass().addClass(c);
	$('div[data-name="alert-refer-out-register"] h4').html(title);
	$('div[data-name="alert-refer-out-register"] p').html(msg);
}

$(function(){

	$('input[data-name="svrefero-appoint-date"]').datepicker({ dateFormat: 'd/m/yy' });
	$('input[data-name="svrefero-date-list"]').datepicker({ dateFormat: 'd/m/yy' }).datepicker('setDate', new Date());
	$('input[data-name="svreferi-date-list"]').datepicker({ dateFormat: 'd/m/yy' }).datepicker('setDate', new Date());
	$('input[data-name="svrefero-register-refer-date"]').datepicker({ dateFormat: 'd/m/yy' }).datepicker('setDate', new Date());
	$('input[data-name="svrefer-confirm-date"	]').datepicker({ dateFormat: 'd/m/yy' }).datepicker('setDate', new Date());
					
	$('input[data-name="svrefero-search-patient-date"]').datepicker({
		dateFormat: 'd/m/yy'
	}).datepicker('setDate', new Date());

	// create new refer out operation function
	var Refer = {};
			Refer.Out = {};
			Refer.In = {};
	
	/**
	 * Get refer out list
	 * @param {Date} refer_date Refer out date
	 **/
	Refer.Out.getReferList = function()
	{
		var refer_date = $('input[data-name="svrefero-date-list"]').val();
		
		$.ajax({
			url: _base_url + 'refers/get_refer_out_list',
			dataType: 'json',
			type: 'POST',
			
			data:
			{
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				refer_date: refer_date
			},
			success: function( data )
			{
				$('table[data-name="tblrefer-out-list"] > tbody').empty();
				
				if( data.success )
				{
					$.each(data.rows, function(i, v){
						
						$('table[data-name="tblrefer-out-list"] > tbody').append(
							'<tr>'
								+ '<td>' + v.id  + '</td>'
								+ '<td>' + toThaiDate( v.refer_date )  + '</td>'
								+ '<td>' + v.cid  + '</td>'
								+ '<td>' + v.fullname + '</td>'
								+ '<td>' + v.age + '</td>'
								+ '<td>' + v.to_hospital_name + '</td>'
								+ '<td>'
								+ '<a href="#" title="แก้ไขข้อมูลการส่งต่อ" class="btn" data-name="refero-info" data-id="'+ v.id +'"><i class="icon-edit"></i></a> '
								+ '<a href="#" title="ยกเลิกการส่งต่อ" class="btn" data-name="refero-remove" data-id="'+ v.id +'"><i class="icon-trash"></i></a>'
								+ '</td>'
							+ '</tr>'
						);
					});
				}
				else
				{
					$('table[data-name="tblrefer-out-list"] > tbody').append(
						'<tr>' 
						+ '<td colspan="7"> ไม่พบรายการส่งต่อ </td>'
						+ '</tr>'
					);
				}
			},
			error: function(xhr, status, errorThrown) {
				$('table[data-name="tblrefer-out-list"] > tbody').append(
					'<tr>' 
					+ '<td colspan="7"> ไม่สามารถแสดงรายการได้ </td>'
					+ '</tr>'
				);
			}
		});
	};
	/**
	 * Register new refer out
	 * 
	 * @param {mixed} config Refer out information
	 * @return void
	 **/
	Refer.Out.register = function( config )
	{
		$.ajax({
			url: _base_url + 'refers/doout',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				vn: config.vn,
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
	};
	/**
	 * Get visit detail for register new refer out
	 * and set information of visit in registration form
	 * 
	 * @param string vn Visit number
	 * @return void
	 **/
	Refer.Out.getVisitDetail = function( vn )
	{
		$.ajax({
			url: _base_url + 'refers/getregister_service',
			dataType: 'json',
			type: 'POST',
			data: {
				vn: vn,
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
	};
	/**
	 * Check refer out exist
	 * return ture if exist, false if don't exist
	 *
	 * @param string vn Visit number
	 * @returns bool
	 **/
	Refer.Out.checkExist = function( vn )
	{
		$.ajax({
			url: _base_url + 'refers/checkout',
			dataType: 'json',
			type: 'POST',
			
			data:
			{
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				vn: vn
			},
			
			success: function( data )
			{
				if( data.success )
				{
					toggleAlertReferOut('ข้อมูลซ้ำ!', 'กรุณาตรวจสอบ เอกสารเลขที่ ' + data.refer_id ,  'alert alert-error');
				}
				else
				{
					Refer.Out.getVisitDetail( vn );
				}
			},
			
			error: function( xhr, status, errorThrown )
			{
				console.log( xhr.status + ' : ' + xhr.statusText );
			}
			
		});
	};
		/**
	 *	Get Refer out detail if visit exist
	 *
	 *	@param string id Refer out number
	 **/
	Refer.Out.getReferOutDetail = function( id )
	{
		$.ajax({
			url: _base_url + 'refers/get_refer_out_detail',
			dataType: 'json',
			type: 'POST',
			
			data:
			{
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				id: id
			},
			
			success: function( data )
			{
				if( data.success )
				{
					// set refer detail
					$('input[data-name="svrefero-cid"]').val( data.rows[0].cid );
					$('input[data-name="svrefero-vn"]').val( data.rows[0].vn );
					$('input[data-name="svrefero-dateserv"]').val( data.rows[0].date_serv );
					$('input[data-name="svrefer-register-visit-date"]').val( toThaiDate(data.rows[0].date_serv) );
					$('input[data-name="svrefer-register-visit-time"]').val( data.rows[0].time_serv );
					
					var fullname = data.rows[0].fname + ' ' + data.rows[0].lname;
					$( 'input[data-name="svrefer-register-visit-fullname"]' ).val( fullname );
					$( 'input[data-name="svrefer-register-visit-right"]' ).val( data.rows[0].ins_name );
					$( 'input[data-name="svrefero-register-refer-date"]' ).datepicker( 'setDate', toSystemDate(data.rows[0].refer_date) );
					$( 'select[data-name="svrefero-register-refer-cause"]' ).val( data.rows[0].refer_cause );
					$( 'input[data-name="svrefero-register-diag"]' ).val( data.rows[0].diag_name );
					$( 'input[data-name="svrefero-register-diag-code" ]' ).val( data.rows[0].diag );
					$( 'select[data-name="svrefero-register-type"]' ).val( data.rows[0].refer_type );
					$( 'input[data-name="svrefero-register-tohosp-name"]' ).val( data.rows[0].hospital_name );
					$( 'input[data-name="svrefero-register-tohosp-code"]' ).val( data.rows[0].to_hospital );
					$( 'textarea[data-name="svrefero-register-treatment"]' ).val( data.rows[0].treatment );
					$( 'textarea[data-name="svrefero-other-detail"]' ).val( data.rows[0].other_detail );
					$( 'input[data-name="svrefero-appoint-date"]' ).datepicker( 'setDate', new Date( data.rows[0].appoint_date ) );
					
					$('div[data-name="svrefero-register-search-panel"]').css('display', 'none');
					$('div[data-name="svrefero-register-detail-panel"]').fadeIn('slow');
					
					referModal.showRegister();
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
	};
	/**
	 * Remove refer out
	 *
	 * @param {String} id The refer out id
	 **/
	Refer.Out.remove = function( id )
	{
		$.ajax({
			url: _base_url + 'refers/remove_out',
			dataType: 'json',
			type: 'POST',
			
			data:
			{
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				id: id
			},
			
			success: function( data )
			{
				if( data.success )
				{
					alert( 'ลบข้อมูลการส่งต่อเสร็จเรียบร้อยแล้ว' );
					Refer.Out.getReferList();
				}
				else
				{
					alert( 'ไม่สามารถลบรายการได้ : \r\n' + data.status );
				}
			},
			
			error: function( xhr, status, errorThrown )
			{
				alert( xhr.status + ': ' + xhr.statusText );
			}
			
		});
	}
	
	/************************************
	********* Refer in module ***********
	*************************************/
	/**
	 * Get refer in list
	 * 
	 **/
	Refer.In.getList = function()
	{
		var refer_date = $('input[data-name="svreferi-date-list"]').val(),
		approve = $( 'select[data-name="svreferi-approve-type"]' ).val();
		
		$.ajax({
			url: _base_url + 'refers/get_refer_in_list',
			dataType: 'json',
			type: 'POST',
			
			data:
			{
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				refer_date: refer_date,
				approve: approve
			},
			success: function( data )
			{
				$('table[data-name="tblrefer-in-list"] > tbody').empty();
				
				if( data.success )
				{
					$.each(data.rows, function(i, v){
						var str_status = '';
						
						if (v.confirm_status == 'N')
						{
							str_status = '<a href="#" title="ยังไม่ลงทะเบียนรับ คลิกเพื่อลงทะเบียนรับ" class="btn btn-danger" data-name="referi-confirm" data-id="'+ v.id +'"><i class="icon-check icon-white"></i></a> ';
						}
						else
						{
							str_status = '<a href="#" title="ลงทะเบียนรับแล้ว คลิกเพื่อดูข้อมูล" class="btn btn-success" data-name="referi-confirm-detail" data-id="'+ v.id +'"><i class="icon-info-sign icon-white"></i></a> ';	
						}
						
						$('table[data-name="tblrefer-in-list"] > tbody').append(
							'<tr>'
								+ '<td>' + v.id  + '</td>'
								+ '<td>' + toThaiDate( v.refer_date )  + '</td>'
								+ '<td>' + v.cid  + '</td>'
								+ '<td>' + v.fullname + '</td>'
								+ '<td>' + v.to_hospital_name + '</td>'
								+ '<td>' + str_status 
								+ ' <a href="#" title="ข้อมูลการส่งต่อ" class="btn" data-name="refero-info" data-id="'+ v.id +'"><i class="icon-edit"></i></a> '
								+ '</td>'
							+ '</tr>'
						);
					});
				}
				else
				{
					$('table[data-name="tblrefer-in-list"] > tbody').append(
						'<tr>' 
						+ '<td colspan="7"> ไม่พบรายการส่งต่อ </td>'
						+ '</tr>'
					);
				}
			},
			error: function(xhr, status, errorThrown) {
				$('table[data-name="tblrefer-in-list"] > tbody').append(
					'<tr>' 
					+ '<td colspan="6"> ไม่สามารถแสดงรายการได้ </td>'
					+ '</tr>'
				);
			}
		});
	};
	/**
	 * Get refer-out detail for confirmation
	 *
	 * @param {Int} id The Refer-out number
	 **/
	Refer.In.getConfirmDetail = function ( id )
	{
		$.ajax({
			url: _base_url + 'refers/get_confirm',
			dataType: 'json',
			type: 'POST',
			
			data:
			{
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				id: id
			},
			
			success: function( data )
			{
				if( data.success )
				{
					$( 'input[data-name="svrefer-confirm-detail-date"]' ).val( toThaiDate( data.rows[0].confirm_date ) );
					$( 'textarea[data-name="svrefer-confirm-detail-other"]' ).val( data.rows[0].confirm_detail );
					$( 'input[data-name="svrefer-confirm-detail-user"]' ).val( data.rows[0].user_fullname );
					$( 'input[data-name="svrefer-confirm-detail-date-update"]' ).val( data.rows[0].confirm_datetime );
					referModal.showConfirmDetail();
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
	};
	/**
	 * Save refer confirm
	 *
	 **/
	Refer.In.saveConfirm = function() {
		var confirm_date = $( 'input[data-name="svrefer-confirm-date"]' ).val(),
		refer_id = $( 'input[data-name="svrefer-confirm-refer-id"]' ).val(),
		other_detail = $( 'textarea[data-name="svrefer-confirm-other-detail"]' ).val();
		
		if( ! confirm_date )
		{
			alert( 'กรุณากำหนดวันที่รับ' );
		}
		else if( ! refer_id )
		{
			alert( 'ไม่พบเลขที่ในการส่งต่อ กรุณาตรวจสอบ' );
		}
		else
		{
			// do save confirm
			$.ajax({
				url: _base_url + 'refers/doconfirm',
				dataType: 'json',
				type: 'POST',
				
				data:
				{
					csrf_token: $.cookie('csrf_cookie_cloudhis'),
					refer_id: refer_id,
					confirm_date: confirm_date,
					other_detail: other_detail
				},
				
				success: function( data )
				{
					if( data.success )
					{
						alert( 'การลงทะเบียนรับ พร้อมกับสร้าง visit เสร็จสิ้นแล้ว' );
						// clear data
						$( 'input[data-name="svrefer-confirm-refer-id"]' ).val('');
						// refersh list
						Refer.In.getList();
						// close modal
						$('div[data-name="modal-refer-in-confirm"]').modal('hide');
						
					}
					else
					{
						alert( 'ไม่สามารถบันทึกข้อมูลการยืนยันได้\r\n' + data.statusText );
					}
				},
				
				error: function( xhr, status, errorThrown )
				{
					alert( xhr.status + ': ' + xhr.statusText );
				}
				
			});
		}
	};
	
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
			var vn = $('input[data-name="svrefero-vn"]').val();
			
			if ( vn )
			{
				Refer.Out.checkExist( vn );
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
		select: function(event, ui)
		{
			$('input[data-name="svrefero-register-tohosp-code"]').val(ui.item.code);
		}
	});
	// save refer out
	$('button[data-name="svrefero-btn-save-register"]').click(function(){
		// check valid data
		var _vn = $('input[data-name="svrefero-vn"]').val(),
				_diag = $('input[data-name="svrefero-register-diag-code"]').val(), 
				_treatment = $('textarea[data-name="svrefero-register-treatment"]').val(), 
				_refer_cause = $('select[data-name="svrefero-register-refer-cause"]').val(), 
				_appoint_date = $('input[data-name="svrefero-appoint-date"]').val(), 
				_other_detail = $('textarea[data-name="svrefero-other-detail"]').val(), 
				_to_hospital = $('input[data-name="svrefero-register-tohosp-code"]').val(),
				_refer_date = $('input[data-name="svrefero-register-refer-date"]').val(),
				_refer_type = $('select[data-name="svrefero-register-type"]').val();
		if ( ! _vn )
		{
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', 'ไม่พบ<code>รหัสการรับบริการ [vn]</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [รหัสการรับบริการ]');
		}
		else if ( ! _refer_date )
		{
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', '<code>วันที่ส่งต่อ</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [วันที่ส่งต่อ]');
		}
		else if ( ! _diag )
		{
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', '<code>การวินิจฉัย</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [การวินิจฉัย]');
		}
		else if ( ! _refer_cause )
		{
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', '<code>เหตุผลการส่งต่อ</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [เหตุผลการส่งต่อ]');
		}
		else if ( ! _refer_type )
		{
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', '<code>ประเภทการส่งต่อ</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [ประเภทการส่งต่อ]');
		}
		else if ( ! _to_hospital )
		{
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', '<code>สถานพยาบาลที่จะส่งต่อ</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [สถานพยาบาลส่งต่อ]');
		}
		else if ( ! _treatment )
		{
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', '<code>การให้การรักษาเบื้องต้น</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [การให้การรักษาเบื้องต้น]');
		}
		else if ( ! _appoint_date )
		{
			toggleAlertReferOut('ข้อมูลไม่สมบูรณ์!', '<code>วันที่นัดผู้ป่วยเข้ารับบริการที่สถานบริการ</code>',  'alert alert-error');
			alert('ข้อมูลไม่สมบูรณ์ กรุณาตรวจสอบ [วันนัดผู้ป่วยเข้ารับบริการครั้งต่อไป]');
		}
		else
		{
			// do save register
			var data = {
				vn: _vn,
				diag: _diag,
				treatment: _treatment,
				refer_type: _refer_type,
				refer_cause: _refer_cause,
				refer_date: _refer_date,
				appoint_date: _appoint_date,
				other_detail: _other_detail,
				to_hospital: _to_hospital
			}
			
			Refer.Out.register( data );
		}
	});

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
							
	            data:
							{
	                query: request.term,
	                date_serv: $('input[data-name="svrefero-search-patient-date"]').val(),
	                csrf_token: $.cookie('csrf_cookie_cloudhis')
	            },
							
	            success: function(data)
							{
								if (data.success)
								{
									response($.map(data.rows, function(i){
	                    return {
	                        label: i.time_serv + ' ' + i.patient_name,
	                        value: i.patient_name,
	                        cid: i.cid,
	                        vn: i.vn,
	                        date_serv: i.date_serv
	                    }
	                }));
								}
								else
								{
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

	// get refer out detail
	$('a[data-name="refero-info"]').live( 'click', function(){
		Refer.Out.getReferOutDetail( $(this).attr('data-id') );
	});
	// remove refer out
	$('a[data-name="refero-remove"]').live( 'click', function(){
		if ( confirm('คุณต้องการลบข้อมูลการส่งต่อนี้ ใช่หรือไม่?') )
		{
			Refer.Out.remove( $(this).attr('data-id') );
		}
	});
	
	// refer confirm
	$('a[data-name="referi-confirm"]').live( 'click', function(){
		$( 'input[data-name="svrefer-confirm-refer-id"]' ).val( $(this).attr('data-id') );
		referModal.showConfirm();
	});
	
	// refer confirm detail
	$( 'a[data-name="referi-confirm-detail"]' ).live( 'click', function(){
		Refer.In.getConfirmDetail( $(this).attr('data-id') );
	} );
	// modal config
	referModal = {
		showRegister: function()
		{
			$('div[data-name="modal-refer-out-new"]').modal('show').css({
        width: 700,
        'margin-left': function ()
				{
            return -($(this).width() / 2);
        }
    	});
		},
		showConfirm: function()
		{
			$('div[data-name="modal-refer-in-confirm"]').modal('show').css({
        width: 600,
        'margin-left': function ()
				{
            return -($(this).width() / 2);
        }
    	});
		},
		showConfirmDetail: function()
		{
			$('div[data-name="modal-refer-in-confirm-detail"]').modal('show').css({
        width: 600,
        'margin-left': function ()
				{
            return -($(this).width() / 2);
        }
    	});
		}
	} /*  end refer modal */
	
	
	// get refer-out list
	$('button[data-name="svrefero-btn-getlist"]').click(function() {
		Refer.Out.getReferList();		
	});
	// get refer-in list
	$( 'button[data-name="svreferi-btn-getlist"]' ).click(function() {
		Refer.In.getList();
	});
	// save refer confirm
	$( 'a[data-name="btnrefer-confirm-save"]' ).click(function(){
		Refer.In.saveConfirm();	
	});
});