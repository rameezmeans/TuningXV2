@extends('layouts.app')
@section('pagespecificstyles')

<style>

        /* 
  You want a simple and fancy tooltip?
  Just copy all [data-tooltip] blocks:
*/
[data-tooltip] {
  --arrow-size: 5px;
  position: relative;
  z-index: 10;
}

.stage-img-box {
    width: 23% !important;
    min-width:85px;
}

/* Positioning and visibility settings of the tooltip */
[data-tooltip]:before,
[data-tooltip]:after {
  position: absolute;
  visibility: hidden;
  opacity: 0;
  left: 50%;
  bottom: calc(100% + var(--arrow-size));
  pointer-events: none;
  transition: 0.2s;
  will-change: transform;
}

/* The actual tooltip with a dynamic width */
[data-tooltip]:before {
  content: attr(data-tooltip);
  padding: 10px 18px;
  min-width: 50px;
  max-width: 300px;
  width: max-content;
  width: -moz-max-content;
  border-radius: 6px;
  font-size: 14px;
  background-color: black;
  background-image: linear-gradient(30deg,
    rgba(59, 72, 80, 0.44),
    rgba(59, 68, 75, 0.44),
    rgba(60, 82, 88, 0.44));
  box-shadow: 0px 0px 24px rgba(0, 0, 0, 0.2);
  color: #fff;
  text-align: center;
  white-space: pre-wrap;
  transform: translate(-50%,  calc(0px - var(--arrow-size))) scale(0.5);
}

/* Tooltip arrow */
[data-tooltip]:after {
  content: '';
  border-style: solid;
  border-width: var(--arrow-size) var(--arrow-size) 0px var(--arrow-size); /* CSS triangle */
  border-color: rgba(55, 64, 70, 0.9) transparent transparent transparent;
  transition-duration: 0s; /* If the mouse leaves the element, 
                              the transition effects for the 
                              tooltip arrow are "turned off" */
  transform-origin: top;   /* Orientation setting for the
                              slide-down effect */
  transform: translateX(-50%) scaleY(0);
}

/* Tooltip becomes visible at hover */
[data-tooltip]:hover:before,
[data-tooltip]:hover:after {
  visibility: visible;
  opacity: 1;
}
/* Scales from 0.5 to 1 -> grow effect */
[data-tooltip]:hover:before {
  transition-delay: 0.3s;
  transform: translate(-50%, calc(0px - var(--arrow-size))) scale(1);
}
/* 
  Arrow slide down effect only on mouseenter (NOT on mouseleave)
*/
[data-tooltip]:hover:after {
  transition-delay: 0.5s; /* Starting after the grow effect */
  transition-duration: 0.2s;
  transform: translateX(-50%) scaleY(1);
}
/*
  That's it for the basic tooltip.

  If you want some adjustability
  here are some orientation settings you can use:
*/

/* LEFT */
/* Tooltip + arrow */
[data-tooltip-location="left"]:before,
[data-tooltip-location="left"]:after {
  left: auto;
  right: calc(100% + var(--arrow-size));
  bottom: 50%;
}

.btn-transparent {
   padding: 5px 5px 5px 5px;;
}

/* Tooltip */
[data-tooltip-location="left"]:before {
  transform: translate(calc(0px - var(--arrow-size)), 50%) scale(0.5);
}
[data-tooltip-location="left"]:hover:before {
  transform: translate(calc(0px - var(--arrow-size)), 50%) scale(1);
}

/* Arrow */
[data-tooltip-location="left"]:after {
  border-width: var(--arrow-size) 0px var(--arrow-size) var(--arrow-size);
  border-color: transparent transparent transparent rgba(55, 64, 70, 0.9);
  transform-origin: left;
  transform: translateY(50%) scaleX(0);
}
[data-tooltip-location="left"]:hover:after {
  transform: translateY(50%) scaleX(1);
}



/* RIGHT */
[data-tooltip-location="right"]:before,
[data-tooltip-location="right"]:after {
  left: calc(100% + var(--arrow-size));
  bottom: 50%;
}

[data-tooltip-location="right"]:before {
  transform: translate(var(--arrow-size), 50%) scale(0.5);
}
[data-tooltip-location="right"]:hover:before {
  transform: translate(var(--arrow-size), 50%) scale(1);
}

