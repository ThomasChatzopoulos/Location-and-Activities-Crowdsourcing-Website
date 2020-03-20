var coordinates = {};

var map = L.map('mapid').setView([51.505, -0.09], 13);
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// FeatureGroup is to store editable layers
var drawnItems = L.featureGroup().addTo(map);
//map.addLayer(drawnItems);

//L.control.layers({'drawlayer': drawnItems}, {position: 'topleft', collapsed: false}).addTo(map);

var drawControl = new L.Control.Draw({
  draw: {
    marker: false,
    polyline: false,
    polygon: false,
    circle: false,
    circlemarker: false
  },
  edit: {
    featureGroup: drawnItems
  }
});
map.addControl(drawControl);

//add layer when new polygon is inserted
//get the coordinates of rectangle

map.on(L.Draw.Event.CREATED, function (event){
  var layer = event.layer;
  drawnItems.addLayer(layer);
  var type = event.layerType;
  console.info(event);
  if( type === "rectangle"){
    coordinates[layer._leaflet_id] = layer.getLatLngs();
    console.log(coordinates);
  }
});
//update coordinates of edited layers
map.on('draw:edited', function (e) {
  var layers = e.layers;
  layers.eachLayer(function (layer) {
    coordinates[layer._leaflet_id] = layer.getLatLngs();
    console.log(coordinates);
         });
     });
//remove coordinates of deleted layers
map.on('draw:deleted', function (e) {
  var layers = e.layers;
  layers.eachLayer(function (layer) {
    var lay_id = layer._leaflet_id;
    console.log(lay_id);
    delete coordinates[lay_id];
    console.log(coordinates);
         });
     });
