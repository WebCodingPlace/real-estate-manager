<?php
/**
* Core functions for real estate manager
*/

define('REM_PATH', untrailingslashit(plugin_dir_path( __FILE__ )) );
define('REM_URL', untrailingslashit(plugin_dir_url( __FILE__ )) );
define('REM_VERSION', '7.3' );

/**
 * Loads main css for rem.
 * @since  10.3.2
 * @return nothing
 */
function rem_load_basic_styles(){
	static $has_run = false;
	if ($has_run) {
		return;
	}
    $has_run = true;
	wp_enqueue_style( 'rem-styles-css', REM_URL . '/assets/front/css/rem-styles.css' );
    ob_start();
        include_once REM_PATH . '/assets/front/css/styles.php';
    $custom_css = ob_get_clean();
    wp_add_inline_style( 'rem-styles-css', $custom_css );
}

/**
 * Loads dropdown libs.
 * @since  10.7.5
 * @return nothing
 */
function rem_load_dropdown_styles(){
	$dropdown_class = rem_get_option('dropdown_style', 'rem-easydropdown');

	switch ($dropdown_class) {
		case 'rem-easydropdown':
			wp_enqueue_style( 'rem-easydropdown-css', REM_URL . '/assets/front/lib/easydropdown.css' );
			wp_enqueue_script( 'rem-easy-drop', REM_URL . '/assets/front/lib/jquery.easydropdown.min.js', array('jquery'));			
			break;
		case 'rem-niceselect':
			wp_enqueue_style( 'rem-niceselect', REM_URL . '/assets/front/lib/nice-select.css' );
		    wp_enqueue_script( 'rem-niceselect', REM_URL . '/assets/front/lib/jquery.nice-select.js', array('jquery'));
			break;
		
		default:
			
			break;
	}
}

/**
 * Loads bootstrap and fontawesome css if needed.
 * @since  10.3.2
 * @return nothing
 */
function rem_load_bs_and_fa(){
	static $has_run = false;
	if ($has_run) {
		return;
	}
    $has_run = true;
    if (rem_get_option('use_bootstrap', 'enable') == 'enable') {
	    wp_enqueue_style( 'rem-bootstrap', REM_URL . '/assets/admin/css/bootstrap.min.css' );  
		if (is_rtl()) {
	        wp_enqueue_style( 'rem-bootstrap-rtl', REM_URL . '/assets/admin/css/bootstrap-rtl.css' );  
	  	}
    }
    if (rem_get_option('use_fontawesome', 'enable') == 'enable') {
        wp_enqueue_style( 'font-awesome-rem', REM_URL . '/assets/front/css/font-awesome.min.css' );
    }
}

/**
 * Return specific option from settings against key provided.
 * @since  4.1
 * @return string
 */
function rem_get_option($key, $default = '') {
	$rem_settings = get_option( 'rem_all_settings' );
	if (isset($rem_settings[$key]) && $rem_settings[$key] != '') {
		return apply_filters( 'rem_get_option_'.$key, $rem_settings[$key], $default );
	} else {
		return $default;
	}
}

/**
 * Return bootstrap columns class based on the number of columns provided.
 * @since  12.0
 * @return string
 */
function rem_get_bootstrap_grid_class($numColumns = 1) {
    // Define the maximum number of columns in Bootstrap 3
    $maxColumns = 12;

    // Calculate the column size based on the maximum number of columns
    $columnSize = $maxColumns / $numColumns;

    // Generate the Bootstrap grid class
    $gridClass = "col-sm-" . $columnSize;

    return $gridClass;
}

/**
 * Return formatted sale price for property display
 * @since  10.3.2
 * @return html markup
 */
function rem_display_property_sale_price($property_id = '') {
	if ($property_id != '') {
		$price = get_post_meta($property_id, 'rem_property_price', true);
	
		$sale_price = get_post_meta($property_id, 'rem_property_sale_price', true);
		$display = rem_get_property_price($price);
		if ($sale_price != '') {
			$display = rem_get_property_price($sale_price);
		}
		$after_price = get_post_meta($property_id, 'rem_after_price_text', true);
		if ($after_price != '') {
			$display = $display . $after_price;
		}
		$before_price = get_post_meta($property_id, 'rem_before_price_text', true);
		if ($before_price != '') {
			$display = $before_price . $display ;
		}
		return $display;
	} else {
		return '';
	}
}

/**
 * Return formatted price for property display
 * @since  4.2
 * @return html markup
 */

function rem_display_property_price($property_id = '') {
	if ($property_id != '') {
		$price = get_post_meta($property_id, 'rem_property_price', true);
		if (strpos($price, '-')) {
		    $price_array =  explode("-", $price);
		    $min_price = $price_array[0];
		    $max_price = $price_array[1];
		    $min_display = rem_get_property_price($min_price);
		    $max_display = rem_get_property_price($max_price);
		    $after_price = get_post_meta($property_id, 'rem_after_price_text', true);
			if ($after_price != '') {
				$min_display = $min_display . $after_price;
				$max_display = $max_display . $after_price;
			}
			$before_price = get_post_meta($property_id, 'rem_before_price_text', true);
			if ($before_price != '') {
				$min_display = $before_price . $min_display ;
				$max_display = $before_price . $max_display ;
			}

			$display = $min_display. "-" .$max_display;
			$sale_price = get_post_meta($property_id, 'rem_property_sale_price', true);
			if ($sale_price != '') {
				$display = '<del>' . $display . '</del> <span class="sale-price">' .rem_get_property_price($sale_price). '</span>';
			}
			return apply_filters( 'rem_display_property_price', $display, $property_id, $price, $sale_price );
		}else{
			$sale_price = get_post_meta($property_id, 'rem_property_sale_price', true);
			$display = rem_get_property_price($price);
			if ($sale_price != '') {
				$display = '<del>' . $display . '</del> <span class="sale-price">' .rem_get_property_price($sale_price). '</span>';
			}
			$after_price = get_post_meta($property_id, 'rem_after_price_text', true);
			if ($after_price != '') {
				$display = $display . $after_price;
			}
			$before_price = get_post_meta($property_id, 'rem_before_price_text', true);
			if ($before_price != '') {
				$display = $before_price . $display ;
			}		
			return apply_filters( 'rem_display_property_price', $display, $property_id, $price, $sale_price );
		}
	} else {
		return '';
	}
}

/**
 * Get full list of currency codes.
 *
 * @return array
 */
