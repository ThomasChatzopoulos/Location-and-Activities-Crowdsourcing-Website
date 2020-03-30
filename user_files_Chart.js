var myChart = document.getElementById('files_per_user').getContext('2d');

var types = Object.keys(records_obj);
var values = Object.values(records_obj);
//replace underscores with whitespace

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
