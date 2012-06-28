$(function(){
  var Proced = {};

  /** Get proced list **/
  Proced.getVisitList = function()
  {
    var vn = $('input[data-name="vn"]').val();

    $.ajax({
      url: _base_url + '/services/get_visit_proced',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
        vn: vn
      },

      success: function(data){

        $('table[data-name="tblProcedList"] > tbody').empty();
        if(_.size(data.rows) == 0){
          $('table[data-name="tblProcedList"] > tbody').append(
            '<tr> <td colspan="6">ไม่พบข้อมูล </td></tr>'
          );
        }else{
          $.each(data.rows, function(i, v){
          i++;
          $('table[data-name="tblProcedList"] > tbody').append(
            '<tr>'
                + '<td>' + i + '</td>'
                + '<td>' + v.code + '</td>'
                + '<td>' + v.name + '</td>'
                + '<td>' + v.price + '</td>'
                + '<td>' + v.doctor_name + '</td>'
                + '<td>'
                + ' <a href="#" class="btn disabled" data-name="proced-edit" data-id="'+ v.id +'"><i class="icon-edit"></i></a>'
                + ' <a href="#" class="btn" data-name="proced-remove" data-id="'+ v.id +'"><i class="icon-trash"></i></a>'
                + '</td>'
                + '</tr>'
          );
        });
        }

      },
      error: function(xhr, status, errorThrown){
        alert('ไม่สามารถแสดงรายการประเภทการวินิจฉัยได้: '  + xhr.status + ': ' + xhr.statusText );
      }
    });
  };

  $('a[data-name="btnTabProced"]').click(function(){
    doLoading();
    Proced.getVisitList();
    doUnLoading();
  });

  // search proced
  $('button[data-name="btnSearchProced"]').click(function(){
    var query = $('input[data-name="txtProcedQuery"]').val();
    if(!query){
      alert('กรุณากรอกข้อความที่ต้องการค้หา');
    }else{
      //do search
      Proced.doSearch( query );
    }
  });

  Proced.doSearch = function( query )
  {
    $.ajax({
      url: _base_url + '/basic/search_proced',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
        query: query
      },

      success: function(data){

        $('table[data-name="tblProcedSearchList"] > tbody').empty();
        if(_.size(data.rows) == 0){
          $('table[data-name="tblProcedSearchList"] > tbody').append(
            '<tr><td colspan="4">ไม่พบข้อมูลที่ค้นหา</td></tr>'
          );
        }else{
          $.each(data.rows, function(i, v){
          i++;
          $('table[data-name="tblProcedSearchList"] > tbody').append(
            '<tr>'
                + '<td>' + i + '</td>'
                + '<td>' + v.code + '</td>'
                + '<td>' + v.name + '</td>'
                + '<td>'
                + '<a href="#" class="btn" data-name="proced-selected" data-code="'+ v.code +'"><i class="icon-check"></i></a>'
                + '</td>'
                + '</tr>'
          );
        });
        }

      },
      error: function(xhr, status, errorThrown){
        alert('ไม่สามารถแสดงรายการประเภทการวินิจฉัยได้: '  + xhr.status + ': ' + xhr.statusText );
      }
    });
  };

  Proced.getDoctorsList = function( )
  {
    $.ajax({
      url: _base_url + '/basic/get_doctor_list_visit',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis')
      },

      success: function(data){

        $('table[data-name="tblDoctorsVisitList"] > tbody').empty();
        if(_.size(data.rows) == 0){
          $('table[data-name="tblDoctorsVisitList"] > tbody').append(
            '<tr><td colspan="4">ไม่พบข้อมูล </td></tr>'
          );
        }else{
          $.each(data.rows, function(i, v){
          i++;
          $('table[data-name="tblDoctorsVisitList"] > tbody').append(
            '<tr>'
                + '<td>' + i + '</td>'
                + '<td>' + v.name + '</td>'
                + '<td>' + v.license_no + '</td>'
                + '<td>'
                + '<a href="#" class="btn" data-name="doctor-selected" data-vname="'+ v.name +'" data-id="'+ v.id +'"><i class="icon-check"></i></a>'
                + '</td>'
                + '</tr>'
          );
        });
        }

      },
      error: function(xhr, status, errorThrown){
        alert('Server error: '  + xhr.status + ': ' + xhr.statusText );
      }
    });
  };

  $('a[data-name="proced-selected"]').live('click', function(){
    var code = $(this).attr('data-code');
    // set proced code for hidden
    $('input:hidden[data-name="txtProcedCode"]').val(code);
    Proced.showSelectDoctor();
  });

  $('a[data-name="doctor-selected"]').live('click', function(){
    var id = $(this).attr('data-id'),
        name = $(this).attr('data-vname');

    $('input[data-name="txtDoctorId"]').val( id );
    $('input[data-name="txtDoctorName"]').val( name );

    $('div[data-name="mdlSelectDoctor"]').modal('hide');
  });

  // save
  $('a[data-name="btnSaveProced"]').click(function(){
    var items = {};
        items.proced_code = $('input[data-name="txtProcedCode"]').val(),
        items.doctor_id = $('input[data-name="txtDoctorId"]').val(),
        items.price = $('input[data-name="txtProcedPrice"]').val(),
        items.vn = $('input[data-name="vn"]').val();

    if(!items.proced_code){
      alert('ไม่พบรหัสหัตถการ');
    }else if(!items.doctor_id){
      alert('ไม่พบเจ้าหน้าที่ผู้ให้บริการ');
    }else if(!items.price){
      alert('กรุณากำหนดราคาค่าบริการ');
    }else if(!items.vn){
      alert('ไม่พบเลขที่การให้บริการ (VN)');
    }else{
      // do save
      Proced.doSave( items );
    }
  });

  Proced.showNewModal = function()
  {
    $('div[data-name="modalSelectedDiagForSave"]').modal('show').css({
      width: 740,
      'margin-left': function () {
        return -($(this).width() / 2);
      }
    });
  };
  Proced.showSelectDoctor = function()
  {
    $('div[data-name="mdlProcedSelectUserPrice"]').modal('show').css({
      width: 640,
      'margin-left': function () {
        return -($(this).width() / 2);
      }
    });
  };

  Proced.showDoctorList = function()
  {
    $('div[data-name="mdlSelectDoctor"]').modal('show').css({
      width: 640,
      'margin-left': function () {
        return -($(this).width() / 2);
      }
    });
  };

  $('button[data-name="btnSearchDoctor"]').click(function(){
    Proced.getDoctorsList();
    Proced.showDoctorList();
  });

  Proced.doSave = function( items ) {
    $.ajax({
      url: _base_url + '/services/doproced',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
        vn: items.vn,
        proced_code: items.proced_code,
        price: items.price,
        doctor_id: items.doctor_id
      },
      success: function(data){
        if(data.success){

          alert('บันทึกข้อมูลการให้บริการหัตถการเสร็จเรียบร้อยแล้ว');
          $('div[data-name="modalSelectedDiagForSave"]').modal('hide');
          $('div[data-name="mdlProcedSelectUserPrice"]').modal('hide');
          $('div[data-name="mdlSelectDoctor"]').modal('hide');
          $('div[data-name="mdlSearchProced"]').modal('hide');

          Proced.getVisitList();

        }else{
          alert('เกิดข้อผิดพลาด: ' + data.msg);
        }
      },
      error: function(xhr, status, errorThrown){
        alert('Server error: [' + xhr.status + ': ' + xhr.statusText + ']' );
      }
    });
  };

  $('a[data-name="proced-remove"]').live('click', function(){
    var id = $(this).attr('data-id');

    if(confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')){
      doLoading();
      Proced.doRemove( id );
      doUnLoading();
    }

  });
  Proced.doRemove = function( id ) {
        $.ajax({
          url: _base_url + '/services/removeproced',
          dataType: 'json',
          type: 'POST',
          data: {
            csrf_token: $.cookie('csrf_cookie_cloudhis'),
            id: id
          },
          success: function(data){
            if(data.success){
              //alert('ลบรายการเสร็จเรียบร้อยแล้ว');
              Proced.getVisitList();
            }else{
              alert('ไม่สามารถลบรายการได้ : ' + data.msg);
            }

          },
          error: function(xhr, status, errorThrown){
            alert('Server error: [' + xhr.status + ': ' + xhr.statusText + ']' );
          }
        });// ajax
      };


});