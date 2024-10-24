<?php

use ECUApp\SharedCode\Models\User;
use ECUApp\SharedCode\Models\Role;
use ECUApp\SharedCode\Models\Service;
use ECUApp\SharedCode\Models\Tool;
use ECUApp\SharedCode\Models\Vehicle;
use Illuminate\Http\Client\ConnectionException;

if(!function_exists('get_tool_name')){

    function get_tool_name( $id ){

        return Tool::FindOrFail($id)->name;
       
    }
}

if(!function_exists('get_dropdown_image')){

    function get_dropdown_image( $id ){

        $tool = Tool::findOrFail($id);
        if($tool){
            return env('BACKEND_LOCAL_URL')."icons/".$tool->icon;
            // return "https://backend.ecutech.gr/icons/".$tool->icon;
        }
    }
}

if(!function_exists('trim_str')){

    function trim_str( $str ){

        return trim($str);
    }
}

if(!function_exists('get_logo_for_stages_and_options')){

    function get_logo_for_stages_and_options( $str ){

        try{

            // $responseStages = Http::get('http://backend.ecutech.gr/api/get_stages');
            
            // if($responseStages == NULL){
            //     return view('505');      
            // }

            // $stages = json_decode($responseStages->body(), true)['stages'];
            $stages = Service::orderBy('sorting', 'asc')
            ->where('type', 'tunning')->where('tuningx_active', 1)->get();

            // $responseOptions = Http::get('http://backend.ecutech.gr/api/get_options');

            // if($responseOptions == NULL){
            //     return view('505');      
            // }

            // $options = json_decode($responseOptions->body(), true)['options'];

            $options = Service::orderBy('sorting', 'asc')
            ->where('type', 'option')->where('tuningx_active', 1)->get();
            
        }
        catch(ConnectionException $e){
            return view('505');          
        }
       

        foreach($stages as $stage){
            if($stage['name'] == $str)
                return 'https://backend.ecutech.gr/icons/'.$stage['icon'];
        }

        foreach($options as $option){
            if($option['name'] == $str)
                return 'https://backend.ecutech.gr/icons/'.$option['icon'];
        }
        
    }
}

if(!function_exists('get_admin')){

    function get_admin(){
        $admin = Role::where('name', 'admin')->first();
        return User::where('role_id', $admin->id)->first();
    }
}

if(!function_exists('get_head')){

    function get_head(){
        $head = Role::where('name', 'head')->first();
        return User::where('role_id', $head->id)->first();
    }
}

