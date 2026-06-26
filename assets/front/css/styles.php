<?php
	$rem_settings = get_option( 'rem_all_settings' );
	if (is_array($rem_settings)) {
		extract($rem_settings);
	}
	$border_color = (isset($headings_underline_color_default)) ? $headings_underline_color_default : '' ;
	$border_color_active = (isset($headings_underline_color_active)) ? $headings_underline_color_active : '' ;
	$btn_bg_color = (isset($buttons_background_color)) ? $buttons_background_color : '' ;
	$btn_txt_color = (isset($buttons_text_color)) ? $buttons_text_color : '' ;
	$btn_bg_hover = (isset($buttons_background_color_hover)) ? $buttons_background_color_hover : '' ;
	$btn_txt_hover = (isset($buttons_text_color_hover)) ? $buttons_text_color_hover : '' ;
	$main_color = (isset($rem_main_color)) ? $rem_main_color : '' ;
	if (rem_get_option('sections_display') == 'boxed') { ?>
		.rem-section-box {
			background-color: #FFFFFF;
			box-shadow: 0 10px 31px 0 rgba(7,152,255,.09);
			border: 1px solid #f1f8ff;
			padding: 15px;
			margin-bottom: 20px;	
		}
		.rem-section-box .section-title {
			margin: 0 0 20px;		
		}
		.rem-section-box .section-title.line-style {
			border-color: transparent;
		}
		.rem-section-box.wrap-title_content {
			margin-top: 20px;
		}
	<?php }
?>
.fotorama__thumb-border, .ich-settings-main-wrap .form-control:focus,
.ich-settings-main-wrap .select2-container--default .select2-selection--multiple:focus,
.select2-container--default.select2-container--focus .select2-selection--multiple {
	border-color: <?php echo esc_attr($main_color); ?> !important;
}
.ich-settings-main-wrap .section-title.line-style {
	border-color: <?php echo esc_attr($border_color); ?>;
}
.landz-box-property.box-grid.mini .price {
	border-top: 4px solid <?php echo esc_attr($main_color); ?> !important;
}
.landz-box-property.box-grid.mini .price:after,
.ich-settings-main-wrap .nice-select:after {
	border-bottom-color: <?php echo esc_attr($main_color); ?> !important;
}

.ich-settings-main-wrap .section-title.line-style .title {
	border-color: <?php echo esc_attr($border_color_active); ?>;
}
.ich-settings-main-wrap .btn-default, .ich-settings-main-wrap .btn,
#rem-agent-page .my-property .my-property-nav a.next,
#rem-agent-page .my-property .my-property-nav a.previous {
	border-radius: 0 !important;
	border: none;
	background-color: <?php echo esc_attr($btn_bg_color); ?>;
	color: <?php echo esc_attr($btn_txt_color); ?>;
}
.rem-tag-cloud a {
	color: <?php echo esc_attr($btn_bg_color); ?>;
}
.rem-tag-cloud a:hover {
	color: <?php echo esc_attr($btn_bg_hover); ?>;
}
.ich-settings-main-wrap .btn-default:hover, .ich-settings-main-wrap .btn:hover,
#rem-agent-page .my-property .my-property-nav a.next:hover,
#rem-agent-page .my-property .my-property-nav a.previous:hover {
	border-radius: 0;
	background-color: <?php echo esc_attr($btn_bg_hover); ?>;
	color: <?php echo esc_attr($btn_txt_hover); ?>;
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
.ich-settings-main-wrap .rem-sale span,
.ich-settings-main-wrap .single-property-page-ribbon div,
.ich-settings-main-wrap .rem-sale-ribbon-2,
.ich-settings-main-wrap .marker-cluster-small,
.ich-settings-main-wrap #user-profile .property-list table thead th,
.ich-settings-main-wrap .rem-box-maps .price,
.ich-settings-main-wrap .noUi-horizontal .noUi-handle,
.rem-cat:hover .rem-cat-content,
.ich-settings-main-wrap .rem-box-maps .img-container .title:after,
.ich-settings-main-wrap .rem-box-maps .img-container .title:before,
.property-style-7:hover .price,
.rem-single-listing-1 .badge-under-heading,
.property-style-7 .img-container .title:after, .property-style-7 .img-container .title:before,
.ich-settings-main-wrap .price-slider.price #price-value-min, .price-slider.price #price-value-max,
input.labelauty:hover + label > span.labelauty-checked-image { 
	background-color: <?php echo esc_attr($main_color); ?> !important;
}
.ich-settings-main-wrap .rem-box-maps .img-container .title,
.agent-card-5:hover .agent-card-5-content,
.rem-cat-content,
.property-style-7 .img-container .title,
.ich-settings-main-wrap .noUi-connect {
	background-color: <?php echo esc_attr($main_color); ?>B3 !important;
}