function rem_get_all_currencies() {
	return array_unique(
		apply_filters( 'rem_all_currencies',
			array(
				'AED' => __( 'United Arab Emirates dirham', 'real-estate-manager' ),
				'AFN' => __( 'Afghan afghani', 'real-estate-manager' ),
				'ALL' => __( 'Albanian lek', 'real-estate-manager' ),
				'AMD' => __( 'Armenian dram', 'real-estate-manager' ),
				'ANG' => __( 'Netherlands Antillean guilder', 'real-estate-manager' ),
				'AOA' => __( 'Angolan kwanza', 'real-estate-manager' ),
				'ARS' => __( 'Argentine peso', 'real-estate-manager' ),
				'AUD' => __( 'Australian dollar', 'real-estate-manager' ),
				'AWG' => __( 'Aruban florin', 'real-estate-manager' ),
				'AZN' => __( 'Azerbaijani manat', 'real-estate-manager' ),
				'BAM' => __( 'Bosnia and Herzegovina convertible mark', 'real-estate-manager' ),
				'BBD' => __( 'Barbadian dollar', 'real-estate-manager' ),
				'BDT' => __( 'Bangladeshi taka', 'real-estate-manager' ),
				'BGN' => __( 'Bulgarian lev', 'real-estate-manager' ),
				'BHD' => __( 'Bahraini dinar', 'real-estate-manager' ),
				'BIF' => __( 'Burundian franc', 'real-estate-manager' ),
				'BMD' => __( 'Bermudian dollar', 'real-estate-manager' ),
				'BND' => __( 'Brunei dollar', 'real-estate-manager' ),
				'BOB' => __( 'Bolivian boliviano', 'real-estate-manager' ),
				'BRL' => __( 'Brazilian real', 'real-estate-manager' ),
				'BSD' => __( 'Bahamian dollar', 'real-estate-manager' ),
				'BTC' => __( 'Bitcoin', 'real-estate-manager' ),
				'BTN' => __( 'Bhutanese ngultrum', 'real-estate-manager' ),
				'BWP' => __( 'Botswana pula', 'real-estate-manager' ),
				'BYR' => __( 'Belarusian ruble', 'real-estate-manager' ),
				'BZD' => __( 'Belize dollar', 'real-estate-manager' ),
				'CAD' => __( 'Canadian dollar', 'real-estate-manager' ),
				'CDF' => __( 'Congolese franc', 'real-estate-manager' ),
				'CHF' => __( 'Swiss franc', 'real-estate-manager' ),
				'CLP' => __( 'Chilean peso', 'real-estate-manager' ),
				'CNY' => __( 'Chinese yuan', 'real-estate-manager' ),
				'COP' => __( 'Colombian peso', 'real-estate-manager' ),
				'CRC' => __( 'Costa Rican col&oacute;n', 'real-estate-manager' ),
				'CUC' => __( 'Cuban convertible peso', 'real-estate-manager' ),
				'CUP' => __( 'Cuban peso', 'real-estate-manager' ),
				'CVE' => __( 'Cape Verdean escudo', 'real-estate-manager' ),
				'CZK' => __( 'Czech koruna', 'real-estate-manager' ),
				'DJF' => __( 'Djiboutian franc', 'real-estate-manager' ),
				'DKK' => __( 'Danish krone', 'real-estate-manager' ),
				'DOP' => __( 'Dominican peso', 'real-estate-manager' ),
				'DZD' => __( 'Algerian dinar', 'real-estate-manager' ),
				'EGP' => __( 'Egyptian pound', 'real-estate-manager' ),
				'ERN' => __( 'Eritrean nakfa', 'real-estate-manager' ),
				'ETB' => __( 'Ethiopian birr', 'real-estate-manager' ),
				'EUR' => __( 'Euro', 'real-estate-manager' ),
				'FJD' => __( 'Fijian dollar', 'real-estate-manager' ),
				'FKP' => __( 'Falkland Islands pound', 'real-estate-manager' ),
				'GBP' => __( 'Pound sterling', 'real-estate-manager' ),
				'GEL' => __( 'Georgian lari', 'real-estate-manager' ),
				'GGP' => __( 'Guernsey pound', 'real-estate-manager' ),
				'GHS' => __( 'Ghana cedi', 'real-estate-manager' ),
				'GIP' => __( 'Gibraltar pound', 'real-estate-manager' ),
				'GMD' => __( 'Gambian dalasi', 'real-estate-manager' ),
				'GNF' => __( 'Guinean franc', 'real-estate-manager' ),
				'GTQ' => __( 'Guatemalan quetzal', 'real-estate-manager' ),
				'GYD' => __( 'Guyanese dollar', 'real-estate-manager' ),
				'HKD' => __( 'Hong Kong dollar', 'real-estate-manager' ),
				'HNL' => __( 'Honduran lempira', 'real-estate-manager' ),
				'HRK' => __( 'Croatian kuna', 'real-estate-manager' ),
				'HTG' => __( 'Haitian gourde', 'real-estate-manager' ),
				'HUF' => __( 'Hungarian forint', 'real-estate-manager' ),
				'IDR' => __( 'Indonesian rupiah', 'real-estate-manager' ),
				'ILS' => __( 'Israeli new shekel', 'real-estate-manager' ),
				'IMP' => __( 'Manx pound', 'real-estate-manager' ),
				'INR' => __( 'Indian rupee', 'real-estate-manager' ),
				'IQD' => __( 'Iraqi dinar', 'real-estate-manager' ),
				'IRR' => __( 'Iranian rial', 'real-estate-manager' ),
				'ISK' => __( 'Icelandic kr&oacute;na', 'real-estate-manager' ),
				'JEP' => __( 'Jersey pound', 'real-estate-manager' ),
				'JMD' => __( 'Jamaican dollar', 'real-estate-manager' ),
				'JOD' => __( 'Jordanian dinar', 'real-estate-manager' ),
				'JPY' => __( 'Japanese yen', 'real-estate-manager' ),
				'KES' => __( 'Kenyan shilling', 'real-estate-manager' ),
				'KGS' => __( 'Kyrgyzstani som', 'real-estate-manager' ),
				'KHR' => __( 'Cambodian riel', 'real-estate-manager' ),
				'KMF' => __( 'Comorian franc', 'real-estate-manager' ),
				'KPW' => __( 'North Korean won', 'real-estate-manager' ),
				'KRW' => __( 'South Korean won', 'real-estate-manager' ),
				'KWD' => __( 'Kuwaiti dinar', 'real-estate-manager' ),
				'KYD' => __( 'Cayman Islands dollar', 'real-estate-manager' ),
				'KZT' => __( 'Kazakhstani tenge', 'real-estate-manager' ),
				'LAK' => __( 'Lao kip', 'real-estate-manager' ),
				'LBP' => __( 'Lebanese pound', 'real-estate-manager' ),
				'LKR' => __( 'Sri Lankan rupee', 'real-estate-manager' ),
				'LRD' => __( 'Liberian dollar', 'real-estate-manager' ),
				'LSL' => __( 'Lesotho loti', 'real-estate-manager' ),
				'LYD' => __( 'Libyan dinar', 'real-estate-manager' ),
				'MAD' => __( 'Moroccan dirham', 'real-estate-manager' ),
				'MDL' => __( 'Moldovan leu', 'real-estate-manager' ),
				'MGA' => __( 'Malagasy ariary', 'real-estate-manager' ),
				'MKD' => __( 'Macedonian denar', 'real-estate-manager' ),
				'MMK' => __( 'Burmese kyat', 'real-estate-manager' ),
				'MNT' => __( 'Mongolian t&ouml;gr&ouml;g', 'real-estate-manager' ),
				'MOP' => __( 'Macanese pataca', 'real-estate-manager' ),
				'MRO' => __( 'Mauritanian ouguiya', 'real-estate-manager' ),
				'MUR' => __( 'Mauritian rupee', 'real-estate-manager' ),
				'MVR' => __( 'Maldivian rufiyaa', 'real-estate-manager' ),
				'MWK' => __( 'Malawian kwacha', 'real-estate-manager' ),
				'MXN' => __( 'Mexican peso', 'real-estate-manager' ),
				'MYR' => __( 'Malaysian ringgit', 'real-estate-manager' ),
				'MZN' => __( 'Mozambican metical', 'real-estate-manager' ),
				'NAD' => __( 'Namibian dollar', 'real-estate-manager' ),
				'NGN' => __( 'Nigerian naira', 'real-estate-manager' ),
				'NIO' => __( 'Nicaraguan c&oacute;rdoba', 'real-estate-manager' ),
				'NOK' => __( 'Norwegian krone', 'real-estate-manager' ),
				'NPR' => __( 'Nepalese rupee', 'real-estate-manager' ),
				'NZD' => __( 'New Zealand dollar', 'real-estate-manager' ),
				'OMR' => __( 'Omani rial', 'real-estate-manager' ),
				'PAB' => __( 'Panamanian balboa', 'real-estate-manager' ),
				'PEN' => __( 'Peruvian nuevo sol', 'real-estate-manager' ),
				'PGK' => __( 'Papua New Guinean kina', 'real-estate-manager' ),
				'PHP' => __( 'Philippine peso', 'real-estate-manager' ),
				'PKR' => __( 'Pakistani rupee', 'real-estate-manager' ),
				'PLN' => __( 'Polish z&#x142;oty', 'real-estate-manager' ),
				'PRB' => __( 'Transnistrian ruble', 'real-estate-manager' ),
				'PYG' => __( 'Paraguayan guaran&iacute;', 'real-estate-manager' ),
				'QAR' => __( 'Qatari riyal', 'real-estate-manager' ),
				'RON' => __( 'Romanian leu', 'real-estate-manager' ),
				'RSD' => __( 'Serbian dinar', 'real-estate-manager' ),
				'RUB' => __( 'Russian ruble', 'real-estate-manager' ),
				'RWF' => __( 'Rwandan franc', 'real-estate-manager' ),
				'SAR' => __( 'Saudi riyal', 'real-estate-manager' ),
				'SBD' => __( 'Solomon Islands dollar', 'real-estate-manager' ),
				'SCR' => __( 'Seychellois rupee', 'real-estate-manager' ),
				'SDG' => __( 'Sudanese pound', 'real-estate-manager' ),
				'SEK' => __( 'Swedish krona', 'real-estate-manager' ),
				'SGD' => __( 'Singapore dollar', 'real-estate-manager' ),
				'SHP' => __( 'Saint Helena pound', 'real-estate-manager' ),
				'SLL' => __( 'Sierra Leonean leone', 'real-estate-manager' ),
				'SOS' => __( 'Somali shilling', 'real-estate-manager' ),
				'SRD' => __( 'Surinamese dollar', 'real-estate-manager' ),
				'SSP' => __( 'South Sudanese pound', 'real-estate-manager' ),
				'STD' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra', 'real-estate-manager' ),
				'SYP' => __( 'Syrian pound', 'real-estate-manager' ),
				'SZL' => __( 'Swazi lilangeni', 'real-estate-manager' ),
				'THB' => __( 'Thai baht', 'real-estate-manager' ),
				'TJS' => __( 'Tajikistani somoni', 'real-estate-manager' ),
				'TMT' => __( 'Turkmenistan manat', 'real-estate-manager' ),
				'TND' => __( 'Tunisian dinar', 'real-estate-manager' ),
				'TOP' => __( 'Tongan pa&#x2bb;anga', 'real-estate-manager' ),
				'TRY' => __( 'Turkish lira', 'real-estate-manager' ),
				'TTD' => __( 'Trinidad and Tobago dollar', 'real-estate-manager' ),
				'TWD' => __( 'New Taiwan dollar', 'real-estate-manager' ),
				'TZS' => __( 'Tanzanian shilling', 'real-estate-manager' ),
				'UAH' => __( 'Ukrainian hryvnia', 'real-estate-manager' ),
				'UGX' => __( 'Ugandan shilling', 'real-estate-manager' ),
				'USD' => __( 'United States dollar', 'real-estate-manager' ),
				'UYU' => __( 'Uruguayan peso', 'real-estate-manager' ),
				'UZS' => __( 'Uzbekistani som', 'real-estate-manager' ),
				'VEF' => __( 'Venezuelan bol&iacute;var', 'real-estate-manager' ),
				'VND' => __( 'Vietnamese &#x111;&#x1ed3;ng', 'real-estate-manager' ),
				'VUV' => __( 'Vanuatu vatu', 'real-estate-manager' ),
				'WST' => __( 'Samoan t&#x101;l&#x101;', 'real-estate-manager' ),
				'XAF' => __( 'Central African CFA franc', 'real-estate-manager' ),
				'XCD' => __( 'East Caribbean dollar', 'real-estate-manager' ),
				'XOF' => __( 'West African CFA franc', 'real-estate-manager' ),
				'XPF' => __( 'CFP franc', 'real-estate-manager' ),
				'YER' => __( 'Yemeni rial', 'real-estate-manager' ),
				'ZAR' => __( 'South African rand', 'real-estate-manager' ),
				'ZMW' => __( 'Zambian kwacha', 'real-estate-manager' ),
			)
		)
	);
}

/**
 * Get Currency symbol.
 *
 * @param string $currency (default: '')
 * @return string
 */
