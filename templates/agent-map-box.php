<?php
	$first_name = get_user_meta( $author_id, 'first_name', true );
	$last_name = get_user_meta( $author_id, 'last_name', true );
	$tagline = get_user_meta( $author_id, 'rem_user_tagline', true );
	$img = '';
	if(get_the_author_meta( 'rem_agent_meta_image', $author_id ) != '') {
       $img = esc_url_raw( get_the_author_meta( 'rem_agent_meta_image', $author_id ) );
    }

    $user_info = get_userdata($author_id);
?>
<div class="rem-box-maps">
    <a href="<?php echo get_author_posts_url( $author_id ); ?>" class="img-container" style="background-image:url(' <?php echo esc_url($img); ?> ')">
        
    </a>
    <h4 class="text-center">
    	<a href="<?php echo get_author_posts_url( $author_id ); ?>">
    	<?php echo rem_wpml_translate($user_info->display_name, 'Agent', 'display_name_'.$author_id); ?>
    	</a>
    </h4>
</div>