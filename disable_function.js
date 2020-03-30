
function disable(select1, select2) {
  if (document.getElementById(select1).disabled == false) {
    document.getElementById(select1).disabled = true;
    document.getElementById(select2).disabled = true;
  }else {
    document.getElementById(select1).disabled = false;
    document.getElementById(select2).disabled = false;
  }
}

function disableall(select) {
  for (var i = 0; i < jArray.length; i++) {
    alert(jArray[i]);
  }
  
  document.getElementById(select).disabled = true;
}
