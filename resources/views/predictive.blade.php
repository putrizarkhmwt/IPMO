<!DOCTYPE html>
<html lang="en">
@include ('layouts.head')

<body>
  <!--Navigation bar-->
  @extends ('layouts.navbar')
  <!--/ Navigation bar-->
  <!--Modal box-->
  @extends ('layouts.login')
  <!--/ Modal box-->
  <!--Maps-->
  <div class="banner" style="min-height:0px;">
    <div class="bg-color" style="min-height:0px;padding-top:60px;top:0;border-bottom-width: 1px;">
        <div class="form-tahun" style="background-color:#fff;padding-left:15px; padding-top:15px">
            <form name="myForm" id='form' method="POST" class="form-a" style="padding-bottom:0px" action="{{ route('filterbyTahun')}}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-2 mb-2" style="padding-left:0px;padding-right:0px;">
                        <div class="form-group" style="margin-top:5px; margin-right:5px; margin-left:10px">
                            <select class="form-control form-control-lg form-control-a" id="kode" name="kode">
                                <option value="">--Pilih Provinsi--</option>
                                <option value="NASIONAL">NASIONAL</option>
                                <option value="BALI">BALI</option>
                                <option value="BANTEN">BANTEN</option>
                                <option value="BENGKULU">BENGKULU</option>
                                <option value="DAERAH ISTIMEWA YOGYAKARTA">DAERAH ISTIMEWA YOGYAKARTA</option>
                                <option value="DKI JAKARTA">DKI JAKARTA</option>
                                <option value="GORONTALO">GORONTALO</option>
                                <option value="JAMBI">JAMBI</option>
                                <option value="JAWA BARAT">JAWA BARAT</option>
                                <option value="JAWA TENGAH">JAWA TENGAH</option>
                                <option value="JAWA TIMUR">JAWA TIMUR</option>
                                <option value="KALIMANTAN BARAT">KALIMANTAN BARAT</option>
                                <option value="KALIMANTAN TENGAH">KALIMANTAN TENGAH</option>
                                <option value="KALIMANTAN TIMUR">KALIMANTAN TIMUR</option>
                                <option value="KALIMANTAN SELATAN">KALIMANTAN SELATAN</option>
                                <option value="KALIMANTAN UTARA">KALIMANTAN UTARA</option>
                                <option value="KEPULAUAN BANGKA BELITUNG">KEPULAUAN BANGKA BELITUNG</option>
                                <option value="KEPULAUAN RIAU">KEPULAUAN RIAU</option>
                                <option value="LAMPUNG">LAMPUNG</option>
                                <option value="MALUKU">MALUKU</option>
                                <option value="MALUKU UTARA">MALUKU UTARA</option>
								<option value="NANGGROE ACEH DARUSSALAM">NANGGROE ACEH DARUSSALAM</option>
                                <option value="NUSA TENGGARA BARAT">NUSA TENGGARA BARAT</option>
                                <option value="NUSA TENGGARA TIMUR">NUSA TENGGARA TIMUR</option>
                                <option value="PAPUA">PAPUA</option>
                                <option value="PAPUA BARAT">PAPUA BARAT</option>
                                <option value="RIAU">RIAU</option>
                                <option value="SULAWESI BARAT">SULAWESI BARAT</option>
                                <option value="SULAWESI TENGAH">SULAWESI TENGAH</option>
                                <option value="SULAWESI TENGGARA">SULAWESI TENGGARA</option>
                                <option value="SULAWESI SELATAN">SULAWESI SELATAN</option>
                                <option value="SULAWESI UTARA">SULAWESI UTARA</option>
                                <option value="SUMATERA BARAT">SUMATERA BARAT</option>
                                <option value="SUMATERA SELATAN">SUMATERA SELATAN</option>
                                <option value="SUMATERA UTARA">SUMATERA UTARA</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mb-2" style="padding-left:0px;padding-right:0px">
                        <div class="form-group" style="margin-top:5px; margin-right:5px; margin-left:5px">
                            <select class="form-control form-control-lg form-control-a" id="Type" name="tahun">
                                <option>--Pilih Tahun--</option>
                                @for ($i = 0; $i < count($opthn)-1; $i++)
                                    @if($tahun == $opthn[$i])
                                    <option value="{{ $opthn[$i] }}" selected="selected">Tahun {{ $opthn[$i] }}</option>
                                    @else
                                        <option value="{{ $opthn[$i] }}">Tahun {{ $opthn[$i] }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mb-2" style="padding-left:0px;padding-right:0px">
                        <div class="form-group" style="margin-top:5px; margin-right:5px; margin-left:5px">
                            <select class="form-control form-control-lg form-control-a" id="Type" name="tahun">
                                <option>--Pilih Fitur--</option>
                                    <option value="ahh">Angka Harapan Hidup</option>
                                    <option value="hls">Harapan Lama Sekolah</option>
                                    <option value="rls">Rata Lama Sekolah</option>
                                    <option value="pp">Pendapatan Perkapita</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mb-2" style="padding-left:0px;padding-right:0px">
                        <button type="submit" class="btn btn-success cari-by-thn" style="margin-top:5px;color:#000;background-color: #2eca6a; padding-right:20px; padding-left:20px; padding-bottom:6px; padding-top:6px">Proses</button>
                    </div>
                    <div class="col-md-2"></div>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
    <div class="section-padding" style="padding:0px;background: #fbf9f9;">
        <div class="container">
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
  
  <!-- Read countries js -->
  
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
  <script src="{{ asset('contactform/contactform.js') }}"></script>
  <!--/ Footer-->
</body>

</html>
