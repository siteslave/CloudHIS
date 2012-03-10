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
									+ '<a href="#" class="btn" data-name="detail-person" data-id="'+ v.id +'"><i class="icon-edit"></i></a>'
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
  /*********************************************************************
   * Select house list
   ********************************************************************/
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
				
				// set to first index
				$('select[data-name="house-sel-house"] option' ).eq(0).attr('selected', 'selected');
        // get people
        var house_id = $( 'select[data-name="house-sel-house"]' ).val();
		    House.getPeopleList( house_id );
      },
      error: function(xhr, status, errorThrown) {
				alert('Error: ' + xhr.status + '- ' + xhr.statusText);
			}
		});
  };

	/*********************************************************************
	 * Get house list
	 *
	 * @param {String} village_code Village code
	 ********************************************************************/
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
	/*********************************************************************
	 * Save new person
	 *
	 * @param {Mixed} ojb Person detail
	 ********************************************************************/
	House.savePerson = function( obj )
	{
    $.ajax({
			url: _base_url + 'people/dosave',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token:  $.cookie('csrf_cookie_cloudhis'),
        update: obj.update, // insert or update
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
				else alert( data.statusText );
      },
      error: function(xhr, status, errorThrown) {
				alert('Error: ' + xhr.status + '- ' + xhr.statusText);
			}
		});
	};
  /********************************************************************* 
  * Set data for update person
  * @param  string pid
  * @return void
  *********************************************************************/
  House.setUpdatePerson = function( id )
  {
    // get data
    $.ajax({
			url: _base_url + 'people/getdetail',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
        id: id
      },
      success: function(data){

				if( data.success )
				{
				  // load address combo
		  		var chw = data.rows[0].village_code.substring(0, 2),
		      amp = data.rows[0].village_code.substring(2, 4),
		      tmb = data.rows[0].village_code.substring(4, 6),
		      moo = data.rows[0].village_code.substring(6, 8);
          // load and set address
          House.loadMoo( chw, amp, tmb, moo );
				  House.loadTmb( chw, amp, tmb );
				  House.loadAmp( chw, amp );
		      
		      $( 'select[data-name="house-person-new-chw"]' ).val( chw );

      		$( 'input[data-name="house-person-new-cid"]' ).val( data.rows[0].cid );
		      $( 'input[data-name="house-person-new-fname"]' ).val( data.rows[0].fname );
		      $( 'input[data-name="house-person-new-lname"]' ).val( data.rows[0].lname );
		      $( 'select[data-name="house-person-new-sex"]' ).val( data.rows[0].sex );
		      
		      if ( typeof data.rows[0].birthdate == 'string' )
		        $( 'input[data-name="house-person-new-birthdate"]' ).datepicker( 'setDate', toSystemDate( data.rows[0].birthdate ) );
		        
		      $( 'select[data-name="house-person-new-blood-group"]' ).val( data.rows[0].blood_group_id );
		      $( 'select[data-name="house-person-new-marry"]' ).val( data.rows[0].marry_status_id );
		      $( 'select[data-name="house-person-new-title"]' ).val( data.rows[0].title_id );
		      $( 'input[data-name="house-person-new-address"]' ).val( data.rows[0].address );
		      //$( 'select[data-name="house-sel-house"]' ).val( data.rows[0].cid );
		      $( 'select[data-name="house-person-new-occupation"]' ).val( data.rows[0].occupation_id );
		      $( 'select[data-name="house-person-new-race"]' ).val( data.rows[0].race_id );
		      $( 'select[data-name="house-person-new-nation"]' ).val( data.rows[0].nation_id );
		      $( 'select[data-name="house-person-new-religion"]' ).val( data.rows[0].religion_id );
		      $( 'select[data-name="house-person-new-education"]' ).val( data.rows[0].education_id );
		      $( 'select[data-name="house-person-new-fstatus"]' ).val( data.rows[0].family_status_id );
		      $( 'input[data-name="house-person-new-father-cid"]' ).val( data.rows[0].father_cid );
		      $( 'input[data-name="house-person-new-mother-cid"]' ).val( data.rows[0].mother_cid );
		      $( 'input[data-name="house-person-new-couple-cid"]' ).val( data.rows[0].couple_cid );
		      
		      if ( typeof data.rows[0].move_in_date == 'string')
		        $( 'input[data-name="house-person-new-movein-date"]' ).datepicker( 'setDate', toSystemDate( data.rows[0].move_in_date ) );

		      if ( typeof data.rows[0].discharge_date == 'string')
		        $( 'input[data-name="house-person-new-discharge-date"]' ).datepicker( 'setDate', toSystemDate( data.rows[0].discharge_date ) );
		      
		      $( 'select[data-name="house-person-new-discharge-status"]' ).val( data.rows[0].discharge_status_id );  
		      $( 'select[data-name="house-person-new-labor"]' ).val( data.rows[0].labor_id );
		      // show register modal
		      House.modal.showRegisterPerson();
				}
				else alert( data.statusText );
      },
      error: function(xhr, status, errorThrown) 
      { alert('Error: ' + xhr.status + '- ' + xhr.statusText); }
		});
  };
  /*********************************************************************
  * Load changwat combo
  *********************************************************************/
  House.loadChw = function ()
  {
    $.ajax({
      url: _base_url + 'basic/get_chw_dropdown',
      dataType: 'json',
      type: 'POST',
      data: { csrf_token: $.cookie('csrf_cookie_cloudhis') },
      success: function(data)
      {
        if ( data.success )
        {
          $('select[data-name="house-person-new-chw"]').empty();
          $.each(data.rows, function(i, v)
          {
            $('select[data-name="house-person-new-chw"]').append(
              '<option value="' + v.chw + '">' + v.name + '</option>'
            );
          });
        }
        else alert( 'ไม่สามารถแสดงรายการได้\r\n' + data.statusText );
      },
      error: function(xhr, status, errorThrown)
      {
				alert('Error: ' + xhr.status + '- ' + xhr.statusText);
			}
    });
  };
  
  House.loadChw(); // load changwat combo
  
  /*********************************************************************
  * Load Ampur combo
  *
  * @param  string  chw Changwat code
  *********************************************************************/
  House.loadAmp = function ( chw, amp )
  {
    $.ajax({
      url: _base_url + 'basic/get_amp_dropdown',
      dataType: 'json',
      type: 'POST',
      data:
      {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
        chw: chw
      },
      success: function(data)
      {
        if ( data.success )
        {
          $('select[data-name="house-person-new-amp"]').empty();
          $.each(data.rows, function(i, v)
          {
            if ( v.amp == amp )
            {
              $('select[data-name="house-person-new-amp"]').append(
                '<option value="' + v.amp + '" selected="selected">' + v.name + '</option>'
              );
            }
            else
            {
              $('select[data-name="house-person-new-amp"]').append(
                '<option value="' + v.amp + '">' + v.name + '</option>'
              );
            }
          });
        }
        else alert( 'ไม่สามารถแสดงรายการได้\r\n' + data.statusText );
      },
      error: function(xhr, status, errorThrown)
      { alert('Error: ' + xhr.status + '- ' + xhr.statusText); }
    });
  };
  /*********************************************************************
  * Load tambon combo
  * 
  * @param  string  chw Changwat code
  * @param  string  amp Ampur code
  *********************************************************************/
  House.loadTmb = function( chw, amp, tmb )
  {
    $.ajax({
      url: _base_url + 'basic/get_tmb_dropdown',
      dataType: 'json',
      type: 'POST',
      data: { 
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      chw: chw,
      amp: amp 
      },
      success: function(data)
      {
        if ( data.success )
        {
          $('select[data-name="house-person-new-tmb"]').empty();
          $.each(data.rows, function(i, v)
          {
            if ( v.tmb == tmb ) 
            {
              $('select[data-name="house-person-new-tmb"]').append(
                '<option value="' + v.tmb + '" selected="selected">' + v.name + '</option>'
              );  
            }
            else
            {
              $('select[data-name="house-person-new-tmb"]').append(
                '<option value="' + v.tmb + '">' + v.name + '</option>'
              );
            }
          });
        }
        else alert( 'ไม่สามารถแสดงรายการได้\r\n' + data.statusText );
      },
      error: function(xhr, status, errorThrown)
      { alert('Error: ' + xhr.status + '- ' + xhr.statusText); }
    });
  };
  /*********************************************************************
  * Load mooban combo
  * 
  * @param  string  chw Changwat code
  * @param  string  amp Ampur code
  * @param  string  tmb Tambon code
  *********************************************************************/
  House.loadMoo = function( chw, amp, tmb, moo )
  {
    $.ajax({
      url: _base_url + 'basic/get_moo_dropdown',
      dataType: 'json',
      type: 'POST',
      data: 
      { 
      csrf_token: $.cookie('csrf_cookie_cloudhis'),
      chw: chw,
      amp: amp,
      tmb: tmb 
      },
      success: function(data)
      {
        if ( data.success )
        {
          $('select[data-name="house-person-new-moo"]').empty();
          $.each(data.rows, function(i, v)
          {
            if ( v.moo == moo )
            {
              $('select[data-name="house-person-new-moo"]').append(
                '<option value="' + v.moo + '" selected="selected">หมู่ ' + v.moo + ' ' + v.name + '</option>'
              );
            }
            else
            {
              $('select[data-name="house-person-new-moo"]').append(
                '<option value="' + v.moo + '">หมู่ ' + v.moo + ' ' + v.name + '</option>'
              );
            }
          });
        }
        else alert( 'ไม่สามารถแสดงรายการได้\r\n' + data.statusText );
      },
      error: function(xhr, status, errorThrown)
      { alert('Error: ' + xhr.status + '- ' + xhr.statusText); }
    });
  };
  
  /*********************************************************************
  * Load village combo
  *********************************************************************/
  House.loadVillages = function ()
  {
    $.ajax({
      url: _base_url + 'villages/get_villages',
      dataType: 'json',
      type: 'POST',
      data: { csrf_token: $.cookie('csrf_cookie_cloudhis') },
      success: function(data)
      {
        if ( data.success )
        {
        $('select[data-name="house-sel-village"]').empty();
          $.each(data.rows, function(i, v)
          {
            $('select[data-name="house-sel-village"]').append(
              '<option value="' + v.village_code + '">หมู่ ' + v.village_code.substring(6) + ' ' + v.village_name +'</option>'
            );
          });
          // set first index
          $('select[data-name="house-sel-village"] option').eq(0).attr('selected', 'selected');
          
          var village_code = $( 'select[data-name="house-sel-village"]' ).val();
          House.getList( village_code );
        }
        else alert( 'ไม่สามารถแสดงรายการได้\r\n' + data.statusText );
      },
      error: function(xhr, status, errorThrown)
      { alert('Error: ' + xhr.status + '- ' + xhr.statusText); }
    });
  };
  // clear address combo
  House.clearAddress = function()
  {
    $('select[data-name="house-person-new-amp"]').empty();
    $('select[data-name="house-person-new-tmb"]').empty();
    $('select[data-name="house-person-new-moo"]').empty();
  };
  
  // get address
  $( 'select[data-name="house-sel-village"]' ).change(function(){
    var village_code = $( this ).val();
		$( 'table[data-name="house-tbl-people-list"] > tbody' ).empty();
		
    House.getList( village_code );
  });

  // get people list
  $( 'button[data-name="house-btn-get-people-list"]' ).click(function(){
		var house_id = $( 'select[data-name="house-sel-house"]' ).val();

		if ( ! house_id ) alert( 'กรุณาเลือกหลังคาเรือน' );
		else House.getPeopleList( house_id );
  });
  // select house
	$('select[data-name="house-sel-house"]').live( 'change', function(){
		var house_id = $( this ).val();

		if ( ! house_id ) alert( 'กรุณาเลือกหลังคาเรือน' );
		else House.getPeopleList( house_id );
	});
	
	// save new person
	$( 'a[data-name="house-btn-save-new-person"]' ).click(function(){

		person = new Object();
    person.update               = $( 'input[data-name="update"]' ).val();
		person.cid                  = $( 'input[data-name="house-person-new-cid"]' ).val();
		person.fname                = $( 'input[data-name="house-person-new-fname"]' ).val();
		person.lname                = $( 'input[data-name="house-person-new-lname"]' ).val();
		person.sex                  = $( 'select[data-name="house-person-new-sex"]' ).val();
		person.birthdate            = $( 'input[data-name="house-person-new-birthdate"]' ).val();
		person.blood_group_id       = $( 'select[data-name="house-person-new-blood-group"]' ).val();
		person.marry_status_id      = $( 'select[data-name="house-person-new-marry"]' ).val();
		person.title_id             = $( 'select[data-name="house-person-new-title"]' ).val();
		person.address              = $( 'input[data-name="house-person-new-address"]' ).val();
		person.house_id             = $( 'select[data-name="house-sel-house"]' ).val();
		person.occupation_id        = $( 'select[data-name="house-person-new-occupation"]' ).val();
		person.race_id              = $( 'select[data-name="house-person-new-race"]' ).val();
		person.nation_id            = $( 'select[data-name="house-person-new-nation"]' ).val();
		person.religion_id          = $( 'select[data-name="house-person-new-religion"]' ).val();
		person.education_id         = $( 'select[data-name="house-person-new-education"]' ).val();
		person.family_status_id     = $( 'select[data-name="house-person-new-fstatus"]' ).val();
		person.father_cid           = $( 'input[data-name="house-person-new-father-cid"]' ).val();
		person.mother_cid           = $( 'input[data-name="house-person-new-mother-cid"]' ).val();
		person.couple_cid           = $( 'input[data-name="house-person-new-couple-cid"]' ).val();
		person.move_in_date         = $( 'input[data-name="house-person-new-movein-date"]' ).val();
		person.discharge_status_id  = $( 'select[data-name="house-person-new-discharge-status"]' ).val();
		person.discharge_date       = $( 'input[data-name="house-person-new-discharge-status-date"]' ).val();
		person.labor_id             = $( 'select[data-name="house-person-new-labor"]' ).val();
		person.chw                  = $( 'select[data-name="house-person-new-chw"]' ).val();
		person.amp                  = $( 'select[data-name="house-person-new-amp"]' ).val();
		person.tmb                  = $( 'select[data-name="house-person-new-tmb"]' ).val();
		person.moo                  = $( 'select[data-name="house-person-new-moo"]' ).val();
    person.type_area_id         = $( 'select[data-name="house-person-new-typearea"]' ).val();
    
		person.village_code         = person.chw + person.amp + person.tmb + person.moo;

		// check data

		if ( ! person.cid ) alert( 'ไม่พบเลขบัตรประชาชน' );
		else if ( ! person.fname ) alert( 'ไม่พบชื่อ' );
		else if ( ! person.lname ) alert( 'ไม่พบนามสกุล' );
		else if ( ! person.birthdate ) alert( 'ไม่พบวันเกิด' );
		else if ( ! person.move_in_date ) alert( 'ไม่พบวันที่ย้ายเข้า' );
		else if ( ! person.address ) alert( 'ไม่พบบ้านเลขที่ตามทะเบียนบ้าน' );
		else if ( ! person.chw ) alert( 'ไม่พบ จังหวัด ตามทะเบียนบ้าน' );
		else if ( ! person.amp ) alert( 'ไม่พบ อำเภอ ตามทะเบียนบ้าน' );
		else if ( ! person.tmb ) alert( 'ไม่พบ ตำบล ตามทะเบียนบ้าน' );
		else if ( ! person.moo ) alert( 'ไม่พบ หมู่บ้าน ตามทะเบียนบ้าน' );
		else House.savePerson( person );
		
	});
	// get house list
	$( 'a[data-name="house-btn-show-house"]' ).click(function(){
		village_code = $( this ).attr( 'data-village-code' );
		House.getHouseList( village_code );
	});

	// register new person
	$( 'a[data-name="house-btn-add-person-to-house"]' ).live('click', function(){
		// set active tab
	  $('a[data-name="house-person-new-basic1"]').tab('show');
	  // set add person
	  $( 'input[data-name="update"]' ).val( '0' );
	  
		House.modal.showRegisterPerson();
	});
	
	// tab people list click
	$( 'a[data-name="house-tab-people-list"]' ).click(function(){
	  House.loadVillages();
	});

	/** display modal **/
	House.modal = {};

	House.modal.showHouse = function()
	{
		$('div[data-name="house-modal-house-list"]').modal('show').css({
			width: 600,
			'margin-left': function () { return -($(this).width() / 2); }
		});
	};
	/** new person **/
	House.modal.showRegisterPerson = function()
	{	  
		$( 'div[data-name="house-modal-new-person"]' ).modal('show').css({
			width: 700,
			'margin-left': function () { return -($(this).width() / 2); }
		});
	};
	
	$( 'div[data-name="house-modal-new-person"]' ).on( 'hidden', function(){
	  $( 'input[data-name="house-btn-new-reset"]' ).trigger( 'click' );
	  House.clearAddress();
	});

  $( 'select[data-name="house-person-new-chw"]' ).change(function(){
    var chw = $( this ).val();
    House.clearAddress();
    House.loadAmp( chw );
  });

  $( 'select[data-name="house-person-new-amp"]' ).change(function(){
    var chw = $( 'select[data-name="house-person-new-chw"]' ).val(),
        amp = $( this ).val();
    // clear combo
    $('select[data-name="house-person-new-moo"]').empty();
    // load tambon combo     
    House.loadTmb( chw, amp );
  });

  $( 'select[data-name="house-person-new-tmb"]' ).change(function(){
    var chw = $( 'select[data-name="house-person-new-chw"]' ).val(),
        amp = $( 'select[data-name="house-person-new-amp"]' ).val(),
        tmb = $( this ).val();
    House.loadMoo( chw, amp, tmb );
  });
  // edit person event button click
  $( 'a[data-name="detail-person"]' ).live( 'click', function(){
  	// set active tab
	  $('a[data-name="house-person-new-basic1"]').tab('show');
	  // set update person
	  $( 'input[data-name="update"]' ).val( '1' );
	  
    var id = $( this ).attr( 'data-id' );
    House.setUpdatePerson( id );
  });
});
