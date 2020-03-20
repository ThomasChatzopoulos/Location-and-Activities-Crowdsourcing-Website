<?php
//if it returns 1 its inside else 0
function contains($bounds, $lat, $lng)
{
    $count = 0;
    $bounds_count = count($bounds);
    for ($b = 0; $b < $bounds_count; $b++) {
        $vertex1 = $bounds[$b];
        $vertex2 = $bounds[($b + 1) % $bounds_count];
        if (west($vertex1, $vertex2, $lng, $lat))
            $count++;
    }

    return $count % 2;
}

function west($A, $B, $x, $y)
{
    if ($A['y'] <= $B['y']) {
        if ($y <= $A['y'] || $y > $B['y'] ||
            $x >= $A['x'] && $x >= $B['x']) {
            return false;
        }
        if ($x < $A['x'] && $x < $B['x']) {
            return true;
        }
        if ($x == $A['x']) {
            if ($y == $A['y']) {
                $result1 = NAN;
            } else {
                $result1 = INF;
            }
        } else {
            $result1 = ($y - $A['y']) / ($x - $A['x']);
        }
        if ($B['x'] == $A['x']) {
            if ($B['y'] == $A['y']) {
                $result2 = NAN;
            } else {
                $result2 = INF;
            }
        } else {
            $result2 = ($B['y'] - $A['y']) / ($B['x'] - $A['x']);
        }
        return $result1 > $result2;
    }

    return west($B, $A, $x, $y);
}
