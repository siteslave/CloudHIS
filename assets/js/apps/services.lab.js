$(function(){
	$('a[data-name="service-lab-order"]').click(function(){
		getLabGroupList();
	});
	
	// save lab order
	$('a[data-name="save-lab-order"]').click(function(){
		saveLabOrder();
	});
	// get order list
	$('a[data-name="service-lab-result"]').click(function(){
		$('table[data-name="svtbl-lab-item-list"] > tbody').empty();
		getLabOrderList();
	});
	// get items list
	$('button[data-name="svbtn-get-lab-items"]').click(function(){
		getLabItems();
	});
	
	var getLabGroupList = function(){
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
	},
	saveLabOrder = function() {
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
	},
	getLabOrderList = function() {
		$vn = _vn = $('input[data-name="vn"]').val();
		$.ajax({
			url: _base_url + 'lab/getorders',
      dataType: 'json',
      type: 'POST',
      data: {
      	vn: _vn,
        csrf_token: $.cookie('csrf_cookie_cloudhis')
      },
      success: function(data){
      	$('select[data-name="lab-order-list-result"]').empty();
				$.each(data.rows, function(i, v){
					$('select[data-name="lab-order-list-result"]').append(
						'<option value="' + v.id + '">' + v.name + '</option>'
					);
				});
      },
      error: function(xhr, status, errorThrown) {
				alert('Error: ' + xhr.status + '- ' + xhr.statusText);
			}
		});
	},
	getLabItems = function() {
		var _group_id = $('select[data-name="lab-order-list-result"]').val();
		$.ajax({
			url: _base_url + 'lab/getlabitems',
      dataType: 'json',
      type: 'POST',
      data: {
      	group_id: _group_id,
        csrf_token: $.cookie('csrf_cookie_cloudhis')
      },
      success: function(data){
      	if (data.success) {
      		$('table[data-name="svtbl-lab-item-list"] > tbody').empty();
						$.each(data.rows, function(i, v){
							var value = v.lab_result == null ? '0' : v.lab_result;
							
							$('table[data-name="svtbl-lab-item-list"] > tbody').append(
								'<tr>'
									+ '<td>' + v.name  + '</td>'
									+ '<td><input type="text" class="span1" name="item['+v.lab_item_id+']" value="' + value + '"></td>'
									+ '<td>' + v.lab_unit + '</td>'
								+ '</tr>'
							);
						});
      	} else {
      		alert(data.status);
      	}
      },
      error: function(xhr, status, errorThrown) {
				alert('ไม่พบข้อมูล \r\n Error: ' + xhr.status + '- ' + xhr.statusText);
			}
		});
	}
})