function Multidelete() {

	$(document).on('click', '.deleteBtn', function() {


		$('#multipleDelete').modal('show');

		var checkboxLength = $('input[class="items"]:checked').length ;

		if(checkboxLength > 0){

			$('.empty_record').addClass('hidden');

			$('.not_empty_record').removeClass('hidden');

			$('.record_count').text(checkboxLength);			

		}else{

			$('.empty_record').removeClass('hidden');

			$('.not_empty_record').addClass('hidden');

			$('.record_count').text('');	
		}



	});

	$(document).on('click', '.del_all', function() {

		$('#dataForm').submit();

	});

}

function checkAllItem() {

	$('input[class="items"]:checkbox').each(function() {
		
		if ($('input[class="check_all_items"]:checkbox:checked').length == 0 ) {
			$(this).prop('checked' , false);
		}else{
			$(this).prop('checked' , true);
		}

	});

}