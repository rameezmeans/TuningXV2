@extends('layouts.app')

@section('pagespecificstyles')

<style>
    .tab .tablinks .wow i {
        display: block;
        font-size: 1.5em;
    }

    .bullets {
        list-style-type: circle !important;
    }

    .modal {
        top: 20% !important;
    }

    #ecu_file_select+ul+span {
        display: none;
    }

    #gearbox_file_select+ul+span {
        display: none;
    }

    .tab .tablinks .wow span {
        display: block;
    }

    .tab .tablinks .wow small {
        display: block;
        white-space: normal;
    }

    span {
        white-space: normal;
    }

    .tablinks-smaller {
        height: 50px;
        width: 50% !important;
    }

    /* Style the tab */
    .tab {
        /* overflow: hidden; */

        color: #f02429;
        background-color: #fff;
        box-shadow: none;
        display: flex;
        font-size: 16px;
        height: 100px;
        margin: 0 auto;
        overflow-x: auto;
        overflow-y: hidden;
        position: relative;
        white-space: nowrap;
        width: 100%;
    }

    /* Style the buttons that are used to open the tab content */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        width: 34%;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        border-bottom: #f02429 2px solid;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        border-bottom: #f02429 2px solid;
    }

    /* Style the tab content */
    .tabcontent {
        background-color: #fff;
        display: none;
        padding: 6px 12px;
        border-top: none;
        margin-top: 5px;
    }


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
        width: 50%;
        padding: 0;
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

    .f-dropdown {
        --max-scroll: 3;
        position: relative;
        z-index: 10;
    }

    .f-dropdown select {
        display: none;
    }

    .f-dropdown>span {
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        position: relative;
        color: #bbb;
        border: 1px solid #ccc;
        background: #fff;
        transition: color 0.2s ease, border-color 0.2s ease;
        border-radius: 6px;
        box-shadow: 0 8px 20px 0 rgb(73 76 83 / 20%);
    }

    .f-dropdown ul li a span {
        font-size: 16px;
    }

    .f-dropdown>span>span {
        white-space: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        padding-right: 12px;
        font-size: 12px;
    }

    .f-dropdown>span img {
        width: 30px;
        margin-right: 10px;
    }

    .f-dropdown>span:before,
    .f-dropdown>span:after {
        content: "";
        display: block;
        position: absolute;
        width: 8px;
        height: 2px;
        border-radius: 1px;
        top: 50%;
        right: 12px;
        background: #000;
        transition: all 0.3s ease;
    }

    .f-dropdown>span:before {
        margin-right: 4px;
        transform: scale(0.96, 0.8) rotate(50deg);
    }

    .f-dropdown>span:after {
        transform: scale(0.96, 0.8) rotate(-50deg);
    }

    .f-dropdown ul {
        margin: 0;
        padding: 0;
        list-style: none;
        opacity: 0;
        visibility: hidden;
        position: absolute;
        max-height: calc(var(--max-scroll) * 75px);
        top: 30px;
        left: 0;
        z-index: 1;
        right: 0;
        background: #FFF;
        border: 1px solid #CCC;
        border-radius: 6px;
        overflow-x: hidden;
        overflow-y: auto;
        transform-origin: 0 0;
        transition: opacity 0.2s ease, visibility 0.2s ease, transform 0.3s cubic-bezier(0.4, 0.6, 0.5, 1.32);
        transform: translate(0, 5px);
    }

    .f-dropdown ul li {
        padding: 0;
        margin: 0;
    }

    .f-dropdown ul li a {
        cursor: pointer;
        display: block;
        padding: 8px 12px;
        color: #000;
        text-decoration: none;
        outline: none;
        position: relative;
        transition: all 0.2s ease;
        align-items: center;
    }

    .f-dropdown ul li a img {
        width: auto;
        height: 40px;
        float: right;
        padding-bottom: 5px;
    }

    .f-dropdown ul li a:hover {
        color: #5C6BC0;
    }

    .f-dropdown ul li.active a {
        color: #FFF;
        background: lightgrey;
    }

    .f-dropdown ul li.active a:before,
    .f-dropdown ul li.active a:after {
        --scale: 0.6;
        content: "";
        display: block;
        width: 10px;
        height: 2px;
        position: absolute;
        right: 12px;
        top: 50%;
        opacity: 0;
        background: #FFF;
        transition: all 0.2s ease;
    }

    .f-dropdown ul li.active a:before {
        transform: rotate(45deg) scale(var(--scale));
    }

    .f-dropdown ul li.active a:after {
        transform: rotate(-45deg) scale(var(--scale));
    }

    .f-dropdown ul li.active a:hover:before,
    .f-dropdown ul li.active a:hover:after {
        --scale: 0.9;
        opacity: 1;
    }

    .f-dropdown ul li:first-child a {
        border-radius: 6px 6px 0 0;
    }

    .f-dropdown ul li:last-child a {
        border-radius: 0 0 6px 6px;
    }

    .f-dropdown.disabled {
        opacity: 0.7;
    }

    .f-dropdown.disabled>span {
        cursor: not-allowed;
    }

    .f-dropdown.filled>span {
        color: #000;
    }

    .f-dropdown.open {
        z-index: 15;
    }

    .f-dropdown.open>span {
        border-color: #AAA;
    }

    .f-dropdown.open>span:before,
    .f-dropdown.open>span:after {
        background: #000;
    }

    .f-dropdown.open>span:before {
        transform: scale(0.96, 0.8) rotate(-50deg);
    }

    .f-dropdown.open>span:after {
        transform: scale(0.96, 0.8) rotate(50deg);
    }

    .f-dropdown.open ul {
        opacity: 1;
        visibility: visible;
        transform: translate(0, 12px);
        transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s cubic-bezier(0.4, 0.6, 0.5, 1.32);
    }

    /* --------------------------- */
    .f-group {
        max-width: 250px;
        margin: 0 auto;
        text-align: left;
    }

    .f-group select {
        width: 100%;
    }

    .f-control {
        font-size: 14px;
        line-height: normal;
        color: #000;
        display: inline-block;
        background-color: #ffffff;
        border: #ccc 1px solid;
        border-radius: 6px;
        padding: 8px 12px;
        outline: none;
        max-width: 250px;
    }

    .information {
        display: none;
    }