function rem_get_currency_symbol( $currency = '' ) {
	if ( ! $currency ) {
		$currency = rem_get_option('currency', 'USD');
	}

	$symbols = apply_filters( 'rem_all_currency_symbols', array(
		'AED' => '&#x62f;.&#x625;',
		'AFN' => '&#x60b;',
		'ALL' => 'L',
		'AMD' => 'AMD',
		'ANG' => '&fnof;',
		'AOA' => 'Kz',
		'ARS' => '&#36;',
		'AUD' => '&#36;',
		'AWG' => '&fnof;',
		'AZN' => 'AZN',
		'BAM' => 'KM',
		'BBD' => '&#36;',
		'BDT' => '&#2547;&nbsp;',
		'BGN' => '&#1083;&#1074;.',
		'BHD' => '.&#x62f;.&#x628;',
		'BIF' => 'Fr',
		'BMD' => '&#36;',
		'BND' => '&#36;',
		'BOB' => 'Bs.',
		'BRL' => '&#82;&#36;',
		'BSD' => '&#36;',
		'BTC' => '&#3647;',
		'BTN' => 'Nu.',
		'BWP' => 'P',
		'BYR' => 'Br',
		'BZD' => '&#36;',
		'CAD' => '&#36;',
		'CDF' => 'Fr',
		'CHF' => '&#67;&#72;&#70;',
		'CLP' => '&#36;',
		'CNY' => '&yen;',
		'COP' => '&#36;',
		'CRC' => '&#x20a1;',
		'CUC' => '&#36;',
		'CUP' => '&#36;',
		'CVE' => '&#36;',
		'CZK' => '&#75;&#269;',
		'DJF' => 'Fr',
		'DKK' => 'DKK',
		'DOP' => 'RD&#36;',
		'DZD' => '&#x62f;.&#x62c;',
		'EGP' => 'EGP',
		'ERN' => 'Nfk',
		'ETB' => 'Br',
		'EUR' => '&euro;',
		'FJD' => '&#36;',
		'FKP' => '&pound;',
		'GBP' => '&pound;',
		'GEL' => '&#x10da;',
		'GGP' => '&pound;',
		'GHS' => '&#x20b5;',
		'GIP' => '&pound;',
		'GMD' => 'D',
		'GNF' => 'Fr',
		'GTQ' => 'Q',
		'GYD' => '&#36;',
		'HKD' => '&#36;',
		'HNL' => 'L',
		'HRK' => 'Kn',
		'HTG' => 'G',
		'HUF' => '&#70;&#116;',
		'IDR' => 'Rp',
		'ILS' => '&#8362;',
		'IMP' => '&pound;',
		'INR' => '&#8377;',
		'IQD' => '&#x639;.&#x62f;',
		'IRR' => '&#xfdfc;',
		'ISK' => 'kr.',
		'JEP' => '&pound;',
		'JMD' => '&#36;',
		'JOD' => '&#x62f;.&#x627;',
		'JPY' => '&yen;',
		'KES' => 'KSh',
		'KGS' => '&#x441;&#x43e;&#x43c;',
		'KHR' => '&#x17db;',
		'KMF' => 'Fr',
		'KPW' => '&#x20a9;',
		'KRW' => '&#8361;',
		'KWD' => '&#x62f;.&#x643;',
		'KYD' => '&#36;',
		'KZT' => 'KZT',
		'LAK' => '&#8365;',
		'LBP' => '&#x644;.&#x644;',
		'LKR' => '&#xdbb;&#xdd4;',
		'LRD' => '&#36;',
		'LSL' => 'L',
		'LYD' => '&#x644;.&#x62f;',
		'MAD' => '&#x62f;. &#x645;.',
		'MAD' => '&#x62f;.&#x645;.',
		'MDL' => 'L',
		'MGA' => 'Ar',
		'MKD' => '&#x434;&#x435;&#x43d;',
		'MMK' => 'Ks',
		'MNT' => '&#x20ae;',
		'MOP' => 'P',
		'MRO' => 'UM',
		'MUR' => '&#x20a8;',
		'MVR' => '.&#x783;',
		'MWK' => 'MK',
		'MXN' => '&#36;',
		'MYR' => '&#82;&#77;',
		'MZN' => 'MT',
		'NAD' => '&#36;',
		'NGN' => '&#8358;',
		'NIO' => 'C&#36;',
		'NOK' => '&#107;&#114;',
		'NPR' => '&#8360;',
		'NZD' => '&#36;',
		'OMR' => '&#x631;.&#x639;.',
		'PAB' => 'B/.',
		'PEN' => 'S/.',
		'PGK' => 'K',
		'PHP' => '&#8369;',
		'PKR' => '&#8360;',
		'PLN' => '&#122;&#322;',
		'PRB' => '&#x440;.',
		'PYG' => '&#8370;',
		'QAR' => '&#x631;.&#x642;',
		'RMB' => '&yen;',
		'RON' => 'lei',
		'RSD' => '&#x434;&#x438;&#x43d;.',
		'RUB' => '&#8381;',
		'RWF' => 'Fr',
		'SAR' => '&#x631;.&#x633;',
		'SBD' => '&#36;',
		'SCR' => '&#x20a8;',
		'SDG' => '&#x62c;.&#x633;.',
		'SEK' => '&#107;&#114;',
		'SGD' => '&#36;',
		'SHP' => '&pound;',
		'SLL' => 'Le',
		'SOS' => 'Sh',
		'SRD' => '&#36;',
		'SSP' => '&pound;',
		'STD' => 'Db',
		'SYP' => '&#x644;.&#x633;',
		'SZL' => 'L',
		'THB' => '&#3647;',
		'TJS' => '&#x405;&#x41c;',
		'TMT' => 'm',
		'TND' => '&#x62f;.&#x62a;',
		'TOP' => 'T&#36;',
		'TRY' => '&#8378;',
		'TTD' => '&#36;',
		'TWD' => '&#78;&#84;&#36;',
		'TZS' => 'Sh',
		'UAH' => '&#8372;',
		'UGX' => 'UGX',
		'USD' => '&#36;',
		'UYU' => '&#36;',
		'UZS' => 'UZS',
		'VEF' => 'Bs F',
		'VND' => '&#8363;',
		'VUV' => 'Vt',
		'WST' => 'T',
		'XAF' => 'Fr',
		'XCD' => '&#36;',
		'XOF' => 'Fr',
		'XPF' => 'Fr',
		'YER' => '&#xfdfc;',
		'ZAR' => '&#82;',
		'ZMW' => 'ZK',
	) );

	$currency_symbol = isset( $symbols[ $currency ] ) ? $symbols[ $currency ] : '';

	return apply_filters( 'rem_currency_symbol', $currency_symbol, $currency );
}

/**
 * Get the price format depending on the currency position.
 *
 * @return string
 */
function rem_get_price_format() {
	$currency_pos = rem_get_option( 'currency_position', 'left' );
	$format = '%1$s%2$s';

	switch ( $currency_pos ) {
		case 'left' :
			$format = '%1$s%2$s';
		break;
		case 'right' :
			$format = '%2$s%1$s';
		break;
		case 'left_space' :
			$format = '%1$s&nbsp;%2$s';
		break;
		case 'right_space' :
			$format = '%2$s&nbsp;%1$s';
		break;
	}

	return apply_filters( 'rem_price_format', $format, $currency_pos );
}

/**
 * Return the thousand separator for prices.
 * @since  4.1
 * @return string
 */
function rem_get_price_thousand_separator() {
	$separator = stripslashes( rem_get_option( 'thousand_separator' ) );
	return $separator;
}

/**
 * Return the decimal separator for prices.
 * @since  4.1
 * @return string
 */
function rem_get_price_decimal_separator() {
	$separator = stripslashes( rem_get_option( 'decimal_separator' ) );
	return $separator ? $separator : '.';
}

/**
 * Return the number of decimals after the decimal point.
 * @since  4.1
 * @return int
 */
function rem_get_price_decimals() {
	return absint( rem_get_option( 'decimal_points', 2 ) );
}

/**
 * Format the price with a currency symbol.
 *
 * @param float $price
 * @param array $args (default: array())
 * @return string
 */
function rem_get_property_price( $price, $args = array() ) {
	$price_digits = $price;
	extract( apply_filters( 'rem_price_args', wp_parse_args( $args, array(
		'currency'           => rem_get_option('currency', 'USD'),
		'decimal_separator'  => rem_get_price_decimal_separator(),
		'thousand_separator' => rem_get_price_thousand_separator(),
		'decimals'           => rem_get_price_decimals(),
		'price_format'       => rem_get_price_format()
	) ) ) );
	$negative = $price < 0;
	if (is_numeric($price)) {
		$price  = apply_filters( 'raw_rem_price', floatval( $negative ? $price * -1 : $price ) );
		$price  = apply_filters( 'formatted_rem_price', number_format( $price, $decimals, $decimal_separator, $thousand_separator ), $price, $decimals, $decimal_separator, $thousand_separator );
	}

	if ( apply_filters( 'rem_price_trim_zeros', false ) && $decimals > 0 ) {
		$price = rem_trim_zeros( $price );
	}

	$formatted_price = ( $negative ? '-' : '' ) . sprintf( $price_format, '<span class="rem-currency-symbol">' . rem_get_currency_symbol( $currency ) . '</span>', $price );
	$return          = '<span class="rem-price-amount">' . $formatted_price . '</span>';

	return apply_filters( 'rem_property_price', $return, $price, $args, $price_digits );
}

function rem_trim_zeros( $price ) {
	return preg_replace( '/' . preg_quote( rem_get_price_decimal_separator(), '/' ) . '0++$/', '', $price );
}

function rem_get_single_property_settings_tabs(){
	$savedTabs = get_option('rem_property_field_sections');
	if ($savedTabs != '' && is_array($savedTabs)) {
		$tabsData = $savedTabs;
	} else {
		$tabsData = array(
			array(
				'title' 	=> __( 'Details', 'real-estate-manager' ),
				'key'		=> 'general_settings',
				'icon'		=> '',
				'accessibility' => 'public'
			),
			array(
				'title' 	=> __( 'Internal Structure', 'real-estate-manager' ),
				'key'		=> 'internal_structure',
				'icon'		=> '',
				'accessibility' => 'public'
			),
			array(
				'title' 	=> __( 'Features', 'real-estate-manager' ),
				'key'		=> 'property_details',
				'icon'		=> '',
				'accessibility' => 'public'
			),
			array(
				'title' 	=> __( 'Attachments', 'real-estate-manager' ),
				'key'		=> 'property_attachments',
				'icon'		=> '',
				'accessibility' => 'public'
			),
			array(
				'title' 	=> __( 'Video', 'real-estate-manager' ),
				'key'		=> 'property_video',
				'icon'		=> '',
				'accessibility' => 'public'
			),
			array(
				'title' 	=> __( 'Private Fields', 'real-estate-manager' ),
				'key'		=> 'private_fields',
				'icon'		=> '',
				'accessibility' => 'agent'
			),
		);

	    if (rem_get_option('property_settings_tabs', '') != '') {
	        $additional_tabs = explode("\n", rem_get_option('property_settings_tabs'));
	        foreach ($additional_tabs as $tab_title) {
	            if ($tab_title != '') {
	                $tab_key = str_replace(' ', '_', $tab_title);
	                $tab_key = strtolower($tab_key);
	                $tab_key = preg_replace('/[^A-Za-z0-9\-]/', '', $tab_key);
	            	$tabsData[] = array(
						'title' 	=> $tab_title,
						'key'		=> $tab_key,
						'icon'		=> '',
						'accessibility' => 'public'
	            	);
	            }
	        }
	    }
	}

    if(has_filter('rem_single_property_sections')) {
        $tabsData = apply_filters('rem_single_property_sections', $tabsData);
    }

    return $tabsData;
}

function rem_get_agent_fields_tabs(){
	$tabsData = array(
		'personal_info' => __( 'Personal Info', 'real-estate-manager' ),
		'social_profiles' => __( 'Social Profiles', 'real-estate-manager' ),
		'skills' => __( 'Skills', 'real-estate-manager' ),
	);

    if(has_filter('rem_agent_fields_tabs')) {
        $tabsData = apply_filters('rem_agent_fields_tabs', $tabsData);
    }

    return $tabsData;
}

/**
 * Get all property listing styles to be used in WP Bakery Shortcodes
 * @since 10.3.3
 */
function rem_get_property_listing_styles(){
	$styles = array(
        __('Style 1 - Inline', 'real-estate-manager') => '1',
        __('Style 2 - Static Box', 'real-estate-manager') => '2',
        __('Style 3 - Hover Box', 'real-estate-manager') => '3',
        __('Style 4 - Mini Box', 'real-estate-manager') => '4',
        __('Style 5 - Full Box', 'real-estate-manager') => '5',
        __('Style 6 - Fade Thumbnails', 'real-estate-manager') => '6',
        __('Style 7 - Map Box', 'real-estate-manager') => '7',
        __('Style 1 - Deprecated', 'real-estate-manager') => '101',
        __('Style 2 - Deprecated', 'real-estate-manager') => '102',
	);

    if(has_filter('rem_property_listing_styles')) {
        $styles = apply_filters('rem_property_listing_styles', $styles);
    }

    return $styles;
}

