$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: "charts_data/hours_data.php",
    dataType: 'json',
    error: function(xhr, status, error) {
    alert(xhr.responseText);
    },
    success: function(data) {
      var hours_obj = data[0];
      var colours_obj_hours = data[1];
      var hours_table = data[2];

      var counter = 0;
      $.each(hours_table, function (key, val) {
        $("<tr><th scope='row'><b>" + key + "</b></th><td id= '_" + key + "'></td><td><b>" + val + "</b></td></tr>").appendTo("#hours_table");
        $("#_" + key).css("background-color", colours_obj_hours[counter]);
        counter += 1;
      });

      var myChart = $('#hours_chart');

      var types = Object.keys(hours_obj);
      var values = Object.values(hours_obj);
      //replace underscores with whitespace

      var colours = Object.values(colours_obj_hours);

      var DonChart = new Chart(myChart, {
        type: 'doughnut',
        data:{
          labels:types,
          datasets:[{
            label:'Percentage',
            data:values,
            fill: false,
            backgroundColor: colours,
            cubicInterpolationMode: "monotone",
            borderColor: "rgba(0,0,0,0)"
          }]
        },
        options: {
          circumference : Math.PI,
          rotation: -Math.PI,

          legend:{
            display: false
          }
        }
      });
    }
  });
});
