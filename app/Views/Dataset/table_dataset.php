  <div class="input-group m-0">
  <button onclick="TableListDataset()" class="btn bg-gradient-warning btn-sm mt-0 mb-0"><i class="fas fa-chevron-left"></i> Back</button>
</div>
<div class="alert bg-light mt-3">
  <?=$file_name?>
</div>

<div class="table-responsive mt-3">
<table class="table table-sm table-striped table-bordered table-hover">
  <thead class="bg-gradient-primary text-white">
    <tr>
      <?php foreach ($first_line as $k) {  echo '<th>'.strtoupper($k).'</th>';  }?>
    </tr>
  </thead>
  <tbody>

    <?php 
    $no=1;
    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
      echo '<tr>';
    for ($i = 0; $i <= $jml_sample; ++$i) {
    echo '<td>'.$data[$i].'</td>';   
    } 
    echo '</tr>';
    }
    ?>

  </tbody>
</table>


</div>