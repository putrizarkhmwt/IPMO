<?php

namespace App\Http\Controllers;

use Charts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Environment\Console;

class IPMController extends Controller
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
    
    public function index(Request $request)
    {
        if($request->kode == ""){
            $kode = "NASIONAL";
        }else{
            $kode = $request->kode;
        }
        
        if($request->tahun == ""){
            $tahun = "2018";
        }else{
            $tahun = $request->tahun;
        }
        if($request->fitur == null){
            $fitur[0] = "ahh";
            $fitur[1] = "hls";
            $fitur[2] = "rls";
            $fitur[3] = "pp";
        }else{
            $fitur = $request->fitur;
        }
        
        app('App\Http\Controllers\CleaningController')->handleMissingValue($kode);
        app('App\Http\Controllers\CleaningController')->handleInconsistentData();
        $csvFileName = "IPM.csv";
        $csvFile = public_path('' . $csvFileName);
        $all_data = $this->readCSV($csvFile,array('delimiter' => ','));
        $thn = array_column($all_data, 'tahun');
        $opthn = array_values(array_unique($thn));
        //dd($all_data);
                    
        $data = app('App\Http\Controllers\ClusteringController')->getCluster($tahun, $fitur, $kode);
        // $data = app('App\Http\Controllers\ClusteringController')->getClusterBPS($tahun="2018", $kode="GORONTALO");
        // $data = app('App\Http\Controllers\ClusteringController')->getCluster($tahun="2018", $fitur, $kode="KALIMANTAN UTARA");
        // $variance = app('App\Http\Controllers\ClusteringController')->getvariance($data, $fitur);
        // dd($variance);
        $filterbyprov = array_values(array_filter($all_data, function ($value) use ($kode) {
            return ($value["provinsi"] === $kode);
        }));
        $dt = array_values(array_filter($filterbyprov, function ($value) use ($tahun) {
            return ($value["tahun"] === $tahun);
        }));
        
        for($i=0; $i<count($data); $i++){
            $data[$i]['ahh'] = $dt[$i]['ahh'];
            $data[$i]['hls'] = $dt[$i]['hls'];
            $data[$i]['rls'] = $dt[$i]['rls'];
            $data[$i]['pp'] = $dt[$i]['pp'];
        }
        
        return view('index', compact('tahun','opthn','data','kode', 'fitur'));
    }

    public function byTahun(Request $request){
        $kode  = $request->input('kode');
        $tahun = $request->input('tahun');
        $fitur = $request->input('fitur');
        return redirect()->action('IPMController@index', ['kode' => $kode,'tahun' => $tahun, 'fitur' => $fitur]);
    }
}
