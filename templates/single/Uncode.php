<?php

/**
 * Single Property Template for Uncode Theme
 */

get_header();
global $post;
$author_id = $post->post_author;
$author_info = get_userdata($author_id);
$max_width = apply_filters( 'rem_max_container_width', '1170px' );


	/**
	 * DATA COLLECTION - START
	 **/

	/** Init variables **/
	$limit_width = $limit_content_width = $the_content = $main_content = $layout = $bg_color = $sidebar_style = $sidebar_bg_color = $sidebar = $sidebar_size = $sidebar_sticky = $sidebar_padding = $sidebar_inner_padding = $sidebar_content = $title_content = $media_content = $page_custom_width = $row_classes = $main_classes = $footer_content = $footer_classes = $content_after_body = '';
	$with_builder = false;

	if ($post->ID === 0) {
		$post = get_post( get_queried_object_id() );
	}

	$post_type = $post->post_type;

	/** Get general datas **/
	if (isset($metabox_data['_uncode_specific_style'][0]) && $metabox_data['_uncode_specific_style'][0] !== '') {
		$style = $metabox_data['_uncode_specific_style'][0];
		if (isset($metabox_data['_uncode_specific_bg_color'][0]) && $metabox_data['_uncode_specific_bg_color'][0] !== '') {
			$bg_color = $metabox_data['_uncode_specific_bg_color'][0];
		}
	} else {
		$style = ot_get_option('_uncode_general_style');
		if (isset($metabox_data['_uncode_specific_bg_color'][0]) && $metabox_data['_uncode_specific_bg_color'][0] !== '') {
			$bg_color = $metabox_data['_uncode_specific_bg_color'][0];
		} else {
			$bg_color = ot_get_option('_uncode_general_bg_color');
		}
	}
	$bg_color = ($bg_color == '') ? ' style-'.$style.'-bg' : ' style-'.$bg_color.'-bg';

	/** Get page width info **/
	$boxed = ot_get_option('_uncode_boxed');

	$page_content_full = (isset($metabox_data['_uncode_specific_layout_width'][0])) ? $metabox_data['_uncode_specific_layout_width'][0] : '';
	if ($page_content_full === '') {
		/** Use generic page width **/
		$generic_content_full = ot_get_option('_uncode_'.$post_type.'_layout_width');
		if ($generic_content_full === '') {
			$main_content_full = ot_get_option('_uncode_body_full');
			if ($main_content_full !== 'on') {
				$limit_content_width = ' limit-width';
			}
		} else {
			if ($generic_content_full === 'limit') {
				$generic_custom_width = ot_get_option('_uncode_'.$post_type.'_layout_width_custom');
				if ($generic_custom_width[1] === 'px') {
					if ( $generic_custom_width[0] == '' || ! is_numeric($generic_custom_width[0]) ) {
						$generic_custom_width[0] = 1200;
					}
					$generic_custom_width[0] = 12 * round(($generic_custom_width[0]) / 12);
				}
				if (is_array($generic_custom_width) && !empty($generic_custom_width)) {
					$page_custom_width = ' style="max-width: '.implode('', $generic_custom_width).'; margin: auto;"';
				}
			}
		}
	} else {
		/** Override page width **/
		if ($page_content_full === 'limit') {
			$limit_content_width = ' limit-width';
			$page_custom_width = (isset($metabox_data['_uncode_specific_layout_width_custom'][0])) ? unserialize($metabox_data['_uncode_specific_layout_width_custom'][0]) : '';
			if (is_array($page_custom_width) && !empty($page_custom_width) && $page_custom_width[0] !== '') {
				if ($page_custom_width[1] === 'px') {
					$page_custom_width[0] = 12 * round(($page_custom_width[0]) / 12);
				}
				$page_custom_width = ' style="max-width: '.implode("", $page_custom_width).'; margin: auto;"';
			} else {
				$page_custom_width = '';
			}
		}
	}

	$generic_media_display = ot_get_option('_uncode_' . $post_type . '_featured_media_display');
	$media_display = get_post_meta($post->ID, '_uncode_featured_media_display', 1);
	if ($media_display === '') {
		$media_display = $generic_media_display;
	}

	$media = get_post_meta($post->ID, '_uncode_featured_media', 1);
	$featured_image = get_post_thumbnail_id($post->ID);
	if ($featured_image === '') {
		$featured_image = $media;
	}

	/** Collect header data **/
	if (isset($metabox_data['_uncode_header_type'][0]) && $metabox_data['_uncode_header_type'][0] !== '') {
		$page_header_type = $metabox_data['_uncode_header_type'][0];
		if ($page_header_type !== 'none') {
			$meta_data = uncode_get_specific_header_data($metabox_data, $post_type, $featured_image);
			$metabox_data = $meta_data['meta'];
			$show_title = $meta_data['show_title'];
		}
	} else {
		$page_header_type = ot_get_option('_uncode_'.$post_type.'_header');
		if ($page_header_type !== '' && $page_header_type !== 'none') {
			$metabox_data['_uncode_header_type'] = array($page_header_type);
			$meta_data = uncode_get_general_header_data($metabox_data, $post_type, $featured_image);
			$metabox_data = $meta_data['meta'];
			$show_title = $meta_data['show_title'];
		}
	}

	/** Get layout info **/
	if (isset($metabox_data['_uncode_active_sidebar'][0]) && $metabox_data['_uncode_active_sidebar'][0] !== '') {
		if ($metabox_data['_uncode_active_sidebar'][0] !== 'off') {
			$layout = (isset($metabox_data['_uncode_sidebar_position'][0])) ? $metabox_data['_uncode_sidebar_position'][0] : '';
			$sidebar = (isset($metabox_data['_uncode_sidebar'][0])) ? $metabox_data['_uncode_sidebar'][0] : '';
			$sidebar_size = (isset($metabox_data['_uncode_sidebar_size'][0])) ? $metabox_data['_uncode_sidebar_size'][0] : 4;
			$sidebar_sticky = (isset($metabox_data['_uncode_sidebar_sticky'][0]) && $metabox_data['_uncode_sidebar_sticky'][0] === 'on') ? ' sticky-element' : '';
			$sidebar_fill = (isset($metabox_data['_uncode_sidebar_fill'][0])) ? $metabox_data['_uncode_sidebar_fill'][0] : '';
			$sidebar_style = (isset($metabox_data['_uncode_sidebar_style'][0])) ? $metabox_data['_uncode_sidebar_style'][0] : $style;
			$sidebar_bg_color = (isset($metabox_data['_uncode_sidebar_bgcolor'][0]) && $metabox_data['_uncode_sidebar_bgcolor'][0] !== '') ? ' style-' . $metabox_data['_uncode_sidebar_bgcolor'][0] . '-bg' : '';
		}
	} else {
		$activate_sidebar = ot_get_option('_uncode_'.$post_type.'_activate_sidebar');
		$sidebar_name     = ot_get_option('_uncode_'.$post_type.'_sidebar');

		if ($activate_sidebar !== 'off' && is_active_sidebar( $sidebar_name )) {
			$layout = ot_get_option('_uncode_'.$post_type.'_sidebar_position');
			if ($layout === '') {
				$layout = 'sidebar_right';
			}
			$sidebar = ot_get_option('_uncode_'.$post_type.'_sidebar');
			$sidebar_style = ot_get_option('_uncode_'.$post_type.'_sidebar_style');
			$sidebar_size = ot_get_option('_uncode_'.$post_type.'_sidebar_size');
			$sidebar_sticky = ot_get_option('_uncode_' . $post_type . '_sidebar_sticky');
			$sidebar_sticky = ($sidebar_sticky === 'on') ? ' sticky-element sticky-sidebar' : '';
			$sidebar_fill = ot_get_option('_uncode_'.$post_type.'_sidebar_fill');
			$sidebar_bg_color = ot_get_option('_uncode_'.$post_type.'_sidebar_bgcolor');
			$sidebar_bg_color = ($sidebar_bg_color !== '') ? ' style-' . $sidebar_bg_color . '-bg' : '';
		}
	}

	if ($sidebar_style === '') {
		$sidebar_style = $style;
	}

	/** Get breadcrumb info **/
	$generic_breadcrumb = ot_get_option('_uncode_' . $post_type . '_breadcrumb');
	$page_breadcrumb = (isset($metabox_data['_uncode_specific_breadcrumb'][0])) ? $metabox_data['_uncode_specific_breadcrumb'][0] : '';
	if ($page_breadcrumb === '') {
		$breadcrumb_align = ot_get_option('_uncode_' . $post_type . '_breadcrumb_align');
		$show_breadcrumb = ($generic_breadcrumb === 'off') ? false : true;
	} else {
		$breadcrumb_align = (isset($metabox_data['_uncode_specific_breadcrumb_align'][0])) ? $metabox_data['_uncode_specific_breadcrumb_align'][0] : '';
		$show_breadcrumb = ($page_breadcrumb === 'off') ? false : true;
	}

	/** Get title info **/
	$generic_show_title = ot_get_option('_uncode_'.$post_type.'_title');
	$page_show_title = (isset($metabox_data['_uncode_specific_title'][0])) ? $metabox_data['_uncode_specific_title'][0] : '';
	if ($page_show_title === '') {
		$show_title = ($generic_show_title === 'off') ? false : true;
	} else {
		$show_title = ($page_show_title === 'off') ? false : true;
	}

	/** Get media info **/
	$generic_show_media = ot_get_option('_uncode_' . $post_type . '_media');
	$page_show_media = (isset($metabox_data['_uncode_specific_media'][0])) ? $metabox_data['_uncode_specific_media'][0] : '';
	if ($page_show_media === '') {
		$show_media = ($generic_show_media === 'off') ? false : true;
	} else {
		$show_media = ($page_show_media === 'off') ? false : true;
	}

	if ( !$show_media && $featured_image !== '' ) {
		$generic_show_featured_media = ot_get_option('_uncode_' . $post_type . '_featured_media');
		$page_show_featured_media = (isset($metabox_data['_uncode_specific_featured_media'][0]) && $metabox_data['_uncode_specific_featured_media'][0] !== '') ? $metabox_data['_uncode_specific_featured_media'][0] : $generic_show_featured_media;

		if ( $page_show_featured_media === 'on' ) {
			$media = $featured_image;
		}
	} else {
		$page_show_featured_media = false;
	}

	$show_media = $page_show_featured_media && $page_show_featured_media!=='off' ? true : $show_media;

	/**
	 * DATA COLLECTION - END
	 **/

	while ( have_posts() ) : the_post();

		/** Build header **/
		if ($page_header_type !== '' && $page_header_type !== 'none') {
			$page_header = new unheader($metabox_data, $post->post_title, $post->post_excerpt);

			$header_html = $page_header->html;
			if ($header_html !== '') {
				echo '<div id="page-header">';
				echo uncode_remove_p_tag( $page_header->html );
				echo '</div>';
			}

			if (!empty($page_header->poster_id) && $page_header->poster_id !== false && $media !== '') {
				$media = $page_header->poster_id;
			}
		}
		echo '<script type="text/javascript">UNCODE.initHeader();</script>';
		/** Build breadcrumb **/

		if ($show_breadcrumb && !is_front_page() && !is_home()) {
			if ($breadcrumb_align === '') {
				$breadcrumb_align = 'right';
			}
			$breadcrumb_align = ' text-' . $breadcrumb_align;

			$content_breadcrumb = uncode_breadcrumbs();
			$breadcrumb_title = '<div class="breadcrumb-title h5 text-bold">' . get_the_title() . '</div>';
			echo uncode_get_row_template($breadcrumb_title . $content_breadcrumb, '', $limit_content_width, $style, ' row-breadcrumb row-breadcrumb-' . $style . $breadcrumb_align, 'half', true, 'half');
		}

		/** Build media **/

		if ($media !== '' && !$with_builder && $show_media && !post_password_required()) {
			if ($layout === 'sidebar_right' || $layout === 'sidebar_left') {
		  		if ($sidebar_size === '') {
		  			$sidebar_size = 4;
		  		}
				$media_size = 12 - $sidebar_size;
			} else {
				$media_size = 12;
			}

			$media_array = explode(',', $media);
			$media_counter = count($media_array);
			$rand_id = uncode_big_rand();
			if ($media_counter === 0) {
				$media_array = array($media);
			}

			if ($media_display === 'isotope') {
				$media_content.= '<div id="gallery-' . $rand_id . '" class="isotope-system post-media">
											<div class="isotope-wrapper half-gutter">
	        										<div class="isotope-container isotope-layout style-masonry" data-type="masonry" data-layout="masonry" data-lg="1000" data-md="600" data-sm="480">';
			}

			foreach ($media_array as $key => $value) {//check if albums are set among medias
				if ( get_post_mime_type($value) == 'oembed/gallery' && wp_get_post_parent_id($value) ) {
					$parent_id = wp_get_post_parent_id($value);
					$media_album_ids = get_post_meta($parent_id, '_uncode_featured_media', true);
					$media_arr = explode(',', $media);//eplode $media string to add album IDs
					$media_album_ids_arr = explode(',', $media_album_ids);
					if ( is_array($media_album_ids_arr) && !empty($media_album_ids_arr) ) {
						unset($media_array[$key]);//remove album featured image from array
						$media_album_ids_arr = array_reverse($media_album_ids_arr);
						foreach ($media_album_ids_arr as $_key => $_value) {
							array_splice($media_array, $key, 0, $_value);
							array_splice($media_arr, $key, 0, $_value);
						}
					}
					$media = implode(",", $media_arr);//implode $media again after adding album IDs
				}
			}

			foreach ($media_array as $key => $value) {
				if ($media_display === 'carousel') {
					$value = $media;
				}
				$block_data = array();
				$block_data['media_id'] = $value;
				$block_data['classes'] = array(
					'tmb'
				);
				$block_data['text_padding'] = 'no-block-padding';
				if ($media_display === 'isotope') {
					$block_data['single_width'] = 4;
					$block_data['classes'][] = 'tmb-iso-w4';
				} else {
					$block_data['single_width'] = $media_size;
				}
				$block_data['single_style'] = $style;
				$block_data['single_text'] = 'under';
				$block_data['classes'][] = 'tmb-'.$style;
				if ($media_display === 'isotope') {
					$block_data['classes'][] = 'tmb-overlay-anim';
					$block_data['classes'][] = 'tmb-overlay-text-anim';
					$block_data['single_icon'] = 'fa fa-plus2';
					$block_data['overlay_color'] = ($style == 'light') ? 'style-black-bg' : 'style-white-bg';
					$block_data['overlay_opacity'] = '20';
					$lightbox_classes = array();
					$lightbox_classes['data-noarr'] = false;
				} else {
					$lightbox_classes = false;
					$block_data['link_class'] = 'inactive-link';
					$block_data['link'] = '#';
				}
				$block_data['title_classes'] = array();
				$block_data['tmb_data'] = array();
				$block_layout['media'] = array();
				$block_layout['icon'] = array();
				$media_html = uncode_create_single_block($block_data, $rand_id, 'masonry', $block_layout, $lightbox_classes, false, true);
				if ($media_display !== 'isotope') {
					$media_content.= '<div class="post-media">' . $media_html . '</div>';
				} else {
					$media_content.= $media_html;
				}
				if ($media_display === 'carousel') {
					break;
				}
			}

			if ($media_display === 'isotope') {
				$media_content.= '</div>
											</div>
										</div>';
			}
		}

		/** Build title **/

		if ($show_title) {
			$title_content .= apply_filters( 'uncode_before_body_title', '' );
			$title_content .= '<div class="post-title-wrapper"><h1 class="post-title">' . get_the_title() . '</h1></div>';
			$title_content .= apply_filters( 'uncode_after_body_title', '' );
		}

		/** Build content **/

	if (rem_get_option('agent_sidebar_sticky') == 'enable'){
		$sticky_class = 'rem_sticky_sidebar';
	}
