@extends('layouts.front')


@section('pagespecificstyles')

<style>

.select2-search__field {
    height: 1.8rem !important;
}

body {
    background: #f1f5f9 !important;
}

</style>

@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12" style="">
                    <div class="logo-register text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="261" height="101" viewBox="0 0 261 101"><defs><clipPath id="a"><rect width="261" height="101" transform="translate(0 0.053)" fill="#fff" stroke="#707070" stroke-width="1"/></clipPath><pattern id="b" preserveAspectRatio="none" width="100%" height="100%" viewBox="0 0 1200 1200"><image width="1200" height="1200" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABLAAAASwCAMAAADc/0P9AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAAlQTFRFsBMhAAAAAAAAUPktvQAAAAN0Uk5T//8A18oNQQAAFGhJREFUeNrs3VuW4ygURUFg/oPuCeTqsiwucEzEt0u+icQuv9LZBkCIZgkAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAAQLECwAwQIEyxIAggUgWIBgAQgWgGABggUgWACCBQgWgGABCBYgWACCBSBYgGABCBaAYAGCBSBYAIIFCBaAYAEIFiBYAIIFIFiAYAEIFiBYAIIFIFiAYAEIFoBgAYIFIFgAggUIFoBgAQgWIFgAggUgWIBgAQgWgGABggUgWACCBQgWgGAB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BSBYAIIFCBaAYAEIFiBYAIIFIFiAYAEIFoBgAYIFIFiAYAEIFoBgAYIFIFgAggUIFoBgAQgWIFgAggUgWIBgAQgWgGABggUgWACCBQgWgGABCBYgWACCBSBYgGABCBaAYAGCBSBYgGABCBaAYAGCBSBYAIIFCBaAYAEIFiBYAIIFIFiAYAEIFoBgAYIFIFgAggUIFoBgAQgWIFgAggUgWIBgAQgWgGABggUgWIBgAQgWgGABggUgWACCBQgWgGABCBYgWACCBSBYgGABCBaAYAGCBSBYAIIFCBaAYAEIFiBYAIIFIFiAYAEIFoBgAYIFIFiAYAEIFoBgAYIFIFgAggUIFoBgAQgWIFgAggUgWIBgAQgWgGABggUgWACCBQgWgGABCBYgWACCBSBYgGABCBaAYAGCBSBYgGABCBaAYAGCBSBYAIIFCBaAYAEIFiBYAIIFIFiAYAEIFoBgAYIFIFgAggUIFoBgAQgWIFgAggUgWIBgAQgWgGABggUgWIBgAQgWgGABggUgWACCBQgWgGABCBYgWACCBSBYgGABCBaAYAGCBSBYAIIFCBaAYAEIFiBYAIIFIFiAYAEIFiBYlgAQLADBAgQLQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAEC0CwAMEC2Ow/AQYA7MtQs3XP5LAAAAAASUVORK5CYII="/></pattern></defs><g transform="translate(-160.484 -13.66)"><g transform="translate(160.484 13.607)" clip-path="url(#a)"><rect width="343" height="344" transform="translate(-41 -126.947)" fill="url(#b)"/></g></g></svg>
                    </div>
                    <div class="register-box">
                        <a class="black" href="#"><p><i class="fa fa-angle-left p-r-5"></i>Back to Homepage</p></a>
                        <h2>Register Yourself!</h2>
                        <p>Start managing your ECU files faster and better.</p>
                    
                    @if($errors->any())
                    <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
                    @endif

                    <form method="POST" action="{{ route('register.post') }}" class="login-form">
                        @csrf

                            <div class="form-group">
                                <label for="exampleInputName1">Name</label>
                                <input type="text" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" id="exampleInputName1" aria-describedby="emailHelp" placeholder="Enter Name" name="name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPhone1">Phone *</label>
                                <input type="text" value="{{old('phone')}}" id="exampleInputPhone1" name="phone" class="form-control @error('phone') is-invalid @enderror" required="required" placeholder="{{__('Phone')}}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                            <label for="exampleInputEmail1">Email *</label>
                                <input type="text" value="{{old('email')}}" id="exampleInputEmail1" name="email" class="form-control @error('email') is-invalid @enderror" required="required" placeholder="{{__('Email')}}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password *</label>
                                    <input type="password" id="exampleInputPassword1" name="password" class="form-control @error('password') is-invalid @enderror" required="required" placeholder="{{__('Password')}}">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPasswordConfirmation1">Password Confirmation *</label>
                                <input type="password" id="exampleInputPasswordConfirmation1" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required="required" placeholder="{{__('Password Verification')}}">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputLanguage1">Language</label>
                                
                                <select name="language" id="exampleInputLanguage1" class="select-dropdown form-control" style="width: 100%;">
                                    <option value="english">English</option>
                                    <option value="gr">Greek</option>
                                </select>
                                
                            </div>

                            <div class="form-group">
                                <label for="exampleInputAddress1">Address *</label>
                                <input type="text" value="{{old('address')}}" id="exampleInputAddress1" name="address" class="form-control @error('address') is-invalid @enderror" required="required" placeholder="{{__('Address')}}">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputZip1">Zip *</label>
                                <input type="text" value="{{old('zip')}}" id="exampleInputZip1" name="zip" class="form-control @error('zip') is-invalid @enderror" required="required" placeholder="{{__('Zip')}}">
                                @error('zip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCity1">City *</label>
                                <input type="text" value="{{old('city')}}" id="exampleInputCity1" name="city" class="form-control @error('city') is-invalid @enderror" required="required" placeholder="{{__('City')}}">
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">EVC Customer ID</label>
                                    <input type="text" id="exampleEvc1" name="evc_customer_id" class="form-control @error('evc_customer_id') is-invalid @enderror" placeholder="{{__('EVC customer ID')}}">
                                @error('evc_customer_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputCountry1">Country *</label>
                                <select name="country" id="exampleInputCountry1" class="select-dropdown form-control">
                                    <option selected disabled>{{__('Select Your Country')}}</option>
                                    <option value="AF">Afghanistan</option>
                                    <option value="AX">Aland Islands</option>
                                    <option value="AL">Albania</option>
                                    <option value="DZ">Algeria</option>
                                    <option value="AS">American Samoa</option>
                                    <option value="AD">Andorra</option>
                                    <option value="AO">Angola</option>
                                    <option value="AI">Anguilla</option>
                                    <option value="AQ">Antarctica</option>
                                    <option value="AG">Antigua and Barbuda</option>
                                    <option value="AR">Argentina</option>
                                    <option value="AM">Armenia</option>
                                    <option value="AW">Aruba</option>
                                    <option value="AU">Australia</option>
                                    <option value="AT">Austria</option>
                                    <option value="AZ">Azerbaijan</option>
                                    <option value="BS">Bahamas</option>
                                    <option value="BH">Bahrain</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="BB">Barbados</option>
                                    <option value="BY">Belarus</option>
                                    <option value="BE">Belgium</option>
                                    <option value="BZ">Belize</option>
                                    <option value="BJ">Benin</option>
                                    <option value="BM">Bermuda</option>
                                    <option value="BT">Bhutan</option>
                                    <option value="BO">Bolivia</option>
                                    <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                    <option value="BA">Bosnia and Herzegovina</option>
                                    <option value="BW">Botswana</option>
                                    <option value="BV">Bouvet Island</option>
                                    <option value="BR">Brazil</option>
                                    <option value="IO">British Indian Ocean Territory</option>
                                    <option value="BN">Brunei Darussalam</option>
                                    <option value="BG">Bulgaria</option>
                                    <option value="BF">Burkina Faso</option>
                                    <option value="BI">Burundi</option>
                                    <option value="KH">Cambodia</option>
                                    <option value="CM">Cameroon</option>
                                    <option value="CA">Canada</option>
                                    <option value="CV">Cape Verde</option>
                                    <option value="KY">Cayman Islands</option>
                                    <option value="CF">Central African Republic</option>
                                    <option value="TD">Chad</option>
                                    <option value="CL">Chile</option>
                                    <option value="CN">China</option>
                                    <option value="CX">Christmas Island</option>
                                    <option value="CC">Cocos (Keeling) Islands</option>
                                    <option value="CO">Colombia</option>
                                    <option value="KM">Comoros</option>
                                    <option value="CG">Congo</option>
                                    <option value="CD">Congo, Democratic Republic of the Congo</option>
                                    <option value="CK">Cook Islands</option>
                                    <option value="CR">Costa Rica</option>
                                    <option value="CI">Cote D'Ivoire</option>
                                    <option value="HR">Croatia</option>
                                    <option value="CU">Cuba</option>
                                    <option value="CW">Curacao</option>
                                    <option value="CY">Cyprus</option>
                                    <option value="CZ">Czech Republic</option>
                                    <option value="DK">Denmark</option>
                                    <option value="DJ">Djibouti</option>
                                    <option value="DM">Dominica</option>
                                    <option value="DO">Dominican Republic</option>
                                    <option value="EC">Ecuador</option>
                                    <option value="EG">Egypt</option>
                                    <option value="SV">El Salvador</option>
                                    <option value="GQ">Equatorial Guinea</option>
                                    <option value="ER">Eritrea</option>
                                    <option value="EE">Estonia</option>
                                    <option value="ET">Ethiopia</option>
                                    <option value="FK">Falkland Islands (Malvinas)</option>
                                    <option value="FO">Faroe Islands</option>
                                    <option value="FJ">Fiji</option>
                                    <option value="FI">Finland</option>
                                    <option value="FR">France</option>
                                    <option value="GF">French Guiana</option>
                                    <option value="PF">French Polynesia</option>
                                    <option value="TF">French Southern Territories</option>
                                    <option value="GA">Gabon</option>
                                    <option value="GM">Gambia</option>
                                    <option value="GE">Georgia</option>
                                    <option value="DE">Germany</option>
                                    <option value="GH">Ghana</option>
                                    <option value="GI">Gibraltar</option>
                                    <option value="GR">Greece</option>
                                    <option value="GL">Greenland</option>
                                    <option value="GD">Grenada</option>
                                    <option value="GP">Guadeloupe</option>
                                    <option value="GU">Guam</option>
                                    <option value="GT">Guatemala</option>
                                    <option value="GG">Guernsey</option>
                                    <option value="GN">Guinea</option>
                                    <option value="GW">Guinea-Bissau</option>
                                    <option value="GY">Guyana</option>
                                    <option value="HT">Haiti</option>
                                    <option value="HM">Heard Island and Mcdonald Islands</option>
                                    <option value="VA">Holy See (Vatican City State)</option>
                                    <option value="HN">Honduras</option>
                                    <option value="HK">Hong Kong</option>
                                    <option value="HU">Hungary</option>
                                    <option value="IS">Iceland</option>
                                    <option value="IN">India</option>
                                    <option value="ID">Indonesia</option>
                                    <option value="IR">Iran, Islamic Republic of</option>
                                    <option value="IQ">Iraq</option>
                                    <option value="IE">Ireland</option>
                                    <option value="IM">Isle of Man</option>
                                    <option value="IL">Israel</option>
                                    <option value="IT">Italy</option>
                                    <option value="JM">Jamaica</option>
                                    <option value="JP">Japan</option>
                                    <option value="JE">Jersey</option>
                                    <option value="JO">Jordan</option>
                                    <option value="KZ">Kazakhstan</option>
                                    <option value="KE">Kenya</option>
                                    <option value="KI">Kiribati</option>
                                    <option value="KP">Korea, Democratic People's Republic of</option>
                                    <option value="KR">Korea, Republic of</option>
                                    <option value="XK">Kosovo</option>
                                    <option value="KW">Kuwait</option>
                                    <option value="KG">Kyrgyzstan</option>
                                    <option value="LA">Lao People's Democratic Republic</option>
                                    <option value="LV">Latvia</option>
                                    <option value="LB">Lebanon</option>
                                    <option value="LS">Lesotho</option>
                                    <option value="LR">Liberia</option>
                                    <option value="LY">Libyan Arab Jamahiriya</option>
                                    <option value="LI">Liechtenstein</option>
                                    <option value="LT">Lithuania</option>
                                    <option value="LU">Luxembourg</option>
                                    <option value="MO">Macao</option>
                                    <option value="MK">Macedonia, the Former Yugoslav Republic of</option>
                                    <option value="MG">Madagascar</option>
                                    <option value="MW">Malawi</option>
                                    <option value="MY">Malaysia</option>
                                    <option value="MV">Maldives</option>
                                    <option value="ML">Mali</option>
                                    <option value="MT">Malta</option>
                                    <option value="MH">Marshall Islands</option>
                                    <option value="MQ">Martinique</option>
                                    <option value="MR">Mauritania</option>
                                    <option value="MU">Mauritius</option>
                                    <option value="YT">Mayotte</option>
                                    <option value="MX">Mexico</option>
                                    <option value="FM">Micronesia, Federated States of</option>
                                    <option value="MD">Moldova, Republic of</option>
                                    <option value="MC">Monaco</option>
                                    <option value="MN">Mongolia</option>
                                    <option value="ME">Montenegro</option>
                                    <option value="MS">Montserrat</option>
                                    <option value="MA">Morocco</option>
                                    <option value="MZ">Mozambique</option>
                                    <option value="MM">Myanmar</option>
                                    <option value="NA">Namibia</option>
                                    <option value="NR">Nauru</option>
                                    <option value="NP">Nepal</option>
                                    <option value="NL">Netherlands</option>
                                    <option value="AN">Netherlands Antilles</option>
                                    <option value="NC">New Caledonia</option>
                                    <option value="NZ">New Zealand</option>
                                    <option value="NI">Nicaragua</option>
                                    <option value="NE">Niger</option>
                                    <option value="NG">Nigeria</option>
                                    <option value="NU">Niue</option>
                                    <option value="NF">Norfolk Island</option>
                                    <option value="MP">Northern Mariana Islands</option>
                                    <option value="NO">Norway</option>
                                    <option value="OM">Oman</option>
                                    <option value="PK">Pakistan</option>
                                    <option value="PW">Palau</option>
                                    <option value="PS">Palestinian Territory, Occupied</option>
                                    <option value="PA">Panama</option>
                                    <option value="PG">Papua New Guinea</option>
                                    <option value="PY">Paraguay</option>
                                    <option value="PE">Peru</option>
                                    <option value="PH">Philippines</option>
                                    <option value="PN">Pitcairn</option>
                                    <option value="PL">Poland</option>
                                    <option value="PT">Portugal</option>
                                    <option value="PR">Puerto Rico</option>
                                    <option value="QA">Qatar</option>
                                    <option value="RE">Reunion</option>
                                    <option value="RO">Romania</option>
                                    <option value="RU">Russian Federation</option>
                                    <option value="RW">Rwanda</option>
                                    <option value="BL">Saint Barthelemy</option>
                                    <option value="SH">Saint Helena</option>
                                    <option value="KN">Saint Kitts and Nevis</option>
                                    <option value="LC">Saint Lucia</option>
                                    <option value="MF">Saint Martin</option>
                                    <option value="PM">Saint Pierre and Miquelon</option>
                                    <option value="VC">Saint Vincent and the Grenadines</option>
                                    <option value="WS">Samoa</option>
                                    <option value="SM">San Marino</option>
                                    <option value="ST">Sao Tome and Principe</option>
                                    <option value="SA">Saudi Arabia</option>
                                    <option value="SN">Senegal</option>
                                    <option value="RS">Serbia</option>
                                    <option value="CS">Serbia and Montenegro</option>
                                    <option value="SC">Seychelles</option>
                                    <option value="SL">Sierra Leone</option>
                                    <option value="SG">Singapore</option>
                                    <option value="SX">Sint Maarten</option>
                                    <option value="SK">Slovakia</option>
                                    <option value="SI">Slovenia</option>
                                    <option value="SB">Solomon Islands</option>
                                    <option value="SO">Somalia</option>
                                    <option value="ZA">South Africa</option>
                                    <option value="GS">South Georgia and the South Sandwich Islands</option>
                                    <option value="SS">South Sudan</option>
                                    <option value="ES">Spain</option>
                                    <option value="LK">Sri Lanka</option>
                                    <option value="SD">Sudan</option>
                                    <option value="SR">Suriname</option>
                                    <option value="SJ">Svalbard and Jan Mayen</option>
                                    <option value="SZ">Swaziland</option>
                                    <option value="SE">Sweden</option>
                                    <option value="CH">Switzerland</option>
                                    <option value="SY">Syrian Arab Republic</option>
                                    <option value="TW">Taiwan, Province of China</option>
                                    <option value="TJ">Tajikistan</option>
                                    <option value="TZ">Tanzania, United Republic of</option>
                                    <option value="TH">Thailand</option>
                                    <option value="TL">Timor-Leste</option>
                                    <option value="TG">Togo</option>
                                    <option value="TK">Tokelau</option>
                                    <option value="TO">Tonga</option>
                                    <option value="TT">Trinidad and Tobago</option>
                                    <option value="TN">Tunisia</option>
                                    <option value="TR">Turkey</option>
                                    <option value="TM">Turkmenistan</option>
                                    <option value="TC">Turks and Caicos Islands</option>
                                    <option value="TV">Tuvalu</option>
                                    <option value="UG">Uganda</option>
                                    <option value="UA">Ukraine</option>
                                    <option value="AE">United Arab Emirates</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="US">United States</option>
                                    <option value="UM">United States Minor Outlying Islands</option>
                                    <option value="UY">Uruguay</option>
                                    <option value="UZ">Uzbekistan</option>
                                    <option value="VU">Vanuatu</option>
                                    <option value="VE">Venezuela</option>
                                    <option value="VN">Viet Nam</option>
                                    <option value="VG">Virgin Islands, British</option>
                                    <option value="VI">Virgin Islands, U.s.</option>
                                    <option value="WF">Wallis and Futuna</option>
                                    <option value="EH">Western Sahara</option>
                                    <option value="YE">Yemen</option>
                                    <option value="ZM">Zambia</option>
                                    <option value="ZW">Zimbabwe</option>
                                  </select>
                            </div>
                            

                            <div class="form-group">
                                <label for="exampleInputStatus1">Status</label>
                                <select name="status" id="status" class="select-dropdown form-control">
                                    <option value="status" selected disabled>{{__('Select Your Status')}} *</option>
                                    <option value="company">Company</option>
                                    <option value="private">Private</option>
                                    <option value="entrepreneur_microentreprise">Auto Entrepreneur / Microentreprise</option>
                                </select>
                            </div>

                            <div class="form-group" id="company_name">
                                <label for="exampleInputCompanyName1">Company Name </label>
                                <input value="{{old('company_name')}}" type="text" id="exampleInputCompanyName1" name="company_name" class="form-control @error('company_name') is-invalid @enderror" placeholder="{{__('Company Name')}}">
                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group" id="company_id">
                                <label for="exampleInputCompanyID1">Company ID</label>
                                <input type="text" value="{{old('company_id')}}" id="exampleInputCompanyID1" name="company_id" class="form-control @error('company_id') is-invalid @enderror" placeholder="{{__('Company trade registration identification number')}}">
                                @error('company_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="checkbox" id="slave_tools_flag" name="slave_tools_flag" value="slave_tools_flag">
                                <label for="slave_tools_flag"> {{__('I have slave tools.')}}</label><br>
                                <p style="margin-left:0.6rem;font-size:12px;">{{__('Please select at least one reading tool.')}}</p>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputMaster1">Master Tools</label>
                                <div>
                                <select name="master_tools[]" id="master_tools" class="select-dropdown-multi form-control" multiple>
                                    @foreach($masterTools as $tool)
                                        <option value="{{$tool->id}}">{{$tool->name}}</option>
                                    @endforeach
                                    
                                  </select>
                                </div>
                                
                            </div>

                            <div class="form-group">
                                <label for="exampleInputSlave1">Slave Tools</label>
                                <div>
                                <select disabled name="slave_tools[]" id="slave_tools" class="select-dropdown-multi form-control" multiple>
                                    @foreach($slaveTools as $tool)
                                        <option value="{{$tool->id}}">{{$tool->name}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                
                            </div>
                       
                            {!! htmlFormSnippet() !!}
                        
                        <div class="form-group m-t-20">
                            <button type="submit" id="register_form_Register" name="register_form[Register]" class="form-control waves-effect waves-light btn btn-red">{{__('Register')}}</button>
                        </div>
                    </form>
                    <div class="text-center m-t-10">
                        <p>You have an Account? <a href="/login" class="">Sign In</a></p>
                    </div>
                </div> 
        </div>
    </div>
</div>
@endsection

@section('pagespecificscripts')
<script type="text/javascript">
    $( document ).ready(function() {

        $(".select-dropdown-multi").select2({
			closeOnSelect : false,
			placeholder : "{{__('Select Tools')}}",
			// allowHtml: true,
			allowClear: true,
			tags: false // создает новые опции на лету
            
		});

        $(document).on('change', '#status',function() {
            var status = $(this).val();

            if(status != 'company'){
                $('#company_id').addClass('hide');
                $('#company_name').addClass('hide');
            }
            else{
                $('#company_id').removeClass('hide');
                $('#company_name').removeClass('hide');
            }
        });

        $('#slave_tools_flag').click(function() {
            if ($(this).is(':checked')) {
                console.log('checked');
                $("#slave_tools").removeAttr('disabled');
            }
            else {
                console.log('unchecked'); 
                $("#slave_tools").attr("disabled", "disabled");
            }
        });
    });
</script>
@endsection
