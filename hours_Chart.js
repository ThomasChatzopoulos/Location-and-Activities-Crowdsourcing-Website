var myChart = document.getElementById('hours_chart').getContext('2d');

var types = Object.keys(hours_obj);
var values = Object.values(hours_obj);
//replace underscores with whitespace

var colours = Object.values(colours_obj_hours);

var DonChart = new Chart(myChart, {
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
    circumference : Math.PI,
    rotation: -Math.PI,

    legend:{
      display: false
    }
  }
});
