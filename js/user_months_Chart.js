$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: "charts_data/12_months_user_eco_data.php",
    dataType: 'json',
    error: function(xhr, status, error) {
      alert(xhr.responseText);
    },
    success: function(data) {
      var months_obj = data[0];
      var colours_obj_months = data[1];
      var score_table = data[2];

      var counter = 0;
      $.each(score_table, function (key, val) {
        $("<tr><th style='text-align:center;'scope='row'><b>" + key + "</b></th><td id= '_" + key + "'></td><td style='text-align:center;'><b>" + val + "</b>%</td></tr>").appendTo("#score_table");
        $("#_" + key).css("background-color", colours_obj_months[counter]);
        counter += 1;
      });

      var myChart = $('#user_months_chart');
      var types = Object.keys(months_obj);
      var values = Object.values(months_obj);
      //replace underscores with whitespace

      var colours = Object.values(colours_obj_months);

      var barChart = new Chart(myChart, {
        type: 'bar',
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
          title:{
            display:true,
          text:"Score per month",
          fontSize:25
        },
        legend:{
          display:false,
        },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true,
              }
            }]
          }
        }
      });
    }
  });
});
