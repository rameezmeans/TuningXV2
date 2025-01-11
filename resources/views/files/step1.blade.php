@extends('layouts.app')
@section('pagespecificstyles')
<style>
	
	.select2-search__field {
    height: 1.8rem !important;
}

.select2-container--default .select2-selection--single {
  height: 50px;
}

.select2-selection__rendered {
  height: 50px;
}

.select2-container--default {
    width: 100% !important;
    height: 100px;;
}

  .stage-box{
    display: flex;
    width: 100%;
    height: 85px;
    background: #FFFFFF 0% 0% no-repeat padding-box;
    border: 1px solid #E2E8F0;
    border-radius: 6px;
    opacity: 1;
    margin-bottom:25px;
    
  }

  .border {
    border: 1px #b01321 solid;
  }

  .text-stage {
    font-size:20px;
    align-items: center;
    display: flex;
    padding: 0px 10px !important;
  }

  .stage-image{
    height: 100%;
    width: 55%;
    display: flex;
    
    align-items: center;
  }

  .radio-button{
    float: left;
    margin-left:10px !important;
  }

  .image-itself{
    margin-left:5% !important;
  }

  .square-container {
    position: relative;
    width: 100%;
    padding-bottom: 100% !important;
    background: #FFFFFF 0% 0% no-repeat padding-box;
    opacity: 1;
    border-radius: 6px;
  }
  .file-type-label{
    
    display: flex;
    text-align: center;
    flex-direction: column;
    position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      text-align: center; /* Center content */
      line-height: 1.5; /* Adjust line height for vertical centering */
      padding:5px;
      border: 1px solid #E2E8F0;
     border-radius: 6px;
  }
  
  .file-type-label .img-bx{
    display: block;
    height: 160px;
  }
  
  .file-type-label .img-bx img{
    width: 100%;
    height: auto;
    max-width: 70%;
    display:inline-block;
  }

  a.modal-trigger {
      color: #B01321;
      text-decoration: underline;
  }
  

</style>
@endsection
@section('content')

@php 

	$feeds = ECUApp\SharedCode\Models\NewsFeed::where('active', 1)
        ->whereNull('subdealer_group_id')
        ->where('front_end_id', 2)
        ->get();

		$feed = NULL;

        foreach($feeds as $live){
			$feed = $live;
        }
@endphp

