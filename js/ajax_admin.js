function date_ranges(a, b) {
  var startyear = $("#startyearBox").val();
  var endyear = $("#endyearBox").val();
  var startmonth = $("#startmonthBox").val();
  var endmonth = $("#endmonthBox").val();
  var startday = $("#startdayBox").val();
  var endday = $("#enddayBox").val();
  var starthour = $("#starthourBox").val();
  var endhour = $("#endhourBox").val();
  var submit = a;
  var exp_type = $("#exportselectBox").val();
  var exp_submit = b;
  $.ajax({
            type: 'POST',
            url: "admin.php",
            data: {
              startyear: startyear,
              endyear: endyear,
              startmonth: startmonth,
              endmonth: endmonth,
              startday: startday,
              endday: endday,
              starthour: starthour,
              endhour: endhour,
              submit: submit,
              exp_submit: exp_submit,
              exp_type: exp_type
            },
            dataType: 'json',
            success: function(data) { // TODO: για κάποιο λόγο το data δεν περνιέται σωστά (αντί για πίνακα περνιέται σαν string)
              if (data[0] == true || data[1] == true || data[2] == true || data[3] == true || data[4] == true) {
                alert('failed');
              }
              if (data[0] == true) {
                $("#startyear").addClass("input-error");
                $("#endYear").addClass("input-error");
                alert("start year cannot be less than end year");
              }
              if (data[1] == true) {
                $("#startmonth").addClass("input-error");
                $("#endmonth").addClass("input-error");
                alert("start month cannot be less than end month");
              }

              if (data[2] == true) {
                $("#startday").addClass("input-error");
                $("#endday").addClass("input-error");
                alert("start days cannot be less than end day");
              }
              if (data[3] == true) {
                $("#starthour").addClass("input-error");
                $("#endhour").addClass("input-error");
                alert("start hour cannot be less than end hour");
              }
            },
            error: function(xhr, status, error) {
              alert(xhr.responseText);
            },
  });
}