if(!function_exists('country_to_continent')){

    function country_to_continent( $country ){
            $continent = '';
            if( $country == 'AF' ) $continent = 'Asia';
            if( $country == 'AX' ) $continent = 'Europe';
            if( $country == 'AL' ) $continent = 'Europe';
            if( $country == 'DZ' ) $continent = 'Africa';
            if( $country == 'AS' ) $continent = 'Oceania';
            if( $country == 'AD' ) $continent = 'Europe';
            if( $country == 'AO' ) $continent = 'Africa';
            if( $country == 'AI' ) $continent = 'North America';
            if( $country == 'AQ' ) $continent = 'Antarctica';
            if( $country == 'AG' ) $continent = 'North America';
            if( $country == 'AR' ) $continent = 'South America';
            if( $country == 'AM' ) $continent = 'Asia';
            if( $country == 'AW' ) $continent = 'North America';
            if( $country == 'AU' ) $continent = 'Oceania';
            if( $country == 'AT' ) $continent = 'Europe';
            if( $country == 'AZ' ) $continent = 'Asia';
            if( $country == 'BS' ) $continent = 'North America';
            if( $country == 'BH' ) $continent = 'Asia';
            if( $country == 'BD' ) $continent = 'Asia';
            if( $country == 'BB' ) $continent = 'North America';
            if( $country == 'BY' ) $continent = 'Europe';
            if( $country == 'BE' ) $continent = 'Europe';
            if( $country == 'BZ' ) $continent = 'North America';
            if( $country == 'BJ' ) $continent = 'Africa';
            if( $country == 'BM' ) $continent = 'North America';
            if( $country == 'BT' ) $continent = 'Asia';
            if( $country == 'BO' ) $continent = 'South America';
            if( $country == 'BA' ) $continent = 'Europe';
            if( $country == 'BW' ) $continent = 'Africa';
            if( $country == 'BV' ) $continent = 'Antarctica';
            if( $country == 'BR' ) $continent = 'South America';
            if( $country == 'IO' ) $continent = 'Asia';
            if( $country == 'VG' ) $continent = 'North America';
            if( $country == 'BN' ) $continent = 'Asia';
            if( $country == 'BG' ) $continent = 'Europe';
            if( $country == 'BF' ) $continent = 'Africa';
            if( $country == 'BI' ) $continent = 'Africa';
            if( $country == 'KH' ) $continent = 'Asia';
            if( $country == 'CM' ) $continent = 'Africa';
            if( $country == 'CA' ) $continent = 'North America';
            if( $country == 'CV' ) $continent = 'Africa';
            if( $country == 'KY' ) $continent = 'North America';
            if( $country == 'CF' ) $continent = 'Africa';
            if( $country == 'TD' ) $continent = 'Africa';
            if( $country == 'CL' ) $continent = 'South America';
            if( $country == 'CN' ) $continent = 'Asia';
            if( $country == 'CX' ) $continent = 'Asia';
            if( $country == 'CC' ) $continent = 'Asia';
            if( $country == 'CO' ) $continent = 'South America';
            if( $country == 'KM' ) $continent = 'Africa';
            if( $country == 'CD' ) $continent = 'Africa';
            if( $country == 'CG' ) $continent = 'Africa';
            if( $country == 'CK' ) $continent = 'Oceania';
            if( $country == 'CR' ) $continent = 'North America';
            if( $country == 'CI' ) $continent = 'Africa';
            if( $country == 'HR' ) $continent = 'Europe';
            if( $country == 'CU' ) $continent = 'North America';
            if( $country == 'CY' ) $continent = 'Asia';
            if( $country == 'CZ' ) $continent = 'Europe';
            if( $country == 'DK' ) $continent = 'Europe';
            if( $country == 'DJ' ) $continent = 'Africa';
            if( $country == 'DM' ) $continent = 'North America';
            if( $country == 'DO' ) $continent = 'North America';
            if( $country == 'EC' ) $continent = 'South America';
            if( $country == 'EG' ) $continent = 'Africa';
            if( $country == 'SV' ) $continent = 'North America';
            if( $country == 'GQ' ) $continent = 'Africa';
            if( $country == 'ER' ) $continent = 'Africa';
            if( $country == 'EE' ) $continent = 'Europe';
            if( $country == 'ET' ) $continent = 'Africa';
            if( $country == 'FO' ) $continent = 'Europe';
            if( $country == 'FK' ) $continent = 'South America';
            if( $country == 'FJ' ) $continent = 'Oceania';
            if( $country == 'FI' ) $continent = 'Europe';
            if( $country == 'FR' ) $continent = 'Europe';
            if( $country == 'GF' ) $continent = 'South America';
            if( $country == 'PF' ) $continent = 'Oceania';
            if( $country == 'TF' ) $continent = 'Antarctica';
            if( $country == 'GA' ) $continent = 'Africa';
            if( $country == 'GM' ) $continent = 'Africa';
            if( $country == 'GE' ) $continent = 'Asia';
            if( $country == 'DE' ) $continent = 'Europe';
            if( $country == 'GH' ) $continent = 'Africa';
            if( $country == 'GI' ) $continent = 'Europe';
            if( $country == 'GR' ) $continent = 'Europe';
            if( $country == 'GL' ) $continent = 'North America';
            if( $country == 'GD' ) $continent = 'North America';
            if( $country == 'GP' ) $continent = 'North America';
            if( $country == 'GU' ) $continent = 'Oceania';
            if( $country == 'GT' ) $continent = 'North America';
            if( $country == 'GG' ) $continent = 'Europe';
            if( $country == 'GN' ) $continent = 'Africa';
            if( $country == 'GW' ) $continent = 'Africa';
            if( $country == 'GY' ) $continent = 'South America';
            if( $country == 'HT' ) $continent = 'North America';
            if( $country == 'HM' ) $continent = 'Antarctica';
            if( $country == 'VA' ) $continent = 'Europe';
            if( $country == 'HN' ) $continent = 'North America';
            if( $country == 'HK' ) $continent = 'Asia';
            if( $country == 'HU' ) $continent = 'Europe';
            if( $country == 'IS' ) $continent = 'Europe';
            if( $country == 'IN' ) $continent = 'Asia';
            if( $country == 'ID' ) $continent = 'Asia';
            if( $country == 'IR' ) $continent = 'Asia';
            if( $country == 'IQ' ) $continent = 'Asia';
            if( $country == 'IE' ) $continent = 'Europe';
            if( $country == 'IM' ) $continent = 'Europe';
            if( $country == 'IL' ) $continent = 'Asia';
            if( $country == 'IT' ) $continent = 'Europe';
            if( $country == 'JM' ) $continent = 'North America';
            if( $country == 'JP' ) $continent = 'Asia';
            if( $country == 'JE' ) $continent = 'Europe';
            if( $country == 'JO' ) $continent = 'Asia';
            if( $country == 'KZ' ) $continent = 'Asia';
            if( $country == 'KE' ) $continent = 'Africa';
            if( $country == 'KI' ) $continent = 'Oceania';
            if( $country == 'KP' ) $continent = 'Asia';
            if( $country == 'KR' ) $continent = 'Asia';
            if( $country == 'KW' ) $continent = 'Asia';
            if( $country == 'KG' ) $continent = 'Asia';
            if( $country == 'LA' ) $continent = 'Asia';
            if( $country == 'LV' ) $continent = 'Europe';
            if( $country == 'LB' ) $continent = 'Asia';
            if( $country == 'LS' ) $continent = 'Africa';
            if( $country == 'LR' ) $continent = 'Africa';
            if( $country == 'LY' ) $continent = 'Africa';
            if( $country == 'LI' ) $continent = 'Europe';
            if( $country == 'LT' ) $continent = 'Europe';
            if( $country == 'LU' ) $continent = 'Europe';
            if( $country == 'MO' ) $continent = 'Asia';
            if( $country == 'MK' ) $continent = 'Europe';
            if( $country == 'MG' ) $continent = 'Africa';
            if( $country == 'MW' ) $continent = 'Africa';
            if( $country == 'MY' ) $continent = 'Asia';
            if( $country == 'MV' ) $continent = 'Asia';
            if( $country == 'ML' ) $continent = 'Africa';
            if( $country == 'MT' ) $continent = 'Europe';
            if( $country == 'MH' ) $continent = 'Oceania';
            if( $country == 'MQ' ) $continent = 'North America';
            if( $country == 'MR' ) $continent = 'Africa';
            if( $country == 'MU' ) $continent = 'Africa';
            if( $country == 'YT' ) $continent = 'Africa';
            if( $country == 'MX' ) $continent = 'North America';
            if( $country == 'FM' ) $continent = 'Oceania';
            if( $country == 'MD' ) $continent = 'Europe';
            if( $country == 'MC' ) $continent = 'Europe';
            if( $country == 'MN' ) $continent = 'Asia';
            if( $country == 'ME' ) $continent = 'Europe';
            if( $country == 'MS' ) $continent = 'North America';
            if( $country == 'MA' ) $continent = 'Africa';
            if( $country == 'MZ' ) $continent = 'Africa';
            if( $country == 'MM' ) $continent = 'Asia';
            if( $country == 'NA' ) $continent = 'Africa';
            if( $country == 'NR' ) $continent = 'Oceania';
            if( $country == 'NP' ) $continent = 'Asia';
            if( $country == 'AN' ) $continent = 'North America';
            if( $country == 'NL' ) $continent = 'Europe';
            if( $country == 'NC' ) $continent = 'Oceania';
            if( $country == 'NZ' ) $continent = 'Oceania';
            if( $country == 'NI' ) $continent = 'North America';
            if( $country == 'NE' ) $continent = 'Africa';
            if( $country == 'NG' ) $continent = 'Africa';
            if( $country == 'NU' ) $continent = 'Oceania';
            if( $country == 'NF' ) $continent = 'Oceania';
            if( $country == 'MP' ) $continent = 'Oceania';
            if( $country == 'NO' ) $continent = 'Europe';
            if( $country == 'OM' ) $continent = 'Asia';
            if( $country == 'PK' ) $continent = 'Asia';
            if( $country == 'PW' ) $continent = 'Oceania';
            if( $country == 'PS' ) $continent = 'Asia';
            if( $country == 'PA' ) $continent = 'North America';
            if( $country == 'PG' ) $continent = 'Oceania';
            if( $country == 'PY' ) $continent = 'South America';
            if( $country == 'PE' ) $continent = 'South America';
            if( $country == 'PH' ) $continent = 'Asia';
            if( $country == 'PN' ) $continent = 'Oceania';
            if( $country == 'PL' ) $continent = 'Europe';
            if( $country == 'PT' ) $continent = 'Europe';
            if( $country == 'PR' ) $continent = 'North America';
            if( $country == 'QA' ) $continent = 'Asia';
            if( $country == 'RE' ) $continent = 'Africa';
            if( $country == 'RO' ) $continent = 'Europe';
            if( $country == 'RU' ) $continent = 'Europe';
            if( $country == 'RW' ) $continent = 'Africa';
            if( $country == 'BL' ) $continent = 'North America';
            if( $country == 'SH' ) $continent = 'Africa';
            if( $country == 'KN' ) $continent = 'North America';
            if( $country == 'LC' ) $continent = 'North America';
            if( $country == 'MF' ) $continent = 'North America';
            if( $country == 'PM' ) $continent = 'North America';
            if( $country == 'VC' ) $continent = 'North America';
            if( $country == 'WS' ) $continent = 'Oceania';
            if( $country == 'SM' ) $continent = 'Europe';
            if( $country == 'ST' ) $continent = 'Africa';
            if( $country == 'SA' ) $continent = 'Asia';
            if( $country == 'SN' ) $continent = 'Africa';
            if( $country == 'RS' ) $continent = 'Europe';
            if( $country == 'SC' ) $continent = 'Africa';
            if( $country == 'SL' ) $continent = 'Africa';
            if( $country == 'SG' ) $continent = 'Asia';
            if( $country == 'SK' ) $continent = 'Europe';
            if( $country == 'SI' ) $continent = 'Europe';
            if( $country == 'SB' ) $continent = 'Oceania';
            if( $country == 'SO' ) $continent = 'Africa';
            if( $country == 'ZA' ) $continent = 'Africa';
            if( $country == 'GS' ) $continent = 'Antarctica';
            if( $country == 'ES' ) $continent = 'Europe';
            if( $country == 'LK' ) $continent = 'Asia';
            if( $country == 'SD' ) $continent = 'Africa';
            if( $country == 'SR' ) $continent = 'South America';
            if( $country == 'SJ' ) $continent = 'Europe';
            if( $country == 'SZ' ) $continent = 'Africa';
            if( $country == 'SE' ) $continent = 'Europe';
            if( $country == 'CH' ) $continent = 'Europe';
            if( $country == 'SY' ) $continent = 'Asia';
            if( $country == 'TW' ) $continent = 'Asia';
            if( $country == 'TJ' ) $continent = 'Asia';
            if( $country == 'TZ' ) $continent = 'Africa';
            if( $country == 'TH' ) $continent = 'Asia';
            if( $country == 'TL' ) $continent = 'Asia';
            if( $country == 'TG' ) $continent = 'Africa';
            if( $country == 'TK' ) $continent = 'Oceania';
            if( $country == 'TO' ) $continent = 'Oceania';
            if( $country == 'TT' ) $continent = 'North America';
            if( $country == 'TN' ) $continent = 'Africa';
            if( $country == 'TR' ) $continent = 'Asia';
            if( $country == 'TM' ) $continent = 'Asia';
            if( $country == 'TC' ) $continent = 'North America';
            if( $country == 'TV' ) $continent = 'Oceania';
            if( $country == 'UG' ) $continent = 'Africa';
            if( $country == 'UA' ) $continent = 'Europe';
            if( $country == 'AE' ) $continent = 'Asia';
            if( $country == 'GB' ) $continent = 'Europe';
            if( $country == 'US' ) $continent = 'North America';
            if( $country == 'UM' ) $continent = 'Oceania';
            if( $country == 'VI' ) $continent = 'North America';
            if( $country == 'UY' ) $continent = 'South America';
            if( $country == 'UZ' ) $continent = 'Asia';
            if( $country == 'VU' ) $continent = 'Oceania';
            if( $country == 'VE' ) $continent = 'South America';
            if( $country == 'VN' ) $continent = 'Asia';
            if( $country == 'WF' ) $continent = 'Oceania';
            if( $country == 'EH' ) $continent = 'Africa';
            if( $country == 'YE' ) $continent = 'Asia';
            if( $country == 'ZM' ) $continent = 'Africa';
            if( $country == 'ZW' ) $continent = 'Africa';
            return $continent;
        }
    }

    if(!function_exists('get_dropdown_image')){

        function get_dropdown_image( $id ){
    
            $tool = Tool::findOrFail($id);
            if($tool){
                return env('BACKEND_LOCAL_URL')."icons/".$tool->icon;
                // return "https://backend.ecutech.gr/icons/".$tool->icon;
            }
        }
    }

