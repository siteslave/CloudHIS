var LAB = {};

LAB.getLabGroupList = function()
{
	// load order list
	$.ajax({
		url: _base_url + '/basic/getlaborders',
    dataType: 'json',
    type: 'POST',
    data: {
      csrf_token: $.cookie('csrf_cookie_cloudhis')
    },
    success: function(data){
      $('table[data-name="tblServiceLabOrderList"] > tbody').empty();

      $.each(data.rows, function(i, v){
        i++;
        $('table[data-name="tblServiceLabOrderList"] > tbody').append(
            '<tr>'
                + '<td>' + i + '</td>'
                + '<td>' + v.name + '</td>'
                + '<td>'
                + '<a href="#" class="btn btn-primary" data-name="laborder-selected" data-id="'+ v.id +'"><i class="icon-check icon-white"></i> สั่ง LAB</a>'
                + '</td>'
                + '</tr>'
        );
      });

      LAB.modal.showLabOrder();
    },
    error: function(xhr, status, errorThrown) {
			alert('Error: ' + xhr.status + '- ' + xhr.statusText);
		}
	});
};
	
LAB.saveLabOrder = function( vn, id )
{
	$.ajax({
		url: _base_url + '/services/dolaborder',
    dataType: 'json',
    type: 'POST',
    data: {
    	vn: vn,
    	group_id: id,
      csrf_token: $.cookie('csrf_cookie_cloudhis')
    },
    success: function(data){
			if(data.success) {
				alert('สั่ง Lab เรียบร้อยแล้ว');
				//$('#modal-lab-order').modal('hide');
				LAB.getOrderHistoryList();
			} else {
				alert(data.status);
			}
    },
    error: function(xhr, status, errorThrown) {
			alert('Error: ' + xhr.status + '- ' + xhr.statusText);
		}
	});
};
	
LAB.getLabOrderList = function( vn )
{
	$.ajax({
		url: _base_url + '/lab/getorders',
    dataType: 'json',
    type: 'POST',
    data: {
    	vn: vn,
      csrf_token: $.cookie('csrf_cookie_cloudhis')
    },
    success: function(data){
      $('table[data-name="tblServiceLabOrderForResult"] > tbody').empty();

      $.each(data.rows, function(i, v){
        i++;
        $('table[data-name="tblServiceLabOrderForResult"] > tbody').append(
            '<tr>'
                + '<td>' + i + '</td>'
                + '<td>' + v.name + '</td>'
                + '<td>'
                + '<a href="#" class="btn btn-primary" data-name="laborderresult-selected" data-vname="'+ v.name +'" data-id="'+ v.id +'"><i class="icon-check icon-white"></i> บันทึกผล</a>'
                + '</td>'
                + '</tr>'
        );
      });

      LAB.modal.showLabResult();
    },
    error: function(xhr, status, errorThrown) {
			alert('Error: ' + xhr.status + '- ' + xhr.statusText);
		}
	});
};

LAB.getLabItems = function( group_id )
{
	$.ajax({
		url: _base_url + '/lab/getlabitems',
    dataType: 'json',
    type: 'POST',
    data: {
    	group_id: group_id,
      csrf_token: $.cookie('csrf_cookie_cloudhis')
    },
    success: function(data){
    	if (data.success) {
    		$('table[data-name="tblServiceLabItemResultList"] > tbody').empty();
					$.each(data.rows, function(i, v){
						var value = v.lab_result == null ? '0' : v.lab_result;
						i++;
						$('table[data-name="tblServiceLabItemResultList"] > tbody').append(
							'<tr>'
								+ '<td>' + i  + '</td>'
								+ '<td>' + v.name  + '</td>'
								+ '<td><input type="text" data-name="lab-item-result" class="input-mini" data-item="'+v.id+'" value="' + value + '"></td>'
								+ '<td>' + v.lab_unit + '</td>'
								+ '<td>'
								+ '<a href="#" class="btn" data-name="remove-lab-order-item" data-id="'+ v.id +'" title="ลบรายการแล็ป"><i class="icon-trash"></i></a>'
								+ '</td>'
							+ '</tr>'
						);

            $('div[data-name="divSaveLabItemList"]').fadeIn('slow');
					});
    	} else {
				$('table[data-name="svtbl-lab-item-list"] > tbody').append(
					'<tr>'
						+ '<td colspan="5">ไม่พบประวัติการสั่ง LAB</td>'
					+ '</tr>'
				);
    	}
    },
    error: function(xhr, status, errorThrown) {
			alert('ไม่พบข้อมูล \r\n Error: ' + xhr.status + '- ' + xhr.statusText);
		}
	});
};
	
