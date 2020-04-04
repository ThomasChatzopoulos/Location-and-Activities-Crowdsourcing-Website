$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: "charts_data/user_file_data.php",
    dataType: 'json',
    error: function(xhr, status, error) {
      alert(xhr.responseText);
    },
    success: function(data) {
      var file_table = data[0];

      $.each(file_table, function (key, val) {
        $("<tr><th style='text-align:center;' scope='row'><b>" + key + "</b></th><td style='text-align:center; scope='col'><b>" + val + "</b></td></tr>").appendTo("#file_table");
      });
    }
  });
});
