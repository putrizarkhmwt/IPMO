<div class="banner">
    <div class="bg-color" style="padding-top:60px">
        <div class="form-tahun" style="background-color:#fff;padding-left:15px; padding-top:15px">
            <form name="myForm" id='form' method="POST" class="form-a" style="padding-bottom:0px" action="{{ route('filterbyTahun')}}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-2 mb-2" style="padding-left:0px;padding-right:0px;">
                        <div class="form-group" style="margin-top:5px; margin-right:5px; margin-left:10px">
                            <select class="form-control form-control-lg form-control-a" id="kode" name="kode">
                                <option value="">--Pilih Provinsi--</option>
                                <option value="NASIONAL">Nasional</option>
                                <option value="BALI">Bali</option>
                                <option value="BANTEN">Banten</option>
                                <option value="BENGKULU">Bengkulu</option>
                                <option value="DAERAH ISTIMEWA YOGYAKARTA">DI Yogyakarta</option>
                                <option value="DKI JAKARTA">DKI Jakarta</option>
                                <option value="GORONTALO">Gorontalo</option>
                                <option value="JAMBI">Jambi</option>
                                <option value="JAWA BARAT">Jawa Barat</option>
                                <option value="JAWA TENGAH">Jawa Tengah</option>
                                <option value="JAWA TIMUR">Jawa Timur</option>
                                <option value="KALIMANTAN BARAT">Kalimantan Barat</option>
                                <option value="KALIMANTAN TENGAH">Kalimantan Tengah</option>
                                <option value="KALIMANTAN TIMUR">Kalimantan Timur</option>
                                <option value="KALIMANTAN SELATAN">Kalimantan Selatan</option>
                                <option value="KALIMANTAN UTARA">Kalimantan Utara</option>
                                <option value="KEPULAUAN BANGKA BELITUNG">Kepulauan Bangka Belitung</option>
                                <option value="KEPULAUAN RIAU">Kepulauan Riau</option>
                                <option value="LAMPUNG">Lampung</option>
                                <option value="MALUKU">Maluku</option>
                                <option value="MALUKU UTARA">Maluku Utara</option>
								<option value="NANGGROE ACEH DARUSSALAM">Nanggroe Aceh Darussalam</option>
                                <option value="NUSA TENGGARA BARAT">Nusa Tenggara Barat</option>
                                <option value="NUSA TENGGARA TIMUR">Nusa Tenggara Timur</option>
                                <option value="PAPUA">PApua</option>
                                <option value="PAPUA BARAT">Papua Barat</option>
                                <option value="RIAU">Riau</option>
                                <option value="SULAWESI BARAT">Sulawesi Barat</option>
                                <option value="SULAWESI TENGAH">Sulawesi Tengah</option>
                                <option value="SULAWESI TENGGARA">Sulawesi Tenggara</option>
                                <option value="SULAWESI SELATAN">Sulawesi Selatan</option>
                                <option value="SULAWESI UTARA">Sulawesi Utara</option>
                                <option value="SUMATERA BARAT">Sumatera Barat</option>
                                <option value="SUMATERA SELATAN">Sumatera Selatan</option>
                                <option value="SUMATERA UTARA">Sumatera Utara</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mb-2" style="padding-left:0px;padding-right:0px">
                        <div class="form-group" style="margin-top:5px; margin-right:5px; margin-left:5px">
                            <select class="form-control form-control-lg form-control-a" id="Type" name="tahun">
                                <option value="">--Pilih Tahun--</option>
                                @for ($i = 0; $i < count($opthn); $i++)
                                    @if($tahun == $opthn[$i])
                                    <option value="{{ $opthn[$i] }}" selected="selected">Tahun {{ $opthn[$i] }}</option>
                                    @else
                                        <option value="{{ $opthn[$i] }}">Tahun {{ $opthn[$i] }}</option>
                                    @endif
                                @endfor
                                    @if($tahun == "2019")
                                        <option value="2019" selected="selected">Prediksi Tahun Selanjutnya</option>
                                    @else
                                        <option value="2019">Prediksi Tahun Selanjutnya</option>
                                    @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mb-2" style="padding-left:5px;padding-right:0px;width:14.2%">
                            <select id='testSelect1' name='fitur[]' style='margin-top:0px' multiple>
                                <option value='ahh'>Angka Harapan Hidup</option>
                                <option value='hls'>Harapan Lama Sekolah</option>
                                <option value='rls'>Rata Lama Sekolah</option>
                                <option value='pp'>Pengeluaran Perkapita</option>
                            </select>
                    </div>
                    <div class="col-md-2 mb-2" style="width: 8.8888%;padding-left:0px;padding-right:0px">
                        <button type="submit" class="btn btn-success cari-by-thn" style="margin-top:5px;color:#000;background-color: #2eca6a; padding-right:20px; padding-left:20px; padding-bottom:6px; padding-top:6px">Proses</button>
                    </div>
                    <div class="col-md-2" style="width: 40.8888%">
                        <div class="row">
                            <div class="col-md-12" style="font-weight:bold;text-align: center;font-size:17px;padding-left:0px;padding-right:0px">
                                @if($tahun == null)
                                    Segmentasi IPM {{$kode}} Tahun 2018 
                                @else
                                    Segmentasi IPM {{$kode}} Tahun {{$tahun}} 
                                @endif
                            </div>
                            <div class="col-md-12" style="font-weight:bold;text-align: center;font-size:13px;padding-left:0px;padding-right:0px">
                                @if(count($fitur) == 4)
                                    Berdasarkan Fitur AHH, RLS, HLS, dan PP
                                @else
                                    Berdasarakan Fitur 
                                    @for($i=0; $i < count($fitur); $i++)
                                        @if($i == count($fitur)-1)
                                            dan {{strtoupper($fitur[$i])}} 
                                        @else
                                            {{strtoupper($fitur[$i])}}, 
                                        @endif
                                    @endfor
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="map" class="map" style="width: 100%; height: 590px;"></div>
    </div>
</div>
<script>
    document.multiselect('#testSelect1');
    $('#fitur option:selected').each(function(){
        $(this).prop('selected', false);
    });
    $('#fitur').multiselect('refresh');
</script>
