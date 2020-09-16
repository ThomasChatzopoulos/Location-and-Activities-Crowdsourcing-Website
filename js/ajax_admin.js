var activarray= "";
function date_ranges(a, b) {
  $.ajax({
    type: 'POST',
    url: "activities_from_db.php",
    dataType: 'json',
    error: function(xhr, status, error) {
      alert(xhr.responseText);
    },
    success: function(data) {
      var act_table = data[0];
      activarray= "false";
      $.each(act_table, function (key, val) {
        if($('#'+val).is(":checked")){
          activarray = activarray.concat(val, '.');
        }
      });
    var startyear = $("#startyearBox").val();
    var endyear = $("#endyearBox").val();
    var select_allyears = $("#allYearsCheckBox").is(":checked");
    var startmonth = $("#startmonthBox").val();
    var endmonth = $("#endmonthBox").val();
    var select_allmonths = $("#allMonthsCheckBox").is(":checked");
    var startday = $("#startdayBox").val();
    var endday = $("#enddayBox").val();
    var select_alldays = $("#allDaysCheckBox").is(":checked");
    var starthour = $("#starthourBox").val();
    var endhour = $("#endhourBox").val();
    var select_allhours = $("#allHoursCheckBox").is(":checked");
    var select_all_activities = $("#allActivitiesCheckBox").is(":checked");
    var submit = a;
    var exp_type = $("#exportselectBox").val();
    var exp_submit = b;

    if(startyear==="" && endyear==="" && select_allyears==false) {
      alert("Year range required");
    }
    else if(startmonth==="" && endmonth==="" && select_allmonths==false) {
      alert("Month range required");
    }
    else if(startday==="" && endday==="" && select_alldays==false) {
      alert("Day range required");
    }
    else if(starthour==="" && endhour==="" && select_allhours==false) {
      alert("Hour range required");
    }
    else if(activarray == "false" && select_all_activities==false) {
      alert("Activity type required");
    }
    else {
      $.ajax({
        type: 'POST',
        url: "admin.php",
        data: {
          startyear: startyear,
          endyear: endyear,
          select_allyears: select_allyears,
          startmonth: startmonth,
          endmonth: endmonth,
          select_allmonths: select_allmonths,
          startday: startday,
          endday: endday,
          select_alldays: select_alldays,
          starthour: starthour,
          endhour: endhour,
          select_allhours: select_allhours,
          select_all_activities: select_all_activities,
          activarray: activarray,
          submit: submit,
          exp_submit: exp_submit,
          exp_type: exp_type

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
          if (data.result1[2] == true) {
            $("#startday").addClass("input-error");
            $("#endday").addClass("input-error");
            alert("start days cannot be less than end day");
          }
          if (data.result1[3] == true) {
            $("#starthour").addClass("input-error");
            $("#endhour").addClass("input-error");
            alert("start hour cannot be less than end hour");
          }
          if(data.result2 != null) {
            heatmapLayer.setData(data.result2);
            layer = heatmapLayer;
            alert("Success (heatmap)!");
          }
          if(data.result3 != null) {
            $.each(data.result3, function (key, val) {
              var type = data.result3[0].split('.').pop();
              var newFileName = "data_export."+type;
              document.getElementById("download").innerHTML = '<br><p><a id = "link" href="export_files/'+data.result3+'" download="'+newFileName+'"></a></p>';
              document.getElementById("link").click();
            });
            var filename = "export_files/"+data.result3[0];
            $.ajax({
              type: 'POST',
              url: "delete_file.php",
              data: {
                filename: filename
              },
              dataType: 'json',
              error: function(xhr, status, error) {
                alert(xhr.responseText);
              },
              success: function(data) {
              }
            });
          }
        },
        error: function(xhr, status, error) {
          console.log(xhr);
          console.log(error);
          console.log(status);
        }
      });
    }
  }
});
}
