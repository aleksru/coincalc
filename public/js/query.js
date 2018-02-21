window.onload = function(){
	$.ajaxSetup({
  		headers: {
    	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  	}
	});

	$('form#postindex').submit(function (e) {
        e.preventDefault();
        var data = $('form#postindex').serializeArray();
        $('#res').html("");
        $("#btn").attr('disabled',true);
        $.ajax({
            type: "POST",
            url: 'ajax',
            async: true,
            data: data,
            success: function (msg) {
    			$('#res').html(msg);
                $("#btn").removeAttr('disabled');
                $("#result").tablesorter();
            },
        });
    });

    $('form#videocart').change(function (e) {
        e.preventDefault();
        var data = $('form#videocart').serializeArray();
        //$('.encrypt input').val('');
        $.ajax({
            type: "POST",
            url: 'posthash',
            async: true,
            data: data,
            success: function (msg) {
                //$('#res').html(msg);
                if(msg.length == 0){
                    $('.encrypt input').val('');
                }
                $.each(msg, function(i, item){
                    //console.log(item);
                    //console.log($("input."+i).val(item));
                    $('input.'+ i).val(item);
                });
            },
        });
    });
};