<?php
/**
* Core functions for real estate manager
*/

define('REM_PATH', untrailingslashit(plugin_dir_path( __FILE__ )) );
define('REM_URL', untrailingslashit(plugin_dir_url( __FILE__ )) );
define('REM_VERSION', '6.0' );

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
        wp_enqueue_style( 'rem-bs-css', REM_URL . '/assets/admin/css/bootstrap.min.css' );  
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
		return $rem_settings[$key];
	} else {
		return $default;
	}
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
		$sale_price = get_post_meta($property_id, 'rem_property_sale_price', true);
		$display = rem_get_property_price($price);
		if ($sale_price != '') {
			$display = '<del>' . $display . '</del> <span class="sale-price">' .rem_get_property_price($sale_price). '</span>';
		}
		$after_price = get_post_meta($property_id, 'rem_after_price_text', true);
		if ($after_price != '') {
			$display = $display . $after_price;
		}
		return $display;
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
	extract( apply_filters( 'rem_price_args', wp_parse_args( $args, array(
		'currency'           => rem_get_option('currency', 'USD'),
		'decimal_separator'  => rem_get_price_decimal_separator(),
		'thousand_separator' => rem_get_price_thousand_separator(),
		'decimals'           => rem_get_price_decimals(),
		'price_format'       => rem_get_price_format()
	) ) ) );
	$negative        = $price < 0;
	$price           = apply_filters( 'raw_rem_price', floatval( $negative ? $price * -1 : $price ) );
	$price           = apply_filters( 'formatted_rem_price', number_format( $price, $decimals, $decimal_separator, $thousand_separator ), $price, $decimals, $decimal_separator, $thousand_separator );

	if ( apply_filters( 'rem_price_trim_zeros', false ) && $decimals > 0 ) {
		$price = wc_trim_zeros( $price );
	}

	$formatted_price = ( $negative ? '-' : '' ) . sprintf( $price_format, '<span class="rem-currency-symbol">' . rem_get_currency_symbol( $currency ) . '</span>', $price );
	$return          = '<span class="rem-price-amount">' . $formatted_price . '</span>';

	return apply_filters( 'rem_property_price', $return, $price, $args );
}

function rem_get_single_property_settings_tabs(){
	$tabsData = array(
		'general_settings' => __( 'General Settings', 'real-estate-manager' ),
		'internal_structure' => __( 'Internal Structure', 'real-estate-manager' ),
		'property_details' => __( 'Property Features', 'real-estate-manager' ),
		'property_attachments' => __( 'File Attachments', 'real-estate-manager' ),
		'property_video' => __( 'Video', 'real-estate-manager' ),
	);

    if(has_filter('rem_property_settings_tabs')) {
        $tabsData = apply_filters('rem_property_settings_tabs', $tabsData);
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
	);

    if(has_filter('rem_property_listing_styles')) {
        $styles = apply_filters('rem_property_listing_styles', $styles);
    }

    return $styles;
}

/**
 * Renders property edit fields in backend
 */
function rem_render_field($field){
	global $post;
	$saved_value = get_post_meta( $post->ID, 'rem_'.$field['key'], true );

	$value = ($saved_value != '') ? $saved_value : $field['default'] ;

	if ($field['type'] == 'text' || $field['type'] == 'number' || $field['type'] == 'date') {

		echo '<input id="'.$field['key'].'" class="form-control input-sm" type="'.$field['type'].'" name="rem_property_data['.$field['key'].']" value="'.$value.'">';

	} elseif ($field['type'] == 'select') { ?>
		<select id="<?php echo $field['key'] ?>" name="rem_property_data[<?php echo $field['key']; ?>]" class="form-control input-sm">
			<?php
				$options = (is_array($field['options'])) ? $field['options'] : explode("\n", $field['options']);
				foreach ($options as $name) {
					echo '<option value="'.stripcslashes($name).'" '.selected( $value, $name, false ).'>'.stripcslashes($name).'</option>';
				}
			?>
		</select>
	<?php } elseif ($field['type'] == 'upload') { ?>
        <div class="input-group">
            <textarea id="<?php echo $field['key']; ?>" name="rem_property_data[<?php echo $field['key']; ?>]" class="form-control custom-control place-attachment" rows="2" style="resize:none;"><?php echo stripcslashes($value); ?></textarea>     
            <span data-title="<?php _e( 'Select attachments for property', 'real-estate-manager' ); ?>" data-btntext="<?php _e( 'Add', 'real-estate-manager' ); ?>" class="upload-attachment input-group-addon btn btn-info"><?php _e( 'Upload', 'real-estate-manager' ); ?></span>
        </div>

	<?php } elseif ($field['type'] == 'widget') { ?>
		<select name="rem_property_data[<?php echo $field['key']; ?>]" class="form-control input-sm">
			<?php
				foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
					echo '<option value="'.$sidebar['id'].'" '.selected( $saved_m[$field['key']], $sidebar['id'], true ).'>'.$sidebar['name'].'</option>';
				}
			?>
		</select>
	<?php } elseif ($field['type'] == 'checkbox') {

		$saved_value = get_post_meta( $post->ID, 'rem_property_detail_cbs', true );
		$value = (isset($saved_value[$field['key']])) ? $saved_value[$field['key']] : $field['default']; ?>
			<div class="onoffswitch">
			    <input type="checkbox" <?php checked( $value, 'on', true); ?> value="on" name="rem_property_data[property_detail_cbs][<?php echo $field['key']; ?>]" class="onoffswitch-checkbox" id="<?php echo $field['key']; ?>">
			    <label class="onoffswitch-label" for="<?php echo $field['key']; ?>">
			        <span class="onoffswitch-inner" data-off="<?php _e( 'NO', 'real-estate-manager' ); ?>" data-on="<?php _e( 'YES', 'real-estate-manager' ); ?>"></span>
			        <span class="onoffswitch-switch"></span>
			    </label>
			</div>
	<?php }
}

