var SERVICE = {};
SERVICE.detail = {};

$( function() {

	// chronic follow up
	$('a[data-name="service-chronicfu"]').click(function(){
    SERVICE.detail.modal.showChronicFu();
	});
	// ncd screen
	$('a[data-name="service-ncd"]').click(function(){
    SERVICE.detail.modal.showNcd();
	});
	// ANC
	$('a[data-name="service-anc"]').click(function(){
    SERVICE.detail.modal.showAnc();
	});

	// 506
	$('a[data-name="service-506"]').click(function(){
    SERVICE.detail.modal.showSurveil();
	});
	// Appoint
	$('a[data-name="service-appoint"]').click(function(){
    SERVICE.detail.modal.showAppoint();
	});
	// Income
	$('a[data-name="btnsv-add-income"]').click(function(){
    SERVICE.detail.modal.showIncome();
	});
	// Drug
	$('a[data-name="btnsv-add-drug"]').click(function(){
    SERVICE.detail.modal.showDrug();
	});
	// Procedure
	$('a[data-name="btnsv-add-procedure"]').click(function(){
    SERVICE.detail.modal.showProcedure();
	});
	// Diag
	$('a[data-name="btnsv-add-diag"]').click(function(){
    $('table[data-name="tblICDResult"] > tbody').empty();
    SERVICE.detail.modal.showDiag();
	});
	// end modal

	$('input[data-name="proced_price"]').numeric();

	// select text in txt-icd
	$("input, textarea").focus(
	 	function()
	 	{
	  	// only select if the text has not changed
	  	if($(this).value == $(this).defaultValue)
	  	{
	   		$(this).select();
	  	}
	 	}
	);
	// modal diag hide.
	$('div#modal-diag').on('hidden', function () {
  	// reset form
		$('button[data-name="btnreset"]').click();
	});
	// check valid form.
	 SERVICE.doCheckScreening = function() {
		var data = {};
      data._vn 				  = $('input[data-name="vn"]').val(),
      data._weight 			= $('input[data-name="weight"]').val(),
			data._height 			= $('input[data-name="height"]').val(),
			data._heartbeat 	= $('input[data-name="heartbeat"]').val(),
			data._pulse 			= $('input[data-name="pulse"]').val(),
			data._waistline 	= $('input[data-name="waistline"]').val(),
			data._temperature = $('input[data-name="temperature"]').val(),
			data._fbs					= $('input[data-name="fbs"]').val(),
			data._bp1 				= $('input[data-name="bp1"]').val(),
			data._bp2 				= $('input[data-name="bp2"]').val(),
			data._dtx1	 			= $('input[data-name="dtx1"]').val(),
			data._dtx2 				= $('input[data-name="dtx2"]').val(),
			data._smoking 		= $('input[data-name="txtSmokingId"]').val(),
			data._drinking 		= $('input[data-name="txtDrinkingId"]').val(),
			data._allergic 		= $('input[data-name="txtAllergicsId"]').val(),
			data._cc 					= $('textarea[data-name="cc"]').val(),
			data._new_height 	= data._height / 100,
			data._bmi 				= (data._weight / (data._new_height * data._new_height)).toFixed(2);
		
		// check if data empty	
		var _str_error = '';
		var _check = false;
		
		if ( ! data._vn ) {
			_str_error 	= '<code>เลขที่รับบริการ</code> ';
			_check 		= true;
		} 
		if ( ! data._weight ||  isNaN(data._weight) ) {
			_str_error 	+= '<code> น้ำหนัก </code> ' ;
			_check 		= true;
		} 
		if ( ! data._height || isNaN( data._height ) ) {
			_str_error += '<code> ส่วนสูง </code> ';
			_check = true;
		} 
		if ( ! data._heartbeat ) {
			_str_error += '<code>อัตราการเต้นของหัวใจ</code>';
			_check = true;
		} 
		if ( ! data._pulse ) {
			_str_error += '<code> ชีพจร </code> ';
			_check = true;
		} 
		if ( ! data._waistline || isNaN( data._waistline ) ) {
			_str_error += '<code> รอบเอว </code> ';
			_check = true;
		}
		if ( ! data._temperature || isNaN( data._temperature ) ) {
			_str_error += '<code> อุณหภูมิ </code> ';
			_check = true;
		}
		if ( ! data._bp1 || isNaN( data._bp1 ) ) {
			_str_error += '<code> ความดัน (บน) </code> ';
			_check = true;
		}
		if ( ! data._bp2 || isNaN( data._bp2 ) ) {
			_str_error += '<code> ความดัน (ล่าง) </code> ';
			_check = true;
		}
		if ( ! data._cc ) {
			_str_error += ' <code>อาการแรกรับ</code> ';
			_check = true;
		} 
		// if errors.
		if( _check ) {
			toggleAlert(' เกิดข้อผิดพลาด ',  ' กรุณาตรวจสอบข้อมูลเหล่านี้  '  + _str_error  , 'alert alert-error');
		} else { // no error.
			// set bmi data
			$('input[data-name="bmi"]').val(data._bmi);
			
			SERVICE.doSaveScreening( data );
		}
	};

  SERVICE.doSaveScreening = function( data )
  {
    $.ajax({
      url: _base_url + 'services/doscreening',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
        vn: data._vn,
        weight: data._weight ,
        height: data._height,
        heartbeat: data._heartbeat,
        pulse: data._pulse,
        waistline: data._waistline,
        temperature: data._temperature,
        fbs: data._fbs,
        bp1: data._bp1,
        bp2: data._bp2,
        dtx1: data._dtx1,
        dtx2: data._dtx2,
        smoking: data._smoking,
        drinking: data._drinking,
        allergic: data._allergic,
        cc: data._cc,
        bmi: data._bmi
      },
      success: function(v){
        if(v.success){
          //window.location = _base_url + 'services';
          alert(' บันทึกข้อมูล ['+v.msg+'] การบันทึกข้อมูลเสร็จเรียบร้อยแล้ว ');
          _check = false;
        }else{
          alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล : ' + v.msg);
        }

      },
      error: function(xhr, status, errorThrown){
        alert('เกิดข้อผิดพลาด [' +  xhr.status + ': ' + xhr.statusText + ']' );
        //console.log(xhr);
      }
    }); // $.ajax
  };

 //get smoking list
  SERVICE.getSmokingList = function() {
    $.ajax({
      url: _base_url + 'basic/get_smokings',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis')
      },

      success: function(data){

        $('table[data-name="tblSmokingList"] > tbody').empty();

        $.each(data.rows, function(i, v){
          i++;
          $('table[data-name="tblSmokingList"] > tbody').append(
            '<tr>'
              + '<td>' + i + '</td>'
              + '<td>' + v.name + '</td>'
              + '<td>'
              + '<a href="#" class="btn" data-name="smoking-selected" data-id="'+ v.id +'" data-vname="'+ v.name +'"><i class="icon-check"></i></a>'
              + '</td>'
              + '</tr>'
          );
        });

      },
      error: function(xhr, status, errorThrown){
        alert('ไม่สามารถแสดงรายการสูบบุหรี่ได้: '  + xhr.status + ': ' + xhr.statusText );
      }
    });// ajax
  };

  // selected smoking
  $('a[data-name="smoking-selected"]').live('click', function(){
    var id = $(this).attr('data-id'), name = $(this).attr('data-vname');

    $('input[data-name="txtSmokingName"]').val(name);
    $('input[data-name="txtSmokingId"]').val(id);

    $('div[data-name="mdlSearchSmoking"]').modal('hide')

  });
  // show smoking list
  $('button[data-name="btnSelectSmoking"]').click(function(){
    SERVICE.getSmokingList();
    SERVICE.detail.modal.showSmoking();
  });

  //get smoking list
  SERVICE.getDrinkingList = function() {
    $.ajax({
      url: _base_url + 'basic/get_drinkings',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis')
      },

      success: function(data){

        $('table[data-name="tblDrinkingList"] > tbody').empty();

        $.each(data.rows, function(i, v){
          i++;
          $('table[data-name="tblDrinkingList"] > tbody').append(
            '<tr>'
              + '<td>' + i + '</td>'
              + '<td>' + v.name + '</td>'
              + '<td>'
              + '<a href="#" class="btn" data-name="drinking-selected" data-id="'+ v.id +'" data-vname="'+ v.name +'"><i class="icon-check"></i></a>'
              + '</td>'
              + '</tr>'
          );
        });

      },
      error: function(xhr, status, errorThrown){
        alert('ไม่สามารถแสดงรายการสูบบุหรี่ได้: '  + xhr.status + ': ' + xhr.statusText );
      }
    });// ajax
  };

  // selected drinking
  $('a[data-name="drinking-selected"]').live('click', function(){
    var id = $(this).attr('data-id'), name = $(this).attr('data-vname');

    $('input[data-name="txtDrinkingName"]').val(name);
    $('input[data-name="txtDrinkingId"]').val(id);

    $('div[data-name="mdlSearchDrinking"]').modal('hide')

  });
  // show drinking list
  $('button[data-name="btnSelectDrinking"]').click(function(){
    SERVICE.getDrinkingList();
    SERVICE.detail.modal.showDrinking();
  });

   //get Allergics list
  SERVICE.getAllergicsList = function() {
    $.ajax({
      url: _base_url + 'basic/get_allergics',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis')
      },

      success: function(data){

        $('table[data-name="tblAllergicsList"] > tbody').empty();

        $.each(data.rows, function(i, v){
          i++;
          $('table[data-name="tblAllergicsList"] > tbody').append(
            '<tr>'
              + '<td>' + i + '</td>'
              + '<td>' + v.name + '</td>'
              + '<td>'
              + '<a href="#" class="btn" data-name="allergics-selected" data-id="'+ v.id +'" data-vname="'+ v.name +'"><i class="icon-check"></i></a>'
              + '</td>'
              + '</tr>'
          );
        });

      },
      error: function(xhr, status, errorThrown){
        alert('ไม่สามารถแสดงรายการสูบบุหรี่ได้: '  + xhr.status + ': ' + xhr.statusText );
      }
    });// ajax
  };

  // selected drinking
  $('a[data-name="allergics-selected"]').live('click', function(){
    var id = $(this).attr('data-id'), name = $(this).attr('data-vname');

    $('input[data-name="txtAllergicsName"]').val(name);
    $('input[data-name="txtAllergicsId"]').val(id);

    $('div[data-name="mdlSearchAllergics"]').modal('hide')

  });
  // show Allergics list
  $('button[data-name="btnSelectAllergics"]').click(function(){
    SERVICE.getAllergicsList();
    SERVICE.detail.modal.showAllergics();
  });

	// show modal	
	SERVICE.detail.modal = {
		showProcedure: function() {
			$('div[data-name="mdlSearchProced"]').modal('show').css({
        width: 770,
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    	});
		},
		showDiag: function() {
			$('div[data-name="mdlSearchDiags"]').modal('show').css({
        width: 770,
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    	});
		},
		showDrug: function() {
			$('div[data-name="mdlSearchDrug"]').modal('show').css({
        width: 770,
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    	});
		},
		showIncome: function() {
			$('div[data-name="modal-income"]').modal('show').css({
        width: 700,
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    	});
		},
		showAppoint: function() {
			$('div[data-name="modal-appoint"]').modal('show').css({
        width: 770,
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    	});
		},
		showSurveil: function() {
			$('div[data-name="modal-506"]').modal('show').css({
        width: 770,
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    	});
		},
		showAnc: function() {
			$('div[data-name="modal-anc"]').modal('show').css({
        width: 770,
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    	});
		},
		showNcd: function() {
			$('div[data-name="modal-ncd"]').modal('show').css({
        width: 770,
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    	});
		},
		showChronicFu: function() {
			$('div[data-name="modal-chronicfu"]').modal('show').css({
        width: 770,
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    	});
		},
		showSmoking: function() {
			$('div[data-name="mdlSearchSmoking"]').modal('show').css({
        width: 460,
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    	});
		},
		showDrinking: function() {
			$('div[data-name="mdlSearchDrinking"]').modal('show').css({
        width: 460,
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    	});
		},
		showAllergics: function() {
			$('div[data-name="mdlSearchAllergics"]').modal('show').css({
        width: 460,
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    	});
		}
	}; // end Modal

  $( 'a[data-name="btnSaveScreen"]' ).click( function() {
    SERVICE.doCheckScreening();
  });

});
