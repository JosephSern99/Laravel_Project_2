@extends('layouts.app')
@section('title', __('Image Upload'))

@section('content')

<link rel="stylesheet" href="{{ URL::asset('css/images.css?v=1.0.2') }}">

<div class="link-class" style="justify-content: space-between; flex-wrap: wrap;
    justify-content: space-between;
    display: flex;">
    <div>
        <a id="back"><img alt="Back" src="{{ asset('icon/back.svg?v=1.0.0') }}"></a>
        <span class="link-text">Back</span>
    </div>
    <div>
        <span class="link-text">Next</span>
        <a id="next"><img alt="Next" src="{{ asset('icon/next.svg?v=1.0.0') }}"></a>
    </div>
</div>

<div class="cards-default">
<div class="panel panel-default">
    <div class="panel-body">
        <br />
        <div class="dropzone dropzone-area" id="dpz-upload-documents" style="justify-content: flex-start; flex-wrap: wrap;
    display: flex; border-radius: 6px;
  border: solid 1px #9fa2b4; border-style: dotted;">
            <div class="dz-message" style="padding-left: 1rem; padding-right: 1rem;">Drag and drop your files, or click to upload</div>
            <!-- <div> <img id="iconpic" alt="pic" src="{{ asset('icon/picture.svg?v=1.0.0') }}"> </div> -->
        </div>
        <br />
    </div>
</div>

<button id="proceed" class="btn-proceed">
    Proceed
</button>

</div>







@endsection
@section('script')
<script src="{!! url("fresh/app-assets/vendors/js/file-uploaders/dropzone.min.js") !!}"></script>
<script>



var fileLists = {!! json_encode($filelists) !!}

// console.log(fileLists);


Dropzone.autoDiscover = false;

var dropZoneOptions = {
    url: "{!!  route("dropzone.images.upload") !!}",
    acceptedFiles: 'image/jpeg, image/png , image/jpg, image/svg',
    maxFiles: 6,
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 100, // MB
    clickable: true,
    addRemoveLinks: true,
    dictRemoveFile: "Remove",
    createImageThumbnails: false,
    dictRemoveFileConfirmation: "Are you sure you want to delete this file?"
};

var dropZoneOptions_Documents = Object.assign({
    init: function(){
        dropzoneInit(this, "Documents                ");
    }, removedfile: function(file){
        dropZoneRemove(file, "Documents                ");
    }
}, dropZoneOptions);
var dropzoneDocuments = new Dropzone("#dpz-upload-documents", dropZoneOptions_Documents);

$(function(){
    GetLibraryData();
    checkUploadedFiles();
});

function dropzoneInit(_this, _path){
    // console.log("{!! $record->getKey() !!}");
    // console.log(_path);
    _this.on("sending", function(file, xhr, formData){
        formData.append("path", _path);
        formData.append("id", "{!! $record->getKey() !!}");
        formData.append("_token", "{!! csrf_token() !!}");
    });

    _this.on("success", function(file, response, progressEvent){
        var previewElement = file.previewElement;
        var _t = $(previewElement);
        _t.find("[data-dz-name]").text(response.filename);

        // console.log(response.id);
        _t.attr("libraryid", response.id);
		checkUploadedFiles();
        GetLibraryData();
    });

    _this.on("addedfile", function (file) {

    if (_this.files.length === 7) {
        alert("You can Select up to 6 Pictures only.","error");
        this.removeFile(file);
    }

    });

    var backButton = document.querySelector("#back");
    backButton.addEventListener("click", function () {

        location.href="{!!route("cs.checklistmain",["id"=>$record->svor_CaseId])!!}";


    });



    var nextButton = document.querySelector("#next");
    nextButton.addEventListener("click", function () {
            if (_this.files.length >= 2 && _this.files.length <=6) {
                location.href="{!!route("cs.imagesdetails",["id"=>$record->svor_CaseId])!!}";
            }
            else {
                alert("Please upload min 2 - 6 files");
            }
    });


    var proceedButton = document.querySelector("#proceed");
        proceedButton.addEventListener("click", function () {
            if (_this.files.length >= 2 && _this.files.length <=6) {
                location.href="{!!route("cs.imagesdetails",["id"=>$record->svor_CaseId])!!}";
            }
            else {
                alert("Please upload min 2 - 6 files");
            }
    });

	var mockfiles = fileLists[_path] || [];

    // console.log(mockfiles);

	var mockfilesLength = mockfiles.length;

	for(var m = 0; m < mockfilesLength; m++){
		var mock = mockfiles[m];
		var mockFile = {
			name: mock["filename"] || "",
			size: mock["size"] || "",
			type: mock["mime"] || "",
			accepted: true
		};

		_this.files.push(mockFile);
		_this.emit("addedfile", mockFile);
		_this.emit("complete", mockFile);

		$(mockFile.previewElement).attr("libraryid", mock["libraryid"]);
	}

    _this.on("error", function(file, errormessage, xhr){
        $(file.previewElement).find(".dz-error-message span").text(errormessage.message);
    });
}

function dropZoneRemove(file, _path){
    var dzid = $(file.previewElement).attr("libraryid") || 0;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "{!! route("dropzone.images.delete", ["id" => $record->getKey()]) !!}",
        type: "post",
        data: {
            "dzid": dzid,
            "path": _path
        },
        dataType: "json",
        success: function(_data){
            if(_data.status == "ok"){
                file.previewElement.remove();
                checkUploadedFiles()
                GetLibraryData();
            }else{
                alert("Fail to delete file.")
            }
        }, error: function(){
            alert("Error on delete file.");
        }
    });
}


function checkUploadedFiles(){
	// var invoicesFile = dropzoneInvoices.getAcceptedFiles();
	var documentsFile = dropzoneDocuments.getAcceptedFiles();

	// var target2 = $("[data-target='step2']").closest(".step");
	// var target3 = $("[data-target='step3']").closest(".step");

	// if(invoicesFile.length > 0){
	// 	target2.addClass("done");
	// }else{
	// 	target2.removeClass("done");
	// }

	// if(documentsFile.length > 0){
	// 	target3.addClass("done");
	// }else{
	// 	target3.removeClass("done");
	// }

	// if(invoicesFile.length > 0 && documentsFile.length > 0){
	// 	$("#btn_invoice_submit").show();
	// }else{
	// 	$("#btn_invoice_submit").hide();
	// }
}



function GetLibraryData(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
		url: "{!! route("library.serviceorder.list", ["id" => $record->getKey()]) !!}",
		type: "post",
		dataType: "json",
		success: function(_data){

		},
		error: function(){

		}
	});
}

</script>
@endsection
