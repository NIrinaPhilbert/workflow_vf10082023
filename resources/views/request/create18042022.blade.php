@extends('layouts.appnew')

@section('content')

<div id="mymaincontent">
        <p></p>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid pb-4">
                    <!-- Main row -->
                    <div class="row">
                    <!-- Left col -->
                    <div class="col-md-12">
                        <!-- TABLE: DATA -->
                        <form method="POST">
                            @method('POST')
                            @csrf   
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <p></p>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Envoi demande</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0 mt-3 mb-3">
                                    <div class="table-responsive">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-lg-7 col-md-10 col-sm-12 col-xs-12 mx-auto pt-2">
                                                    <!-- ERROR MESSAGES -->
                                                        
                                                        <!-- ERROR MESSAGES -->
                                                        <div class="input-group mb-3">
                                                            <label class="w-100">Objet de la demande</label>
                                                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Objet de la demande" value="{{ old('subject') }}">
                                                            @error('subject')
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('subject') }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <label class="w-100">Outil</label>
                                                            
                                                            <select class="form-control select2 @error('tool_id') is-invalid @enderror" id="tool_id" name="tool_id">
                                                                <option value="" disabled selected>Selectionner l'outil concerné...</option>
                                                                @foreach($tools as $tool)
                                                                <option value="{{ $tool->id }}">{{ $tool->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('tool_id')
                                                            <div class="invalid-feedback">
                                                                {{-- $errors->first('tool_id') --}}
                                                                Veuillez remplir ce champ !
                                                            </div>
                                                            @enderror
                                                        </div>                        
                                                        <div class="input-group mb-3">
                                                            <label class="w-100">Type demande</label>
                                                            
                                                            <select class="form-control @error('type_request_id') is-invalid @enderror" id="type_request_id" name="type_request_id">
                                                                <option value="" disabled selected>Selectionner Type demande...</option>
                                                                
                                                            </select>
                                                            @error('type_request_id')
                                                                <div class="invalid-feedback">
                                                                    {{-- $errors->first('type_request_id') --}}
                                                                    Veuillez remplir ce champ !
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <label class="w-100">Entite destinataire</label>
                                                            <input type="text" class="form-control" id="entity_id" name="entity_id" value="">
                                                            <input type="text" class="form-control" id="entity_name" name="entity_name" placeholder="Entite destinataire" value="" readonly="true">
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <label class="w-100">Contenu de la demande</label>
                                                            <textarea name="content" cols="70" rows="2" placeholder="Contenu de la demande"></textarea>
                                                            
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <label class="w-100">Demande</label>
                                                            <textarea id="summernote" name="summernote"></textarea>
                                                        </div>
                                                        <!-- ERROR MESSAGES -->
                                                        <div id="div-state" class="w-100 alert fade show text-center" style="display: none;">
                                                            <span class="txt-state"></span>
                                                        </div>
                                                        <!-- ERROR MESSAGES -->
                                                        <!-- start DropzoneJS -->
                                                        <div class="input-group mb-3">
                                                            <label class="w-100">File uploader</label>
                                                            <div id="actions" class="row w-100">
                                                                <div class="col-lg-6">
                                                                    <div class="btn-group w-100">
                                                                    <span class="btn btn-sm btn-success col fileinput-button">
                                                                        <i class="fas fa-plus"></i>
                                                                        <span>Add</span>
                                                                    </span>
                                                                    <button type="submit" class="btn btn-sm btn-primary col start">
                                                                        <i class="fas fa-upload"></i>
                                                                        <span>Start</span>
                                                                    </button>
                                                                    <button type="reset" class="btn btn-sm btn-warning col cancel">
                                                                        <i class="fas fa-times-circle"></i>
                                                                        <span>Cancel</span>
                                                                    </button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 d-flex align-items-center mt-1">
                                                                    <div class="fileupload-process w-100">
                                                                    <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                <div class="table table-striped files mt-2" id="previews">
                                                                <div id="template" class="row mt-2" style="background: #f6f6f6; border: 1px solid #eee; border-radius: .2em;">
                                                                    <div class="col-12 d-flex" style="justify-content: right;">
                                                                    <div class="btn-group">
                                                                        <!-- <button class="btn btn-sm btn-link text-primary start p-1" title="Start">
                                                                        <i class="fas fa-upload"></i>
                                                                        </button>
                                                                        <button data-dz-remove class="btn btn-sm btn-link text-warning cancel-one p-1" title="Cancel">
                                                                        <i class="fas fa-times-circle"></i>
                                                                        </button> -->
                                                                        <button data-dz-remove class="btn btn-md btn-link text-danger delete pt-1 pr-0 pb-0 pl-0" title="Remove">
                                                                        <i class="fas fa-times-circle"></i>
                                                                        </button>
                                                                    </div>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
                                                                    </div>
                                                                    <div class="col d-flex align-items-center">
                                                                        <p class="mb-2">
                                                                        <span class="lead" data-dz-name></span>
                                                                        (<span data-dz-size></span>)
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-12 d-flex align-items-center mt-1">
                                                                        <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-auto d-flex align-items-center mt-1 mb-1">
                                                                    <strong class="error text-danger text-sm" data-dz-errormessage></strong>
                                                                        <strong class="error text-success text-sm" data-dz-successmessage></strong>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                        </div>
                                                        <!-- end DropzoneJS -->             
                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer bg-transparent border" id="section-footer">
                                    <div class="mt-2 mb-2 text-center">
                                        <a class="btn btn-primary" id="btn-save" style="display: none;">CREATE & SAVE</a>
                                        <button class="btn btn-primary" type="submit">ENVOYER DEMANDE</button>
                                        <button class="ml-1 btn btn-secondary" type="reset">CANCEL</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                        <!-- /.card -->
                    </div>
                </div>
                    <!-- /.row -->
            </section>
        </div><!--/. container-fluid -->       
</div>

<script type="text/javascript">
  $(document).ready( function () {
   $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
    }); 
  var listFilenames = []
  // var url_lte = "http://localhost/project_templating/rest/modules/lte.php";
  var url_lte = "<?php echo url("/request"); ?>";
 // var url_lte = "{{route('requestww.store')}}";
  $(document).ready(function() {
    // Summernote
    $('#summernote').summernote({
      height: "300"
    })
    // DropzoneJS Demo Code Start
    Dropzone.autoDiscover = false

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template")
    previewNode.id = ""
    var previewTemplate = previewNode.parentNode.innerHTML
    previewNode.parentNode.removeChild(previewNode)
    
    var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
      
      url: url_lte, // Set the url
      method: 'POST',
      thumbnailWidth: 80,
      thumbnailHeight: 80,
      parallelUploads: 20,
      previewTemplate: previewTemplate,
      autoQueue: false, // Make sure the files aren't queued until manually added
      previewsContainer: "#previews", // Define the container to display the previews
      clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
      success: function(file, response) {
        // console.log(file)
        listFilenames.push(file.name)
        updateState()
        $('.delete').hide()
        $('#section-footer').find('#btn-save').show()
      }
    })

    myDropzone.on("addedfile", function(file) { })

	  // Update the total progress bar
	  myDropzone.on("totaluploadprogress", function(progress) {
	    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
	  })

	  myDropzone.on("sending", function(file) {
	    // Show the total progress bar when upload starts
	    document.querySelector("#total-progress").style.opacity = "1"
	  })

	  // Hide the total progress bar when nothing's uploading anymore
	  myDropzone.on("queuecomplete", function(progress) {
	    document.querySelector("#total-progress").style.opacity = "0"
	  })

	  // Setup the buttons for all transfers
	  // The "add files" button doesn't need to be setup because the config
	  // `clickable` has already been specified.
	  document.querySelector("#actions .start").onclick = function() {
      var added_files = myDropzone.getFilesWithStatus(Dropzone.ADDED)
      if (added_files.length > 0) {
        myDropzone.enqueueFiles(added_files)
      }
      updateState()
    }
    document.querySelector("#actions .cancel").onclick = function() {
      myDropzone.removeAllFiles(true)
      if (listFilenames.length > 0) {
        cancelFiles(listFilenames);
      }
      $('.delete').show()
      $('#section-footer').find('#btn-save').hide()
    }
    // DropzoneJS Demo Code End
  })
  function updateState() {
    if (listFilenames.length == 0) {
      $('#div-state').removeClass('alert-success').addClass('alert-danger').find('.txt-state').html('<i class="fas fa-exclamation-triangle mr-2"></i>Please! Upload at least one file.')
    } else {
      $('#div-state').removeClass('alert-danger').addClass('alert-success').find('.txt-state').html('<i class="fas fa-check mr-2"></i>Files are uploaded and form can be submitted.')
    }
    $('#div-state').fadeIn(300)
  }
  function resetForm() {
    $('form [name="summernote"]').summernote('code',"")
    $("#actions .cancel").click()
  }
  function saveForm(_form, filenames) {
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: url_lte,
        data: { ext_action: "save_data", formdata: $(_form).serializeArray(), filenames: filenames },
        dataType: 'json',
        async: true,
        success: function(data){
          if (data.success) {
            listFilenames = []
            alert("Data and files are added successfully.")
            window.location.reload()
          } else alert("Error when adding data")
        }
    });
  }
  function cancelFiles(filenames) {
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: url_lte,
        data: { ext_action: "delete_files", filenames: filenames },
        dataType: 'json',
        async: true,
        success: function(data){
          listFilenames = []
          updateState()
        }
    });
  }
  function resetMessage() {
    $('#div-state').hide()
    $('#div-state').removeClass('alert-success').removeClass('alert-danger').find('.txt-state').html('')
  }
  $(document).on('submit', 'form', function(e) {
    e.preventDefault()
  })
  $(document).on('click', '#btn-save', function(e) {
    e.preventDefault()
    if (listFilenames.length > 0) saveForm($('form'), listFilenames)
  })
  $(document).on('click', '#btn-reset', function(e) {
    e.preventDefault()
    resetForm()
    resetMessage()
  })



