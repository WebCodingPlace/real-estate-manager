<section id="property-content" class="ich-settings-main-wrap">
	<div class="row">
		<div class="<?php echo ($sidebar == 'enable') ? 'col-sm-9' : 'col-sm-12' ; ?>">
			<?php
				/**
				 * Hook: rem_single_property_page_slider.
				 */
				do_action( 'rem_single_property_page_slider', $property_id );

				/**
				 * Hook: rem_single_property_page_title.
				 */
				do_action( 'rem_single_property_page_title', $property_id );

				/**
				 * Hook: rem_single_property_page_contents.
				 */
				do_action( 'rem_single_property_page_contents', $property_id );

				/**
				 * Hook: rem_single_property_page_contents.
				 */
				do_action( 'rem_single_property_page_childs', $property_id );

				/**
				 * Hook: rem_single_property_page_sections.
				 */
				do_action( 'rem_single_property_page_sections', $property_id );

				/**
				 * Hook: rem_single_property_page_features.
				 */
				do_action( 'rem_single_property_page_features', $property_id );

				/**
				 * Hook: rem_single_property_page_map.
				 */
				do_action( 'rem_single_property_page_map', $property_id );

				/**
				 * Hook: rem_single_property_page_tags.
				 */
				do_action( 'rem_single_property_page_tags', $property_id );

				/**
				 * Hook: rem_single_property_page_edit.
				 */
				do_action( 'rem_single_property_page_edit', $property_id );
			?>
		</div>
		<?php if($sidebar == 'enable') { ?>
		<div class="col-sm-3">
			<?php
				global $post;
				$author_id = $post->post_author;
				do_action( 'rem_single_property_agent', $author_id );
			?>
			</div>
		<?php } ?>
	</div>
</section>