/**
 * Renders property edit fields in backend
 */
function rem_render_field($field, $quick_edit = false){
	global $post;
	if(isset($post->ID)){
		$saved_value = get_post_meta( $post->ID, 'rem_'.$field['key'], true );
	} else {
		$saved_value = '';
	}

	$value = ($saved_value != '') ? $saved_value : $field['default'];
	$value = str_replace("\"", "'", $value);
	$required = (isset($field['required']) && $field['required'] == 'true' ) ? 'required' : '' ;

	switch ($field['type']) {
		case has_action( "rem_render_property_field_admin_{$field['key']}" ) :
		    do_action( "rem_render_property_field_admin_{$field['key']}", $field, $value );
		    break;
		case has_action( "rem_render_property_field_admin_type_{$field['type']}" ) :
		    do_action( "rem_render_property_field_admin_type_{$field['type']}", $field, $value );
		    break;
		case 'text':
		case 'shortcode':
		case 'video':
		case 'number':
		case 'date':
			$max = isset($field['max_value']) ? 'max="'.$field['max_value'].'"' : '';
			$min = isset($field['min_value']) ? 'min="'.$field['min_value'].'"' : '';
			$step = ($field['type'] == 'number') ? 'step=".01"' : '';
			echo '<input '.esc_attr($required).' '.esc_attr($step).' '.esc_attr($max).' '.esc_attr($min).' id="'.esc_attr($field['key']).'" class="form-control input-sm" type="'.esc_attr($field['type']).'" name="rem_property_data['.esc_attr($field['key']).']" value="'.stripcslashes(esc_attr($value)).'">';
			break;
			
		case 'button':
			echo '<input '.esc_attr($required).' id="'.esc_attr($field['key']).'" class="form-control input-sm" type="text" name="rem_property_data['.esc_attr($field['key']).']" value="'.stripcslashes(esc_attr($value)).'">';
			break;

		case 'select':
			?>
			<select <?php echo esc_attr($required); ?> id="<?php echo esc_attr($field['key']); ?>" name="rem_property_data[<?php echo esc_attr($field['key']); ?>]" class="form-control input-sm">
				<?php if($field['key'] != 'property_featured'){ ?>
					<option value="">--
						<?php if ($quick_edit) {
							echo __( 'No Change', 'real-estate-manager' );
						} else {
							echo __( 'Any', 'real-estate-manager' ).' '.esc_attr($field['title']);
						} ?>
					--</option>
				<?php } ?>
				<?php
					$options = (is_array($field['options'])) ? $field['options'] : explode("\n", $field['options']);
					foreach ($options as $name) {
						$translated_label = rem_wpml_translate($name, 'real-estate-manager-fields');
						echo '<option value="'.esc_attr($name).'" '.selected( $value, $name, false ).'>'.esc_attr($translated_label).'</option>';
					}
				?>
			</select>
			<?php 
			break;

		case 'countries':
			$countries_obj   = new REM_Countries();
			$countries   = $countries_obj->get_countries();
			?>
			<select <?php echo esc_attr($required); ?> id="<?php echo esc_attr($field['key']); ?>" name="rem_property_data[<?php echo esc_attr($field['key']); ?>]" class="form-control input-sm rem-countries-list">
				<option value="">-- <?php echo __( 'Any', 'real-estate-manager' ).' '.esc_attr($field['title']); ?> --</option>
				<?php
					foreach ($countries as $code => $name) {
						echo '<option value="'.esc_attr($code).'" '.selected( $value, $code, false ).'>'.esc_attr($name).'</option>';
					}
				?>
			</select>
			<?php
			break;

		case 'states': ?>
			<select <?php echo esc_attr($required); ?> data-state="<?php echo esc_attr($value); ?>" id="<?php echo esc_attr($field['key']); ?>" name="rem_property_data[<?php echo esc_attr($field['key']); ?>]" class="form-control input-sm rem-states-list">
				<option value="">-- <?php echo __( 'Any', 'real-estate-manager' ).' '.esc_attr($field['title']); ?> --</option>
			</select>
			<?php
			break;

		case 'select2':
			?>
			<select <?php echo esc_attr($required); ?> multiple id="<?php echo esc_attr($field['key']); ?>" name="rem_property_data[<?php echo esc_attr($field['key']); ?>][]" class="form-control input-sm rem-select2-field">
				<?php
				
					$multi_value = !empty($saved_value) ? $saved_value : $field['default'];
				
					$options = (is_array($field['options'])) ? $field['options'] : explode("\n", $field['options']);
					foreach ($options as $name) {
						$translated_label = rem_wpml_translate($name, 'real-estate-manager-fields');
						$selected = (is_array($multi_value) && in_array( $name,$multi_value)) ? 'selected' : '';

						echo '<option  '.esc_attr($selected).' value="'.esc_attr($name).'" >'.esc_attr($translated_label).'</option>';
					}
				?>
			</select>
			<?php 
			break;

		case 'upload': ?>
			<div class="upload-attachments-wrap">
				<p>
					<button type="button"
						class="upload-attachment btn btn-info"
						data-title="<?php esc_attr_e( 'Select attachments for property', 'real-estate-manager' ); ?>"
						data-field_key="<?php echo esc_attr($field['key']); ?>"
						data-max_files="<?php echo (isset($field['max_files'])) ? esc_attr( $field['max_files'] ) : '' ; ?>"
						data-file_type="<?php echo (isset($field['file_type'])) ? esc_attr( $field['file_type'] ) : '' ; ?>"
						data-max_files_msg="<?php echo (isset($field['max_files_msg'])) ? esc_attr( $field['max_files_msg'] ) : '' ; ?>"
						data-btntext="<?php esc_attr_e( 'Add', 'real-estate-manager' ); ?>">
						<span class="dashicons dashicons-paperclip"></span>
						<?php echo esc_attr($field['title']); ?>
					</button>
				</p>
				<div class="row attachments-prev">
					<?php
						if ($value != '') {
							if (!is_array($value)) {
								$value = explode("\n", $value);
							}
							if (is_array($value)) {
							    foreach ($value as $id) {
							        $attachment_url = wp_get_attachment_image_src( $id, 'thumbnail', true ); ?>
							        <div class="col-sm-4">
							            <div class="rem-preview-image">
							                <input type="hidden" name="rem_property_data[<?php echo esc_attr($field['key']); ?>][<?php echo esc_attr(trim($id)); ?>]" value="<?php echo esc_attr($id); ?>">
							                <div class="rem-image-wrap">
							                    <img class="attachment-icon" src="<?php echo esc_url($attachment_url[0]); ?>">
							                    <span class="attachment-name"><a target="_blank" href="<?php echo esc_url(wp_get_attachment_url( $id )); ?>"><?php echo esc_html(get_the_title( $id )); ?></a></span>
							                </div>
							                <div class="rem-actions-wrap">
							                    <a href="javascript:void(0)" class="btn remove-image btn-sm">
							                        <i class="fa fa-times"></i>
							                    </a>
							                </div>
							            </div>
							        </div>
							    <?php }
							}
						}
					?>
				</div>
			</div>
			<?php
			break;

		case 'widget':
			?>
			<select <?php echo esc_attr($required); ?> name="rem_property_data[<?php echo esc_attr($field['key']); ?>]" class="form-control input-sm">
				<?php
					foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
						echo '<option value="'.esc_attr($sidebar['id']).'" '.selected( $saved_m[$field['key']], $sidebar['id'], true ).'>'.esc_attr($sidebar['name']).'</option>';
					}
				?>
			</select>
			<?php 
			break;

		case 'textarea':
			?>
			<textarea <?php echo esc_attr($required); ?> name="rem_property_data[<?php echo esc_attr($field['key']); ?>]" class="form-control input-sm"><?php echo esc_attr($value); ?></textarea>
			<?php 
			break;

		case 'checkbox':
			$saved_value = get_post_meta( $post->ID, 'rem_property_detail_cbs', true );
			$feature_key = stripcslashes($field['key']);
			$value = (isset($saved_value[$feature_key])) ? $saved_value[$feature_key] : $field['default'];
			?>
			<div class="onoffswitch">
			    <input type="checkbox" <?php checked( $value, 'on', true); ?> value="on" name="rem_property_data[property_detail_cbs][<?php echo esc_attr($feature_key); ?>]" class="onoffswitch-checkbox" id="<?php echo esc_attr($field['key']); ?>">
			    <label class="onoffswitch-label" for="<?php echo esc_attr($field['key']); ?>">
			        <span class="onoffswitch-inner" data-off="<?php esc_attr_e( 'NO', 'real-estate-manager' ); ?>" data-on="<?php esc_attr_e( 'YES', 'real-estate-manager' ); ?>"></span>
			        <span class="onoffswitch-switch"></span>
			    </label>
			</div>
			<?php 
			break;
		
		default:
			
			break;
	}
	
}

/**
 * Renders Special fields for searching from shortcode or widget
 * @since 10.4.2
 */