// =================fin sumernote===============================//
    //$('#tool_id').change(function(){
$("#mymaincontent").delegate("#tool_id", 'change', function() {
    event.preventDefault();
  //alert(value);
  /*$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });*/
  var iToolId = jQuery("#tool_id").val() ;
  //alert('iToolId'+iToolId);
  //var _token = $('input[type="hidden"]').attr('value');
  var _token = $('input#_token').val();
  $.ajax({
    type:"POST",
    url: "showtyperequest",
    dataType:'json',
    data: {iToolId : iToolId , _token : _token },
    success: function(data){ 
        // format de data
        /*data = '[{"id":"1","ville":"paris"},{"id":"2","ville":"marseille"},
            {"id":"3","ville":"lille"},{"id":"4","ville":"metz"},
            {"id":"5","ville":"renne"}]';  */
        //var json2=JSON.parse(JSON.stringify(data));
        //alert(json2);
       
        var length = Object.keys(data).length;
        
        $("#type_request_id").html("");
        if(length > 0){
            $("#type_request_id").append('<option value="" disabled selected>Selectionner le type de la demande...</option>');
            $.each(data, function (key, value) {           
                $("#type_request_id").append('<option value="'+value.type_request_id+'">'+value.type_request_name+'</option>');
            });
        }else{
            $("#type_request_id").append('<option value="'+""+'">'+"Sans type de demande"+'</option>');
        }
   
    }
  })

});
//============================================================//

$("#mymaincontent").delegate("#type_request_id", 'change', function() {
  
  
  var iToolId = jQuery("#tool_id").val() ;
  var iTypeRequestId = $(this).val() ;
  
  
  var _token = $('input#_token').val();
  //alert('ici1');
  $.ajax({
    type:"POST",
    url: "getfirstentityvalidator",
    dataType:'html',
    data: {iToolId : iToolId , iTypeRequestId : iTypeRequestId , _token : _token },
    success: function(data){
        var tzEntity = data.split('_');

        $('#entity_id').val(tzEntity[0]);
        $('#entity_name').val(tzEntity[1]);

        /*$("#type_request_id").html("");
        if(length > 0){
            $.each(data, function (key, value) {           
                $("#type_request_id").append('<option value="'+value.type_request_id+'">'+value.type_request_name+'</option>');
            });
        }else{
            $("#type_request_id").append('<option value="'+""+'">'+"Sans type de demande"+'</option>');
        }*/
   
    }
  })

});
//===============================================================================//

</script>
@endsection
