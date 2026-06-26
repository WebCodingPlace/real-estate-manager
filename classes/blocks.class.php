<?php
/**
* This class handles all work regarding Gutenberg Blocks
*/
class REM_Gutenberg_Blocks
{
	
	function __construct(){
        add_filter( 'block_categories_all', array($this, 'rem_block_category'), 30, 2 );
        add_action( 'enqueue_block_editor_assets', array($this, 'block_editor_assets') );
        add_action( 'init', array($this, 'register_blocks') );
        add_filter( 'rem_gutenberg_blocks', array($this, 'filter_through_blocks'), 30, 1 );
	}

    function rem_blocks(){
        $blocks = array(
            array(
                'slug' => 'login-agent',
                'callback' => 'login_agent',
                'attributes' => array(
                    'heading' => array('type' => 'string'),
                    'redirect' => array('type' => 'string'),
                    'content' => array('source' => 'html'),
                ),
                'css' => array(
                    array(
                        'slug' => 'rem-bs-css',
                        'file' => REM_URL . '/assets/admin/css/bootstrap.min.css'
                    ),
                )
            ),
            array(
                'slug' => 'register-agent',
                'callback' => 'register_agent',
                'attributes' => array(
                    'redirect' => array('type' => 'string'),
                    'content' => array('source' => 'html'),
                ),
                'css' => array(
                    array(
                        'slug' => 'rem-bs-css',
                        'file' => REM_URL . '/assets/admin/css/bootstrap.min.css'
                    ),
                )
            ),
            array(
                'slug' => 'simple-search',
                'callback' => 'simple_search',
                'attributes' => array(
                    'placeholder' => array('type' => 'string'),
                    'width' => array('type' => 'string'),
                    'border_color' => array('type' => 'string'),
                    'results_page' => array('type' => 'string'),
                    'search_icon' => array('type' => 'html'),
                ),
                'css' => array(
                	array(
                		'slug' => 'rem-bs-css',
                		'file' => REM_URL . '/assets/admin/css/bootstrap.min.css'
                	),
                )
            ),
        );

        return apply_filters( 'rem_gutenberg_blocks', $blocks );
    }

    function filter_through_blocks($blocks){
        $enabled_blocks = rem_get_option('gutenberg_blocks');


        if ($enabled_blocks != '' && is_array($enabled_blocks)) {
            foreach ($blocks as $key => $block) {
                if (!in_array($block['callback'], $enabled_blocks)) {
                    unset($blocks[$key]);
                }
            }
        }

        return $blocks;
    }

    function rem_block_category( $categories, $block_editor_context ) {
        if (isset($block_editor_context->post->post_type) && in_array( $block_editor_context->post->post_type, ['post', 'page'] ) ) {
            return array_merge(
                $categories,
                array(
                    array(
                        'slug' => 'rem',
                        'title' => __( 'Real Estate Manager', 'real-estate-manager' ),
                        'icon' => 'admin-home',
                    ),
                )
            );
        } else {
            return $categories;
        }
    }


    function block_editor_assets(){
        global $post;
        if ( isset($post->post_type) && $post->post_type != 'rem_property' ) {
            $blocks = $this->rem_blocks();
            foreach ($blocks as $block) {
            	if (isset($block['css']) && is_array($block['css'])) {
            		foreach ($block['css'] as $css) {
            			wp_enqueue_style( $css['slug'], $css['file'] );
            		}
            	}
                if (file_exists(REM_PATH . '/assets/admin/js/blocks/'.$block['slug'].'.js')) {
                    wp_enqueue_script(
                        'rem-gutenberg-'.$block['slug'],
                        REM_URL . '/assets/admin/js/blocks/'.$block['slug'].'.js',
                        array( 'wp-blocks', 'wp-editor' , 'wp-i18n', 'wp-element' ),
                        filemtime( REM_PATH . '/assets/admin/js/blocks/'.$block['slug'].'.js' )
                    );
                }
            }
        }
    }

    function register_blocks(){
        if (function_exists('register_block_type')) {
            $blocks = $this->rem_blocks();
            foreach ($blocks as $block) {
            	$settings = array();
            	$settings['render_callback'] = array($this, $block['callback']);
            	$settings['attributes'] = $block['attributes'];          

                register_block_type( 'real-estate-manager/'.$block['slug'], $settings );
            }
        }
    }

    function login_agent($attributes, $content){
        global $rem_sc_ob;
        return $rem_sc_ob->login_agent($attributes, $content);
    }

    function register_agent($attributes, $content){
        global $rem_sc_ob;
        return $rem_sc_ob->register_agent($attributes, $content);
    }

    function simple_search($attributes){
		global $rem_sc_ob;
		return $rem_sc_ob->simple_search_property($attributes);
    }

}
?>