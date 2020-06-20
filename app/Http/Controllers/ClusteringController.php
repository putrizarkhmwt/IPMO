<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClusteringController extends Controller
{
    public function centroidLinkage($data, $k, $fitur){
        //set cluster
        for($i=0; $i<count($data); $i++){
            $centroid[$i]               = $data[$i];
            $centroid[$i]['label']      = $i;
            $centroid[$i]['data'][0]    = $data[$i];
        }  

        $n = count($data);
        while($n>$k){
            //hitung distance
            $min = 1000;
            for($i=0; $i<count($centroid); $i++){
                for($j=0; $j<count($centroid); $j++){
                    $sumFitur = 0;
                    for($f=0; $f<count($fitur); $f++){
                        $sumFitur += pow( (floatval($centroid[$j][$fitur[$f]]) - floatval($centroid[$i][$fitur[$f]])), 2);
                    }
                    $distance[$i][$j] = sqrt($sumFitur);   
                    
                    //menentukan jarak minimal
                    if($distance[$i][$j]!=0){
                        if ($distance[$i][$j] < $min){
                            $min = $distance[$i][$j];
                            $min_distance['distance'] = $min;
                            $min_distance['data'][0]  = $i;
                            $min_distance['data'][1]  = $j;
                        }
                    }
                }
            }

            //get idx merge data
            $max_idx     = max($min_distance['data']);
            $min_idx     = min($min_distance['data']);
            //update data
            $dt_merge = array_merge($centroid[$min_idx]['data'], $centroid[$max_idx]['data']);
            $centroid[$min_idx]['data'] = $dt_merge;
            array_splice($centroid,$max_idx,1);

            //update centroid
            for($i=0; $i<count($centroid); $i++){   
                $count_dt = count($centroid[$i]['data']);
                $sum_value['ahh'] = array_sum(array_map(function($item) { 
                                    return $item['ahh']; 
                                }, $centroid[$i]['data']));
                $sum_value['hls'] = array_sum(array_map(function($item) { 
                                    return $item['hls']; 
                                }, $centroid[$i]['data']));
                $sum_value['rls'] = array_sum(array_map(function($item) { 
                                    return $item['rls']; 
                                }, $centroid[$i]['data']));
                $sum_value['pp'] = array_sum(array_map(function($item) { 
                                    return $item['pp']; 
                                }, $centroid[$i]['data']));
                for($f=0; $f<count($fitur); $f++){
                    $centroid[$i][$fitur[$f]] = number_format( ($sum_value[$fitur[$f]]/$count_dt), 3);
                }
            }
            $n--;
        }
        //set centroid dan set label
        for($i=0; $i<count($centroid); $i++){
            foreach($centroid[$i]['data'] as $dataitem){
                for($j=0; $j<count($data); $j++){
                    if($data[$j] == $dataitem){
                        for($f=0; $f<count($fitur); $f++){
                            $data[$j]['centroid'][$fitur[$f]]    = $centroid[$i][$fitur[$f]];
                        }
                        $data[$j]['label'] = $i;
                    }
                }
            }
        }

        //jarak centroid dg ground
        for($i=0; $i<count($data); $i++){
            $sumFitur = 0;
            for($f=0; $f<count($fitur); $f++){
                $sumFitur += pow( (floatval($data[$i]['centroid'][$fitur[$f]]) - floatval(0)), 2);
            }
            $distance_centroid[$i] = sqrt($sumFitur); 
            $data[$i]['distance_centroid'] = $distance_centroid[$i];
        }

        //ambil sort distance
        $distance = array_unique($distance_centroid);
        sort($distance);
        for($i=0; $i<count($data); $i++){
            if($data[$i]['distance_centroid'] == $distance[0]){
                $data[$i]['segmentasi'] = "Rendah";
            }else if($data[$i]['distance_centroid'] == $distance[1]){
                $data[$i]['segmentasi'] = "Sedang";
            }else if($data[$i]['distance_centroid'] == $distance[2]){
                $data[$i]['segmentasi'] = "Tinggi";
            }else{
                $data[$i]['segmentasi'] = "Sangat Tinggi";
            }
        }

        //dd($distance);
        return $data;
    }

    public function getClusterBPS(string $tahun, $kode){
        $data = app('App\Http\Controllers\NormalizationController')->getNormalization($tahun, $kode);
        //get cluster
        for($i=0; $i<count($data); $i++){
            if($data[$i]['ipm'] < 60){
                $data[$i]['segmentasi'] = "Rendah";
            }else if($data[$i]['ipm'] >= 60 && $data[$i]['ipm'] < 70){
                $data[$i]['segmentasi'] = "Sedang";
            }else if($data[$i]['ipm'] >= 70 && $data[$i]['ipm'] < 80){
                $data[$i]['segmentasi'] = "Tinggi";
            }else{
                $data[$i]['segmentasi'] = "Sangat Tinggi";
            }
        }

        //get centroid
        $cluster = array_values(array_unique(array_column($data, 'segmentasi')));

        for($i=0; $i<count($cluster); $i++){   
            $segmentasi = $cluster[$i];
            $dt = array_values(array_filter($data, function ($value) use ($segmentasi) {
                return ($value["segmentasi"] == $segmentasi);
            }));
            $count_dt = count($dt);
            $sum_value['ahh'] = array_sum(array_map(function($item) { 
                return $item['ahh']; 
            }, $dt));
            $sum_value['hls'] = array_sum(array_map(function($item) { 
                                return $item['hls']; 
                            }, $dt));
            $sum_value['rls'] = array_sum(array_map(function($item) { 
                                return $item['rls']; 
                            }, $dt));
            $sum_value['pp'] = array_sum(array_map(function($item) { 
                                return $item['pp']; 
                            }, $dt));
            $centroid[$i]['ahh'] = number_format( ($sum_value['ahh']/$count_dt), 3);
            $centroid[$i]['hls'] = number_format( ($sum_value['hls']/$count_dt), 3);
            $centroid[$i]['rls'] = number_format( ($sum_value['rls']/$count_dt), 3);
            $centroid[$i]['pp']  = number_format( ($sum_value['pp']/$count_dt), 3);

            //set centroid
            for($j=0; $j<count($data); $j++){
                if($data[$j]['segmentasi'] == $segmentasi){
                    $data[$j]['centroid'] = $centroid[$i];
                }
            }
        }
        return $data;
    }
    
    //hitung variance
    public function getVariance($data, $fitur){
        $cluster = array_values(array_unique(array_column($data, 'segmentasi')));
        
        //count variance vc2
        for($i=0; $i<count($cluster); $i++){
            $segmentasi = $cluster[$i];
            $dt = array_values(array_filter($data, function ($value) use ($segmentasi) {
                        return ($value['segmentasi'] == $segmentasi);
                    }));
            $sum_d = 0;
            for($j=0; $j<count($dt); $j++){
                $sumFitur = 0;
                for($f=0; $f<count($fitur); $f++){
                    $sumFitur += abs(floatval($dt[$j]['centroid'][$fitur[$f]]) - floatval($dt[$j][$fitur[$f]]));
                }
                $ec = pow( $sumFitur, 2);
                $sum_d = $sum_d +  $ec; 
            }
            if((count($dt) - 1) > 0){
                $vc[$i] = 1/ (count($dt) - 1) * $sum_d;
            }else{
                $vc[$i]  = 0;
            }
        }
        
        //count vw
        $N = count($data);
        $k = count($cluster);
        $sum_vw = 0;
        for($i=0; $i<count($cluster); $i++){
            $segmentasi = $cluster[$i];
            $dt = array_values(array_filter($data, function ($value) use ($segmentasi) {
                        return ($value['segmentasi'] == $segmentasi);
                    }));
            $n = count($dt);
            $sum_vw = $sum_vw + (($n - 1) * $vc[$i]);
        }
        $vw = (1/($N - $k)) * $sum_vw;

        //count vb
        $centroid = array_values(array_unique(array_column($data, 'centroid'), SORT_REGULAR));
        for($f=0; $f<count($fitur); $f++){
            $d[$fitur[$f]] = array_sum(array_column($centroid, $fitur[$f])) / count($cluster);
        }

        $sum_vb = 0;
        for($i=0; $i<count($cluster); $i++){
            $segmentasi = $cluster[$i];
            $dt = array_values(array_filter($data, function ($value) use ($segmentasi) {
                        return ($value['segmentasi'] == $segmentasi);
                    }));
            $n = count($dt);
            $centroid = array_unique(array_column($dt, 'centroid'), SORT_REGULAR);
            $sumFitur = 0;
            for($f=0; $f<count($fitur); $f++){
                $sumFitur += abs(floatval($centroid[0][$fitur[$f]]) - floatval($d[$fitur[$f]]));
            }
            $ec = pow($sumFitur, 2);

            $sum_vb = $sum_vb + ($n * $ec);
        }
        $vb = (1/($k - 1)) * $sum_vb;

        $v = $vw/$vb;
        return $v;
    }

    public function getCluster(string $tahun = null, $fitur, $kode){
        $k = 4;
        $data = app('App\Http\Controllers\NormalizationController')->getNormalization($tahun, $kode);
        $p = 50; //batas iterasi
        $idx = 0; //index data centroid baru
        $hasil_clustering = $this->centroidLinkage($data,$k,$fitur);
        
        return $hasil_clustering;
    }
}
