<?php

namespace App\Http\Controllers;

use Charts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Environment\Console;

class TrendController extends Controller
{
    //read file csv
    public function readCSV($csvFile, $array)
    {
        $file_handle = fopen($csvFile, 'r');
        $i = 0;
        while (!feof($file_handle)) {
            $line_of_text[$i] = fgetcsv($file_handle, 0, $array['delimiter']);
            $dt[$i]["provinsi"] = $line_of_text[$i][0];
            $dt[$i]["kab_kot"] = $line_of_text[$i][1];
            $dt[$i]["ipm"] = $line_of_text[$i][2];
            $dt[$i]["ahh"] = $line_of_text[$i][3];
            $dt[$i]["hls"] = $line_of_text[$i][4];
            $dt[$i]["rls"] = $line_of_text[$i][5];
            $dt[$i]["pp"] = $line_of_text[$i][6];
            $dt[$i]["tahun"] = $line_of_text[$i][7];
            $i++;
        }
        fclose($file_handle);
        return $dt;
    }

    public function index($kode = null, $wilayah = null)
    {
        pp('App\Http\Controllers\CleaningController')->handleMissingValue($kode);
        app('App\Http\Controllers\CleaningController')->handleInconsistentData();
        if($kode == null){
            $kode = "INDONESIA";
            $namawilayah = "INDONESIA";
            $wilayah = "INDONESIA";
            $filterwilayah = "NASIONAL";
        }else{
            $namawilayah = $wilayah;
            if($kode == $wilayah){
                $filterwilayah = $wilayah;
            }else{
                $filterwilayah = $kode;
            }
        }
        
        $csvFileName_predict = "WMA3.csv";
        $csvFile_predict = public_path('' . $csvFileName_predict);
        $all_data_predict = $this->readCSV($csvFile_predict,array('delimiter' => ','));
        $data_predict = array_values(array_filter($all_data_predict, function ($value) use ($wilayah) {
                                    return ($value["kab_kot"] === $wilayah);
                                }));

        $csvFileName_real = "IPM.csv";
        $csvFile_real = public_path('' . $csvFileName_real);
        $all_data_real = $this->readCSV($csvFile_real,array('delimiter' => ','));
        $data_real = array_values(array_filter($all_data_real, function ($value) use ($wilayah) {
                        return ($value["kab_kot"] === $wilayah);
                    }));
        $filterbyprov = array_values(array_filter($all_data_predict, function ($value) use ($filterwilayah) {
                             return ($value["provinsi"] === $filterwilayah);
                        }));
        $filterkabkot = array_column($filterbyprov, 'kab_kot');
        $wilayah = array_values(array_unique($filterkabkot));
        //unset($wilayah[0]);
        asort($wilayah);
        array_values($wilayah);
        
        $tahun = array_values(array_unique(array_column($data_predict, 'tahun')));
        //data predict
        $ipm_predict = array_column($data_predict, 'ipm');
        $ahh_predict = array_column($data_predict, 'ahh');
        $hls_predict = array_column($data_predict, 'hls');
        $rls_predict = array_column($data_predict, 'rls');
        $pp_predict  = array_column($data_predict, 'pp');
        //dd($data_real);
        //data real
        $ipm_real = array_column($data_real, 'ipm');
        array_splice($ipm_real, 0,3);
        $ahh_real = array_column($data_real, 'ahh');
        array_splice($ahh_real, 0,3);
        $hls_real = array_column($data_real, 'hls');
        array_splice($hls_real, 0,3);
        $rls_real = array_column($data_real, 'rls');
        array_splice($rls_real, 0,3);
        $pp_real  = array_column($data_real, 'pp');
        array_splice($pp_real, 0,3);

        $ipm = Charts::multi('line', 'highcharts')
        ->title('Nilai Indeks Pembangunan Manusia')
        ->colors(['#ff0000', '#00ff00'])
        ->labels($tahun)
        ->dataset('Prediksi', $ipm_predict)
        ->dataset('Real',  $ipm_real)
        ->dimensions(1000,500)
        ->responsive(true);

        $ahh = Charts::multi('line', 'highcharts')
        ->title('Angka Harapan Hidup')
        ->colors(['#ff0000', '#00ff00'])
        ->labels($tahun)
        ->dataset('Prediksi', $ahh_predict)
        ->dataset('Real',  $ahh_real)
        ->dimensions(1000,500)
        ->responsive(true);

        $hls = Charts::multi('line', 'highcharts')
        ->title('Harapan Lama Sekolah')
        ->colors(['#ff0000', '#00ff00'])
        ->labels($tahun)
        ->dataset('Prediksi', $hls_predict)
        ->dataset('Real',  $hls_real)
        ->dimensions(1000,500)
        ->responsive(true);

        $rls = Charts::multi('line', 'highcharts')
        ->title('Rata-rata Lama Sekolah')
        ->colors(['#ff0000', '#00ff00'])
        ->labels($tahun)
        ->dataset('Prediksi', $rls_predict)
        ->dataset('Real',  $rls_real)
        ->dimensions(1000,500)
        ->responsive(true);

        $pp = Charts::multi('line', 'highcharts')
        ->title('Pendapatan Perkapita')
        ->colors(['#ff0000', '#00ff00'])
        ->labels($tahun)
        ->dataset('Prediksi', $pp_predict)
        ->dataset('Real',  $pp_real)
        ->dimensions(1000,500)
        ->responsive(true);
        
        //save data
        // $i = 0;
        // foreach($ipm_real as $real){
        //     $dt_ipm[$i]['real'] = $real; 
        //     $i++;
        // }
        // $i = 0;
        // foreach($ipm_predict as $predict){
        //     $dt_ipm[$i]['predict'] = $predict; 
        //     $dt_ipm[$i]['prov'] = $filterwilayah;
        //     $i++;
        // }
        // //dd($dt_ipm);
        // $fp = fopen('dt.csv', 'a');

        // foreach ($dt_ipm as $fields) {
        //     fputcsv($fp, $fields);
        // }

        // fclose($fp);
       return view('predictive', compact('wilayah', 'ipm', 'ahh', 'hls', 'rls', 'pp', 'kode', 'wilayah', 'filterwilayah','namawilayah'));
    }
}
