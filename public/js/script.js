// autocomplet : this function will be executed every time we change the text
function autocomplet() {
	var min_length = 0; // min caracters to display the autocomplete
	var keyword = $('#country_id').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'autocomplete/ajax_refresh.php?category',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#country_list_id').show();
				$('#country_list_id').html(data);
			}
		});
	} else {
		$('#country_list_id').hide();
	}
}
function autocomplett() {
	var min_length = 0; // min caracters to display the autocomplete
	var keyword = $('#company_id').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'autocomplete/ajax_refresh.php?company',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#company_list_id').show();
				$('#company_list_id').html(data);
			}
		});
	} else {
		$('#company_list_id').hide();
	}
}

function autocomplettt() {
	$('#doc_list_id').show();
	$('#doc_list_id').css('color','#f00');
	$('#doc_list_id').html("Searching for doctors, Keep on typing or wait");
	var min_length = 1; // min caracters to display the autocomplete
	var areas = $('#area').val();
	var keyword = $('#doc_id').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'autocomplete/ajax_refresh.php?docs',
			type: 'POST',
			data: {keyword:keyword,areas:areas},
			success:function(data){
				$('#doc_list_id').show();
				$('#doc_list_id').html(data);
			}
		});
	} else {
		$('#doc_list_id').hide();
	}
}
function autocomplett1() {	
	var min_length = 0; // min caracters to display the autocomplete
	var keyword = $('#info_id').val();
	if (keyword.length >= min_length) {
		$.ajax({
			url: 'autocomplete/ajax_refresh.php?info',
			type: 'POST',
			data: {keyword:keyword},
			success:function(data){
				$('#info_list_id').show();
				$('#info_list_id').html(data);
			}
		});
	} else {
		$('#info_list_id').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item(item) {
	// change input value
	//$('#country_id').val(item);
	$('#country_id').val(item);
	$('#country_list_id').hide();
	// hide proposition list
}
function set_item1(item) {
	// change input value
	//$('#country_id').val(item);
	$('#company_id').val(item);
	$('#company_list_id').hide();
	// hide proposition list
}
function set_item2(item) {
	// change input value
	$('#doc_id').val(item);
	$('#doc_list_id').hide();
	location.href = 'chamber.php?doctorid='+item;
	// hide proposition list
}
function set_item4(item) {
	// change input value
	$('#doc_id').val(item);
	$('#doc_list_id').hide();
	location.href = 'doctors.php?chamber='+item;
	// hide proposition list
}
function set_item7(item) {
	// change input value
	$('#doc_id').val(item);
	$('#doc_list_id').hide();
	location.href = 'doctors.php?specialization='+item;
	// hide proposition list
}
function set_item3(item) {
	// change input value
	//$('#doc_id').val(item);
	$('#info_id').hide();
	$('#info_list_id').hide();
	location.href = 'info.php?cat='+item;
	// hide proposition list
}