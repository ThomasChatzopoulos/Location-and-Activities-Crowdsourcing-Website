$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: "charts_data/activity_type_data.php",
    dataType: 'json',
    error: function(xhr, status, error) {
    alert(xhr.responseText);
    },
    success: function(data) {
      var activities_obj = data[0];
      var colours_obj_act = data[1];
      var act_table = data[2];

      var counter = 0;
      $.each(act_table, function (key, val) {
        $("<tr><th scope='row'><b>" + key + "</b></th><td id= '_" + key + "'></td><td><b>" + val + "</b></td></tr>").appendTo("#act_table");
        $("#_" + key).css("background-color", colours_obj_act[counter]);
        counter += 1;
      });

      var myChart = $('#activity_chart');

      var types = Object.keys(activities_obj);
      var values = Object.values(activities_obj);
      //replace underscores with whitespace
      for (j = 0; j < types.length; j++) {
        types[j] = types[j].replace(/_/g, " ");
      }

      var colours = Object.values(colours_obj_act);

      var barChart = new Chart(myChart, {
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
          legend:{
            display:false
          },
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
        }
      });
      }
    });
});
// options.maintainAspectRatio =
//   $(window).width() < width_threshold ? false : true;
