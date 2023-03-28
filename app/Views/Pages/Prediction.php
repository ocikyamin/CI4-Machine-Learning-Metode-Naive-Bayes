<?= $this->extend('layouts') ?>
<?= $this->section('content') ?>
<div class="row">
<div class="col-lg-4">
<div class="card mb-4">
<!-- <div class="card-header mb-0">
<h6>Naive Bayes Prediction</h6>
</div> -->
<div class="card-body mt-0">

<div class="form-group mt-0 mb-3">
<label for="select_dataset" class="form-control-label">Select Your Datasets</label>
<select name="select_dataset" id="select_dataset" class="form-control shadow-sm">
<option value=""> Select Samples</option>
<?php 
$i=1;
foreach ($list_dataset as $d):?>
<option value="<?=$d['id'] ?>"><?=$i++?>. <?=$d['file_name'] ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="form-area-predict"></div>

</div>
</div>
</div>

<div class="col-lg-8">
<div id="result-area" class="card mb-4">
<div class="card-header mt-0 mb-0">
<h6>Prediction Result</h6>
	<div class="alert bg-light">Hasil Prediksi Akan Ditampilkan disini :</div>
<div id="hasil_prediksi">Here!</div>
</div>
<div class="card-body">
<div id="table_sample">

</div>
</div>
</div>
</div>
</div>

<script>

$('#select_dataset').change(function(e) {
	e.preventDefault();
	// alert('okk')
	// $('.form-area-predict').html(``);
	if ($(this).val() !=="") {
		$.ajax({
			url: '<?=base_url('apps/PredictiontForm')?>',
			type: 'POST',
			dataType: 'json',
			data: {file_id: $(this).val()},
			 beforeSend: function() {
			 	$('.form-area-predict').html(`<div class="text-center mt-2">
			 		<h3><i class="fa fa-spin fa-spinner text-warning"></i></h3></div>`);
			 },
			success :function (response) {
				if (response) {
					if (response.err) {
					$('.form-area-predict').html(response.err);
					}

					if (response.ok) {
					$('.form-area-predict').html(response.ok);
					}

					// if (response.sample) {
					// $('#table_sample').html(response.sample);
					// }

				}
			}
		});
		
	}else{
		alert()
	}

});	


function alert() {
$('.form-area-predict').html(`<div class="text-success mt-2 text-center">Plih Dataset yang digunakan untuk melakukan Prediksi !</div>`);
$('#table_sample').html('');
}

$(function() {
	alert()
});



</script>

<?= $this->endSection() ?>