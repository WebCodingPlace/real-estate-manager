<?php
	$first_name = get_user_meta( $author_id, 'first_name', true );
	$last_name = get_user_meta( $author_id, 'last_name', true );
	$tagline = get_user_meta( $author_id, 'rem_user_tagline', true );
	$author_prop_count = count_user_posts($author_id, 'rem_property');
?>

<div class="agent-card-5-inner">
    <div class="agent-card-5-avatar">
        <a href="<?php echo get_author_posts_url( $author_id ); ?>">
           <?php do_action( 'rem_agent_picture', $author_id ); ?>
        </a>
    </div>
    <div class="agent-card-5-content">
        <div class="agent-card-5-info">
            <?php if (!is_author()) { ?>
            <h2 class="agent-card-5-name"> 
                <?php 
                    $user_info = get_userdata($author_id);
                    echo rem_wpml_translate($user_info->display_name, 'Agent', 'display_name_'.$author_id);
                ?>
            </h2>
            <?php } ?>
            <span>
                <?php printf( _n( '%s property', '%s properties', $author_prop_count, 'real-estate-manager' ), number_format_i18n( $author_prop_count ) ); ?>    
            </span>
        </div>
        <div class="agent-card-5-social"> 
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
</div>

<div class="clearfix"></div>

<style type="text/css">

.agent-card-5 {
    overflow: hidden;
}
.agent-card-5-inner {
    position: relative;
}
.agent-card-5-avatar {
    margin: auto;
}
.agent-card-5-avatar {
    text-align: center;
}
a, a:focus, a:hover {
    outline: none;
    text-decoration: none;
    color: #727272;
}
.agent-card-5-avatar img {
    width: 100%;
    display: block;
}
.agent-card-5-content {
    left: 0;
    right: 0;
}
.agent-card-5-content {
    padding: 10px;
    background-color: #222;
    -webkit-transition: all 1s;
    -moz-transition: all 1s;
    -ms-transition: all 1s;
    -o-transition: all 1s;
    transition: all 1s;
    position: absolute;
    bottom: 0;
}
.agent-card-5-content {
    text-align: center;
}
.agent-card-5-info {
    background-color: transparent;
    padding-top: 0;
    padding-bottom: 3px;
}
.agent-card-5-info h2.agent-card-5-name {
    color: #fff;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 0;
    margin-top: 0;
}
.agent-card-5 h2 {
    border: none;
    text-decoration: none;
    -webkit-transition: all .3s;
    -moz-transition: all .3s;
    -o-transition: all .3s;
    transition: all .3s;
}
.agent-card-5-info span {
    -webkit-transition: all .3s;
    -moz-transition: all .3s;
    -ms-transition: all .3s;
    -o-transition: all .3s;
    transition: all .3s;
    color: #bababa;
    font-weight: 400;
    margin-top: 2px;
    display: inline-block;
}
.agent-card-5-social {
    top: initial;
    background-color: transparent;
    margin: 0;
    -webkit-transition: all .5s;
    -moz-transition: all .5s;
    -ms-transition: all .5s;
    -o-transition: all .5s;
    transition: all .5s;
    max-height: 0;
}
.agent-card-5-social {
    /*background: #fb6a19;*/
    /*margin: 0 35px;*/
    position: relative;
    /*top: -17.5px;*/
}
.agent-card-5-social a {
    display: inline-block;
    line-height: 35px;
    width: 35px;
    height: 35px;
    border: none;
}
a, a:focus, a:hover {
    outline: none;
    text-decoration: none;
    color: #727272;
}
.agent-card-5-social a i {
    color: #fff;
}
.agent-card-5-social a i {
    font-size: 13px;
    line-height: 35px;
    -webkit-transition: all .3s;
    -moz-transition: all .3s;
    -o-transition: all .3s;
    transition: all .3s;
}
.agent-card-5:hover .agent-card-5-content {
    background-color: #92c800;
}
.agent-card-5:hover .agent-card-5-info span {
    color: #fff;
}
.agent-card-5:hover .agent-card-5-social {
    max-height: 100px;
}
.agent-card-5 .contact-agent,
.agent-card-5 .skill-box {
    border: 1px solid #e5dede;
}
</style>