.ring
{
  position:absolute;
  top:200px;
  left:10%;
  transform:translate(-50%,-50%);
  width:30px;
  height:30px;
  background:transparent;
  border:3px solid #3c3c3c;
  border-radius:50%;
  text-align:center;
  line-height:150px;
  font-family:sans-serif;
  font-size:8px;
  color:#f02429;
  letter-spacing:4px;
  text-transform:uppercase;
  text-shadow:0 0 10px #f02429;
  box-shadow:0 0 20px rgba(0,0,0,.5);
}
.ring:before
{
  content:'';
  position:absolute;
  top:0px;
  left:0px;
  width:100%;
  height:100%;
  border:3px solid transparent;
  border-top:3px solid #f02429;
  border-right:3px solid #f02429;
  border-radius:50%;
  animation:animateC 2s linear infinite;
}
span.loading
{
  display:block;
  position:absolute;
  top:calc(50% - 2px);
  left:50%;
  width:50%;
  height:4px;
  background:transparent;
  transform-origin:left;
  animation:animate 2s linear infinite;
}
span.loading:before
{
  content:'';
  position:absolute;
  width:16px;
  height:16px;
  border-radius:50%;
  background:#f02429;
  top:-6px;
  right:-8px;
  box-shadow:0 0 20px #f02429;
}
@keyframes animateC
{
  0%
  {
    transform:rotate(0deg);
  }
  100%
  {
    transform:rotate(360deg);
  }
}
@keyframes animate
{
  0%
  {
    transform:rotate(45deg);
  }
  100%
  {
    transform:rotate(405deg);
  }
}

