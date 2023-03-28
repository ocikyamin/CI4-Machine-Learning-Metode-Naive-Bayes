<form id="form-predict" method="post" accept-charset="utf-8">
<input type="hidden" name="file_id" value="<?=$file_id ?>">
<?php 
$column_names = $kolom;
$sample_count = $jml_sample;
$samples = $samples;
for($i = 0; $i < $sample_count; $i++) {
echo '<label>'.strtoupper($column_names[$i]).'</label>';
$options = array_unique(array_column($samples, $i));
$jml = count($options);
	// echo '<pre>';
	// print_r($jml);
	// echo '</pre>';
if ($jml < 6) {
	// echo 'Option <br>';
	// option 
?>
<div class="form-group mt-0 mb-0">
<select name="sample[]" class="form-control form-control-sm">
<option value="">-- Plih --</option>
<?php 
foreach ($options as $option) {
echo '<option value="'.$option.'">'.$option.'</option>';
}
?>
</select>
</div>
<?php
// option 

}else{
	// echo 'Text <br>';
	// text 
?>
<div class="form-group mt-0 mb-0">
<input class="form-control form-control-sm" name="sample[]" type="text">
</div>
<?php
// text
}




}
?>

<button type="submit" name="btn_predict" id="btn_predict" class="btn btn-info w-100 mt-3 mb-1"><i class="fas fa-paper-plane"></i> Predict</button>
<button type="reset" class="btn btn-secondary w-100 mt-0"><i class="fa fa-refresh"></i> Reset</button>


</form>
<script>
	$('#form-predict').submit(function(e) {
		e.preventDefault()
		$.ajax({
			url: '<?=base_url('apps/ProccesPredict') ?>',
			type: 'POST',
			dataType: 'json',
			data: $(this).serialize(),
			success : function (response) {
				console.log(response)
				$('#hasil_prediksi').html(response.view);
			}
		})
		
	});
</script>