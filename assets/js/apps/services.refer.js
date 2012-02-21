$(function(){
	$('input[data-name="svrefer-search-patient-date"]').datepicker({
		dateFormat: 'd/m/yy'
	});
	$('input[data-name="svrefer-search-patient-date"]').datepicker('setDate', new Date());
	// display register detail
	$('button[data-name="svrefer-btn-get-register-detail"]').click(function(){
		$('div[data-name="svrefer-register-detail-panel"]').fadeIn('slow');
	});
	// hide register detail
	$('button[data-name="svrefer-btn-clear-register"]').click(function(){
		$('div[data-name="svrefer-register-detail-panel"]').fadeOut('slow');
	});
	
	$('input[data-name="svrefer-search-patient"]').autocomplete({
		source: function(request, response){
			$.ajax({
	            url: _base_url + 'refers/search_patient_service',
	            dataType: 'json',
	            type: 'POST',
	            data: {
	                query: request.term,
	                date_serv: $('input[data-name="svrefer-search-patient-date"]').val(),
	                csrf_token: $.cookie('csrf_cookie_cloudhis')
	            },
	            success: function(data){
								if (data.success) {
									response($.map(data.rows, function(i){
	                    return {
	                        label: i.cid + ' ' + i.patient_name,
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
			$('input[data-name="svrefer-cid"]').val(ui.item.cid);
			$('input[data-name="svrefer-vn"]').val(ui.item.vn);
			$('input[data-name="svrefer-dateserv"]').val(ui.item.date_serv);
		}
	});
})