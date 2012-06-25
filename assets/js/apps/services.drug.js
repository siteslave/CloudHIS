var Drug = {};

Drug.showSearchDrug = function()
{
  $('div[data-name="mdlDoSearchDrug"]').modal('show').css({
    width: 770,
    'margin-left': function () {
      return -($(this).width() / 2);
    }
  });
};
Drug.showSearchUsage = function()
{
  $('div[data-name="mdlDoSearchUsage"]').modal('show').css({
    width: 640,
    'margin-left': function () {
      return -($(this).width() / 2);
    }
  });
};
Drug.showNewUsage = function()
{
  $('div[data-name="mdlNewUsage"]').modal('show').css({
    width: 700,
    'margin-left': function () {
      return -($(this).width() / 2);
    }
  });
};

Drug.showMainDrug = function() {
  $('div[data-name="mdlSearchDrug"]').modal('show').css({
    width: 770,
    'margin-left': function () {
      return -($(this).width() / 2);
    }
  });
};


Drug.doSearchDrug = function( query )
{
  $.ajax({
    url: _base_url + 'basic/search_drug',
    dataType: 'json',
    type: 'POST',
    data: {
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      query: query
    },

    success: function(data){

      $('table[data-name="tblDrugSearchResultList"] > tbody').empty();

      $.each(data.rows, function(i, v){
        i++;
        $('table[data-name="tblDrugSearchResultList"] > tbody').append(
            '<tr>'
                + '<td>' + i + '</td>'
                + '<td>' + v.name + '</td>'
                + '<td>' + v.units + '</td>'
                + '<td>' + v.strength + '</td>'
                + '<td>' + v.unitprice + '</td>'
                + '<td>'
                + '<a href="#" class="btn" data-name="drugsearch-selected" data-unitprice="'+ v.unitprice+'" data-vname="'+ v.name +'" data-id="'+ v.id +'"><i class="icon-check"></i></a>'
                + '</td>'
                + '</tr>'
        );
      });

    },
    error: function(xhr, status, errorThrown){
      alert('Server error: '  + xhr.status + ': ' + xhr.statusText );
    }
  });
};

Drug.doSearchUsage = function( query )
{
  $.ajax({
    url: _base_url + 'basic/search_usage',
    dataType: 'json',
    type: 'POST',
    data: {
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      query: query
    },

    success: function(data){

      $('table[data-name="tblUsageSearchResultList"] > tbody').empty();

      $.each(data.rows, function(i, v){
        i++;
        $('table[data-name="tblUsageSearchResultList"] > tbody').append(
            '<tr>'
                + '<td>' + i + '</td>'
                + '<td>' + v.name1 + '</td>'
                + '<td>' + v.name2 + '</td>'
                + '<td>'
                + '<a href="#" class="btn" data-name="usagesearch-selected" data-vname="'+ v.name1 +' ' + v.name2 +'" data-id="'+ v.id +'"><i class="icon-check"></i></a>'
                + '</td>'
                + '</tr>'
        );
      });

    },
    error: function(xhr, status, errorThrown){
      alert('Server error: '  + xhr.status + ': ' + xhr.statusText );
    }
  });
};


Drug.doSaveUsage = function( items )
{
  $.ajax({
    url: _base_url + 'services/dosave_usage',
    dataType: 'json',
    type: 'POST',
    data: {
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      name1: items.name1,
      name2: items.name2
    },

    success: function(data){
      alert('เพิ่มวิธีการใช้ยาใหม่เสร็จเรียร้อยแล้ว');

      $('input[data-name="txtNewUsageName1"]').val('');
      $('input[data-name="txtNewUsageName2"]').val('');

      $('div[data-name="mdlNewUsage"]').modal('hide');
    },
    error: function(xhr, status, errorThrown){
      alert('Server error: '  + xhr.status + ': ' + xhr.statusText );
    }
  });
};

Drug.doSave = function( items )
{
	$.ajax({
		url: _base_url + 'services/dodrug',
		dataType: 'json',
		type: 'POST',
		data: {
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			vn: items.vn,
			drug_id: items.drug_id,
			price: items.price,
			qty: items.qty,
			usage_id: items.usage_id
		},
		success: function(data){
			if(data.success){
        alert('บันทึกข้อมูลเสร็จเรียบร้อยแล้ว');
        Drug.getVisitList();
        $('div[data-name="mdlSearchDrug"]').modal('hide');

			}else{
        alert('เกิดข้อผิดพลาดในการบันทึก: ' + data.msg );
			}
		},
		error: function(xhr, status, errorThrown){
      alert('Server error: '  + xhr.status + ': ' + xhr.statusText );
	  }	
	});// ajax
};