.timeline-content {
    width: 100%;
    height: auto;
    background: #FCFCFC 0% 0% no-repeat padding-box;
    box-shadow: 0px 3px 32px #0000000A;
    border: 1px solid #E2E8F0;
    opacity: 1;
    margin-top: 100px;
    border-radius: 10px;
    padding: 20px;
}

body  {
    background: #1E293B80 !important;
}

</style>

@endsection

@section('content')

<main>

    <section>
        <div id="commentsPopup" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button style="float: right;" type="button" class="btn btn-white close-modal">x</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">

                        </div>
                        <div>
                            <h3 class="modal-information">{{__('Important Information')}}</h3>
                            <div class="modal-comments">{{__('Please click on Confirm button to download the file.')}}</div>
                        </div>

                    </div>
                    <div class="modal-footer">

                        {{-- <button type="button" class="btn btn-white close-modal">{{__('Close')}}</button> --}}
                        <a href="#" class="btn btn-success download-path-original modal-confirm" style="margin-right: 10px;">{{__('Confirm')}}</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="content">
            <div class="container">
                
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3"></div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        
                        <div class="timeline-content" style="">

                            <div style="margin-top: 0px;">
                                <a style="float: right; border: 1px #1E293B solid; padding: 0px 5px; border-radius: 2px;" @if($file->original_file_id) href="{{route('file', $file->original_file_id)}}" @else href="{{route('history')}}" @endif>X</a>
                            @if(!$file->engineer_file)
                            <div id="checking">
                                
                                <strong style="float: left; display: block;">Searching file in our database</strong><br>
                                

                                <div  class="ring">
                                    <span class="loading"></span>
                                </div>
                                <p style="display: block; margin-top: 50px; float: left; margin-left: 50px;">Please wait while we try to prepare your file for instant download.</p>
                            </div>

                                <div id="download-area" class="hide">
                                    
                                </div>

                                <div id="not-found-area" class="hide">
                                    <br>
                                    <p>Your file will be processed by our engineers, you will hear from them very soon.</p>
                                    
                                </div>
                            @else

                            @if($file->no_longer_auto == 0)
                            <p>Success, your file is ready for download.</p>
                                {{-- <button class="btn btn-red btn-download" 
                                data-make="{{$file->brand}}" 
                                data-engine="{{$file->engine}}" 
                                data-ecu="{{$file->ecu}}" 
                                data-model="{{$file->model}}" 
                                data-generation="{{$file->version}}" 
                                data-file_id="{{$file->id}}" 
                                data-path="{{route("download", [$file->id, $file->engineer_file->request_file])}}"
                                >
                                    
                                    <i class="fa fa-download"></i>
                                    Download
                                </button> --}}

                                <a class="btn btn-red" href="{{route('download', [$file->id,$file->engineer_file->request_file])}}">
                                    <i class="fa fa-download"></i> Download
                                </a>
                                
                                @else
                                    <p>Your file will be processed by our engineers, you will hear from them very soon.</p>
                                @endif

                            @endif
                            </div>


                                <div id="options-area" class="m-t-10 bb-light bt" style="line-height: 2.7; margin-bottom: 10px; padding-bottom: 10px; margin-top:100px;">
                                    <p class="push-bit" style="">
                                        Your request is being recieved with following options:
                                    </p>
    
                                    @if($file->stages_services)
                                      @php $stage = \ECUApp\SharedCode\Models\Service::FindOrFail( $file->stages_services->service_id); @endphp
                                      @if($stage)
                                          <span class="show-stage"><img style="width: 5%;" src="{{ get_logo_for_stages_and_options( $stage->name ) }}" alt="{{$stage->name}}">
                                            {{ $stage->name }}</span>
                                      @endif
                                    @endif

                                    @if($file->options_services)
                                      @foreach($file->options_services as $option)
                                        @php 
                                            $op = \ECUApp\SharedCode\Models\Service::FindOrFail( $option->service_id ); 
                                        @endphp
                                        @if($op)
                                        <span class="show-stage"><img style="width: 5%;" src="{{ get_logo_for_stages_and_options( $op->name ) }}" alt="{{$stage->name}}">
                                          {{ $op->name }}</span>
                                        @endif
                                      @endforeach
                                    @endif

                                </div>

                                <div class="p-t-10 bb-light" style="padding-bottom: 20px;">
                                    <span><strong>Reading Tool:</strong></span>
                                    <div class="m-t-10">
                                      <span class="show-stage">
                                        <img style="width: 7%;" src="{{ get_dropdown_image($file->tool_id) }}" class="tool-logo-small"> {{ ucfirst($file->tool_type) }}
                                      </span>
                                    </div>
                                </div>

                                <div class="details-box" style="margin: 0px; margin-top: 10px;">
                                    <table style="background: transparent;">
                                      <tbody>
                                        <tr >
                                          <td style="width: 40%; padding-bottom: 10px;">
                                            <strong>Brand Group:</strong>
                                            <img alt="" class="" style="width: 20%;" src="{{ get_image_from_brand($file->brand) }}">
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
                                  
                            


                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3"></div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('pagespecificscripts')
