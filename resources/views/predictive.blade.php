<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Indeks Pembangunan Manusia Monitoring</title>
  <meta name="description" content="Free Bootstrap Theme by BootstrapMade.com">
  <meta name="keywords" content="free website templates, free bootstrap themes, free template, free bootstrap, free website template">

  
  <link rel="stylesheet" type="text/css" href="{{ asset('css/maps.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/font-awesome.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/imagehover.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/multiselect.css') }}"/>

 
  <!-- =======================================================
    Theme Name: Mentor
    Theme URL: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/
    Author: BootstrapMade.com
    Author URL: https://bootstrapmade.com
  ======================================================= -->
</head>

<style>
.charts{
  border: 1px solid #000; 
  padding:2px;
}
</style>

<body>
  <!--Navigation bar-->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ url('/') }}">IPM MONITOR</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
            <li><a href="{{ url('/tren') }}">Data Statistik</a></li>
            <li><a href="{{ url('/') }}">Segmentasi</a></li>
        </ul>
        </div>
    </div>
    </nav>
  <!--/ Navigation bar-->
  <!--Maps-->
  <div class="banner" style="min-height:0px;">
    <div class="bg-color" style="min-height:0px;padding-top:60px;top:0;background-color:#FFF">
    <div class="box box-solid">
        <div class="box-body">
            <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary" style="margin-bottom:5px;border: 1px solid transparent;border-width: 1px;">
                    <div class="box-header with-border" style="margin:5px 30px">
                        <h4 class="box-title">
                            <p style="margin-top:20px; color: #56bb73"> Klik Wilayah <p>
                        </h4>
                        <div style="border: 1px solid transparent;border-width: 1px;"></div>
                    </div>
                    <div id="collapseWilayah" class="panel-collapse collapse in" style="margin:5px 30px">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <h4 style="padding-bottom: 10px; border-bottom: 5px solid #5fcf80;">
                                        @if($filterwilayah == "NASIONAL")
                                            Provinsi {{ucwords(strtolower($kode))}}
                                        @else
                                            Kabupaten/Kota {{ucwords(strtolower($filterwilayah))}}
                                        @endif
                                    </h4>
                                    <div class="row">
                                        @foreach($wilayah as $prov)
                                        <div class="col-xs-2 col-sm-2" style="margin-bottom:5px">
                                            @if($kode == "INDONESIA")
                                                <a href="{{ url('tren/'.$prov.'/'.$prov) }}">{{ ucwords(strtolower($prov)) }}</a>
                                            @else
                                                <a href="{{ url('tren/'.$kode.'/'.$prov) }}">{{ ucwords(strtolower($prov)) }}</a>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                            
            </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="section-padding" style="padding:0px;background: #ececec;">
        <div class="container">
            <div class="box-header with-border" style="margin:5px 30px">
                <h2 class="box-title"style="padding-top: 20px">
                    <p style="padding-top:20px; border-bottom: 3px solid #000; display: table-cell; margin: 0; position: absolute; left: 50%;transform: translate(-50%, -50%);"> Performa Data IPM {{ ucwords(strtolower($namawilayah)) }}<p>
                </h2>
                <div style="border: 1px solid transparent;border-width: 1px;"></div>
            </div>
            <div class="row">
                <div class="feature-info">
                    <div class="fea">
                        <div class="col-md-12">
                        {!! $ipm->html() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="feature-info">
                    <div class="fea">
                        <div class="col-md-6">
                        {!! $ahh->html() !!}
                        </div>
                    </div>
                    <div class="fea">
                        <div class="col-md-6">
                        {!! $hls->html() !!}
                        </div>
                    </div>
                </div>
            </div><div class="row">
                <div class="feature-info">
                    <div class="fea">
                        <div class="col-md-6" style="margin-bottom:20px">
                        {!! $rls->html() !!}
                        </div>
                    </div>
                    <div class="fea">
                        <div class="col-md-6" style="margin-bottom:20px">
                        {!! $pp->html() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  <!--Footer-->
    
    {!! Charts::scripts() !!}
    {!! $ipm->script() !!}
    {!! $ahh->script() !!}
    {!! $hls->script() !!}
    {!! $rls->script() !!}
    {!! $pp->script() !!}
    <footer id="footer" class="footer" style="padding: 10px 0 10px">
    <div class="container text-center">
      ©2019 Putri Riza
    </div>
  </footer>

  <!-- Read countries js -->
  
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
  <script src="{{ asset('contactform/contactform.js') }}"></script>
  <!--/ Footer-->
</body>

</html>
