var NCD = {};

NCD.showAlert = function (title, msg, c)
{
	$('div[data-name="alert-ncd"]').removeClass().addClass(c);
	$('div[data-name="alert-ncd"] h4').html(title);
	$('div[data-name="alert-ncd"] p').html(msg);
};

NCD.getList = function() {
	var _cid = $('input[data-name="cid"]').val();
	
	$.ajax({
		url: _base_url + 'services/getncd',
		dataType: 'json',
		type: 'POST',
		data: {
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			cid: _cid
		},
		success: function( data ) {
			$('table[data-name="tblNCDList"] > tbody').empty();
			
			if( data.success )	 {
				//console.log(data.rows);
				$.each(data.rows, function(i, v){

					$('table[data-name="tblNCDList"] > tbody').append(
						'<tr>'
							+ '<td>' + toThaiDate(v.date_serv)  + '</td>'
							+ '<td>' + v.hospital_name + '</td>'
							+ '<td>' + v.place_name + '</td>'
							+ '<td>' + v.screen_year + '</td>'
							+ '<td>'
							+ '<a href="#" class="btn" data-name="remove-ncd" data-ncd="'+ v.id +'"><i class="icon-trash"></i></a>'
							+ '</td>'
						+ '</tr>'
					);
				});
			} else {
				$('table[data-name="tblNCDList"] > tbody').append(
						'<tr>' 
						+ '<td colspan="4"> ไม่สามารถแสดงรายการได้ </td>'
						+ '</tr>'
					);
			}
		},
		error: function(xhr, status, errorThrown) {
			$('table[data-name="tblNCDList"] > tbody').append(
				'<tr>' 
				+ '<td colspan="4"> ไม่สามารถแสดงรายการได้ </td>'
				+ '</tr>'
			);
		}
	});
};
NCD.setVisitScreen = function() {
	var _height = $('input[data-name="height"]').val(),
	_weight 		= $('input[data-name="weight"]').val(),
	_waistline	= $('input[data-name="waistline"]').val(),
	_bp1 				= $('input[data-name="bp1"]').val(),
	_bp2 				= $('input[data-name="bp2"]').val(),
	_smoke 			= $('select[data-name="smoking"]').val(),
	_alcohol 		= $('select[data-name="drinking"]').val(),
	_fbs				= $('input[data-name="fbs"]').val();
	
	// set value
	$('input[data-name="ncd-weight"]').val(_weight);
	$('input[data-name="ncd-height"]').val(_height);
	$('input[data-name="ncd-bph1"]').val(_bp1);
	$('input[data-name="ncd-bpl1"]').val(_bp2);
	$('select[data-name="ncd-smoke"]').val(_smoke);
	$('select[data-name="ncd-alcohol"]').val(_alcohol);
	$('input[data-name="ncd-bslevel"]').val(_fbs);
	$('input[data-name="ncd-waist"]').val(_waistline);
};

