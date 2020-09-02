function date_ranges(a, b) {
  var startyear = $("#startyearBox").val();
  var endyear = $("#endyearBox").val();
  var select_allyears = $("#allYearsCheckBox").val();
  var startmonth = $("#startmonthBox").val();
  var endmonth = $("#endmonthBox").val();
  var select_allmonths = $("#allMonthsCheckBox").val();
  var startday = $("#startdayBox").val();
  var endday = $("#enddayBox").val();
  var select_alldays = $("#allDaysCheckBox").val();
  var starthour = $("#starthourBox").val();
  var endhour = $("#endhourBox").val();
  var select_allhours = $("#allHoursCheckBox").val();
  var select_all_activities = $("#allActivitiesCheckBox").val();
  var submit = a;
  var exp_type = $("#exportselectBox").val();
  var exp_submit = b;
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
              submit: submit,
              exp_submit: exp_submit,
              exp_type: exp_type
            },
            dataType: 'json',
            success: function(data) {
              // if (data.result1[0] == true || data.result1[1] == true || data.result1[2] == true || data.result1[3] == true || data.result1[4] == true) {
              //   alert('failed');
              // }
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
                alert("Success!");
              }
              // alert(data_object.result2);
            },
            error: function(xhr, status, error) {
              alert(xhr.responseText);
            },
  });
}