[data-tooltip-location="right"]:after {
  border-width: var(--arrow-size) var(--arrow-size) var(--arrow-size) 0px;
  border-color: transparent rgba(55, 64, 70, 0.9) transparent transparent;
  transform-origin: right;
  transform: translateY(50%) scaleX(0);
}
[data-tooltip-location="right"]:hover:after {
  transform: translateY(50%) scaleX(1);
}



/* BOTTOM */
[data-tooltip-location="bottom"]:before,
[data-tooltip-location="bottom"]:after {
  top: calc(100% + var(--arrow-size));
  bottom: auto;
}

[data-tooltip-location="bottom"]:before {
  transform: translate(-50%, var(--arrow-size)) scale(0.5);
}
[data-tooltip-location="bottom"]:hover:before {
  transform: translate(-50%, var(--arrow-size)) scale(1);
}

[data-tooltip-location="bottom"]:after {
  border-width: 0px var(--arrow-size) var(--arrow-size) var(--arrow-size);
  border-color: transparent transparent rgba(55, 64, 70, 0.9) transparent;
  transform-origin: bottom;
}

strong {
  display: inline-block;
    white-space: nowrap;
    overflow: hidden !important;
    text-overflow: ellipsis;
}

.all-stages-box{
    width: 100%;
    height: 112px;
    background: #1E293B 0% 0% no-repeat padding-box;
    border-radius: 6px;
    opacity: 1;
    padding: 20px;
    position:relative;
}

.all-stages-box img{
    position: absolute;
    max-width: 100px;
    right: 20px;
}

#rows-for-credits {
    overflow-y: auto;
    max-height: 300px;
    width: 100%;
    height: auto;
    background: #FFFFFF 0% 0% no-repeat padding-box;
    border: 1px solid #E2E8F0;
    border-radius: 6px 6px 0px 0px;
    opacity: 1;
}

p.tuning-resume > small {
    float: right;
}

p.tuning-resume {
    margin: 0px;
    padding: 15px;
    border-bottom: 1px #ddd solid; 
}

.total-box {
    width: 100%;
    height: 78px;
    background: #94A3B8 0% 0% no-repeat padding-box;
    border-radius: 0px 0px 6px 6px;
    opacity: 1;
    padding: 20px;
}

#without-discount-total-credits{
    font-size: 16px;
}

#total-credits{
    font-size: 16px;
}

.stage-option-container{
    height: 76px !important;
}

.stage-option-container .stage-img-box input[type=checkbox],
.stage-option-container .stage-img-box input[type=radio]{
    width: 20px;
    height: 20px;
    margin-right: 9px;
    margin-top: 0;
} 

.stage-option-container .stage-img-box img{
    width: 100%;
    height: auto;
    max-width: 35px;
    margin-right: 5px;
    margin-top: 1px;
}

.stage-option-container .text-stage{
    font-size:16px !important;
    padding:16px !important;
}

.stage-option-container .text-stage button{
    position: absolute;
    right: 22px;
}

.stage-option-container .text-stage button i{
    display: inline-block;
    vertical-align: middle;
}

@media only screen and (max-width: 1439px) {
    .stage-option-container .text-stage {
        font-size: 12px !important;
        padding: 25px 10px 16px !important;
    }
    .stage-option-container .text-stage button {
        right: 5px;
        top:22px;
    }
    .stage-option-container .stage-img-box input[type=checkbox],
    .stage-option-container .stage-img-box input[type=radio] {
        width: 15px;
        height: 15px;
    }
    .stage-option-container .stage-img-box img{
        max-width:25px;
    }
    .all-stages-box .stages-top-box{
        max-width:60% !important;
    }
    .all-stages-box img {
        max-width: 80px;
        right: 20px;
        top: 40px;
    }
}

@media only screen and (max-width: 1780px) {
    .text-stage button i{
        font-size: 15px !important;
    }
    .text-stage button{
        font-size: 13px !important;
        top: 40px !important;
    }
}