/**
 * Renders Special fields for searching from shortcode or widget
 * @since 10.4.2
 */
function rem_render_special_search_fields($key){
	switch ($key) {
		case 'order': ?>
			<select class="dropdown" data-settings='{"cutOff": 5}' name="order" id="order">
				<option value="">-- <?php _e( 'Order', 'real-estate-manager' ); ?> --</option>
				<option value="DESC" <?php echo (isset($_GET['order']) && $_GET['order'] == 'DESC') ? 'selected' : '' ; ?>><?php _e( 'Descending', 'real-estate-manager' ); ?></option>
				<option value="ASC" <?php echo (isset($_GET['order']) && $_GET['order'] == 'ASC') ? 'selected' : '' ; ?>><?php _e( 'Ascending', 'real-estate-manager' ); ?></option>
			</select>
			<?php break;
		case 'property_id': ?>
			<input type="text" placeholder="<?php _e( 'Property ID', 'real-estate-manager' ); ?>" name="property_id" class="form-control" value="<?php echo (isset($_GET['property_id'])) ? $_GET['property_id'] : '' ; ?>">
			<?php break;
		case 'orderby': ?>
			<select class="dropdown" data-settings='{"cutOff": 5}' name="orderby" id="orderby">
				<option value="">-- <?php _e( 'Order By', 'real-estate-manager' ); ?> --</option>
				<option value="title" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'title') ? 'selected' : '' ; ?>><?php _e( 'Title', 'real-estate-manager' ); ?></option>
				<option value="date" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'date') ? 'selected' : '' ; ?>><?php _e( 'Date', 'real-estate-manager' ); ?></option>
				<option value="price" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'price') ? 'selected' : '' ; ?>><?php _e( 'Price', 'real-estate-manager' ); ?></option>
			</select>
			<?php break;
		case 'agent': ?>
			<select class="dropdown" data-settings='{"cutOff": 5}' name="agent_id" id="agent_id">
				<option value="">-- <?php _e( 'Agent', 'real-estate-manager' ); ?> --</option>
				<?php 
					$all_agents = get_users( 'role=rem_property_agent' );
					foreach ($all_agents as $agent) { ?>
						<option value="<?php echo $agent->ID; ?>" <?php echo (isset($_GET['agent_id']) && $_GET['agent_id'] == $agent->ID) ? 'selected' : '' ; ?>><?php echo $agent->display_name;; ?></option>
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
function rem_render_property_search_fields($field, $display = 'widget'){
	if ($field['key'] == 'property_area' || $field['key'] == 'property_bedrooms' || $field['key'] == 'property_bathrooms') {
		$meta_key = array(
			'property_area' => 'search_area_options',
			'property_bedrooms' => 'search_bedrooms_options',
			'property_bathrooms' => 'search_bathrooms_options',
		);
		if (rem_get_option($meta_key[$field['key']], '') != '') { ?>
			<select class="dropdown" data-settings='{"cutOff": 5}' name="<?php echo $field['key']; ?>" id="<?php echo $field['key']; ?>">
				<option value="">-- <?php echo ($display == 'widget') ? __( 'Any', 'real-estate-manager' ) : $field['title']; ?> --</option>
					<?php
						$options = explode("\n", rem_get_option($meta_key[$field['key']]));
						foreach ($options as $title) {
							$selected = '';
							if(isset($_GET[$field['key']]) && $_GET[$field['key']] == trim($title)){
								$selected = 'selected';
							}
							echo '<option value="'.trim($title).'" '.$selected.'>'.$title.'</option>';
						}
					?>
			</select>
		<?php } else { ?>
			<input class="form-control" type="text" placeholder="<?php echo $field['title']; ?>" name="<?php echo $field['key']; ?>" id="<?php echo $field['key']; ?>" value="<?php echo (isset($_GET[$field['key']])) ? $_GET[$field['key']] : '' ; ?>"/>
		<?php }		
	} elseif ($field['key'] == '') { ?>
		
	<?php } else {
		if ($field['type'] == 'select') { ?>
			<select class="dropdown" data-settings='{"cutOff": 5}' name="<?php echo $field['key']; ?>" id="<?php echo $field['key']; ?>">
				<option value="">-- <?php echo ($display == 'widget') ? __( 'Any', 'real-estate-manager' ) : $field['title']; ?> --</option>
					<?php
						foreach ($field['options'] as $title) {
							$selected = '';
							if(isset($_GET[$field['key']]) && $_GET[$field['key']] == trim($title)){
								$selected = 'selected';
							}
							echo '<option value="'.trim($title).'" '.$selected.'>'.$title.'</option>';
						}
					?>
			</select>
		<?php } else { ?>
			<input placeholder="<?php echo $field['title']; ?>" class="form-control" type="<?php echo $field['type']; ?>" name="<?php echo $field['key']; ?>" id="<?php echo $field['key']; ?>" value="<?php echo (isset($_GET[$field['key']])) ? $_GET[$field['key']] : '' ; ?>"/>
		<?php }
	}
}
/**
 * Controls the inputs for price ranges for searching
 * @since 10.4.2
 */
function rem_render_price_range_field($display = 'widget'){
	$price_symbol = rem_get_currency_symbol();
	if (rem_get_option('search_price_range', 'slider') == 'slider') { ?>
		<?php if ($display == 'widget') { ?>
			<label><?php _e( 'Price', 'real-estate-manager' ); ?></label>
		<?php } ?>
		<div class="slider price-range"></div>
		<div class="price-slider price">
	        <span id="price-value-min"></span> 
	        <span class="separator"><?php echo $price_symbol ?></span>
	        <span id="price-value-max"></span>
	    </div>
	    <input type="hidden" name="price_min" id="min-value">
	    <input type="hidden" name="price_max" id="max-value">
	<?php } else { ?>
		<?php if ($display == 'widget') { ?>
			<label><?php _e( 'Price', 'real-estate-manager' ); ?></label>
		<?php } ?>
	<div class="row">
		<div class="col-xs-5"><input type="text" class="form-control" name="price_min" placeholder="<?php _e( 'Min', 'real-estate-manager' ); ?>" value="<?php echo (isset($_GET['price_min'])) ? $_GET['price_min'] : '' ; ?>"></div>
		<div class="col-xs-2 text-center"><strong class="price-sep"><?php echo $price_symbol; ?></strong></div>
		<div class="col-xs-5"><input type="text" class="form-control" name="price_max" placeholder="<?php _e( 'Max', 'real-estate-manager' ); ?>" value="<?php echo (isset($_GET['price_max'])) ? $_GET['price_max'] : '' ; ?>"></div>
	</div>
	<?php } ?>
<?php }

/**
 * Creating search query for shortcodes + Widgets
 * @since 10.4.2 
 */
function rem_get_search_query($data){
    $ppp = rem_get_option('properties_per_page', -1);

    $args = array(
        'post_type' =>  'rem_property',
        'post_status' => 'publish',
        'posts_per_page' => $ppp
    );

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
            if (preg_match('/^\d{1,}\+/', $data[$field['key']])) {
                $numb = intval($data[$field['key']]);
                $args['meta_query'][] = array(
                    array(
                        'key'     => 'rem_'.$field['key'],
                        'value'   => $numb,
                        'type'    => 'numeric',
                        'compare' => '>=',
                    ),
                );
            } else if (preg_match('/^\d{1,}-\d{1,}/', $data[$field['key']])) {
                $area_arr = explode('-', $data[$field['key']]);
                $args['meta_query'][] = array(
                    array(
                        'key'     => 'rem_'.$field['key'],
                        'value'   => array( $area_arr[0], $area_arr[1] ),
                        'type'    => 'numeric',
                        'compare' => 'BETWEEN',
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

    /**
     * Searching for Price
     */
    if (isset($data['price_min']) && $data['price_min'] != '') {
        $t_sep = rem_get_option('thousand_separator', '');
        $d_points = rem_get_option('decimal_points', '');
        $d_sep = rem_get_option('decimal_separator', '');
        $price_min = $data['price_min'];
        $price_max = $data['price_max'];
        if ($t_sep != '') {
            $price_min = str_replace($t_sep, '', $data['price_min']);
            $price_max = str_replace($t_sep, '', $data['price_max']);
        }
        
        if ($d_points != '' && $d_points != '0' && $d_sep != '') {
            $price_min = explode($d_sep, $price_min );
            $price_min = $price_min[0];
            $price_max = explode($d_sep, $price_max );
            $price_max = $price_max[0];
        }
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

        foreach ($data['detail_cbs'] as $cbname => $value) {
            $args['meta_query'][] = array(
                array(
                    'key'     => 'rem_property_detail_cbs',
                    'value'   => $cbname,
                    'compare' => 'LIKE',
                ),
            );
        }
    }

    return $args;
}

function rem_check_deprecated_fields($saved_fields, $all_fields){
	$add_fields = true;
	foreach ($saved_fields as $saved_field) {
		if (isset($saved_field['key']) && $saved_field['key'] == 'property_price') {
			$add_fields = false;
			break;
		}
	}
	
	if ($add_fields) {
		foreach ($all_fields as $builtin_field) {
			if (isset($builtin_field['editable']) && $builtin_field['editable'] == false) {
				$saved_fields[] = $builtin_field;
			}
		}
	}
	
	return $saved_fields;
}
?>