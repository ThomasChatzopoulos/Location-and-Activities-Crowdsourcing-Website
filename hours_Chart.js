var myChart = document.getElementById('myChart5').getContext('2d');

var types = Object.keys(hours_obj);
var values = Object.values(hours_obj);
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


var DonChart = new Chart(myChart, {
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
    circumference : Math.PI,
    rotation: -Math.PI,
    title:{
      display:true,
      text:"hours",
      fontSize:25
    },
    legend:{
      position: 'right'
    }
  }
});