Drug.doRemove = function( id )
{
	$.ajax({
		url: _base_url + 'services/remove_drug',
		dataType: 'json',
		type: 'POST',
		
		data: 
		{
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			id: id
		},
		
		success: function(data)
		{
			if(data.success)
			{
				alert('ลบรายการเสร็จเรียบร้อยแล้ว');
        Drug.getVisitList();
			}
			else
			{
				alert('เกิดข้อผิดพลาดในการลบข้อมูล : ' + data.msg );
			}
		},
		
		error: function(xhr, status, errorThrown)
		{
      alert('Server error: '  + xhr.status + ': ' + xhr.statusText );
	  }	
	});
};

Drug.doUpdate = function( items )
{
  $.ajax({
    url: _base_url + 'services/update_drug',
    dataType: 'json',
    type: 'POST',

    data:
    {
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      id: items.id,
      usage_id: items.usage_id,
      drug_id: items.drug_id,
      price: items.price,
      qty: items.qty
    },

    success: function(data)
    {
      if(data.success)
      {
        alert('ปรับปรุงรายการเรียบร้อยแล้ว');
        $('div[data-name="mdlSearchDrug"]').modal('hide');
        Drug.getVisitList();
      }
      else
      {
        alert('เกิดข้อผิดพลาดในการปรับปรุงข้อมูล : ' + data.msg );
      }
    },

    error: function(xhr, status, errorThrown)
    {
      alert('Server error: '  + xhr.status + ': ' + xhr.statusText );
    }
  });
};

Drug.getVisitList = function(){
  var vn = $('input[data-name="vn"]').val();

  $.ajax({
    url: _base_url + 'services/get_visit_drug',
    dataType: 'json',
    type: 'POST',
    data: {
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      vn: vn
    },

    success: function(data){

      $('table[data-name="tblDrug"] > tbody').empty();

      $.each(data.rows, function(i, v){
        var total = parseFloat(v.price) * parseFloat(v.qty);
        i++;
        $('table[data-name="tblDrug"] > tbody').append(
          '<tr>'
            + '<td>' + i + '</td>'
            + '<td>' + v.drug_name + '</td>'
            + '<td>' + v.name1 + ' ' + v.name2 + '</td>'
            + '<td>' + addCommas(v.price) + '</td>'
            + '<td>' + addCommas(v.qty) + '</td>'
            + '<td>' + addCommas(total) + '</td>'
            + '<td>'
            + '<a href="#" class="btn" title="แก้ไข" data-name="drug-edit" data-id="'+ v.id +'"><i class="icon-edit"></i></a>'
            + ' <a href="#" class="btn" title="ลบทิ้ง" data-name="drug-remove" data-id="'+ v.id +'"><i class="icon-trash"></i></a>'
            + '</td>'
            + '</tr>'
        );
      });

    },
    error: function(xhr, status, errorThrown){
      alert('Server error: '  + xhr.status + ': ' + xhr.statusText );
    }
  });
};

Drug.getDetail = function( id ){
  $.ajax({
    url: _base_url + 'services/get_visit_drug_detail',
    dataType: 'json',
    type: 'POST',
    data: {
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      id: id
    },

    success: function(data){
      $.each(data.rows, function(i, v){
        $('input[data-name="txtDrugId"]').val(v.drug_id);
        $('input[data-name="txtDrugName"]').val(v.drug_name);
        $('input[data-name="txtUsageId"]').val(v.usage_id);
        $('input[data-name="txtUsageName"]').val(v.name1 + ' ' + v.name2);
        $('input[data-name="txtDrugPrice"]').val(v.price);
        $('input[data-name="txtDrugQty"]').val(v.qty);
      });
    },
    error: function(xhr, status, errorThrown){
      alert('Server error: '  + xhr.status + ': ' + xhr.statusText );
    }
  });
};

