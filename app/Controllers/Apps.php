<?php
namespace App\Controllers;
use App\Controllers\BaseController;
//Import Library PHP-ML
use Phpml\Classification\NaiveBayes;
use Phpml\Dataset\CsvDataset;
// Untuk Uji performance
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\Metric\Accuracy;
use Phpml\Metric\ConfusionMatrix;
//Memanggil Model
use App\Models\MDataset;

class Apps extends BaseController
{

function __construct(){
$this->MDataset = new MDataset;
}


public function index(){
return view('Home');
}

function Samples(){
$data = ['dataset'=> $this->MDataset->findAll()];
return view('Dataset/list', $data);
}

function TableListDataset(){
    if ($this->request->isAJAX()) {
        $data = ['dataset'=> $this->MDataset->findAll()];
        $msg = ['view'=> view('Dataset/table_list_dataset', $data)];
        echo json_encode($msg);
    }
    
}


function Predict(){
$data = [
'list_dataset' => $this->MDataset->findAll()
];
return view('Pages/Prediction', $data);
}

function PredictiontForm(){
if ($this->request->isAJAX()) {
$fileID = intval($this->request->getPost('file_id'));
$get_data = $this->MDataset->find($fileID);// Mengambil nama dataset dari DB
if (!empty($get_data)) {
$dataset_active = $get_data['file']; // nama field yang aktif
$path = ROOTPATH.'/datasets/'.$dataset_active; // panggil file pada folder sesuai dengan data yang aktif
$file = fopen($path, 'r'); // membaca file csv pada folder berdasrkan dataset aktif
$first_line = str_getcsv(fgets($file)); //membaca seluruh kolom pada file csv
$jml_sample = count($first_line)-1; //menghitung jumlah kolom pada file csv dikurangi 1 sebagai label target
$dataset    = new CsvDataset($path,$jml_sample,true); // membuat dataset
$getSamples = $dataset->getSamples();
$kolom = $dataset->getColumnNames(); //mendaptkan nama kolom data sample 
$data = [
'file_id'    => $fileID,
'dataset'    => $get_data,
'jml_sample' => $jml_sample, 
'kolom'      => $kolom,
'samples'    => $getSamples
];
$table = [
'first_line'=> $first_line,
'file'=> $file,
];
 $msg = [
    'ok'=> view('Pages/FormPrediction', $data),
    'sample'=> view('Pages/table_sample', $table)
]; 

}else{
$msg = ['err'=> 404];
}
echo json_encode($msg);
}
   
}

function ProccesPredict(){
if ($this->request->isAJAX()) {
$fileID         = intval($this->request->getPost('file_id'));
$get_data       = $this->MDataset->find($fileID);// Mengambil nama dataset dari DB
if (!empty($get_data)) {
$dataset_active = $get_data['file']; // nama field yang aktif
$path           = ROOTPATH.'/datasets/'.$dataset_active; // panggil file pada folder sesuai dengan data yang aktif
$file           = fopen($path, 'r'); // membaca file csv pada folder berdasrkan dataset aktif
$first_line     = str_getcsv(fgets($file)); //membaca seluruh kolom pada file csv
$jml_sample     = count($first_line)-1; //menghitung jumlah kolom pada file csv dikurangi 1 sebagai label target
$dataset        = new CsvDataset($path,$jml_sample,true); // membuat dataset
$getSamples     = $dataset->getSamples();
$getTargets = $dataset->getTargets();
$classifier = new NaiveBayes();
// Membuat data Training dengan algoritma NaiveBayes dengan memenggil fungsi train
// Mengisi parameter fungsi train dengan variable $getSamples dan $getTargets
$classifier->train($getSamples, $getTargets);
$get_sample = $this->request->getPost('sample');
// Proses Predict
$result_predict = $classifier->predict($get_sample);
$data = [
'datas'=> $get_sample,
'result'=> $result_predict,
'classifier'=>$classifier];
$msg = ['view'=>view('Pages/PredictionResult',$data)];
echo json_encode($msg);
}
}
}




// Upload File 

function UploadFiles()
{
if ($this->request->isAJAX()) {
$this->validate= \Config\Services::validation();
$validation = $this->validate([
'file_nya'  => [
'label'     => 'File',
'rules'     => 'uploaded[file_nya]|ext_in[file_nya,csv]',
'errors'    => [
'uploaded'  => '{field} Harus di Isi',
'ext_in'    => '{field} Extensi yang dizinkan hanya .csv'
]
],
'file_name'  => [
'label'     => 'Nama Dokumen',
'rules'     => 'required|is_unique[dataset.file_name]',
'errors'    => [
'required'  => '{field} Harus di Isi',
'is_unique'=>  '{field} Telah digunakan.',
]
]]);
if (!$validation) {
$msg = ['error'=> [
    'file_nya'=> $this->validate->getError('file_nya'),
    'file_name'=> $this->validate->getError('file_name')
]];

}else{
$file_name     = $this->request->getPost('file_name');
$files         = $this->request->getFile('file_nya');
$file_ext      = $files->getExtension();
$newName       = $files->getRandomName();
$set_file_name = $newName;  
$path = ROOTPATH.'/datasets/'; 
// pindahkan file pada folder 
$files->move($path, $set_file_name);
$data=[
'file_name' => $file_name,
'file'      => $set_file_name,
'url'       => $path.$set_file_name,
'is_active' => null 
];
$this->MDataset->save($data);
$msg =['sukses'=> 'File Berhasil di Upload.'];
}
// $msg =['tes'=> $file_links];
header('Content-Type: application/json');
echo json_encode($msg); 
}
}




function ReadDataset(){
if ($this->request->isAJAX()) {
$fileID = intval($this->request->getPost('file_id'));
$get_data = $this->MDataset->find($fileID);// Mengambil nama dataset dari DB
if (!empty($get_data)) {
$dataset_active = $get_data['file']; // nama field yang aktif
$path = ROOTPATH.'/datasets/'.$dataset_active; // panggil file pada folder sesuai dengan data yang aktif
$file = fopen($path, 'r'); // membaca file csv pada folder berdasrkan dataset aktif
$first_line = str_getcsv(fgets($file)); //membaca seluruh kolom pada file csv
$jml_sample = count($first_line)-1; 
$table = [
'file_name'=> $get_data['file_name'],    
'first_line'=> $first_line,
'jml_sample'=> $jml_sample,
'file'=> $file,
];
 $msg = [
    'sample'=> view('Dataset/table_dataset', $table)
]; 
}else{
$msg = ['err'=> 404];
}
echo json_encode($msg);
}
    
}



function DeleteDataset(){
 if ($this->request->isAJAX()) {
    $fileID   = intval($this->request->getPost('id'));
    $get_data = $this->MDataset->find($fileID);

    if (!empty($get_data['file'])) {
    $path = ROOTPATH.'/datasets/'.$get_data['file']; 
    $get_data = $this->MDataset->delete($fileID);
    unlink($path);

    $msg = ['sukses'=> 'File dihapus'];
    }else{
$msg = ['err'=> 'File Gagal dihapus'];
    }

    echo json_encode($msg);
 }
}





function view_sample()
{
$fileID         = intval($this->request->getPost('file_id'));
$get_data       = $this->MDataset->find(9);// Mengambil nama dataset dari DB
$dataset_active = $get_data['file']; // nama field yang aktif


$path           = ROOTPATH.'/datasets/'.$dataset_active; // panggil file pada folder sesuai dengan data yang aktif
$file           = fopen($path, 'r'); // membaca file csv pada folder berdasrkan dataset aktif
$first_line     = str_getcsv(fgets($file)); //membaca seluruh kolom pada file csv

$jml_sample     = count($first_line)-1; //menghitung jumlah kolom pada file csv dikurangi 1 sebagai label target
$dataset        = new CsvDataset($path,$jml_sample,true); // membuat dataset

$getSamples     = $dataset->getSamples();
$getTargets     = $dataset->getTargets();

$kolom  = $dataset->getColumnNames(); //mendaptkan nama kolom data sample 
// var_dump($kolom);

echo '<table border="1">';
echo '<tr>';
foreach ($first_line as $k) {
  echo '<td>'.$k.'</td>';  
}
echo '</tr>';
while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

echo '<tr>';
for ($i = 0; $i <= $jml_sample; ++$i) {
echo '<td>'.$data[$i].'</td>';   
}
echo '</tr>';
}
echo '<table>';


    
}



