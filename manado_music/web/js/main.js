$(function(){	
	$('#modalButton').click(function (){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
	});
	$('#modalPrintJalan').click(function (){
		$('#printModal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
	});
});