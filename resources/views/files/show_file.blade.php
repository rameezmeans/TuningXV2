@extends('layouts.app')

@section('pagespecificstyles')

<style>

.feedback {
  --normal: #eceaf3;
  --normal-shadow: #d9d8e3;
  --normal-mouth: #9795a4;
  --normal-eye: #595861;
  --active: #f8da69;
  --active-shadow: #f4b555;
  --active-mouth: #f05136;
  --active-eye: #313036;
  --active-tear: #76b5e7;
  --active-shadow-angry: #e94f1d;
  margin: auto;
  width: 66%;
  padding: 60px 10px;
  list-style: none;
  display: flex;
}

.feedback li {
  padding: 0 !important;
  position: relative;
  border-radius: 50%;
  background: var(--sb, var(--normal));
  box-shadow: inset 3px -3px 4px var(--sh, var(--normal-shadow));
  transition: background 0.4s, box-shadow 0.4s, transform 0.3s;
  -webkit-tap-highlight-color: transparent;
}

.feedback li:not(:last-child) {
  margin-right: 20px;
}

.feedback li div {
  width: 40px;
  height: 40px;
  position: relative;
  transform: perspective(240px) translateZ(4px);
}

.feedback li div svg,
.feedback li div:before,
.feedback li div:after {
  display: block;
  position: absolute;
  left: var(--l, 9px);
  top: var(--t, 13px);
  width: var(--w, 8px);
  height: var(--h, 2px);
  transform: rotate(var(--r, 0deg)) scale(var(--sc, 1)) translateZ(0);
}

.feedback li div svg {
  fill: none;
  stroke: var(--s);
  stroke-width: 2px;
  stroke-linecap: round;
  stroke-linejoin: round;
  transition: stroke 0.4s;
}

.feedback li div svg.eye {
  --s: var(--e, var(--normal-eye));
  --t: 17px;
  --w: 7px;
  --h: 4px;
}

.feedback li div svg.eye.right {
  --l: 23px;
}

.feedback li div svg.mouth {
  --s: var(--m, var(--normal-mouth));
  --l: 11px;
  --t: 23px;
  --w: 18px;
  --h: 7px;
}

.feedback li div:before,
.feedback li div:after {
  content: '';
  z-index: var(--zi, 1);
  border-radius: var(--br, 1px);
  background: var(--b, var(--e, var(--normal-eye)));
  transition: background 0.4s;
}

.feedback li.angry {
  --step-1-rx: -24deg;
  --step-1-ry: 20deg;
  --step-2-rx: -24deg;
  --step-2-ry: -20deg;
}

.feedback li.angry div:before {
  --r: 20deg;
}

.feedback li.angry div:after {
  --l: 23px;
  --r: -20deg;
}

.feedback li.angry div svg.eye {
  stroke-dasharray: 4.55;
  stroke-dashoffset: 8.15;
}

.feedback li.angry.active {
  animation: angry 1s linear;
}

.feedback li.angry.active div:before {
  --middle-y: -2px;
  --middle-r: 22deg;
  animation: toggle 0.8s linear forwards;
}

.feedback li.angry.active div:after {
  --middle-y: 1px;
  --middle-r: -18deg;
  animation: toggle 0.8s linear forwards;
}

.feedback li.sad {
  --step-1-rx: 20deg;
  --step-1-ry: -12deg;
  --step-2-rx: -18deg;
  --step-2-ry: 14deg;
}

.feedback li.sad div:before,
.feedback li.sad div:after {
  --b: var(--active-tear);
  --sc: 0;
  --w: 5px;
  --h: 5px;
  --t: 15px;
  --br: 50%;
}

.feedback li.sad div:after {
  --l: 25px;
}

.feedback li.sad div svg.eye {
  --t: 16px;
}

.feedback li.sad div svg.mouth {
  --t: 24px;
  stroke-dasharray: 9.5;
  stroke-dashoffset: 33.25;
}

.feedback li.sad.active div:before,
.feedback li.sad.active div:after {
  animation: tear 0.6s linear forwards;
}

.feedback li.ok {
  --step-1-rx: 4deg;
  --step-1-ry: -22deg;
  --step-1-rz: 6deg;
  --step-2-rx: 4deg;
  --step-2-ry: 22deg;
  --step-2-rz: -6deg;
}

.feedback li.ok div:before {
  --l: 12px;
  --t: 17px;
  --h: 4px;
  --w: 4px;
  --br: 50%;
  box-shadow: 12px 0 0 var(--e, var(--normal-eye));
}

.feedback li.ok div:after {
  --l: 13px;
  --t: 26px;
  --w: 14px;
  --h: 2px;
  --br: 1px;
  --b: var(--m, var(--normal-mouth));
}

.feedback li.ok.active div:before {
  --middle-s-y: 0.35;
  animation: toggle 0.2s linear forwards;
}

.feedback li.ok.active div:after {
  --middle-s-x: 0.5;
  animation: toggle 0.7s linear forwards;
}

.feedback li.good {
  --step-1-rx: -14deg;
  --step-1-rz: 10deg;
  --step-2-rx: 10deg;
  --step-2-rz: -8deg;
}

.feedback li.good div:before {
  --b: var(--m, var(--normal-mouth));
  --w: 5px;
  --h: 5px;
  --br: 50%;
  --t: 22px;
  --zi: 0;
  opacity: 0.5;
  box-shadow: 16px 0 0 var(--b);
  filter: blur(2px);
}

.feedback li.good div:after {
  --sc: 0;
}

.feedback li.good div svg.eye {
  --t: 15px;
  --sc: -1;
  stroke-dasharray: 4.55;
  stroke-dashoffset: 8.15;
}

.feedback li.good div svg.mouth {
  --t: 22px;
  --sc: -1;
  stroke-dasharray: 13.3;
  stroke-dashoffset: 23.75;
}

.feedback li.good.active div svg.mouth {
  --middle-y: 1px;
  --middle-s: -1;
  animation: toggle 0.8s linear forwards;
}

.feedback li.happy div {
  --step-1-rx: 18deg;
  --step-1-ry: 24deg;
  --step-2-rx: 18deg;
  --step-2-ry: -24deg;
}

.feedback li.happy div:before {
  --sc: 0;
}

.feedback li.happy div:after {
  --b: var(--m, var(--normal-mouth));
  --l: 11px;
  --t: 23px;
  --w: 18px;
  --h: 8px;
  --br: 0 0 8px 8px;
}

.feedback li.happy div svg.eye {
  --t: 14px;
  --sc: -1;
}

.feedback li.happy.active div:after {
  --middle-s-x: 0.95;
  --middle-s-y: 0.75;
  animation: toggle 0.8s linear forwards;
}

.feedback li:not(.active) {
  cursor: pointer;
}

.feedback li:not(.active):active {
  transform: scale(0.925);
}

.feedback li.active {
  --sb: var(--active);
  --sh: var(--active-shadow);
  --m: var(--active-mouth);
  --e: var(--active-eye);
}

.feedback li.active div {
  animation: shake 0.8s linear forwards;
}

.file-heading-area{
    padding-left:25px;
}

@keyframes shake {
  30% {
      transform: perspective(240px) rotateX(var(--step-1-rx, 0deg)) rotateY(var(--step-1-ry, 0deg)) rotateZ(var(--step-1-rz, 0deg)) translateZ(10px);
  }

  60% {
      transform: perspective(240px) rotateX(var(--step-2-rx, 0deg)) rotateY(var(--step-2-ry, 0deg)) rotateZ(var(--step-2-rz, 0deg)) translateZ(10px);
  }

  100% {
      transform: perspective(240px) translateZ(4px);
  }
}

@keyframes tear {
  0% {
      opacity: 0;
      transform: translateY(-2px) scale(0) translateZ(0);
  }

  50% {
      transform: translateY(12px) scale(0.6, 1.2) translateZ(0);
  }

  20%,
  80% {
      opacity: 1;
  }

  100% {
      opacity: 0;
      transform: translateY(24px) translateX(4px) rotateZ(-30deg) scale(0.7, 1.1) translateZ(0);
  }
}

@keyframes toggle {
  50% {
      transform: translateY(var(--middle-y, 0)) scale(var(--middle-s-x, var(--middle-s, 1)), var(--middle-s-y, var(--middle-s, 1))) rotate(var(--middle-r, 0deg));
  }
}

@keyframes angry {
  40% {
      background: var(--active);
  }

  45% {
      box-shadow: inset 3px -3px 4px var(--active-shadow), inset 0 8px 10px var(--active-shadow-angry);
  }
}


.file-title-block{
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-items: center;
}

.img-circle-car-history{
    margin-right:10px;
}

.fl-nav li{
    display:inline-block;
    vertical-align:middle;
}

.fl-nav li a{
    padding:0 !important;
    margin-right:10px !important;
}

.fl-nav li button{
    padding:13px 24px !important;
    height:49px;
    font-size:16px !important;
    font-weight:bold !important;
    min-width:167px;
    line-height:19px;
}

.fl-nav li button i{
    margin-right:8px;
}

.show-stage{
    display: inline-block;
    height: 29px;
    line-height: 17px;
    vertical-align: top;
    margin-bottom:5px;
}

textarea.form-control{
    padding:15px;
}

.details-box{
    margin:10px 0 !important;
}

@media only screen and (max-width: 1700px) {
    ul.nav.nav-tabs{
        display:flex;
    }
    .fl-nav li button{
        min-width:inherit;
        padding:13px 14px !important;
    }
}
@media only screen and (max-width: 1550px) {
    
    .fl-nav li button{
        height: 38px;
        font-size: 13px !important;
        padding: 5px !important;
    }
    #content .container-fluid .nav-tabs > li > a{
        font-size: 14px;
        line-height: 20px;
        margin-right: 0;
    }
    .d-label{
        float: none !important;
        margin-top: 20px  !important;
        display: block  !important;
        text-align: center  !important;
    }
}

@media only screen and (max-width: 1350px) {
    
    .d-label{
        float: none !important;
        margin-top: 20px  !important;
        display: block  !important;
        text-align: center  !important;
    }
}

input#engineers_attachement{
    padding:12px 18px;
}

.btn:focus {
  outline-color: transparent !important;
}

li.active > a > button {
  background-color: #b01321 !important;
  color: white !important;
}

li > a > button {
  
  color: black !important;
}

.top-box-red {
  background: #f9d3d6 0% 0% no-repeat padding-box;
    color: #b01321;
}

div.file-type-buttons label {
    display: inline-block;
}

div.file-type-buttons label > input + img {
    background: #eee;
    border-radius: 5px;
    box-shadow: 0 6px 12px 0 rgba(73, 76, 83, 0.2);
    filter: grayscale(100%);
    padding: 1em;
    width: 100%;
}

</style>

