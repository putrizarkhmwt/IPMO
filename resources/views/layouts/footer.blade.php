<footer id="footer" class="footer" style="padding: 10px 0 10px">
    <div class="container text-center">
      ©2019 Putri Riza
      <div class="credits">
        <!--
          All the links in the footer should remain intact.
          You can delete the links only if you purchased the pro version.
          Licensing information: https://bootstrapmade.com/license/
          Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Mentor
        -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade.com</a>
      </div>
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
            }
        }
        }
    }else{
        for (var i = 0; i < districtsData.features.length; i++) {
        for(var j =0; j < json_data.length; j++){
            if (districtsData.features[i].properties.KABKOT.toLowerCase() == json_data[j].kab_kot.toLowerCase()) {
            districtsData.features[i].properties.segmentasi = json_data[j].segmentasi;
            districtsData.features[i].properties.ipm = json_data[j].ipm;
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