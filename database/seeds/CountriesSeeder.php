<?php

use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            	[ "prefix" => "AF", "country" => "Afghanistan" ],
                [ "prefix" => "AL", "country" => "Albania" ],
                [ "prefix" => "DZ", "country" => "Algeria" ],
                [ "prefix" => "AS", "country" => "American Samoa" ],
                [ "prefix" => "AD", "country" => "Andorra" ],
                [ "prefix" => "AO", "country" => "Angola" ],
                [ "prefix" => "AI", "country" => "Anguilla" ],
                [ "prefix" => "AQ", "country" => "Antarctica" ],
                [ "prefix" => "AG", "country" => "Antigua and Barbuda" ],
                [ "prefix" => "AR", "country" => "Argentina" ],
                [ "prefix" => "AM", "country" => "Armenia" ],
                [ "prefix" => "AW", "country" => "Aruba" ],
                [ "prefix" => "AU", "country" => "Australia" ],
                [ "prefix" => "AT", "country" => "Austria" ],
                [ "prefix" => "AZ", "country" => "Azerbaijan" ],
                [ "prefix" => "BS", "country" => "Bahamas" ],
                [ "prefix" => "BH", "country" => "Bahrain" ],
                [ "prefix" => "BD", "country" => "Bangladesh" ],
                [ "prefix" => "BB", "country" => "Barbados" ],
                [ "prefix" => "BY", "country" => "Belarus" ],
                [ "prefix" => "BE", "country" => "Belgium" ],
                [ "prefix" => "BZ", "country" => "Belize" ],
                [ "prefix" => "BJ", "country" => "Benin" ],
                [ "prefix" => "BM", "country" => "Bermuda" ],
                [ "prefix" => "BT", "country" => "Bhutan" ],
                [ "prefix" => "BO", "country" => "Bolivia" ],
                [ "prefix" => "BA", "country" => "Bosnia and Herzegovina" ],
                [ "prefix" => "BW", "country" => "Botswana" ],
                [ "prefix" => "BV", "country" => "Bouvet Island" ],
                [ "prefix" => "BR", "country" => "Brazil" ],
                [ "prefix" => "BQ", "country" => "British Antarctic Territory" ],
                [ "prefix" => "IO", "country" => "British Indian Ocean Territory" ],
                [ "prefix" => "VG", "country" => "British Virgin Islands" ],
                [ "prefix" => "BN", "country" => "Brunei" ],
                [ "prefix" => "BG", "country" => "Bulgaria" ],
                [ "prefix" => "BF", "country" => "Burkina Faso" ],
                [ "prefix" => "BI", "country" => "Burundi" ],
                [ "prefix" => "KH", "country" => "Cambodia" ],
                [ "prefix" => "CM", "country" => "Cameroon" ],
                [ "prefix" => "CA", "country" => "Canada" ],
                [ "prefix" => "CT", "country" => "Canton and Enderbury Islands" ],
                [ "prefix" => "CV", "country" => "Cape Verde" ],
                [ "prefix" => "KY", "country" => "Cayman Islands" ],
                [ "prefix" => "CF", "country" => "Central African Republic" ],
                [ "prefix" => "TD", "country" => "Chad" ],
                [ "prefix" => "CL", "country" => "Chile" ],
                [ "prefix" => "CN", "country" => "China" ],
                [ "prefix" => "CX", "country" => "Christmas Island" ],
                [ "prefix" => "CC", "country" => "Cocos [Keeling] Islands" ],
                [ "prefix" => "CO", "country" => "Colombia" ],
                [ "prefix" => "KM", "country" => "Comoros" ],
                [ "prefix" => "CG", "country" => "Congo - Brazzaville" ],
                [ "prefix" => "CD", "country" => "Congo - Kinshasa" ],
                [ "prefix" => "CK", "country" => "Cook Islands" ],
                [ "prefix" => "CR", "country" => "Costa Rica" ],
                [ "prefix" => "HR", "country" => "Croatia" ],
                [ "prefix" => "CU", "country" => "Cuba" ],
                [ "prefix" => "CY", "country" => "Cyprus" ],
                [ "prefix" => "CZ", "country" => "Czech Republic" ],
                [ "prefix" => "CI", "country" => "Côte d’Ivoire" ],
                [ "prefix" => "DK", "country" => "Denmark" ],
                [ "prefix" => "DJ", "country" => "Djibouti" ],
                [ "prefix" => "DM", "country" => "Dominica" ],
                [ "prefix" => "DO", "country" => "Dominican Republic" ],
                [ "prefix" => "NQ", "country" => "Dronning Maud Land" ],
                [ "prefix" => "DD", "country" => "East Germany" ],
                [ "prefix" => "EC", "country" => "Ecuador" ],
                [ "prefix" => "EG", "country" => "Egypt" ],
                [ "prefix" => "SV", "country" => "El Salvador" ],
                [ "prefix" => "GQ", "country" => "Equatorial Guinea" ],
                [ "prefix" => "ER", "country" => "Eritrea" ],
                [ "prefix" => "EE", "country" => "Estonia" ],
                [ "prefix" => "ET", "country" => "Ethiopia" ],
                [ "prefix" => "FK", "country" => "Falkland Islands" ],
                [ "prefix" => "FO", "country" => "Faroe Islands" ],
                [ "prefix" => "FJ", "country" => "Fiji" ],
                [ "prefix" => "FI", "country" => "Finland" ],
                [ "prefix" => "FR", "country" => "France" ],
                [ "prefix" => "GF", "country" => "French Guiana" ],
                [ "prefix" => "PF", "country" => "French Polynesia" ],
                [ "prefix" => "TF", "country" => "French Southern Territories" ],
                [ "prefix" => "FQ", "country" => "French Southern and Antarctic Territories" ],
                [ "prefix" => "GA", "country" => "Gabon" ],
                [ "prefix" => "GM", "country" => "Gambia" ],
                [ "prefix" => "GE", "country" => "Georgia" ],
                [ "prefix" => "DE", "country" => "Germany" ],
                [ "prefix" => "GH", "country" => "Ghana" ],
                [ "prefix" => "GI", "country" => "Gibraltar" ],
                [ "prefix" => "GR", "country" => "Greece" ],
                [ "prefix" => "GL", "country" => "Greenland" ],
                [ "prefix" => "GD", "country" => "Grenada" ],
                [ "prefix" => "GP", "country" => "Guadeloupe" ],
                [ "prefix" => "GU", "country" => "Guam" ],
                [ "prefix" => "GT", "country" => "Guatemala" ],
                [ "prefix" => "GG", "country" => "Guernsey" ],
                [ "prefix" => "GN", "country" => "Guinea" ],
                [ "prefix" => "GW", "country" => "Guinea-Bissau" ],
                [ "prefix" => "GY", "country" => "Guyana" ],
                [ "prefix" => "HT", "country" => "Haiti" ],
                [ "prefix" => "HM", "country" => "Heard Island and McDonald Islands" ],
                [ "prefix" => "HN", "country" => "Honduras" ],
                [ "prefix" => "HK", "country" => "Hong Kong SAR China" ],
                [ "prefix" => "HU", "country" => "Hungary" ],
                [ "prefix" => "IS", "country" => "Iceland" ],
                [ "prefix" => "IN", "country" => "India" ],
                [ "prefix" => "ID", "country" => "Indonesia" ],
                [ "prefix" => "IR", "country" => "Iran" ],
                [ "prefix" => "IQ", "country" => "Iraq" ],
                [ "prefix" => "IE", "country" => "Ireland" ],
                [ "prefix" => "IM", "country" => "Isle of Man" ],
                [ "prefix" => "IL", "country" => "Israel" ],
                [ "prefix" => "IT", "country" => "Italy" ],
                [ "prefix" => "JM", "country" => "Jamaica" ],
                [ "prefix" => "JP", "country" => "Japan" ],
                [ "prefix" => "JE", "country" => "Jersey" ],
                [ "prefix" => "JT", "country" => "Johnston Island" ],
                [ "prefix" => "JO", "country" => "Jordan" ],
                [ "prefix" => "KZ", "country" => "Kazakhstan" ],
                [ "prefix" => "KE", "country" => "Kenya" ],
                [ "prefix" => "KI", "country" => "Kiribati" ],
                [ "prefix" => "KW", "country" => "Kuwait" ],
                [ "prefix" => "KG", "country" => "Kyrgyzstan" ],
                [ "prefix" => "LA", "country" => "Laos" ],
                [ "prefix" => "LV", "country" => "Latvia" ],
                [ "prefix" => "LB", "country" => "Lebanon" ],
                [ "prefix" => "LS", "country" => "Lesotho" ],
                [ "prefix" => "LR", "country" => "Liberia" ],
                [ "prefix" => "LY", "country" => "Libya" ],
                [ "prefix" => "LI", "country" => "Liechtenstein" ],
                [ "prefix" => "LT", "country" => "Lithuania" ],
                [ "prefix" => "LU", "country" => "Luxembourg" ],
                [ "prefix" => "MO", "country" => "Macau SAR China" ],
                [ "prefix" => "MK", "country" => "Macedonia" ],
                [ "prefix" => "MG", "country" => "Madagascar" ],
                [ "prefix" => "MW", "country" => "Malawi" ],
                [ "prefix" => "MY", "country" => "Malaysia" ],
                [ "prefix" => "MV", "country" => "Maldives" ],
                [ "prefix" => "ML", "country" => "Mali" ],
                [ "prefix" => "MT", "country" => "Malta" ],
                [ "prefix" => "MH", "country" => "Marshall Islands" ],
                [ "prefix" => "MQ", "country" => "Martinique" ],
                [ "prefix" => "MR", "country" => "Mauritania" ],
                [ "prefix" => "MU", "country" => "Mauritius" ],
                [ "prefix" => "YT", "country" => "Mayotte" ],
                [ "prefix" => "FX", "country" => "Metropolitan France" ],
                [ "prefix" => "MX", "country" => "Mexico" ],
                [ "prefix" => "FM", "country" => "Micronesia" ],
                [ "prefix" => "MI", "country" => "Midway Islands" ],
                [ "prefix" => "MD", "country" => "Moldova" ],
                [ "prefix" => "MC", "country" => "Monaco" ],
                [ "prefix" => "MN", "country" => "Mongolia" ],
                [ "prefix" => "ME", "country" => "Montenegro" ],
                [ "prefix" => "MS", "country" => "Montserrat" ],
                [ "prefix" => "MA", "country" => "Morocco" ],
                [ "prefix" => "MZ", "country" => "Mozambique" ],
                [ "prefix" => "MM", "country" => "Myanmar [Burma]" ],
                [ "prefix" => "NA", "country" => "Namibia" ],
                [ "prefix" => "NR", "country" => "Nauru" ],
                [ "prefix" => "NP", "country" => "Nepal" ],
                [ "prefix" => "NL", "country" => "Netherlands" ],
                [ "prefix" => "AN", "country" => "Netherlands Antilles" ],
                [ "prefix" => "NT", "country" => "Neutral Zone" ],
                [ "prefix" => "NC", "country" => "New Caledonia" ],
                [ "prefix" => "NZ", "country" => "New Zealand" ],
                [ "prefix" => "NI", "country" => "Nicaragua" ],
                [ "prefix" => "NE", "country" => "Niger" ],
                [ "prefix" => "NG", "country" => "Nigeria" ],
                [ "prefix" => "NU", "country" => "Niue" ],
                [ "prefix" => "NF", "country" => "Norfolk Island" ],
                [ "prefix" => "KP", "country" => "North Korea" ],
                [ "prefix" => "VD", "country" => "North Vietnam" ],
                [ "prefix" => "MP", "country" => "Northern Mariana Islands" ],
                [ "prefix" => "NO", "country" => "Norway" ],
                [ "prefix" => "OM", "country" => "Oman" ],
                [ "prefix" => "PC", "country" => "Pacific Islands Trust Territory" ],
                [ "prefix" => "PK", "country" => "Pakistan" ],
                [ "prefix" => "PW", "country" => "Palau" ],
                [ "prefix" => "PS", "country" => "Palestinian Territories" ],
                [ "prefix" => "PA", "country" => "Panama" ],
                [ "prefix" => "PZ", "country" => "Panama Canal Zone" ],
                [ "prefix" => "PG", "country" => "Papua New Guinea" ],
                [ "prefix" => "PY", "country" => "Paraguay" ],
                [ "prefix" => "YD", "country" => "People's Democratic Republic of Yemen" ],
                [ "prefix" => "PE", "country" => "Peru" ],
                [ "prefix" => "PH", "country" => "Philippines" ],
                [ "prefix" => "PN", "country" => "Pitcairn Islands" ],
                [ "prefix" => "PL", "country" => "Poland" ],
                [ "prefix" => "PT", "country" => "Portugal" ],
                [ "prefix" => "PR", "country" => "Puerto Rico" ],
                [ "prefix" => "QA", "country" => "Qatar" ],
                [ "prefix" => "RO", "country" => "Romania" ],
                [ "prefix" => "RU", "country" => "Russia" ],
                [ "prefix" => "RW", "country" => "Rwanda" ],
                [ "prefix" => "RE", "country" => "Réunion" ],
                [ "prefix" => "BL", "country" => "Saint Barthélemy" ],
                [ "prefix" => "SH", "country" => "Saint Helena" ],
                [ "prefix" => "KN", "country" => "Saint Kitts and Nevis" ],
                [ "prefix" => "LC", "country" => "Saint Lucia" ],
                [ "prefix" => "MF", "country" => "Saint Martin" ],
                [ "prefix" => "PM", "country" => "Saint Pierre and Miquelon" ],
                [ "prefix" => "VC", "country" => "Saint Vincent and the Grenadines" ],
                [ "prefix" => "WS", "country" => "Samoa" ],
                [ "prefix" => "SM", "country" => "San Marino" ],
                [ "prefix" => "SA", "country" => "Saudi Arabia" ],
                [ "prefix" => "SN", "country" => "Senegal" ],
                [ "prefix" => "RS", "country" => "Serbia" ],
                [ "prefix" => "CS", "country" => "Serbia and Montenegro" ],
                [ "prefix" => "SC", "country" => "Seychelles" ],
                [ "prefix" => "SL", "country" => "Sierra Leone" ],
                [ "prefix" => "SG", "country" => "Singapore" ],
                [ "prefix" => "SK", "country" => "Slovakia" ],
                [ "prefix" => "SI", "country" => "Slovenia" ],
                [ "prefix" => "SB", "country" => "Solomon Islands" ],
                [ "prefix" => "SO", "country" => "Somalia" ],
                [ "prefix" => "ZA", "country" => "South Africa" ],
                [ "prefix" => "GS", "country" => "South Georgia and the South Sandwich Islands" ],
                [ "prefix" => "KR", "country" => "South Korea" ],
                [ "prefix" => "ES", "country" => "Spain" ],
                [ "prefix" => "LK", "country" => "Sri Lanka" ],
                [ "prefix" => "SD", "country" => "Sudan" ],
                [ "prefix" => "SR", "country" => "Suriname" ],
                [ "prefix" => "SJ", "country" => "Svalbard and Jan Mayen" ],
                [ "prefix" => "SZ", "country" => "Swaziland" ],
                [ "prefix" => "SE", "country" => "Sweden" ],
                [ "prefix" => "CH", "country" => "Switzerland" ],
                [ "prefix" => "SY", "country" => "Syria" ],
                [ "prefix" => "ST", "country" => "São Tomé and Príncipe" ],
                [ "prefix" => "TW", "country" => "Taiwan" ],
                [ "prefix" => "TJ", "country" => "Tajikistan" ],
                [ "prefix" => "TZ", "country" => "Tanzania" ],
                [ "prefix" => "TH", "country" => "Thailand" ],
                [ "prefix" => "TL", "country" => "Timor-Leste" ],
                [ "prefix" => "TG", "country" => "Togo" ],
                [ "prefix" => "TK", "country" => "Tokelau" ],
                [ "prefix" => "TO", "country" => "Tonga" ],
                [ "prefix" => "TT", "country" => "Trinidad and Tobago" ],
                [ "prefix" => "TN", "country" => "Tunisia" ],
                [ "prefix" => "TR", "country" => "Turkey" ],
                [ "prefix" => "TM", "country" => "Turkmenistan" ],
                [ "prefix" => "TC", "country" => "Turks and Caicos Islands" ],
                [ "prefix" => "TV", "country" => "Tuvalu" ],
                [ "prefix" => "UM", "country" => "U.S. Minor Outlying Islands" ],
                [ "prefix" => "PU", "country" => "U.S. Miscellaneous Pacific Islands" ],
                [ "prefix" => "VI", "country" => "U.S. Virgin Islands" ],
                [ "prefix" => "UG", "country" => "Uganda" ],
                [ "prefix" => "UA", "country" => "Ukraine" ],
                [ "prefix" => "SU", "country" => "Union of Soviet Socialist Republics" ],
                [ "prefix" => "AE", "country" => "United Arab Emirates" ],
                [ "prefix" => "GB", "country" => "United Kingdom" ],
                [ "prefix" => "US", "country" => "United States" ],
                [ "prefix" => "ZZ", "country" => "Unknown or Invalid Region" ],
                [ "prefix" => "UY", "country" => "Uruguay" ],
                [ "prefix" => "UZ", "country" => "Uzbekistan" ],
                [ "prefix" => "VU", "country" => "Vanuatu" ],
                [ "prefix" => "VA", "country" => "Vatican City" ],
                [ "prefix" => "VE", "country" => "Venezuela" ],
                [ "prefix" => "VN", "country" => "Vietnam" ],
                [ "prefix" => "WK", "country" => "Wake Island" ],
                [ "prefix" => "WF", "country" => "Wallis and Futuna" ],
                [ "prefix" => "EH", "country" => "Western Sahara" ],
                [ "prefix" => "YE", "country" => "Yemen" ],
                [ "prefix" => "ZM", "country" => "Zambia" ],
                [ "prefix" => "ZW", "country" => "Zimbabwe" ],
                [ "prefix" => "AX", "country" => "Åland Islands" ]
        ];

        foreach ($countries as $country) {
            DB::table('countries')->insert([
                'prefix'     => $country['prefix'],
                'country'    => $country['country'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
