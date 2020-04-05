$(document).ready(function (e) {
		$('#upload').on('click', function () {
			var file_data = $('#file').prop('files')[0];
			var form_data = new FormData();
			form_data.append('file', file_data);
			$.ajax({
				url: 'file_upload.php',
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function (data) {
          if(data[0] == false && data[1] == false && data[2] == false && data[3] == false) {
            $('#msg').html("<span style='color:lawngreen;'>File '"+ data[4] +"' successfully uploaded. Ιt will take us a while for your data to be available.</span>");
            var url = "data_Insertion.php";
            var insertion_window=window.open(url, "_blank").blur();
          }
          if(data[0] == true){
            $('#msg').html("<span style='color:red;'>Error during '"+ data[4] +"' file uploading. Please try again!</span>");
          }
          if(data[1] == true){
            $('#msg').html("<span style='color:red;'>File with the same name already exists ('"+data[4]+"').Try again or rename your file.</span>");
          }
          if(data[2] == true){
            $('#msg').html("<span style='color:red;'>Please choose a file!</span>");
          }
          if(data[3] == true){
            $('#msg').html("<span style='color:red;'>Please choose a json file (.json)</span>");
          }
				},
        error: function(xhr, status, error) {
          alert(xhr.responseText);
        },
			});
		});
	});
