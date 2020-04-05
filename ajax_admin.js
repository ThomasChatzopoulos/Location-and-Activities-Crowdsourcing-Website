$(document).ready(function() {
  $(this).submit(function(event) {
    event.preventDefault();
    var startyear = $("#startyearBox").val();
    var endyear = $("#endyearBox").val();
    var startmonth = $("#startmonthBox").val();
    var endmonth = $("#endmonthBox").val();
    var startday = $("#startdayBox").val();
    var endday = $("#enddayBox").val();
    var starthour = $("#starthourBox").val();
    var endhour = $("#endhourBox").val();

    $.ajax({
              type: 'POST',
              url: "admin.php",
              datatype: 'json',
              success: function(data) { // TODO: για κάποιο λόγο το data δεν περνιέται σωστά (αντί για πίνακα περνιέται σαν string)
                alert(data);
                if (data[0] == false && data[1] == false && data[2] == false && data[3] == false) {
                  alert('success');
                  window.location = "admin.php";
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

              }
    });
  });
});