@endsection
@section('content')
<div id="viewport">
    @include('layouts.sidebar')
    <!-- Content -->
    <div id="content">
      @include('layouts.header')
      <div class="container-fluid">
        <div class="file-title-block"> 
                <button class="btn btn-white button-img redirect-click" style="position: relative; bottom: 20px;"  data-redirect="{{route('history')}}"><i class="fa fa fa-angle-left"></i></button>
                <span style="display: inline-flex;" class="file-heading-area">
                  <img alt="" class="img-circle-car-history" src="{{ get_image_from_brand($file->brand) }}">
                  <div>
                    <h3 class="m-t-5">
                        {{$file->vehicle()->Name}} {{ $file->engine }} {{ $file->vehicle()->TORQUE_standard }}
                        <span class="label @if($file->status == 'rejected') label-red @elseif($file->status == 'completed') label-green @elseif($file->status == 'submitted') label-grey @else label-orange @endif">{{ucfirst($file->status)}}<i class="fa @if( $file->status == 'accepted') fa-check @elseif($file->status == 'rejected') fa-close @endif "></i></span>
                    </h3>
                    <p style="display: block;">{{ $file->engine }} {{ $file->vehicle()->TORQUE_standard }}</p>
                  </div>
                </span>
        </div>
        <div class="row bt file-mb">
          
          <div class="col-xl-6 col-lg-6 col-md-6 m-t-40" >
            @if($file->status != "rejected")
            <button class="btn btn-white" id="new-request"><i class="fa fa-code-pull-request"></i> <strong>New Request</strong></button>
            @endif
            
            @if(!$file->acm_file)
              <button class="btn btn-white" id="acm-file"><i class="fa fa-cloud-upload"></i> <strong>ACM File</strong></button>
            @endif

            <button class="btn btn-white" id="note-button"><i class="fa fa-cloud-upload"></i> <strong>Add Personal Note</strong></button>
            
            @if($file->status != "rejected")
            <div class="main-file-box m-t-40 hide" id="new-request-box">
              <div class="card m-t-10">
                <div class="card-header">
                  <div style="margin-bottom: 20px;">
                    <span style="">
                      <h4 style="margin-bottom: 10px;">New Request</h4>
                      
                      <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                          <form method="POST" action="{{ route('request-file') }}" enctype="multipart/form-data">
                            <div class="tab-content">
                                
                                @csrf
                                <input type="hidden" id="tool_type" name="tool_type" value="">
                                <input type="hidden" name="file_id" value="{{$file->id}}">
                                <div class="m-t-5" style="margin-bottom: 10px;">

                                    <h5>{{__('Select File Type')}}</h5>
                                    {{-- <div class="input-field col s12" style="margin-left:5px; display:flex;"> --}}
                                    <div class="row file-types file-type-buttons">
                                        <label class="file-type-label col-lg-3">
                                            <input type="radio" value="ecu_file" class="file-selection file_type" name="file_type">
                                            <img src="https://resellers.ecutech.tech/assets/img/OLSx-pictogram-file-02.svg">
                                            <span>
                                                ECU file
                                            </span>
                                        </label>
                                        <label class="file-type-label col-lg-3">
                                            <input type="radio" value="gearbox_file" class="file-selection file_type" name="file_type">
                                            <img src="https://resellers.ecutech.tech/assets/img/OLSxGearBox.svg">
                                            <span>
                                                Gearbox file
                                            </span>
                                        </label>

                                        @error('file_type')
                                        <p class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                        @enderror
                                    
                                    
                                <div class="col-lg-6" >
                                    <div class="form-group hide" id="ecu_file_select">
                                        <select name="request_type"  class="select-dropdown form-control">
                                            <option value="status" selected disabled>{{__('Request Type')}} </option>
                                            <option value="new_upload">{{__('New upload')}}</option>
                                            <option value="tuning_evolution">{{__('Tuning Evolution - I want to make a new tuning request.')}}</option>
                                            {{-- <option value="back_to_tuned">{{__('Back to tuned - The car has been updated by the dealer, please renew the tuning.')}}</option>
                                            <option value="back_to_stock">{{__('Back to stock - Send me back the original version.')}}</option>
                                            <option value="back_to_stock_with_virtual_read">{{__('Back to stock with virtual read - Its a virtual read, can you send me this file back to flash the car in stock mode?')}}</option>
                                            <option value="problem_RMA">{{__('Problem - RMA - Ive an issue with this file, can you check?')}}</option> --}}
                                        </select>
                                    </div>
                                    <div class="form-group hide" id="gearbox_file_select">
                                        <select name="request_type" class="select-dropdown  form-control">
                                            <option value="status" selected disabled>{{__('Request Type')}} </option>
                                            <option value="new_upload">{{__('New Upload')}}</option>
                                        </select>
                                    </div>
                                </div>
                              </div>
                                {{-- </div> --}}
                                <div class="input-field m-t-20">
                                    <div class="form-group">
                                      <label>Tools</label>
                                        <select class="form-control f-dropdown" name="master_tools" id="master_tools">
                                            @foreach($masterTools as $ma)
                                            <option data-image="{{ get_dropdown_image(trim_str($ma->tool_id)) }}" value="{{$ma->tool_id}}">{{get_tool_name($ma->tool_id).' (master)'}}</option>
                                            @endforeach
                                            @if(!empty($slaveTools))
                                                @foreach($slaveTools as $s)
                                                <option data-image="{{ get_dropdown_image(trim_str($s->tool_id)) }}" value="{{$s->tool_id}}" data-tool_type='Slave'>{{get_tool_name($s->tool_id).' (slave)'}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('master_tools')
                                    <p class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                    @enderror
                                </div>
                                <div class="file-field input-field col s12">
                                    <div class="btn">
                                        
                                        <input type="file" name="request_file" class="" id="request_file">
                                    </div>
                                    @error('request_file')
                                    <p class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                    @enderror
                                </div>
                                
                                </div>
                            </div>
                            <div class="tab-footer text-center">
                              <button type="submit" class="btn btn-info"><i class="fa fa-submit"></i> Next</button>
                            </div>
                            </form>
                        </div>
                      </div>
                      
                    </span>
                  </div>
                </div>
              </div>
            </div>


            @endif

            <div class="main-file-box m-t-40 hide" id="acm-file-box">

              <div class="card m-t-10">
                <div class="card-header">
                  <div style="margin-bottom: 20px;">
                    <span style="">
                      <h4 style="margin-bottom: 10px;">ACM File</h4>
                      <strong>Pleaes upload ACM File and Engineer will get it.</strong>
                      <p>
                        <i style="color: red;" class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        <span style="color: darkgray;"></span>
                      </p>
                      <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                      <form method="POST" action="{{ route('acm-file-upload') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="file_id" value="{{$file->id}}">
                          <div class="form-group">
                            <label for="exampleInputName1">Attachment</label>
                          <input type="file" name="acm_file" class="form-control" id="acm_file">
                          </div>

                          <button type="submit" class="btn btn-info"><i class="fa fa-submit"></i> Submit</button>
                        
                      </form>
                        </div>
                      </div>
                      
                    </span>
                  </div>
                </div>
              </div>

            </div>

            <div class="main-file-box m-t-40 hide" id="note-box">
              <div class="card m-t-10">
                <div class="card-header">
                  <div style="margin-bottom: 20px;">
                    <span style="">
                      <h4 style="margin-bottom: 10px;">Personal Note</h4>
                      <strong>Add an internal note to the vehicle's timeline</strong>
                      <p>
                        <i style="color: red;" class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        <span style="color: darkgray;">You only can view this note. Engineers will not be notified.</span>
                      </p>
                      <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                      <form method="POST" action="{{ route('file-url') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="file_id" value="{{$file->id}}">

                          <div class="form-group m-t-20">
                            
                            <textarea class="form-control" style="width: 100%; height: 100px;" id="car-info-memo" name="file_url" class="materialize-textarea" placeholder="{{__('Personal Note.')}}"></textarea>
                            @error('file_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label for="exampleInputName1">Attachment</label>
                          <input type="file" name="file_url_attachment" class="form-control" id="file_url_attachment">
                          </div>

                          <button type="submit" class="btn btn-info"><i class="fa fa-submit"></i> Submit</button>
                        
                      </form>
                        </div>
                      </div>
                      
                    </span>
                  </div>
                </div>
              </div>

            </div>

            <div class="main-file-box m-t-40">
              <span>
                <i class="fa fa-download top-box top-box-grey"></i>
              </span>
              <h3 style="display: inline; color: #021F7E; margin-left: 20px;">
                File Uploaded
              </h3>
              
              <span style="float: right; margin-top: 20px;" class="d-label">
                <span class="label label-danger">
                  Credits: {{$file->credits}}
                </span> 
                {{ $file->created_at->format('d/m/Y')}} at {{$file->created_at->format('H:i:s')}}
              </span>
              <div style="padding-left: 60px;" class="card-dt">
                <div class="card m-t-10">
                  <div class="card-header">
                    <div style="margin-bottom: 20px;">
                      <span style="display: inline-grid;">
                        <h4 style="margin-bottom: 10px;">File Details:</h4>
                        <span>This file is sent to the engineer with following details.</span>
                      </span>
                    
                    </div>

                    <span class="file-name-box">
                      
                      <span style="display: inline-grid;">
                        <strong>File Name:</strong>
                        <span class="f-name">{{$file->file_attached}}</span>
                      </span>
                    <a href="{{route('download', [$file->id,$file->file_attached])}}" class="btn btn-info" style="float: right;"><i class="fa fa-download"></i> Downloand</a>
                    </span>
                    @if($file->acm_file)
                    <div class="bt m-t-20 p-t-10">
                      <span style="display: inline-grid;margin-bottom: 20px;" >
                        <strong>ACM File Name:</strong>
                        <span class="f-name">{{$file->acm_file}}</span>
                      </span>
                          <a class="btn btn-info" href="{{route('download', [$file->id,$file->acm_file])}}" style="float: right;"><i class="fa fa-download"></i> Downloand</a>
                    </div>
                    @endif
                    <div class="bt m-t-10 p-t-10">
                      <span><strong>Stages and Options:</strong></span>
                    </div>
                    <div class="m-t-10" style="line-height: 2.7;">
                      @if($file->stages_services)
                        @php $stage = \ECUApp\SharedCode\Models\Service::FindOrFail( $file->stages_services->service_id); @endphp
                        @if($stage)
                            <span class="show-stage"><img style="width: 20px;" src="{{ get_logo_for_stages_and_options( $stage->name ) }}" alt="{{$stage->name}}">
                              {{ $stage->name }}</span>
                        @endif
                      @endif
                      @if($file->options_services)
                        @foreach($file->options_services as $option)
                          @php 
                              $op = \ECUApp\SharedCode\Models\Service::FindOrFail( $option->service_id ); 
                          @endphp
                          @if($op)
                          <span class="show-stage"><img style="width: 20px;" src="{{ get_logo_for_stages_and_options( $op->name ) }}" alt="{{$op->name}}">
                            {{ $op->name }}</span>
                          @endif
                        @endforeach
                      @endif
                    </div>
                    
                    <div class="bt m-t-20 p-t-10">
                      <span><strong>Reading Tool:</strong></span>
                      <div class="m-t-10">
                        <span class="show-stage">
                          <img style="width: 20px;" src="{{ get_dropdown_image($file->tool_id) }}" class="tool-logo-small"> {{ ucfirst($file->tool_type) }}
                        </span>
                      </div>
                    </div>
                   

                  </div>
                </div>
              </div>
            </div>

            <div class="main-file-box m-t-40">
              <span>
                <i class="fa fa-download top-box top-box-grey"></i>
              </span>
              <h3 style="display: inline; color: #021F7E; margin-left: 20px;">
                File Support
              </h3>
              
              <div style="padding-left: 60px;" class="card-dt">
                <div class="card m-t-10">
                  <div class="card-header">
                    <div style="margin-bottom: 20px;">
                      @if(!$file->messages_and_logs()->isEmpty())
                      @foreach($file->messages_and_logs() as $engineersMessage)
                        <div class="row bb-light" style="padding: 10px 30px 10px 30px;">
                          <div>
                            @if($engineersMessage->engineer)
                            <div>
                              <i style="font-size: 24px; color: #B01321;" class="fas fa-user-circle"></i>
                              <strong style="font-size: 18px;color: #B01321;">Engineer's Reply</strong>
                              <p style="float: right;">{{ $engineersMessage->created_at->format('d/m/Y')}} at {{$engineersMessage->created_at->format('H:i:s')}}</p>
                            </div>
                            @else
                              
                              <i style="font-size: 24px;" class="fas fa-user-circle"></i>
                              @if(isset($engineersMessage->egnineers_internal_notes))
                                <strong style="font-size: 18px;">Help Request</strong>  
                              @else
                                <strong style="font-size: 18px;">Log Entry</strong> 
                              @endif
                              <p style="float: right;">{{ $engineersMessage->created_at->format('d/m/Y')}} at {{$engineersMessage->created_at->format('H:i:s')}}</p>
                            @endif
                          <p>
                            @if(isset($engineersMessage->egnineers_internal_notes))
                              <p>{!!$engineersMessage->egnineers_internal_notes!!}</p>
                            @else
                              <p>{{$engineersMessage->events_internal_notes}}</p>
                            @endif
                          </div>
  
                          @if(isset($engineersMessage->egnineers_internal_notes))
                          @if($engineersMessage->engineers_attachement)
                              
                              <strong class="">Filename: </strong><span class="">{{$engineersMessage->engineers_attachement}}</span>
                              <a href="{{route('download', [$file->id,$engineersMessage->engineers_attachement])}}" class="btn-sm btn-info" style="float: right;">Download</a>
                          @endif
                          @else
                          @if($engineersMessage->events_attachement)
                              
                          <strong class="">Filename: </strong><span class="">{{$engineersMessage->events_attachement}}</span>
                          <a href="{{route('download', [$file->id,$engineersMessage->events_attachement])}}" class="btn-sm btn-info" style="float: right;">Download</a>
                          @endif
                          @endif
                        </div>
                      @endforeach
                        @endif
                      <div class="m-t-10">
                        <div class="card-header">
                          <div style="margin-bottom: 20px;">
                            <span style="">
                              <h4 style="margin-bottom: 10px;">Support Message</h4>
                              <strong></strong>
                              <p>
                                <i style="color: red;" class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                <span style="color: darkgray;">You can send Message to Engineer. Engineers will be notified.</span>
                              </p>
                              <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12">
                              <form method="POST" action="{{ route('file-engineers-notes') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="file_id" value="{{$file->id}}">
        
                                  <div class="form-group m-t-20">
                                    
                                    <textarea class="form-control" style="width: 100%; height: 100px;" id="car-info-memo" name="egnineers_internal_notes" class="materialize-textarea" placeholder="{{__('Support Message.')}}"></textarea>
                                    @error('egnineers_internal_notes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputName1">Attachment</label>
                                  <input type="file" name="engineers_attachement" class="form-control" id="engineers_attachement">
                                  </div>
        
                                  <button type="submit" class="btn btn-info"><i class="fa fa-submit"></i> Submit</button>
                                
                              </form>
                                </div>
                              </div>
                              
                            </span>
                          </div>
                        </div>
                      </div>
                    
                    </div>
  
                    
                  </div>
                </div>
            </div>
            
            </div>

            @if(!$file->offers->isEmpty())
            @php $difference=0; 
            $creditsProposed = 0;
            @endphp
            <div class="main-file-box m-t-40">
              <span>
                <i class="fa fa-download top-box top-box-grey"></i>
              </span>
              <h3 style="display: inline; color: #021F7E; margin-left: 20px;">
                Proposed Stage and Option
              </h3>
              <div style="padding-left: 60px;" class="card-dt">
              <div class="card m-t-10">
                <div class="card-header">

                  <div style="margin-bottom: 20px;">
                    <span style="display: inline-grid;">
                      <h4 style="margin-bottom: 10px;">File Details:</h4>
                      <span>Engineer proposed following Stage and Options for this file Please confirm or Reject.</span>
                    </span>
                  </div>

              <span class="file-name-box">
                      
                <span style="display: inline-grid;">
                  <strong>File Name:</strong>
                  <span class="f-name">{{$file->file_attached}}</span>
                </span>
             
              </span>
              <div class="bt m-t-10 p-t-10">
                <span><strong>Proposed Stages and Options:</strong></span>
              </div>
              <div class="m-t-10" style="line-height: 2.7;">
                    @if($file->stage_offer)
                      @php 
                        
                        $stage = \ECUApp\SharedCode\Models\Service::FindOrFail( $file->stage_offer->service_id);

                          $creditsProposed += $stage->credits;

                      @endphp
                      @if($stage)
                          <span class="show-stage">
                            <img style="width: 20px;" src="{{ get_logo_for_stages_and_options( $stage->name ) }}" alt="{{$stage->name}}">
                            {{ $stage->name }}
                          </span>
                      @endif
                    @endif
                    
                    @if(!$file->options_offer->isEmpty())
                      @foreach($file->options_offer as $option)
                        @php 
                            $op = \ECUApp\SharedCode\Models\Service::FindOrFail( $option->service_id ); 

                              $creditsProposed += $op->credits;
                            
                        @endphp
                        @if($op)
                        <span class="show-stage"><img style="width: 20px;" src="{{ get_logo_for_stages_and_options( $op->name ) }}" alt="{{$op->name}}">
                          {{ $op->name }}</span>
                        @endif
                      @endforeach
                    @endif

                    @php 
                      $difference = $file->credits - $creditsProposed;
                      
                    @endphp

                  </div>
                  <div class="bt m-t-20 p-t-10 text-center">
                    @if( $difference < 0 )

                      <span class="label label-danger">Credits to Pay: {{-1*$difference}}</span>
                    
                    @elseif($difference > 0)

                      <span class="label label-success">Credits to be saved: {{$difference}}</span>
                    @elseif($difference == 0)
                    
                      <span class="label label-success">Credits will remain same.</span>

                    @endif
                  </div>

                  <div class="bt m-t-20 p-t-10 text-center">
                    @if($difference >= 0)
                      <button type="submit" class="btn btn-info" id="btn-accept" data-file_id="{{$file->id}}"><i class="fa fa-check"></i> Accept Options</button>
                    @else
                      <a class="btn btn-info" href="{{route('pay-credits-offer', $file->id)}}"><i class="fa fa-check"></i> Pay Credits</a>
                    @endif
                    <button type="submit" class="btn btn-danger" id="btn-reject" data-file_id="{{$file->id}}><i class="fa fa-close"></i> Reject</button>
                  </div>

                </div>
              </div>
              </div>

            </div>

            @endif

            @if($file->status == 'rejected')
            <div class="main-file-box m-t-40">
              <span>
                <i class="fa fa-download top-box top-box-red"></i>
              </span>
              <h3 style="display: inline; color: #b01321; margin-left: 20px;">
                File Rejected
              </h3>

              <span style="float: right; margin-top: 20px;" class="d-label">
                <span class="label label-danger">Credits: {{$file->credits}}</span> 
                
              <div style="padding-left: 60px;" class="card-dt">
                <div class="card m-t-10">
                  <div class="card-header">
                    <div style="margin-bottom: 20px;">
                      <span style="display: inline-grid;">
                        <h4 style="margin-bottom: 10px;">Reason To Reject:</h4>
                        <span class="text-danger">{{$file->reason_to_reject}}</span>
                      </span>
                    
                    </div>

                    
                  </div>
                </div>
            </div>
            </div>
            @endif

            

            @foreach($file->files as $row)

            @if($row->is_kess3_slave)

            @if($row->uploaded_successfully)

            {{-- @if($file->no_longer_auto == 0) --}}

            <div class="main-file-box m-t-40">
              <span>
                <i class="fa fa-upload top-box top-box-green"></i>
              </span>
              <h3 style="display: inline; color: #237E02; margin-left: 20px;">
                File Received
              </h3>
              <span class="r-file-span" style="float: right; margin-top: 15px;">{{ $row->created_at->format('d/m/Y')}} at {{$row->created_at->format('H:i:s')}}</span>
            
            <div style="padding-left: 60px;" class="card-dt">
            <div class="card m-t-10">

              <div class="card-header">
                <div style="margin-bottom: 20px;">
                  <span style="display: inline-grid;">
                    <h4 style="margin-bottom: 10px;">File Received:</h4>
                    <span>This file is uploaded by the engineer with following details.</span>
                  </span>
                </div>

                <span class="file-name-box">
                  <span style="display: inline-grid;">
                    <strong>File Name:</strong>
                    <span class="f-name">{{$row->request_file}}</span>
                  </span>

                  @if($file->comments())

                  @if($file->showComments())

                    @if($row->show_comments())
                      <button class="btn btn-info btn-download" data-make="{{$file->brand}}" data-engine="{{$file->engine}}" data-ecu="{{$file->ecu}}" data-model="{{$file->model}}" data-generation="{{$file->version}}" data-file_id="{{$file->id}}" data-path="{{route('download', [$row->file_id,$row->request_file])}}" style="float: right;"><i class="fa fa-download"></i> Downloand</button>
                    @else
                      <a class="btn btn-info" href="{{route('download', [$row->file_id,$row->request_file])}}" style="float: right;"><i class="fa fa-download"></i> Downloand</a>
                    @endif
                  @else
                    <a class="btn btn-info" href="{{route('download', [$row->file_id,$row->request_file])}}" style="float: right;"><i class="fa fa-download"></i> Downloand</a>
                  @endif

                  @else
                    <a class="btn btn-info" href="{{route('download', [$row->file_id,$row->request_file])}}" style="float: right;"><i class="fa fa-download"></i> Downloand</a>
                  @endif
                </span>

                @if($file->acm_file)
                @if($row->acm_files)
              @foreach($row->acm_files as $acm)
                <div class="bt m-t-20 p-t-10">
                  <span style="display: inline-grid;margin-bottom: 20px;" >
                    <strong>ACM File Name:</strong>
                    <span class="f-name">{{$acm->acm_file}}</span>
                  </span>
                      <a class="btn btn-info" href="{{route('download', [$file->id,$acm->acm_file])}}" style="float: right;"><i class="fa fa-download"></i> Downloand</a>
                </div>
              @endforeach
              @endif
              @endif

                <div class="bt m-t-10 p-t-10">
                  <span><strong>Stages and Options:</strong></span>
                </div>
                <div class="m-t-10">
                  @if($file->stages_services)
                    @php $stage = \ECUApp\SharedCode\Models\Service::FindOrFail( $file->stages_services->service_id); @endphp
                    @if($stage)
                        <span class="show-stage"><img style="width: 20px;" src="{{ get_logo_for_stages_and_options( $stage->name ) }}" alt="{{$stage->name}}">
                          {{ $stage->name }}</span>
                    @endif
                  @endif
                  @if($file->options_services)
                    @foreach($file->options_services as $option)
                      @php 
                          $op = \ECUApp\SharedCode\Models\Service::FindOrFail( $option->service_id ); 
                      @endphp
                      @if($op)
                      <span class="show-stage"><img style="width: 20px;" src="{{ get_logo_for_stages_and_options( $op->name ) }}" alt="{{$stage->name}}">
                        {{ $op->name }}</span>
                      @endif
                    @endforeach
                  @endif
                </div>

                <div class="bt m-t-20 p-t-10">
                  <span><strong>Reading Tool:</strong></span>
                  <div class="m-t-10">
                    <span class="show-stage">
                      <img style="width: 20px;" src="{{ get_dropdown_image($file->tool_id) }}" class="tool-logo-small"> {{ ucfirst($file->tool_type) }}
                    </span>
                  </div>
                </div>
                
                <div class="m-t-20 bt">
                  <ul class="nav nav-tabs fl-nav fl-nav-mb" style="border-bottom: 0px; padding: 10px 0;">
                    {{-- <li  class="active">
                      <a style="border: none;" data-toggle="tab" href="#support-{{$row->id}}">
                        <button class="btn btn-white">
                          <i>
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABXElEQVR4nN2VO0sDQRSFdy0sFIyxtrINWIhYiFgr1oKIWFhraSfYmPwBEUH0J6iNWgmKWFj4FwRNAmkEn/EJfjJwhesyu3OzWogHtjl7zj0zc+cRRf8aQDswC2wDV8CTfFXhZpwmb/ER4JIwLoDhVouPAq+G4l94dh5r8S7gmtZRBzosAYvkx7wl4Mhj3Ac+DAEHloDbhGkTaAMmgXPgLSOgbgl4EfEG0G/Qx8CYeJqWgHcRhxsmALrVLGrAeOSDK6q2Z6dwFeARKCudj9OopgXsqH1dEu5BuHul83HfkBbQlP8lxZWl4EqAMwXsKc26V5SCRP1aVrPWZM+7Ne7JEXAHTITEuyJeTvAVOSdLHs+CeLYsoxlUzR7wNDcLU9Ypr4rBXce9qrlZt+yJ+X2Qx+ZMjA1gDijKWekDhkyFAiFF4DBltG754t8IiYFp4Bi4kbPiXrpToPDjgD+PT0xxfXWFo4ayAAAAAElFTkSuQmCC">
                          </i> Engineer Support
                        </button>
                      </a>
                    </li> --}}
                    <li><a style="border: none;" data-toggle="tab" href="#log-{{$row->id}}"><button class="btn btn-white"><i class="fa fa-file" style="transform: rotate(-90deg)"></i> Add Log</button></a></li>
                    <li><a style="border: none;" data-toggle="tab" href="#star-{{$row->id}}"><button class="btn btn-white"><i class="fa fa-star"></i> Add a Rating</button></a></li>
                    
                  </ul>
                  
                  <div class="tab-content">
                    {{-- <div id="support-{{$row->id}}" class="tab-pane fade active in">

                      <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                        <form method="POST" action="{{ route('file-engineers-notes') }}" enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" name="file_id" value="{{$file->id}}">
                          <input type="hidden" name="request_file_id" value="{{$row->id}}">
                            
                            <div class="form-group m-t-20">
                              <label for="exampleInputName1">Ask Engineer for Support</label>
                              <textarea class="form-control" style="width: 100%; height: 100px;" id="car-info-memo" name="egnineers_internal_notes" class="materialize-textarea" placeholder="{{__('Internal note for Engineers.')}}"></textarea>
                              @error('egnineers_internal_notes')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                            <div class="form-group">
                              <label for="exampleInputName1">Attachment</label>
                            <input type="file" name="engineers_attachement" class="form-control" id="engineers_attachement">
                            </div>

                            <button type="submit" class="btn btn-info"><i class="fa fa-submit"></i> Submit</button>
                          
                        </form>
                      </div>
                      </div>

                    </div> --}}
                    <div id="log-{{$row->id}}" class="tab-pane fade">

                      <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                        <form method="POST" action="{{ route('file-events-notes') }}" enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" name="file_id" value="{{$file->id}}">
                          <input type="hidden" name="request_file_id" value="{{$row->id}}">
                            
                            <div class="form-group m-t-20">
                              <label for="exampleInputName1">Attach log file and send to engineer.</label>
                              <textarea class="form-control" style="width: 100%; height: 100px;" id="car-info-memo" name="events_internal_notes" class="materialize-textarea" placeholder="{{__('Internal note for To save on timeline.')}}"></textarea>
                              @error('events_internal_notes')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                            <div class="form-group">
                              <label for="exampleInputName1">Attachment</label>
                            <input type="file" name="events_attachement" class="form-control" id="events_attachement">
                            </div>

                            <button type="submit" class="btn btn-info"><i class="fa fa-submit"></i> Submit</button>
                          
                        </form>
                      </div>
                      </div>


                    </div>
                    <div id="star-{{$row->id}}" class="tab-pane fade">

                      <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                          <ul class="feedback">
                            <li class="angry @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'angry' ) active @endif" data-type="angry" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                                <div>
                                    <svg class="eye left">
                                        <use xlink:href="#eye">
                                    </svg>
                                    <svg class="eye right">
                                        <use xlink:href="#eye">
                                    </svg>
                                    <svg class="mouth">
                                        <use xlink:href="#mouth">
                                    </svg>
                                </div>
                            </li>
                            <li class="sad @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'sad' ) active @endif" data-type="sad" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                                <div>
                                    <svg class="eye left">
                                        <use xlink:href="#eye">
                                    </svg>
                                    <svg class="eye right">
                                        <use xlink:href="#eye">
                                    </svg>
                                    <svg class="mouth">
                                        <use xlink:href="#mouth">
                                    </svg>
                                </div>
                            </li>
                            <li class="ok @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'ok' ) active @endif" data-type="ok" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                                <div></div>
                            </li>
                            <li class="good @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'good' ) active @endif" data-type="good" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                                <div>
                                    <svg class="eye left">
                                        <use xlink:href="#eye">
                                    </svg>
                                    <svg class="eye right">
                                        <use xlink:href="#eye">
                                    </svg>
                                    <svg class="mouth">
                                        <use xlink:href="#mouth">
                                    </svg>
                                </div>
                            </li>
                            <li class="happy @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'happy' ) active @endif" data-type="happy" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                                <div>
                                    <svg class="eye left">
                                        <use xlink:href="#eye">
                                    </svg>
                                    <svg class="eye right">
                                        <use xlink:href="#eye">
                                    </svg>
                                </div>
                            </li>
                        </ul>
        
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 4" id="eye">
                                <path d="M1,1 C1.83333333,2.16666667 2.66666667,2.75 3.5,2.75 C4.33333333,2.75 5.16666667,2.16666667 6,1"></path>
                            </symbol>
                            <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 7" id="mouth">
                                <path d="M1,5.5 C3.66666667,2.5 6.33333333,1 9,1 C11.6666667,1 14.3333333,2.5 17,5.5"></path>
                            </symbol>
                        </svg>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

              </div>
              
            </div>
            </div>
          </div>

          @endif


          @else


          <div class="main-file-box m-t-40">
            <span>
              <i class="fa fa-upload top-box top-box-green"></i>
            </span>
            <h3 style="display: inline; color: #237E02; margin-left: 20px;">
              File Received
            </h3>
            <span class="r-file-span" style="float: right; margin-top: 15px;">{{ $row->created_at->format('d/m/Y')}} at {{$row->created_at->format('H:i:s')}}</span>
          
          <div style="padding-left: 60px;" class="card-dt">
          <div class="card m-t-10">

            <div class="card-header">
              <div style="margin-bottom: 20px;">
                <span style="display: inline-grid;">
                  <h4 style="margin-bottom: 10px;">File Received:</h4>
                  <span>This file is uploaded by the engineer with following details.</span>
                </span>
              </div>

              <span class="file-name-box" style="margin-bottom: 20px;">
                <span style="display: inline-grid;" >
                  <strong>ECU File Name:</strong>
                  <span class="f-name">{{$row->request_file}}</span>
                </span>

                @if($file->comments())

                @if($file->showComments())

                  @if($row->show_comments())
                    <button class="btn btn-info btn-download" data-make="{{$file->brand}}" data-engine="{{$file->engine}}" data-ecu="{{$file->ecu}}" data-model="{{$file->model}}" data-generation="{{$file->version}}" data-file_id="{{$file->id}}" data-path="{{route('download', [$row->file_id,$row->request_file])}}" style="float: right;"><i class="fa fa-download"></i> Downloand</button>
                  @else
                    <a class="btn btn-info" href="{{route('download', [$row->file_id,$row->request_file])}}" style="float: right;"><i class="fa fa-download"></i> Downloand</a>
                  @endif
                @else
                  <a class="btn btn-info" href="{{route('download', [$row->file_id,$row->request_file])}}" style="float: right;"><i class="fa fa-download"></i> Downloand</a>
                @endif

                @else
                  <a class="btn btn-info" href="{{route('download', [$row->file_id,$row->request_file])}}" style="float: right;"><i class="fa fa-download"></i> Downloand</a>
                @endif

              </span>

              @if($file->acm_file)
              
                @if($row->acm_files)
              @foreach($row->acm_files as $acm)
                <div class="bt m-t-20 p-t-10">
                  
                  
                  <span style="display: inline-grid;margin-bottom: 20px;" >
                    <strong>ACM File Name:</strong>
                    <span class="f-name">{{$acm->acm_file}}</span>
                  </span>
                      <a class="btn btn-info" href="{{route('download', [$file->id,$acm->acm_file])}}" style="float: right;"><i class="fa fa-download"></i> Downloand</a>
                    
                  
                </div>
              @endforeach
              @endif
              @endif

              <div class="bt m-t-10 p-t-10">
                <span><strong>Stages and Options:</strong></span>
              </div>
              <div class="m-t-10">
                @if($file->stages_services)
                  @php $stage = \ECUApp\SharedCode\Models\Service::FindOrFail( $file->stages_services->service_id); @endphp
                  @if($stage)
                      <span class="show-stage"><img style="width: 20px;" src="{{ get_logo_for_stages_and_options( $stage->name ) }}" alt="{{$stage->name}}">
                        {{ $stage->name }}</span>
                  @endif
                @endif
                @if($file->options_services)
                  @foreach($file->options_services as $option)
                    @php 
                        $op = \ECUApp\SharedCode\Models\Service::FindOrFail( $option->service_id ); 
                    @endphp
                    @if($op)
                    <span class="show-stage"><img style="width: 20px;" src="{{ get_logo_for_stages_and_options( $op->name ) }}" alt="{{$stage->name}}">
                      {{ $op->name }}</span>
                    @endif
                  @endforeach
                @endif
              </div>

              <div class="bt m-t-20 p-t-10">
                <span><strong>Reading Tool:</strong></span>
                <div class="m-t-10">
                  <span class="show-stage">
                    <img style="width: 20px;" src="{{ get_dropdown_image($file->tool_id) }}" class="tool-logo-small"> {{ ucfirst($file->tool_type) }}
                  </span>
                </div>
              </div>
              
              <div class="m-t-20 bt">
                <ul class="nav nav-tabs fl-nav fl-nav-mb" style="border-bottom: 0px; padding: 10px 0;">
                  {{-- <li  class="active">
                    <a style="border: none;" data-toggle="tab" href="#support-{{$row->id}}">
                      <button class="btn btn-white">
                        <i>
                          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABXElEQVR4nN2VO0sDQRSFdy0sFIyxtrINWIhYiFgr1oKIWFhraSfYmPwBEUH0J6iNWgmKWFj4FwRNAmkEn/EJfjJwhesyu3OzWogHtjl7zj0zc+cRRf8aQDswC2wDV8CTfFXhZpwmb/ER4JIwLoDhVouPAq+G4l94dh5r8S7gmtZRBzosAYvkx7wl4Mhj3Ac+DAEHloDbhGkTaAMmgXPgLSOgbgl4EfEG0G/Qx8CYeJqWgHcRhxsmALrVLGrAeOSDK6q2Z6dwFeARKCudj9OopgXsqH1dEu5BuHul83HfkBbQlP8lxZWl4EqAMwXsKc26V5SCRP1aVrPWZM+7Ne7JEXAHTITEuyJeTvAVOSdLHs+CeLYsoxlUzR7wNDcLU9Ypr4rBXce9qrlZt+yJ+X2Qx+ZMjA1gDijKWekDhkyFAiFF4DBltG754t8IiYFp4Bi4kbPiXrpToPDjgD+PT0xxfXWFo4ayAAAAAElFTkSuQmCC">
                        </i> Engineer Support
                      </button>
                    </a>
                  </li> --}}
                  <li><a style="border: none;" data-toggle="tab" href="#log-{{$row->id}}"><button class="btn btn-white"><i class="fa fa-file" style="transform: rotate(-90deg)"></i> Add Log</button></a></li>
                  <li><a style="border: none;" data-toggle="tab" href="#star-{{$row->id}}"><button class="btn btn-white"><i class="fa fa-star"></i> Add a Rating</button></a></li>
                  
                </ul>
                
                <div class="tab-content">
                  {{-- <div id="support-{{$row->id}}" class="tab-pane fade active in">

                    <div class="row">
                      <div class="col-xl-12 col-lg-12 col-md-12">
                      <form method="POST" action="{{ route('file-engineers-notes') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="file_id" value="{{$file->id}}">
                        <input type="hidden" name="request_file_id" value="{{$row->id}}">
                          
                          <div class="form-group m-t-20">
                            <label for="exampleInputName1">Ask Engineer for Support</label>
                            <textarea class="form-control" style="width: 100%; height: 100px;" id="car-info-memo" name="egnineers_internal_notes" class="materialize-textarea" placeholder="{{__('Internal note for Engineers.')}}"></textarea>
                            @error('egnineers_internal_notes')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label for="exampleInputName1">Attachment</label>
                          <input type="file" name="engineers_attachement" class="form-control" id="engineers_attachement">
                          </div>

                          <button type="submit" class="btn btn-info"><i class="fa fa-submit"></i> Submit</button>
                        
                      </form>
                    </div>
                    </div>

                  </div> --}}
                  <div id="log-{{$row->id}}" class="tab-pane fade">

                    <div class="row">
                      <div class="col-xl-12 col-lg-12 col-md-12">
                      <form method="POST" action="{{ route('file-events-notes') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="file_id" value="{{$file->id}}">
                        <input type="hidden" name="request_file_id" value="{{$row->id}}">
                          
                          <div class="form-group m-t-20">
                            <label for="exampleInputName1">Attach log file and send to engineer.</label>
                            <textarea class="form-control" style="width: 100%; height: 100px;" id="car-info-memo" name="events_internal_notes" class="materialize-textarea" placeholder="{{__('Internal note for To save on timeline.')}}"></textarea>
                            @error('events_internal_notes')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label for="exampleInputName1">Attachment</label>
                          <input type="file" name="events_attachement" class="form-control" id="events_attachement">
                          </div>

                          <button type="submit" class="btn btn-info"><i class="fa fa-submit"></i> Submit</button>
                        
                      </form>
                    </div>
                    </div>


                  </div>
                  <div id="star-{{$row->id}}" class="tab-pane fade">

                    <div class="row">
                      <div class="col-xl-12 col-lg-12 col-md-12">
                        <ul class="feedback">
                          <li class="angry @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'angry' ) active @endif" data-type="angry" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                              <div>
                                  <svg class="eye left">
                                      <use xlink:href="#eye">
                                  </svg>
                                  <svg class="eye right">
                                      <use xlink:href="#eye">
                                  </svg>
                                  <svg class="mouth">
                                      <use xlink:href="#mouth">
                                  </svg>
                              </div>
                          </li>
                          <li class="sad @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'sad' ) active @endif" data-type="sad" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                              <div>
                                  <svg class="eye left">
                                      <use xlink:href="#eye">
                                  </svg>
                                  <svg class="eye right">
                                      <use xlink:href="#eye">
                                  </svg>
                                  <svg class="mouth">
                                      <use xlink:href="#mouth">
                                  </svg>
                              </div>
                          </li>
                          <li class="ok @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'ok' ) active @endif" data-type="ok" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                              <div></div>
                          </li>
                          <li class="good @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'good' ) active @endif" data-type="good" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                              <div>
                                  <svg class="eye left">
                                      <use xlink:href="#eye">
                                  </svg>
                                  <svg class="eye right">
                                      <use xlink:href="#eye">
                                  </svg>
                                  <svg class="mouth">
                                      <use xlink:href="#mouth">
                                  </svg>
                              </div>
                          </li>
                          <li class="happy @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'happy' ) active @endif" data-type="happy" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                              <div>
                                  <svg class="eye left">
                                      <use xlink:href="#eye">
                                  </svg>
                                  <svg class="eye right">
                                      <use xlink:href="#eye">
                                  </svg>
                              </div>
                          </li>
                      </ul>
      
                      <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                          <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 4" id="eye">
                              <path d="M1,1 C1.83333333,2.16666667 2.66666667,2.75 3.5,2.75 C4.33333333,2.75 5.16666667,2.16666667 6,1"></path>
                          </symbol>
                          <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 7" id="mouth">
                              <path d="M1,5.5 C3.66666667,2.5 6.33333333,1 9,1 C11.6666667,1 14.3333333,2.5 17,5.5"></path>
                          </symbol>
                      </svg>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

            </div>
            
          </div>
          </div>
        </div>


          @endif
          {{-- @endif --}}

          @endforeach

          @foreach($file->own_files as $file)

          <div class="main-file-box m-t-40">
            <span>
              <i class="fa fa-download top-box top-box-grey"></i>
            </span>
            <h3 style="display: inline; color: #021F7E; margin-left: 20px;">
              File Uploaded
            </h3>
            
            <span style="float: right; margin-top: 20px;" class="d-label">
              <span class="label label-danger">
                Credits: {{$file->credits}}
              </span> 
              {{ $file->created_at->format('d/m/Y')}} at {{$file->created_at->format('H:i:s')}}
            </span>
            <div style="padding-left: 60px;" class="card-dt">
              <div class="card m-t-10">
                <div class="card-header">
                  <div style="margin-bottom: 20px;">
                    <span style="display: inline-grid;">
                      <h4 style="margin-bottom: 10px;">File Details:</h4>
                      <span>This file is sent to the engineer with following details.</span>
                    </span>
                  
                  </div>

                  <span class="file-name-box">
                    
                    <span style="display: inline-grid;">
                      <strong>ECU File Name:</strong>
                      <span class="f-name">{{$file->file_attached}}</span>
                    </span>
                  <a href="{{route('download', [$file->id,$file->file_attached])}}" class="btn btn-info" style="float: right;"><i class="fa fa-download"></i> Downloand</a>
                  </span>
                  <div class="bt m-t-10 p-t-10">
                    <span><strong>Stages and Options:</strong></span>
                  </div>
                  <div class="m-t-10" style="line-height: 2.7;">
                    @if($file->stages_services)
                      @php $stage = \ECUApp\SharedCode\Models\Service::FindOrFail( $file->stages_services->service_id); @endphp
                      @if($stage)
                          <span class="show-stage"><img style="width: 20px;" src="{{ get_logo_for_stages_and_options( $stage->name ) }}" alt="{{$stage->name}}">
                            {{ $stage->name }}</span>
                      @endif
                    @endif
                    @if($file->options_services)
                      @foreach($file->options_services as $option)
                        @php 
                            $op = \ECUApp\SharedCode\Models\Service::FindOrFail( $option->service_id ); 
                        @endphp
                        @if($op)
                        <span class="show-stage"><img style="width: 20px;" src="{{ get_logo_for_stages_and_options( $op->name ) }}" alt="{{$op->name}}">
                          {{ $op->name }}</span>
                        @endif
                      @endforeach
                    @endif
                  </div>
                  
                  <div class="bt m-t-20 p-t-10">
                    <span><strong>Reading Tool:</strong></span>
                    <div class="m-t-10">
                      <span class="show-stage">
                        <img style="width: 20px;" src="{{ get_dropdown_image($file->tool_id) }}" class="tool-logo-small"> {{ ucfirst($file->tool_type) }}
                      </span>
                    </div>
                  </div>
                 

                </div>
              </div>
            </div>
          </div>

          <div class="main-file-box m-t-40">
            <span>
              <i class="fa fa-download top-box top-box-grey"></i>
            </span>
            <h3 style="display: inline; color: #021F7E; margin-left: 20px;">
              File Support
            </h3>
            
            <div style="padding-left: 60px;" class="card-dt">
              <div class="card m-t-10">
                <div class="card-header">
                  <div style="margin-bottom: 20px;">
                    @if(!$file->messages_and_logs()->isEmpty())
                    @foreach($file->messages_and_logs() as $engineersMessage)
                      <div class="row bb-light" style="padding: 10px 30px 10px 30px;">
                        <div>
                          @if($engineersMessage->engineer)
                          <div>
                            <i style="font-size: 24px; color: #B01321;" class="fas fa-user-circle"></i>
                            <strong style="font-size: 18px;color: #B01321;">Engineer's Reply</strong>
                            <p style="float: right;">{{ $engineersMessage->created_at->format('d/m/Y')}} at {{$engineersMessage->created_at->format('H:i:s')}}</p>
                          </div>
                          @else
                            
                            <i style="font-size: 24px;" class="fas fa-user-circle"></i>
                            @if(isset($engineersMessage->egnineers_internal_notes))
                              <strong style="font-size: 18px;">Help Request</strong>  
                            @else
                              <strong style="font-size: 18px;">Log Entry</strong> 
                            @endif
                            <p style="float: right;">{{ $engineersMessage->created_at->format('d/m/Y')}} at {{$engineersMessage->created_at->format('H:i:s')}}</p>
                          @endif
                        <p>
                          @if(isset($engineersMessage->egnineers_internal_notes))
                            <p>{!!$engineersMessage->egnineers_internal_notes!!}</p>
                          @else
                            <p>{{$engineersMessage->events_internal_notes}}</p>
                          @endif
                        </div>

                        @if(isset($engineersMessage->egnineers_internal_notes))
                        @if($engineersMessage->engineers_attachement)
                            
                            <strong class="">Filename: </strong><span class="">{{$engineersMessage->engineers_attachement}}</span>
                            <a href="{{route('download', [$file->id,$engineersMessage->engineers_attachement])}}" class="btn-sm btn-info" style="float: right;">Download</a>
                        @endif
                        @else
                        @if($engineersMessage->events_attachement)
                            
                        <strong class="">Filename: </strong><span class="">{{$engineersMessage->events_attachement}}</span>
                        <a href="{{route('download', [$file->id,$engineersMessage->events_attachement])}}" class="btn-sm btn-info" style="float: right;">Download</a>
                        @endif
                        @endif
                      </div>
                    @endforeach
                      @endif
                    <div class="m-t-10">
                      <div class="card-header">
                        <div style="margin-bottom: 20px;">
                          <span style="">
                            <h4 style="margin-bottom: 10px;">Support Message</h4>
                            <strong></strong>
                            <p>
                              <i style="color: red;" class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                              <span style="color: darkgray;">You can send Message to Engineer. Engineers will be notified.</span>
                            </p>
                            <div class="row">
                              <div class="col-xl-12 col-lg-12 col-md-12">
                            <form method="POST" action="{{ route('file-engineers-notes') }}" enctype="multipart/form-data">
                              @csrf
                              <input type="hidden" name="file_id" value="{{$file->id}}">
      
                                <div class="form-group m-t-20">
                                  
                                  <textarea class="form-control" style="width: 100%; height: 100px;" id="car-info-memo" name="egnineers_internal_notes" class="materialize-textarea" placeholder="{{__('Support Message.')}}"></textarea>
                                  @error('egnineers_internal_notes')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputName1">Attachment</label>
                                <input type="file" name="engineers_attachement" class="form-control" id="engineers_attachement">
                                </div>
      
                                <button type="submit" class="btn btn-info"><i class="fa fa-submit"></i> Submit</button>
                              
                            </form>
                              </div>
                            </div>
                            
                          </span>
                        </div>
                      </div>
                    </div>
                  
                  </div>

                  
                </div>
              </div>
          </div>
          
          </div>
          
          @if(!$file->offers->isEmpty())
            @php $difference=0; 
            $creditsProposed = 0;
            @endphp
            <div class="main-file-box m-t-40">
              <span>
                <i class="fa fa-download top-box top-box-grey"></i>
              </span>
              <h3 style="display: inline; color: #021F7E; margin-left: 20px;">
                Proposed Stage and Option
              </h3>
              <div style="padding-left: 60px;" class="card-dt">
              <div class="card m-t-10">
                <div class="card-header">

                  <div style="margin-bottom: 20px;">
                    <span style="display: inline-grid;">
                      <h4 style="margin-bottom: 10px;">File Details:</h4>
                      <span>Engineer proposed following Stage and Options for this file Please confirm or Reject.</span>
                    </span>
                  </div>

              <span class="">
                      
                <span style="display: inline-grid;">
                  <strong>File Name:</strong>
                  <span>{{$file->file_attached}}</span>
                </span>
             
              </span>
              <div class="bt m-t-10 p-t-10">
                <span><strong>Proposed Stages and Options:</strong></span>
              </div>
              <div class="m-t-10" style="line-height: 2.7;">
                    @if($file->stage_offer)
                      @php 
                        
                        $stage = \ECUApp\SharedCode\Models\Service::FindOrFail( $file->stage_offer->service_id);
                      
                          $creditsProposed += $stage->credits;

                      @endphp
                      @if($stage)
                          <span class="show-stage">
                            <img style="width: 20px;" src="{{ get_logo_for_stages_and_options( $stage->name ) }}" alt="{{$stage->name}}">
                            {{ $stage->name }}
                          </span>
                      @endif
                    @endif
                    
                    @if(!$file->options_offer->isEmpty())
                      @foreach($file->options_offer as $option)
                        @php 
                            $op = \ECUApp\SharedCode\Models\Service::FindOrFail( $option->service_id ); 

                            $creditsProposed += $op->credits;
                            
                        @endphp
                        @if($op)
                        <span class="show-stage"><img style="width: 20px;" src="{{ get_logo_for_stages_and_options( $op->name ) }}" alt="{{$op->name}}">
                          {{ $op->name }}</span>
                        @endif
                      @endforeach
                    @endif

                    @php 
                      $difference = $file->credits - $creditsProposed;
                      
                    @endphp

                  </div>
                  <div class="bt m-t-20 p-t-10 text-center">
                    @if( $difference < 0 )

                      <span class="label label-danger">Credits to Pay: {{-1*$difference}}</span>
                    
                    @elseif($difference > 0)

                      <span class="label label-success">Credits to be saved: {{$difference}}</span>
                    @elseif($difference == 0)
                    
                      <span class="label label-success">Credits will remain same.</span>

                    @endif
                  </div>

                  <div class="bt m-t-20 p-t-10 text-center">
                    @if($difference >= 0)
                      <button type="submit" class="btn btn-info" id="btn-accept" data-file_id="{{$file->id}}"><i class="fa fa-check"></i> Accept Options</button>
                    @else
                      <a class="btn btn-info" href="{{route('pay-credits-offer', $file->id)}}"><i class="fa fa-check"></i> Pay Credits</a>
                    @endif
                    <button type="submit" class="btn btn-danger" id="btn-reject" data-file_id="{{$file->id}}><i class="fa fa-close"></i> Reject</button>
                  </div>

                </div>
              </div>
              </div>

            </div>

            @endif


            @if($file->status == 'rejected')
            <div class="main-file-box m-t-40">
              <span>
                <i class="fa fa-download top-box top-box-red"></i>
              </span>
              <h3 style="display: inline; color: #b01321; margin-left: 20px;">
                File Rejected
              </h3>

              <span style="float: right; margin-top: 20px;" class="d-label">
                <span class="label label-danger">Credits: {{$file->credits}}</span> 
                
              <div style="padding-left: 60px;" class="card-dt">
                <div class="card m-t-10">
                  <div class="card-header">
                    <div style="margin-bottom: 20px;">
                      <span style="display: inline-grid;">
                        <h4 style="margin-bottom: 10px;">Reason To Reject:</h4>
                        <span class="text-danger">{{$file->reason_to_reject}}</span>
                      </span>
                    
                    </div>

                    
                  </div>
                </div>
            </div>
            </div>
            @endif

            

            @foreach($file->files as $row)
            <div class="main-file-box m-t-40">
              <span>
                <i class="fa fa-upload top-box top-box-green"></i>
              </span>
              <h3 style="display: inline; color: #237E02; margin-left: 20px;">
                File Received
              </h3>
              <span style="float: right; margin-top: 15px;">{{ $row->created_at->format('d/m/Y')}} at {{$row->created_at->format('H:i:s')}}</span>
            
            <div style="padding-left: 60px;" class="card-dt">
            <div class="card m-t-10">

              <div class="card-header">
                <div style="margin-bottom: 20px;">
                  <span style="display: inline-grid;">
                    <h4 style="margin-bottom: 10px;">File Received:</h4>
                    <span>This file is uploaded by the engineer with following details.</span>
                  </span>
                </div>

                <span>
                  <span style="display: inline-grid;">
                    <strong>ECU File Name:</strong>
                    <span>{{$row->request_file}}</span>
                  </span>


                  @if($file->comments())

                  @if($file->showComments())

                    <button class="btn btn-info btn-download" data-make="{{$file->brand}}" data-engine="{{$file->engine}}" data-ecu="{{$file->ecu}}" data-model="{{$file->model}}" data-generation="{{$file->version}}" data-file_id="{{$file->id}}" data-path="{{route('download', [$row->file_id,$row->request_file])}}" style="float: right;"><i class="fa fa-download"></i> Downloand</button>
                  @else
                    <a class="btn btn-info" href="{{route('download', [$row->file_id,$row->request_file])}}" style="float: right;"><i class="fa fa-download"></i> Downloand</a>
                  @endif

                  @else
                    <a class="btn btn-info" href="{{route('download', [$row->file_id,$row->request_file])}}" style="float: right;"><i class="fa fa-download"></i> Downloand</a>
                  @endif

                </span>
                <div class="bt m-t-10 p-t-10">
                  <span><strong>Stages and Options:</strong></span>
                </div>
                <div class="m-t-10">
                  @if($file->stages_services)
                    @php $stage = \ECUApp\SharedCode\Models\Service::FindOrFail( $file->stages_services->service_id); @endphp
                    @if($stage)
                        <span class="show-stage"><img style="width: 20px;" src="{{ get_logo_for_stages_and_options( $stage->name ) }}" alt="{{$stage->name}}">
                          {{ $stage->name }}</span>
                    @endif
                  @endif
                  @if($file->options_services)
                    @foreach($file->options_services as $option)
                      @php 
                          $op = \ECUApp\SharedCode\Models\Service::FindOrFail( $option->service_id ); 
                      @endphp
                      @if($op)
                      <span class="show-stage"><img style="width: 20px;" src="{{ get_logo_for_stages_and_options( $op->name ) }}" alt="{{$stage->name}}">
                        {{ $op->name }}</span>
                      @endif
                    @endforeach
                  @endif
                </div>

                <div class="bt m-t-20 p-t-10">
                  <span><strong>Reading Tool:</strong></span>
                  <div class="m-t-10">
                    <span class="show-stage">
                      <img style="width: 20px;" src="{{ get_dropdown_image($file->tool_id) }}" class="tool-logo-small"> {{ ucfirst($file->tool_type) }}
                    </span>
                  </div>
                </div>
                
                {{-- @if(!$row->messages_and_logs()->isEmpty())
                <div class="bt m-t-20 text-center collapsible-ecu">
                  <h4 style="margin-top: 20px;"><i class="fa @if(Session::has('success')) fa-chevron-circle-down @else fa-chevron-circle-up @endif" id="arrow-message"></i> Support Messages</h4>
                </div>
                  <div class="bt m-t-20 p-t-10 red-scroll content-ecu" @if(Session::has('success')) style="display: block;" @endif>
                    @foreach($row->messages_and_logs() as $engineersMessage)
                      <div class="row bb-light" style="padding: 10px 30px 10px 30px;">
                        <div>
                          @if($engineersMessage->engineer)
                          <div>
                            <i style="font-size: 24px; color: #B01321;" class="fas fa-user-circle"></i>
                            <strong style="font-size: 18px;color: #B01321;">Engineer's Reply</strong>
                            <p style="float: right;">{{ $engineersMessage->created_at->format('d/m/Y')}} at {{$engineersMessage->created_at->format('H:i:s')}}</p>
                          </div>
                          @else
                            
                            <i style="font-size: 24px;" class="fas fa-user-circle"></i>
                            @if(isset($engineersMessage->egnineers_internal_notes))
                              <strong style="font-size: 18px;">Help Request</strong>  
                            @else
                              <strong style="font-size: 18px;">Log Entry</strong> 
                            @endif
                            <p style="float: right;">{{ $engineersMessage->created_at->format('d/m/Y')}} at {{$engineersMessage->created_at->format('H:i:s')}}</p>
                          @endif
                        <p>
                          @if(isset($engineersMessage->egnineers_internal_notes))
                            <p>{!!$engineersMessage->egnineers_internal_notes!!}</p>
                          @else
                            <p>{{$engineersMessage->events_internal_notes}}</p>
                          @endif
                        </div>

                        @if(isset($engineersMessage->egnineers_internal_notes))
                        @if($engineersMessage->engineers_attachement)
                            
                            <strong class="">Filename: </strong><span class="">{{$engineersMessage->engineers_attachement}}</span>
                            <a href="{{route('download', [$file->id,$engineersMessage->engineers_attachement])}}" class="btn-sm btn-info" style="float: right;">Download</a>
                        @endif
                        @else
                        @if($engineersMessage->events_attachement)
                            
                        <strong class="">Filename: </strong><span class="">{{$engineersMessage->events_attachement}}</span>
                        <a href="{{route('download', [$file->id,$engineersMessage->events_attachement])}}" class="btn-sm btn-info" style="float: right;">Download</a>
                        @endif
                        @endif
                      </div>
                    @endforeach
                    
                  </div>
                @endif
                 --}}

                <div class="m-t-20 bt">
                  <ul class="nav nav-tabs fl-nav" style="border-bottom: 0px; padding: 10px 0;">
                    {{-- <li  class="active">
                      <a style="border: none;" data-toggle="tab" href="#support-{{$row->id}}">
                        <button class="btn btn-white">
                          <i>
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABXElEQVR4nN2VO0sDQRSFdy0sFIyxtrINWIhYiFgr1oKIWFhraSfYmPwBEUH0J6iNWgmKWFj4FwRNAmkEn/EJfjJwhesyu3OzWogHtjl7zj0zc+cRRf8aQDswC2wDV8CTfFXhZpwmb/ER4JIwLoDhVouPAq+G4l94dh5r8S7gmtZRBzosAYvkx7wl4Mhj3Ac+DAEHloDbhGkTaAMmgXPgLSOgbgl4EfEG0G/Qx8CYeJqWgHcRhxsmALrVLGrAeOSDK6q2Z6dwFeARKCudj9OopgXsqH1dEu5BuHul83HfkBbQlP8lxZWl4EqAMwXsKc26V5SCRP1aVrPWZM+7Ne7JEXAHTITEuyJeTvAVOSdLHs+CeLYsoxlUzR7wNDcLU9Ypr4rBXce9qrlZt+yJ+X2Qx+ZMjA1gDijKWekDhkyFAiFF4DBltG754t8IiYFp4Bi4kbPiXrpToPDjgD+PT0xxfXWFo4ayAAAAAElFTkSuQmCC">
                          </i> Engineer Support
                        </button>
                      </a>
                    </li> --}}
                    <li class="active"><a style="border: none;" data-toggle="tab" href="#log-{{$row->id}}"><button class="btn btn-white"><i class="fa fa-file" style="transform: rotate(-90deg)"></i> Add Log</button></a></li>
                    <li><a style="border: none;" data-toggle="tab" href="#star-{{$row->id}}"><button class="btn btn-white"><i class="fa fa-star"></i> Add a Rating</button></a></li>
                    
                  </ul>
                  
                  <div class="tab-content">
                    {{-- <div id="support-{{$row->id}}" class="tab-pane fade active in">

                      <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                        <form method="POST" action="{{ route('file-engineers-notes') }}" enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" name="file_id" value="{{$file->id}}">
                          <input type="hidden" name="request_file_id" value="{{$row->id}}">
                            
                            <div class="form-group m-t-20">
                              <label for="exampleInputName1">Ask Engineer for Support</label>
                              <textarea class="form-control" style="width: 100%; height: 100px;" id="car-info-memo" name="egnineers_internal_notes" class="materialize-textarea" placeholder="{{__('Internal note for Engineers.')}}"></textarea>
                              @error('egnineers_internal_notes')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                            <div class="form-group">
                              <label for="exampleInputName1">Attachment</label>
                            <input type="file" name="engineers_attachement" class="form-control" id="engineers_attachement">
                            </div>

                            <button type="submit" class="btn btn-info"><i class="fa fa-submit"></i> Submit</button>
                          
                        </form>
                      </div>
                      </div>

                    </div> --}}
                    <div id="log-{{$row->id}}" class="tab-pane fade active in">

                      <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                        <form method="POST" action="{{ route('file-events-notes') }}" enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" name="file_id" value="{{$file->id}}">
                          <input type="hidden" name="request_file_id" value="{{$row->id}}">
                            
                            <div class="form-group m-t-20">
                              <label for="exampleInputName1">Attach log file and send to engineer.</label>
                              <textarea class="form-control" style="width: 100%; height: 100px;" id="car-info-memo" name="events_internal_notes" class="materialize-textarea" placeholder="{{__('Internal note for To save on timeline.')}}"></textarea>
                              @error('events_internal_notes')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                            <div class="form-group">
                              <label for="exampleInputName1">Attachment</label>
                            <input type="file" name="events_attachement" class="form-control" id="events_attachement">
                            </div>

                            <button type="submit" class="btn btn-info"><i class="fa fa-submit"></i> Submit</button>
                          
                        </form>
                      </div>
                      </div>


                    </div>
                    <div id="star-{{$row->id}}" class="tab-pane fade">

                      <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                          <ul class="feedback">
                            <li class="angry @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'angry' ) active @endif" data-type="angry" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                                <div>
                                    <svg class="eye left">
                                        <use xlink:href="#eye">
                                    </svg>
                                    <svg class="eye right">
                                        <use xlink:href="#eye">
                                    </svg>
                                    <svg class="mouth">
                                        <use xlink:href="#mouth">
                                    </svg>
                                </div>
                            </li>
                            <li class="sad @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'sad' ) active @endif" data-type="sad" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                                <div>
                                    <svg class="eye left">
                                        <use xlink:href="#eye">
                                    </svg>
                                    <svg class="eye right">
                                        <use xlink:href="#eye">
                                    </svg>
                                    <svg class="mouth">
                                        <use xlink:href="#mouth">
                                    </svg>
                                </div>
                            </li>
                            <li class="ok @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'ok' ) active @endif" data-type="ok" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                                <div></div>
                            </li>
                            <li class="good @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'good' ) active @endif" data-type="good" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                                <div>
                                    <svg class="eye left">
                                        <use xlink:href="#eye">
                                    </svg>
                                    <svg class="eye right">
                                        <use xlink:href="#eye">
                                    </svg>
                                    <svg class="mouth">
                                        <use xlink:href="#mouth">
                                    </svg>
                                </div>
                            </li>
                            <li class="happy @if( isset($row->file_feedback->type) && $row->file_feedback->type == 'happy' ) active @endif" data-type="happy" data-file_id="{{$file->id}}" data-request_file_id="{{$row->id}}">
                                <div>
                                    <svg class="eye left">
                                        <use xlink:href="#eye">
                                    </svg>
                                    <svg class="eye right">
                                        <use xlink:href="#eye">
                                    </svg>
                                </div>
                            </li>
                        </ul>
        
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 4" id="eye">
                                <path d="M1,1 C1.83333333,2.16666667 2.66666667,2.75 3.5,2.75 C4.33333333,2.75 5.16666667,2.16666667 6,1"></path>
                            </symbol>
                            <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 7" id="mouth">
                                <path d="M1,5.5 C3.66666667,2.5 6.33333333,1 9,1 C11.6666667,1 14.3333333,2.5 17,5.5"></path>
                            </symbol>
                        </svg>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

              </div>
              
            </div>
            </div>
          </div>
          @endforeach

          @endforeach
          
          </div>
          
          <div class="col-xl-6 col-lg-6 col-md-6 m-t-40">
            <div class="card single-item">
              <div class="card-header">
                
              </div>
              <div class="">

                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#car-details">Car Details</a></li>
                  <li><a data-toggle="tab" href="#contact-details">Contact Details</a></li>
                  <li><a data-toggle="tab" href="#personal-notes">Personal Notes</a></li>
                  
                </ul>
                
                <div class="tab-content">
                  <div id="car-details" class="tab-pane fade in active">

                    <div class="details-box">
                      <table style="background: transparent;">
                        <tbody>
                          <tr >
                            <td style="width: 40%; padding-bottom: 10px;">
                              <strong>*Brand Group:</strong>
                              <img alt="" class="" style="width: 10%;" src="{{ get_image_from_brand($file->brand) }}">
                            </td>
                            <td style="width: 40%; padding-bottom: 10px;">
                              <strong>Brand Name:</strong>
                              <span>{{$file->brand}}</span>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 40%; padding-bottom: 15px;">
                              <strong>Model:</strong>
                              <span>{{$file->model}}</span>
                            </td>
                            <td style="width: 40%; padding-bottom: 15px;">
                              <strong>Engine:</strong>
                              <span>{{$file->engine}}</span>
                            </td>
                          </tr>
                          <tr>
                            <td style="width: 40%; padding-bottom: 10px;">
                              <strong>ECU:</strong>
                              <span>{{$file->ecu}}</span>
                            </td>
                            <td style="width: 40%; padding-bottom: 10px;">
                              <strong>Gear Box:</strong>
                              <span>{{ucfirst(str_replace("_"," ",$file->gear_box))}}</span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <div class="row" style="padding-top: 10px;">

                    <form method="POST" action="{{route('edit-milage')}}">
                      @csrf
                      <input type="hidden" name="id" value="{{$file->id}}">
                      <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                          <label for="exampleInputName1">Vin</label>
                          <input type="text" value="{{$file->vin_number}}" class="form-control @error('vin_number') is-invalid @enderror" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Name" name="vin_number">
                          @error('vin_number')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                          <label for="exampleInputName1">Plate</label>
                          <input type="text" value="{{$file->license_plate}}" class="form-control @error('license_plate') is-invalid @enderror" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Name" name="license_plate">
                          @error('license_plate')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                          <label for="exampleInputName1">Fuel</label>
                          <input type="text" value="{{ $vehicle->Type_of_fuel }}" disabled class="form-control" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Name" name="type_of_fuel">
                          @error('type_of_fuel')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                          <label for="exampleInputName1">First Registration Number</label>
                          <input type="text" value="{{$file->first_registration}}" class="form-control @error('first_registration') is-invalid @enderror" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter First Reegistration Number" name="first_registration">
                          @error('first_registration')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                      </div>
                      <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="form-group">
                          <label for="exampleInputName1">Milage</label>
                          <input type="number" value="{{$file->kilometrage}}" class="form-control @error('kilometrage') is-invalid @enderror" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Milage" name="kilometrage">
                          @error('kilometrage')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                      </div>
                      
                      <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="form-group">
                          <label for="exampleInputName1">Internal Note</label>
                          <textarea class="form-control @error('vehicle_internal_notes') is-invalid @enderror" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Note" name="vehicle_internal_notes">{{$file->vehicle_internal_notes}}</textarea>
                          @error('vehicle_internal_notes')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>

                      <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Save Changes</button>
                      </div>
                    </form>
                    </div>

                  </div>
                  <div id="contact-details" class="tab-pane fade">

                    <div style="margin-top: 20px;">

                    <form method="POST" action="{{route('add-customer-note')}}">

                      @csrf
                      <input type="hidden" name="id" value="{{$file->id}}">

                      <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                          <label for="exampleInputName1">Customer Name</label>
                          <input type="text" value="{{$file->name}}" class="form-control @error('vin_number') is-invalid @enderror" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Name" name="name">
                          @error('name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                          <label for="exampleInputName1">Email</label>
                          <input type="text" value="{{$file->email}}" class="form-control @error('email') is-invalid @enderror" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Email" name="email">
                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                      </div>
                      <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="form-group">
                          <label for="exampleInputName1">Phone</label>
                          <input type="text" value="{{$file->phone}}" class="form-control @error('phone') is-invalid @enderror" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Phone" name="phone">
                          @error('phone')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                      </div>
                      <button type="submit" class="btn btn-info m-l-20" style="margin-bottom:10px"><i class="fa fa-save"></i> Save Changes</button>
                    </form>

                    </div>

                  </div>
                  <div id="personal-notes" class="tab-pane fade">
                    <div>
                    <div class="bt m-t-20 p-t-10 red-scroll" @if(Session::has('success')) style="display: block;" @endif>
                      @if(!$file->file_urls->isEmpty())
                      @foreach($file->file_urls as $fileUrl)
                        <div class="row bb-light" style="padding: 10px 30px 10px 30px; margin-left: 1px; margin-right: 1px;">
                          <div>
                              <i style="font-size: 24px;" class="fas fa-user-circle"></i>
                              <strong style="font-size: 18px;">Personal Message</strong>
                              <p style="float: right;">{{ $fileUrl->created_at->format('d/m/Y')}} at {{$fileUrl->created_at->format('H:i:s')}}</p>
                              <p>{{$fileUrl->file_url}}</p>
                          </div>
                          @if(isset($fileUrl->file_url_attachment))
                              <strong class="">Filename: </strong><span class="">{{$fileUrl->file_url_attachment}}</span>
                              <a href="{{route('download', [$file->id,$fileUrl->file_url_attachment])}}" class="btn-sm btn-info" style="float: right;">Download</a>
                          @endif
                        </div>
                      @endforeach
                      @endif
                    </div>
                  </div>
                  </div>
                </div>
              </div>
              
              <div class="card-footer">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="commentsPopup" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <img class="modal-loading" src="https://i.gifer.com/VAyR.gif" width="10%;">
                </div>
                <div>
                    <h3 class="modal-information">{{__('Important Information')}}</h3>
                    <div class="modal-comments">{{__('Please click on Confirm button to download the file.')}}</div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="#" @disabled(true) class="btn btn-success download-path-original modal-confirm" style="">{{__('Confirm')}}</a>
                <button @disabled(true) type="button" class="btn btn-white close-modal m-t-10" style="width: 100%; margin-left:0px;">{{__('Cancel')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagespecificscripts')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">

    $( document ).ready(function(event) {

      $(document).on('click', '#btn-accept', function(e) {

        let file_id = $(this).data('file_id');

        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
            buttonsStyling: false
          });

          swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You accept the options provided by Engineer?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Accpet it!',
            cancelButtonText: 'No, cancel!',
                reverseButtons: false
              }).then((result) => {
                if (result.isConfirmed) {

                console.log(file_id);

                $.ajax({
                    url: "/accept_offer",
                    type: "POST",
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'file_id': file_id,
                    },
                    success: function(d) {
                        console.log(d);
                        location.reload();
                    }
                  });
                
                } else if ( result.dismiss === Swal.DismissReason.cancel ) {

                  swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Uploaded file is safe :)',
                    'error'
                  );

                }
              });

      });

      $(document).on('click', '#btn-reject', function(e) {

        let file_id = $(this).data('file_id');

        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
            buttonsStyling: false
          });

          swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You Reject the options provided by Engineer?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Reject it!',
            cancelButtonText: 'No, cancel!',
                reverseButtons: false
              }).then((result) => {
                if (result.isConfirmed) {

                console.log(file_id);

                $.ajax({
                    url: "/reject_offer",
                    type: "POST",
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'file_id': file_id,
                    },
                    success: function(d) {
                        console.log(d);
                        location.reload();
                    }
                  });
                
                } else if ( result.dismiss === Swal.DismissReason.cancel ) {

                  swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Uploaded file is safe :)',
                    'error'
                  );

                }
              });

      });

      $(document).on('click', '.btn-download', function() {

      $('#commentsPopup').modal('show');
      $('.modal-content').css('visibility', 'visible');

      setTimeout(
          function() {
              $('.close-modal').attr("disabled", false);
              $('.modal-confirm').attr("disabled", false);
      }, 5000);

      $('.modal-loading').css("display", "none");
      $('.modal-confirm').css("display", "block");

      let ecu = $(this).data('ecu');
      let make = $(this).data('make');
      let generation = $(this).data('generation');
      let engine = $(this).data('engine');
      let file_id = $(this).data('file_id');
      let model = $(this).data('model');

      $('.download-path-original').attr("href", $(this).data('path'));

        $.ajax({
            url: "/get_comments",
            type: "POST",
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'make': make,
                'model': model,
                'generation': generation,
                'ecu': ecu,
                'engine': engine,
                'file_id': file_id
            },
            success: function(d) {
                console.log(d);
                if (d.comments !== '') {
                    console.log(d.comments);
                    $('.modal-comments').html(d.comments);
                    $('.modal-loading').css("display", "none");
                    $('.modal-confirm').css("display", "block");
                } else {
                    $('.modal-loading').css("display", "none");
                    $('.modal-information').css("display", "none");
                    $('.modal-comments').css("display", "block");
                    $('.modal-confirm').css("display", "block");
                }

            }
            });

    });

    $('.file_type').click(function(e) {
            if ($(this).is(':checked')) {
                let file_type = $(this).val();

                if (file_type == 'ecu_file') {
                    console.log($('#ecu_file_select').next().next());
                    // $('#ecu_file_select').next().next().css("display", "block");
                    // $('#gearbox_file_select').next().next().css("display", "none");
                    $('#ecu_file_select').removeClass('hide');
                    $('#gearbox_file_select').addClass('hide');
                } else if (file_type == 'gearbox_file') {
                    $('#ecu_file_select').addClass('hide');
                    $('#gearbox_file_select').removeClass('hide');

                    // $('#gearbox_file_select').next().next().css("display", "block");
                    // $('#ecu_file_select').next().next().css("display", "none");
                }
            }
        });

    $(document).on('click', '.close-modal', function() {

      $('#commentsPopup').modal('hide');
    });

    $(document).on('click', '.modal-confirm', function() {

    $('#commentsPopup').modal('hide');
    });

    $(document).on('click', '#new-request', function() {

        $('#new-request-box').removeClass('hide');
        $(this).removeClass('btn-white');
        $(this).addClass('btn-grey');

        $('#note-box').addClass('hide');
        $('#note-button').removeClass('btn-grey');
        $('#note-button').addClass('btn-white');

        $('#acm-file-box').addClass('hide');
      $('#acm-file').removeClass('btn-grey');
      $('#acm-file').addClass('btn-white');
      
    });

    

    $(document).on('click', '#acm-file', function() {

      $('#acm-file-box').removeClass('hide');
      $(this).removeClass('btn-white');
      $(this).addClass('btn-grey');

      $('#note-box').addClass('hide');
      $('#note-button').removeClass('btn-grey');
      $('#note-button').addClass('btn-white');

      $('#new-request-box').addClass('hide');
      $('#new-request').removeClass('btn-grey');
      $('#new-request').addClass('btn-white');

    });

    

    $(document).on('click', '#new-request', function() {

      $('#new-request-box').removeClass('hide');
      $(this).removeClass('btn-white');
      $(this).addClass('btn-grey');

      $('#note-box').addClass('hide');
      $('#note-button').removeClass('btn-grey');
      $('#note-button').addClass('btn-white');

      $('#acm-file-box').addClass('hide');
      $('#acm-file').removeClass('btn-grey');
      $('#acm-file').addClass('btn-white');

    });

      $(document).on('click', '#note-button', function() {
        $('#note-box').removeClass('hide');
        $(this).removeClass('btn-white');
        $(this).addClass('btn-grey');

        $('#new-request-box').addClass('hide');
        $('#new-request').removeClass('btn-grey');
        $('#new-request').addClass('btn-white');

        $('#acm-file-box').addClass('hide');
      $('#acm-file').removeClass('btn-grey');
      $('#acm-file').addClass('btn-white');
      
      });
      
      $(document).on('click', '.feedback li', function() {
            
            $('.feedback li').removeClass('active');
            $(this).addClass('active');
            let type = $(this).data('type');
            let file_id = $(this).data('file_id');
            let request_file_id = $(this).data('request_file_id');

            $.ajax({
                url: "/file_feedback",
                type: "POST",
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'file_id': file_id,
                    'type': type,
                    'request_file_id': request_file_id
                },
                success: function(d) {
                    swal('Your feedback is recored!');
                }
            });

        });

    var coll = document.getElementsByClassName("collapsible-ecu");
    var i;

    for (i = 0; i < coll.length; i++) {
      coll[i].addEventListener("click", function() {
        this.classList.toggle("active-ecu");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
          $(content).hide(500);
          $('#arrow-message').removeClass('fa-chevron-circle-down');
          $('#arrow-message').addClass('fa-chevron-circle-up');
        } else {
          $(content).show(500);
          $('#arrow-message').removeClass('fa-chevron-circle-up');
          $('#arrow-message').addClass('fa-chevron-circle-down');
        }
      });
    }

    });

</script>

@endsection