function rem_render_special_search_fields($key, $labels = false){
	$dashes = apply_filters( 'rem_search_dropdowns_dashes', '--' );
	$dropdown_class = rem_get_option('dropdown_style', 'rem-easydropdown');
	switch ($key) {
		case 'order': ?>
			<?php if($labels){ ?>
				<label for="order"><?php esc_attr_e( 'Order', 'real-estate-manager' ) ?></label>
			<?php } ?>
			<select class="<?php echo esc_attr($dropdown_class); ?>" data-settings='{"cutOff": 5}' name="order" id="order">
				<option value=""><?php echo esc_attr($dashes); ?> <?php esc_attr_e( 'Order', 'real-estate-manager' ); ?> <?php echo esc_attr($dashes); ?></option>
				<option value="DESC" <?php echo (isset($_GET['order']) && $_GET['order'] == 'DESC') ? 'selected' : '' ; ?>><?php esc_attr_e( 'Descending', 'real-estate-manager' ); ?></option>
				<option value="ASC" <?php echo (isset($_GET['order']) && $_GET['order'] == 'ASC') ? 'selected' : '' ; ?>><?php esc_attr_e( 'Ascending', 'real-estate-manager' ); ?></option>
			</select>
			<?php break;
		case 'tags': ?>
			<?php if($labels){ ?>
				<label for="order"><?php esc_attr_e( 'Tag', 'real-estate-manager' ) ?></label>
			<?php } ?>
			<select class="<?php echo esc_attr($dropdown_class); ?>" data-settings='{"cutOff": 5}' name="tag" id="tag">
				<option value=""><?php echo esc_attr($dashes); ?> <?php esc_attr_e( 'Tag', 'real-estate-manager' ); ?> <?php echo esc_attr($dashes); ?></option>
				<?php 
					$tags = get_terms( 'rem_property_tag' );
					foreach ($tags as $tag_ob) { ?>
						<option value="<?php echo esc_attr($tag_ob->term_id); ?>" <?php echo (isset($_GET['tag']) && $_GET['tag'] == $tag_ob->term_id) ? 'selected' : '' ; ?>><?php echo esc_attr($tag_ob->name); ?></option>
					<?php }
				?>
			</select>
			<?php break;
		case 'categories': ?>
			<?php if($labels){ ?>
				<label for="order"><?php esc_attr_e( 'Category', 'real-estate-manager' ) ?></label>
			<?php } ?>
			<select class="<?php echo esc_attr($dropdown_class); ?>" data-settings='{"cutOff": 5}' name="category" id="category">
				<option value=""><?php echo esc_attr($dashes); ?> <?php esc_attr_e( 'Category', 'real-estate-manager' ); ?> <?php echo esc_attr($dashes); ?></option>
				<?php 
					$cats = get_terms( 'rem_property_cat' );
					foreach ($cats as $cat_ob) { ?>
						<option value="<?php echo esc_attr($cat_ob->term_id); ?>" <?php echo (isset($_GET['category']) && $_GET['category'] == $cat_ob->term_id) ? 'selected' : '' ; ?>><?php echo esc_attr($cat_ob->name); ?></option>
					<?php }
				?>
			</select>
			<?php break;
		case 'property_id': ?>
			<?php if($labels){ ?>
				<label for="order"><?php esc_attr_e( 'Property ID', 'real-estate-manager' ) ?></label>
			<?php } ?>
			<input type="text" placeholder="<?php esc_attr_e( 'Property ID', 'real-estate-manager' ); ?>" name="property_id" class="form-control" value="<?php echo (isset($_GET['property_id'])) ? esc_attr($_GET['property_id']) : '' ; ?>">
			<?php break;
		case 'orderby': ?>
			<?php if($labels){ ?>
				<label for="order"><?php esc_attr_e( 'Order By', 'real-estate-manager' ) ?></label>
			<?php } ?>
			<select class="<?php echo esc_attr($dropdown_class); ?>" data-settings='{"cutOff": 5}' name="orderby" id="orderby">
				<option value=""><?php echo esc_attr($dashes); ?> <?php esc_attr_e( 'Order By', 'real-estate-manager' ); ?> <?php echo esc_attr($dashes); ?></option>
				<option value="title" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'title') ? 'selected' : '' ; ?>><?php esc_attr_e( 'Title', 'real-estate-manager' ); ?></option>
				<option value="date" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'date') ? 'selected' : '' ; ?>><?php esc_attr_e( 'Date', 'real-estate-manager' ); ?></option>
				<option value="price" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'price') ? 'selected' : '' ; ?>><?php esc_attr_e( 'Price', 'real-estate-manager' ); ?></option>
			</select>
			<?php break;
		case 'agent': ?>
			<?php if($labels){ ?>
				<label for="order"><?php esc_attr_e( 'Agent', 'real-estate-manager' ) ?></label>
			<?php } ?>
			<select class="<?php echo esc_attr($dropdown_class); ?>" data-settings='{"cutOff": 5}' name="agent_id" id="agent_id">
				<option value=""><?php echo esc_attr($dashes); ?> <?php esc_attr_e( 'Agent', 'real-estate-manager' ); ?> <?php echo esc_attr($dashes); ?></option>
				<?php 
					$all_agents = get_users( 'role=rem_property_agent' );
					foreach ($all_agents as $agent) { ?>
						<option value="<?php echo esc_attr($agent->ID); ?>" <?php echo (isset($_GET['agent_id']) && $_GET['agent_id'] == $agent->ID) ? 'selected' : '' ; ?>><?php echo rem_wpml_translate($agent->display_name, 'Agent', 'display_name_'.esc_attr($agent->ID)); ?></option>
					<?php }
				?>
			</select>
			<?php break;
		
		default:
			
			break;
	}
}
/**
 * Renders property search fields for both pages and widgets
 * @since 10.4.2
 */
function rem_render_property_search_fields($field, $display = 'widget', $labels = false){

	// Special Fields to convert into dropdowns
	$meta_keys = array(
		'property_area' => 'search_area_options',
		'property_bedrooms' => 'search_bedrooms_options',
		'property_bathrooms' => 'search_bathrooms_options',
	);
	$dropdown_class = rem_get_option('dropdown_style', 'rem-easydropdown');
	$meta_keys = apply_filters( 'rem_dropdown_search_fields_keys', $meta_keys );
	$dashes = apply_filters( 'rem_search_dropdowns_dashes', '--' );

	if ($labels) {
		echo '<label for="'.esc_attr( $field['key'] ).'">'.rem_wpml_translate($field['title'], 'real-estate-manager-fields').'</label>';
	}

	// rendering dropdown regarding above
	if (has_action( "rem_render_property_search_field_{$field['key']}" )) {
		do_action( "rem_render_property_search_field_{$field['key']}", $field );
	} elseif (has_action( "rem_render_property_search_field_type_{$field['type']}" )) {
		do_action( "rem_render_property_search_field_type_{$field['type']}", $field, $display );
	} elseif (array_key_exists($field['key'], $meta_keys) && rem_get_option($meta_keys[$field['key']], '') != '') { ?>
		<select class="<?php echo esc_attr($dropdown_class); ?>" data-settings='{"cutOff": 5}' name="<?php echo esc_attr($field['key']); ?>" id="<?php echo esc_attr($field['key']); ?>">
			<?php if(!$labels){ ?>
				<option value=""><?php echo esc_attr($dashes); ?> <?php echo ($display == 'widget') ? __( 'Any', 'real-estate-manager' ) : rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?> <?php echo esc_attr($dashes); ?></option>
			<?php } ?>
			<?php
				$options = explode("\n", rem_get_option($meta_keys[$field['key']]));
				foreach ($options as $title) {
					$titleVal = explode("|", $title);
					if (isset($titleVal[1])) {
						$label = stripcslashes($titleVal[1]);
					} else {
						$label = stripcslashes($titleVal[0]);
					}
					$selected = '';
					if(isset($_GET[$field['key']]) && $_GET[$field['key']] == trim($title)){
						$selected = 'selected';
					}
					echo '<option value="'.trim($titleVal[0]).'" '.$selected.'>'.$label.'</option>';
				}
			?>
		</select>
	<?php } elseif ($field['type'] == 'select') { ?>
		<select class="<?php echo esc_attr($dropdown_class); ?>" data-settings='{"cutOff": 5}' name="<?php echo esc_attr($field['key']); ?>" id="<?php echo esc_attr($field['key']).esc_attr($display); ?>">
			<option value=""><?php echo esc_attr($dashes); ?> <?php echo ($display == 'widget') ? __( 'Any', 'real-estate-manager' ) : rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?> <?php echo esc_attr($dashes); ?></option>
				<?php
					foreach ($field['options'] as $title) {
						$title = stripcslashes($title);
						$selected = '';
						if(isset($_GET[$field['key']]) && $_GET[$field['key']] == trim($title)){
							$selected = 'selected';
						}
						if (isset($field['default']) && $field['default'] == trim($title)) {
							$selected = 'selected';
						}
						echo '<option value="'.trim(esc_attr($title)).'" '.esc_attr($selected).'>'.rem_wpml_translate($title, 'real-estate-manager-fields').'</option>';
					}
				?>
		</select>
		<?php } elseif ($field['type'] == 'countries') { ?>
		<select class="form-control rem-countries-list" data-settings='{"cutOff": 5}' name="<?php echo esc_attr($field['key']); ?>" id="<?php echo esc_attr($field['key']).esc_attr($display); ?>">
			<option value=""><?php echo esc_attr($dashes); ?> <?php echo ($display == 'widget') ? __( 'Any', 'real-estate-manager' ) : rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?> <?php echo esc_attr($dashes); ?></option>
				<?php
					$countries_obj   = new REM_Countries();
					$countries   = $countries_obj->get_countries();
					foreach ($countries as $code => $title) {
						$selected = '';
						if(isset($_GET[$field['key']]) && $_GET[$field['key']] == $code){
							$selected = 'selected';
						}
						if (isset($field['default']) && $field['default'] == $code) {
							$selected = 'selected';
						}
						echo '<option value="'.esc_attr($code).'" '.esc_attr($selected).'>'.esc_attr($title).'</option>';
					}
				?>
		</select>
		<?php } elseif ($field['type'] == 'states') { ?>
		<select class="form-control rem-states-list" data-state="<?php echo (isset($_GET[$field['key']])) ? esc_attr( $_GET[$field['key']] ) : esc_attr( $field['default'] ); ?>" data-settings='{"cutOff": 5}' name="<?php echo esc_attr($field['key']); ?>" id="<?php echo esc_attr($field['key']).esc_attr($display); ?>">
			<option value=""><?php echo esc_attr($dashes); ?> <?php echo ($display == 'widget') ? __( 'Any', 'real-estate-manager' ) : rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?> <?php echo esc_attr($dashes); ?></option>
		</select>
		<?php } elseif ($field['type'] == 'select2') { ?>
		<select multiple class="rem-select2-field" name="<?php echo esc_attr($field['key']); ?>[]" id="<?php echo esc_attr($field['key']).esc_attr($display); ?>[]" data-placeholder="<?php echo esc_attr($dashes); ?> <?php echo ($display == 'widget') ? __( 'Any', 'real-estate-manager' ) : rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?> <?php echo esc_attr($dashes); ?>">
			<option value=""><?php echo esc_attr($dashes); ?> <?php echo ($display == 'widget') ? __( 'Any', 'real-estate-manager' ) : rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?> <?php echo esc_attr($dashes); ?></option>
				<?php
					foreach ($field['options'] as $title) {
						$title = stripcslashes($title);
						$selected = '';
						if(isset($_GET[$field['key']]) && in_array(trim($title), $_GET[$field['key']])){
							$selected = 'selected';
						}
						echo '<option value="'.trim(esc_attr($title)).'" '.esc_attr($selected).'>'.rem_wpml_translate($title, 'real-estate-manager-fields').'</option>';
					}
				?>
		</select>
		<?php } elseif ($field['type'] == 'number' && $field['range_slider'] == 'range_slider') {
	        $default_min_value = isset($field['min_value']) && $field['min_value'] != '' ? round($field['min_value']) : 0;
	        $default_max_value = isset($field['max_value']) && $field['max_value'] != '' ? round($field['max_value']) : 9999;
	        rem_render_range_field($field, $default_min_value, $default_max_value );

	    } elseif ($field['type'] == 'number' && $field['range_slider'] == 'min_max') { ?>
	    	<div class="rem-min-max-number-fields">
	    		<div class="rem-min-number-field">
	    			<input type="number"
	    			class="form-control"
	    			name="range[<?php echo esc_attr($field['key']); ?>][min]"
	    			placeholder="<?php esc_attr_e( 'Min', 'real-estate-manager' ); ?>"
	    			value="<?php echo (isset($_GET['range'][$field['key']]['min'])) ? esc_attr( $_GET['range'][$field['key']]['min'] ) : '' ; ?>">
	    		</div>
	    		<?php if ($display != 'widget') { ?>
	    			<div class="rem-title-number-field"><?php echo esc_attr($field['title']); ?></div>
	    		<?php } else { ?>
	    			<div class="rem-title-number-field">-</div>
	    		<?php } ?>
	    		<div class="rem-max-number-field">
	    			<input type="number"
	    			class="form-control"
	    			name="range[<?php echo esc_attr($field['key']); ?>][max]"
	    			placeholder="<?php esc_attr_e( 'Max', 'real-estate-manager' ); ?>"
	    			value="<?php echo (isset($_GET['range'][$field['key']]['max'])) ? esc_attr( $_GET['range'][$field['key']]['max'] ) : '' ; ?>">
	    		</div>
	    	</div>
	    	<?php
	    } else {
    	if(rem_get_option('prefill_search_fields', '') == 'enable'){
    		$results  = array();
		    $args = array(
		        'post_type' =>  'rem_property',
		        'post_status' => 'publish',
		        'posts_per_page' => 1000
		    );
		    $the_query = new WP_Query( $args );
		    if ( $the_query->have_posts() ) :
		    	while ( $the_query->have_posts() ) : $the_query->the_post();
		                $value = get_post_meta( get_the_id(), 'rem_'.$field['key'], true );
		                $value = trim($value);
		                if (!in_array($value, $results) && $value != '') {
		                	$results[] = $value;
		                }
		        endwhile;
		        if (!empty($results)) { ?>
					<select class="<?php echo esc_attr($dropdown_class); ?>" data-settings='{"cutOff": 5}' name="<?php echo esc_attr($field['key']); ?>" id="<?php echo esc_attr($field['key']).esc_attr($display); ?>">
						<option value=""><?php echo esc_attr($dashes); ?> <?php echo ($display == 'widget') ? __( 'Any', 'real-estate-manager' ) : rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?> <?php echo esc_attr($dashes); ?></option>
							<?php
								if (has_filter( 'rem_search_auto_options')) {
									$results = apply_filters( 'rem_search_auto_options', $results, $field );
								} else {
									sort($results);
								}
								
								foreach ($results as $title) {
									$title = stripcslashes($title);
									$selected = '';
									if(isset($_GET[$field['key']]) && $_GET[$field['key']] == trim($title)){
										$selected = 'selected';
									}
									echo '<option value="'.trim($title).'" '.esc_attr( $selected ).'>'.$title.'</option>';
								}
							?>
					</select>
		        <?php } else { ?>
					<input class="form-control" type="text" placeholder="<?php echo esc_attr($field['title']); ?>" name="<?php echo esc_attr($field['key']); ?>" id="<?php echo esc_attr($field['key']); ?>" value="<?php echo (isset($_GET[$field['key']])) ? esc_attr( $_GET[$field['key']] ) : '' ; ?>"/>
		        <?php } ?>
		        <?php wp_reset_postdata();

		    else : ?>
				<input class="form-control" type="text" placeholder="<?php echo rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?>" name="<?php echo esc_attr($field['key']); ?>" id="<?php echo esc_attr($field['key']); ?>" value="<?php echo (isset($_GET[$field['key']])) ? esc_attr( $_GET[$field['key']] ) : '' ; ?>"/>
		    <?php endif;		    
    	} else { ?>
			<input class="form-control" type="text" placeholder="<?php echo rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?>" name="<?php echo esc_attr($field['key']); ?>" id="<?php echo esc_attr($field['key']); ?>" value="<?php echo (isset($_GET[$field['key']])) ? esc_attr( $_GET[$field['key']] ) : '' ; ?>"/>
    	<?php }
		?>
	<?php }
}

