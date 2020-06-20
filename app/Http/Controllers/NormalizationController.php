<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Environment\Console;

class NormalizationController extends Controller
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

    // select min value
    public function min_with_key($array, $key) {
        if (!is_array($array) || count($array) == 0) 
        return false;
        $min = $array[0][$key];
        foreach($array as $a) {
            if($a[$key] < $min) {
                $min = $a[$key];
            }
        }
        return $min;
    }

    // min max normalization
    public function normalization($data, $key){
        $max = $this->max_with_key($data, $key);
        $min = $this->min_with_key($data, $key);
        $newmax = 1;
        $newmin = 0;
        for($i=0; $i<count($data); $i++){
            $data[$i][$key] = number_format((($data[$i][$key] - $min) * ($newmax-$newmin) / ($max-$min) + $newmin),3);
        }
        return $data;
    }

    public function getNormalization(string $tahun = NULL, string $kode = NULL)
    {
        if($tahun == "2019"){
            $csvFileName = "Prediksi2.csv";
        }else{
            $csvFileName = "IPM.csv";
        }
        $csvFile = public_path('' . $csvFileName);
        $all_data = $this->readCSV($csvFile,array('delimiter' => ','));
        $filterbyprov = array_values(array_filter($all_data, function ($value) use ($kode) {
                            return ($value["provinsi"] === $kode);
                        }));
        $data = array_values(array_filter($filterbyprov, function ($value) use ($tahun) {
                    return ($value["tahun"] === $tahun);
                }));
        $data = $this->normalization($data, 'ahh');
        $data = $this->normalization($data, 'hls');
        $data = $this->normalization($data, 'rls');
        $data = $this->normalization($data, 'pp');
        return $data;
    }
}
