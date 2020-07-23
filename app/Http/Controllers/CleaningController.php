<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Environment\Console;

class CleaningController extends Controller
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

    public function handleMissingValue(string $kode = NULL){
        $csvFileName = "IPM.csv";
        $csvFile = public_path('' . $csvFileName);
        $all_data = $this->readCSV($csvFile,array('delimiter' => ','));
        $data = array_values(array_filter($all_data, function ($value) use ($kode) {
                            return ($value["provinsi"] === $kode);
                        }));
        $filterprov = array_column($data, 'kab_kot');
        $kab_kot = array_values(array_unique($filterprov));
        $thn = array_values(array_unique(array_column($all_data, 'tahun')));
        rsort($thn);
        $k = 0;
        $update = false;
        foreach($kab_kot as $kabkot){
            $dt = array_values(array_filter($data, function ($value) use ($kabkot) {
                            return ($value["kab_kot"] === $kabkot);
                        }));
            rsort($dt);
            for($i=0; $i<count($dt); $i++){
                if($dt[$i]["ipm"] == NULL || $dt[$i]["ahh"] == NULL || $dt[$i]["hls"] == NULL || $dt[$i]["rls"] == NULL || $dt[$i]["pp"] == NULL){
                    $tahun = $dt[$i]["tahun"];
                    $thn = intval($tahun)-1;
                    $thn = strval($thn);
                    $filter = $dt[$i]["kab_kot"];
                    $filterdt = array_values(array_filter($dt, function ($value) use ($thn) {
                                    return ($value["tahun"] === $thn);
                                }));
                    $replace = array_values(array_filter($filterdt, function ($value) use ($filter) {
                                    return ($value["kab_kot"] === $filter);
                                }));
                    for($j=0; $j<count($replace); $j++){
                        $dtreplace[$k]["provinsi"]  = $replace[$j]["provinsi"];
                        $dtreplace[$k]["kab_kot"]   = $replace[$j]["kab_kot"];
                        $dtreplace[$k]["ipm"]       = $replace[$j]["ipm"];
                        $dtreplace[$k]["ahh"]       = $replace[$j]["ahh"];
                        $dtreplace[$k]["hls"]       = $replace[$j]["hls"];
                        $dtreplace[$k]["rls"]       = $replace[$j]["rls"];
                        $dtreplace[$k]["pp"]        = $replace[$j]["pp"];
                        $dtreplace[$k]["tahun"]     = $replace[$j]["tahun"];
                        $k++;
                        $update = true;
                    }
                }
            }
        }
        
        if($update == true){
            for($i=0; $i<count($all_data); $i++){  //read each line as an array
                if($all_data[$i]["ipm"] == NULL || $all_data[$i]["ahh"] == NULL || $all_data[$i]["hls"] == NULL || $all_data[$i]["rls"] == NULL || $all_data[$i]["pp"] == NULL){
                    for($j=0; $j<count($dtreplace); $j++){
                    //modify data here
                        $all_data[$i]["ipm"] = $dtreplace[$j]["ipm"];
                        $all_data[$i]["ahh"] = $dtreplace[$j]["ahh"];
                        $all_data[$i]["hls"] = $dtreplace[$j]["hls"];
                        $all_data[$i]["rls"] = $dtreplace[$j]["rls"];
                        $all_data[$i]["pp"] = $dtreplace[$j]["pp"];
                    }
                }   
            }
    
            //write modified data to new file
            $fp = fopen('temporary.csv', 'a');

            foreach ($all_data as $fields) {
                fputcsv($fp, $fields);
            }

            fclose($fp);

            //clean up
            unlink('IPM.csv');// Delete obsolete BD
            rename('temporary.csv', 'IPM.csv'); //Rename temporary to new
        }
    }

    public function handleInconsistentData(){
        $csvFileName = "IPM.csv";
        $csvFile = public_path('' . $csvFileName);
        $all_data = $this->readCSV($csvFile,array('delimiter' => ','));
        $k = 0;
        $update = false;
        for($i=0; $i<count($all_data); $i++){  //read each line as an array
            if($all_data[$i]["pp"] < 1000){
                $dtreplace[$k]["provinsi"]  = $all_data[$i]["provinsi"];
                $dtreplace[$k]["kab_kot"]   = $all_data[$i]["kab_kot"];
                $dtreplace[$k]["ipm"]       = $all_data[$i]["ipm"];
                $dtreplace[$k]["ahh"]       = $all_data[$i]["ahh"];
                $dtreplace[$k]["hls"]       = $all_data[$i]["hls"];
                $dtreplace[$k]["rls"]       = $all_data[$i]["rls"];
                $dtreplace[$k]["pp"]        = $all_data[$i]["pp"] * 1000;
                $dtreplace[$k]["tahun"]     = $all_data[$i]["tahun"];
                $k++;
                $update = true;
            }
        }
        
        if($update == true){
            for($i=0; $i<count($all_data); $i++){  //read each line as an array
                if($all_data[$i]["ipm"] == NULL || $all_data[$i]["ahh"] == NULL || $all_data[$i]["hls"] == NULL || $all_data[$i]["rls"] == NULL || $all_data[$i]["pp"] == NULL){
                    for($j=0; $j<count($dtreplace); $j++){
                    //modify data here
                        $all_data[$i]["ipm"] = $dtreplace[$j]["ipm"];
                        $all_data[$i]["ahh"] = $dtreplace[$j]["ahh"];
                        $all_data[$i]["hls"] = $dtreplace[$j]["hls"];
                        $all_data[$i]["rls"] = $dtreplace[$j]["rls"];
                        $all_data[$i]["pp"] = $dtreplace[$j]["pp"];
                    }
                }   
            }
    
            //write modified data to new file
            $fp = fopen('temporary.csv', 'a');

            foreach ($all_data as $fields) {
                fputcsv($fp, $fields);
            }

            fclose($fp);

            //clean up
            unlink('IPM.csv');// Delete obsolete BD
            rename('temporary.csv', 'IPM.csv'); //Rename temporary to new
        }
    }
}