LAB.getOrderHistoryList = function()
{
	var _vn = $('input[data-name="vn"]').val();
	$.ajax({
		url: _base_url + '/lab/getorder_history',
    dataType: 'json',
    type: 'POST',
    
    data: 
    {
    	vn: _vn,
      csrf_token: $.cookie('csrf_cookie_cloudhis')
    },
    
    success: function(data)
    {
    	if (data.success) 
    	{
    		$('table[data-name="tblServiceLabOrderHistoryList"] > tbody').empty();
					$.each(data.rows, function(i, v){

            i++;

						$('table[data-name="tblServiceLabOrderHistoryList"] > tbody').append(
							'<tr>'
								+ '<td>' + i + '</td>'
								+ '<td>' + v.name + '</td>'
							+ '<td>'
							+ '<a href="#" class="btn" data-name="remove-lab-order" data-order="'+ v.id +'"><i class="icon-trash"></i></a>'
							+ '</td>'
							+ '</tr>'
						);
					});
    	} 
    	else 
    	{
				$('table[data-name="svtbl-lab-order-history"] > tbody').append(
					'<tr>'
						+ '<td colspan="5">ไม่พบประวัติการสั่ง LAB</td>'
					+ '</tr>'
				);
    	}
    },
    
    error: function(xhr, status, errorThrown) 
    {
			alert('Error: ' + xhr.status + '- ' + xhr.statusText);
		}
	});
};

LAB.doRemoveLabOrder = function( _id ) 
{
	$.ajax({
		url: _base_url + '/lab/removeorder',
    dataType: 'json',
    type: 'POST',
    
    data: 
    {
    	order_id: _id,
      csrf_token: $.cookie('csrf_cookie_cloudhis')
    },
    
    success: function(data){
    	if (data.success) {
    		// refresh list
    		//LAB.getOrderHistoryList();
    	} 
    	else 
    	{
    		alert(data.status);
    	}
    },
    error: function(xhr, status, errorThrown) 
    {
			alert('Error: ' + xhr.status + '- ' + xhr.statusText);
		}
	});
};
	
LAB.doRemoveLabOrderItem = function( _id ) 
{
	$.ajax({
		url: _base_url + '/lab/removeorder_item',
    dataType: 'json',
    type: 'POST',
    
    data: 
    {
    	id: _id,
      csrf_token: $.cookie('csrf_cookie_cloudhis')
    },
    
    success: function(data)
    {
    	if (data.success) 
    	{
    		alert('ลบรายการเรียบร้อยแล้ว');
    	} 
    	else 
    	{
    		alert(data.status);
    	}
    },
    
    error: function(xhr, status, errorThrown) 
    {
			alert('Error: ' + xhr.status + '- ' + xhr.statusText);
		}
	});
};
	
LAB.doLabResult = function( _id, _result ) 
{
	$.ajax({
		url: _base_url + '/lab/dolabresult',
    dataType: 'json',
    type: 'POST',
    data: {
    	id: _id,
    	result: _result,
      csrf_token: $.cookie('csrf_cookie_cloudhis')
    },
    success: function(data){
    	if (data.success) {
    		//console.log('บันทึกผลเรียบร้อย');
    	} else {
    		alert('เกิดข้อผิดพลาด\r\n' + data.status);
    		console.log(data.status);
    	}
    },
    error: function(xhr, status, errorThrown) {
			alert('Error: ' + xhr.status + '- ' + xhr.statusText);
		}
	});
};

LAB.modal = {
  showLabResult: function() {
    $('div[data-name="mdlServiceLabResult"]').modal('show').css({
      width: 640,
      'margin-left': function () {
        return -($(this).width() / 2);
      }
    });
  },
  showLabOrder: function() {
    $('div[data-name="mdlServiceLabOrder"]').modal('show').css({
      width: 640,
      'margin-left': function () {
        return -($(this).width() / 2);
      }
    });
  }
};

$(function(){

  //hide lab item
  $('a[data-name="btnHideDivLabItemResult"]').click(function(){
    $('div[data-name="divSaveLabItemList"]').fadeOut('slow');
    $('div[data-name="divServiceLabVisitGroup"]').fadeToggle('slow');
  });

	$('a[data-name="btnLabOrder"]').click(function(){
		LAB.getOrderHistoryList();
		LAB.getLabGroupList();
	});
	
	// save lab order
	$('a[data-name="laborder-selected"]').live('click',function(){
    var group_id = $(this).attr('data-id'),
        vn = $('input[data-name="vn"]').val();
		LAB.saveLabOrder( vn, group_id );
	});
	// get order list
	$('a[data-name="btnLabResult"]').click(function(){
    var vn = $('input[data-name="vn"]').val();
		LAB.getLabOrderList( vn );
	});

	// get items list
	$('a[data-name="laborderresult-selected"]').live('click',function(){
    var group_id = $(this).attr('data-id'),
        name = $(this).attr('data-vname');

    $('div[data-name="divServiceLabVisitGroup"]').fadeToggle('slow');
    $('span[data-name="spanLabName"]').html(name);
		LAB.getLabItems( group_id );
	});
	//remove lab order
	$('a[data-name="remove-lab-order"]').live('click', function() {
		var _id = $(this).attr("data-order");
		if ( confirm( 'คุณต้องการลบรายการนี้ใช่หรือไม่?' )  ) {
			LAB.doRemoveLabOrder( _id);
			$(this).parent().parent().remove();
		}
	} );
	//remove lab order item
	$('a[data-name="remove-lab-order-item"]').live('click', function() {
		var _id = $(this).attr("data-id");
		
		if ( confirm( 'คุณต้องการลบรายการนี้ใช่หรือไม่?') ) {
			LAB.doRemoveLabOrderItem( _id);
			$(this).parent().parent().remove();
		}
	});
	// save lab result
	$('input[data-name="lab-item-result"]').live('focusout', function(){
		var _result = $(this).val(),
		_id = $(this).attr('data-item');
		
		// save result
		LAB.doLabResult(_id, _result);	
	});
});