toggleAlertIncome = function (title, msg, c){
	$('div[data-name="alert-income"]').removeClass().addClass(c);
	$('div[data-name="alert-income"] h4').html(title);
	$('div[data-name="alert-income"] p').html(msg);
}

$(function(){
	
	$('input[data-name="income_price"]').numeric();
	$('input[data-name="income_qty"]').numeric();
	// clear drug_code when name change
	$('input[data-name="income_name"]').keypress(function() {
		$('input[data-name="income_id"]').val('');
		//console.log('Text change.');
	});		
	// auto complete for income search
	$('input[data-name="income_name"]').autocomplete({
		source: function(request, response){
			$.ajax({
	            url: _base_url + 'basic/search_income',
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
	                        id: i.id,
	                        unit: i.unit
	                    }
	                }));
	            }
       	 	});
		},
		minLength: 2,
		select: function(event, ui){
			$('input[data-name="income_id"]').val(ui.item.id);
			$('input[data-name="income_unit"]').val(ui.item.unit);
		}
	});
//
	// check income detail
	$( 'a[data-name="btn-save-income"]' ).click( function() {
		var _vn 		= $('input[data-name="vn"]').val(),
		_income_id 		= $('input[data-name="income_id"]').val(),
		_income_name 	= $('input[data-name="income_name"]').val(),
		_income_unit 	= $('input[data-name="income_unit"]').val(),
		_qty 			= $('input[data-name="income_qty"]').val(),
		_price			= $('input[data-name="income_price"]').val();
		
		if( ! _vn ) {
			toggleAlertIncome('กรุณาตรวจสอบข้อมูล', 'ไม่พบ <code> รหัสการให้บริการ (VN) </code>',  'alert alert-error');
		} else if( ! _income_id ) {
			toggleAlertIncome('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>รายการค่าใช้จ่าย</code>',  'alert alert-error');
		} else if( ! _qty ) {
			toggleAlertIncome('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>จำนวน</code>',  'alert alert-error');
		} else if( ! _price ) {
			toggleAlertIncome('กรุณาตรวจสอบข้อมูล', 'ไม่พบ<code>ราคา</code>',  'alert alert-error');
		} else { // save drug
			doSaveIncome( _vn, _income_id, _price, _qty, _income_name, _income_unit );
		}
	} );
	
	// remove drug
		// remove diag
	$('a[data-name="remove-income"]').live('click', function() {
		var _income_id = $(this).attr("data-income"),
				_vn = $('input[data-name="vn"]').val();
					
		if ( confirm( 'คุณต้องการลบรายการนี้ใช่หรือไม่?\r\n หากข้อมูลไม่อัปเดทกรุณารีเฟรชหน้าเพจใหม่' )  ) {
			$(this).parent().parent().remove();
			doRemoveIncome( _vn, _income_id);
		}
	} );
	// do save drug
	var doSaveIncome = function(_vn, _income_id, _price, _qty, _income_name, _income_unit ) {
		// do save
		$.ajax({
			url: _base_url + 'services/doincome',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				vn: _vn,
				income_id: _income_id,
				price: _price,
				qty: _qty
			},
			success: function(data){
				if(data.success){
					toggleAlert(' บันทึกข้อมูล',  ' บันทึกข้อมูลเสร็จเรียบร้อยแล้ว', 'alert alert-success');
					//alert('การบันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
					// add new row
					var _total = _price * _qty;
					
					var _tr = '<tr><td>' + _income_name  + '</td><td>'+ _income_unit +'</td><td style="text-align: right;">' + addCommas(parseFloat(_price).toFixed(2)) + '</td><td style="text-align: right;">' + addCommas(parseFloat(_qty).toFixed(2)) + '</td><td style="text-align: right;">'+ addCommas(_total.toFixed(2)) +'</td><td><a href="#" data-name="remove-income" data-income="' + _income_id + '" class="btn"> <i class="icon-trash"></i> </a></td></tr>';
					$('table[data-name="tblIncome"] tbody').append(_tr).fadeIn('slow');
					// reset form
					$('button[data-name="btnreset"]').click();
					// hide dialog
					$('div#modal-income').modal('hide');
				}else{
					toggleAlertIncome('เกิดข้อผิดพลาด!', 'กรุณาตรวจสอบข้อมูล:  ' + data.status,  'alert alert-error');
				}
			  
			},
			error: function(xhr, status, errorThrown){
				toggleAlertIncome('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
				//console.log(xhr);
		  }	
		});// ajax
	}// end do save drug
	, doRemoveIncome = function( _vn, _income_id) {
		$.ajax({
			url: _base_url + 'services/removeincome',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				vn: _vn,
				income_id: _income_id
			},
			success: function(data){
				if(data.success){
					toggleAlert(' ผลการลบ',  ' ลบรายการที่ไม่ต้องการเรียบร้อยแล้ว : หากข้อมูลไม่อัปเดทกรุณารีเฟรชหน้าเพจใหม่ ', 'alert alert-success');
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