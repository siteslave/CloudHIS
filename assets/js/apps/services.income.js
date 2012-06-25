var INCOME = {};

INCOME.doSave = function( items ) {

	$.ajax({
		url: _base_url + 'services/doincome',
		dataType: 'json',
		type: 'POST',
		
		data: {
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			vn: items.vn,
			income_id: items.income_id,
			price: items.price,
			qty: items.qty
		},
		
		success: function(data)
		{
			if(data.success)
			{
        alert('บันทึกข้อมูลเรียบร้อยแล้ว');

        INCOME.getList();

        $('div[data-name="modal-income"]').modal('hide');
			}
			else
			{
				alert('เกิดข้อผิดพลาด: ' + data.msg);
			}
		  
		},
		error: function(xhr, status, errorThrown){
      alert('Server error: '  + xhr.status + ': ' + xhr.statusText );
	  }	
	});
};

INCOME.doUpdate = function( items ) {

  $.ajax({
    url: _base_url + 'services/doupdate_income',
    dataType: 'json',
    type: 'POST',

    data: {
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      id: items.id,
      income_id: items.income_id,
      price: items.price,
      qty: items.qty
    },

    success: function(data)
    {
      if(data.success)
      {
        alert('บันทึกข้อมูลเรียบร้อยแล้ว');
        INCOME.getList();
        $('div[data-name="modal-income"]').modal('hide');
      }
      else
      {
        alert('เกิดข้อผิดพลาด: ' + data.msg);
      }

    },
    error: function(xhr, status, errorThrown){
      alert('Server error: '  + xhr.status + ': ' + xhr.statusText );
    }
  });
};

INCOME.doRemove = function( id ) {
	$.ajax({
		url: _base_url + 'services/remove_income',
		dataType: 'json',
		type: 'POST',
		
		data: {
			csrf_token: $.cookie('csrf_cookie_cloudhis'),
			id: id
		},
		
		success: function(data){
			if(data.success){
        alert('ลบรายการเรียบร้อยแล้ว');
        INCOME.getList();

			}else{
        alert('เกิดข้อผิดพลาด: ' + data.msg);
			}
		},
		error: function(xhr, status, errorThrown){
      alert('Server error: '  + xhr.status + ': ' + xhr.statusText );
	  }
	});
};

INCOME.showSearchIncome= function()
{
  $('div[data-name="mdlSearchIncome"]').modal('show').css({
    width: 640,
    'margin-left': function () {
      return -($(this).width() / 2);
    }
  });
};
INCOME.showIncome = function() {
  $('div[data-name="modal-income"]').modal('show').css({
    width: 700,
    'margin-left': function () {
      return -($(this).width() / 2);
    }
  });
};

