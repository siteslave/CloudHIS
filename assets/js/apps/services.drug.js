$(function() {
	toggleAlertDrug = function (title, msg, c){
		$('div[data-name="alert-drug"]').removeClass().addClass(c);
		$('div[data-name="alert-drug"] h4').html(title);
		$('div[data-name="alert-drug"] p').html(msg);
	}
	
	$('input[data-name="drug_price"]').numeric();
	$('input[data-name="drug_qty"]').numeric();
			
	// auto complete for drug search

	$('input[data-name="drug_name"]').autocomplete({
		source: function(request, response){
			$.ajax({
	            url: _base_url + 'basic/search_drug',
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
			$('input[data-name="drug_id"]').val(ui.item.id);
		}
	});
	// auto complete for drug search
	$('input[data-name="usage_name"]').autocomplete({
		source: function(request, response){
			$.ajax({
	            url: _base_url + 'basic/search_usage',
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
			$('input[data-name="usage_id"]').val(ui.item.id);
			$('input[data-name="drug_price"]').focus();
		}
	});
	
	// clear drug_code when name change
	$('input[data-name="drug_name"]').keypress(function() {
		$('input[data-name="drug_id"]').val('');
		//console.log('Text change.');
	});
	// clear drug_code when name change
	$('input[data-name="usage_name"]').keypress(function() {
		$('input[data-name="usage_id"]').val('');
		//console.log('Text change.');
	});


	// check drug detail
	$( 'a[data-name="btn-save-drug"]' ).click( function() {
		var _vn 	= $('input[data-name="vn"]').val(),
		_drug_id 	= $('input[data-name="drug_id"]').val(),
		_drug_name 	= $('input[data-name="drug_name"]').val(),
		_usage_id 	= $('input[data-name="usage_id"]').val(),
		_usage_name = $('input[data-name="usage_name"]').val(),
		_qty 		= $('input[data-name="drug_qty"]').val(),
		_price		= $('input[data-name="drug_price"]').val();
		
		if( ! _vn ) {
			toggleAlertDrug('กรุณาตรวจสอบข้อมูล', 'ไม่พบ <code> รหัสการให้บริการ (VN) </code>',  'alert alert-error');
		} else if( ! _drug_id ) {
			toggleAlertDrug('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>ชื่อยา</code>',  'alert alert-error');
		} else if( ! _qty ) {
			toggleAlertDrug('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>จำนวน</code>',  'alert alert-error');
		} else if( ! _price ) {
			toggleAlertDrug('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>ราคา</code>',  'alert alert-error');
		} else if( ! _usage_id ) {
			toggleAlertDrug('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>วิธีการใช้</code>',  'alert alert-error');
		} else { // save drug
			doSaveDrug( _vn, _drug_id, _price, _qty, _usage_id, _drug_name, _usage_name );
		}
	} );
	
	// remove drug
	$('a[data-name="remove-drug"]').live('click', function() {
		var _drug_id = $(this).attr("data-drug"),
			_vn = $('input[data-name="vn"]').val();
					
		if ( confirm( 'คุณต้องการลบรายการนี้ใช่หรือไม่?' )  ) {
			$(this).parent().parent().remove();
			doRemoveDrug( _vn, _drug_id);
		}
	} );
	// do save drug
	var doSaveDrug = function( _vn, _drug_id, _price, _qty, _usage_id, _drug_name, _usage_name ) {
		// do save
		$.ajax({
			url: _base_url + 'services/dodrug',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				vn: _vn,
				drug_id: _drug_id,
				price: _price,
				qty: _qty,
				usage_id: _usage_id
			},
			success: function(data){
				if(data.success){
					toggleAlert(' บันทึกข้อมูล',  ' บันทึกข้อมูลเสร็จเรียบร้อยแล้ว', 'alert alert-success');
					//alert('การบันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
					// add new row
					var _total = _price * _qty;
					
					var _tr = '<tr><td>' + _drug_name  + '</td><td>' + _usage_name + '</td><td style="text-align: right;">' + addCommas(parseFloat(_price).toFixed(2)) + '</td><td style="text-align: right;">' + addCommas(parseFloat(_qty).toFixed(2)) + '</td><td style="text-align: right;">'+ addCommas(_total.toFixed(2)) +'</td><td><a href="#" data-name="remove-drug" data-drug="' + _drug_id + '" class="btn"> <i class="icon-trash"></i> </a></td></tr>';
					$('table[data-name="tblDrug"] tbody').append(_tr).fadeIn('slow');
					// reset form
					$('button[data-name="btnreset"]').click();
					// hide dialog
					$('div#modal-drug').modal('hide');
				}else{
					toggleAlertDrug('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล:  ' + data.status,  'alert alert-error');
				}
			  
			},
			error: function(xhr, status, errorThrown){
				toggleAlertDrug('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
				//console.log(xhr);
		  }	
		});// ajax
	}// end do save drug
	, doRemoveDrug = function( _vn, _drug_id) {
		$.ajax({
			url: _base_url + 'services/removedrug',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				vn: _vn,
				drug_id: _drug_id
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
		  }	
		});// ajax
	};// end doRemoveDrug
	
});