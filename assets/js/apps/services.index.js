$(function(){
	$('table[data-rel="tblservice-main"]').tablesorter({ sortList: [[0,1]] });
	$('table[data-rel="tblservice-main"] tr').click(function(){
		window.location = _base_url + 'services/detail/' + $(this).attr('data-vn');
	});
	$('table[data-rel="tblservice-main"] tr').hover(function(){
		$(this).addClass('highlight')
	},function(){
		$(this).removeClass('highlight')
	});
});