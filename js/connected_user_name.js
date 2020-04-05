$(document).ready(function() {
  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: "connected_user_name.php",
    error: function(xhr, status, error) {
      alert(xhr.responseText);
    },
    success: function(data) {
      var user_name = data[0];
      $('#user_name').append(user_name);
    }
  });
});
