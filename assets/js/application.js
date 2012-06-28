
var addCommas = function (nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
},
// convert mysql date to thai date
toThaiDate = function( d )
{
	var _d = d.split('-'),
					_y = parseInt(_d[0]) + 543,
					_m = _d[1],
					_d = _d[2],
						
					_date = _d + '/' + _m + '/' + _y ;
					
	return _date;
},
// convert mysql data to system date
toSystemDate = function( d )
{
		var _d = d.split('-'),
					_y = _d[0],
					_m = _d[1],
					_d = _d[2],
						
					_date = _d + '/' + _m + '/' + _y ;
					
	return _date;
},
doLoading = function(){
  $.blockUI({ css: {
    border: 'none',
    padding: '15px',
    backgroundColor: '#000',
    '-webkit-border-radius': '10px',
    '-moz-border-radius': '10px',
    opacity: .5,
    color: '#fff'
  }});
},
doUnLoading = function(){
  $.unblockUI();
},
doBlock = function(obj, msg)
{
  $(obj).block({
    css: {
      border: 'none',
      padding: '15px',
      backgroundColor: '#000',
      '-webkit-border-radius': '10px',
      '-moz-border-radius': '10px',
      opacity: .5,
      color: '#fff'
    },
    message: '<h3>'+msg+'</h3>',
    overlayCSS:  {
      backgroundColor: '#000',
      opacity:         0.1
    }
  });
},
doUnBlock = function(obj)
{
  $(obj).unblock();
};

$(function(){
  // date mask
  $('input[data-type="date"]').mask("99/99/9999").attr('placeholder', 'dd/mm/yyyy');
  $('input[data-type="year"]').mask("9999");
  $('input[data-type="postcode"]').mask("99999");
  // set numberic field
  $('input[data-type="number"]').numeric();
});