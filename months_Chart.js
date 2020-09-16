
$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: "charts_data/months_data.php",
    dataType: 'json',
    error: function(xhr, status, error) {
    console.log(xhr.responseText);
    },
    success: function(data) {
      var months_obj = data[0];
      var colours_obj_months = data[1];
      var months_table = data[2];

      var counter = 0;
      $.each(months_table, function (key, val) {
        $("<tr><th scope='row'><b>" + key + "</b></th><td id= '_" + key + "'></td><td><b>" + val + "</b></td></tr>").appendTo("#months_table");
        $("#_" + key).css("background-color", colours_obj_months[counter]);
        counter += 1;
      });

      var myChart = $('#months_chart');

      var types = Object.keys(months_obj);
      var values = Object.values(months_obj);
      //replace underscores with whitespace

      var colours = colours_obj_months;

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
