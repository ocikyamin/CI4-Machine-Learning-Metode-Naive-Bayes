<?= $this->extend('layouts') ?>
<?= $this->section('content') ?>
<div class="row">
<div class="col-12">
<div class="card mb-4">
<div class="card-header">
<h6 class="text-warning p-0 m-0"><i class="fa fa-folder-open"></i> Samples</h6>
</div>
<div class="card-body">
<div id="area_dataset"></div>    
</div>
</div>
</div>
</div>


<div class="modal modal-sheet" tabindex="-1" role="dialog" id="modalSheet">
<div class="modal-dialog" role="document">
<div class="modal-content rounded-4 shadow">
<div class="modal-header border-bottom-0">
<h1 class="modal-title fs-5"><i class="fas fa-cloud-upload-alt"></i> Import CSV</h1>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body py-0">
<div class="alert bg-light">
<a href="#" target="_blank" class="text-success">Download Template</a>
</div>
<form id="form-import-file" enctype="multipart/form-data" method="post" accept-charset="utf-8">

<div class="form-group">
<label> Nama Dokumen : <b class="text-success" id="file_name_area"></b></label>
<input type="text" name="file_name" id="file_name" class="form-control" placeholder="Enter Your Document Name">
<div id="err_file_name" class="invalid-feedback"></div>
</div>

<div class="form-group">
<label> Format Extensi (.csv)</label>
<input type="file" name="file_nya" id="file_nya" class="form-control">
<div id="err_file_nya" class="invalid-feedback"></div>
</div>
<!-- <div id="msg"></div> -->


<div id="btn-upload" class="d-none">
<div class="flex-column border-top-0">
<button type="submit" id="btn-import-file" class="btn btn-lg btn-primary w-100 mx-0 mb-2"><i class="fas fa-cloud-upload-alt"></i> Upload</button>
</div>
</div>


</form>



<div class="flex-column border-top-0">
<button type="button" class="btn btn-lg btn-light w-100 mx-0" data-bs-dismiss="modal">Close</button>
</div>

</div>



</div>
</div>
</div>

<script>

function TableListDataset() {
$.ajax({
url: '<?=base_url('apps/TableListDataset')?>',
dataType: 'json',
beforeSend: function() {
$('#area_dataset').html(`<div class="text-center mt-2">
<h3><i class="fa fa-spin fa-spinner text-warning"></i></h3></div>`);
},
success : function(response) {
$('#area_dataset').html(response.view);
}
})

}


$('#file_name').keyup(function(event) {
$('#file_name_area').html($(this).val())
});

$('#file_nya').change(function(event) {
if ($(this).val() == "") {
$('#btn-upload').addClass('d-none')
}else{
$('#btn-upload').removeClass('d-none')
}
});



// import-file

$('#form-import-file').submit(function(e) {
e.preventDefault();

$('.progress').show();
let forms = $('#form-import-file')[0];
let data = new FormData(forms);

$.ajax({


url: '<?=base_url('apps/UploadFiles')?>',
type: 'POST',
dataType: 'json',
data: data,
enctype: 'multipart/form-data',
processData : false,
contentType: false,
cache: false,
beforeSend: function() {
$('#btn-import-file').prop('disabled', true);

$('#btn-import-file').html(`<i class="fa fa-spin fa-spinner"></i>`);
},
complete: function() {
$('#btn-import-file').prop('disabled', false);
$('#btn-import-file').html(`<i class="fas fa-cloud-upload-alt"></i> Upload`);
},
success : function (response) {

if (response.error) {
if (response.error.file_name) {
$('#file_name').addClass('is-invalid')
$('#err_file_name').html(response.error.file_name)
}

if (response.error.file_nya) {
$('#file_nya').addClass('is-invalid')
$('#err_file_nya').html(response.error.file_nya)
}
}

if (response.sukses) { 
$('#form-import-file')[0].reset();
// $('#msg').html(`<div class="alert alert-success text-white mt-2"> File Berhasil di unggah.</div>`);
$('#btn-upload').addClass('d-none')
toastr.success(response.sukses,"Sukses" , {
positionClass: "toast-top-right"
})

TableListDataset()
}

},
error: function (xhr, ajaxOptions, thrownError) {
alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
}

}) // end ajax








});

function FormUpload(){
$('#modalSheet').modal('show')
}




$(document).ready(function() {
TableListDataset()
});


</script>
<?= $this->endSection() ?>