/**
 * Search widget fields
 * @since 10.8.1
 */

function rem_render_property_dropdown_fields($field, $fixed_fields){
	
	$fixed_args = array(
        'post_type' =>  'rem_property',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );
	if (!empty($fixed_fields)) {
		foreach ($fixed_fields as $key => $value) {
			$fixed_args['meta_query'][] = array(
	            array(
	                'key'     => 'rem_'.$key,
	                'value'   => $value,
	                'compare' => 'LIKE',
	            ),
	        );
		}
	}
	if ($field['type'] == 'select' || $field['type'] == 'select2' ) { ?>
		<div class="rem-ajax-search-widget" data-settings='{"cutOff": 5}' name="<?php echo esc_attr($field['key']); ?>" id="<?php echo esc_attr($field['key']).esc_attr($display); ?>">
			<?php
			foreach ($field['options'] as $key => $title) {
				$title = stripcslashes($title);
				$args = $fixed_args;
				$args['meta_query'][] = array(
		            array(
		                'key'     => 'rem_'.$field['key'],
		                'value'   => $title,
		                'compare' => 'LIKE',
		            ),
		        );
				$query = new WP_Query( $args );
				echo '<div class="checkbox"><label><input type="checkbox" name="'.esc_attr($field['key']).'[]" value="'.esc_attr($title).'"> '.rem_wpml_translate($title, 'real-estate-manager-fields').' ('.$query->found_posts.')</label></div>';
			}
			?>
		</div>
		<?php }
}
/**
 * Controls the inputs for price ranges for searching
 * @since 10.4.2
 */
function rem_render_price_range_field($display = 'widget', $labels = false){
	$price_symbol = rem_get_currency_symbol();
	$price_symbol = apply_filters( 'rem_price_range_currency_symbol', $price_symbol, $display );
	$dashes = apply_filters( 'rem_search_dropdowns_dashes', '--' );
	$dropdown_class = rem_get_option('dropdown_style', 'rem-easydropdown');
	if ($labels) {
		echo '<label>'.__( 'Price', 'real-estate-manager' ).'</label>';
	}
	if (has_filter( 'rem_render_price_range_field' )) {
		apply_filters( 'rem_render_price_range_field', $display );
		return;
	} else if (rem_get_option('search_price_range', 'slider') == 'slider') { ?>
		<?php if ($display == 'widget') { ?>
			<label><?php esc_attr_e( 'Price', 'real-estate-manager' ); ?></label>
		<?php } ?>
		<div class="slider price-range"></div>
		<div class="price-slider price text-center">
	        <span id="price-value-min"></span> 
	        <span class="separator"><?php echo esc_attr($price_symbol) ?></span>
	        <span id="price-value-max"></span>
	    </div>
	    <input type="hidden" name="price_min" id="min-value">
	    <input type="hidden" name="price_max" id="max-value">
	<?php } elseif (rem_get_option('search_price_range', 'slider') == 'min_max_dropdown') { ?>
		<select class="<?php echo esc_attr($dropdown_class); ?> rem_price_dropdown" data-settings='{"cutOff": 5}' >
			<option value=""><?php echo esc_attr($dashes); ?> <?php echo __( 'Price', 'real-estate-manager' ); ?> <?php echo esc_attr($dashes); ?></option>
				<?php
				if (!empty(rem_get_option('price_dropdown_options'))) {
					
					$options = explode("\n", rem_get_option('price_dropdown_options'));
					foreach ($options as $value) {
						$value = stripcslashes($value);
						$selected = '';
						$price = explode("-", $value );
						$min = !empty($price[0]) ? $price[0]: 0;
						$max = !isset($price[1]) ? $price[1]: 99999;
						echo '<option data-min="'.trim($min).'" data-max="'.trim($max).'" value="'.trim($value).'" >'.rem_get_property_price(trim($min) ).'-'.rem_get_property_price(trim($max) ).'</option>';
					}
				}
				?>
		</select>
		<div class="rem_price_dropdown_values">
			<input type="hidden" name="price_min" id="min-value">
		    <input type="hidden" name="price_max" id="max-value">
		</div>
	<?php } elseif (rem_get_option('search_price_range', 'slider') == 'single_options') { ?>
		<select class="<?php echo esc_attr($dropdown_class); ?> rem_price_dropdown" data-settings='{"cutOff": 5}' name="property_price">
			<option value=""><?php echo esc_attr($dashes); ?> <?php echo __( 'Price', 'real-estate-manager' ); ?> <?php echo esc_attr($dashes); ?></option>
				<?php
				if (!empty(rem_get_option('price_dropdown_options'))) {
					
					$options = explode("\n", rem_get_option('price_dropdown_options'));
					foreach ($options as $title) {
						$titleVal = explode("|", $title);
						if (isset($titleVal[1])) {
							$label = stripcslashes($titleVal[1]);
						} else {
							$label = stripcslashes($titleVal[0]);
						}
						$selected = '';
						if(isset($_GET[$field['key']]) && $_GET[$field['key']] == trim($title)){
							$selected = 'selected';
						}
						echo '<option value="'.trim($titleVal[0]).'+" '.$selected.'>'.rem_get_property_price($label).'+</option>';
					}
				}
				?>
		</select>
	<?php } else { ?>
		<?php if ($display == 'widget') { ?>
			<label><?php esc_attr_e( 'Price', 'real-estate-manager' ); ?></label>
		<?php } ?>
	<div class="row">
		<div class="col-xs-5"><input type="text" class="form-control" name="price_min" placeholder="<?php esc_attr_e( 'Min', 'real-estate-manager' ); ?>" value="<?php echo (isset($_GET['price_min'])) ? esc_attr( $_GET['price_min'] ) : '' ; ?>"></div>
		<div class="col-xs-2 text-center"><strong class="price-sep"><?php echo esc_attr($price_symbol); ?></strong></div>
		<div class="col-xs-5"><input type="text" class="form-control" name="price_max" placeholder="<?php esc_attr_e( 'Max', 'real-estate-manager' ); ?>" value="<?php echo (isset($_GET['price_max'])) ? esc_attr( $_GET['price_max'] ) : '' ; ?>"></div>
	</div>
	<?php }
	do_action( 'rem_after_price_range_search', $display );
}	
/**
 * Creating search query for shortcodes + Widgets
 * @since 10.4.2 
 */
