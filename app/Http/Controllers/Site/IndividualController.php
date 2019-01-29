<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\Discount;
use App\Models\Site\BookingInfo;
use App\Models\Site\Individual;
use App\Models\Site\Review;
use App\Models\Site\Spaces;
use App\Models\Site\Wishlist;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use PDF;
use Illuminate\Support\Facades\Response;

class IndividualController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check.type.individual');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        $bookings = BookingInfo::where('user_id', Auth::user()->id)->where('status' , 1)->whereDate('start_date' , '>=' , Carbon::today())->get();
        $reviews = Review::where('user_id' , Auth::user()->id)->where('r_status' , '1')->orderBy('created_at','desc')->take(3)->get();

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

        $discount_silver = Discount::where('type', 'silver')->first();
        $discount_gold = Discount::where('type', 'gold')->first();
        $discount_platinum = Discount::where('type', 'platinum')->first();

        $user_bookings_count = BookingInfo::where('status', 1)->whereDate('end_date' , '<' , Carbon::today())->where('user_id', Auth::user()->id)->count();

        if($user_bookings_count >= $discount_platinum->no_of_booking) {
            $badge = "Platinum";
        } elseif ($user_bookings_count >= $discount_gold->no_of_booking){
            $badge = "Gold";
        } elseif ($user_bookings_count >= $discount_silver->no_of_booking) {
            $badge = "Sliver";
        } else {
            $badge = "Classic";
        }

        return view('site/individuals/dashboard_pages/dashboard', compact('bookings','date' , 'reviews', 'discount_silver','discount_gold','discount_platinum','user_bookings_count', 'badge'));
    }

    public function get_profile()
    {
        $individual = Individual::where('user_id', Auth::user()->id)->first();

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

        return view('site/individuals/dashboard_pages/profile', compact('individual','years','months','timezones','languages' ,'currencies'));
    }

    public function get_payment(){
        $individual = Individual::where('user_id', Auth::user()->id)->first();

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
        return view('site/individuals/dashboard_pages/payment', compact('individual','years','months','timezones','languages' ,'currencies','card_years','credit_cards'));
    }

    public function profile_update(Request $request)
    {
        $individual = Individual::where('user_id', Auth::user()->id)->first();
        $user = Auth::user();

        if ($request->hasFile('profile_pic')) {
            $path = 'images/users/' .Auth::user()->id.'/profile/';
            $fileName = request()->profile_pic->getClientOriginalName();
            $request->profile_pic->storeAs($path,$fileName);
            $individual->image = $fileName;
        } else {
            $dob = $request->input('day') .'-'. $request->input('month') .'-'. $request->input('year');

            $individual->dob = $dob;
            $individual->gender = $request->input('gender');
            $individual->time_zone = $request->input('timezone');
            $individual->language = $request->input('language');
            $individual->currency = $request->input('currency');
            $individual->address = $request->input('address');


            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone_number = $request->input('phone_number');
        }

        $user->save();
        $individual->save();


        session()->flash('msg-success', 'Profile updated');

        return redirect()->back();
    }

    public function get_wishlists()
    {
        $wish_venues = Wishlist::where('list_name', 'venue')->where('user_id', Auth::user()->id)->get();
        $wish_spaces = Wishlist::where('list_name', 'space')->where('user_id', Auth::user()->id)->get();

        return view('site/individuals/dashboard_pages/wishlists', compact('wish_venues','wish_spaces'));

    }

    public function get_reviews()
    {
        $user = Auth::user();
        $pending_booking = BookingInfo::where('user_id', $user->id)->where('status' , 1)->where('review_status', 0)->whereDate('end_date' , '<' , Carbon::today())->get();
        $reviewed_booking = BookingInfo::where('user_id', $user->id)->where('status' , 1)->where('review_status', 1)->whereDate('end_date' , '<' , Carbon::today())->get();
        return view('site/individuals/dashboard_pages/reviews' ,compact('pending_booking','reviewed_booking'));
    }

    public function get_saving_report()
    {
        $discount_silver = Discount::where('type', 'silver')->first();
        $discount_gold = Discount::where('type', 'gold')->first();
        $discount_platinum = Discount::where('type', 'platinum')->first();

        $user_bookings_count = BookingInfo::where('status', 1)->whereDate('end_date' , '<' , Carbon::today())->where('user_id', Auth::user()->id)->count();

        if($user_bookings_count >= $discount_platinum->no_of_booking) {
            $badge = "Platinum";
        } elseif ($user_bookings_count >= $discount_gold->no_of_booking){
            $badge = "Gold";
        } elseif ($user_bookings_count >= $discount_silver->no_of_booking) {
            $badge = "Sliver";
        } else {
            $badge = "Classic";
        }

        return view('site/individuals/dashboard_pages/savings' , compact('discount_silver','discount_gold','discount_platinum','user_bookings_count', 'badge'));
    }

    public function generate_saving_report(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $user = Auth::user();
        $bookings = BookingInfo::where('user_id', $user->id)->where('status', 1)
            ->where('start_date', '>=', $start_date)
            ->where('end_date', '<=', $end_date)
            ->where('discount','!=', 0)
            ->get();

        return view('site/individuals/dashboard_pages/saving-report' ,compact('bookings','start_date','end_date','user'));
    }

    public function download_saving_pdf(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $bookings = json_decode($request->bookings);

        $user = Auth::user();

        $pdf = PDF::loadView('site/individuals/dashboard_pages/saving-pdf', compact('bookings','user','start_date','end_date'));
        return $pdf->download('saving-report.pdf');
    }

    public function download_saving_cvs(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $bookings = json_decode($request->bookings);

        $user = Auth::user();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=report.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('Sr#', 'Name of Meeting', 'Venue Name', 'Space Name', 'Start Date','End Date', 'Amount', 'Discount Amount');

        $callback = function() use ($bookings, $columns)
        {

            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($bookings as $key=>$booking) {
                if($booking->status == 0){
                    $status = "Pending";
                }elseif ($booking->status == 1){
                    $status = "Approved";
                }elseif ($booking->status == 2){
                    $status = "Cancelled";
                }
                $venue_title = get_venue_title($booking->venue_id);
                $space_title = get_venue_title($booking->space_id);
                $discount = $booking->total - $booking->grand_total;

                fputcsv($file, array($key+1, $booking->purpose, $venue_title, $space_title, date('d M Y', strtotime($booking->start_date)), date('d M Y', strtotime($booking->end_date)), 'AED '.$booking->grand_total, 'AED '.$discount));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }
}