.ich-settings-main-wrap .select2-container--default .select2-selection--multiple .select2-selection__choice {
	background-color: <?php echo esc_attr($main_color); ?> !important;
	color: #FFF;
	border: none;
}

.ich-settings-main-wrap .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
	color: #FFF;		
}

.ich-settings-main-wrap .single-property-page-ribbon div:after {
	border-left-color: <?php echo esc_attr($main_color); ?> !important;
	border-right-color: <?php echo esc_attr($main_color); ?> !important;
}

.ich-settings-main-wrap .nice-select:after {
	border-right-color: <?php echo esc_attr($main_color); ?> !important;
}
#property-content .details .detail .fa-square,
.rem-single-listing-1 .property-features-container .fa-square,
.hover-effect .cover:before,
.rem-style-1 .icons-wrap a:hover,
.rem-style-2 .icons-wrap a:hover,
.rem-style-1 .icons-wrap a.active,
.rem-style-2 .icons-wrap a.active,
.ich-settings-main-wrap .rem-topbar-btn.active {
	color: <?php echo esc_attr($main_color); ?> !important;
}
.rem-style-1 .icons-wrap a:hover,
.rem-style-2 .icons-wrap a:hover,
.rem-style-1 .icons-wrap a.active,
.rem-style-2 .icons-wrap a.active,
.ich-settings-main-wrap .rem-topbar-btn.active {
	border-color: <?php echo esc_attr($main_color); ?> !important;
}

.ich-settings-main-wrap .rem-topbar-btn {
	color: <?php echo esc_attr($main_color); ?>80 !important;
}
.ich-settings-main-wrap .dropdown .carat:after {
	border-top: 6px solid <?php echo esc_attr($main_color); ?> !important;
}
.input.labelauty:hover + label > span.labelauty-checked-image {
	border: none;
}
<?php if(is_rtl()){ ?>
	.price-slider.price #price-value-min:after {
		border-right: 6px solid <?php echo esc_attr($main_color); ?> !important;
	}
	.price-slider.price #price-value-max:after {
		border-left: 6px solid <?php echo esc_attr($main_color); ?> !important;
	}
<?php } else { ?>
	.price-slider.price #price-value-min:after {
		border-left: 6px solid <?php echo esc_attr($main_color); ?> !important;
	}
	.price-slider.price #price-value-max:after {
		border-right: 6px solid <?php echo esc_attr($main_color); ?> !important;
	}
<?php } ?>
.ich-settings-main-wrap .landz-box-property .title {
	border-bottom: 3px solid <?php echo esc_attr($main_color); ?>;
}
.ich-settings-main-wrap #user-profile .property-list table thead th {
	border-bottom: 0;
}
.ich-settings-main-wrap .landz-box-property .price:after {
	border-bottom: 10px solid <?php echo esc_attr($main_color); ?>;
}
.landz-box-property dd {
	margin: 0 !important;
}
#rem-agent-page .my-property .my-property-nav .button-container {
	border-top: 1px solid <?php echo esc_attr($main_color); ?> !important;
}
.ich-settings-main-wrap #new-property #position,
.prop-compare-wrapper.ich-settings-main-wrap .compare_close,
.prop-compare-wrapper.ich-settings-main-wrap .compare_open {
	background-color: <?php echo esc_attr($main_color); ?> !important;
}
.ich-settings-main-wrap #new-property #position:after {
	border-bottom: 10px solid <?php echo esc_attr($main_color); ?> !important;
}
.ich-settings-main-wrap .pagination > .active > a,
.ich-settings-main-wrap .pagination > .active > span,
.ich-settings-main-wrap .pagination > .active > a:hover,
.ich-settings-main-wrap .pagination > .active > span:hover,
.ich-settings-main-wrap .pagination > .active > a:focus,
.ich-settings-main-wrap .pagination > .active > span:focus {
	background-color: <?php echo esc_attr($main_color); ?> !important;
	border-color: <?php echo esc_attr($main_color); ?> !important;
}

