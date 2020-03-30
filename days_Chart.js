var myChart = document.getElementById('days_chart').getContext('2d');

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