function rem_get_search_query($data){
    $ppp = rem_get_option('properties_per_page', 15);

    $args = array(
        'post_type' =>  'rem_property',
        'post_status' => 'publish',
        'posts_per_page' => $ppp
    );
    if (isset($data['paged'])) {
    	$args['paged'] = $data['paged'];
    }
    if (isset($data['property_id']) && $data['property_id'] != '') {
        $args['post__in'] = array(intval($data['property_id']));
    }

    if (isset($data['agent_id']) && $data['agent_id'] != '') {
        $args['author'] = $data['agent_id'];
    }

    if (isset($data['order']) && $data['order'] != '') {
        $args['order'] = $data['order'];
    }

    if (isset($data['orderby']) && $data['orderby'] != '') {
        $args['orderby'] = $data['orderby'];
        if ($data['orderby'] == 'price') {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'rem_property_price';           
        }
    }

	if (isset($data['orderby_custom']) && $data['orderby_custom'] != '') {
	    $args['orderby'] = 'meta_value';
	    $args['meta_key'] = 'rem_'.$data['orderby_custom'];
	}

    if (isset($data['tag']) && $data['tag'] != '') {
        $args['tax_query'] = array(
			array(
				'taxonomy' => 'rem_property_tag',
				'field'    => 'term_id',
				'terms'    => $data['tag'],
			),
        );        
    }

    if (isset($data['category']) && $data['category'] != '') {
        $args['tax_query'] = array(
			array(
				'taxonomy' => 'rem_property_cat',
				'field'    => 'term_id',
				'terms'    => $data['category'],
			),
        );        
    }
    
    if (isset($data['search_property']) && $data['search_property'] != '') {
        $args['s'] = $data['search_property'];
    }
    
    /**
     * Searching for custom fields
     */
    global $rem_ob;
    $default_fields = $rem_ob->single_property_fields();
    foreach ($default_fields as $field) {
        if (isset($data[$field['key']]) && $data[$field['key']] != '') {
        	if(has_filter( "rem_search_query_{$field['key']}" )){

        		$args = apply_filters( "rem_search_query_{$field['key']}", $args, $field, $data[$field['key']], $data );
        		
        	} elseif ($field['type'] == 'select2') {
        		if (isset($data[$field['key']]) && !empty($data[$field['key']])) {
        			$logic = rem_get_option('multi_select_logic', 'AND');
		            $filter_arr = array(
				        'relation' => $logic
				    );

		            if (is_array($data[$field['key']])) {
				        foreach ($data[$field['key']] as $value) {
				        	$filter_arr[] = array(
			                    'key'     => 'rem_'.$field['key'],
			                    'value'   => $value,
			                    'compare' => 'LIKE',
				        	);
				        }
		            }

			        $args['meta_query'][] = $filter_arr;
			    }
        	} elseif (is_array($data[$field['key']]) && !empty($data[$field['key']]) ) {
	            $filter_arr = array(
			        'relation' => 'OR'
			    );

		        foreach ($data[$field['key']] as $value) {
		        	$filter_arr[] = array(
	                    'key'     => 'rem_'.$field['key'],
	                    'value'   => $value,
	                    'compare' => 'LIKE',
		        	);
		        }

		        $args['meta_query'][] = $filter_arr;

        	} elseif (preg_match('/^\d{1,}\+/', $data[$field['key']])) {
                $numb = intval($data[$field['key']]);
                $args['meta_query'][] = array(
                    array(
                        'key'     => 'rem_'.$field['key'],
                        'value'   => $numb,
                        'type'    => 'numeric',
                        'compare' => '>=',
                    ),
                );
            } elseif (preg_match('/^\d{1,}-\d{1,}/', $data[$field['key']])) {
                $area_arr = explode('-', $data[$field['key']]);
                $args['meta_query'][] = array(
                    array(
                        'key'     => 'rem_'.$field['key'],
                        'value'   => array( $area_arr[0], $area_arr[1] ),
                        'type'    => 'numeric',
                        'compare' => 'BETWEEN',
                    ),
                );
            } elseif (strpos($data[$field['key']], '!') !== false) {
                $args['meta_query'][] = array(
                    array(
                        'key'     => 'rem_'.$field['key'],
                        'value'   => ltrim($data[$field['key']],"!"),
                        'compare' => 'NOT LIKE',
                    ),
                );
            } elseif (strpos($field['key'], '#') !== false) {
                $args['meta_query'][] = array(
                    array(
                        'key'     => 'rem_'.$field['key'],
                        'value'   => ltrim($data[$field['key']],"#"),
                        'compare' => '=',
                    ),
                );
            } elseif (strpos($field['key'], '_id') !== false) {
                $args['meta_query'][] = array(
                    array(
                        'key'     => 'rem_'.$field['key'],
                        'value'   => stripcslashes($data[$field['key']]),
                        'compare' => '=',
                    ),
                );
            } else {
                $args['meta_query'][] = array(
                    array(
                        'key'     => 'rem_'.$field['key'],
                        'value'   => stripcslashes($data[$field['key']]),
                        'compare' => 'LIKE',
                    ),
                );
            }
        }
    }

    if ( isset($data['range']) && !empty($data['range']) ) {
    	foreach ($data['range'] as $range_key => $values) {
    		if ($values['min'] != '' || $values['max'] != '') {
		        $range_min = ($values['min'] == '') ? '0' : rem_range_into_int($values['min']);
		        $range_max = ($values['max'] == '') ? '999999999999' : rem_range_into_int($values['max']);
	    		$args['meta_query'][] = array(
		            array(
		                'key'     => 'rem_'.$range_key,
		                'value'   => array( intval($range_min), intval($range_max) ),
		                'type'    => 'numeric',
		                'compare' => 'BETWEEN',
		            ),
		        );
    		}
    	}
    }    

    /**
     * Searching for Price
     */
    if (isset($data['price_min'])) {
        $price_min = ($data['price_min'] == '') ? '0' : rem_price_into_int($data['price_min']);
        $price_max = ($data['price_max'] == '') ? '999999999999' : rem_price_into_int($data['price_max']);

        $args['meta_query'][] = array(
            array(
                'key'     => 'rem_property_price',
                'value'   => array( intval($price_min), intval($price_max) ),
                'type'    => 'numeric',
                'compare' => 'BETWEEN',
            ),
        );
    }

    /**
     * Searching for Features
     */
    if (isset($data['detail_cbs']) && $data['detail_cbs'] != '') {
		$feature_values = array(); // Array to store feature values

		foreach ($data['detail_cbs'] as $cbname => $value) {
			$cb_length = strlen($cbname);
			$feature_values[] = sprintf('s:%d:"%s";', $cb_length, $cbname);
		}

		// Create a single meta query with a 'REGEXP' compare
		$args['meta_query'][] = array(
			'key'     => 'rem_property_detail_cbs',
			'value'   => '(' . implode('|', $feature_values) . ')',
			'compare' => 'REGEXP',
		);
    }

	if (rem_get_option('search_not_available', 'enable') == 'disable') {
        $args['meta_query'][] = array(
            array(
                'key'     => 'rem_property_status',
                'value'   => 'Not Available',
                'compare' => 'NOT LIKE',
            ),
        );
	}

    // WPML Support
    if (isset($data['lang'])) {
    	do_action( 'wpml_switch_language',  $data['lang'] );
    }

    $args = apply_filters( 'rem_search_properties_query_args', $args, $data );

    return $args;
}

/**
 * Converts string into valid HTML ID
 * @param  [string] $string [description]
 * @since  10.4.6
 */
function rem_string_into_id($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}  

/**
 * Converts formatted price into integer
 * @param  [string] $string [description]
 * @since  10.6.3
 */
function rem_price_into_int($price) {
	$t_sep = rem_get_option('thousand_separator', '');
	$d_points = rem_get_option('decimal_points', '');
	$d_sep = rem_get_option('decimal_separator', '');
	if ($t_sep != '') {
	    $price = str_replace($t_sep, '', $price);
	}
	if ($d_points != '' && $d_points != '0' && $d_sep != '') {
	    $price = explode($d_sep, $price );
	    $price = $price[0];
	}
    return $price;
}

/**
 * Converts formatted input/range into integer
 * @param  [string] $string [description]
 * @since  10.6.3
 */
function rem_range_into_int($string) {
	$t_sep = rem_get_option('range_thousand_separator', '');
	$d_points = rem_get_option('range_decimal_points', '');
	$d_sep = rem_get_option('range_decimal_separator', '');
	if ($t_sep != '') {
	    $string = str_replace($t_sep, '', $string);
	}
	if ($d_points != '' && $d_points != '0' && $d_sep != '') {
	    $string = explode($d_sep, $string );
	    $string = $string[0];
	}
    return $string;
}

function rem_render_section_title($tabData){
	$title = rem_wpml_translate($tabData['title'], 'real-estate-manager-sections');
	$tab_key = $tabData['key'];
	$icon = '';

	if (isset($tabData['icon']) && $tabData['icon'] != '') {
		if (strpos($tabData['icon'], "http://") !== false || strpos($tabData['icon'], "https://") !== false) {
			$icon = '<img class="rem-sec-icon" src= "'.esc_url( $tabData['icon'] ).'">';
		} else {
			$icon = '<i class="'.esc_attr( $tabData['icon'] ).'"></i>';
		}
	}

	$icon = apply_filters( 'rem_property_section_title_icon', $icon,  $tabData);

	$wrap = apply_filters( 'rem_property_section_title_wrap', 'h2', $tab_key );
	$wrap = esc_attr( $wrap );
	echo "<$wrap class='title'>$icon ".esc_attr($title)."</$wrap>";
}

/**
 * Getting Leaflet map styles and attribution
 * @param  [type] $map_id [description]
 * @since 10.4.7
 */
function rem_get_leaflet_provider($map_id){

	switch ($map_id) {
		case '1':
			$provider = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
			$attribution = '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
			break;
			
		case '2':
			$provider = 'http://{s}.tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png';
			$attribution = '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
			break;

		case '3':
			$provider = 'https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png';
			$attribution = '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
			break;

		case '4':
			$provider = 'https://tile.osm.ch/switzerland/{z}/{x}/{y}.png';
			$attribution = '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
			break;

		case '5':
			$provider = 'https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png';
			$attribution = '&copy; Openstreetmap France | &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
			break;

		case '6':
			$provider = 'https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png';
			$attribution = '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, Tiles courtesy of <a href="http://hot.openstreetmap.org/" target="_blank">Humanitarian OpenStreetMap Team</a>';
			break;

		case '7':
			$provider = 'https://tile.openstreetmap.bzh/br/{z}/{x}/{y}.png';
			$attribution = '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, Tiles courtesy of <a href="http://www.openstreetmap.bzh/" target="_blank">Breton OpenStreetMap Team</a>';
			break;

		case '8':
			$provider = 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png';
			$attribution = 'Map data: &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)';
			break;

		case '9':
			$provider = 'https://{s}.tile.openstreetmap.se/hydda/full/{z}/{x}/{y}.png';
			$attribution = 'Tiles courtesy of <a href="http://openstreetmap.se/" target="_blank">OpenStreetMap Sweden</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
			break;

		case '10':
			$provider = 'https://{s}.tile.openstreetmap.se/hydda/base/{z}/{x}/{y}.png';
			$attribution = 'Tiles courtesy of <a href="http://openstreetmap.se/" target="_blank">OpenStreetMap Sweden</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
			break;

		case '11':
			$provider = 'https://stamen-tiles-{s}.a.ssl.fastly.net/toner/{z}/{x}/{y}{r}.png';
			$attribution = 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
			break;

		case '12':
			$provider = 'https://stamen-tiles-{s}.a.ssl.fastly.net/toner-background/{z}/{x}/{y}{r}.png';
			$attribution = 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
			break;

		case '13':
			$provider = 'https://stamen-tiles-{s}.a.ssl.fastly.net/toner-lite/{z}/{x}/{y}{r}.png';
			$attribution = 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
			break;

		case '14':
			$provider = 'https://stamen-tiles-{s}.a.ssl.fastly.net/watercolor/{z}/{x}/{y}.png';
			$attribution = 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
			break;

		case '15':
			$provider = 'https://stamen-tiles-{s}.a.ssl.fastly.net/terrain/{z}/{x}/{y}{r}.png';
			$attribution = 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
			break;

		case '16':
			$provider = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}';
			$attribution = 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012';
			break;

		case '17':
			$provider = 'https://server.arcgisonline.com/ArcGIS/rest/services/Specialty/DeLorme_World_Base_Map/MapServer/tile/{z}/{y}/{x}';
			$attribution = 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012';
			break;

		case '18':
			$provider = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}';
			$attribution = 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012';
			break;

		case '19':
			$provider = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
			$attribution = 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012';
			break;

		case '20':
			$provider = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Shaded_Relief/MapServer/tile/{z}/{y}/{x}';
			$attribution = 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012';
			break;

		case '21':
			$provider = 'https://server.arcgisonline.com/ArcGIS/rest/services/NatGeo_World_Map/MapServer/tile/{z}/{y}/{x}';
			$attribution = 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012';
			break;

		case '22':
			$provider = 'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}';
			$attribution = 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012';
			break;

		case '23':
			$provider = 'https://stamen-tiles-{s}.a.ssl.fastly.net/terrain-background/{z}/{x}/{y}{r}.png';
			$attribution = 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>';
			break;
		
		default:
			$provider = 'https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png';
			$attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Points &copy 2012 LINZ';
			break;
	}

	$resp = array(
		'provider' => $provider,
		'attribution' => $attribution
	);

	return apply_filters( 'rem_leaflet_provider_and_attribution', $resp, $map_id );
}

