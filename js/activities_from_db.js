$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: "activities_from_db.php",
    dataType: 'json',
    error: function(xhr, status, error) {
      alert(xhr.responseText);
    },
    success: function(data) {
      var act_table = data[0];
      $.each(act_table, function (key, val) {
        $("<tr><th scope='row'></th><td scope='col'><input class='act_checkboxes' type='checkbox' value = 'Yes' id = '" + val + "' name = '" + val +  "'/><b>" + "            " + val + "</b></td></tr>").appendTo("#act_table");
      });
    }
  });
});
