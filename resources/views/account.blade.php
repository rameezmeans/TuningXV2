@extends('layouts.app')
@section('pagespecificstyles')

<style>
  .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: white !important;
    
}
	
	.label-info {
    padding: 5px 15px;
    border-radius: 10px;
}

.select2-hidden-accessible {
    clip: rect(0 0 0 0) !important;
    border: 0 !important;
    -webkit-clip-path: inset(50%) !important;
    clip-path: inset(50%) !important;
    height: 1px !important;
    overflow: hidden !important;
    padding: 0 !important;
    position: absolute !important;
    white-space: nowrap !important;
    width: 1px !important;
}

select {
    background-color: hsla(0, 0%, 100%, 0.9);
    border: #777;
    border-radius: 2px;
    height: 3rem;
    padding: 5px;
    width: 100%;
}

.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 28px;
    user-select: none;
    -webkit-user-select: none;
}

.select2-container .select2-selection--single .select2-selection__rendered {
    display: block;
    overflow: hidden;
    padding-left: 8px;
    padding-right: 20px;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.select2-container .select2-selection--single .select2-selection__clear {
    position: relative;
}

.select2-container[dir="rtl"]
    .select2-selection--single
    .select2-selection__rendered {
    padding-left: 20px;
    padding-right: 8px;
}

.select2-container .select2-selection--multiple {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    min-height: 48px;
    user-select: none;
    -webkit-user-select: none;
}

.select2-container .select2-selection--multiple .select2-selection__rendered {
    display: inline-block;
    overflow: hidden;
    padding-left: 8px;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.select2-container .select2-search--inline {
    float: left;
}

.select2-container .select2-search--inline .select2-search__field {
    border: none;
    box-sizing: border-box;
    font-size: 100%;
    margin-top: 5px;
    padding: 0;
}

.select2-container
    .select2-search--inline
    .select2-search__field::-webkit-search-cancel-button {
    -webkit-appearance: none;
}

.select2-dropdown {
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px;
    box-sizing: border-box;
    display: block;
    left: -100000px;
    position: absolute;
    width: 100%;
    z-index: 1051;
}

.select2-results {
    display: block;
}

.select2-results__options {
    list-style: none;
    margin: 0;
    padding: 0;
}

.select2-results__option {
    padding: 6px;
    user-select: none;
    -webkit-user-select: none;
}

.select2-results__option[aria-selected] {
    cursor: pointer;
}

.select2-container--open .select2-dropdown {
    left: 0;
}

.select2-container--open .select2-dropdown--above {
    border-bottom: none;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.select2-container--open .select2-dropdown--below {
    border-top: none;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

.select2-search--dropdown {
    display: block;
    padding: 4px;
}

.select2-search--dropdown .select2-search__field {
    box-sizing: border-box;
    padding: 4px;
    width: 100%;
}

.select2-search--dropdown .select2-search__field::-webkit-search-cancel-button {
    -webkit-appearance: none;
}

.select2-search--dropdown.select2-search--hide {
    display: none;
}

.select2-close-mask {
    background-color: #fff;
    border: 0;
    display: block;
    filter: alpha(opacity=0);
    height: auto;
    left: 0;
    margin: 0;
    min-height: 100%;
    min-width: 100%;
    opacity: 0;
    padding: 0;
    position: fixed;
    top: 0;
    width: auto;
    z-index: 99;
}

.select2-hidden-accessible {
    clip: rect(0 0 0 0) !important;
    border: 0 !important;
    -webkit-clip-path: inset(50%) !important;
    clip-path: inset(50%) !important;
    height: 1px !important;
    overflow: hidden !important;
    padding: 0 !important;
    position: absolute !important;
    white-space: nowrap !important;
    width: 1px !important;
}

.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px;
}

.select2-container--default
    .select2-selection--single
    .select2-selection__rendered {
    color: #444;
    line-height: 28px;
}

.select2-container--default
    .select2-selection--single
    .select2-selection__clear {
    cursor: pointer;
    float: right;
    font-weight: 700;
}

.select2-container--default
    .select2-selection--single
    .select2-selection__placeholder {
    color: #999;
}

.select2-container--default
    .select2-selection--single
    .select2-selection__arrow {
    height: 26px;
    position: absolute;
    right: 1px;
    top: 1px;
    width: 20px;
}

.select2-container--default
    .select2-selection--single
    .select2-selection__arrow
    b {
    border-color: #888 transparent transparent;
    border-style: solid;
    border-width: 5px 4px 0;
    height: 0;
    left: 50%;
    margin-left: -4px;
    margin-top: -2px;
    position: absolute;
    top: 50%;
    width: 0;
}

.select2-container--default[dir="rtl"]
    .select2-selection--single
    .select2-selection__clear {
    float: left;
}

.select2-container--default[dir="rtl"]
    .select2-selection--single
    .select2-selection__arrow {
    left: 1px;
    right: auto;
}

.select2-container--default.select2-container--disabled
    .select2-selection--single {
    background-color: #eee;
    cursor: default;
}

.select2-container--default.select2-container--disabled
    .select2-selection--single
    .select2-selection__clear {
    display: none;
}

.select2-container--default.select2-container--open
    .select2-selection--single
    .select2-selection__arrow
    b {
    border-color: transparent transparent #888;
    border-width: 0 4px 5px;
}

.select2-container--default .select2-selection--multiple {
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: text;
}

.select2-container--default
    .select2-selection--multiple
    .select2-selection__rendered {
    box-sizing: border-box;
    list-style: none;
    margin: 0;
    padding: 8px;
    width: 100%;
}

.select2-container--default
    .select2-selection--multiple
    .select2-selection__rendered
    li {
    list-style: none;
}

.select2-container--default
    .select2-selection--multiple
    .select2-selection__clear {
    cursor: pointer;
    float: right;
    font-weight: 400;
    margin-right: 10px;
    margin-top: 6px;
    padding: 1px;
    color: #1E293B;
    font-size: 20px;
}

.select2-container--default
    .select2-selection--multiple
    .select2-selection__choice {
    background-color: #E1E7EF;
    border-radius: 12px;
    cursor: default;
    float: left;
    margin-right: 8PX;
    margin-top: 0.1px;
    padding: 8px 32px 8px 22px;
    font-size: 14px;
    line-height: 20px;
}

.select2-container--default
    .select2-selection--multiple
    .select2-selection__choice__remove {
    color: #1E293B;
    cursor: pointer;
    display: inline-block;
    font-weight: 700;
    margin-right: 8px;
}

.select2-container--default
    .select2-selection--multiple
    .select2-selection__choice__remove:hover {
    color: #333;
}

.select2-container--default[dir="rtl"]
    .select2-selection--multiple
    .select2-search--inline,
.select2-container--default[dir="rtl"]
    .select2-selection--multiple
    .select2-selection__choice {
    float: right;
}

.select2-container--default[dir="rtl"]
    .select2-selection--multiple
    .select2-selection__choice {
    margin-left: 5px;
    margin-right: auto;
}

.select2-container--default[dir="rtl"]
    .select2-selection--multiple
    .select2-selection__choice__remove {
    margin-left: 2px;
    margin-right: auto;
}

.select2-container--default.select2-container--focus
    .select2-selection--multiple {
    border: 1px solid #000;
    outline: 0;
}

.select2-container--default.select2-container--disabled
    .select2-selection--multiple {
    background-color: #eee;
    cursor: default;
}

.select2-container--default.select2-container--disabled
    .select2-selection__choice__remove {
    display: none;
}

.select2-container--default.select2-container--open.select2-container--above
    .select2-selection--multiple,
.select2-container--default.select2-container--open.select2-container--above
    .select2-selection--single {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

.select2-container--default.select2-container--open.select2-container--below
    .select2-selection--multiple,
.select2-container--default.select2-container--open.select2-container--below
    .select2-selection--single {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #aaa;
}

.select2-container--default .select2-search--inline .select2-search__field {
    -webkit-appearance: textfield;
    background: transparent;
    border: none;
    box-shadow: none;
    outline: 0;
    padding:0 15px;
}

.select2-container--default .select2-results > .select2-results__options {
    max-height: 200px;
    overflow-y: auto;
}

.select2-container--default .select2-results__option[role="group"] {
    padding: 0;
}

.select2-container--default .select2-results__option[aria-disabled="true"] {
    color: #999;
}

.select2-container--default .select2-results__option[aria-selected="true"] {
    background-color: #ddd;
}

.select2-container--default .select2-results__option .select2-results__option {
    padding-left: 1em;
}

.select2-container--default
    .select2-results__option
    .select2-results__option
    .select2-results__group {
    padding-left: 0;
}

.select2-container--default
    .select2-results__option
    .select2-results__option
    .select2-results__option {
    margin-left: -1em;
    padding-left: 2em;
}

.select2-container--default
    .select2-results__option
    .select2-results__option
    .select2-results__option
    .select2-results__option {
    margin-left: -2em;
    padding-left: 3em;
}

.select2-container--default
    .select2-results__option
    .select2-results__option
    .select2-results__option
    .select2-results__option
    .select2-results__option {
    margin-left: -3em;
    padding-left: 4em;
}

.select2-container--default
    .select2-results__option
    .select2-results__option
    .select2-results__option
    .select2-results__option
    .select2-results__option
    .select2-results__option {
    margin-left: -4em;
    padding-left: 5em;
}

.select2-container--default
    .select2-results__option
    .select2-results__option
    .select2-results__option
    .select2-results__option
    .select2-results__option
    .select2-results__option
    .select2-results__option {
    margin-left: -5em;
    padding-left: 6em;
}

.select2-container--default
    .select2-results__option--highlighted[aria-selected] {
    background-color: #5897fb;
    color: #fff;
}

.select2-container--default .select2-results__group {
    cursor: default;
    display: block;
    padding: 6px;
}

.select2-container--classic .select2-selection--single {
    background-color: #f7f7f7;
    background-image: -webkit-linear-gradient(top, #fff 50%, #eee);
    background-image: -o-linear-gradient(top, #fff 50%, #eee 100%);
    background-image: linear-gradient(180deg, #fff 50%, #eee);
    background-repeat: repeat-x;
    border: 1px solid #aaa;
    border-radius: 4px;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#FFFFFFFF", endColorstr="#FFEEEEEE", GradientType=0);
    outline: 0;
}

.select2-container--classic .select2-selection--single:focus {
    border: 1px solid #5897fb;
}

.select2-container--classic
    .select2-selection--single
    .select2-selection__rendered {
    color: #444;
    line-height: 28px;
}

.select2-container--classic
    .select2-selection--single
    .select2-selection__clear {
    cursor: pointer;
    float: right;
    font-weight: 700;
    margin-right: 10px;
}

.select2-container--classic
    .select2-selection--single
    .select2-selection__placeholder {
    color: #999;
}

.select2-container--classic
    .select2-selection--single
    .select2-selection__arrow {
    background-color: #ddd;
    background-image: -webkit-linear-gradient(top, #eee 50%, #ccc);
    background-image: -o-linear-gradient(top, #eee 50%, #ccc 100%);
    background-image: linear-gradient(180deg, #eee 50%, #ccc);
    background-repeat: repeat-x;
    border: none;
    border-bottom-right-radius: 4px;
    border-left: 1px solid #aaa;
    border-top-right-radius: 4px;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#FFEEEEEE", endColorstr="#FFCCCCCC", GradientType=0);
    height: 26px;
    position: absolute;
    right: 1px;
    top: 1px;
    width: 20px;
}

.select2-container--classic
    .select2-selection--single
    .select2-selection__arrow
    b {
    border-color: #888 transparent transparent;
    border-style: solid;
    border-width: 5px 4px 0;
    height: 0;
    left: 50%;
    margin-left: -4px;
    margin-top: -2px;
    position: absolute;
    top: 50%;
    width: 0;
}

.select2-container--classic[dir="rtl"]
    .select2-selection--single
    .select2-selection__clear {
    float: left;
}

.select2-container--classic[dir="rtl"]
    .select2-selection--single
    .select2-selection__arrow {
    border: none;
    border-radius: 0;
    border-bottom-left-radius: 4px;
    border-right: 1px solid #aaa;
    border-top-left-radius: 4px;
    left: 1px;
    right: auto;
}

.select2-container--classic.select2-container--open .select2-selection--single {
    border: 1px solid #5897fb;
}

.select2-container--classic.select2-container--open
    .select2-selection--single
    .select2-selection__arrow {
    background: transparent;
    border: none;
}

.select2-container--classic.select2-container--open
    .select2-selection--single
    .select2-selection__arrow
    b {
    border-color: transparent transparent #888;
    border-width: 0 4px 5px;
}

.select2-container--classic.select2-container--open.select2-container--above
    .select2-selection--single {
    background-image: -webkit-linear-gradient(top, #fff, #eee 50%);
    background-image: -o-linear-gradient(top, #fff 0, #eee 50%);
    background-image: linear-gradient(180deg, #fff 0, #eee 50%);
    background-repeat: repeat-x;
    border-top: none;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#FFFFFFFF", endColorstr="#FFEEEEEE", GradientType=0);
}

.select2-container--classic.select2-container--open.select2-container--below
    .select2-selection--single {
    background-image: -webkit-linear-gradient(top, #eee 50%, #fff);
    background-image: -o-linear-gradient(top, #eee 50%, #fff 100%);
    background-image: linear-gradient(180deg, #eee 50%, #fff);
    background-repeat: repeat-x;
    border-bottom: none;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#FFEEEEEE", endColorstr="#FFFFFFFF", GradientType=0);
}

.select2-container--classic .select2-selection--multiple {
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: text;
    outline: 0;
}

.select2-container--classic .select2-selection--multiple:focus {
    border: 1px solid #5897fb;
}

.select2-container--classic
    .select2-selection--multiple
    .select2-selection__rendered {
    list-style: none;
    margin: 0;
    padding: 0 5px;
}

.select2-container--classic
    .select2-selection--multiple
    .select2-selection__clear {
    display: none;
}

.select2-container--classic
    .select2-selection--multiple
    .select2-selection__choice {
    background-color: #e4e4e4;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px;
}

.select2-container--classic
    .select2-selection--multiple
    .select2-selection__choice__remove {
    color: #888;
    cursor: pointer;
    display: inline-block;
    font-weight: 700;
    margin-right: 2px;
}

.select2-container--classic
    .select2-selection--multiple
    .select2-selection__choice__remove:hover {
    color: #555;
}

.select2-container--classic[dir="rtl"]
    .select2-selection--multiple
    .select2-selection__choice {
    float: right;
    margin-left: 5px;
    margin-right: auto;
}

.select2-container--classic[dir="rtl"]
    .select2-selection--multiple
    .select2-selection__choice__remove {
    margin-left: 2px;
    margin-right: auto;
}

.select2-container--classic.select2-container--open
    .select2-selection--multiple {
    border: 1px solid #5897fb;
}

.select2-container--classic.select2-container--open.select2-container--above
    .select2-selection--multiple {
    border-top: none;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

.select2-container--classic.select2-container--open.select2-container--below
    .select2-selection--multiple {
    border-bottom: none;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.select2-container--classic .select2-search--dropdown .select2-search__field {
    border: 1px solid #aaa;
    outline: 0;
}

.select2-container--classic .select2-search--inline .select2-search__field {
    box-shadow: none;
    outline: 0;
}

.select2-container--classic .select2-dropdown {
    background-color: #fff;
    border: 1px solid transparent;
}

.select2-container--classic .select2-dropdown--above {
    border-bottom: none;
}

.select2-container--classic .select2-dropdown--below {
    border-top: none;
}

.select2-container--classic .select2-results > .select2-results__options {
    max-height: 200px;
    overflow-y: auto;
}

.select2-container--classic .select2-results__option[role="group"] {
    padding: 0;
}

.select2-container--classic .select2-results__option[aria-disabled="true"] {
    color: grey;
}

.select2-container--classic
    .select2-results__option--highlighted[aria-selected] {
    background-color: #3875d7;
    color: #fff;
}

.select2-container--classic .select2-results__group {
    cursor: default;
    display: block;
    padding: 6px;
}

.select2-container--classic.select2-container--open .select2-dropdown {
    border-color: #5897fb;
}

.select2-search__field {
        height: 2rem !important;
    }

    .select2-results__option {
        padding: 1rem;
    }

    .select2-results__option span {
        font-size: 18px;
    }

    .select2 {
        width: 100% !important;
    }
    
</style>

@endsection
@section('content')
<div id="viewport">
    @include('layouts.sidebar')
    <!-- Content -->
    <div id="content" class="db-content">
      @include('layouts.header')
      <div class="container-fluid">
        <div class="header-block fix-header">  
            <h1 class="m-t-40">Account Settings</h1>
            <p>Manage all your account information and settings.</p>
        </div>
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12" style="margin-bottom: 100px;">

                  <ul class="nav nav-tabs account-nav-tabs" style="border-top: #ddd 1px solid;">
                    <li class="@if(request()->get('tab') != 'tools') active @endif"><a data-toggle="tab" href="#profile">Profile</a></li>
                    <li><a data-toggle="tab" href="#password">Password Change</a></li>
                    <li class="@if(request()->get('tab') == 'tools') active @endif"><a data-toggle="tab" href="#ecu">ECU Tools</a></li>
                    <li><a data-toggle="tab" href="#logs">Credit Logs</a></li>
                    <li><a data-toggle="tab" href="#evclogs">EVC Credits Logs</a></li>
                    <li><a data-toggle="tab" href="#delete">Delete Account</a></li>
                  </ul>
                
                  <div class="tab-content account-tab-content">

                    <div id="profile" class="tab-pane fade @if(request()->get('tab') != 'tools') in active @endif">
                      <div class="row m-b-45" style="border-bottom: 1px solid #ddd;">
                            <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
                                <div class="heading-column-box">
                                    <h3>Personal Information</h3>
                                    <p>Use a personal address where you can receive email.</p>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                              <div class="row">
                                  <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="form-group" style="margin-bottom:19px">
                                        <label for="exampleInputType1">Account Type</label>
                                            <div>
                                                <span class="m-r-10"><input type="radio" @if($user->status == 'company') checked @endif @disabled(true)> Company</span>
                                                <span class="m-r-10"><input type="radio" @if($user->status == 'private') checked @endif  @disabled(true)> Private</span>
                                                <span><input type="radio" @if($user->status == 'entrepreneur_microentreprise') checked @endif  @disabled(true)> Auto Entrepreneur / Microentreprise</span>
                                            </div>
                                    </div>
                                  </div>
                                </div>
                                <form action="{{route('edit-account')}}" method="POST">
                                @csrf
                                <div class="row">
                                  <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputCompanyName1">Company Name </label>
                                      <input type="text" name="company_name" class="form-control" value="{{$user->company_name}}">
                                      @error('company_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    </div>
                                  </div>
                                  <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputCompanyName1">Company Trade Registration ID </label>
                                      <input type="text" name="company_id" class="form-control" value="{{$user->company_id}}">
                                      @error('company_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputCompanyName1">Full Name *</label>
                                      <input type="text" name="name" class="form-control" required="required" value="{{$user->name}}">
                                      @error('name')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror
                                    </div>
                                  </div>
                                  <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputCompanyName1">Email</label>
                                      <input disabled type="text" name="email" class="form-control" value="{{$user->email}}">
                                      @error('name')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror
                                    </div>
                                  </div>
                                  <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputCompanyName1">Phone *</label>
                                      <input type="text" name="phone" class="form-control" value="{{$user->phone}}">
                                      @error('phone')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputCompanyName1">Country</label>
                                      <input disabled type="text" name="country" class="form-control" required="required" disabled value="{{code_to_country($user->country)}}">
                                    </div>
                                  </div>
                                  <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputCompanyName1">Address</label>
                                      <input disabled type="text" name="address" class="form-control" value="{{$user->address}}">
                                    </div>
                                  </div>
                                  <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputCompanyName1">City</label>
                                      <input disabled type="text" name="company_name" class="form-control" value="{{$user->city}}">
                                    </div>
                                  </div>
                                  <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputCompanyName1">Zip</label>
                                      <input disabled type="text" name="company_name" class="form-control" value="{{$user->zip}}">
                                    </div>
                                  </div>
                                  <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="form-group">
                                      <label for="exampleInputCompanyName1">EVC Customer ID</label>
                                      <input type="text" name="evc_customer_id" class="form-control" value="{{$user->evc_customer_id}}">
                                      @error('evc_customer_id')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    
                                    <input type="submit" class="btn btn-success m-l-20" value="Update">
                                  </div>
                                </div>
                                </form>
                            </div>
                            
                      </div>

                      <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
                            <div class="heading-column-box">
                                <h3>Languages</h3>
                                <p>Set Your Prefered Contact and Dashboard language.</p>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                          <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                              <div class="form-group">
                                <label for="exampleInputLanguage1">Language</label>
                                
                                <select name="language" id="language" class="select-dropdown form-control" style="width: 100%;">
                                    <option @if(isset($user->translation) && $user->translation->locale == 'en') @selected(true)  @endif value="english">English</option>
                                    <option @if(isset($user->translation) && $user->translation->locale  == 'gr') @selected(true)  @endif value="gr">Greek</option>
                                </select>
                                
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      
                    </div>
                    <div id="password" class="tab-pane fade">
                      <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
                            <div class="heading-column-box">
                                <h3>Password Change</h3>
                                <p>Update your password associated with your account.</p>
                            </div>    
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                          @if($errors->any())
                          <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
                          @endif
                       <form name="" method="post" action="{{ route('change-password') }}">
                          @csrf
                          <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                              <label for="exampleInputLanguage1">Current Password</label>
                              <input type="password" name="current_password" class="form-control">
                            </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                              <label class="">{{__('New Password')}}</label>
                              <input type="password" name="new_password" class="form-control">
                            </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                              <label class="">{{__('Confirm Password')}}</label>
                              <input type="password" name="confirm_password" class="form-control">
                            </div>
                            </div>
                            <div class="form-group">
                            <button type="submit" id="language_create_form_Save" class="btn btn-info m-l-20">{{__('Save Changed')}}</button>
                            </div>
                          
                          </div>
                        </form>
                        </div>
                      </div>
                    </div>

                    <div id="ecu" class="tab-pane fade @if(request()->get('tab') == 'tools') in active @endif">
                      <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
                            <div class="heading-column-box">    
                                <h3>ECU Tools</h3>
                                <p>Edit your reading list.</p>
                            </div>
                      </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                          <form method="POST" action="{{ route('update-tools'); }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <div class="form-group m-b-30">
                                <label class="account-label">Master Tools</label>
                                <div class="input-field col s12">
                                    
                                        <select name="master_tools[]" id="master_tools" class="form-control select-dropdown-multi" multiple>
    
                                            @foreach($allMasterTools as $mtool)
                                            
                                            <option value="{{ $mtool->id }}" @if( in_array($mtool->id, $masterTools)) selected @endif>{{$mtool->name}}</option>
                                            @endforeach
    
                                        </select>
                                    
                                </div>
                            </div>
    
                            <div class="form-group m-t-20">

                            <label class="account-label">Slave Tools</label>
                            

                                  <select name="slave_tools[]" id="slave_tools" class="select-dropdown-multi form-control" multiple>
  
                                      @foreach($allSlaveTools as $stool) 
                                      <option value="{{ $stool->id }}" @if( in_array($stool->id, $slaveTools)) selected @endif>{{$stool->name}}</option>
                                      @endforeach
  
                                  </select>
                                
                            </div>
                    
    
                        <button type="submit" class="btn btn-info waves-effect waves-light m-sm">{{__('Save Changes')}}</button>
                      </form>
                        </div>
                      </div>
                    </div>

                    <div id="logs" class="tab-pane fade">
                      <div class="col-xl-12 col-lg-12 col-md-12 m-t-20" >
                      <table class="table table-hover datatable">
                        <thead>
                          <tr>
                                <th>DATE</th>
                                <th>PURCHASE</th>
                                <th>SPEND</th>
                                <th>RUNNING TOTAL</th>
                                <th>NOTE</th>
                                <th>INVOICE NUM</th>
                                <th>AMOUNT</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($credits as $credit)
                              <tr>
                                <td style="width: 15%;">{{date('Y - m - d', strtotime( $credit->created_at))}}</td>
                                
                                @if($credit->credits > 0)
                                    <td style="width: 15%;"><span @if($credit->credits < 0) class="label-danger" @else class="label-success" @endif> {{$credit->credits}} Credits </span></td>
                                    <td></td>
                                @else
                                    <td></td>
                                    <td style="width: 15%;"><span @if($credit->credits < 0) class="label-danger" @else class="label-success" @endif> {{$credit->credits}} Credits </span></td>
                                @endif
                                
                                <td><span class="label-info">{{$credit->running_total()}}</span></td>
                                <td>{{$credit->message_to_credit}}</td>
                                <td>@if($credit->credits > 0){{$credit->invoice_id}}@endif</td>
                                
                                @if(!$credit->file_id)
                                    <td>{{$credit->price_payed}}€</td>
                                @else
                                    <td></td>
                                @endif

                              </tr>
                          @endforeach
                        </tbody>
                      </table>
                      </div>
                    </div>
                    <div id="evclogs" class="tab-pane fade">
                        <div class="col-xl-12 col-lg-12 col-md-12 m-t-20" >
                            <table class="table table-hover datatable">
                              <thead>
                                <tr>
                                  <th>DATE</th>
                                  <th>CREDITS</th>
                                  <th>NOTES</th>
                                  <th>INVOICE NUM</th>
                                  <th>AMOUNT</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($evcCredits as $credit)
                                    <tr>
                                      <td>{{date('Y - m - d', strtotime( $credit->created_at))}}</td>
                                      <td><span @if($credit->credits < 0) class="label-danger" @else class="label-success" @endif> {{$credit->credits}} Credits </span></td>
                                      <td>{{$credit->message_to_credit}}</td>
                                      <td>{{$credit->invoice_id}}</td>
                                      <td>{{$credit->price_payed}}€</td>
                                    </tr>
                                @endforeach
                              </tbody>
                            </table>
                            </div>
                    </div>

                    <div id="delete" class="tab-pane fade">
                        <div class="col-xl-12 col-lg-12 col-md-12 m-t-20" >
                            If You want to delete Your account. Please click the button below.
                        <form method="post" action="{{ route('delete-account-email') }}" class="m-t-20">
                            
                            @csrf

                            <input type="hidden" name="user_id" value="{{$user->id}}">

                            <button type="submit" class="btn btn-danger waves-effect waves-light m-sm">{{__('Delete Account')}}</button>
                      </form>
                        </div>
                    </div>
                    
                  </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('pagespecificscripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>

<script type="text/javascript">

    function get_dropdown_image(id) {
        // icons is a global variable from app.blade.php ...
        return icons[id];
    }

    $(document).ready(function(event) {

          $(document).on('change', '#language',function(e) {
            var language = $(this).val();
            window.location.href = '/language/'+language;
          });

          $(".select-dropdown-multi").select2({
            templateResult: function(idioma) {
                var $span = $("<span>" + idioma.text + "<img style='float:right; width:5%;' src='" + get_dropdown_image(idioma.id) + "'/> </span>");
                return $span;
            },
            closeOnSelect: false,
            placeholder: "Select Tools",
            allowHtml: true,
            allowClear: true,
            tags: false  
            
        });
    });

</script>

@endsection