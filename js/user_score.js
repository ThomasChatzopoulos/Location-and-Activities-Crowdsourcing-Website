$(document).ready(function() {
  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: "user_score.php",
    error: function(xhr, status, error) {
      alert(xhr.responseText);
    },
    success: function(data) {
      var current_month = data[0];
      var month_score = data[1];

      // $("Your score for " + current_month + ": " + month_score).appendTo('#user_score');

      $('#user_score').append("Your score for " + current_month + ": " + month_score + "%");

    }
  });
});