?>
	<section id="property-content" class="ich-settings-main-wrap" style="max-width: <?php echo esc_attr($max_width); ?>;margin:0 auto;">

		<div class="">
			<div class="row">

				<div id="post-<?php the_ID(); ?>" <?php post_class('col-sm-8 col-md-9'); ?>>
					<?php
						/**
						 * Hook: rem_single_property_page_slider.
						 */
						do_action( 'rem_single_property_page_slider', get_the_id() );

						/**
						 * Hook: rem_single_property_page_title.
						 */
						do_action( 'rem_single_property_page_title', get_the_id() );

						/**
						 * Hook: rem_single_property_page_contents.
						 */
						do_action( 'rem_single_property_page_contents', get_the_id() );

						/**
						 * Hook: rem_single_property_page_sections.
						 */
						do_action( 'rem_single_property_page_sections', get_the_id() );

						/**
						 * Hook: rem_single_property_page_features.
						 */
						do_action( 'rem_single_property_page_features', get_the_id() );

						/**
						 * Hook: rem_single_property_page_map.
						 */
						do_action( 'rem_single_property_page_map', get_the_id() );

						/**
						 * Hook: rem_single_property_page_tags.
						 */
						do_action( 'rem_single_property_page_tags', get_the_id() );

						/**
						 * Hook: rem_single_property_page_edit.
						 */
						do_action( 'rem_single_property_page_edit', get_the_id() );
					?>
				</div>

				<div class="col-sm-4 col-md-3 <?php echo esc_attr($sticky_class); ?>">
					<?php
						do_action( 'rem_single_property_agent', $author_id );
						$p_sidebar = rem_get_option('property_page_sidebar', '');
						if ( is_active_sidebar( $p_sidebar )  ) {
							dynamic_sidebar( $p_sidebar );
						}
					?>
				</div>

			</div>
		</div>
	</section>

