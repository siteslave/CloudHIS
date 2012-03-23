var REG = {};

REG.showAlert = function(title, msg, c)
{
	$('#svreg-error-msg').removeClass().addClass(c);
	$('#svreg-error-msg strong').html(title);
	$('#svreg-error-msg em').html(msg);
};
//check register form
REG.doCheckForm = function()
{
	var _cid 				= $('input[data-rel="cid"]').val(),
	_date_serv 			= $('input[data-rel="date_serv"]').val(),
	_time_serv 			= $('input[data-rel="time_serv"]').val(),
	_intime 				= $('select[data-rel="intime"]').val(),
	_clinic_id 			= $('select[data-rel="clinic_id"]').val(),
	_pttype_id 			= $('select[data-rel="pttype_id"]').val(),
	_location_id 		= $('select[data-rel="location_id"]').val(),
	_service_place_id 	= $('select[data-rel="service_place_id"]').val(),
	_ins_id 				= $('input[data-rel="ins_id"]').val(),
	_ins_code 			= $('input[data-rel="ins_code"]').val(),
	_hmain_code 		= $('input[data-rel="hmain_code"]').val(),
	_hsub_code 			= $('input[data-rel="hsub_code"]').val();
	_ins_start 			= $('input[data-rel="ins_start"]').val();
	_ins_expire 		= $('input[data-rel="ins_expire"]').val();

	if(_cid.length == 0) 
	{
		_t = 'ข้อมูลไม่สมบูรณ์';
		_msg = 'กรุณากรอกเลขบัตรประชาชนที่ต้องการค้นหา';
		REG.showAlert(_t, _msg, 'alert alert-error');
	}
	else if(_date_serv.length == 0)
	{
		REG.showAlert('ข้อมูลไม่สมบูรณ์', 'กรุณาเลือก <code> วันที่ </code> มารับบริการ', 'alert alert-error');
	}
	else if(_time_serv.length == 0)
	{
		REG.showAlert('ข้อมูลไม่สมบูรณ์', 'กรุณาเลือก <code"> เวลา </code> มารับบริการ', 'alert alert-error');
	}
	else if(_ins_id.length == 0)
	{
		REG.showAlert('ข้อมูลไม่สมบูรณ์', 'กรุณาเลือก <code> สิทธิการรักษา </code> ของผู้มารับบริการ', 'alert alert-error');
	}
	else
	{
		var obj = {};
		obj.cid = _cid;
		obj.date_serv = _date_serv;
		obj.time_serv = _time_serv;
		obj.intime = _intime;
		obj.clinic_id = _clinic_id;
		obj.pttype_id = _pttype_id;
		obj.location_id = _location_id;
		obj.service_place_id = _service_place_id;
		obj.ins_id = _ins_id;
		obj.ins_code = _ins_code;
		obj.hmain_code = _hmain_code;
		obj.hsub_code = _hsub_code;
		obj.ins_start = _ins_start;
		obj.ins_expire = _ins_expire;
		
		REG.doRegister( obj );
	}
};

