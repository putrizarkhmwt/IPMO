//kode point zoom daerah
// SET VIEW PETA PERTAMA KALI
if(kode === "NASIONAL"){
  var longlat = [-0.69231,119.1444803];
  var map = L.map('map').setView(longlat, 5);
}else{
  var point =[{
    "id" : "NANGGROE ACEH DARUSSALAM",
    "longlat" : [4.2322796,96.4033215],
    "size" : 7
  },
  {
    "id" : "JAWA TIMUR",
    "longlat" : [-7.6014965,112.5801271],
    "size" : 8
  },
  {
    "id" : "KALIMANTAN SELATAN",
    "longlat" : [-2.6343217,115.3073116],
    "size" : 8
  },
  {
    "id" : "DAERAH ISTIMEWA YOGYAKARTA",
    "longlat" : [-7.869553,110.3940229],
    "size" : 10
  },
  {
    "id" : "JAWA TENGAH",
    "longlat" : [-6.9646169,109.7490712],
    "size" : 8
  },
  {
    "id" : "KALIMANTAN TENGAH",
    "longlat" : [-1.1361121,113.0338501],
    "size" : 7
  },
  {
    "id" : "JAMBI",
    "longlat" : [-1.5521482,102.2812509],
    "size" : 8
  },
  {
    "id" :  "SUMATERA UTARA",
    "longlat" : [2.3953044,98.6169046],
    "size" : 7
  },
  {
    "id" : "BENGKULU",
    "longlat" : [-3.9906443,101.6835084],
    "size" : 8
  },
  {
    "id" : "GORONTALO",
    "longlat" : [0.7917099,122.2844529],
    "size" : 9
  },
  {
    "id" : "PAPUA",
    "longlat" : [-4.5415215,135.9455496],
    "size" : 6
  },
  {
    "id" : "SUMATERA BARAT",
    "longlat" : [-0.9235858,100.1146716],
    "size" : 7
  },
  {
    "id" : "SUMATERA SELATAN",
    "longlat" : [-3.5023359,103.50682],
    "size" : 7
  },
  {
    "id" : "SULAWESI SELATAN",
    "longlat" : [-4.1717225,119.3036389],
    "size" : 7
  },
  {
    "id" : "BALI",
    "longlat" : [-8.4537138,114.9010767],
    "size" : 9
  },
  {
    "id" : "JAWA BARAT",
    "longlat" : [-6.7765433,107.6921381],
    "size" : 8
  },
  {
    "id" : "SULAWESI TENGGARA",
    "longlat" : [-4.371528,122.0501144],
    "size" : 8
  },
  {
    "id" : "MALUKU",
    "longlat" : [-5.5254808,129.1572817],
    "size" : 7
  },
  {
    "id" : "NUSA TENGGARA BARAT",
    "longlat" : [-8.5254613,117.4017705],
    "size" : 8
  },
  {
    "id" : "RIAU",
    "longlat" : [0.7494461,101.0142776],
    "size" : 7
  },
  {
    "id" : "DKI JAKARTA",
    "longlat" : [-6.1802188,106.8631553],
    "size" : 11
  },
  {
    "id" : "SULAWESI UTARA",
    "longlat" : [2.5151527,123.7690074],
    "size" : 7
  },
  {
    "id" : "NUSA TENGGARA TIMUR",
    "longlat" : [-9.2736384,121.891234],
    "size" : 7
  },
  {
    "id" : "LAMPUNG",
    "longlat" : [-4.8275718,104.6549613],
    "size" : 8
  },
  {
    "id" : "SULAWESI TENGAH",
    "longlat" : [-0.4782995,120.7451479],
    "size" : 7
  },
  {
    "id" : "KALIMANTAN TIMUR",
    "longlat" : [0.2578109,115.9437785],
    "size" : 7
  },
  {
    "id" : "BANTEN",
    "longlat" : [-6.4334899,105.9864929],
    "size" : 9
  },
  {
    "id" : "KALIMANTAN BARAT",
    "longlat" : [-0.2861903,110.7340916],
    "size" : 7
  },
  {
    "id" : "SULAWESI BARAT",
    "longlat" : [-2.245471,119.5971917],
    "size" : 8
  },
  {
    "id" : "KEPULAUAN BANGKA BELITUNG",
    "longlat" : [-2.235817,106.3895384],
    "size" : 8
  },
  {
    "id" : "KEPULAUAN RIAU",
    "longlat" : [2.1351841,107.0840734],
    "size" : 7
  },
  {
    "id" : "MALUKU UTARA",
    "longlat" : [0.1880772,126.2742107],
    "size" : 7
  },
  {
    "id" : "PAPUA BARAT",
    "longlat" : [-1.804178,132.1871844],
    "size" : 7
  },
  {
    "id" : "KALIMANTAN UTARA",
    "longlat" : [2.9030304,116.0518223],
    "size" : 7
  }];
  var longlat = point.filter(d => d.id === kode);
  var map = L.map('map').setView(longlat[0].longlat, longlat[0].size);
}




