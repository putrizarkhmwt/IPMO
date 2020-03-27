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

    //prepare data
    public function getData(string $tahun = null){
        $csvFileName = "IPMJATIM.csv";
        $csvFile = public_path('' . $csvFileName);
        $all_data = $this->readCSV($csvFile,array('delimiter' => ','));
        if($tahun == null){
            $tahun = $this->max_with_key($all_data, 'tahun');
        }else{
            $tahun = $tahun;
        }
        $data = array_values(array_filter($all_data, function ($value) use ($tahun) {
            return ($value["tahun"] === $tahun);
        }));
        return $data;
    }

    public function index(Request $request)
    {
        if($request->kode == null){
            $kode = "NASIONAL";
        }else{
            $kode = $request->kode;
        }
        
        if($request->tahun == null){
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

        $csvFileName = "IPMJATIM.csv";
        $csvFile = public_path('' . $csvFileName);
        $all_data = $this->readCSV($csvFile,array('delimiter' => ','));
        $thn = array_column($all_data, 'tahun');
        $opthn = array_values(array_unique($thn));

        $ipm = Charts::multi('line', 'highcharts')
        ->title('Prediksi Nilai Indeks Pembangunan Manusia')
        ->colors(['#ff0000', '#00ff00'])
        ->labels(['2010', '2011', '2012', '2013', '2014','2015'])
        ->dataset('Prediksi', [10, 15, 20, 25, 30, 35])
        ->dataset('Real',  [14, 19, 26, 32, 40, 50])
        ->dimensions(1000,500)
        ->responsive(true);

        $ahh = Charts::multi('line', 'highcharts')
        ->title('Prediksi Angka Harapan Hidup')
        ->colors(['#ff0000', '#00ff00'])
        ->labels(['2010', '2011', '2012', '2013', '2014','2015'])
        ->dataset('Prediksi', [10, 15, 20, 25, 30, 35])
        ->dataset('Real',  [14, 19, 26, 32, 40, 50])
        ->dimensions(1000,500)
        ->responsive(true);

        $hls = Charts::multi('line', 'highcharts')
        ->title('Prediksi Harapan Lama Sekolah')
        ->colors(['#ff0000', '#00ff00'])
        ->labels(['2010', '2011', '2012', '2013', '2014','2015'])
        ->dataset('Prediksi', [10, 15, 20, 25, 30, 35])
        ->dataset('Real',  [14, 19, 26, 32, 40, 50])
        ->dimensions(1000,500)
        ->responsive(true);

        $rls = Charts::multi('line', 'highcharts')
        ->title('Prediksi Rata-rata Lama Sekolah')
        ->colors(['#ff0000', '#00ff00'])
        ->labels(['2010', '2011', '2012', '2013', '2014','2015'])
        ->dataset('Prediksi', [10, 15, 20, 25, 30, 35])
        ->dataset('Real',  [14, 19, 26, 32, 40, 50])
        ->dimensions(1000,500)
        ->responsive(true);

        $pp = Charts::multi('line', 'highcharts')
        ->title('Prediksi Pendapatan Perkapita')
        ->colors(['#ff0000', '#00ff00'])
        ->labels(['2010', '2011', '2012', '2013', '2014','2015'])
        ->dataset('Prediksi', [10, 15, 20, 25, 30, 35])
        ->dataset('Real',  [14, 19, 26, 32, 40, 50])
        ->dimensions(1000,500)
        ->responsive(true);

        return view('predictive', compact('tahun','opthn','kode', 'fitur', 'ipm', 'ahh', 'hls', 'rls', 'pp'));
    }
}