REG.doRegister = function( obj ){
	$.ajax({
		url: _base_url + 'services/doregister',
		dataType: 'json',
		type: 'POST',
		data: {
	    cid: _cid, 
	    date_serv: obj.date_serv, 
	    time_serv: obj.time_serv, 
	    intime: obj.intime, 
	    clinic_id: obj.clinic_id,
			pttype_id: obj.pttype_id, 
			location_id: obj.location_id, 
			service_place_id: obj.service_place_id, 
			ins_id: obj.ins_id,
			ins_code: obj.ins_code, 
			hmain_code: obj.hmain_code, 
			hsub_code: obj.hsub_code, 
			ins_start: obj.ins_start, 
			ins_expire: obj.ins_expire,
			csrf_token: $.cookie('csrf_cookie_cloudhis')
		},
		success: function(data){
			if(data.success){
				window.location = _base_url + 'services';
			}else{
				REG.showAlert('Server Error!', 'เกิดข้อผิดพลาดในการส่งข้อมูล กรุณาตรวจสอบ ' , 'alert alert-error');
			}
		  
		},
		error: function(xhr, status, errorThrown){
			REG.showAlert('Server Error!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
	  }
	});
};

REG.doSearchPatient = function()
{
	var _query = $('input[data-rel="txtquery-search"]').val();
	
	if(_query.length == 0) {
		REG.showAlert('ข้อมูลไม่สมบูรณ์', 'กรุณากรอก <code> เลขบัตรประชาชน </code> ที่ต้องการค้นหา', 'alert alert-warning');
	}else{
		// get patient detail
	$.ajax({
		url: _base_url + 'people/detail',
		dataType: 'json',
		type: 'POST',
		
		data: 
		{
			cid: _query,
			csrf_token: $.cookie('csrf_cookie_cloudhis')
		},
		
		success: function(data)
		{
			if(data.length == 0) 
			{
				REG.showAlert('ไม่พบข้อมูล', 'กรุณากรอกเลขบัตรประชาชนที่ต้องการค้นหา', 'alert alert-error');
				$('div[data-rel="service-register-pt-detail"]').fadeOut('slow');
				$('a[data-rel="doclear"]').trigger('click');
			}
			else
			{
				var fullname = data[0].fname + ' ' + data[0].lname;

				REG.showAlert('ยินดีต้อนรับ', 'กรุณากรอกรายละเอียดการมารับบริการ', 'alert alert-success');

				$('input[data-rel="patient-name"]').val(fullname);
				$('input[data-rel="cid"]').val(data[0].cid);
				$('input[data-rel="birthdate"]').val(data[0].birthdate);

				$('div[data-rel="service-search-form"]').fadeOut('slow');
				$('div[data-rel="service-register-pt-detail"]').fadeIn('slow');
			}
		}
 	 	});
 	}	
};
//end registerServices()
$(function(){
	var date = new Date();

	time = date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
	day = date.getDate() + '/' + date.getMonth() + '/' + date.getFullYear();
	$('input[data-rel="date_serv"]').datepicker({
		dateFormat: 'd/m/yy'
	});
	$('input[data-rel="ins_start"]').datepicker({
		dateFormat: 'd/m/yy'
	});
	$('input[data-rel="ins_expire"]').datepicker({
		dateFormat: 'd/m/yy'
	});

	$('input[data-rel="time_serv"]').val(time);
	$('input[data-rel="date_serv"]').datepicker('setDate', date);

	//reset form and hide patient detail
	$('a[data-rel="doclear"]').click(function(){
		$('div[data-rel="service-register-pt-detail"]').fadeOut('slow');
		$('div[data-rel="service-search-form"]').fadeIn('slow');
		return true;
	});

	$('input[data-rel="txtquery-search"]').autocomplete({
		source: function(request, response){
			$.ajax({
	            url: _base_url + 'people/search',
	            dataType: 'json',
	            type: 'POST',
	            data: {
	                query: request.term,
	                csrf_token: $.cookie('csrf_cookie_cloudhis')
	            },
	            success: function(data){
	                response($.map(data, function(i){
	                    return {
	                        label: i.fname + ' ' + i.lname,
	                        value: i.cid
	                    }
	                }));
	            }
       	 	});
		},
		minLength: 2,
		select: function(event, ui){
			//$('input[name="hmaincode"]').val(ui.item.code);
		}
	});
	//search hospital name
	$('input[data-rel="hmainname"]').autocomplete({
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
			$('input[data-rel="hmain_code"]').val(ui.item.code);
		}
	});
	$('input[data-rel="hsubname"]').autocomplete({
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
			$('input[data-rel="hsub_code"]').val(ui.item.code);
		}
	});
	//autocomplete for insurances
	$('input[data-rel="insurance_name"]').autocomplete({
		source: function(request, response){
			$.ajax({
	            url: _base_url + 'insurances/search',
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
	                        code: i.id
	                    }
	                }));
	            },
	            error: function(xhr, status, errorThrown){

	            }
       	 	});
		},
		minLength: 2,
		select: function(event, ui){
			$('input[data-rel="ins_id"]').val(ui.item.code);
		}
	});

	$('a[data-rel="search-patient"]').click(function(){
		REG.doSearchPatient();
	});

	//form save register service click
	$('a[data-rel="doregister"]').click(function(){
		// check form for validation
		REG.doCheckForm();
	});
	
});