$(function() {

  $('button[data-name="btnSearchDrug"]').click(function(){
    $('input[data-name="drug_id"]').val('');
    Drug.showSearchDrug();
  });

  $('button[data-name="btnSearchUsage"]').click(function(){
    Drug.showSearchUsage();
  });

  // search
  $('button[data-name="btnDoSearchDrug"]').click(function(){
    var query = $('input[data-name="txtDrugSearchQuery"]').val();

    if(!query){
      alert('กรุณาพิมพ์คำที่ต้องการค้นหาใหม่');
    }else{
      Drug.doSearchDrug( query );
    }
  });
  // search usage
  $('button[data-name="btnDoSearchUsage"]').click(function(){
    var query = $('input[data-name="txtUsageSearchQuery"]').val();

    if(!query){
      alert('กรุณาพิมพ์คำที่ต้องการค้นหาใหม่');
    }else{
      Drug.doSearchUsage( query );
    }
  });

  $('a[data-name="drugsearch-selected"]').live('click', function(){
    var id = $(this).attr('data-id'),
        name = $(this).attr('data-vname'),
        price = $(this).attr('data-unitprice');

    $('input[data-name="txtDrugId"]').val( id );
    $('input[data-name="txtDrugName"]').val( name );
    $('input[data-name="txtDrugPrice"]').val( price );
    $('div[data-name="mdlDoSearchDrug"]').modal('hide');
  });

  $('a[data-name="usagesearch-selected"]').live('click', function(){
    var id = $(this).attr('data-id'),
        name = $(this).attr('data-vname');

    $('input[data-name="txtUsageId"]').val( id );
    $('input[data-name="txtUsageName"]').val( name );
    $('div[data-name="mdlDoSearchUsage"]').modal('hide');
  });

  // add new usage
  $('a[data-name="btnNewUsageDetail"]').click(function(){
    Drug.showNewUsage();
  });

  // do save new usage
  $('a[data-name="btnDoSaveNewUsage"]').click(function(){
    var items = {};
    items.name1 = $('input[data-name="txtNewUsageName1"]').val(),
    items.name2 = $('input[data-name="txtNewUsageName2"]').val();

    if(!items.name1){
      alert('กรุณากรอกช่อง ชื่อ 1');
    }else if(!items.name2){
      alert('กรุณากรอกช่อง ชื่อ 2');
    }else{
      Drug.doSaveUsage( items );
    }
  });

  // save drug
  $('a[data-name="btnDoSaveDrug"]').click(function(){
    var items = {};
    items.drug_id = $('input[data-name="txtDrugId"]').val(),
    items.usage_id = $('input[data-name="txtUsageId"]').val(),
    items.price = $('input[data-name="txtDrugPrice"]').val(),
    items.qty = $('input[data-name="txtDrugQty"]').val();
    items.vn = $('input[data-name="vn"]').val();

    if(!items.drug_id) {
      alert('กรุณากำหนดชื่อยาที่ต้องการจ่าย');
    }else if(!items.usage_id){
      alert('กรุณากำหนดวิธีการใช้ยา');
    }else if(!items.price){
      alert('กรุณากำหนดราคา');
    }else if(!items.qty){
      alert('กรุณากำหดจำนวน');
    }else{
      var id = $('input[data-name="drug_id"]').val();
      if(!id){
        Drug.doSave( items );
      }else{
        items.id = id;
        Drug.doUpdate( items );
      }

    }
  });

  $('a[data-name="btnTabDrug"]').click(function(){
    Drug.getVisitList();
  });

  // remove drug
  $('a[data-name="drug-remove"]').live('click', function(){
    var id = $(this).attr('data-id');

    if(confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')){
      Drug.doRemove( id );
    }

  });

  $('a[data-name="drug-edit"]').live('click', function(){
    var id = $(this).attr('data-id');
    $('input[data-name="drug_id"]').val(id);
    // show edit
    Drug.getDetail( id );
    Drug.showMainDrug();
  });

  $('div[data-name="mdlSearchDrug"]').on('hidden', function(){
    $('input[data-name="drug_id"]').val('');
    $('input[data-name="txtDrugId"]').val('');
    $('input[data-name="txtDrugName"]').val('');
    $('input[data-name="txtUsageId"]').val('');
    $('input[data-name="txtUsageName"]').val('');
    $('input[data-name="txtDrugPrice"]').val('');
    $('input[data-name="txtDrugQty"]').val('');
  });
});