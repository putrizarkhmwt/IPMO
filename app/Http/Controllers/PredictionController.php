<?php 
namespace App\Http\Controllers;

use Charts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Environment\Console;

class PredictionController extends Controller
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

    //select max value
    public function max_with_key($array, $key) {
        if (!is_array($array) || count($array) == 0) return false;
        $max = $array[0][$key];
        foreach($array as $a) {
            if($a[$key] > $max) {
                $max = $a[$key];
            }
        }
        return $max;
    }

    public function getData(string $tahun, string $kode){
        $csvFileName = "IPM.csv";
        $csvFile = public_path('' . $csvFileName);
        $all_data = $this->readCSV($csvFile,array('delimiter' => ','));
        $filterbyprov = array_values(array_filter($all_data, function ($value) use ($kode) {
                            return ($value["provinsi"] === $kode);
                        }));
        $j = 0;
        $dt = array_values(array_filter($filterbyprov, function ($value) use ($tahun) {
                return ($value["tahun"] === $tahun);
            }));
        $data = $dt;
        for($thn=$tahun-1; $j < 2; $thn--){
            $tahun = strval($thn);
            $dt = array_values(array_filter($filterbyprov, function ($value) use ($tahun) {
                    return ($value["tahun"] === $tahun);
                }));

            $data = array_merge($data,$dt);
            $j++;
        }

        return $data;
    }

    public function getWMA($dt){
        $fitur = ["ipm","ahh","hls","rls","pp"];
        for($f=0; $f < count($fitur); $f++){
            $sum_dt = 0;
            $sum_bobot = 0;
            $j = 6;
            for($idx=0; $idx < count($dt); $idx++){
                $sum_dt = $sum_dt + ($j * $dt[$idx][$fitur[$f]]);
                $sum_bobot = $sum_bobot + $j;
                $j--;
            }
            $result = $sum_dt / $sum_bobot;
            $prediksi[$fitur[$f]] = number_format((float)$result,2,'.','');
        }

        return $prediksi;
    }

    public function getSMA($dt){
        $fitur = ["ipm","ahh","hls","rls","pp"];
        for($f=0; $f < count($fitur); $f++){
            $sum_dt = 0;
            for($idx=0; $idx < count($dt); $idx++){
                $sum_dt = $sum_dt + $dt[$idx][$fitur[$f]];
            }
            $result = $sum_dt / count($dt);
            $prediksi[$fitur[$f]] = number_format((float)$result,2,'.','');
        }
        return $prediksi;
    }

    public function resultPrediksi(){
        $data = $this->getData();
        $kabkot = array_values(array_unique(array_column($data,"kab_kot")));
        for($i=0; $i<count($kabkot); $i++){
            $kab_kot = $kabkot[$i];
            $dt = array_values(array_filter($data, function ($value) use ($kab_kot) {
                        return ($value["kab_kot"] === $kab_kot);
                    }));
            $prediksi = $this->getWMA($dt);
            $data_prediksi[$i]["provinsi"] = $dt[0]["provinsi"];
            $data_prediksi[$i]["kab_kot"] = $dt[0]["kab_kot"];
            $data_prediksi[$i]["ipm"] = $prediksi["ipm"];
            $data_prediksi[$i]["ahh"] = $prediksi["ahh"];
            $data_prediksi[$i]["hls"] = $prediksi["hls"];
            $data_prediksi[$i]["rls"] = $prediksi["rls"];
            $data_prediksi[$i]["pp"] = $prediksi["pp"];
            $data_prediksi[$i]["tahun"] = "2019";
        }
        $fp = fopen('Prediksi2.csv', 'a');

        foreach ($data_prediksi as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        return $data_prediksi;
    }
    public function index()
    {
        // $csvFileName = "IPM.csv";
        // $csvFile = public_path('' . $csvFileName);
        // $all_data = $this->readCSV($csvFile,array('delimiter' => ','));
        // $filterprov = array_column($all_data, 'provinsi');
        // $wilayah = array_values(array_unique($filterprov));
        // //dd($wilayah);
        // foreach($wilayah as $prov){
        //     $thn = 2013;
        //     while($thn!=2019){
        //         $data = $this->getData($thn-1, $prov);
        //         $kabkot = array_values(array_unique(array_column($data,"kab_kot")));
        //         for($i=0; $i<count($kabkot); $i++){
        //             $kab_kot = $kabkot[$i];
        //             $dt = array_values(array_filter($data, function ($value) use ($kab_kot) {
        //                         return ($value["kab_kot"] === $kab_kot);
        //                     }));
        //             $prediksi = $this->getWMA($dt);
        //             $data_prediksi[$i]["provinsi"] = $dt[0]["provinsi"];
        //             $data_prediksi[$i]["kab_kot"] = $dt[0]["kab_kot"];
        //             $data_prediksi[$i]["ipm"] = $prediksi["ipm"];
        //             $data_prediksi[$i]["ahh"] = $prediksi["ahh"];
        //             $data_prediksi[$i]["hls"] = $prediksi["hls"];
        //             $data_prediksi[$i]["rls"] = $prediksi["rls"];
        //             $data_prediksi[$i]["pp"] = $prediksi["pp"];
        //             $data_prediksi[$i]["tahun"] = $thn;
        //         }

        //         $fp = fopen('WMA3.csv', 'a');

        //         foreach ($data_prediksi as $fields) {
        //             fputcsv($fp, $fields);
        //         }

        //         fclose($fp);

        //     $thn++; 
        //     }
        // }
        
        // return $data_prediksi;
    }
}
