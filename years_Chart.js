$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: "charts_data/years_data.php",
    dataType: 'json',
    error: function(xhr, status, error) {
    alert(xhr.responseText);
    },
    success: function(data) {
      var years_obj = data[0];
      var colours_obj_years = data[1];
      var years_table = data[2];

      var counter = 0;
      $.each(years_table, function (key, val) {
        $("<tr><th scope='row'><b>" + key + "</b></th><td id= '_" + key + "'></td><td><b>" + val + "</b></td></tr>").appendTo("#years_table");
        $("#_" + key).css("background-color", colours_obj_years[counter]);
        counter += 1;
      });

      var myChart = $('#years_chart');

      var types = Object.keys(years_obj);
      var values = Object.values(years_obj);

      var colours = Object.values(colours_obj_years);

      Chart.defaults.global.defaultFontColor = 'white';

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
            display: false
          }
        }
      });
    }
  });
});
