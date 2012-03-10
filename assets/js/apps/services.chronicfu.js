toggleAlertChronicfu = function (title, msg, c){
	$('div[data-name="alert-chronicfu"]').removeClass().addClass(c);
	$('div[data-name="alert-chronicfu"] h4').html(title);
	$('div[data-name="alert-chronicfu"] p').html(msg);
}
$(function(){
	$('input[data-name="chronicfu-weight"]').numeric();
	$('input[data-name="chronicfu-height"]').numeric();
	$('input[data-name="chronicfu-waist"]').numeric();
	$('input[data-name="chronicfu-sbp"]').numeric();
	$('input[data-name="chronicfu-dbp"]').numeric();
	
	$('a[data-name="service-chronicfu"]').click(function(){
		// get screening list
		getChronicfuList();
		// set visit data to screening data
		setChronicVisitScreen();
	});
	
	$( 'button[data-name="btn-save-chronicfu"]' ).click( function() {
		var _vn = $('input[data-name="vn"]').val(),
		_weight = $('input[data-name="chronicfu-weight"]').val(),
		_height = $('input[data-name="chronicfu-height"]').val(),
		_sbp = $('input[data-name="chronicfu-sbp"]').val(),
		_dbp = $('input[data-name="chronicfu-dbp"]').val(),
		_eye = $('select[data-name="chronicfu-eye"]').val(),
		_foot = $('select[data-name="chronicfu-foot"]').val(),
		_waist = $('input[data-name="chronicfu-waist"]').val();
		
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
		if ( ! _sbp || isNaN( _sbp ) ) {
			_str_error += '<code>ความดัน SBP</code>';
			_check = true;
		} 
		if ( ! _dbp || isNaN( _dbp ) ) {
			_str_error += '<code> ความดัน DBP </code> ';
			_check = true;
		} 
		if ( ! _waist || isNaN( _waist ) ) {
			_str_error += '<code> รอบเอว </code> ';
			_check = true;
		}
		// if errors.
		if( _check ) {
			toggleAlertChronicfu(' เกิดข้อผิดพลาด ',  ' กรุณาตรวจสอบข้อมูลเหล่านี้  '  + _str_error  , 'alert alert-error');
		} else {
			// do save
			doSaveChronicfu( _vn, _weight, _height, _waist, _sbp, _dbp, _foot, _eye );
		}
	} );
	
	//remove chronic follow up
	$('a[data-name="remove-chronicfu"]').live('click', function() {
		var _id = $(this).attr("data-chronicfu")
					
		if ( confirm( 'คุณต้องการลบรายการนี้ใช่หรือไม่?' )  ) {
			doRemoveChronicfu( _id );
		}
	} );
	
	var setChronicVisitScreen = function() {
		var _height = $('input[data-name="height"]').val(),
		_weight 		= $('input[data-name="weight"]').val(),
		_waistline	= $('input[data-name="waistline"]').val(),
		_bp1 				= $('input[data-name="bp1"]').val(),
		_bp2 				= $('input[data-name="bp2"]').val();
		
		// set value
		$('input[data-name="chronicfu-weight"]').val(_weight);
		$('input[data-name="chronicfu-height"]').val(_height);
		$('input[data-name="chronicfu-sbp"]').val(_bp1);
		$('input[data-name="chronicfu-dbp"]').val(_bp2);
		$('input[data-name="chronicfu-waist"]').val(_waistline);
	},
	getChronicfuList = function() {
		var _cid = $('input[data-name="cid"]').val();
		
		$.ajax({
			url: _base_url + 'services/getchronicfu',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				cid: _cid
			},
			success: function( data ) {
				$('table[data-name="tblChronicFuList"] > tbody').empty();
				
				if( data.success )	 {
					//console.log(data.rows);
					$.each(data.rows, function(i, v){
						var f = v.foot == '1' ? 'ตรวจ' : 'ไม่ตรวจ',
						e = v.eye == '1' ? 'ตรวจ' : 'ไม่ตรวจ'
						$('table[data-name="tblChronicFuList"] > tbody').append(
							
							'<tr>'
								+ '<td>' + toThaiDate(v.date_serv)  + '</td>'
								+ '<td>' + v.sbp + '</td>'
								+ '<td>' + v.dbp + '</td>'
								+ '<td>' + e + '</td>'
								+ '<td>' + f + '</td>'
								+ '<td>'
								+ '<a href="#" class="btn" data-name="remove-chronicfu" data-chronicfu="'+ v.id +'"><i class="icon-trash"></i></a>'
								+ '</td>'
							+ '</tr>'
						);
					});
				} else {
					$('table[data-name="tblChronicFuList"] > tbody').append(
							'<tr>' 
							+ '<td colspan="4"> ไม่สามารถแสดงรายการได้ </td>'
							+ '</tr>'
						);
				}
			},
			error: function(xhr, status, errorThrown) {
				$('table[data-name="tblChronicFuList"] > tbody').append(
					'<tr>' 
					+ '<td colspan="4"> ไม่สามารถแสดงรายการได้ </td>'
					+ '</tr>'
				);
			}
		});
	}	,
	doSaveChronicfu = function( _vn, _weight, _height, _waist, _sbp, _dbp, _foot, _eye	) 
	{
		// post data with ajax
		$.ajax({
			url: _base_url + 'services/dochronicfu',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				vn: _vn, 
				weight: _weight,
				height: _height,
				waist: _waist, 
				sbp: _sbp, 
				dbp: _dbp, 
				foot: _foot, 
				eye: _eye
			},
			success: function(data){
				if(data.success){
					toggleAlertChronicfu(' บันทึกข้อมูล',  ' บันทึกข้อมูลเสร็จเรียบร้อยแล้ว', 'alert alert-success');
					// reset form
					$('button[data-name="btnreset"]').click();
					// refresh fp list
					getChronicfuList();
				}else{
					toggleAlertChronicfu('เกิดข้อผิดพลาด!',  data.status,  'alert alert-error');
				}
			  
			},
			error: function(xhr, status, errorThrown){
				toggleAlertChronicfu('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
				console.log(xhr);
		  }	
		});// ajax
	},
	doRemoveChronicfu = function( _id ) {
		$.ajax({
			url: _base_url + 'services/removechronicfu',
			dataType: 'json',
			type: 'POST',
			data: {
				csrf_token: $.cookie('csrf_cookie_cloudhis'),
				id: _id
			},
			success: function(data){
				if(data.success){
					toggleAlertChronicfu(' ผลการลบ',  ' ลบรายการที่ไม่ต้องการเรียบร้อยแล้ว ', 'alert alert-success');
					// refresh fp list
					getChronicfuList();
				}else{
					toggleAlertChronicfu('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการส่งข้อมูล:  ' + data.status,  'alert alert-error');
				}
			  
			},
			error: function(xhr, status, errorThrown){
				toggleAlertChronicfu('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
		  }	
		});// ajax
	}
});