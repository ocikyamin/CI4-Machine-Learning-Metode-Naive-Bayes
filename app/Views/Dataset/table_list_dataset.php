
 <div class="input-group m-0">
<span class="input-group-text"><button onclick="FormUpload()" class="btn bg-gradient-primary btn-sm mt-0 mb-0"><i class="fas fa-cloud-upload-alt"></i> Import</button></span>
<select id="dataset_id" class="form-control">
<option value=""> Preview Samples Data</option>
<?php 
$i=1;
foreach ($dataset as $d):?>
<option value="<?=$d['id']?>"><?=$i++?>. <?=$d['file_name'] ?></option>
<?php endforeach; ?>
</select>
</div>



<div class="table-responsive">
<table class="table table-sm table-hover align-items-center mt-3">
<thead class="bg-light">
<tr>
<th class="text-uppercase text-center">No.</th>
<th class="text-uppercase ps-1"> Samples Name</th>
<th class="text-uppercase ps-1"> Created at</th>
<th class="text-center"><i class="fa fa-cog"></i></th>
</tr>
</thead>
<tbody>
<?php

if (empty($dataset)) {
	echo '<tr><td colspan="3" class="text-danger text-center">Belum ada Dataset.</td></tr>';
}
$i =1;
foreach ($dataset as $d):?>
<tr>
<td class="text-center"><?=$i++?>.</td>    
<td><?=strtoupper($d['file_name'])?></td>  
<td><p class="text-sm font-weight-bold mb-0"><?=date('d/m/Y H:i:s', strtotime($d['created_at']))?></p></td>  
<td class="text-center">
	<!-- <a href="<?=base_url('datasets/'.$d['file']) ?>" target="_blank" class="btn btn-light btn-sm m-0"><i class="fas fa-cloud-download-alt text-success m-0"></i></a>
<a href="#" class="btn btn-light btn-sm m-0"><i class="fa fa-edit text-warning m-0"></i></a> -->
<a href="#" class="btn btn-light btn-sm m-0" onclick="DeleteDataset(<?=$d['id']?>)"><i class="fa fa-trash text-danger m-0"></i></a>
</td>             
</tr>
<?php endforeach; ?>
</tbody>
</table>

</div>
<script>

function DeleteDataset(id) {
	$.ajax({
		url: '<?=base_url('apps/DeleteDataset')?>',
		type: 'POST',
		dataType: 'json',
		data: {id: id},
		success : function (response) {
			// console.log(response)
			toastr.success(response.sukses,"Sukses" , {
			positionClass: "toast-top-right"
			})

			TableListDataset()
		}
	})
	
}



// tampilkan dataset 
$('#dataset_id').change(function(e) {
if ($(this).val() !=="") {

$.ajax({
url: '<?=base_url('apps/ReadDataset')?>',
type: 'POST',
dataType: 'json',
data: {file_id: $(this).val()},
beforeSend: function() {
$('#area_dataset').html(`<div class="text-center mt-2">
<h3><i class="fa fa-spin fa-spinner text-warning"></i></h3></div>`);
},
success :function (response) {
if (response) {
if (response.sample) {
$('#area_dataset').html(response.sample);
}

}
}
});

}else{
TableListDataset()
}  
});
	
</script>