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
}
// convert mysql date to thai date
var toThaiDate = function( d ) {
	var _d = d.split('-'),
					_y = parseInt(_d[0]) + 543,
					_m = _d[1],
					_d = _d[2],
						
					_date = _d + '/' + _m + '/' + _y ;
					
	return _date;
}