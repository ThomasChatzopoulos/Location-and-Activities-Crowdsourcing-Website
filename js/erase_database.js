$(document).ready(function (e) {
	$('#erase_database').on('click', function () {
    $.ajax({
			url: 'erase_database.php',
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			type: 'post',
      success: function (data) {
				// alert(data);
        if(data=="Success"){
          alert("Database successfully erased!");
        }
				else if(data=="Fail") {
					alert("Failed ");
				}
      },
  	});
	});
});