function rem_single_property_has_map($property_id){
    $property_has_map = true;

    if (rem_get_option('single_property_map', 'enable') != 'enable') {
        $property_has_map = false;
    }

    if (get_post_meta( $property_id, '_disable_map', true ) == 'yes') {
        $property_has_map = false;
    }

    $property_has_map = apply_filters( 'rem_single_property_has_map', $property_has_map, $property_id );

    return $property_has_map;
}

function rem_get_lat_long_by_address($address){
	$maps_api = apply_filters( 'rem_maps_api', 'AIzaSyBbpbij9IIXGftKhFLMHOuTpAbFoTU_8ZQ' );

    $address = str_replace(" ", "+", $address);

    $json = wp_remote_get("https://maps.google.com/maps/api/geocode/json?address=$address&key=$maps_api");
    $json = json_decode($json);

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    return array('lat' => $lat, 'long' => $long);
}

function get_search_fields_for_page_builders(){
	global $rem_ob;
	$fields_to_show = array( __( 'Search Field', 'real-estate-manager' ) => 'search' );

	$default_fields = $rem_ob->single_property_fields();
	foreach ($default_fields as $field) {
		$fields_to_show[$field['title']] = $field['key'];
	}
	$fields_to_show[__( 'Order', 'real-estate-manager' )] = 'order';
	$fields_to_show[__( 'Order By', 'real-estate-manager' )] = 'orderby';
	$fields_to_show[__( 'Agent', 'real-estate-manager' )] = 'agent';
	$fields_to_show[__( 'Property ID', 'real-estate-manager' )] = 'property_id';
	$fields_to_show[__( 'Tags', 'real-estate-manager' )] = 'tags';

	return $fields_to_show;
}

/**
 * WPML
 * registering and translating strings input by users
 */
if( ! function_exists('rem_wpml_register') ) {
    function rem_wpml_register($field_value, $domain, $field_name = '') {
    	$field_name = ($field_name == '') ? $field_value : $field_name ;
        do_action( 'wpml_register_single_string', $domain, $field_name, $field_value );
    }
}

if( ! function_exists('rem_wpml_translate') ) {
    function rem_wpml_translate($field_value, $domain, $field_name = '', $language = '') {
    	$field_name = ($field_name == '') ? $field_value : $field_name ;
        return apply_filters('wpml_translate_single_string', stripcslashes($field_value), $domain, $field_name, $language );
    }
}

function rem_get_energy_efficiency_classes(){
    $classes = array(
		'A+',
		'A',
		'B',
		'C',
		'D',
		'E',
		'F',
		'G',
		'H',
    );

    return apply_filters( 'rem_energy_efficiency_classes', $classes );        
}

function rem_get_field_value($key, $property_id = ''){
	if ($property_id == '') {
		global $post;
		$property_id = $post->ID;
	}
	$value = get_post_meta( $property_id, 'rem_'.$key, true );
	if ($value != '') {

		if(is_array($value)){
			$values = array();
			foreach ($value as $innervalues) {
				$value = rem_wpml_translate(trim($innervalues), 'real-estate-manager-fields');
				$values[] = $value;
			}
			$value = implode(",", $values);
		} else {
			$value = rem_wpml_translate($value, 'real-estate-manager-fields');
		}
		
		if (preg_match('/(_|\b)area(_|\b)/', $key)){
			$value = $value.' '.rem_get_option('properties_area_unit', 'Sq Ft');
		}
		if (preg_match('/(_|\b)price(_|\b)/', $key)) {
			$value = rem_get_property_price($value);
		}
	}

	return $value;
}

function rem_get_field_label($key){
	
	$label = '';

	global $rem_ob;
	$all_fields = $rem_ob->single_property_fields();
	if (!empty($all_fields)) {
		foreach ($all_fields as $field) {
			if ($key == $field['key'] ) {
               $label = rem_wpml_translate($field['title'], 'real-estate-manager-fields'); 
            }
		}
	} 
	return $label;
}

/**
 * renders search ranges for number fields if checked from settings
 */

function rem_render_range_field($field, $min, $max){
	if ($min == $max) {
		$max = $max * 2;
	}
	$cb_label = rem_get_option('range_cb_text', ''); ?>
    <div class="p-slide-wrap">
        <div class="slider slider-range-input" data-default_min="<?php echo esc_attr($min); ?>" data-default_max="<?php echo esc_attr($max); ?>" data-max="<?php echo esc_attr($max); ?>" data-min="<?php echo esc_attr($min); ?>"></div>
        <div class="price-slider price <?php echo ($cb_label != '') ? 'text-right' : 'text-center' ; ?>">
    		<?php
    			$cb_label = rem_get_option('range_cb_text', '');
    			$checkbox_check = (isset($field['any_value_on_slider']) && $field['any_value_on_slider'] == "true") ? "checked": "";
    			
    			if ($cb_label != '') {

        			$cb_label = str_replace('%field_title%', $field['title'], $cb_label);
        			echo '<label class="any-check">';
        			echo '<input type="checkbox" '.esc_attr($checkbox_check).'>';
        			echo apply_filters( 'rem_range_cb_label', $cb_label, $field );
        			echo '</label>';
    			}
    		?>
            <span id="price-value-min" class="price-value-min"></span>
            <span class="separator"><?php echo esc_attr($field['title']); ?></span>
            <span id="price-value-max" class="price-value-max"></span>
        </div>
        <input type="hidden" name="range[<?php echo esc_attr($field['key']); ?>][min]" class="min-value">
        <input type="hidden" name="range[<?php echo esc_attr($field['key']); ?>][max]" class="max-value">
    </div>
<?php }

function rem_number_field_values_in_posts($field_key){
    $args = array(    
        'post_type'   => 'rem_property',
        'posts_per_page' => -1,
    );
    $post_data = array();
    $properties_array = get_posts( $args );
    foreach ($properties_array as $post) {
        $meta_value = get_post_meta( $post->ID, 'rem_'.$field_key , true);
        if ( !empty($meta_value) ){
            $post_data[] = $meta_value;
        }
    }
    $property_data = array();
    if ( !empty( $post_data ) ) {
        $property_data['max'] = max($post_data);
        $property_data['min'] = min($post_data);
    }
    return $property_data;
}

/**
 * Returns available options of single field
 * @since 10.7.6
 */

function rem_get_field_data( $field_key ){
	global $rem_ob;
	$inputFields = $rem_ob->single_property_fields();

	foreach ($inputFields as $field) {
		if ( $field_key == $field['key'] ) {
			return $field;
		}
	}

	return false;						
}

/**
 * Returns if field should display or not
 * @param  [array]  $field [single field data]
 * @since 10.8.1
 */
function rem_is_field_accessible($field, $property_id = ''){
    $accessibility = (isset($field['accessibility'])) ? $field['accessibility'] : 'public' ;
    switch ($accessibility) {
        case 'public':
            $is_accessible = true;
            break;

        case 'disable':
            $is_accessible = false;
            break;

        case 'admin':
            $is_accessible = false;
            if (is_user_logged_in() && current_user_can('administrator')) {
                $is_accessible = true;
            }
            break;

        case 'agent':
            $is_accessible = false;
            if (is_user_logged_in()) {
                $current_user_data = wp_get_current_user();
                if ($property_id == '' || get_post_field( 'post_author', $property_id ) == $current_user_data->ID || current_user_can('administrator')) {
                    $is_accessible = true;
                }
            }
            break;
        
        default:
            $is_accessible = true;
            break;
    }
    
    return apply_filters( 'rem_is_field_accessible_'.$field['key'], $is_accessible, $field, $property_id );
}

/**
 * Returns if section should display or not
 * @param  [array]  $tab [single tab data]
 * @since 10.8.4
 */
function rem_is_tab_accessible($tab, $property_id = ''){
    $accessibility = (isset($tab['accessibility'])) ? $tab['accessibility'] : 'public' ;
    switch ($accessibility) {
        case 'public':
            $is_accessible = true;
            break;

        case 'disable':
            $is_accessible = false;
            break;

        case 'admin':
            $is_accessible = false;
            if (is_user_logged_in() && current_user_can('administrator')) {
                $is_accessible = true;
            }
            break;

        case 'registered':
            $is_accessible = false;
            if (is_user_logged_in()) {
                $is_accessible = true;
            }
            break;

        case 'agent':
            $is_accessible = false;
            if (is_user_logged_in()) {
                $current_user_data = wp_get_current_user();
                if ($property_id == '' || get_post_field( 'post_author', $property_id ) == $current_user_data->ID || current_user_can('administrator')) {
                    $is_accessible = true;
                }
            }
            break;
        
        default:
            $is_accessible = true;
            break;
    }
    
    return apply_filters( 'rem_is_tab_accessible_'.$tab['key'], $is_accessible, $tab, $property_id );
}

/**
 * Check if agent can publish new properties
 * @param  [Integer] $agent_id
 * @return [bool]
 * @since 10.8.2
 */
function rem_can_agent_publish($agent_id){
	$max_properties = rem_get_option('max_properties');
	if ($max_properties != '' && $max_properties != -1) {
		$active_properties = count_user_posts( $agent_id, 'rem_property' );
		if ($active_properties<$max_properties) {
			return true;
		} else {
			return false;
		}
	} else {
		return true;
	}
}
?>