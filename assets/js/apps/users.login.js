var USER = {};

USER.checkLogin = function() 
{
  var _user_name = $('input[data-name="user_name"]').val(),
			_user_pass = $('input[data-name="user_pass"]').val();

	if ( _user_name.length == 0 ) 
	{
		alert('กรุณากรอกชื่อผู้ใช้งาน (User name)');
		$('button[data-name="btnuser-login"]').button('reset');
	} 
	else if ( _user_pass.length == 0 ) 
	{
		$('button[data-name="btnuser-login"]').button('reset');
		alert('กรุณากรอกรหัสผ่าน (Password)');
	} 
	else 
	{
		USER.doLogin( _user_name, _user_pass );
	}
};
/**
 * Logging in
 * @param {String} _u User name
 * @param {String} _p Password
 *
 **/
USER.doLogin = function( _u, _p ) {
  $.ajax({
		url: _base_url + '/users/login',
		dataType: 'json',
		type: 'POST',
		data: {
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			user_name: _u,
			user_pass: _p
		},
		success: function(data){
			if(data.success){
				$('button[data-name="btnuser-login"]').button('complete');
				// redirect to main page
				window.location = _base_url;
			}else{
				alert('ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบ');
				$('button[data-name="btnuser-login"]').button('reset');
			}
		},
		error: function(xhr, status, errorThrown){
			//toggleAlertEPI('เซิร์ฟเวอร์มีปัญหา!', 'เกิดข้อผิดพลาดในการส่งข้อมูล  : <code>' +  xhr.status + ': ' + xhr.statusText + '</code>' ,'alert alert-error');
			alert(xhr.status + ': ' + xhr.statusText);
			$('button[data-name="btnuser-login"]').button('reset');
	  }	
	});// ajax
};

$(function() {
	$('button[data-name="btnuser-login"]').click(function(){
		$(this).button('loading');
		USER.checkLogin();
	});
});