<?php if (rem_get_option('ribbon_bg', '') != '') { ?>
.rem-property-box .featured-text,
.landz-box-property .rem-sale-ribbon-2,
.propery-style-6 .rem-sale-ribbon-2,
.property-box-16 .rem-sale-ribbon-2,
figure[class^="property-style-"] .rem-sale-ribbon-2,
.rem-sale.rem-sale-top-left span {
	background-color: <?php echo rem_get_option('ribbon_bg'); ?> !important;
}
.rem-sale::before, .rem-sale::after {
	border: 5px solid <?php echo rem_get_option('ribbon_bg'); ?>5E !important;
}
.rem-sale-ribbon-2:before {
	border-right-color: <?php echo rem_get_option('ribbon_bg'); ?>A6 !important;
}
<?php } ?>

<?php if (rem_get_option('badge_bg', '') != '') { ?>
.rem-property-box .property-type,
.property-style-19 .type-badge,
.flat-item-image .for-sale {
	background-color: <?php echo rem_get_option('badge_bg'); ?> !important;
}
<?php } ?>

<?php if (rem_get_option('energy_eff') == 'enable') {
	$ef_classes = rem_get_energy_efficiency_classes();
	foreach ($ef_classes as $key => $ef_c) {
		if ($key < 5) { ?>
			.rem-marker-energy[data-ef='<?php echo esc_attr($ef_c); ?>'] {
			  left: 0
			}
			.rem-marker-energy[data-ef='<?php echo esc_attr($ef_c); ?>']:before {
			  right: auto;
			  left: 0;
			  border-right: 10px solid transparent
			}
		<?php } else { ?>
			.rem-marker-energy[data-ef='<?php echo esc_attr($ef_c); ?>'] {
			  right: 0
			}
			.rem-marker-energy[data-ef='<?php echo esc_attr($ef_c); ?>']:before {
			  right: 0;
			  left: auto;
			  border-left: 10px solid transparent
			}
		<?php }
	}
?>
	.rem-energy-eff-wrap {
	  width: calc(100% / <?php echo count($ef_classes); ?>);
	}

	@media (max-width:481px) {
		<?php
		foreach ($ef_classes as $key => $ef_c) {
			if ($key < 5) { ?>
				.rem-marker-energy[data-ef='<?php echo esc_attr($ef_c); ?>']:before {
				  left: calc(<?php echo (100 / count($ef_classes)) * $key; ?>%)
				}
			<?php } else { ?>
				.rem-marker-energy[data-ef='<?php echo esc_attr($ef_c); ?>']:before {
				  right: auto;
				  left: calc(<?php echo (100 / count($ef_classes)) * $key; ?>% - 10px)
				}
			<?php }
		}
		?>
	}

<?php } ?>
<?php if (rem_get_option('agent_sidebar_sticky') == 'enable') { 
	$sticky_offset = rem_get_option('sticky_sidebar_offset');
	$sticky_offset = (!empty($sticky_offset)) ? $sticky_offset : '0' ;
?>
	.logged-in.single-rem_property .ich-settings-main-wrap  .rem_sticky_sidebar {
	    position: -webkit-sticky;
	    position: sticky;
	    top: calc(<?php echo esc_attr($sticky_offset); ?>px + 32px);
	}
	.single-rem_property .ich-settings-main-wrap  .rem_sticky_sidebar {
	    top: <?php echo esc_attr($sticky_offset); ?>px;
	    position: -webkit-sticky;
	    position: sticky;
	}
	@media only screen and (max-width: 481px) {
	  .logged-in.single-rem_property .ich-settings-main-wrap  .rem_sticky_sidebar {
		    position: relative;
		    top: auto;
		}
		.single-rem_property .ich-settings-main-wrap  .rem_sticky_sidebar {
		    top: auto;
		    position: relative;
		}
	}
<?php } ?>
<?php echo (isset($custom_css)) ? stripcslashes($custom_css) : '' ; ?>
<?php do_action( 'rem_css_kit_styles', esc_attr($main_color) ); ?>