<?php
	$first_name = get_user_meta( $author_id, 'first_name', true );
	$last_name = get_user_meta( $author_id, 'last_name', true );
	$tagline = get_user_meta( $author_id, 'rem_user_tagline', true );
	$author_prop_count = count_user_posts($author_id, 'rem_property');
?>

<div>
	<div class="agent-card-4-img-box">
		<div class="agent-card-4-listing"><?php echo sprintf(__("%s listings",'real-estate-manager'), $author_prop_count); ?></div> 
		<?php do_action( 'rem_agent_picture', $author_id ); ?>
	</div>

	<?php if (!is_author()) { ?>
	<h4>
        <a href="<?php echo get_author_posts_url( $author_id ); ?>">
        <?php 
            $user_info = get_userdata($author_id);
            echo rem_wpml_translate($user_info->display_name, 'Agent', 'display_name_'.$author_id);
        ?>
        </a> 
	</h4>
	<?php } ?>

	<?php if ($tagline != '') { ?>
		<div class="agent-card-4-tagline">
			<?php echo rem_wpml_translate($tagline, 'Agent', 'rem_user_tagline_'.$author_id); ?>
		</div>
	<?php } ?>

	<div class="agent-card-4-social-list">
		<?php
		global $rem_ob;
		$agent_fields = $rem_ob->get_agent_fields();
        foreach ($agent_fields as $field) {
            if ((isset($field['display']) && in_array('card', $field['display']) && get_user_meta( $author_id, $field['key'] , true ) != '') || $field['key'] == 'rem_agent_url') {
                $url = get_user_meta( $author_id, $field['key'] , true );
                $target = '_blank';

                if ($url != '' && $url != 'disable') { ?>
                	<a class="<?php echo esc_attr($field['key']); ?>" href="<?php echo esc_url($url); ?>">
						<i class="<?php echo esc_attr($field['icon_class']); ?>"></i>
					</a>                     
                <?php
                } 
            }
        } 
        ?>	
	</div>
</div>

<style type="text/css">
.agent-card-4 {
    margin-bottom: 0px;
    box-shadow: 0 10px 31px 0 rgba(7,152,255,0.09);
	border-radius: 2px;
}
.agent-card-4:hover {
    box-shadow: 0 3px 23px 9px rgba(7,152,255,0.15)!important;
    transform: translate(0%, -10px);
}
.agent-card-4:hover img {
    opacity: 0.8;
    transform: scale(1.1);
    -moz-transform: scale(1.1);
    -webkit-transform: scale(1.1);
    -o-transform: scale(1.1);
    -ms-transform: scale(1.1);
    -ms-filter: "progid:DXImageTransform.Microsoft.Matrix(M11=1.1, M12=0, M21=0, M22=1.1, SizingMethod='auto expand')";
    filter: progid:DXImageTransform.Microsoft.Matrix(M11=1.1, M12=0, M21=0, M22=1.1, SizingMethod='auto expand');
}
.agent-card-4-social-list a:hover {
    color: #04090f !important;
}
.agent-card-4 {
    width: 100%;
    padding-right: 0px;
    padding-left: 0px;
    margin-bottom: 30px;
    border: 1px solid #f1f8ff;
    position: relative;
    overflow: hidden;
    background-color: #fff;
    -webkit-transition: all 0.4s ease;
    -moz-transition: all 0.4s ease;
    -o-transition: all 0.4s ease;
    transition: all 0.4s ease;
}

.agent-card-4-img-box {
    position: relative;
    overflow: hidden;
    margin: 7px;
    border-radius: 2px;
}
.agent-card-4-listing {
    position: absolute;
    left: 15px;
    bottom: 10px;
    font-size: 12px;
    background-color: #f1bf7f;
    color: #ffffff;
    float: right;
    padding: 4px 15px;
    margin-top: 4px;
    line-height: 12px;
    z-index: 1;
    font-weight: 600;
}
.agent-card-4 img {
    transition: all 0.7s ease;
    -moz-transition: all 0.7s ease;
    -ms-transition: all 0.7s ease;
    -webkit-transition: all 0.7s ease;
    -o-transition: all 0.7s ease;
    -webkit-transform-style: preserve-3d;
    -webkit-backface-visibility: hidden;
    width: 100%;
    display: inline-block;
}
.agent-card-4 h4 {
    padding: 0px 20px;
    margin-top: 20px !important;
    font-size: 20px !important;
    margin-bottom: 5px !important;
    font-weight: 800 !important;
}
.agent-card-4 .agent-card-4-tagline {
    padding-right: 20px;
    margin-left: 20px;
    font-weight: 600;
}
.agent-card-4 .agent-card-4-tagline{
	font-size: 13px;    
    line-height: 13px;
    color: #777;
}
.agent-card-4-content {
    font-size: 14px;
    margin: 20px 20px 0px 20px;
    line-height: 1.5em;
}
.agent-card-4-social-list {
    bottom: 15px;
    font-size: 20px;
    padding: 20px 20px 0px 20px;
    width: 100%;
}
.agent-card-4-social-list a {
    color: #777!important;
    margin-right: 5px;
    font-size: 13px;
    background: #efefef !important;
    position: relative;
    width: 30px;
    height: 30px;
    line-height: 30px;
    display: inline-block;
    text-align: center;
    border-radius: 50%;
}
.rem-list-agents .agent-card-4-social-list {
  margin-bottom: 20px;
}
</style>