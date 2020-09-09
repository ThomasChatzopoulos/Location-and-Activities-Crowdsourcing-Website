<?php
//if it returns 1 its inside else 0
function contains($bounds, $lat, $lng)
{
  $outside = false;
  $polyX = array();
  $polyY = array();
  foreach ($bounds as $key_1 => $val_1) {
    foreach ($val_1 as $key_2 => $val_2) {
      if($key_2 == "lat")
      {
        array_push($polyX, number_format($val_2, 7));
      }
      else if($key_2 == "lng") {
        array_push($polyY, number_format($val_2, 7));
      }
    }
  }
  for($i=0; $i<=3; $i++)
  {
    if($polyX[$i] == min($polyX) &&  $polyY[$i] == max($polyY)) {
      $ax = $polyX[$i];
      $ay = $polyY[$i];
    }
    if($polyX[$i] == max($polyX) &&  $polyY[$i] == min($polyY)) {
      $ix = $polyX[$i];
      $iy = $polyY[$i];
    }
  }
  if( $ix >= $lat && $lat >= $ax && $iy <= $lng && $lng <= $ay ) {
    return true;
  }
  else {
      return false;
  }
}

?>
