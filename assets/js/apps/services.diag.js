$(function(){
  var Diags = {};

  Diags.showSelectedDiag = function()
  {
    Diags.getDiagTypeList();
    $('div[data-name="modalSelectedDiagForSave"]').modal('show').css({
      width: 460,
      'margin-left': function () {
        return -($(this).width() / 2);
      }
    });
  };
// search diag
  $('button[data-name="btnSearchDiag" ]').click(function(){
    var query = $('input[data-name="txtICDQuery"]').val();
    if(!query){
      alert('กรุณากรอกข้อมูลเพื่อค้นหา');
    }else{

      // dosearch
     Diags.doSearchICD( query );
    }
  });
  Diags.doSearchICD = function(query)
  {
    $.ajax({
      url: _base_url + 'basic/search_diag',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
        query: query
      },

      success: function(data){

        $('table[data-name="tblICDResult"] > tbody').empty();

        $.each(data, function(i, v){
          i++;
          $('table[data-name="tblICDResult"] > tbody').append(
              '<tr>'
                  + '<td>' + i + '</td>'
                  + '<td>' + v.code + '</td>'
                  + '<td>' + v.name + '</td>'
                  + '<td>'
                  + '<a href="#" class="btn" data-name="icd-selected" data-vname="'+ v.name +'" data-code="'+ v.code +'"><i class="icon-check"></i></a>'
                  + '</td>'
                  + '</tr>'
          );
        });

      },
      error: function(xhr, status, errorThrown){
        alert('ไม่สามารถแสดงรายการประเภทการวินิจฉัยได้: '  + xhr.status + ': ' + xhr.statusText );
      }
    });
  };

  Diags.getDiagTypeList = function() {
    $.ajax({
      url: _base_url + 'basic/get_diag_type_list',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis')
      },

      success: function(data){

        $('table[data-name="tblDiagTypeList"] > tbody').empty();

        $.each(data.rows, function(i, v){
          i++;
          $('table[data-name="tblDiagTypeList"] > tbody').append(
              '<tr>'
                  + '<td>' + i + '</td>'
                  + '<td>' + v.name + '</td>'
                  + '<td>'
                  + '<a href="#" class="btn" data-name="diagtype-selected" data-id="'+ v.id +'"><i class="icon-check"></i></a>'
                  + '</td>'
                  + '</tr>'
          );
        });
      },
      error: function(xhr, status, errorThrown){
        alert('ไม่สามารถแสดงรายการประเภทการวินิจฉัยได้: '  + xhr.status + ': ' + xhr.statusText );
      }
    });// ajax
  };

  $('a[data-name="diagtype-selected"]').live('click', function(){
    var data = {};
    data.diag_type = $(this).attr('data-id');
    data.diag_code = $('input[data-name="txtICDCode"]').val();
    data.vn = $('input[data-name="vn"]').val();

    if(!data.diag_type){
      alert('กรุณากำหนดประเภทการวินิจฉัย (Diag type)');
    }else if(!data.diag_code){
      alert('กรุณาเลือกรหัสการวินิจฉัย');
    }else if(!data.vn){
      alert('ไม่พบรหัสการรับบริการ (VN)');
    }else{
      //do save diag
      Diags.doSaveDiag( data );
    }

  });

  $('a[data-name="icd-selected"]').live('click', function(){
    var code = $(this).attr('data-code');

    $('input[data-name="txtICDCode"]').val(code);
   // $('input[data-name="txtICDName"]').val(name);

    Diags.showSelectedDiag();
  });

  // save diag
  Diags.doSaveDiag = function( icd ) {
    // do save
    $.ajax({
      url: _base_url + 'services/dodiag',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
        vn: icd.vn,
        diag_code: icd.diag_code ,
        diag_type: icd.diag_type
      },
      success: function(data){
        if(data.success){
          // hide dialog
          $('div[data-name="mdlSearchDiags"]').modal('hide');
          $('div[data-name="modalSelectedDiagForSave"]').modal('hide');

          // load diag list
          Diags.getDiagList();

        }else{
          alert( 'เกิดข้อผิดพลาด : ' + data.msg);
        }
      },
      error: function(xhr, status, errorThrown){
        alert('เกิดข้อผิดพลาด: ' + xhr.status + ': ' + xhr.statusText);
        //console.log(xhr);
      }
    });// ajax
  };

  // get diag list
  Diags.getDiagList = function() {
    var vn = $('input[data-name="vn"]').val();

    $.ajax({
      url: _base_url + 'services/get_visit_diag',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
        vn: vn
      },
      success: function(data){
        if(data.success){
          $('table[data-name="tblDiagList"] > tbody').empty();

          $.each(data.rows, function(i, v){
            i++;
            $('table[data-name="tblDiagList"] > tbody').append(
                '<tr>'
                    + '<td>' + i + '</td>'
                    + '<td>' + v.diag_code + '</td>'
                    + '<td>' + v.diag_name + '</td>'
                    + '<td>' + v.diag_type_name + '</td>'
                    + '<td>'
                    + '<a href="#" class="btn" data-name="remove-diag" data-id="'+ v.id +'"><i class="icon-trash"></i></a>'
                    + '</td>'
                    + '</tr>'
            );
          });
        }else{
          alert('เกิดข้อผิดพลาดในการบันทึกรายการ: ' + data.msg);
        }
      },
      error: function(xhr, status, errorThrown){
        alert('เกิดข้อผิดพลาด: ' + xhr.status + ': ' + xhr.statusText);
        //console.log(xhr);
      }
    });// ajax
  };

  $('a[data-name="btnTabDiag"]').click(function(){
    Diags.getDiagList();
  });

  // remove diag
  $('a[data-name="remove-diag"]').live('click', function(){
    if(confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?')){
      var id = $(this).attr('data-id');
      if(!id){
        alert('ไม่พบรหัสการวินิจฉัยที่ต้องการลบ');
      }else{
        //do remove
        Diags.doRemoveDiag( id );
      }
    }
  });

  Diags.doRemoveDiag = function( id )
  {
    $.ajax({
      url: _base_url + 'services/removediag',
      dataType: 'json',
      type: 'POST',
      data: {
        csrf_token: $.cookie('csrf_cookie_cloudhis'),
        id: id
      },
      success: function(data){
        if(data.success){
          alert('ลบรายการเรียบร้อยแล้ว');
          Diags.getDiagList();
        }else{
          alert('ไม่สามารถลบรายการได้: ' + data.msg);
        }

      },
      error: function(xhr, status, errorThrown){
        alert('Server error: ' + xhr.status +': ' + xhr.statusText);
      }
    });// ajax
  };
});