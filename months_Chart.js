var myChart = document.getElementById('months_chart').getContext('2d');

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
