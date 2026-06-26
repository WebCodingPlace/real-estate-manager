<?php
	$first_name = get_user_meta( $author_id, 'first_name', true );
	$last_name = get_user_meta( $author_id, 'last_name', true );
	$tagline = get_user_meta( $author_id, 'rem_user_tagline', true );
	$author_prop_count = count_user_posts($author_id, 'rem_property');
?>
<div class="agent-card-6-inner <?php echo is_author() ? '' : 'inner-padding' ?>">
	<div class="row">
		<div class="<?php echo is_author() ? 'col-xs-12' : 'col-xs-3' ?>">
			<div class="agent-card-6-avatar">
				<?php do_action( 'rem_agent_picture', $author_id ); ?>
			</div>
		</div>
		<?php if (!is_author()) { ?>
		<div class="col-xs-9">
			<div class="agent-card-6-info">
			    <h2 class="agent-card-6-name"> 
			        <?php 
			            $user_info = get_userdata($author_id);
			            echo rem_wpml_translate($user_info->display_name, 'Agent', 'display_name_'.$author_id);
			        ?>
			    </h2>
			    <span>
			    	<a href="<?php echo get_author_posts_url( $author_id ); ?>">
			        <?php printf( _n( '%s property', '%s properties', $author_prop_count, 'real-estate-manager' ), number_format_i18n( $author_prop_count ) ); ?>    
					</a>
				</span>
			</div>
		</div>
		<?php } ?>

		<?php if(is_author()){ ?>
		<div class="col-sm-12">
	        <div class="agent-card-6-social"> 
	            <?php
	            global $rem_ob;
	            $agent_fields = $rem_ob->get_agent_fields();
	            foreach ($agent_fields as $field) {
	                if ((isset($field['display']) && in_array('card', $field['display']) && get_user_meta( $author_id, $field['key'] , true ) != '') || $field['key'] == 'rem_agent_url') {
	                    $url = get_user_meta( $author_id, $field['key'] , true );
	                    $target = '_blank';

	                    if ($url != '' && $url != 'disable') {
	                        if($field['key'] == 'rem_mobile_url'){
	                            $target = '';
	                            if (!preg_match("/[a-z]/i", $url)) {
	                                $url = 'tel:'.$url;
	                            }
	                        }
	                        ?>
	                        <a class="<?php echo esc_attr($field['key']); ?>" href="<?php echo esc_url($url); ?>">
	                        	<?php if (isset($field['icon_class'])) { ?>
	                            	<i class="<?php echo esc_attr($field['icon_class']); ?>"></i>
	                        	<?php } ?>
	                        </a>                     
	                    <?php
	                    } 
	                }
	            } 
	            ?>  
	        </div>			
		</div>
		<?php } ?>
	</div>
</div>
<style type="text/css">
	.agent-card-6 {
		background-color: #FFFFFF;
	}
	.inner-padding {
		padding: 20px;
	}
	.agent-card-6-inner .agent-card-6-avatar img {
		max-width: 100% !important;
		height: auto;
	}
	.agent-card-6-inner .agent-card-6-avatar {
		border-radius: 3px;
		overflow: hidden;
	}
	.agent-card-6-name {
		margin: 5px 0 !important;
		font-size: 18px !important;
	}
	.agent-card-6-social {
		text-align: center;
		margin-top: 20px;
	}
	.agent-card-6-social a {
		padding: 10px 20px;
		display: inline-block;
		background-color: #FFF;
	}
</style>