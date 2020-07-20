<footer id="footer" class="footer" style="padding: 10px 0 10px">
    <div class="container text-center">
      ©2019 Putri Riza
    </div>
  </footer>
  <script type="text/javascript"> 
    document.body.style.cursor = 'wait';
    var provkode = '<?=json_encode($kode)?>';
    var kode = JSON.parse(provkode);
</script>
<script type="text/javascript" src="{{ asset('/js/districts.js') }}"></script>
<script type="text/javascript">

//convert to json
    var data = '<?=json_encode($data)?>';
    var json_data = JSON.parse(data);

    //update segmentasi
    if(kode === "NASIONAL"){
        for (var i = 0; i < districtsData.features.length; i++) {
        for(var j =0; j < json_data.length; j++){
            if (districtsData.features[i].properties.PROVINSI.toLowerCase() == json_data[j].kab_kot.toLowerCase()) {
            districtsData.features[i].properties.segmentasi = json_data[j].segmentasi;
            districtsData.features[i].properties.ipm = json_data[j].ipm;
            districtsData.features[i].properties.ahh = json_data[j].ahh;
            districtsData.features[i].properties.hls = json_data[j].hls;
            districtsData.features[i].properties.rls = json_data[j].rls;
            districtsData.features[i].properties.pp = json_data[j].pp;
            }
        }
        }
    }else{
        for (var i = 0; i < districtsData.features.length; i++) {
        for(var j =0; j < json_data.length; j++){
            if (districtsData.features[i].properties.KABKOT.toLowerCase() == json_data[j].kab_kot.toLowerCase()) {
            districtsData.features[i].properties.segmentasi = json_data[j].segmentasi;
            districtsData.features[i].properties.ipm = json_data[j].ipm;
            districtsData.features[i].properties.ahh = json_data[j].ahh;
            districtsData.features[i].properties.hls = json_data[j].hls;
            districtsData.features[i].properties.rls = json_data[j].rls;
            districtsData.features[i].properties.pp = json_data[j].pp;
            }
        }
        }
    }


    console.Log(districtsData);
</script>
<script src="{{ asset('js/render-map.js') }}"></script>
  <!-- Read countries js -->
  
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
  <script src="{{ asset('contactform/contactform.js') }}"></script>