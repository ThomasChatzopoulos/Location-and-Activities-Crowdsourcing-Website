<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"/> //draw

    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script> //draw
    <style>
      #mapid {position: absolute; top: 0; bottom: 0; left: 0; right: 0;}
    </style>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div id="mapid"></div>
    <?php require 'heatmap_data.php' ?>
    <script>
     var dataPoints = '<?php echo json_encode($data_points) ?>';
     data_object = JSON.parse(dataPoints);
     //console.log(data_object);
     </script>
    <script src="polygon.js">
    </script>
  </body>
</html>