<div id="viewport">
    @include('layouts.sidebar')
    <!-- Content -->
    <div id="content">
      @include('layouts.header')
      <div class="container-fluid">
        <div class="bb-light fix-header">
            <div class="header-block header-block-w-p">
                <h1 class="m-t-40">File Upload</h1>
                <p id="step">Step 1/4</p>
          </div>
        </div>

        <div class="i-content-block">
        <div class="row" style="margin-bottom: 100px;">
            @if($errors->any())
            {!! implode('', $errors->all('<div class="invalid-feedback">:message</div>')) !!}
            @endif
          <div class="col-xl-3 col-lg-3 col-md-3 heading-column master-tools @if($errors->any()) hide @endif">
              <div class="heading-column-box">
                <h3>Reading Tool</h3>
                <p>To edit reading tool list click <a style="color: #b01321;" target="_blank" href="{{route('account', ['tab' => 'tools'])}}">here</a>.</p>
            </div>
          </div>
          <div class="col-xl-9 col-lg-9 col-md-9 master-tools  @if($errors->any()) hide @endif">
            
            @if(!empty($masterTools))

              <label class="account-label">Master</label>
              <div class="row">
                  @foreach($masterTools as $row)
                    <div class="col-xl-4 col-lg-4 col-md-4">
                      <label class="tools stage-box" for="{{'master_'.$row->tool_id}}">
                        <span class="bl stage-image">
                          <input type="radio" class="radio-button" id="{{'master_'.$row->tool_id}}" name="tool_selected" data-type='master' value="{{$row->tool_id}}">
                          <img class="image-itself" width="50%" src="{{ get_dropdown_image($row->tool_id) }}" alt="{{\ECUApp\SharedCode\Models\Tool::findOrFail($row->tool_id)->name}}">
                        </span>
                        <span class="text-stage">
                          <strong >{{\ECUApp\SharedCode\Models\Tool::findOrFail($row->tool_id)->name}}</strong>
                        </span>
                      </label>
                    </div>
                  @endforeach
              </div>

            @endif

            @if(!empty($slaveTools))

              <label class="account-label m-t-40">Slave</label>
              <div class="row">
               
                  @foreach($slaveTools as $row)
                  <div class="col-xl-4 col-lg-4 col-md-4">
                    <label class="tools stage-box" for="{{'master_'.$row->tool_id}}">
                      <span class="bl stage-image">
                        <input type="radio" class="radio-button" id="{{'master_'.$row->tool_id}}" name="tool_selected" data-type='slave' value="{{$row->tool_id}}">
                        <img class="image-itself" width="50%" src="{{ get_dropdown_image($row->tool_id) }}" alt="{{\ECUApp\SharedCode\Models\Tool::findOrFail($row->tool_id)->name}}">
                      </span>
                      <span class="text-stage">
                        <strong >{{\ECUApp\SharedCode\Models\Tool::findOrFail($row->tool_id)->name}}</strong>
                      </span>
                    </label>
                  </div>
                  @endforeach
                
              </div>
            
            @endif

          </div>

          <div id="posting-file" class="@if($errors->any()) show @else hide @endif">
            <form id="step2" name="step2" method="POST" action="{{ route('step2') }}" enctype="multipart/form-data">
                <input type="hidden" name="temporary_file_id" id="temporary_file_id" value="{{ old('temporary_file_id') }}">
                @csrf

                    <div class="row post-row">
                        <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
                            <div class="heading-column-box">
                                <h3>Customer Info</h3>
                                <p>Fill your contact information.</p>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-8">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 ">
                              <div class="form-group">
                                <label for="exampleInputCompanyName1">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6">
                              <div class="form-group">
                                <label for="exampleInputCompanyPhone1">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{old('phone')}}">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                              <div class="form-group">
                                <label for="exampleInputCompanyEmail1">Contact Email</label>
                                <input type="text" name="email" class="form-control" value="{{old('email')}}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                            </div>
                            
                        </div>
                        </div>
                </div>

                

                <div class="row post-row">

                    <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
                        <div class="heading-column-box">
                            <h3>Select File Type</h3>
                            <p>Fill your contact information.</p>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-8 type-column">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 ">
                                <div class="square-container">
                                    <label class="file-type-label">
                                        <input type="radio" value="ecu_file" class="file-selection file_type_area" name="file_type" data-type="ecu_file">
                                        <div class="img-bx">
                                            <img src="{{ url('pictogram.svg') }}">  
                                        </div>
                                        <span>
                                            ECU file
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="square-container">
                                    <label class="file-type-label">
                                        <input type="radio" value="gearbox_file" class="file-selection file_type_area" name="file_type" data-type="gearbox_file">
                                        <div class="img-bx">
                                            <img src="{{ url('gearbox.svg') }}">
                                        </div>
                                        <span>
                                            Gearbox file
                                        </span>
                                    </label>
                                </div>
                            </div>
                            
                        </div>
                        @error('file_type')
                        <p class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>

                </div>

                <div class="row post-row">

                    <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
                        <div class="heading-column-box">
                            <h3>Vehicle Information</h3>
                            <p>Fill your vehicle characteristics.</p>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="row">

                            <div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="form-group">
                                  <label for="exampleInputCompanyModelYear1">Model Year</label>
                                  <input type="text" id="model_year" name="model_year" class="@error('model_year') is-invalid @enderror form-control" placeholder="{{__('Model Year')}} " value="{{ old('model_year') }}">
                                    @error('model_year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                              </div>

                              <div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="form-group">
                                  <label for="exampleInputCompanyLP1">License Plate *</label>
                                  <input type="text" required id="license_plate" name="license_plate" class="@error('license_plate') is-invalid @enderror form-control" placeholder="{{__('License Year')}} " value="{{ old('license_plate') }}">
                                    @error('license_plate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                              </div>

                              <div class="col-xl-4 col-lg-4 col-md-4">
                                <div class="form-group">
                                  <label for="exampleInputCompanyLP1">Vin Number</label>
                                  <input type="text" id="vin_number" name="vin_number" class="@error('vin_number') is-invalid @enderror form-control" placeholder="{{__('Vin Number')}} " value="{{ old('model_year') }}">
                                    @error('vin_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                              </div>

                              <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="form-group">
                                  <label for="exampleInputCompanyLP1">Brand *</label>
                                  
                                    <select name="brand" id="brand" class="select-dropdown form-control">
                                        @if(!old('brand'))
                                        <option selected value="brand">{{__('Brand')}}</option>
                                        @endif
                                        @foreach ($brands as $b)
                                            <option @if(old('brand')==$b) selected @endif value="{{ $b }}">{{$b}}</option>
                                        @endforeach
                                    </select>
                                
                                </div>
                              </div>

                              <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="form-group">
                                  <label for="exampleInputCompanyLP1">Model *</label>
                                  
                                <select name="model" id="model" class="select-dropdown form-control" disabled>
                                    <option value="model" @if(!old('model')) selected @endif disabled>{{__('Model')}}</option>
                                </select>
                                
                                </div>
                              </div>

                              <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="form-group">
                                  <label for="exampleInputCompanyLP1">Version *</label>
                                  
                                <select name="version" id="version" class="select-dropdown form-control" disabled>
                                    <option value="version" @if(!old('version')) selected @endif disabled>{{__('Version')}}</option>
                                </select>
                                
                                </div>
                              </div>

                              <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="form-group">
                                  <label for="exampleInputCompanyLP1">Engine *</label>
                                  
                                <select name="engine" id="engine" class="select-dropdown form-control" disabled>
                                    <option value="engine" @if(!old('engine')) selected @endif disabled>{{__('Engine')}}</option>
                                </select>
                                
                                </div>
                              </div>

                              <div class="col-xl-6 col-lg-6 col-md-6" id="ecu_box">
                                <div class="form-group">
                                  <label for="exampleInputCompanyLP1">ECU Type *</label>
                                  
                                <select name="ecu" id="ecu" class="select-dropdown form-control" disabled>
                                    <option value="ecu" @if(!old('ecu')) selected @endif disabled>{{__('ECU')}}</option>
                                </select>
                                
                                </div>
                              </div>
							
							<div class="col-xl-6 col-lg-6 col-md-6 hide" id="gearbox_box">
                                <div class="form-group">
                                  <label for="exampleInputCompanyLP1">Gear Box ECU Type *</label>
                                  
                                  <select name="gearbox_ecu" id="gearbox_ecu" class="select-dropdown-multi form-control">
									  <option value=""></option>
                                    @foreach($gearboxECUs as $ecu)
                                        <option value="{{$ecu->id}}">{{$ecu->type}}</option>
                                    @endforeach
                                  </select>
                                
                                </div>
                              </div>

                              <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="form-group">
                                  <label for="exampleInputCompanyLP1">Gearbox</label>
                                  
                                  <select name="gear_box" class="select-dropdown form-control">
                                    <option value="gear_box" @if(!old('gear_box')) selected @endif disabled>Gear box</option>
                                    <option value="auto_gear_box" @if(!old('gear_box')) @endif>{{__('Automatic Gearbox')}}</option>
                                    <option value="manual_gear_box" @if(!old('gear_box')) selected @endif>{{__('Manual Gearbox')}}</option>
            
                                </select>
                                
                                </div>
                              </div>

                              <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="form-group rd-gp">
                                  <label for="exampleInputCompanyLP1">Is it an Original file? * </label>
                                    <div>
                                      <input type="radio" id="yes" name="is_original" value="yes">
                                      <label for="yes">Yes</label>
                                      <input type="radio" id="no" name="is_original" value="no">
                                      <label for="no">No</label><br>
                                    </div>
                                    @error('is_original')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                              </div>

                              <div id="original_area" class="hide">

                                <div class="col-xl-12 col-lg-12 col-md-12">
                                  <div class="form-group">
                                    <label for="exampleInputCompanyLP1">Modifications</label>
                                    
                                    <select id="modification" name="modification" class="select-dropdown form-control">
                                      <option value="" selected disabled>Mention Modification</option>
                                      <option value="stage1">Stage1</option>
                                      <option value="stage2">Stage2</option>
                                      <option value="DPF">DPF</option>
                                      <option value="EGR">EGR</option>
                                      <option value="DTC_OFF">DTC OFF</option>
                                      <option value="other">Other (Please mention)</option>
                                    </select>
                                  
                                  </div>
                                </div>
  
                                <div class="col-xl-12 col-lg-12 col-md-12 hide" id="mention_area">
                                  <div class="form-group">
                                      <label for="exampleInputCompanyAC1">Mention Modification</label>
                                      <textarea type="text" id="mention_modification" rows="3" name="mention_modification" class="materialize-textarea form-control @error('mention_modification') is-invalid @enderror" placeholder="{{__('Mention Modification')}} ">{{ old('mention_modification') }}</textarea>
                                      @error('mention_modification')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                  </div>
                                </div>
  
                                </div>

                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputCompanyAC1">Additional Comment</label>
                                    <textarea type="text" id="additional_comments" rows="3" name="additional_comments" class="materialize-textarea form-control @error('additional_comments') is-invalid @enderror" placeholder="{{__('Additional Comments')}} ">{{ old('additional_comments') }}</textarea>
                                    @error('additional_comments')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="row post-row hide" id="acm_box">

                  <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
                      <div class="heading-column-box">
                          <h3>Upload ACM MCM/ECM File</h3>
                          <p>Please upload ACM MCM/ECM file here. In Case of Form Failed, Please upload it again.</p>
                      </div>
                  </div>

                  <div class="col-xl-6 col-lg-6 col-md-8 type-column">
                      <div class="row">
                          <div class="col-xl-12 col-lg-12 col-md-12 ">
                              
                            <input type="file" name="acm_file" id="acm_file" value="{{ old('acm_file') }}">
                             
                          </div>
                      </div>
                      
                  </div>

              </div>

                <div class="row post-row">

                    <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
                        <div class="heading-column-box">
                            <h3>Terms & Conditions</h3>
                            <p>Please check all boxes in order to continue with the upload process</p>
                        </div>
                    </div>

            
                
                <div class="col-xl-8 col-lg-8 col-md-8 m-t-20">
                    <div class="terms-area">
                    <p>
                        <input type="checkbox" class="cgv-checkbox" id="cgv">
                        <label for="cgv">

                            {{__('I understand and agree to')}} <a class="modal-trigger" target="_blank" href="{{route('terms-and-conditions')}}" style="z-index: 1003;"><strong>{{__('the terms and conditions of sales')}}</strong></a> and <a class="modal-trigger" target="_blank" href="{{route('norefund-policy')}}" style="z-index: 1003;"><strong>{{__('norefund policy')}}</strong></a>.
                        </label>
                    </p>
                    <p>
                        <input type="checkbox" class="cgv-checkbox" id="professional">
                        <label for="professional">
                            {{__('Hereby, I declare that I am a professional')}}
                        </label>
                    </p>
                    <p>
                        
                        <label for="track"><input type="checkbox" class="cgv-checkbox" id="track">
                            {{__('I acknowledge that I am fully aware that the tuned software are dedicated to vehicles intended exclusively for use on race track')}}

                        </label>
                    </p>
                    <p id="create_vehicle_form_checkbox-error-custom" class="input-field" style="display: none;">
                        <span class="invalid">{{__('You must accept the different conditions above to be able to submit your request.')}}</span>
                    </p>
                </div>

                <div class="row">
                  <div class="col-xl-6 col-lg-6 col-md-6">
                    @if(isset($feed))

                        @if($feed->type == 'danger')
                          <button type="button" id="register_form_Register_Popup" class="waves-effect waves-light btn btn-red" disabled>{{__('Next')}}</button>
                        @else
                          <button type="submit" id="register_form_Register" class="waves-effect waves-light btn btn-red" disabled>{{__('Next')}}</button>
                        @endif

                      @else

                        <button type="submit" id="register_form_Register" class="waves-effect waves-light btn btn-red" disabled>{{__('Next')}}</button>

                      @endif
                  </div>
                </div>

                </div>

        </div>

        
      </form>
    </div>

        </div>

        <div class="row m-t-40 bt hide" style="margin-bottom: 100px;" id="upload-area">
          <div class="col-xl-3 col-lg-3 col-md-3 m-t-40 heading-column">
              <div class="heading-column-box">
                <h3>Upload File</h3>
                <p>Drop your file or click to select a file from your device.</p>
            </div>
          </div>
          <div class="col-xl-8 col-lg-8 col-md-8 m-t-20">
            <form method="POST" action="{{ route('create-temp-file') }}" enctype="multipart/form-data" id="uploadfile" class="dropzone">
              @csrf
              <input type="hidden" name="tool_type_for_dropzone" id="tool_type_for_dropzone">
              <input type="hidden" name="tool_for_dropzone" id="tool_for_dropzone">
              <div>
                  <h5>{{__('Please Drop and file here by Click')}}</h5>
              </div>
            </form>
          </div>
        </div>
       
      </div>
    </div>
  </div>
  </div>
@endsection

@section('pagespecificscripts')

<script type="text/javascript">

    var boxcounter;
    $(function() {
        let boxcounter = 0;
        $(".cgv-checkbox").click(function() {
            if (this.checked) {
                console.log('checked');
                boxcounter++;
                if (boxcounter == 3) {
                    $("#register_form_Register_Popup").removeAttr("disabled");
                    $("#register_form_Register").removeAttr("disabled");
                }
            } else {
                boxcounter--;
                if (boxcounter < 3) {
                    $("#register_form_Register_Popup").attr("disabled", "disabled");
                    $("#register_form_Register").attr("disabled", "disabled");
                }
            }
        });
    });

    function disable_dropdowns() {

        $('#model').children().remove();
        $('#model').append('<option selected id="model">Model</option>');
        $('#version').children().remove();
        $('#version').append('<option selected id="version">Version</option>');
        $('#ecu').children().remove();
        $('#ecu').append('<option selected id="ecu">ECU</option>');
        $('#gear_box').children().remove();
        $('#engine').append('<option selected id="ecu">Engine</option>');
        $('#engine').children().remove();

        $('#model').attr('disabled', 'disabled');
        $('#version').attr('disabled', 'disabled');
        $('#ecu').attr('disabled', 'disabled');
        $('#engine').attr('disabled', 'disabled');
        $('#gear_box').attr('disabled', 'disabled');
    }

    Dropzone.autoDiscover = false;

    var dropzone = new Dropzone('#uploadfile', {
        thumbnailWidth: 200,
        maxFilesize: 10,
        //   acceptedFiles: "'',.cod,.bin",

        success: function(file, response) {
            console.log(response);
            $('#step').html('Step 2/4');
            $('#upload-area').addClass('hide');
            $('#file-name').html('(File Attached)');
            $('#temporary_file_id').val(response.tempFileID);
            $('#file-name').removeClass('hide');
            $('#posting-file').removeClass('hide');
            $('.master-tools').addClass('hide');
            $('.slave-tools').addClass('hide');
            $('.i-content-block').addClass('level2');
        },
        error: function(file) {
            
        },
        accept: function(file, done) {
            console.log(file);
            let fileName = file.name;
            let ext = fileName.substr(fileName.length - 3);
            console.log(ext);

            if (ext == 'zip' || ext == 'rar' ||file.type == "application/zip" || file.type == "application/x-rar") {
                
                console.log('failed');  

                if (window.confirm('You can not upload zip or rar files!')){
                    location.reload();
                }
                else{
                    location.reload();
                }             
            }
            else{
                done();
            }
            
        }
    });

    $(document).ready(function(event) {

      $("input[name='is_original']").click(function() {
        if ($(this).val() === 'yes') {
          console.log('original');
          $('#original_area').addClass('hide');
        } else if ($(this).val() === 'no') {
          console.log('not original');
          $('#original_area').removeClass('hide');
        } 
      });

      $(document).on('change', '#modification', function(e) {
        
        if($(this).val() == 'other'){
          console.log($(this).val());
          $('#mention_area').removeClass('hide');
        }
        else{
          $('#mention_area').addClass('hide');
        }

      });

      $("#register_form_Register_Popup").click(function() {
            
            Swal.fire({
              title: '{{$cautionText}}',
              showDenyButton: true,
              confirmButtonText: "Next",
              denyButtonText: "Cancel"
            }).then((result) => {
              
              if (result.isConfirmed) {
  
                document.forms['step2'].submit();
  
              } else if (result.isDenied) {
              
                window.location.href = "/home";
  
              }
  
            });
                
                
          });
		
		$(".select-dropdown-multi").select2({
			closeOnSelect : false,
			placeholder : "{{__('Select Gearbox ECU')}}",
			// allowHtml: true,
			allowClear: true,
			tags: false // создает новые опции на лету
		  });

      $('input[type=radio][name=file_type]').change(function() {
            if (this.value == 'ecu_file') {
                console.log(this.value);
                $('#ecu_box').removeClass('hide');
                $('#gearbox_box').addClass('hide');
            }
            else if (this.value == 'gearbox_file') {
                console.log(this.value);
                $('#ecu_box').addClass('hide');
                $('#gearbox_box').removeClass('hide');
            }
        });

        $(document).on('change', '#brand', function(e) {
            let brand = $(this).val();
            disable_dropdowns();

            $.ajax({
                url: "/get_models",
                type: "POST",
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'brand': brand
                },
                success: function(items) {
                    console.log(items);

                    $('#model').removeAttr('disabled');
                    $('#version').attr('disabled', 'disabled');
                    $('#tools').attr('disabled', 'disabled');
                    $('#gear_box').attr('disabled', 'disabled');

                    $.each(items.models, function(i, item) {
                        console.log(item.model);
                        $('#model').append($('<option>', {
                            value: item.model,
                            text: item.model
                        }));
                    });
                }
            });
        });

        $(document).on('change', '#model', function(e) {
            // disable_dropdowns();
            $('#version').children().remove();
            $('#version').append('<option selected id="version">Version</option>');
            $('#ecu').children().remove();
            $('#ecu').append('<option selected id="ecu">ECU</option>');
            $('#gear_box').children().remove();

            $('#version').attr('disabled', 'disabled');
            $('#ecu').attr('disabled', 'disabled');
            $('#gear_box').attr('disabled', 'disabled');

            let model = $(this).val();
            let brand = $('#brand').val();
            $.ajax({
                url: "/get_versions",
                type: "POST",
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'model': model,
                    'brand': brand
                },
                success: function(items) {
                    console.log(items);
                    $('#model').removeAttr('disabled');
                    $('#version').removeAttr('disabled');
                    $('#tools').attr('disabled', 'disabled');
                    $('#gear_box').attr('disabled', 'disabled');
                    $.each(items.versions, function(i, item) {
                        console.log(item.generation);
                        $('#version').append($('<option>', {
                            value: item.generation,
                            text: item.generation
                        }));
                    });

                }
            });
        });

        $(document).on('change', '#version', function(e) {
            // disable_dropdowns();
            $('#engine').children().remove();
            $('#engine').append('<option selected value"engine" disabled>Engine</option>');


            // $('#model').attr('disabled', 'disabled');
            // $('#version').attr('disabled', 'disabled');
            $('#engine').attr('disabled', 'disabled');


            let version = $(this).val();
            let brand = $('#brand').val();
            let model = $('#model').val();

            $.ajax({
                url: "/get_engines",
                type: "POST",
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'model': model,
                    'brand': brand,
                    'version': version,
                },
                success: function(items) {
                    $('#engine').removeAttr('disabled');

                    console.log(items.engines);

                    $.each(items.engines, function(i, item) {
                        $('#engine').append($('<option>', {
                            value: item.engine,
                            text: item.engine
                        }));
                    });
                }
            });
        });

        $(document).on('change', '#engine', function(e) {
            // disable_dropdowns();
            $('#ecu').children().remove();
            $('#ecu').append('<option selected value="ecu" disabled>ECU</option>');
            // $('#model').attr('disabled', 'disabled');
            // $('#version').attr('disabled', 'disabled');
            $('#ecu').attr('disabled', 'disabled');
            let engine = $(this).val();
            let brand = $('#brand').val();
            let model = $('#model').val();
            let version = $('#version').val();
			
			$.ajax({
                url: "/get_type",
                type: "POST",
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'model': model,
                    'brand': brand,
                    'version': version,
                    'engine': engine,
                },
                success: function(response) {
                    console.log(response);
                    if(response.type == 'truck' || response.type == 'agri' || response.type == 'machine'){
                      $('#acm_box').removeClass('hide');
                    }
                }
            });

            $.ajax({
                url: "/get_ecus",
                type: "POST",
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'model': model,
                    'brand': brand,
                    'version': version,
                    'engine': engine,
                },
                success: function(items) {
                    console.log(items);
                    $('#ecu').removeAttr('disabled');
                    $('#gear_box').removeAttr('disabled');
                    $.each(items.ecus, function(i, item) {
                        $('#ecu').append($('<option>', {
                            value: item,
                            text: item
                        }));
                    });
                }
            });
        });

        $("span.file_type_area").click(function() {

            let file_type = $(this).data('type');
            $('span.file_type_area').removeClass('bordered_div');
            $(this).addClass('bordered_div');
            console.log(file_type);
            $('#file_type').val(file_type);
        });

        $(".tools").removeClass('hide');

        $("label.tools").click(function() {

            $("html, body").animate({ scrollTop: $(document).height() }, 'slow');

            $('label.tools').removeClass('border');
            $(this).addClass('border')
           
            let type = $(this).find('.radio-button').data('type');
            let value = $(this).find('.radio-button').val();

            $('#tool_type').val(type);
            $('#tool_type_for_dropzone').val(type);

            $('#tool_for_dropzone').val(value);
            $('#tool').val(value);
            
            $('#upload-area').removeClass('hide');

        });

    });

</script>

@endsection