.loader {
  border: 16px solid transparent; /* Light grey */
  border-top: 16px solid #b01321; /* Blue */
  border-radius: 50%;
  width: 60px;
  height: 60px;
  margin-bottom: 20px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
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
            <div class="bb-light fix-header">
            <div class="header-block header-block-w-p">
                <h1>Services</h1>
                <p>3/4</p>
        </div>
        </div>
        <div class="i-content-block price-level">

        <form method="POST" action="{{ route('post-stages') }}"  enctype="application/x-www-form-urlencoded" name="file_upload_tuning" id="file-upload-tuning-form" autocomplete="off">
            <input type="hidden" value="{{ $file->id }}" name="file_id" id="file_id">
            <input type="hidden" id="file_tool_type" value="{{$file->tool_type}}">
            @csrf

             <div class="row post-row">
                <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
                    <div class="heading-column-box">  
                        <h3>Tuning</h3>
                        <p>These are tuning stages.</p>
                    </div>
              </div>

              <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="row">
                    @php $count = 1; @endphp
                  @foreach ($stages as $stage)
                    <div class="col-xl-12 col-lg-12 col-md-12">
                      <div class="stage-option-container">
                        <span class="bl stage-img-box">
                            <input @if($count == 1) checked @endif name="stage" class="with-gap" type="radio" id="tuning-{{$stage['id']}}" value="{{$stage['id']}}" data-name="{{$stage['name']}}" data-price="@if($file->tool_type == 'master'){{$stage['tuningx_credits']}}@else{{$stage['tuningx_slave_credits']}}@endif">
                            <img width="50%" src="{{'https://backend.ecutech.gr/icons/'.$stage['icon']}}" alt="{{$stage['name']}}">
                        </span>
                        <span class="text-stage">

                          <span style="display: inline-grid;">
                            <strong>{{$stage['name']}}</strong>
                            @if($file->tool_type == 'master')
                              <span class="text-danger"> {{$stage['tuningx_credits']}} Credits </span>
                            @else
                              <span class="text-danger"> {{$stage['tuningx_slave_credits']}} Credits </span>
                            @endif
                          </span>

                          <button type="button" data-tooltip-location="left" data-tooltip="{{__(trim($stage['description']))}}"  class="btn btn-transparent" style="font-size: 16px;"><i style="font-size: 18px;" class="fa fa-info-circle"></i> Info</button>
                          
                        </span>
                      </div>
                    </div>
                    @php $count++; @endphp
                  @endforeach
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="all-stages-box">
                    <span style="display: inline-grid;" class="stages-top-box">
                        <strong style="color: white;">{{$file->vehicle()->Make}}</strong>
                        <span style="color: white;">{{$file->vehicle()->Model}} - {{$file->vehicle()->Generation}} - {{$file->vehicle()->Engine}}</span>
                    </span>
                    <img src="@if($file->vehicle()){{ $file->vehicle()->Brand_image_URL }} @else {{ env('BACKEND_URL').'/icons/logos/logo_white.png' }} @endif" alt="logo">
                </div>
                
                <div id="rows-for-credits" class="red-scroll" style="">
                </div>
                <div class="total-box">
                    <span style="font-size: 16px;">Total</span>
                    <span style="float: right;" >
                        <small>
                            <span id="without-discount-total-credits" class="hide" style="color: gray;text-decoration: line-through;"></span>
                            
                            <span id="total-credits">@if($file->tool_type == 'master'){{$firstStage->tuningx_credits}}@else{{$firstStage->tuningx_slave_credits}}@endif
                            </span> credits
                        </small>
                    </span>
                    
                </div>
                <input type="hidden" id="total_credits_to_submit" name="total_credits_to_submit" value="@if($file->tool_type == 'master'){{$firstStage->tuningx_credits}}@else{{$firstStage->tuningx_slave_credits}}@endif">
                <div class="text-center">
                    <button class="btn btn-red m-t-10" type="submit" id="btn-final-submit">
                      <i class="fa fa-arrow-right"></i> Go to Checkout
                      </button>
                    </div>
              </div>
             
            </div>

            <div class="row post-row">
              <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
                <div class="heading-column-box">
                  <h3>Options</h3>
                  <p>These are tuning options.</p>
                </div>
              </div>

              <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="loader hide"></div>
                <label class="account-label">Options</label>
                <div class="row">
                  @foreach ($options as $option)
                    <div class="col-xl-12 col-lg-12 col-md-12">
                      <div class="stage-option-container">
                        <span class="bl stage-img-box">
                          @php $record = \ECUApp\SharedCode\Models\Service::findOrFail($option['id'])->optios_stage(1)->first(); @endphp
                          @if($file->tool_type == 'slave')
                            <input type="checkbox" class="options-checkbox option-credits-{{$option['id']}}" id="{{ str_replace(' ','_', strtolower( $option['name'] ) )}}" name="options[]" value="{{$option['id']}}" data-name="{{$option['name']}}" data-code="{{$option['name']}}" 
                            data-price="@if($record){{$record->slave_credits}}@else Problem @endif" 
                            data-default-price="@if($record){{$record->slave_credits}}@else Problem @endif"
                            >
                          @elseif($file->tool_type == 'master')
                            <input type="checkbox" class="options-checkbox option-credits-{{$option['id']}}" id="{{ str_replace(' ','_', strtolower( $option['name'] ) )}}" name="options[]" value="{{$option['id']}}" data-name="{{$option['name']}}" data-code="{{$option['name']}}" 
                            data-price="@if($record){{$record->master_credits}}@else Problem @endif" 
                            data-default-price="@if($record){{$record->master_credits}}@else Problem @endif">
                          @endif
                            <img width="50%" src="{{'https://backend.ecutech.gr/icons/'.$option['icon']}}" alt="{{$option['name']}}">
                        </span>
                        <span class="text-stage">

                          <span style="display: inline-grid;">
                            <strong>{{$option['name']}}</strong>
                            
                            @if($file->tool_type == 'slave')
                              <span class="text-danger"> <span id="option-credits-{{$option['id']}}">@if($record){{$record->slave_credits}}@else Problem @endif</span> Credits </span>
                            @elseif($file->tool_type == 'master')
                              <span class="text-danger"> <span id="option-credits-{{$option['id']}}">@if($record){{$record->master_credits}}@else Problem @endif</span> Credits </span>
                            @endif
                          </span>

                          <button type="button" data-tooltip-location="left" data-tooltip="{{__(trim($option['description']))}}"  class="btn btn-transparent" style="font-size: 16px; float: right;"><i style="font-size: 18px;" class="fa fa-info-circle"></i> Info</button>
                          
                          

                        </span>
                        
                      </div>

                      @if($option['customers_comments_active'] == 1)
                        @if($option['customers_comments_vehicle_type'] == NULL)
                          <div class="comments-area-{{$option['id']}} hide">
                                <div class="col-xl-12 col-md-12 " style="padding: 5px;">
                                    <textarea placeholder="{{$option['customers_comments_placeholder_text']}}" name="option_comments[{{$option['id']}}]" style="background: white;  height:100%; width:100%;"></textarea>
                                </div>
                          </div>
                          @else

                            @if(in_array($file->vehicle()->type,explode(',',$option['customers_comments_vehicle_type'])))
                              <div class="comments-area-{{$option['id']}} hide">
                                <div class="col-xl-12 col-md-12 " style="padding: 5px;">
                                    <textarea placeholder="{{$option['customers_comments_placeholder_text']}}" name="option_comments[{{$option['id']}}]" style="background: white;  height:100%; width:100%;"></textarea>
                                </div>
                              </div>
                            @endif
                          @endif
                      @endif

                        
                        {{-- @elseif($option['name'] == 'Vmax OFF')
                            
                              @if($file->vehicle()->type == 'agri')
                              <div class="stage-option-container vmax-off-textarea hide" >
                                  <div class="col-xl-12 col-md-12 " style="padding: 5px;">
                                      <textarea name="vmax_off_comments" style="background: white;height:100%; width:100%;"></textarea>
                                  </div>
                              </div>
                          @endif --}}
                        {{-- @endif --}}
  
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
        </form>
        </div>
        </div>
    </div>
</div>
@endsection

@section('pagespecificscripts')

<script type="text/javascript">

    var valuesArray = null; 

    var file_type = '{{$file->tool_type}}';

    Array.prototype.removeByValue = function (val) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] === val) {
        this.splice(i, 1);
        i--;
        }
    }
    return this;
    }

    // function get_combination(service_ids){
    //     let discount = 0;
    //     $.ajax({
    //                 url: 'get_combination',
    //                 data: {
    //                     service_ids: service_ids,
    //                 },
    //                 async: false,
    //                 type: "POST",
    //                 headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
    //                 success: function(response) {

    //                     let res = JSON.parse(response);

    //                     console.log(res);

    //                     if(res.found == true){
                            
    //                         discount = res.combination.actual_credits - res.combination.discounted_credits;
    //                     }
    //                     else{
    //                         discount = 0;
    //                     }
    //                 }
    //             });
    //             return discount;
    // };

    $(document).ready(function(){

      let stage_id = 1;

      $.ajax({
                  url: 'get_options_for_stage',
                  data: {
                      stage_id: stage_id,
                  },
                  async: false,
                  type: "POST",
                  headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                  success: function(options) {
                        
                        valuesArray = jQuery.parseJSON(options);

                        jQuery.each( valuesArray , function(i,v){

                        if(file_type == 'slave'){
                          jQuery('#option-credits-'+v.option_id).html(v.slave_credits);
                          jQuery('.option-credits-'+v.option_id).attr('data-price', v.slave_credits);
                          jQuery('.option-credits-'+v.option_id).attr('data-default-price', v.slave_credits);
                        }
                        else if(file_type == 'master'){
                          jQuery('#option-credits-'+v.option_id).html(v.master_credits);
                          jQuery('.option-credits-'+v.option_id).data('price', v.master_credits);
                          jQuery('.option-credits-'+v.option_id).attr('data-default-price', v.master_credits);
                        }

                        });

                  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) { 

                  } 
              });

      $("#tuning-1").prop("checked", true);
        
        let firstStageName = '{{$firstStage->name}}';
        
        let firstStageID = '{{$firstStage->id}}';
        let service_ids = [firstStageID];

        let value = 0;

        if(file_type == 'master'){
          value = parseInt('{{$firstStage->tuningx_credits}}');
        }
        else if(file_type == 'slave'){
          value = '{{$firstStage->tuningx_slave_credits}}';
        }

        let checkbox_credits_count = 0;

        let stage_0_credits = 0;

        if(file_type == 'master'){
          stage_0_credits = '{{$firstStage->tuningx_credits}}';
        }
        else if(file_type == 'slave'){
          stage_0_credits = '{{$firstStage->tuningx_slave_credits}}';
        }

        let stages_str = '<div class="bb-light"></div><p class="tuning-resume">'+firstStageName+' <small>'+stage_0_credits+' credits</small></p>';
        $('#rows-for-credits').html(stages_str);

      $(document).on('change', '.options-checkbox', function(){
          
          let get_upload_comments_url = '{{route('get-upload-comments')}}';
          let checked = $(this).is(':checked');

          let locale = '{{Session::get('locale') }}';

          let file_id = $('#file_id').val();
              let service_id = $(this).val();

          if(checked){

              // let file_id = $('#file_id').val();
              // let service_id = $(this).val();

              $('.comments-area-'+service_id).removeClass('hide');

              $('#btn-final-submit').attr("disabled", true);

              $.ajax({
                  url: get_upload_comments_url,
                  data: {
                      service_id: service_id,
                      file_id: file_id,
                      locale, locale
                  },
                  type: "POST",
                  headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                  success: function(response) {

                      $('#btn-final-submit').attr("disabled", false); 
                      
                      let note = '{{__('Please Read Very Carefully')}}!!';

                      console.log(response.comment.comments);
                      let comment = response.comment.comments

                      if(comment != undefined){

                          Swal.fire(
                              note,
                              comment,
                              'warning'
                              );

                          $('.swal2-confirm').attr("disabled", true);

                          setTimeout(
                              function() {
                                  $('.swal2-confirm').attr("disabled", false);
                          }, 5000);
                      }
                      else{
                          console.log('no comments found');
                      }
                      
                  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) { 

                      $('#btn-final-submit').attr("disabled", false);
                      console.log("Status: " + textStatus); 
                      console.log("Error: " + errorThrown); 
                  } 
              });
          }
          else{

            $('.comments-area-'+service_id).addClass('hide');
          }
      });

      // $(document).on('change', '#dtc_off', function(){

      //     console.log("dtc_off changed");

      //     let checked = $('#dtc_off').is(':checked');
      //     if(checked){
      //         $('.dtc-off-textarea').removeClass('hide');
      //     }
      //     else{
      //         $('.dtc-off-textarea').addClass('hide');
      //     }

      // });


      $(document).on('change', '#vmax_off', function(){

      console.log("vmax_off changed");

      let checked = $('#vmax_off').is(':checked');
      if(checked){
          $('.vmax-off-textarea').removeClass('hide');
      }
      else{
          $('.vmax-off-textarea').addClass('hide');
      }

      });

      $(document).on('change', '.with-gap', function(){

          service_ids = [];
          service_ids.push($(this).val());
          $(".options-checkbox").prop('checked', false);
          $('.dtc-off-textarea').addClass('hide');
          $('.vmax-off-textarea').addClass('hide');
          $('#without-discount-total-credits').removeClass('hide');

          // console.log($('.loader').removeClass('hide'));
          
          if ($(this).is(':checked')) {

              $('.loader').removeClass('hide');
              let name = $(this).data('name');
              let new_stage_id = $(this).val();
              value = parseInt($(this).data('price'));
              stages_str = '<div class="divider-light"></div><p class="tuning-resume">'+name+' <small>'+value+' credits</small></p>';
              $('#rows-for-credits').html(stages_str);
              $('#total-credits').html(value);
              $('#total_credits_to_submit').val(value);
              // $('.options-checkbox').attr("disabled", true);

              valuesArray = null;

              $.ajax({
                  url: 'get_options_for_stage',
                  data: {
                      stage_id: new_stage_id,
                  },
                  async: false,
                  type: "POST",
                  headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                  success: function(options) {

                        $('.loader').addClass('hide');
                        // $('.options-checkbox').attr("disabled", false);

                        valuesArray = jQuery.parseJSON(options);

                        jQuery.each( valuesArray , function(i,v){

                        if(file_type == 'slave'){
                          jQuery('#option-credits-'+v.option_id).html(v.slave_credits);
                          jQuery('.option-credits-'+v.option_id).attr('data-price', v.slave_credits);
                          jQuery('.option-credits-'+v.option_id).attr('data-default-price', v.slave_credits);
                        }
                        else if(file_type == 'master'){
                          jQuery('#option-credits-'+v.option_id).html(v.master_credits);
                          jQuery('.option-credits-'+v.option_id).data('price', v.master_credits);
                          jQuery('.option-credits-'+v.option_id).attr('data-default-price', v.master_credits);
                        }

                        });

                  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) { 

                  } 
              });
          }
      });

      Array.prototype.getUnique = function() {
              var o = {}, a = []
              for (var i = 0; i < this.length; i++) o[this[i]] = 1
              for (var e in o) a.push(e)
              return a
      }

      $(document).on('click','input[type="checkbox"]',function(){

          checkbox_credits_count = 0;
          let options_str = '';
          $('#rows-for-credits').html(stages_str);
          $('input[type="checkbox"]').each(function () {
              if($(this).prop("checked") == true){
                  // console.log($(this).data('price'));
                  let option_id = $(this).val();
                  // console.log(valuesArray);
                  let price = 0;
                  jQuery.each(valuesArray, function(i,v){
                    // console.log(v.option_id);
                    if(v.option_id == option_id){
                      // console.log(v);
                      if(file_type == 'slave')
                        price = v.slave_credits;
                      else
                        price = v.master_credits;
                    }
                  });

                  console.log('price: '+price);

                  checkbox_credits_count +=  parseInt(price);
                  service_ids.push($(this).val());
                  let name = $(this).data('name');
                  options_str += '<div class="divider-light"></div><p class="tuning-resume">'+name+' <small>'+price+' credits</small></p>';
              }
              else{
                  service_ids.removeByValue($(this).val());
              }
          });

          let discount = 0;
          let unique_service_ids = service_ids.getUnique();
          console.log('thing: '+checkbox_credits_count);
          
          $('#rows-for-credits').append(options_str);           
          $('#total-credits').html(parseInt(value)+parseInt(checkbox_credits_count)-parseInt(discount));

          if(discount > 0){
              $('#without-discount-total-credits').removeClass('hide');
              $('#without-discount-total-credits').html(value+checkbox_credits_count+" ");
          }
          else{
              $('#without-discount-total-credits').addClass('hide');
          }

          $('#total_credits_to_submit').val(parseInt(value)+parseInt(checkbox_credits_count)-parseInt(discount));

      });

    });
</script>

@endsection