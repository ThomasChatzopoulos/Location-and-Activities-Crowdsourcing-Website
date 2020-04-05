$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: "years_loop.php",
    dataType: 'json',
    error: function(xhr, status, error) {
      alert(xhr.responseText);
    },
    success:
    function(data) {
      var years = data[0];
      for (var i = 0; i < years.length; i++) {
        var x = document.getElementById("startyearBox");
        var option = document.createElement("option");
        option.text = years[i];
        x.add(option);
      }

      for (var i = 0; i < years.length; i++) {
        var x = document.getElementById("endyearBox");
        var option = document.createElement("option");
        option.text = years[i];
        x.add(option);
      }
    }

  });
});
