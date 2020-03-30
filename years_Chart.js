var myChart = document.getElementById('years_chart').getContext('2d');

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
