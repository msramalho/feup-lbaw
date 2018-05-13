@extends('layouts.app')

@section('title', 'Vecto: Edit profile')

@section("styles")
@parent {{-- append to the end multiple times in case of multiple styles --}}
<link href="{{ asset('css/froala_editor.pkgd.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/froala_style.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/codemirror.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="container">

    <div class="jumbotron">
        <h1>Edit Profile</h1>

        
        <div class="form-row mt-5">
            <div class="form-group col-md-12">
                <div class "form-row">
                    <h4>Change Profile Picture</h4>
                </div>
                <hr>
                <!-- Drop Zone -->

                <div class "form-row text-center">
                    <div class="containerA">
                        <form action="{{ url('user/photo') }}" enctype="multipart/form-data" class="dropzone noresize" id="my-awesome-dropzone">{{ csrf_field() }}</form>
                    </div>
                </div>

            </div>
            
        </div>

        <h4 class="mt-3">Personal Information</h4>
        <hr>

        <div class="form-group col-md-12" id="form-info">
            <div class="form-row">
                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                    <label>Name<span style="color : rgb(255,0,0);"> *</span></label>
                    <input type="text" class="form-control" name="name" aria-describedby="NameHelp" placeholder="Enter name" value="{{Auth::user()->name}}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                    <label>Username<span style="color : rgb(255,0,0);"> *</span></label>
                <input type="text" class="form-control" name="username" aria-describedby="userNameHelp" placeholder="Enter username" value="{{Auth::user()->username}}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                    <form method="post">
                        <!-- Date input -->
                        <label class="control-label" for="date">Birthdate<span style="color : rgb(255,0,0);"> *</span></label>
                        <input class="form-control" type="date" name="birthdate" placeholder="DD/MM/YYYY" value="{{(Auth::user()->birthdate != null) ? Auth::user()->birthdate : "DD/MM/YYYY"}}" type="text" />
                    </form>


                    <!-- Submit button -->


                </div>
            </div>
            <div class="form-row">
                <div class=" form-group col-lg-6 col-md-6 col-sm-122">
                    <label>E-mail<span style="color : rgb(255,0,0);"> *</span></label>
                    <input type="email" class="form-control" name="email" aria-describedby="EmailHelp" value="{{Auth::user()->email}}">

                </div>

            </div>
        </div>


        <div class="form-group">
            <h4>Write a little text about you</h4>
            <hr>
            <textarea class="form-control" id="postContent">{{Auth::user()->description}}</textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group col-lg-3 col-md-4 col-sm-6">

                <input type="submit" class="btn btn-primary form-control" id="saveChanges" value="Save Changes" />
            </div>
            <div class="form-group col-lg-3 col-md-4 col-sm-6">

                <input type="submit" class="btn btn-secondary form-control" id="cancel" value="Cancel" />
            </div>
            <div class="form-group col-lg-9 col-md-8 col-sm-6"></div>
        </div>

    </div>

</div>

@endsection

@section("scripts")
@parent {{-- append to the end multiple times in case of multiple scripts --}}
<script src="{{ asset('js/external/codemirror.min.js') }}" ></script>
<script src="{{ asset('js/external/froala_editor.pkgd.min.js') }}" ></script>
<script src="{{ asset('js/external/dropzone.min.js') }}" ></script>
<script src="{{ asset('js/pages/edit-profile.js') }}" ></script>
<script>
    Dropzone.options.myAwesomeDropzone = {
        uploadMultiple: false,
        addRemoveLinks: true,
        dictRemoveFile: 'Remove file',
        dictFileTooBig: 'Image is larger than 5MB',
        timeout: 10000,
        paramName: 'file',
        maxFilesize: 5, // MB
        maxFiles: 1,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",

        init:function() {
            var div_id = $(this.element).attr("id");

            this.on("addedfile", function(file) { 
                alert("Added file."); 
            });

            this.on('maxfilesreached',function(file){
                $('#' + div_id).removeClass('dz-clickable');
                this.removeEventListeners();
            });
            this.on('removedfile',function(file){
                if (this.files.length == this.options.maxFiles - 1){
                    $('#' + div_id).addClass('dz-clickable');
                    this.setupEventListeners();
                }
            });

        },

        error: function(file, response) {
            if($.type(response) === "string")
                var message = response; //dropzone sends it's own error messages in string
            else
                var message = response.message;
            file.previewElement.classList.add("dz-error");
            _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i];
                _results.push(node.textContent = message);
            }
            return _results;
        },

        success: function(file, done) {
            
        }
    };
</script>
@endsection