// Uji Performa Algoritma NBC 

function performance()
{
    $data = [
'list_dataset' => $this->MDataset->findAll()
];
    return view('Pages/Performance',$data);
}

function Ujiperformance(){
if ($this->request->isAJAX()) {
$fileID         = intval($this->request->getPost('file_id'));
$get_data       = $this->MDataset->find($fileID);// Mengambil nama dataset dari DB
if (!empty($get_data)) {
$dataset_active = $get_data['file']; // nama field yang aktif
$path           = ROOTPATH.'/datasets/'.$dataset_active; // panggil file pada folder sesuai dengan data yang aktif
$file           = fopen($path, 'r'); // membaca file csv pada folder berdasrkan dataset aktif
$first_line     = str_getcsv(fgets($file)); //membaca seluruh kolom pada file csv
$jml_sample     = count($first_line)-1; //menghitung jumlah kolom pada file csv dikurangi 1 sebagai label target
$dataset        = new CsvDataset($path,$jml_sample,true); // membuat dataset
$classifier = new NaiveBayes();
$persen          = $this->request->getPost('number')/100;
$splits          = new StratifiedRandomSplit($dataset, $persen);
// train group
$train_samples   = $splits->getTrainSamples();
$train_lables    = $splits->getTrainLabels();
// test group
$test_samples    = $splits->getTestSamples();
$test_lables     = $splits->getTestLabels();
$classifier->train($train_samples, $train_lables);
$class_hasil     = $classifier->predict($test_samples);
$confusionMatrix = ConfusionMatrix::compute($test_lables, $class_hasil);
$score           = round(Accuracy::score($test_lables, $class_hasil),2);
$data = [
'matrix'=> $confusionMatrix,
'splits'=>$splits,
'score'=> $score,
'class_hasil' => $class_hasil
];
$msg = ['random'=> view('Pages/RandomResult', $data)];
echo json_encode($msg);
}
}
}




