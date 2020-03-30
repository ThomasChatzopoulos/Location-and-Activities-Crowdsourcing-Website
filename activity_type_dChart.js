
var myChart = document.getElementById('activity_chart').getContext('2d');

var types = Object.keys(activities_obj);
var values = Object.values(activities_obj);
//replace underscores with whitespace
for (j = 0; j < types.length; j++)
{
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

// options.maintainAspectRatio =
//   $(window).width() < width_threshold ? false : true;
