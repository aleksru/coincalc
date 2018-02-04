window.onload = function(){
	$.ajaxSetup({
  		headers: {
    	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  	}
	});

	$('form').submit(function (e) {
    e.preventDefault();
    var data = $('form').serializeArray();
    $.ajax({
        type: "POST",
        url: 'ajax',
        async: true,
        data: data,
        success: function (msg) {
			$('#res').html(msg);},
        });});
};