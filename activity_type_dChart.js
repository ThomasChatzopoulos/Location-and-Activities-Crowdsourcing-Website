var myChart = document.getElementById('myChart').getContext('2d');

var types = Object.keys(activities_obj);
var values = Object.values(activities_obj);
//replace underscores with whitespace
for (j = 0; j < types.length; j++)
{
  types[j] = types[j].replace(/_/g, " ");
}
// console.log(types);
// console.log(values);

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
      text:"potato123",
      fontSize:25
    },
    legend:{
      position: 'right'
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
