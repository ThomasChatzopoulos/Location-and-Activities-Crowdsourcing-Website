$('#file_form').submit(function(e) {
  e.preventDefault();
  var file_data = $('#file').prop('files')[0];
  var form_data = new FormData(this);
  form_data.append('file', file_data);
  $.ajax({
    url: 'file_upload.php',
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    type: 'POST',
    success: function(data) {
      if (data[0] == false && data[1] == false && data[2] == false && data[3] == false) {
        var last_uploaded_file_name = data[5];
        var coordinates_string = JSON.stringify(coordinates);
        $.ajax({
          type: 'POST',
          url: "data_Insertion.php",
          data: {
            last_uploaded_file_name: last_uploaded_file_name,
            coordinates_string: coordinates_string,
          },
          dataType: 'json',
          success: function(data2) {
            console.log(data2);
            if (data2) {
              alert("Duplicate entries were detected!");
            } else {
              alert("File uploaded successfully!");
            }

          },
          error: function(xhr, status, error) {
            alert(xhr.responseText);
          }
        });
        $('#msg').html("<span style='color:lawngreen;'>File '" + data[4] + "' is being uploaded. Ιt will take us a while for your data to be available.</span>");
      } else {
        if (data[0] == true) {
          // $('#msg').html("<span style='color:red;'>Error during '"+ data[4] +"' file uploading. Please try again!</span>");
          alert("Error during '" + data[4] + "' file uploading. Please try again!");
        }
        if (data[1] == true) {
          // $('#msg').html("<span style='color:red;'>File with the same name already exists ('"+data[4]+"'). Rename your file, or try again (we will do our best)!</span>");
          alert("File with the same name already exists ( '" + data[4] + "' ). Rename your file, or try again (we will do our best)!");
        }
        if (data[2] == true) {
          // $('#msg').html("<span style='color:red;'>Please choose a file!</span>");
          alert("Please choose a file!");
        }
        if (data[3] == true) {
          // $('#msg').html("<span style='color:red;'>Please choose a json file (.json)</span>");
          alert("Please choose a json file (.json)");
        }
      }
    },
    error: function(xhr, status, error) {
      alert(xhr.responseText);
    },
  });
});
