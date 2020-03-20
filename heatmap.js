var baseLayer = L.tileLayer(
  'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
    maxZoom: 18
  }
);

var testData = {max: 8, data: [{latitude: 38.246242, longitude:21.735085, count:3}, {latitude: 38.323343, longitude:21.865082, count:2},
   {latitude: 38.34381, longitude:21.57074, count:8}, {latitude: 38.108628, longitude:21.502075, count:7},{latitude: 38.123034, longitude:21.917725, count:4}]};


var cfg = {"radius": 40,"maxOpacity": 0.8,"scaleRadius": false,"useLocalExtrema": false,latField: 'latitude',lngField: 'longitude',valueField: 'count'};
var heatmapLayer = new HeatmapOverlay(cfg);




var map = new L.Map('mapid', {
  center: new L.LatLng(38.2462420, 21.7350847),
  zoom: 16,
  layers: [baseLayer, heatmapLayer]
});

var polygon = L.polygon([[38.246501, 21.734122],[38.246960, 21.734781],[38.245999, 21.736074],[38.245490, 21.735425]]).addTo(map);

heatmapLayer.setData(data_object);

layer = heatmapLayer;
