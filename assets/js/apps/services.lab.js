$(function(){
	$('a[data-name="service-lab-order"]').click(function(){
		// load order list
		$.ajax({
			url: _base_url + 'basic/getlaborders',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis')
      },
      success: function(data){
      	$('select[data-name="lab-group-list"]').empty();
				$.each(data, function(i, v){
					$('select[data-name="lab-group-list"]').append(
						'<option value="' + v.id + '">' + v.name + '</option>'
					);
				});
      },
      error: function(xhr, status, errorThrown) {
				alert('Error: ' + xhr.status + '- ' + xhr.statusText);
			}
		});
	});
	
	// save lab order
	$('a[data-name="save-lab-order"]').click(function(){
		var _vn = $('input[data-name="vn"]').val(),
		_group_id = $('select[data-name="lab-group-list"]').val();
		
		$.ajax({
			url: _base_url + 'services/dolaborder',
      dataType: 'json',
      type: 'POST',
      data: {
      	vn: _vn,
      	group_id: _group_id,
        csrf_token: $.cookie('csrf_cookie_cloudhis')
      },
      success: function(data){
				if(data.success) {
					alert('สั่ง Lab เรียบร้อยแล้ว');
					$('#modal-lab-order').modal('hide');
				} else {
					alert(data.status);
				}
      },
      error: function(xhr, status, errorThrown) {
				alert('Error: ' + xhr.status + '- ' + xhr.statusText);
			}
		});
	});
})