var token = 'pk.eyJ1Ijoic2Ftc29lYyIsImEiOiJjanE0MWM4MGQxazB5NDJwbDNnbW5rbWkwIn0.x0B1nqBv3o2rP2sE2UbslA';

// MENAMBAHKAN BASE MAP
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + token, {
    id: 'mapbox.streets',
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
}).addTo(map);

// membuat layer group
var layerGroup = L.layerGroup().addTo(map);

// control info ketika hover wilayah
var mapControl = L.control();

// style warna daerah berdasarkan jumlah IKM
function getColor(d) {
  return  d == "Rendah"         ? '#FF4500' :
          d == "Sedang"         ? '#FFA500' :
          d == "Tinggi"         ? '#7CFC00' :
          d == "Sangat Tinggi"  ? '#006400' :
                                  '#FFFFFF';
}

// default style
function style(feature) {
    return {
        fillColor: getColor(feature.properties.segmentasi),
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7
    };
}

// style ketika mouseover aktif
function highlightFeature(e) {
  var layer = e.target;

  layer.setStyle({
      weight: 3,
      color: '#666',
      dashArray: '',
      fillOpacity: 0.7
  });

  if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
      layer.bringToFront();
  }

  info.update(layer.feature.properties);
}

// reset style ketika mouse out
function resetHighlight(e) {
  geojson.resetStyle(e.target);
  info.update();
}

// zoom wilayah ketika wilayah diklik
function zoomToFeature(e) {
  map.fitBounds(e.target.getBounds());
}

// action style
function onEachFeature(feature, layer) {
  layer.on({
      mouseover: highlightFeature,
      mouseout: resetHighlight,
      click: zoomToFeature
  });
}

// menambahkan map dengan style
var geojson;
//kode prov
if(kode === "NASIONAL"){
  geojson = L.geoJson(districtsData, {
    style: style,
    onEachFeature: onEachFeature
  }).addTo(map);
}else{
  geojson = L.geoJson(districtsData, {
    style: style,
    onEachFeature: onEachFeature,
    filter: function (feature, layer) {
      return feature.properties.PROVINSI === kode;
  }
  }).addTo(map);
}


// info box
var info = L.control();
info.onAdd = function (map) {
  this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
  this.update();
  return this._div;
};

// update info box ketika mouse over wilayah
if(kode === "NASIONAL"){
  info.update = function (props) {
    this._div.innerHTML = '<h4>IPM INDONESIA</h4>' +  
                          (props ?
                            '<b>Provinsi : ' + props.PROVINSI + '</b><br />Klasifikasi : ' + props.segmentasi + '<br />Nilai IPM : ' + props.ipm + '<br />Nilai AHH : ' + props.ahh + '<br />Nilai HLS : ' + props.hls + '<br />Nilai RLS : ' + props.rls + '<br />Nilai PP : ' + props.pp
                          : 'Arahkan kursor ke Provinsi');
  };
}else{
  info.update = function (props) {
    this._div.innerHTML =  
                          (props ?
                            '<h4>IPM '+props.PROVINSI+'</h4><b>Provinsi : ' + props.PROVINSI + '</b><br /><b>Kabupaten : ' + props.KABKOT + '</b><br />Klasifikasi : ' + props.segmentasi + '<br />Nilai IPM : ' + props.ipm + '<br />Nilai AHH : ' + props.ahh + '<br />Nilai HLS : ' + props.hls + '<br />Nilai RLS : ' + props.rls + '<br />Nilai PP : ' + props.pp
                          : 'Arahkan kursor ke kabupaten/kota');
  };
}


info.addTo(map);
//create legend
var legend = L.control({position: 'bottomright'});

legend.onAdd = function (map) {

  var div = L.DomUtil.create('div', 'info legend'),
      grades = ["Rendah","Sedang","Tinggi","Sangat Tinggi"],
      labels = [];

  // loop through our density intervals and generate a label with a colored square for each interval
  for (var i = 0; i < grades.length; i++) {
      div.innerHTML +=
          '<i style="background:' + getColor(grades[i]) + '; height:15px; width:20px"></i> ' +
          grades[i] + '<br>' ;
  }

  return div;
};

legend.addTo(map);