<?php		
		
		/** Build post after block **/

		$page_content_block_after = (isset($metabox_data['_uncode_specific_content_block_after'][0])) ? $metabox_data['_uncode_specific_content_block_after'][0] : '';
		if ($page_content_block_after === '') {
			$generic_content_block_after = ot_get_option('_uncode_' . $post_type . '_content_block_after');
			$content_block_after = $generic_content_block_after !== '' ? $generic_content_block_after : false;
		} else {
			$content_block_after = $page_content_block_after !== 'none' ? $page_content_block_after : false;
		}

		if ($content_block_after !== false) {
			$content_block_after = apply_filters( 'wpml_object_id', $content_block_after, 'post' );
			$content_after_body = get_post_field('post_content', $content_block_after);
			if (class_exists('Vc_Base')) {
				$vc = new Vc_Base();
				$vc->addShortcodesCustomCss($content_block_after);
			}
			if ( $content_block_after !== '' && function_exists('vc_is_page_editable') && vc_is_page_editable() ) {
				$cb_edit_link = vc_frontend_editor()->getInlineUrl( '', $content_block_after );
				$content_block_after .= '<div class="vc_controls-element vc_controls vc_controls-content_block"><div
					class="vc_controls-cc"><a
						class="vc_control-btn vc_element-name vc_control-btn-edit" data-control="edit" href="' . esc_url( $cb_edit_link ) . '" target="_blank" title="' . esc_html__( 'Edit Content Block', 'uncode' ) . '"><span class="vc_btn-content">' . esc_html__( 'Post After Content Block', 'uncode' ) . '<span class="vc_btn-content"><i class="vc-composer-icon vc-c-icon-mode_edit"></i></span></span></a></div></div>';

			}
			if (has_shortcode($content_after_body, 'vc_row')) {
				$content_after_body = '<div class="post-after row-container">' . $content_after_body . '</div>';
			} else {
				$content_after_body = '<div class="post-after row-container">' . uncode_get_row_template($content_after_body, $limit_width, $limit_content_width, $style, '', false, true, 'double', $page_custom_width) . '</div>';
			}
			$archive_query = '';
			$regex = '/\[uncode_index(.*?)\]/';
			$regex_attr = '/(.*?)=\"(.*?)\"/';
			preg_match_all($regex, $content_after_body, $matches, PREG_SET_ORDER);
			foreach ($matches as $key => $value) {
				$index_found = false;
				if (isset($value[1])) {
					preg_match_all($regex_attr, trim($value[1]), $matches_attr, PREG_SET_ORDER);
					foreach ($matches_attr as $key_attr => $value_attr) {
						switch (trim($value_attr[1])) {
							case 'auto_query':
								if ($value_attr[2] === 'yes') {
									$index_found = true;
								}
								break;
							case 'loop':
								$archive_query = $value_attr[2];
								break;
						}
					}
				}
				if ($index_found) {
					if ($archive_query === '') {
						$related_posts_ids = uncode_get_related_post_ids( $post->ID, 10 );
						$archive_query = ' loop="size:10|by_id:' . implode(',', $related_posts_ids) .'|post_type:' . $post->post_type . '"';
					} else {
						$parse_query          = uncode_parse_loop_data($archive_query);
						$related_posts_count  = isset( $parse_query[ 'size' ] ) ? absint( $parse_query[ 'size' ] ) : 3;
						$related_posts_ids    = uncode_get_related_post_ids( $post->ID, $related_posts_count );
						$parse_query['by_id'] = implode(',', $related_posts_ids);
						if (!isset($parse_query['order'])) {
							$parse_query['order'] = 'none';
						}
						$parse_query['post_type'] = $post->post_type;
						$archive_query = ' loop="' . uncode_unparse_loop_data($parse_query) . '"';
					}
					$value[1] = preg_replace('#\s(loop)="([^"]+)"#', $archive_query, $value[1], -1, $index_count);
					if ($index_count === 0) {
						$value[1] .= $archive_query;
					}
					$replacement = '[uncode_index' . $value[1] . ']';
					$content_after_body = str_replace($value[0], $replacement, $content_after_body);
				}
			}
		}

  	/** Build post footer **/

  	$show_comments = ot_get_option('_uncode_' . $post_type . '_comments');

		if ((comments_open() || '0' != get_comments_number()) && $show_comments === 'on') {
			$footer_content.= '<div data-name="commenta-area">';
				ob_start();
				comments_template();
				$footer_content.= ob_get_clean();
			$footer_content.= '</div>';
		}

  	if ( $layout === 'sidebar_right' || $layout === 'sidebar_left' ) {

  		/** Build structure with sidebar **/

  		if ($sidebar_size === '') {
  			$sidebar_size = 4;
  		}
  		$main_size = 12 - $sidebar_size;
  		$expand_col = '';

  		/** Collect paddings data **/

  		$footer_classes = ' no-top-padding double-bottom-padding';

  		if ($sidebar_bg_color !== '') {
  			if ($sidebar_fill === 'on') {
  				$sidebar_inner_padding .= ' std-block-padding';
  				$sidebar_padding .= $sidebar_bg_color;
  				$expand_col = ' unexpand';
  				if ($limit_content_width === '') {
  					$row_classes .= ' no-h-padding col-no-gutter no-top-padding';
  					$footer_classes = ' std-block-padding no-top-padding';
  					if (!$with_builder) {
  						$main_classes .= ' std-block-padding';
  					}
  				} else {
  					$row_classes .= ' no-top-padding';
  					if (!$with_builder) {
  						$main_classes .= ' double-top-padding';
  					}
  				}
  			} else {
  				$row_classes .= ' double-top-padding';
  				$row_classes .= ' double-bottom-padding';
  				$sidebar_inner_padding .= $sidebar_bg_color . ' single-block-padding';
  			}
  		} else {
  			if ($with_builder) {
  				if ($limit_content_width === '') {
  					$row_classes .= ' col-std-gutter no-top-padding';
  					if ($boxed !== 'on' && $page_custom_width === '') {
  						$row_classes .= ' no-h-padding';
  					}
  				} else {
  					$row_classes .= ' col-std-gutter no-top-padding';
  				}
  				$sidebar_inner_padding .= ' double-top-padding';
  			} else {
  				$row_classes .= ' col-std-gutter double-top-padding';
  				$main_classes .= ' double-bottom-padding';
  			}
  		}

  		$row_classes .= ' no-bottom-padding';
  		$sidebar_inner_padding .= ' double-bottom-padding';

  		/** Build sidebar **/

			$sidebar_content = "";
			ob_start();
			if ($sidebar !== '') {
				dynamic_sidebar($sidebar);
			} else {
				dynamic_sidebar(1);
			}
			$sidebar_content = ob_get_clean();

			/** Create html with sidebar **/

			$the_content = '<div class="post-content style-'.$style.$main_classes.'">' . $the_content . '</div>';

			if ($footer_content !== '') {
				if ($limit_content_width === '') {
					$footer_content = uncode_get_row_template($footer_content, $limit_width, $limit_content_width, $style, '', false, true, '');
				}
				$footer_content = '<div class="post-footer post-footer-' . $style . ' style-' . $style . $footer_classes . '">' . $footer_content . '</div>';
			}

			$main_content = 	'<div class="col-lg-'.$main_size.'">
					' . $the_content . $footer_content . '
				</div>';

			$the_content = '<div class="row-container">
	        							<div class="row row-parent un-sidebar-layout' . $row_classes . $limit_content_width . '"' . $page_custom_width . '>
													<div class="row-inner">
														' . (($layout === 'sidebar_right') ? $main_content : '') . '
														<div class="col-lg-' . $sidebar_size . ' col-widgets-sidebar">
															<div class="uncol style-' . $sidebar_style . $expand_col . $sidebar_padding . (($sidebar_fill === 'on' && $sidebar_bg_color !== '') ? '' : $sidebar_sticky) . '">
																<div class="uncoltable' . (($sidebar_fill === 'on' && $sidebar_bg_color !== '') ? $sidebar_sticky : '') . '">
																	<div class="uncell' . $sidebar_inner_padding . '">
																		<div class="uncont">
																			' . $sidebar_content . '
																		</div>
																	</div>
																</div>
															</div>
														</div>
														' . (($layout === 'sidebar_left') ? $main_content : '') . '
													</div>
												</div>
											</div>';

		} else {
			/** Create html without sidebar **/
			if ($with_builder) {
				$the_content = '<div class="post-content un-no-sidebar-layout">' . $the_content  . '</div>';
			} else {
				$the_content = '<div class="post-content un-no-sidebar-layout"'.$page_custom_width.'>' . uncode_get_row_template($the_content, $limit_width, $limit_content_width, $style, '', 'double', true, 'double')  . '</div>';
			}
			if ($footer_content !== '') {
				$the_content.= '<div class="post-footer post-footer-' . $style . ' row-container">' . uncode_get_row_template($footer_content, $limit_width, $limit_content_width, $style, '', true, true, 'double', $page_custom_width) . '</div>';
			}
		}

		/** Display post html **/
		echo 	'<article id="post-'. get_the_ID().'" class="'.implode(' ', get_post_class('page-body'.$bg_color)) .'">
						<div class="post-wrapper">
							<div class="post-body">' . uncode_remove_p_tag($the_content . $content_after_body) . '</div>
						</div>
					</article>';

	endwhile; // end of the loop. ?>

<?php get_footer(); ?>