if(!function_exists('get_image_from_brand')){

    function get_image_from_brand( $brand ){
        if(Vehicle::where('make', '=', $brand)->whereNotNull('Brand_image_URL')->first()){
            return Vehicle::where('make', '=', $brand)->whereNotNull('Brand_image_URL')->first()->Brand_image_URL;
        }
        else {
            return env('BACKEND_URL').'/icons/logos/logo_white.png';
        }
    }
}

if(!function_exists('code_to_country')){

    function code_to_country( $code ){
    
        if($code == ''){
            return '';
        }
    
        $code = strtoupper($code);
        $countryList = array(
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas the',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island (Bouvetoya)',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory (Chagos Archipelago)',
            'VG' => 'British Virgin Islands',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros the',
            'CD' => 'Congo',
            'CG' => 'Congo the',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote d\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FO' => 'Faroe Islands',
            'FK' => 'Falkland Islands (Malvinas)',
            'FJ' => 'Fiji the Fiji Islands',
            'FI' => 'Finland',
            'FR' => 'France, French Republic',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia the',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island and McDonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KP' => 'Korea',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyz Republic',
            'LA' => 'Lao',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'AN' => 'Netherlands Antilles',
            'NL' => 'Netherlands the',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn Islands',
            'PL' => 'Poland',
            'PT' => 'Portugal, Portuguese Republic',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia (Slovak Republic)',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia, Somali Republic',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard & Jan Mayen Islands',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland, Swiss Confederation',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks and Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States of America',
            'UM' => 'United States Minor Outlying Islands',
            'VI' => 'United States Virgin Islands',
            'UY' => 'Uruguay, Eastern Republic of',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe'
        );
        
        return array_key_exists($code, $countryList) ? $countryList[$code] : $code;
    
    //    if( !$countryList[$code] ) return $code;
     // else return $countryList[$code];
        
        }
    }


?>