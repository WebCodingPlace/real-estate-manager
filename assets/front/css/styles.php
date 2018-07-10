<?php
	$rem_settings = get_option( 'rem_all_settings' );
	extract($rem_settings);
	$border_color = (isset($headings_underline_color_default)) ? $headings_underline_color_default : '' ;
	$border_color_active = (isset($headings_underline_color_active)) ? $headings_underline_color_active : '' ;
	$btn_bg_color = (isset($buttons_background_color)) ? $buttons_background_color : '' ;
	$btn_txt_color = (isset($buttons_text_color)) ? $buttons_text_color : '' ;
	$btn_bg_hover = (isset($buttons_background_color_hover)) ? $buttons_background_color_hover : '' ;
	$btn_txt_hover = (isset($buttons_text_color_hover)) ? $buttons_text_color_hover : '' ;
	$main_color = (isset($rem_main_color)) ? $rem_main_color : '' ;
?>
.fotorama__thumb-border, .ich-settings-main-wrap .form-control:focus {
	border-color: <?php echo $main_color; ?> !important;
}
.ich-settings-main-wrap .section-title.line-style {
	border-color: <?php echo $border_color; ?>;
}
.landz-box-property.box-grid.mini .price {
	border-top: 4px solid <?php echo $main_color; ?> !important;
}
.landz-box-property.box-grid.mini .price:after {
	border-bottom-color: <?php echo $main_color; ?> !important;
}

.ich-settings-main-wrap .section-title.line-style .title {
	border-color: <?php echo $border_color_active; ?>;
}
.ich-settings-main-wrap .btn-default, .ich-settings-main-wrap .btn,
#rem-agent-page .my-property .my-property-nav a.next,
#rem-agent-page .my-property .my-property-nav a.previous {
	border-radius: 0 !important;
	border: none;
	background-color: <?php echo $btn_bg_color; ?>;
	color: <?php echo $btn_txt_color; ?>;
}
.ich-settings-main-wrap .btn-default:hover, .ich-settings-main-wrap .btn:hover,
#rem-agent-page .my-property .my-property-nav a.next:hover,
#rem-agent-page .my-property .my-property-nav a.previous:hover {
	border-radius: 0;
	background-color: <?php echo $btn_bg_hover; ?>;
	color: <?php echo $btn_txt_hover; ?>;
}

/* Theme Colors */

#property-content .large-price,
.ich-settings-main-wrap #filter-box .filter,
.ich-settings-main-wrap .dropdown.open .carat,
.ich-settings-main-wrap .dropdown li.active,
.ich-settings-main-wrap .dropdown li.focus,
.ich-settings-main-wrap .result-calc,
.ich-settings-main-wrap .landz-box-property .price,
.ich-settings-main-wrap input.labelauty + label > span.labelauty-checked-image,
.ich-settings-main-wrap .skillbar-title,
.ich-settings-main-wrap .noUi-connect,
.ich-settings-main-wrap .rem-sale span,
.ich-settings-main-wrap #user-profile .property-list table thead th,
.ich-settings-main-wrap .price-slider.price #price-value-min, .price-slider.price #price-value-max,
input.labelauty:hover + label > span.labelauty-checked-image { 
	background-color: <?php echo $main_color; ?> !important;
}
#property-content .details .detail .fa-square,
.hover-effect .cover:before {
	color: <?php echo $main_color; ?> !important;
}
.ich-settings-main-wrap .dropdown .carat:after {
	border-top: 6px solid <?php echo $main_color; ?>;
}
.input.labelauty:hover + label > span.labelauty-checked-image {
	border: none;
}
.price-slider.price #price-value-min:after {
	    border-left: 6px solid <?php echo $main_color; ?> !important;
}
.price-slider.price #price-value-max:after {
	    border-right: 6px solid <?php echo $main_color; ?> !important;
}
.ich-settings-main-wrap .landz-box-property .title {
	border-bottom: 3px solid <?php echo $main_color; ?>;
}
.ich-settings-main-wrap #user-profile .property-list table thead th {
	border-bottom: 0;
}
.ich-settings-main-wrap .landz-box-property .price:after {
	border-bottom: 10px solid <?php echo $main_color; ?>;
}
.landz-box-property dd {
	margin: 0 !important;
}
#rem-agent-page .my-property .my-property-nav .button-container {
	border-top: 1px solid <?php echo $main_color; ?> !important;
}
.ich-settings-main-wrap #new-property #position {
	background-color: <?php echo $main_color; ?> !important;
	color: <?php echo $btn_txt_color; ?> !important;
}
.ich-settings-main-wrap #new-property #position:after {
	border-bottom: 10px solid <?php echo $main_color; ?> !important;
}
.ich-settings-main-wrap .pagination > .active > a,
.ich-settings-main-wrap .pagination > .active > span,
.ich-settings-main-wrap .pagination > .active > a:hover,
.ich-settings-main-wrap .pagination > .active > span:hover,
.ich-settings-main-wrap .pagination > .active > a:focus,
.ich-settings-main-wrap .pagination > .active > span:focus {
	background-color: <?php echo $main_color; ?> !important;
	border-color: <?php echo $main_color; ?> !important;
}
<?php echo (isset($custom_css)) ? $custom_css : '' ; ?>
<?php do_action( 'rem_css_kit_styles', $main_color ); ?>