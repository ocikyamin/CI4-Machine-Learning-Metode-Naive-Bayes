<?= $this->extend('layouts') ?>
<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-4">
<div class="card mb-4">
<!-- <div class="card-header mb-0">
<h6>Naive Bayes Prediction</h6>
</div> -->
<div class="card-body mt-0">
<form id="form-performance" method="post" accept-charset="utf-8">


<div class="form-group mt-0 mb-3">
<label for="select_dataset" class="form-control-label">Select Your Datasets</label>
<select name="file_id" id="select_dataset" class="form-control shadow-sm">
<option value=""> Select CSV File</option>
<?php 
$i=1;
foreach ($list_dataset as $d):?>
<option value="<?=$d['id'] ?>"><?=$i++?>. <?=$d['file_name'] ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="form-group">
<label class="form-control-label"> Metode Split Dataset (Training dan Testing)</label>
<select class="form-control" name="metode" id="metode">
	<option value="">Plih Metode</option>
<option value="1">Stratified Random Split</option>
<option value="2">Cross Validation</option>
</select>
</div>
<div class="form-group">
<label class="form-control-label"> Angka Split</label>
<div class="input-group">
<input type="text" class="form-control" name="number" placeholder="10">
<div class="input-group-append">
<span class="input-group-text">%</span>
</div>
</div>
</div>
<button type="submit" id="btn-proses" class="btn btn-info"><i class="fa fa-refresh"></i> Proses</button>
</form>

</div>
</div>
</div>

<div class="col-lg-8">
<div id="result-area" class="card mb-4">
<div class="card-header mt-0 mb-0">
<h6>Performance</h6>
<!-- 	<div class="alert bg-light">Hasil Prediksi Akan Ditampilkan disini :</div>-->
<div id="hasil_uji">Here!</div> 
</div>
<div class="card-body">
<div id="table_sample">

</div>
</div>
</div>
</div>
</div>
<script>
		$('#form-performance').submit(function(e) {
		e.preventDefault();
		 $.ajax({
    url: "<?=base_url('apps/Ujiperformance') ?>",
    type: "post",
    dataType: 'json',
    data: $(this).serialize(),
    beforeSend: function() {
    $('#btn-proses').prop('disabled', true);
    $('#btn-proses').html(
    `<i class="fa fa-spin fa-spinner"></i>`
    );
    },
    complete: function() {
    $('#btn-proses').prop('disabled', false);
    $('#btn-proses').html(`<i class="fa fa-refresh"></i> Proses`);
    },
    success : function(response) {

if (response.random) {
	$('#hasil_uji').html(response.random);
}

if (response.cross) {
	$('#hasil_uji').html(response.cross);
}


    },
    error: function (xhr, ajaxOptions, thrownError) {
alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
}


  })
  



  return false;
	});
</script>

<?= $this->endSection() ?>