<div class="alert bg-light mt-3">Berikut Data Training yang digunakan :</div>
<?php 
echo '<div class="table-responsive"><table class="table table-sm table-hover table-striped"><thead class="bg-dark text-white">';
echo '<tr>';
foreach ($first_line as $k) {
  echo '<td>'.strtoupper($k).'</td>';  
}
echo '</tr><thead><tbody>';
while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

echo '<tr>';
for ($i = 0; $i <= $jml_sample; ++$i) {
echo '<td>'.$data[$i].'</td>';   
}
echo '</tr>';
}
echo '</tbody><table></div>';

 ?>


