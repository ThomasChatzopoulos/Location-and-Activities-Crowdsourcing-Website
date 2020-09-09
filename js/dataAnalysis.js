function chart_date_range(a) {
  var startyear = $("#startyearBox").val();
  var endyear = $("#endyearBox").val();
  var select_allyears = $('allYearsCheckBox').is(":checked");
  var startmonth = $("#startmonthBox").val();
  var endmonth = $("#endmonthBox").val();
  var select_allmonths = $('allMonthsCheckBox').is(":checked");
  var submit = a;

  $.ajax({
    type: 'POST',
    url: "userDataAnalysis.php",
    data: {
      startyear: startyear,
      endyear: endyear,
      select_allyears: select_allyears,
      startmonth: startmonth,
      endmonth: endmonth,
      select_allmonths: select_allmonths,
      submit: submit,
    },
    dataType: 'json',
    success: function(data) {
      if (data.result1[0] == true) {
        $("#startyear").addClass("input-error");
        $("#endYear").addClass("input-error");
        alert("start year cannot be less than end year");
      }
      if (data.result1[1] == true) {
        $("#startmonth").addClass("input-error");
        $("#endmonth").addClass("input-error");
        alert("start month cannot be less than end month");
      }
      if(data.result2 != null) {
        user_activity_distribution(data.result2[0],data.result2[1],data.result2[2]);
      }
      if(data.result3 != null) {
        user_best_hour_per_activity(data.result3);
      }
      if(data.result4 != null) {
        user_best_day_per_activity(data.result4);
      }
      if(data.result5 != null) {
        heatmapLayer.setData(data.result5);
        layer = heatmapLayer;
        alert("Success");
      }
    },
    error: function(xhr, status, error) {
      alert(xhr.responseText);
    },
  });
}

function user_activity_distribution(activities_obj,colours_obj_act,act_table) {
  var counter = 0;
  $.each(act_table, function (key, val) {
    $("<tr><th style='text-align:center;' scope='row'><b>" + key + "</b></th><td id= '_" + key + "'></td><td style='text-align:center;'><b>" + val + "% </b></td></tr>").appendTo("#act_table");
    $("#_" + key).css("background-color", colours_obj_act[counter]);
    counter += 1;
  });

  var myChart = $('#activity_chart');

  var types = Object.keys(activities_obj);
  var values = Object.values(activities_obj);
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
}

function user_best_hour_per_activity(activities_per_hour) {
  $.each(activities_per_hour, function (key, val) {
    $("<tr><th style='text-align:center;' scope='row'><b>" + key + "</b></th><td style='text-align:center;'><b>" + val + "</b></td></tr>").appendTo("#activities_per_hour_table");
  });
}

function user_best_day_per_activity(activities_per_day) {
  $.each(activities_per_day, function (key, val) {
    $("<tr><th style='text-align:center;' scope='row'><b>" + key + "</b></th><td style='text-align:center;'><b>" + val + "</b></td></tr>").appendTo("#activities_per_day_table");
  });
}
