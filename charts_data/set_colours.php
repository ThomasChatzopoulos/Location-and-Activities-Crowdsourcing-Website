<?php

function set_Chart_colours($distinct_keys)
{
  $colours_vec = ['slateblue', 'darkred', 'violet', 'orange', 'olivedrab', 'sienna', 'grey', 'yellow', 'royalblue', 'indigo', 'cyan', 'red'] ;
  $colours = array();
  if (sizeof($colours_vec) > sizeof($distinct_keys)) {
    for ($j=0; $j < sizeof($distinct_keys); $j++) {
      $colours[$j] = $colours_vec[$j];
    }
  }
  elseif (sizeof($colours) < sizeof($distinct_keys)) {
    $colours = $colours_vec;
    for ($i= sizeof($colours); $i < sizeof($distinct_keys) ; $i++) {
      $r= rand(0, 255);
      $g= rand(0, 255);
      $b= rand(0, 255);
      $colour_rand = "rgb($r, $g, $b)";
      array_push($colours, $colour_rand);
    }
  }
  else {
    $colours = $colours_act;
  }
  return $colours;
}

?>
