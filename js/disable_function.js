function disableFunction() {
  var checkBox = document.getElementById(arguments[0]);
  var i;

  if(checkBox.checked == true){
    for(i=1; i<arguments.length; i++){
      document.getElementById(arguments[i]).disabled = true;
    }
  }
  else if(checkBox.checked == false){
    for(i=1; i<arguments.length; i++){
      document.getElementById(arguments[i]).disabled = false;
    }
  }
}

function disableActivities(checkbox_id) {
  var checkBox = document.getElementById(checkbox_id);
  if(checkBox.checked == true){
    $(".act_checkboxes:checkbox").attr("disabled", true);
  }
  else if(checkBox.checked == false){
    $(".act_checkboxes:checkbox").removeAttr("disabled");
  }
}
