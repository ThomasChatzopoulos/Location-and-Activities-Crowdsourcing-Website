$(document).ready(function() {
  $.ajax({
    type: 'POST',
    url: "charts_data/top_3_users.php",
    dataType: 'json',
    error: function(xhr, status, error) {
      alert(xhr.responseText);
    },
    success: function(data) {
    var  top_users_table = data[0];
    var  users_rank_table = data[1];

      var counter=0;
      $.each(top_users_table, function (key, val) {
        if(key == 'You'){
          $("<tr><th style='background-color:#51A77E;text-align:center;' scope='row'; ><b>" + users_rank_table[counter] + "</b></th><td style='background-color:#51A77E;text-align:center;' scope='row'><b>" + key + "</b></td><td style='background-color:#51A77E;text-align:center;' scope='row'><b>" + val + "</b>%</td></tr>").appendTo("#top_users_table");
        }
        else{
          $("<tr><th style='text-align:center; scope='row'><b>" + users_rank_table[counter] + "</b></th><td style='text-align:center; scope='row'><b>" + key + "</b></td><td style='text-align:center; scope='row'><b>" + val + "</b>%</td></tr>").appendTo("#top_users_table");
        }
        counter+=1;
      });
    }
  });
});
