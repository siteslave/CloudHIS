/**
 * @author Satit
 */

$(function(){
	var MCH = {};
	MCH.modal = {};
	
	// show service mch
	$('a[data-name="service-mch"]').click(function(){
		MCH.modal.showMain();
	});
	
	/** show modal **/
	MCH.modal.showMain = function()
	{
		$( 'div[data-name="modal-mch"]' ).modal('show').css({
			width: 700,
			'margin-left': function () { return -($(this).width() / 2); }
		});
	};

});
