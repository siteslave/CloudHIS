$(function() {

  $( 'input[data-name="house-person-new-movein-date"]' ).datepicker({
    dateFormat: 'd/m/yy',
    changeMonth: true,
    changeYear: true
  });
  $( 'input[data-name="house-person-new-discharge-date"]' ).datepicker({
    dateFormat: 'd/m/yy',
    changeMonth: true,
    changeYear: true
  });
  $( 'input[data-name="house-person-new-birthdate"]' ).datepicker({
    dateFormat: 'd/m/yy',
    changeMonth: true,
    changeYear: true
  });
  var House = {};
  
  /**
   * Select house list
   **/
  House.getList = function( village_code )
  {
    $.ajax({
			url: _base_url + 'house/get_house',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
        village_code: village_code
      },
      success: function(data){
      	$('select[data-name="house-sel-house"]').empty();
        
				$.each(data.rows, function(i, v){
					$('select[data-name="house-sel-house"]').append(
						'<option value="' + v.id + '">' + v.address + '</option>'
					);
				});
      },
      error: function(xhr, status, errorThrown) {
				alert('Error: ' + xhr.status + '- ' + xhr.statusText);
			}
		});
  };
  /**
   * Get people list
   **/
  House.getPeopleList = function( house_id )
  {
    $.ajax({
			url: _base_url + 'people/getlist',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
        house_id: house_id
      },
      success: function(data){
				if ( data.success )
				{
					$( 'table[data-name="house-tbl-people-list"] > tbody' ).empty();
					$( 'a[data-name="house-btn-add-person-to-house"]' ).fadeIn( 'slow' );
										
					$.each(data.rows, function(i, v){
						var fullname = v.fname + ' ' + v.lname,
						sex = v.sex == '1' ? 'ชาย' : 'หญิง';
						
						$( 'table[data-name="house-tbl-people-list"] > tbody' ).append(
								'<tr>'
									+ '<td>' + v.cid  + '</td>'
									+ '<td>' + fullname + '</td>'
									+ '<td>' + sex + '</td>'
									+ '<td>' + toThaiDate( v.birthdate ) + '</td>'
									+ '<td>' + v.age + '</td>'
									+ '<td>'
									+ '<a href="#" class="btn" data-name="detail-person" data-cid="'+ v.cid +'"><i class="icon-edit"></i></a>'
									+ '</td>'
								+ '</tr>'																														 
						);
						
					});
				}
				else
				{
					$( 'table[data-name="house-tbl-people-list"] > tbody' ).empty();
					$( 'a[data-name="house-btn-add-person-to-house"]' ).fadeOut( 'slow' );
				
					$( 'table[data-name="house-tbl-people-list"] > tbody' ).append(
							'<tr>'
								+ '<td colspan="6">ไม่พบรายการ</td>'
							+ '</tr>'																														 
					);
				}
      },
      error: function(xhr, status, errorThrown) {
				$( 'table[data-name="house-tbl-people-list"] > tbody' ).empty();
				
					$( 'a[data-name="house-btn-add-person-to-house"]' ).fadeOut( 'slow' );
					
					$( 'table[data-name="house-tbl-people-list"] > tbody' ).append(
							'<tr>'
								+ '<td colspan="6">ไม่สามารถแสดงรายการได้ : การเชื่อมต่อมีปัญหา</td>'
							+ '</tr>'																														 
					);
			}
		});
  };
  /**
   * Select house list
   **/
  House.getList = function( village_code )
  {
    $.ajax({
			url: _base_url + 'house/get_house',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
        village_code: village_code
      },
      success: function(data){
      	$('select[data-name="house-sel-house"]').empty();
        
				$.each(data.rows, function(i, v){
					$('select[data-name="house-sel-house"]').append(
						'<option value="' + v.id + '">' + v.address + '</option>'
					);
				});
      },
      error: function(xhr, status, errorThrown) {
				alert('Error: ' + xhr.status + '- ' + xhr.statusText);
			}
		});
  };
	
	/**
	 * Get house list
	 *
	 * @param {String} village_code Village code
	 *
	 **/
	House.getHouseList = function ( village_code )
	{
    $.ajax({
			url: _base_url + 'house/get_house_list',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
        village_code: village_code
      },
      success: function(data){
				
				if( data.success )
				{
					// set data
					var x = 1;
					$( 'table[data-name="house-tbl-address-list"] > tbody' ).empty();
					
					$.each(data.rows, function(i, v){
						$( 'table[data-name="house-tbl-address-list"] > tbody' ).append(
							'<tr>'
								+ '<td>' + x + '</td>'
								+ '<td>' + v.address + '</td>'
								+ '<td>' + v.m + '</td>'
								+ '<td>' + v.f + '</td>'
								+ '<td>' + v.total + '</td>'
								+ '<td>'
								+ '<a href="#" class="btn" data-name="detail-house" data-id="'+ v.id +'"><i class="icon-edit"></i></a>'
								+ '</td>'
							+ '</tr>'																														 
						);
						x++;
					});

						// show house list
					House.modal.showHouse();
				}
				else
				{
					$( 'table[data-name="house-tbl-address-list"] > tbody' ).empty();
					alert( data.statusText );
				}
      },
      error: function(xhr, status, errorThrown) {
				alert('Error: ' + xhr.status + '- ' + xhr.statusText);
				$( 'table[data-name="house-tbl-address-list"] > tbody' ).empty();
			}
		});
	};
	/**
	 * Save new person
	 *
	 * @param {Mixed} ojb Person detail
	 **/
	House.savePerson = function( obj )
	{
    $.ajax({
			url: _base_url + 'people/dosave',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
				cid: obj.cid,
				fname: obj.fname,
				lname: obj.lname,
				sex: obj.sex,
				birthdate: obj.birthdate,
				blood_group_id: obj.blood_group_id,
				marry_status_id: obj.marry_status_id,
				title_id: obj.title_id,
				address: obj.address,
				house_id: obj.house_id,
				occupation_id: obj.occupation_id,
				race_id: obj.race_id,
				nation_id: obj.nation_id,
				religion_id: obj.religion_id,
				education_id: obj.education_id,
				family_status: obj.family_status_id,
				father_cid: obj.father_cid,
				mother_cid: obj.mother_cid,
				couple_cid: obj.couple_cid,
				move_in_date: obj.move_in_date,
				discharge_status_id: obj.discharge_status_id,
				discharge_date: obj.discharge_date,
				labor_id: obj.labor_id,				
				village_code: obj.village_code,
				type_area_id: obj.type_area_id
      },
      success: function(data){
				
				if( data.success )
				{
					alert( 'บันทึกข้อมูลเรียบร้อยแล้ว' );
					$( 'input[data-name="house-btn-new-reset"]' ).trigger( 'click' );
					$( 'div[data-name="house-modal-new-person"]' ).modal('hide');
				}
				else
				{
					alert( data.statusText );
				}
      },
      error: function(xhr, status, errorThrown) {
				alert('Error: ' + xhr.status + '- ' + xhr.statusText);
			}
		});
	}
	
  // get address
  $( 'select[data-name="house-sel-village"]' ).change(function(){
    var village_code = $( this ).val();
		
		$( 'table[data-name="house-tbl-people-list"] > tbody' ).empty();
		
    House.getList( village_code );
  });
  
  // get people list
  $( 'button[data-name="house-btn-get-people-list"]' ).click(function(){
		var house_id = $( 'select[data-name="house-sel-house"]' ).val();
		
		if ( ! house_id )
		{
			alert( 'กรุณาเลือกหลังคาเรือน' );
		}
		else
		{
			House.getPeopleList( house_id );
		}
     
  });
	$('select[data-name="house-sel-house"]').live( 'change', function(){
		var house_id = $( this ).val();
		
		if ( ! house_id )
		{
			alert( 'กรุณาเลือกหลังคาเรือน' );
		}
		else
		{
			House.getPeopleList( house_id );
		}
	});
	
	// save new person
	$( 'a[data-name="house-btn-save-new-person"]' ).click(function(){
		person = new Object();
		
		person.cid = $( 'input[data-name="house-person-new-cid"]' ).val();
		person.fname = $( 'input[data-name="house-person-new-fname"]' ).val();
		person.lname = $( 'input[data-name="house-person-new-lname"]' ).val();
		person.sex = $( 'select[data-name="house-person-new-sex"]' ).val();
		person.birthdate = $( 'input[data-name="house-person-new-birthdate"]' ).val();
		person.blood_group_id = $( 'select[data-name="house-person-new-blood-group"]' ).val();
		person.marry_status_id = $( 'select[data-name="house-person-new-marry"]' ).val();
		person.title_id = $( 'select[data-name="house-person-new-title"]' ).val();
		person.address = $( 'input[data-name="house-person-new-address"]' ).val();
		person.house_id = $( 'select[data-name="house-sel-house"]' ).val();
		person.occupation_id = $( 'select[data-name="house-person-new-occupation"]' ).val();
		person.race_id = $( 'select[data-name="house-person-new-race"]' ).val();
		person.nation_id = $( 'select[data-name="house-person-new-nation"]' ).val();
		person.religion_id = $( 'select[data-name="house-person-new-religion"]' ).val();
		person.education_id = $( 'select[data-name="house-person-new-education"]' ).val();
		person.family_status_id = $( 'select[data-name="house-person-new-fstatus"]' ).val();
		person.father_cid = $( 'input[data-name="house-person-new-father-cid"]' ).val();
		person.mother_cid = $( 'input[data-name="house-person-new-mother-cid"]' ).val();
		person.couple_cid = $( 'input[data-name="house-person-new-couple-cid"]' ).val();
		person.move_in_date = $( 'input[data-name="house-person-new-movein-date"]' ).val();
		person.discharge_status_id = $( 'select[data-name="house-person-new-discharge-status"]' ).val();
		person.discharge_date = $( 'input[data-name="house-person-new-discharge-status-date"]' ).val();
		person.labor_id = $( 'select[data-name="house-person-new-labor"]' ).val();
		person.chw = $( 'select[data-name="house-person-new-chw"]' ).val();
		person.amp = $( 'select[data-name="house-person-new-amp"]' ).val();
		person.tmb = $( 'select[data-name="house-person-new-tmb"]' ).val();
		person.moo = $( 'select[data-name="house-person-new-moo"]' ).val();
		
		person.village_code = person.chw + person.amp + person.tmb + person.moo;
		
		person.type_area_id = $( 'select[data-name="house-person-new-typearea"]' ).val();
	
		// check data
		
		if ( ! person.cid )
		{
			alert( 'ไม่พบเลขบัตรประชาชน' );
		}
		else if ( ! person.fname )
		{
			alert( 'ไม่พบชื่อ' );
		}
		else if ( ! person.lname )
		{
			alert( 'ไม่พบนามสกุล' );
		}
		else if ( ! person.birthdate )
		{
			alert( 'ไม่พบวันเกิด' );
		}
		else if ( ! person.move_in_date )
		{
			alert( 'ไม่พบวันที่ย้ายเข้า' );
		}
		else if ( ! person.address )
		{
			alert( 'ไม่พบบ้านเลขที่ตามทะเบียนบ้าน' );
		}
		else if ( ! person.chw )
		{
			alert( 'ไม่พบ จังหวัด ตามทะเบียนบ้าน' );
		}
		else if ( ! person.amp )
		{
			alert( 'ไม่พบ อำเภอ ตามทะเบียนบ้าน' );
		}
		else if ( ! person.tmb )
		{
			alert( 'ไม่พบ ตำบล ตามทะเบียนบ้าน' );
		}
		else if ( ! person.moo )
		{
			alert( 'ไม่พบ หมู่บ้าน ตามทะเบียนบ้าน' );
		}
		else
		{
			// data complete do save
			House.savePerson( person );
		}
	});
	// get house list
	$( 'a[data-name="house-btn-show-house"]' ).click(function(){
		village_code = $( this ).attr( 'data-village-code' );
		House.getHouseList( village_code );
	});
	
	// register new person
	$( 'a[data-name="house-btn-add-person-to-house"]' ).live('click', function(){
		House.modal.showRegisterPerson();
	});
	
	/** display modal **/
	House.modal = {};
	
	House.modal.showHouse = function()
	{
		$('div[data-name="house-modal-house-list"]').modal('show').css({
			width: 600,
			'margin-left': function ()
			{
					return -($(this).width() / 2);
			}
		});
	};
	/** new person **/
	House.modal.showRegisterPerson = function()
	{
		$( 'div[data-name="house-modal-new-person"]' ).modal('show').css({
			width: 700,
			'margin-left': function ()
			{
					return -($(this).width() / 2);
			}
		});
	}
  
  $( 'select[data-name="house-person-new-chw"]' ).change(function(){
    $.ajax({
      url: _base_url + 'basic/get_amp_dropdown',
      dataType: 'json',
      type: 'POST',
      data: 
      {
        chw: $( this ).val(),
        csrf_token: $.cookie('csrf_cookie_cloudhis')
      },
      success: function(data)
      {
        if ( data.success )
        {
          $('select[data-name="house-person-new-amp"]').empty();
          $('select[data-name="house-person-new-tmb"]').empty();
          $('select[data-name="house-person-new-moo"]').empty();
        
          $.each(data.rows, function(i, v)
          {
            $('select[data-name="house-person-new-amp"]').append(
              '<option value="' + v.amp + '">' + v.name + '</option>'
            );
          });
        }
        else
        {
          $('select[data-name="house-person-new-amp"]').empty();
          $('select[data-name="house-person-new-tmb"]').empty();
          $('select[data-name="house-person-new-moo"]').empty();
          
          alert( 'ไม่สามารถแสดงรายการได้\r\n' + data.statusText );
        }
      },
      error: function(xhr, status, errorThrown) 
      {
        $('select[data-name="house-person-new-amp"]').empty();
        $('select[data-name="house-person-new-tmb"]').empty();
        $('select[data-name="house-person-new-moo"]').empty();
        
				alert('Error: ' + xhr.status + '- ' + xhr.statusText);
			}
    });	
  });

  $( 'select[data-name="house-person-new-amp"]' ).change(function(){
    $.ajax({
      url: _base_url + 'basic/get_tmb_dropdown',
      dataType: 'json',
      type: 'POST',
      data: 
      {
        chw: $( 'select[data-name="house-person-new-chw"]' ).val(),
        amp: $( this ).val(),
        csrf_token: $.cookie('csrf_cookie_cloudhis')
      },
      success: function(data)
      {
        if ( data.success )
        {
          $('select[data-name="house-person-new-tmb"]').empty();
          $('select[data-name="house-person-new-moo"]').empty();
        
          $.each(data.rows, function(i, v)
          {
            $('select[data-name="house-person-new-tmb"]').append(
              '<option value="' + v.tmb + '">' + v.name + '</option>'
            );
          });
        }
        else
        {
          $('select[data-name="house-person-new-tmb"]').empty();
          $('select[data-name="house-person-new-moo"]').empty();
          
          alert( 'ไม่สามารถแสดงรายการได้\r\n' + data.statusText );
        }
      },
      error: function(xhr, status, errorThrown) 
      {
        $('select[data-name="house-person-new-tmb"]').empty();
        $('select[data-name="house-person-new-moo"]').empty();
        
				alert('Error: ' + xhr.status + '- ' + xhr.statusText);
			}
    });	
  });

  $( 'select[data-name="house-person-new-tmb"]' ).change(function(){
    $.ajax({
      url: _base_url + 'basic/get_moo_dropdown',
      dataType: 'json',
      type: 'POST',
      data: 
      {
        chw: $( 'select[data-name="house-person-new-chw"]' ).val(),
        amp: $( 'select[data-name="house-person-new-amp"]' ).val(),
        tmb: $( this ).val(),
        csrf_token: $.cookie('csrf_cookie_cloudhis')
      },
      success: function(data)
      {
        if ( data.success )
        {
          $('select[data-name="house-person-new-moo"]').empty();
        
          $.each(data.rows, function(i, v)
          {
            $('select[data-name="house-person-new-moo"]').append(
              '<option value="' + v.moo + '">หมู่ ' + v.moo + ' ' + v.name + '</option>'
            );
          });
        }
        else
        {
          $('select[data-name="house-person-new-moo"]').empty();
          alert( 'ไม่สามารถแสดงรายการได้\r\n' + data.statusText );
        }
      },
      error: function(xhr, status, errorThrown) 
      {
        $('select[data-name="house-person-new-moo"]').empty();
				alert('Error: ' + xhr.status + '- ' + xhr.statusText);
			}
    });	
  });
  
});