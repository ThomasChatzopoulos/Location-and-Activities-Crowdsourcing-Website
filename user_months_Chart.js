var myChart = document.getElementById('user_months_chart').getContext('2d');

var types = Object.keys(months_obj);
var values = Object.values(months_obj);
//replace underscores with whitespace

var colours =  Object.values(colours_obj_months);
Chart.defaults.global.defaultFontColor = 'white';


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
