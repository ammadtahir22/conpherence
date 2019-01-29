<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\SpacesType;
use App\Models\Site\Accessibility;
use App\Models\Site\Amenities;
use App\Models\Site\BookingInfo;
use App\Models\Site\Company;
use App\Models\Site\Review;
use App\Models\Site\SittingPlan;
use App\Models\Site\Spaces;
use App\Models\Site\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check.type.company');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function dashboard()
    {
//        $dates = collect();
//        foreach( range( -6, 0 ) AS $i ) {
//            $date = Carbon::now()->addDays( $i )->format( 'Y-m-d' );
//            $dates->put( $date, 0);
//        }
//
//        // Get the booking counts
//        $bookings = BookingInfo::where('hotel_owner_id', Auth::user()->id)->where('status' , 2)
//            ->where( 'created_at', '>=', $dates->keys()->first() )
//            ->groupBy( 'created_at' )
//            ->orderBy( 'created_at' )
//            ->get( [
//                DB::raw( 'DATE( created_at ) as date' ),
//                DB::raw( 'COUNT( * ) as "count"' )
//            ] )
//            ->pluck( 'count', 'date' );
//
////              dd($bookings);
//
//        // Merge the two collections; any results in `$posts` will overwrite the zero-value in `$dates`
//        $dates = $dates->merge( $bookings );
//
//        $arr = [];
//
//        foreach ($dates as $key=>$date_a)
//        {
//            $inner = [];
//            $inner['date'] = $key;
//            $inner['count'] = $date_a;
//
//            $arr[] = $inner;
//        }

//        dd($arr);
////
//        dd(response()->json($arr));

        $bookings = BookingInfo::where('hotel_owner_id', Auth::user()->id)->where('status' , 1)->whereDate('start_date' , '>=' , Carbon::today())->get();

        $space_ids = [];

        if(Auth::check())
        {
            foreach (Auth::user()->company->venues as $venue)
            {
                foreach ($venue->spaces as $space)
                {
                    $space_ids[] = $space->id;
                }
            }
        }
//        dd($space_ids);

        $reviews = Review::whereIn('space_id' , $space_ids)->where('r_status' , '1')->orderBy('created_at','desc')->take(3)->get();

        $date = [];

        foreach ($bookings as $booking)
        {
            $date[] = date('Y-m-d',strtotime($booking->start_date));
            $booking['venue_title'] = get_venue_title($booking->venue_id);
            $booking['space_title'] = get_space_title($booking->space_id);
            $booking['venue_city'] = get_city_by_venue($booking->venue_id);
            $booking['space_reviews_avg'] = get_space_reviews_avg($booking->space_id);
            $booking['space_reviews_count'] = get_space_reviews_count($booking->space_id);
        }
        return view('site/companies/dashboard_pages/dashboard', compact('bookings','date' , 'reviews'));

    }

    public function get_chart_data()
    {
        Carbon::useMonthsOverflow(false);
        $first_day = new Carbon('first day of this month');
        $end_month = new Carbon('last day of this month');

        $count = $first_day->diffInDays($end_month) + 1;

        $dates = collect();

        for($i=0; $i <= $count; $i++){
            $f_day = new Carbon('first day of this month');
            $date = $f_day->addDay( $i )->format( 'Y-m-d' );

            $l_day = new Carbon('last day of this month');

            $dates->put( $date, 0);
            if($date == $l_day->format( 'Y-m-d' )){
                break;
            }
        }

        // Get the booking counts
        $bookings = BookingInfo::where('hotel_owner_id', Auth::user()->id)->where('status' , 1)
            ->where( 'created_at', '>=', $dates->keys()->first() )
            ->groupBy( 'created_at' )
            ->orderBy( 'created_at' )
            ->get( [
                DB::raw( 'DATE( created_at ) as date' ),
                DB::raw( 'COUNT( * ) as "count"' )
            ] )
            ->pluck( 'count', 'date' );

        // Merge the two collections; any results in `$booking` will overwrite the zero-value in `$dates`
        $dates = $dates->merge( $bookings );

        $arr = [];

        foreach ($dates as $key=>$date_a)
        {
            $inner = [];
            $inner['date'] = $key;
            $inner['count'] = $date_a;

            $arr[] = $inner;
        }

        return response()->json($arr);
    }

    public function get_profile(){
        $company = Company::where('user_id', Auth::user()->id)->first();

        $years = array_combine(range(date("Y"), 1900), range(date("Y"), 1900));

        $months = array_combine(array("01","02","03","04","05","06","07","08","09","10","11","12"), array("January","February","March","April","May","June","July","August","September","October","November","December")) ;

        $timezones = array(
            'Pacific/Midway'       => "(GMT-11:00) Midway Island",
            'US/Samoa'             => "(GMT-11:00) Samoa",
            'US/Hawaii'            => "(GMT-10:00) Hawaii",
            'US/Alaska'            => "(GMT-09:00) Alaska",
            'US/Pacific'           => "(GMT-08:00) Pacific Time (US &amp; Canada)",
            'America/Tijuana'      => "(GMT-08:00) Tijuana",
            'US/Arizona'           => "(GMT-07:00) Arizona",
            'US/Mountain'          => "(GMT-07:00) Mountain Time (US &amp; Canada)",
            'America/Chihuahua'    => "(GMT-07:00) Chihuahua",
            'America/Mazatlan'     => "(GMT-07:00) Mazatlan",
            'America/Mexico_City'  => "(GMT-06:00) Mexico City",
            'America/Monterrey'    => "(GMT-06:00) Monterrey",
            'Canada/Saskatchewan'  => "(GMT-06:00) Saskatchewan",
            'US/Central'           => "(GMT-06:00) Central Time (US &amp; Canada)",
            'US/Eastern'           => "(GMT-05:00) Eastern Time (US &amp; Canada)",
            'US/East-Indiana'      => "(GMT-05:00) Indiana (East)",
            'America/Bogota'       => "(GMT-05:00) Bogota",
            'America/Lima'         => "(GMT-05:00) Lima",
            'America/Caracas'      => "(GMT-04:30) Caracas",
            'Canada/Atlantic'      => "(GMT-04:00) Atlantic Time (Canada)",
            'America/La_Paz'       => "(GMT-04:00) La Paz",
            'America/Santiago'     => "(GMT-04:00) Santiago",
            'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
            'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
            'Greenland'            => "(GMT-03:00) Greenland",
            'Atlantic/Stanley'     => "(GMT-02:00) Stanley",
            'Atlantic/Azores'      => "(GMT-01:00) Azores",
            'Atlantic/Cape_Verde'  => "(GMT-01:00) Cape Verde Is.",
            'Africa/Casablanca'    => "(GMT) Casablanca",
            'Europe/Dublin'        => "(GMT) Dublin",
            'Europe/Lisbon'        => "(GMT) Lisbon",
            'Europe/London'        => "(GMT) London",
            'Africa/Monrovia'      => "(GMT) Monrovia",
            'Europe/Amsterdam'     => "(GMT+01:00) Amsterdam",
            'Europe/Belgrade'      => "(GMT+01:00) Belgrade",
            'Europe/Berlin'        => "(GMT+01:00) Berlin",
            'Europe/Bratislava'    => "(GMT+01:00) Bratislava",
            'Europe/Brussels'      => "(GMT+01:00) Brussels",
            'Europe/Budapest'      => "(GMT+01:00) Budapest",
            'Europe/Copenhagen'    => "(GMT+01:00) Copenhagen",
            'Europe/Ljubljana'     => "(GMT+01:00) Ljubljana",
            'Europe/Madrid'        => "(GMT+01:00) Madrid",
            'Europe/Paris'         => "(GMT+01:00) Paris",
            'Europe/Prague'        => "(GMT+01:00) Prague",
            'Europe/Rome'          => "(GMT+01:00) Rome",
            'Europe/Sarajevo'      => "(GMT+01:00) Sarajevo",
            'Europe/Skopje'        => "(GMT+01:00) Skopje",
            'Europe/Stockholm'     => "(GMT+01:00) Stockholm",
            'Europe/Vienna'        => "(GMT+01:00) Vienna",
            'Europe/Warsaw'        => "(GMT+01:00) Warsaw",
            'Europe/Zagreb'        => "(GMT+01:00) Zagreb",
            'Europe/Athens'        => "(GMT+02:00) Athens",
            'Europe/Bucharest'     => "(GMT+02:00) Bucharest",
            'Africa/Cairo'         => "(GMT+02:00) Cairo",
            'Africa/Harare'        => "(GMT+02:00) Harare",
            'Europe/Helsinki'      => "(GMT+02:00) Helsinki",
            'Europe/Istanbul'      => "(GMT+02:00) Istanbul",
            'Asia/Jerusalem'       => "(GMT+02:00) Jerusalem",
            'Europe/Kiev'          => "(GMT+02:00) Kyiv",
            'Europe/Minsk'         => "(GMT+02:00) Minsk",
            'Europe/Riga'          => "(GMT+02:00) Riga",
            'Europe/Sofia'         => "(GMT+02:00) Sofia",
            'Europe/Tallinn'       => "(GMT+02:00) Tallinn",
            'Europe/Vilnius'       => "(GMT+02:00) Vilnius",
            'Asia/Baghdad'         => "(GMT+03:00) Baghdad",
            'Asia/Kuwait'          => "(GMT+03:00) Kuwait",
            'Africa/Nairobi'       => "(GMT+03:00) Nairobi",
            'Asia/Riyadh'          => "(GMT+03:00) Riyadh",
            'Europe/Moscow'        => "(GMT+03:00) Moscow",
            'Asia/Tehran'          => "(GMT+03:30) Tehran",
            'Asia/Baku'            => "(GMT+04:00) Baku",
            'Europe/Volgograd'     => "(GMT+04:00) Volgograd",
            'Asia/Muscat'          => "(GMT+04:00) Muscat",
            'Asia/Tbilisi'         => "(GMT+04:00) Tbilisi",
            'Asia/Yerevan'         => "(GMT+04:00) Yerevan",
            'Asia/Kabul'           => "(GMT+04:30) Kabul",
            'Asia/Karachi'         => "(GMT+05:00) Karachi",
            'Asia/Tashkent'        => "(GMT+05:00) Tashkent",
            'Asia/Kolkata'         => "(GMT+05:30) Kolkata",
            'Asia/Kathmandu'       => "(GMT+05:45) Kathmandu",
            'Asia/Yekaterinburg'   => "(GMT+06:00) Ekaterinburg",
            'Asia/Almaty'          => "(GMT+06:00) Almaty",
            'Asia/Dhaka'           => "(GMT+06:00) Dhaka",
            'Asia/Novosibirsk'     => "(GMT+07:00) Novosibirsk",
            'Asia/Bangkok'         => "(GMT+07:00) Bangkok",
            'Asia/Jakarta'         => "(GMT+07:00) Jakarta",
            'Asia/Krasnoyarsk'     => "(GMT+08:00) Krasnoyarsk",
            'Asia/Chongqing'       => "(GMT+08:00) Chongqing",
            'Asia/Hong_Kong'       => "(GMT+08:00) Hong Kong",
            'Asia/Kuala_Lumpur'    => "(GMT+08:00) Kuala Lumpur",
            'Australia/Perth'      => "(GMT+08:00) Perth",
            'Asia/Singapore'       => "(GMT+08:00) Singapore",
            'Asia/Taipei'          => "(GMT+08:00) Taipei",
            'Asia/Ulaanbaatar'     => "(GMT+08:00) Ulaan Bataar",
            'Asia/Urumqi'          => "(GMT+08:00) Urumqi",
            'Asia/Irkutsk'         => "(GMT+09:00) Irkutsk",
            'Asia/Seoul'           => "(GMT+09:00) Seoul",
            'Asia/Tokyo'           => "(GMT+09:00) Tokyo",
            'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
            'Australia/Darwin'     => "(GMT+09:30) Darwin",
            'Asia/Yakutsk'         => "(GMT+10:00) Yakutsk",
            'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
            'Australia/Canberra'   => "(GMT+10:00) Canberra",
            'Pacific/Guam'         => "(GMT+10:00) Guam",
            'Australia/Hobart'     => "(GMT+10:00) Hobart",
            'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
            'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
            'Australia/Sydney'     => "(GMT+10:00) Sydney",
            'Asia/Vladivostok'     => "(GMT+11:00) Vladivostok",
            'Asia/Magadan'         => "(GMT+12:00) Magadan",
            'Pacific/Auckland'     => "(GMT+12:00) Auckland",
            'Pacific/Fiji'         => "(GMT+12:00) Fiji",
        );

        $languages = array(
            'en' => 'English' ,
            'aa' => 'Afar' ,
            'ab' => 'Abkhazian' ,
            'af' => 'Afrikaans' ,
            'am' => 'Amharic' ,
            'ar' => 'Arabic' ,
            'as' => 'Assamese' ,
            'ay' => 'Aymara' ,
            'az' => 'Azerbaijani' ,
            'ba' => 'Bashkir' ,
            'be' => 'Byelorussian' ,
            'bg' => 'Bulgarian' ,
            'bh' => 'Bihari' ,
            'bi' => 'Bislama' ,
            'bn' => 'Bengali/Bangla' ,
            'bo' => 'Tibetan' ,
            'br' => 'Breton' ,
            'ca' => 'Catalan' ,
            'co' => 'Corsican' ,
            'cs' => 'Czech' ,
            'cy' => 'Welsh' ,
            'da' => 'Danish' ,
            'de' => 'German' ,
            'dz' => 'Bhutani' ,
            'el' => 'Greek' ,
            'eo' => 'Esperanto' ,
            'es' => 'Spanish' ,
            'et' => 'Estonian' ,
            'eu' => 'Basque' ,
            'fa' => 'Persian' ,
            'fi' => 'Finnish' ,
            'fj' => 'Fiji' ,
            'fo' => 'Faeroese' ,
            'fr' => 'French' ,
            'fy' => 'Frisian' ,
            'ga' => 'Irish' ,
            'gd' => 'Scots/Gaelic' ,
            'gl' => 'Galician' ,
            'gn' => 'Guarani' ,
            'gu' => 'Gujarati' ,
            'ha' => 'Hausa' ,
            'hi' => 'Hindi' ,
            'hr' => 'Croatian' ,
            'hu' => 'Hungarian' ,
            'hy' => 'Armenian' ,
            'ia' => 'Interlingua' ,
            'ie' => 'Interlingue' ,
            'ik' => 'Inupiak' ,
            'in' => 'Indonesian' ,
            'is' => 'Icelandic' ,
            'it' => 'Italian' ,
            'iw' => 'Hebrew' ,
            'ja' => 'Japanese' ,
            'ji' => 'Yiddish' ,
            'jw' => 'Javanese' ,
            'ka' => 'Georgian' ,
            'kk' => 'Kazakh' ,
            'kl' => 'Greenlandic' ,
            'km' => 'Cambodian' ,
            'kn' => 'Kannada' ,
            'ko' => 'Korean' ,
            'ks' => 'Kashmiri' ,
            'ku' => 'Kurdish' ,
            'ky' => 'Kirghiz' ,
            'la' => 'Latin' ,
            'ln' => 'Lingala' ,
            'lo' => 'Laothian' ,
            'lt' => 'Lithuanian' ,
            'lv' => 'Latvian/Lettish' ,
            'mg' => 'Malagasy' ,
            'mi' => 'Maori' ,
            'mk' => 'Macedonian' ,
            'ml' => 'Malayalam' ,
            'mn' => 'Mongolian' ,
            'mo' => 'Moldavian' ,
            'mr' => 'Marathi' ,
            'ms' => 'Malay' ,
            'mt' => 'Maltese' ,
            'my' => 'Burmese' ,
            'na' => 'Nauru' ,
            'ne' => 'Nepali' ,
            'nl' => 'Dutch' ,
            'no' => 'Norwegian' ,
            'oc' => 'Occitan' ,
            'om' => '(Afan)/Oromoor/Oriya' ,
            'pa' => 'Punjabi' ,
            'pl' => 'Polish' ,
            'ps' => 'Pashto/Pushto' ,
            'pt' => 'Portuguese' ,
            'qu' => 'Quechua' ,
            'rm' => 'Rhaeto-Romance' ,
            'rn' => 'Kirundi' ,
            'ro' => 'Romanian' ,
            'ru' => 'Russian' ,
            'rw' => 'Kinyarwanda' ,
            'sa' => 'Sanskrit' ,
            'sd' => 'Sindhi' ,
            'sg' => 'Sangro' ,
            'sh' => 'Serbo-Croatian' ,
            'si' => 'Singhalese' ,
            'sk' => 'Slovak' ,
            'sl' => 'Slovenian' ,
            'sm' => 'Samoan' ,
            'sn' => 'Shona' ,
            'so' => 'Somali' ,
            'sq' => 'Albanian' ,
            'sr' => 'Serbian' ,
            'ss' => 'Siswati' ,
            'st' => 'Sesotho' ,
            'su' => 'Sundanese' ,
            'sv' => 'Swedish' ,
            'sw' => 'Swahili' ,
            'ta' => 'Tamil' ,
            'te' => 'Tegulu' ,
            'tg' => 'Tajik' ,
            'th' => 'Thai' ,
            'ti' => 'Tigrinya' ,
            'tk' => 'Turkmen' ,
            'tl' => 'Tagalog' ,
            'tn' => 'Setswana' ,
            'to' => 'Tonga' ,
            'tr' => 'Turkish' ,
            'ts' => 'Tsonga' ,
            'tt' => 'Tatar' ,
            'tw' => 'Twi' ,
            'uk' => 'Ukrainian' ,
            'ur' => 'Urdu' ,
            'uz' => 'Uzbek' ,
            'vi' => 'Vietnamese' ,
            'vo' => 'Volapuk' ,
            'wo' => 'Wolof' ,
            'xh' => 'Xhosa' ,
            'yo' => 'Yoruba' ,
            'zh' => 'Chinese' ,
            'zu' => 'Zulu' ,
        );

        $currencies = array (
            'ALL' => 'Albania Lek',
            'AFN' => 'Afghanistan Afghani',
            'ARS' => 'Argentina Peso',
            'AWG' => 'Aruba Guilder',
            'AUD' => 'Australia Dollar',
            'AZN' => 'Azerbaijan New Manat',
            'BSD' => 'Bahamas Dollar',
            'BBD' => 'Barbados Dollar',
            'BDT' => 'Bangladeshi taka',
            'BYR' => 'Belarus Ruble',
            'BZD' => 'Belize Dollar',
            'BMD' => 'Bermuda Dollar',
            'BOB' => 'Bolivia Boliviano',
            'BAM' => 'Bosnia and Herzegovina Convertible Marka',
            'BWP' => 'Botswana Pula',
            'BGN' => 'Bulgaria Lev',
            'BRL' => 'Brazil Real',
            'BND' => 'Brunei Darussalam Dollar',
            'KHR' => 'Cambodia Riel',
            'CAD' => 'Canada Dollar',
            'KYD' => 'Cayman Islands Dollar',
            'CLP' => 'Chile Peso',
            'CNY' => 'China Yuan Renminbi',
            'COP' => 'Colombia Peso',
            'CRC' => 'Costa Rica Colon',
            'HRK' => 'Croatia Kuna',
            'CUP' => 'Cuba Peso',
            'CZK' => 'Czech Republic Koruna',
            'DKK' => 'Denmark Krone',
            'DOP' => 'Dominican Republic Peso',
            'XCD' => 'East Caribbean Dollar',
            'EGP' => 'Egypt Pound',
            'SVC' => 'El Salvador Colon',
            'EEK' => 'Estonia Kroon',
            'EUR' => 'Euro Member Countries',
            'FKP' => 'Falkland Islands (Malvinas) Pound',
            'FJD' => 'Fiji Dollar',
            'GHC' => 'Ghana Cedis',
            'GIP' => 'Gibraltar Pound',
            'GTQ' => 'Guatemala Quetzal',
            'GGP' => 'Guernsey Pound',
            'GYD' => 'Guyana Dollar',
            'HNL' => 'Honduras Lempira',
            'HKD' => 'Hong Kong Dollar',
            'HUF' => 'Hungary Forint',
            'ISK' => 'Iceland Krona',
            'INR' => 'India Rupee',
            'IDR' => 'Indonesia Rupiah',
            'IRR' => 'Iran Rial',
            'IMP' => 'Isle of Man Pound',
            'ILS' => 'Israel Shekel',
            'JMD' => 'Jamaica Dollar',
            'JPY' => 'Japan Yen',
            'JEP' => 'Jersey Pound',
            'KZT' => 'Kazakhstan Tenge',
            'KPW' => 'Korea (North) Won',
            'KRW' => 'Korea (South) Won',
            'KGS' => 'Kyrgyzstan Som',
            'LAK' => 'Laos Kip',
            'LVL' => 'Latvia Lat',
            'LBP' => 'Lebanon Pound',
            'LRD' => 'Liberia Dollar',
            'LTL' => 'Lithuania Litas',
            'MKD' => 'Macedonia Denar',
            'MYR' => 'Malaysia Ringgit',
            'MUR' => 'Mauritius Rupee',
            'MXN' => 'Mexico Peso',
            'MNT' => 'Mongolia Tughrik',
            'MZN' => 'Mozambique Metical',
            'NAD' => 'Namibia Dollar',
            'NPR' => 'Nepal Rupee',
            'ANG' => 'Netherlands Antilles Guilder',
            'NZD' => 'New Zealand Dollar',
            'NIO' => 'Nicaragua Cordoba',
            'NGN' => 'Nigeria Naira',
            'NOK' => 'Norway Krone',
            'OMR' => 'Oman Rial',
            'PKR' => 'Pakistan Rupee',
            'PAB' => 'Panama Balboa',
            'PYG' => 'Paraguay Guarani',
            'PEN' => 'Peru Nuevo Sol',
            'PHP' => 'Philippines Peso',
            'PLN' => 'Poland Zloty',
            'QAR' => 'Qatar Riyal',
            'RON' => 'Romania New Leu',
            'RUB' => 'Russia Ruble',
            'SHP' => 'Saint Helena Pound',
            'SAR' => 'Saudi Arabia Riyal',
            'RSD' => 'Serbia Dinar',
            'SCR' => 'Seychelles Rupee',
            'SGD' => 'Singapore Dollar',
            'SBD' => 'Solomon Islands Dollar',
            'SOS' => 'Somalia Shilling',
            'ZAR' => 'South Africa Rand',
            'LKR' => 'Sri Lanka Rupee',
            'SEK' => 'Sweden Krona',
            'CHF' => 'Switzerland Franc',
            'SRD' => 'Suriname Dollar',
            'SYP' => 'Syria Pound',
            'TWD' => 'Taiwan New Dollar',
            'THB' => 'Thailand Baht',
            'TTD' => 'Trinidad and Tobago Dollar',
            'TRY' => 'Turkey Lira',
            'TRL' => 'Turkey Lira',
            'TVD' => 'Tuvalu Dollar',
            'UAH' => 'Ukraine Hryvna',
            'GBP' => 'United Kingdom Pound',
            'UGX' => 'Uganda Shilling',
            'USD' => 'United States Dollar',
            'UYU' => 'Uruguay Peso',
            'UZS' => 'Uzbekistan Som',
            'VEF' => 'Venezuela Bolivar',
            'VND' => 'Viet Nam Dong',
            'YER' => 'Yemen Rial',
            'ZWD' => 'Zimbabwe Dollar'
        );
        return view('site/companies/dashboard_pages/profile', compact('company','years','months','timezones','languages' ,'currencies'));
    }

    public function get_payment(){
        $company = Company::where('user_id', Auth::user()->id)->first();

        $years = array_combine(range(date("Y"), 1900), range(date("Y"), 1900));

        $months = array_combine(array("01","02","03","04","05","06","07","08","09","10","11","12"), array("January","February","March","April","May","June","July","August","September","October","November","December")) ;

        $timezones = array(
            'Pacific/Midway'       => "(GMT-11:00) Midway Island",
            'US/Samoa'             => "(GMT-11:00) Samoa",
            'US/Hawaii'            => "(GMT-10:00) Hawaii",
            'US/Alaska'            => "(GMT-09:00) Alaska",
            'US/Pacific'           => "(GMT-08:00) Pacific Time (US &amp; Canada)",
            'America/Tijuana'      => "(GMT-08:00) Tijuana",
            'US/Arizona'           => "(GMT-07:00) Arizona",
            'US/Mountain'          => "(GMT-07:00) Mountain Time (US &amp; Canada)",
            'America/Chihuahua'    => "(GMT-07:00) Chihuahua",
            'America/Mazatlan'     => "(GMT-07:00) Mazatlan",
            'America/Mexico_City'  => "(GMT-06:00) Mexico City",
            'America/Monterrey'    => "(GMT-06:00) Monterrey",
            'Canada/Saskatchewan'  => "(GMT-06:00) Saskatchewan",
            'US/Central'           => "(GMT-06:00) Central Time (US &amp; Canada)",
            'US/Eastern'           => "(GMT-05:00) Eastern Time (US &amp; Canada)",
            'US/East-Indiana'      => "(GMT-05:00) Indiana (East)",
            'America/Bogota'       => "(GMT-05:00) Bogota",
            'America/Lima'         => "(GMT-05:00) Lima",
            'America/Caracas'      => "(GMT-04:30) Caracas",
            'Canada/Atlantic'      => "(GMT-04:00) Atlantic Time (Canada)",
            'America/La_Paz'       => "(GMT-04:00) La Paz",
            'America/Santiago'     => "(GMT-04:00) Santiago",
            'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
            'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
            'Greenland'            => "(GMT-03:00) Greenland",
            'Atlantic/Stanley'     => "(GMT-02:00) Stanley",
            'Atlantic/Azores'      => "(GMT-01:00) Azores",
            'Atlantic/Cape_Verde'  => "(GMT-01:00) Cape Verde Is.",
            'Africa/Casablanca'    => "(GMT) Casablanca",
            'Europe/Dublin'        => "(GMT) Dublin",
            'Europe/Lisbon'        => "(GMT) Lisbon",
            'Europe/London'        => "(GMT) London",
            'Africa/Monrovia'      => "(GMT) Monrovia",
            'Europe/Amsterdam'     => "(GMT+01:00) Amsterdam",
            'Europe/Belgrade'      => "(GMT+01:00) Belgrade",
            'Europe/Berlin'        => "(GMT+01:00) Berlin",
            'Europe/Bratislava'    => "(GMT+01:00) Bratislava",
            'Europe/Brussels'      => "(GMT+01:00) Brussels",
            'Europe/Budapest'      => "(GMT+01:00) Budapest",
            'Europe/Copenhagen'    => "(GMT+01:00) Copenhagen",
            'Europe/Ljubljana'     => "(GMT+01:00) Ljubljana",
            'Europe/Madrid'        => "(GMT+01:00) Madrid",
            'Europe/Paris'         => "(GMT+01:00) Paris",
            'Europe/Prague'        => "(GMT+01:00) Prague",
            'Europe/Rome'          => "(GMT+01:00) Rome",
            'Europe/Sarajevo'      => "(GMT+01:00) Sarajevo",
            'Europe/Skopje'        => "(GMT+01:00) Skopje",
            'Europe/Stockholm'     => "(GMT+01:00) Stockholm",
            'Europe/Vienna'        => "(GMT+01:00) Vienna",
            'Europe/Warsaw'        => "(GMT+01:00) Warsaw",
            'Europe/Zagreb'        => "(GMT+01:00) Zagreb",
            'Europe/Athens'        => "(GMT+02:00) Athens",
            'Europe/Bucharest'     => "(GMT+02:00) Bucharest",
            'Africa/Cairo'         => "(GMT+02:00) Cairo",
            'Africa/Harare'        => "(GMT+02:00) Harare",
            'Europe/Helsinki'      => "(GMT+02:00) Helsinki",
            'Europe/Istanbul'      => "(GMT+02:00) Istanbul",
            'Asia/Jerusalem'       => "(GMT+02:00) Jerusalem",
            'Europe/Kiev'          => "(GMT+02:00) Kyiv",
            'Europe/Minsk'         => "(GMT+02:00) Minsk",
            'Europe/Riga'          => "(GMT+02:00) Riga",
            'Europe/Sofia'         => "(GMT+02:00) Sofia",
            'Europe/Tallinn'       => "(GMT+02:00) Tallinn",
            'Europe/Vilnius'       => "(GMT+02:00) Vilnius",
            'Asia/Baghdad'         => "(GMT+03:00) Baghdad",
            'Asia/Kuwait'          => "(GMT+03:00) Kuwait",
            'Africa/Nairobi'       => "(GMT+03:00) Nairobi",
            'Asia/Riyadh'          => "(GMT+03:00) Riyadh",
            'Europe/Moscow'        => "(GMT+03:00) Moscow",
            'Asia/Tehran'          => "(GMT+03:30) Tehran",
            'Asia/Baku'            => "(GMT+04:00) Baku",
            'Europe/Volgograd'     => "(GMT+04:00) Volgograd",
            'Asia/Muscat'          => "(GMT+04:00) Muscat",
            'Asia/Tbilisi'         => "(GMT+04:00) Tbilisi",
            'Asia/Yerevan'         => "(GMT+04:00) Yerevan",
            'Asia/Kabul'           => "(GMT+04:30) Kabul",
            'Asia/Karachi'         => "(GMT+05:00) Karachi",
            'Asia/Tashkent'        => "(GMT+05:00) Tashkent",
            'Asia/Kolkata'         => "(GMT+05:30) Kolkata",
            'Asia/Kathmandu'       => "(GMT+05:45) Kathmandu",
            'Asia/Yekaterinburg'   => "(GMT+06:00) Ekaterinburg",
            'Asia/Almaty'          => "(GMT+06:00) Almaty",
            'Asia/Dhaka'           => "(GMT+06:00) Dhaka",
            'Asia/Novosibirsk'     => "(GMT+07:00) Novosibirsk",
            'Asia/Bangkok'         => "(GMT+07:00) Bangkok",
            'Asia/Jakarta'         => "(GMT+07:00) Jakarta",
            'Asia/Krasnoyarsk'     => "(GMT+08:00) Krasnoyarsk",
            'Asia/Chongqing'       => "(GMT+08:00) Chongqing",
            'Asia/Hong_Kong'       => "(GMT+08:00) Hong Kong",
            'Asia/Kuala_Lumpur'    => "(GMT+08:00) Kuala Lumpur",
            'Australia/Perth'      => "(GMT+08:00) Perth",
            'Asia/Singapore'       => "(GMT+08:00) Singapore",
            'Asia/Taipei'          => "(GMT+08:00) Taipei",
            'Asia/Ulaanbaatar'     => "(GMT+08:00) Ulaan Bataar",
            'Asia/Urumqi'          => "(GMT+08:00) Urumqi",
            'Asia/Irkutsk'         => "(GMT+09:00) Irkutsk",
            'Asia/Seoul'           => "(GMT+09:00) Seoul",
            'Asia/Tokyo'           => "(GMT+09:00) Tokyo",
            'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
            'Australia/Darwin'     => "(GMT+09:30) Darwin",
            'Asia/Yakutsk'         => "(GMT+10:00) Yakutsk",
            'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
            'Australia/Canberra'   => "(GMT+10:00) Canberra",
            'Pacific/Guam'         => "(GMT+10:00) Guam",
            'Australia/Hobart'     => "(GMT+10:00) Hobart",
            'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
            'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
            'Australia/Sydney'     => "(GMT+10:00) Sydney",
            'Asia/Vladivostok'     => "(GMT+11:00) Vladivostok",
            'Asia/Magadan'         => "(GMT+12:00) Magadan",
            'Pacific/Auckland'     => "(GMT+12:00) Auckland",
            'Pacific/Fiji'         => "(GMT+12:00) Fiji",
        );

        $languages = array(
            'en' => 'English' ,
            'aa' => 'Afar' ,
            'ab' => 'Abkhazian' ,
            'af' => 'Afrikaans' ,
            'am' => 'Amharic' ,
            'ar' => 'Arabic' ,
            'as' => 'Assamese' ,
            'ay' => 'Aymara' ,
            'az' => 'Azerbaijani' ,
            'ba' => 'Bashkir' ,
            'be' => 'Byelorussian' ,
            'bg' => 'Bulgarian' ,
            'bh' => 'Bihari' ,
            'bi' => 'Bislama' ,
            'bn' => 'Bengali/Bangla' ,
            'bo' => 'Tibetan' ,
            'br' => 'Breton' ,
            'ca' => 'Catalan' ,
            'co' => 'Corsican' ,
            'cs' => 'Czech' ,
            'cy' => 'Welsh' ,
            'da' => 'Danish' ,
            'de' => 'German' ,
            'dz' => 'Bhutani' ,
            'el' => 'Greek' ,
            'eo' => 'Esperanto' ,
            'es' => 'Spanish' ,
            'et' => 'Estonian' ,
            'eu' => 'Basque' ,
            'fa' => 'Persian' ,
            'fi' => 'Finnish' ,
            'fj' => 'Fiji' ,
            'fo' => 'Faeroese' ,
            'fr' => 'French' ,
            'fy' => 'Frisian' ,
            'ga' => 'Irish' ,
            'gd' => 'Scots/Gaelic' ,
            'gl' => 'Galician' ,
            'gn' => 'Guarani' ,
            'gu' => 'Gujarati' ,
            'ha' => 'Hausa' ,
            'hi' => 'Hindi' ,
            'hr' => 'Croatian' ,
            'hu' => 'Hungarian' ,
            'hy' => 'Armenian' ,
            'ia' => 'Interlingua' ,
            'ie' => 'Interlingue' ,
            'ik' => 'Inupiak' ,
            'in' => 'Indonesian' ,
            'is' => 'Icelandic' ,
            'it' => 'Italian' ,
            'iw' => 'Hebrew' ,
            'ja' => 'Japanese' ,
            'ji' => 'Yiddish' ,
            'jw' => 'Javanese' ,
            'ka' => 'Georgian' ,
            'kk' => 'Kazakh' ,
            'kl' => 'Greenlandic' ,
            'km' => 'Cambodian' ,
            'kn' => 'Kannada' ,
            'ko' => 'Korean' ,
            'ks' => 'Kashmiri' ,
            'ku' => 'Kurdish' ,
            'ky' => 'Kirghiz' ,
            'la' => 'Latin' ,
            'ln' => 'Lingala' ,
            'lo' => 'Laothian' ,
            'lt' => 'Lithuanian' ,
            'lv' => 'Latvian/Lettish' ,
            'mg' => 'Malagasy' ,
            'mi' => 'Maori' ,
            'mk' => 'Macedonian' ,
            'ml' => 'Malayalam' ,
            'mn' => 'Mongolian' ,
            'mo' => 'Moldavian' ,
            'mr' => 'Marathi' ,
            'ms' => 'Malay' ,
            'mt' => 'Maltese' ,
            'my' => 'Burmese' ,
            'na' => 'Nauru' ,
            'ne' => 'Nepali' ,
            'nl' => 'Dutch' ,
            'no' => 'Norwegian' ,
            'oc' => 'Occitan' ,
            'om' => '(Afan)/Oromoor/Oriya' ,
            'pa' => 'Punjabi' ,
            'pl' => 'Polish' ,
            'ps' => 'Pashto/Pushto' ,
            'pt' => 'Portuguese' ,
            'qu' => 'Quechua' ,
            'rm' => 'Rhaeto-Romance' ,
            'rn' => 'Kirundi' ,
            'ro' => 'Romanian' ,
            'ru' => 'Russian' ,
            'rw' => 'Kinyarwanda' ,
            'sa' => 'Sanskrit' ,
            'sd' => 'Sindhi' ,
            'sg' => 'Sangro' ,
            'sh' => 'Serbo-Croatian' ,
            'si' => 'Singhalese' ,
            'sk' => 'Slovak' ,
            'sl' => 'Slovenian' ,
            'sm' => 'Samoan' ,
            'sn' => 'Shona' ,
            'so' => 'Somali' ,
            'sq' => 'Albanian' ,
            'sr' => 'Serbian' ,
            'ss' => 'Siswati' ,
            'st' => 'Sesotho' ,
            'su' => 'Sundanese' ,
            'sv' => 'Swedish' ,
            'sw' => 'Swahili' ,
            'ta' => 'Tamil' ,
            'te' => 'Tegulu' ,
            'tg' => 'Tajik' ,
            'th' => 'Thai' ,
            'ti' => 'Tigrinya' ,
            'tk' => 'Turkmen' ,
            'tl' => 'Tagalog' ,
            'tn' => 'Setswana' ,
            'to' => 'Tonga' ,
            'tr' => 'Turkish' ,
            'ts' => 'Tsonga' ,
            'tt' => 'Tatar' ,
            'tw' => 'Twi' ,
            'uk' => 'Ukrainian' ,
            'ur' => 'Urdu' ,
            'uz' => 'Uzbek' ,
            'vi' => 'Vietnamese' ,
            'vo' => 'Volapuk' ,
            'wo' => 'Wolof' ,
            'xh' => 'Xhosa' ,
            'yo' => 'Yoruba' ,
            'zh' => 'Chinese' ,
            'zu' => 'Zulu' ,
        );

        $currencies = array (
            'ALL' => 'Albania Lek',
            'AFN' => 'Afghanistan Afghani',
            'ARS' => 'Argentina Peso',
            'AWG' => 'Aruba Guilder',
            'AUD' => 'Australia Dollar',
            'AZN' => 'Azerbaijan New Manat',
            'BSD' => 'Bahamas Dollar',
            'BBD' => 'Barbados Dollar',
            'BDT' => 'Bangladeshi taka',
            'BYR' => 'Belarus Ruble',
            'BZD' => 'Belize Dollar',
            'BMD' => 'Bermuda Dollar',
            'BOB' => 'Bolivia Boliviano',
            'BAM' => 'Bosnia and Herzegovina Convertible Marka',
            'BWP' => 'Botswana Pula',
            'BGN' => 'Bulgaria Lev',
            'BRL' => 'Brazil Real',
            'BND' => 'Brunei Darussalam Dollar',
            'KHR' => 'Cambodia Riel',
            'CAD' => 'Canada Dollar',
            'KYD' => 'Cayman Islands Dollar',
            'CLP' => 'Chile Peso',
            'CNY' => 'China Yuan Renminbi',
            'COP' => 'Colombia Peso',
            'CRC' => 'Costa Rica Colon',
            'HRK' => 'Croatia Kuna',
            'CUP' => 'Cuba Peso',
            'CZK' => 'Czech Republic Koruna',
            'DKK' => 'Denmark Krone',
            'DOP' => 'Dominican Republic Peso',
            'XCD' => 'East Caribbean Dollar',
            'EGP' => 'Egypt Pound',
            'SVC' => 'El Salvador Colon',
            'EEK' => 'Estonia Kroon',
            'EUR' => 'Euro Member Countries',
            'FKP' => 'Falkland Islands (Malvinas) Pound',
            'FJD' => 'Fiji Dollar',
            'GHC' => 'Ghana Cedis',
            'GIP' => 'Gibraltar Pound',
            'GTQ' => 'Guatemala Quetzal',
            'GGP' => 'Guernsey Pound',
            'GYD' => 'Guyana Dollar',
            'HNL' => 'Honduras Lempira',
            'HKD' => 'Hong Kong Dollar',
            'HUF' => 'Hungary Forint',
            'ISK' => 'Iceland Krona',
            'INR' => 'India Rupee',
            'IDR' => 'Indonesia Rupiah',
            'IRR' => 'Iran Rial',
            'IMP' => 'Isle of Man Pound',
            'ILS' => 'Israel Shekel',
            'JMD' => 'Jamaica Dollar',
            'JPY' => 'Japan Yen',
            'JEP' => 'Jersey Pound',
            'KZT' => 'Kazakhstan Tenge',
            'KPW' => 'Korea (North) Won',
            'KRW' => 'Korea (South) Won',
            'KGS' => 'Kyrgyzstan Som',
            'LAK' => 'Laos Kip',
            'LVL' => 'Latvia Lat',
            'LBP' => 'Lebanon Pound',
            'LRD' => 'Liberia Dollar',
            'LTL' => 'Lithuania Litas',
            'MKD' => 'Macedonia Denar',
            'MYR' => 'Malaysia Ringgit',
            'MUR' => 'Mauritius Rupee',
            'MXN' => 'Mexico Peso',
            'MNT' => 'Mongolia Tughrik',
            'MZN' => 'Mozambique Metical',
            'NAD' => 'Namibia Dollar',
            'NPR' => 'Nepal Rupee',
            'ANG' => 'Netherlands Antilles Guilder',
            'NZD' => 'New Zealand Dollar',
            'NIO' => 'Nicaragua Cordoba',
            'NGN' => 'Nigeria Naira',
            'NOK' => 'Norway Krone',
            'OMR' => 'Oman Rial',
            'PKR' => 'Pakistan Rupee',
            'PAB' => 'Panama Balboa',
            'PYG' => 'Paraguay Guarani',
            'PEN' => 'Peru Nuevo Sol',
            'PHP' => 'Philippines Peso',
            'PLN' => 'Poland Zloty',
            'QAR' => 'Qatar Riyal',
            'RON' => 'Romania New Leu',
            'RUB' => 'Russia Ruble',
            'SHP' => 'Saint Helena Pound',
            'SAR' => 'Saudi Arabia Riyal',
            'RSD' => 'Serbia Dinar',
            'SCR' => 'Seychelles Rupee',
            'SGD' => 'Singapore Dollar',
            'SBD' => 'Solomon Islands Dollar',
            'SOS' => 'Somalia Shilling',
            'ZAR' => 'South Africa Rand',
            'LKR' => 'Sri Lanka Rupee',
            'SEK' => 'Sweden Krona',
            'CHF' => 'Switzerland Franc',
            'SRD' => 'Suriname Dollar',
            'SYP' => 'Syria Pound',
            'TWD' => 'Taiwan New Dollar',
            'THB' => 'Thailand Baht',
            'TTD' => 'Trinidad and Tobago Dollar',
            'TRY' => 'Turkey Lira',
            'TRL' => 'Turkey Lira',
            'TVD' => 'Tuvalu Dollar',
            'UAH' => 'Ukraine Hryvna',
            'GBP' => 'United Kingdom Pound',
            'UGX' => 'Uganda Shilling',
            'USD' => 'United States Dollar',
            'UYU' => 'Uruguay Peso',
            'UZS' => 'Uzbekistan Som',
            'VEF' => 'Venezuela Bolivar',
            'VND' => 'Viet Nam Dong',
            'YER' => 'Yemen Rial',
            'ZWD' => 'Zimbabwe Dollar'
        );


        $card_years = array_combine(range(date("Y"), date("Y")+5), range(date("Y"), date("Y")+5));

        $credit_cards = Auth::user()->credit_cards;


        return view('site/companies/dashboard_pages/payment', compact('company','years','months','timezones','languages' ,'currencies','card_years','credit_cards'));
    }

    public function get_venue_index()
    {
        $company = Company::where('user_id', Auth::user()->id)->first();

        $venues = $company->venues;

        return view('site/companies/dashboard_pages/venue', compact('company','venues'));

    }

    public function profile_update(Request $request)
    {
//        dd($request);
        $user = Auth::user();
        $company = Company::where('user_id', $user->id)->first();


        if ($request->hasFile('profile_pic')) {
            $path = 'images/users/' .$user->id.'/profile/';
            $fileName = request()->profile_pic->getClientOriginalName();
            $request->profile_pic->storeAs($path,$fileName);
            $company->image = $fileName;
        } else {
//            $company->name = $request->input('company_name');
            $company->company_email = $request->input('company_email');
            $company->timezone = $request->input('timezone');
            $company->language = $request->input('language');
            $company->currency = $request->input('currency');
            $company->address = $request->input('address');


            $user->name = $request->input('name');
            $user->email = $request->input('email');

            $user->phone_number = $request->input('phone_number');
        }

        $user->save();
        $company->save();


        session()->flash('msg-success', 'Profile updated');

        return redirect()->back();
    }

    public function get_spaces(Request $request)
    {
        $venue_id = $request->input('venue_id');

        $data = '';
        $tab_buttons = '';

        $space_types = SpacesType::whereHas('spaces', function($q) use($venue_id) {
            $q->where('venue_id', $venue_id);
        })->get();

        if(count($space_types) > 0)
        {
            foreach ($space_types as $key=>$space_type)
            {
                $spaces = $space_type->spaces->where('venue_id', $venue_id);

                $tab_buttons .= '<li><a href="#inner_tab_'.$key.'">'.$space_type->title.'</a></li>';

                if (count($spaces) > 0)
                {
                    $data .= '<div id="inner_tab_'.$key.'" class="inner-tab-contents vaneu-booking">';
                    foreach ($spaces as $space)
                    {
                        $data .= '<div class="book-list">';
                        $data .= '<div class="b-list-img col-sm-2">';
                        $data .= '<img src="'.url('storage/images/spaces/'.$space->image).'" alt="image" />';
                        $data .= '</div>';
                        $data .= '<div class="b-list-info col-sm-4">';
                        $data .= '<h3>'.$space->title.'</h3>';
                        $data .= '</div>';
                        $data .= '<div class="b-list-rate col-sm-2">';
                        $data .= '4.5';
                        $data .= '<div class="star-ratings-css">';
                        $data .= '<div class="star-ratings-css-top" style="width: 95%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>';
                        $data .= '<div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>';
                        $data .= '</div>';
                        $data .= '</div>';
                        $data .= '<div class="vanu-edit col-sm-2">';
                        $data .= '<a href="#" class="del-btn"><img src="'.url('images/delete.png').'" alt="delete"/></a>';
                        $data .= '<a href="#" class="edit-btn"><img src="'.url('images/edit.png').'" alt="edit"/></a>';
                        $data .= '</div>';
                        $data .= '<div class="b-list-btn col-sm-2">';
                        $data .= '<a href="booking-detail.html" class="btn get-btn">';
                        $data .= '<span>View Space </span><span></span><span></span><span></span><span></span>';
                        $data .= '</a>';
                        $data .= '</div>';
                        $data .= '</div><!--booking list-->';

                    }
                    $data .= '</div><!--tab end-->';

                } else {
                    $data .= '<div id="inner_tab_'.$key.'" class="inner-tab-contents vaneu-booking">';
                    $data .= '<div class="pay-inner-card"><div class="dash-pay-gray"> No Spaces added yet. </div> </div>';
                    $data .= '</div><!--tab end-->';
                }
            }
        } else {
            $tab_buttons .= '<li><a href="#">No Spaces added yet.</a></li>';
        }

//

//        return $spaces;
        return response()->json(['tab_buttons' => $tab_buttons, 'data' => $data]);
    }



}
