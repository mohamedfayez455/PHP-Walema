var iteration = $('.i').val().split(',');

           
for(i = 0 ; i < iteration.length ; i++){

	var input_id = iteration[i];

	$(document).on('click' , '.sure-' + input_id , function() {
                            
	   $('#deleteForm-' + input_id).submit();
	});

}

