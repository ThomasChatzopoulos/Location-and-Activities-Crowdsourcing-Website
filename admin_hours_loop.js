$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: "hours_loop.php",
    dataType: 'json',
    error: function(xhr, status, error) {
      alert(xhr.responseText);
    },
    success:
    function(data) {
      var hours = data[0];
      for (var i = 0; i < hours.length; i++) {
        var x = document.getElementById("starthourBox");
        var option = document.createElement("option");
        option.text = hours[i];
        x.add(option);
      }

      for (var i = 0; i < hours.length; i++) {
        var x = document.getElementById("endhourBox");
        var option = document.createElement("option");
        option.text = hours[i];
        x.add(option);
      }
    }

  });
});
