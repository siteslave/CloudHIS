/**
 * @author Satit
 */

$(function(){
	var MCH = {};
	MCH.modal = {};
	
	// show service mch
	$('a[data-name="service-mch-post"]').click(function(){
		MCH.modal.showPost();
	});
	// show service mch
	$('a[data-name="service-mch-pre"]').click(function(){
		MCH.modal.showPre();
	});
	
	
	/** show modal **/
	MCH.modal.showPost = function()
	{
		$( 'div[data-name="modal-mch-post"]' ).modal('show').css({
			width: 640,
			'margin-left': function () { return -($(this).width() / 2); }
		});
	};
	/** show modal **/
	MCH.modal.showPre = function()
	{
		$( 'div[data-name="modal-mch-pre"]' ).modal('show').css({
			width: 640,
			'margin-left': function () { return -($(this).width() / 2); }
		});
	};
});