function Coba(){


$dataset_active = '1674464256_c96a1322e204378bc87a.csv'; // nama field yang aktif
$path           = ROOTPATH.'/datasets/'.$dataset_active; // panggil file pada folder sesuai dengan data yang aktif
$file           = fopen($path, 'r'); // membaca file csv pada folder berdasrkan dataset aktif
$first_line     = str_getcsv(fgets($file)); //membaca seluruh kolom pada file csv
$jml_sample     = count($first_line)-1; //menghitung jumlah kolom pada file csv dikurangi 1 sebagai label target
$dataset        = new CsvDataset($path,$jml_sample,true); // membuat dataset
$getSamples     = $dataset->getSamples();
$getTargets = $dataset->getTargets();



$classifier = new NaiveBayes();
// Membuat data Training dengan algoritma NaiveBayes dengan memenggil fungsi train
// Mengisi parameter fungsi train dengan variable $getSamples dan $getTargets
$classifier->train($getSamples, $getTargets);


$get_sample =$getSamples;
$result_predict = $classifier->predict($get_sample);



// Report 



$actualLabels = ['cat', 'ant', 'bird', 'bird', 'bird'];
$predictedLabels = ['cat', 'cat', 'bird', 'bird', 'ant'];

$report = new ClassificationReport($getTargets, $getTargets);


    // $get_sample= array_values();
    echo '<pre>';
    print_r($report);
    echo '</pre>';

}

    





}