INCOME.doSearch = function( query )
{
  $.ajax({
    url: _base_url + 'basic/search_income',
    dataType: 'json',
    type: 'POST',
    data: {
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      query: query
    },

    success: function(data){

      $('table[data-name="tblIncomeSearchResult"] > tbody').empty();

      $.each(data.rows, function(i, v){
        i++;
        $('table[data-name="tblIncomeSearchResult"] > tbody').append(
            '<tr>'
                + '<td>' + i + '</td>'
                + '<td>' + v.name + '</td>'
                + '<td>' + v.price + '</td>'
                + '<td>' + v.unit + '</td>'
                + '<td>'
                + '<a href="#" class="btn" data-price="'+ v.price +'" data-name="income-selected" data-vname="'+ v.name +'" data-id="'+ v.id +'"><i class="icon-check"></i></a>'
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

INCOME.getList = function()
{
  var vn = $('input[data-name="vn"]').val();

  $.ajax({
    url: _base_url + 'services/get_visit_income',
    dataType: 'json',
    type: 'POST',
    data: {
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      vn: vn
    },

    success: function(data){

      $('table[data-name="tblIncomeList"] > tbody').empty();

      $.each(data.rows, function(i, v){
        i++;
        var total = parseFloat(v.price) * parseFloat(v.qty);
        $('table[data-name="tblIncomeList"] > tbody').append(
            '<tr>'
                + '<td>' + i + '</td>'
                + '<td>' + v.name + '</td>'
                + '<td>' + v.unit + '</td>'
                + '<td>' + addCommas(v.price) + '</td>'
                + '<td>' + v.qty + '</td>'
                + '<td>' + addCommas(total) + '</td>'
                + '<td>'
                + '<a href="#" title="แก้ไข" class="btn" data-vname="'+ v.name +'" data-price="'+ v.price +'" data-qty="'+ v.qty+'" data-name="income-edit" data-income="'+ v.income_id+'" data-id="'+ v.id +'"><i class="icon-edit"></i></a>'
                + ' <a href="#" title="ลบทิ้ง" class="btn" data-name="income-remove" data-id="'+ v.id +'"><i class="icon-trash"></i></a>'
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


$(function(){

  // show search
  $('button[data-name="btnIncomeSearch"]').click(function(){
    INCOME.showSearchIncome();
  });

  $('button[data-name="btnDoSearchIncome"]').click(function(){
    var query = $('input[data-name="txtIncomeSearchQuery"]').val();
    if(!query){
      alert('กรุณาพิมพ์ข้อความที่ต้องการค้นหา');
    }else{
      //do search
      INCOME.doSearch( query );
    }
  });

  $('a[data-name="income-selected"]').live('click', function(){
    var price = $(this).attr('data-price'),
        id = $(this).attr('data-id'),
        name = $(this).attr('data-vname');

    $('input[data-name="txtIncomePrice"]').val(price);
    $('input[data-name="txtIncomeQty"]').val('1');
    $('input[data-name="txtIncomeName"]').val(name);
    $('input[data-name="txtIncomeId"]').val(id);
    $('div[data-name="mdlSearchIncome"]').modal('hide');

  });

  $('a[data-name="btnSaveIncome"]').click(function(){
    var items = {};
    items.vn = $('input[data-name="vn"]').val();
    items.income_id = $('input[data-name="txtIncomeId"]').val();
    items.price = $('input[data-name="txtIncomePrice"]').val();
    items.qty = $('input[data-name="txtIncomeQty"]').val();

    if(!items.vn){
      alert('ไม่พบรหัสการรับบริการ (VN)');
    }else if(!items.income_id){
      alert('ไม่พบรหัสค่าใช้จ่าย');
    }else if(!items.price){
      alert('กรุณากำหนดราคาค่าใช้จ่าย');
    }else if(!items.qty){
      alert('กรุณากำหนดจำนวนของค่าใช้จ่าย อย่างน้อย 1');
    }else{
      var update_id = $('input[data-name="txtIncomeUpdateId"]').val();
      if(update_id){
        items.id = update_id;
        INCOME.doUpdate(items);
      }else{
        // do save
        INCOME.doSave( items );
      }
    }
  });

  $('a[data-name="btnTabIncome"]').click(function(){
    INCOME.getList();
  });

  $('a[data-name="income-edit"]').live('click', function(){
    var items = {};
    items.id = $(this).attr('data-id'),
    items.name = $(this).attr('data-vname'),
    items.price = $(this).attr('data-price'),
    items.income_id = $(this).attr('data-income'),
    items.qty = $(this).attr('data-qty');

    $('input[data-name="txtIncomeUpdateId"]').val( items.id );
    $('input[data-name="txtIncomeName"]').val(items.name);
    $('input[data-name="txtIncomeId"]').val(items.income_id);
    $('input[data-name="txtIncomeQty"]').val(items.qty);
    $('input[data-name="txtIncomePrice"]').val(items.price);

    INCOME.showIncome();
  });

  $('div[data-name="modal-income"]').on('hide', function(){
    $('input[data-name="txtIncomeUpdateId"]').val('');
    $('input[data-name="txtIncomeName"]').val('');
    $('input[data-name="txtIncomeId"]').val('');
    $('input[data-name="txtIncomeQty"]').val('');
    $('input[data-name="txtIncomePrice"]').val('');
  });

  $('a[data-name="income-remove"]').live('click', function(){
    var id = $(this).attr('data-id');

    if(confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')){
      INCOME.doRemove( id );
    }
  });
});