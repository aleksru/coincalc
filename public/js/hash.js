window.onload = function(){
	$.ajaxSetup({
  		headers: {
    	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  	}
	});

	$('.videocart').change(function (e) {
        e.preventDefault();
        var data = $('.videocart').serializeArray();
        //$('input').val('');
        $.ajax({
            type: "POST",
            url: 'posthash',
            async: true,
            data: data,
            success: function (msg) {
    			$('#res').html(msg);
                $.each(msg, function(i, item){
                    console.log(item);
                    console.log($("input."+i).val(item));
                    $('input.i').val(item);
                });
            },
        });
    });
};