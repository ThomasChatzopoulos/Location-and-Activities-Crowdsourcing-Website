$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: "charts_data/days_data.php",
    dataType: 'json',
    error: function(xhr, status, error) {
    alert(xhr.responseText);
    },
    success: function(data) {
      var days_obj = data[0];
      var colours_obj_days = data[1];
      var days_table = data[2];

      var counter = 0;
      $.each(days_table, function (key, val) {
        $("<tr><th scope='row'><b>" + key + "</b></th><td id= '_" + key + "'></td><td><b>" + val + "</b></td></tr>").appendTo("#days_table");
        $("#_" + key).css("background-color", colours_obj_days[counter]);
        counter += 1;
      });

      var myChart = $('#days_chart');


      var types = Object.keys(days_obj);
      var values = Object.values(days_obj);
      //replace underscores with whitespace

      var colours = Object.values(colours_obj_days);


      var barChart = new Chart(myChart, {
        type: 'pie',
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
          legend:{
            display: false
          }
        }
      });
    }
  });
});
