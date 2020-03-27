var myChart = document.getElementById('years_chart').getContext('2d');

var types = Object.keys(years_obj);
var values = Object.values(years_obj);
//replace underscores with whitespace

var colours = [];
colours.length = types.length;
for (i = 0; i < colours.length; i++)
{
  var r = Math.floor(Math.random() * 255);
  var g = Math.floor(Math.random() * 255);
  var b = Math.floor(Math.random() * 255);
  colours[i] = "rgb(" + r + "," + g + "," + b + ")";
}


var barChart = new Chart(myChart, {
  type: 'doughnut',
  data:{
    labels:types,
    datasets:[{
      label:'Percentage',
      data:values,
      backgroundColor: colours
    }]
  },
  options: {
    title:{
      display:true,
      text:"Years distribution",
      fontSize:25
    },
    legend:{
      position: 'right'
    }
  }
});
