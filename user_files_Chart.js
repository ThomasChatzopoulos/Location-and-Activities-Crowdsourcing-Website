$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: "charts_data/user_files_data.php",
    dataType: 'json',
    error: function(xhr, status, error) {
    alert(xhr.responseText);
    },
    success: function(data) {
      var records_obj = data[0];
      var colours_obj_rec = data[1];
      var files_table = data[2];

      var counter = 0;
      $.each(files_table, function (key, val) {
        $("<tr><th scope='row'><b>" + key + "</b></th><td id= '_" + key + "'></td><td><b>" + val + "</b></td></tr>").appendTo("#files_table");
        $("#_" + key).css("background-color", colours_obj_rec[counter]);
        counter += 1;
      });

      var myChart = $('#files_per_user');

      var types = Object.keys(records_obj);
      var values = Object.values(records_obj);

      var colours = Object.values(colours_obj_rec);

      var barChart = new Chart(myChart, {
        type: 'horizontalBar',
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
            text:"Files per User",
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