NCD.doCheckInsert = function()
{
	var _vn = $('input[data-name="vn"]').val(),
	_weight = $('input[data-name="ncd-weight"]').val(),
	_height = $('input[data-name="ncd-height"]').val(),
	_bph1 = $('input[data-name="ncd-bph1"]').val(),
	_bph2 = $('input[data-name="ncd-bph2"]').val(),
	_bpl1 = $('input[data-name="ncd-bpl1"]').val(),
	_bpl2 = $('input[data-name="ncd-bpl2"]').val(),
	_dmfamily = $('select[data-name="ncd-dmfamily"]').val(),
	_htfamily = $('select[data-name="ncd-htfamily"]').val(),
	_waist = $('input[data-name="ncd-waist"]').val(),
	_bslevel = $('input[data-name="ncd-bslevel"]').val(),
	_bstest = $('select[data-name="ncd-bstest"]').val(),
	//_service_place = $('select[data-name="ncd-service-place"]').val(),
	_smoke = $('select[data-name="ncd-smoke"]').val(),
	_alcohol = $('select[data-name="ncd-alcohol"]').val()
	_service_place_id	= $('input[data-name="service_place_id"]').val();
	_date_exam	= $('input[data-name="date_serv"]').val();
	
	// check if data empty	
	var _str_error = '';
	var _check = false;
	
	if ( ! _vn ) 
	{
		_str_error 	= '<code>เลขที่รับบริการ</code> ';
		_check 		= true;
	} 
	if ( ! _weight ||  isNaN(_weight) ) 
	{
		_str_error 	+= '<code> น้ำหนัก </code> ' ;
		_check 		= true;
	} 
	if ( ! _height || isNaN( _height ) ) 
	{
		_str_error += '<code> ส่วนสูง </code> ';
		_check = true;
	} 
	if ( ! _bph1 || isNaN( _bph1 ) ) 
	{
		_str_error += '<code>ความดัน BPH1</code>';
		_check = true;
	} 
	if ( ! _bpl1 || isNaN( _bpl1 ) ) 
	{
		_str_error += '<code> ความดัน BPL1 </code> ';
		_check = true;
	} 
	if ( ! _waist || isNaN( _waist ) ) 
	{
		_str_error += '<code> รอบเอว </code> ';
		_check = true;
	}
	if ( ! _bslevel || isNaN( _bslevel ) ) 
	{
		_str_error += '<code> ระดับน้ำตาล </code> ';
		_check = true;
	}
	// if errors.
	if( _check ) {
		NCD.showAlert(' เกิดข้อผิดพลาด ',  ' กรุณาตรวจสอบข้อมูลเหล่านี้  '  + _str_error  , 'alert alert-error');
	} else {
		var obj = {};
				obj.vn 				= _vn; 
				obj.smoke 		= _smoke;
				obj.alcohol 	= _alcohol;
				obj.dmfamily 	= _dmfamily;
				obj.htfamily 	= _htfamily;
				obj.weight 		= _weight;
				obj.height 		= _height;
				obj.waist 		= _waist;
				obj.bph1 			=	_bph1;
				obj.bph2 			= _bph2;
				obj.bpl1 			= _bpl1;
				obj.bpl2 			= _bpl2;
				obj.bslevel 	= _bslevel;
				obj.bstest 		= _bstest;
				obj.service_place_id = _service_place_id;
				obj.date_exam = _date_exam;
				 
		NCD.doSave( obj );
	}
};
/**
 * Save data
 */
NCD.doSave = function( obj	) 
{
	$.ajax({
		url: _base_url + 'services/doncd',
		dataType: 'json',
		type: 'POST',
		
		data: {
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			vn: obj.vn, 
			//screen_place: _screen_place, 
			smoke: obj.smoke, 
			alcohol: obj.alcohol, 
			dmfamily: obj.dmfamily, 
			htfamily: obj.htfamily, 
			weight: obj.weight, 
			height: obj.height, 
			waist: obj.waist, 
			bph1: obj.bph1, 
			bph2: obj.bph2, 
			bpl1: obj.bpl1, 
			bpl2: obj.bpl2,
			bslevel: obj.bslevel, 
			bstest: obj.bstest,
			service_place_id: obj.service_place_id,
			date_exam: obj.date_exam
		},
		
		success: function(data)
		{
			if(data.success)
			{
				NCD.showAlert(' บันทึกข้อมูล',  ' บันทึกข้อมูลเสร็จเรียบร้อยแล้ว', 'alert alert-success');
				// reset form
				$('button[data-name="btnreset"]').click();
				// refresh fp list
				NCD.getList();
			}
			else
			{
				NCD.showAlert('เกิดข้อผิดพลาด!',  data.status,  'alert alert-error');
			}
		  
		},
		
		error: function(xhr, status, errorThrown){
			NCD.showAlert('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
	  }	
	});
};

$(function(){
	// numeric only
	$('input[data-name="ncd-weight"]').numeric();
	$('input[data-name="ncd-height"]').numeric();
	$('input[data-name="ncd-waist"]').numeric();
	$('input[data-name="ncd-bph1"]').numeric();
	$('input[data-name="ncd-bph2"]').numeric();
	$('input[data-name="ncd-bpl1"]').numeric();
	$('input[data-name="ncd-bpl2"]').numeric();
	$('input[data-name="ncd-bslevel"]').numeric();
	
	$('a[data-name="service-ncd"]').click(function(){
		// get screening list
		NCD.getList();
		// set visit data to screening data
		NCD.setVisitScreen();
	});
	
	$( 'button[data-name="btn-save-ncd"]' ).click( function() {
		NCD.doCheckInsert();
	});
});