<script src="https://js.pusher.com/7.0.3/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher("{{ config('chatify.pusher.key') }}", {
        encrypted: true,
        cluster: "{{ config('chatify.pusher.options.cluster') }}",
        authEndpoint: '{{route("pusher.auth")}}',
        auth: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }
    });

</script>
<script type="text/javascript">

    $(document).ready(function(event) {

        let chat_id = '{{env("LIVE_CHAT_ID")}}';
        const channelName = "private-chatify-download-tuningx-"+chat_id;
        var channel = pusher.subscribe(`${channelName}`);

        console.log(channel);

        var clientSendChannel;
        var clientListenChannel;
        let file_id = '{{$file->id}}';
        
        setTimeout(
        function(){
           
            $.ajax({
                        url: '{{route("get-change-status")}}',
                        type: "POST",
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'file_id': file_id
                        },
                        success: function(d) {
                            console.log(d);

                            $('#options-area').css("margin-top", "10px");

                            if(d.fail == 1 && d.file_id == file_id){
                                $('#checking').addClass('hide');
                                $('#download-area').addClass('hide');
                                $('#not-found-area').removeClass('hide');
                            }

                            if(d.fail == 0 && d.file_id == file_id){
                                $('#checking').addClass('hide');
                                $('#download-area').addClass('hide');
                                $('#not-found-area').removeClass('hide');
                            }
                        }
                    });
            
        // }, 90);
        }, 90000);

        channel.bind("download-button", function(data) {

            console.log('mog');
            console.log(data);

            let page_file_id = '{{$file->id}}';
            let file_id = data.file_id;

            if(data.status == 'download'){

                console.log('download');
                
                if(file_id == page_file_id){
                    $.ajax({
                        url: '{{route("get-download-button")}}',
                        type: "POST",
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'file_id': file_id
                        },
                        success: function(d) {
                            
                            $('#options-area').css("margin-top", "10px");
                            console.log(d.download_button);
                            $('#checking').addClass('hide');
                            $('#download-area').removeClass('hide');
                            $('#download-area').html(d.download_button);
                            
                        }
                    });
                }
            }
            else{
                console.log('failed');
                if(file_id == page_file_id){
                    $('#not-found-area').removeClass('hide');
                    $('#checking').addClass('hide');  
                }
            }
        });

        $(document).on('click', '.btn-download', function() {

            $('#commentsPopup').modal('show');
            $('.modal-content').css('visibility', 'visible');
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
                    if (d.comments_found == true) {
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

        $(document).on('click', '.close-modal', function() {

            $('#commentsPopup').modal('hide');
        });

        $(document).on('click', '.modal-confirm', function() {

            $('#commentsPopup').modal('hide');
        });
    });

</script>
@endsection
