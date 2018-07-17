<?php
/**
* REM - Search Property Widget 2 (using jQueryUI)
* since 6.2
*
* Copyleft (c)2018 Kernc
* License: GPL-3.0
*/

class REM_Search_Property_Widget2 extends WP_Widget {

    /**
     * Register rem_search_property_widget widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'rem_search_property_widget2', // Base ID
            __( 'REM - Search Property (jQueryUI)', 'real-estate-manager' ), // Name
            array( 'description' => __( 'Search Properties', 'real-estate-manager' ), ) // Args
        );
    }

    public function widget( $args, $instance ) {

        rem_load_bs_and_fa();
        rem_load_basic_styles();
        wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
        wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-1.12.4.js');
        wp_enqueue_script('jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', array('jquery'));

        $script_settings = array(
            'currency_symbol'   => rem_get_currency_symbol(),
            'currency_position' => rem_get_option('currency_position', 'left'),
            'area_unit'         => rem_get_option('properties_area_unit', 'Sq Ft'),
        );

        extract($instance);

        echo $args['before_widget'];

        if ( isset($instance['title']) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        // geting data from rem class
        global $rem_ob;
        $property_purposes = $rem_ob->get_all_property_purpose();
        $property_types = $rem_ob->get_all_property_types();
        $property_status = $rem_ob->get_all_property_status();
        $all_fields = $rem_ob->single_property_fields();
?>
<style>
.ich-settings-main-wrap .rem-srch label {
    display: block;
    font-size: inherit;
}
.ich-settings-main-wrap .rem-srch .ui-selectmenu-button {
    width: 100%;
    line-height: inherit;
    font: inherit;
    font-weight: normal;
}
.ich-settings-main-wrap .rem-srch input.range-end-points {
    border:0 !important;
    box-shadow: none;
    padding:0;
    width: 80%;
    display: inline-block;
    text-align:right;
    font-weight: normal;
}
.ich-settings-main-wrap .rem-srch .unit {
    font-weight: normal;
    margin: 0 .5em;
}
</style>
<div class="ich-settings-main-wrap">
    <?php $form_id = 'rem-srch-' . uniqid(); ?>
    <form class="rem-srch" id="<?php echo $form_id; ?>" method="get" action="<?php echo get_permalink( $result_page ); ?>">
        <div class="form-group" <?php if(!isset($search_field)) echo 'hidden'; ?>>
            <input class="form-control" value="<?php echo @esc_attr($_GET['search_property']); ?>" name="search_property" placeholder="<?php _e( 'Keywords','real-estate-manager' ); ?>" />
        </div>
        <?php
            foreach ($all_fields as $field) {
                $key = $field['key'];
                $label = __($field['title'], 'real-estate-manager');

                $key_is_price = preg_match('/(_|\b)price(_|\b)/i', $key);
                $key_is_area = preg_match('/(_|\b)area(_|\b)/i', $key);
                $key_is_rooms = preg_match('/rooms(_|\b)/i', $key);
                $currency_left = strpos($script_settings['currency_position'], 'left') !== false;

                if (!isset($instance[$key]))
                    continue;

                if ($field['type'] == 'number' || $key_is_price || $key_is_area || $key_is_rooms) { ?>
                    <div class="form-group">
                        <label><?php echo $label; ?><br>
                            <?php
                            // Prepend currency prefix
                            if ($key_is_price && $currency_left)
                                echo '<span class="unit">' . $script_settings['currency_symbol'] . '</span>';
                            ?>

                            <input name="<?php echo $key; ?>" class="range-end-points" id="rem-srch-<?php echo $key; ?>" value="<?php echo @esc_attr($_GET[$key]); ?>" placeholder="<?php _e( 'Any', 'real-estate-manager' ); ?>"/>

                            <?php
                            // Apend currency / area suffix
                            if ($key_is_price && !$currency_left)
                                echo '<span class="unit">' . $script_settings['currency_symbol'] . '</span>';
                            elseif ($key_is_area)
                                echo '<span class="unit">' . $script_settings['area_unit'] . '</span>';
                            ?>
                        </label>
                        <div id="rem-srch-<?php echo $key ?>-range"></div>
                        <?php

                        // Compute min-max range and step size by querying
                        // available properties. This makes queries (i.e. slow),
                        // BUT plays along nicely with plugins that offer persistent
                        // object cache, such as W3TC ...
                        $min_max_step = wp_cache_get( 'rem-srch-range-'.$key );
                        if ( $min_max_step === false ) {
                            $q = new WP_Query(array(
                                'post_type' => 'rem_property',
                                'meta_key' => 'rem_'.$key,
                                'meta_compare' => '>=',  // XXX: For some reason EXISTS doesn't work
                                'meta_value' => 0,
                            ));
                            $values = array();
                            while ( $q->have_posts() ) {
                                $q->the_post();
                                $values[] = get_post_meta( $q->post->ID, 'rem_'.$key, true );
                            }
                            wp_reset_postdata();

                            $range_min = 0;
                            $range_max = 0;
                            $range_step = 1;
                            if (count($values) > 0) {
                                $range_min = min($values);
                                if (count($values) < 10)
                                    $range_max = max($values);
                                else {
                                    // Property prices distributions have long tails, see
                                    // https://google.com/search?q=property+prices+distribution&tbm=isch
                                    // Thus, when "many" values, skip some outliers
                                    // on the high end. They will be covered when
                                    // searching for e.g. "property_price=10000+"
                                    sort($values);
                                    $range_max = $values[intval(count($values)*.8) - 1];
                                }
                                // Generic step, rounded to 5s and 10s of all powers of 10,
                                // reasonable for natural-numbered ranges
                                $n = floor(($range_max - $range_min) / 20);
                                $range_step = max(1, min(10000,
                                    round($n / pow(10, strlen($n) - 1)) *
                                               pow(10, strlen($n) - 1)));

                                // Round min down according to step. E.g. if
                                // range_min=1000..9000, and step=10000,
                                // then set range_min=0.
                                $range_min = round($range_min - $range_step / 2,
                                                   -pow(10, strlen($range_step) - 1));
                            }
                            $min_max_step = array('min' => $range_min,
                                                  'max' => $range_max,
                                                  'step' => $range_step);
                            wp_cache_set( 'rem-srch-range-'.$key, $min_max_step );
                        }

                        $range_min = $default_min = $min_max_step['min'];
                        $range_max = $default_max = $min_max_step['max'];
                        $range_step = $min_max_step['step'];
                        if (isset($_GET[$key])) {
                            preg_match('/^(?P<lo>\d+)(\+|-(?P<hi>\d+))$/', str_replace(' ', '', $_GET[$key]), $matches);
                            $default_min = isset($matches['lo']) ? $matches['lo'] : 'RANGE[0]';
                            $default_max = isset($matches['hi']) ? $matches['hi'] : 'RANGE[1]';
                        }
                        ?>
                        <script>
                            jQuery(function($){
                                var RANGE = [<?php echo $range_min; ?>, <?php echo $range_max; ?>];
                                var STEP = <?php echo $range_step; ?>;
                                var $input = jQuery('#<?php echo $form_id; ?> #rem-srch-<?php echo $key; ?>');
                                var slider = jQuery('#<?php echo $form_id; ?> #rem-srch-<?php echo $key; ?>-range').slider({
                                    range: true,
                                    min: RANGE[0],
                                    max: RANGE[1],
                                    step: STEP,
                                    values: [<?php echo $default_min; ?>, <?php echo $default_max; ?>],
                                    slide: function (event, ui) {
                                        $input.val(
                                            ui.values[1] > RANGE[1] - STEP ?
                                            (ui.values[0] < RANGE[0] + STEP ? '' /*any*/ : ui.values[ 0 ] + '+') :
                                            ui.values[ 0 ] + ' - ' + ui.values[ 1 ]);
                                    }
                                }).slider('instance');
                                slider.options.slide(null, slider.options);
                                $input.attr('readonly', '');
                            });
                        </script>
                    </div>
            <?php
                } elseif ($field['type'] == 'select') {
            ?>
                    <div class="form-group">
                        <label>
                            <?php echo $label; ?>
                            <select multiple class="form-control custom-select" id="rem-srch-<?php echo $key; ?>" name="<?php echo $key; ?>">
                                <option value="">-- <?php _e( 'Any', 'real-estate-manager' ); ?> --</option>
                                <?php
                                    $options = $field['options'];
                                    if (!is_array($options))
                                        $options = explode("\n", $options);

                                    foreach ($options as $value) {
                                        $value = stripcslashes($value);
                                        $selected = isset($_GET[$key]) && $_GET[$key] == $value ? ' selected' : '';
                                        echo '<option value="'.$value.'"'.$selected.'>'.__( $value, 'real-estate-manager' ).'</option>';
                                    }
                                ?>
                            </select>
                            <script>jQuery(function(){jQuery("#<?php echo $form_id; ?> #rem-srch-<?php echo $key; ?>").selectmenu();})</script>
                        </label>
                    </div>

            <?php
                } elseif ($field['type'] == 'text') {
            ?>
                    <div class="form-group">
                        <label>
                            <?php echo $label; ?>
                            <input class="form-control" name="<?php echo $field['key']; ?>" value="<?php echo @esc_attr($_GET[$key]); ?>"/>
                        </label>
                    </div>
            <?php
                }
            }

            if (isset($features) && $features == 'on') {
                $property_features = $rem_ob->get_all_property_features();
                $translations = array_map(function($s) { return __($s, 'real-estate-manager'); }, $property_features);
                $property_features = array_combine($translations, $property_features);
            ?>
                <div class="form-group ui-front">
                    <label>
                        <?php echo __('Features', 'real-estate-manager'); ?>
                        <input class="form-control" id="rem-srch-features-tags" name="_features" value="<?php echo @esc_attr($_GET['_features']); ?>"/>
                    </label>
                </div>
<style>
.ich-settings-main-wrap .rem-srch .ui-autocomplete {
    max-height: 20em;
    overflow-y: scroll;
    overflow-x: hidden;
}
</style>
<script>
  jQuery( function() {
    var $ = jQuery;
    var features = <?php echo json_encode($property_features); ?>;
    var availableTags = Object.keys(features);
    availableTags.sort();

    function split(val) { return val.split(/,\s*/); }
    function extractLast( term ) { return split(term).pop(); }

    var visibleTags = $('#<?php echo $form_id; ?> #rem-srch-features-tags')
      .on('keydown', function(event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete('instance').menu.active)
          event.preventDefault();
      })
      .autocomplete({
        minLength: 0,
        source: function(request, response) {
          response($.ui.autocomplete.filter(availableTags, extractLast(request.term)));
        },
        focus: function() {
          return false;
        },
        select: function(event, ui) {
          var terms = split(this.value);
          terms.pop();
          terms.push(ui.item.value);
          terms.push('');
          this.value = terms.join(', ');
          this.selectionStart = this.selectionEnd = this.value.length;
          return false;
        }
      });
    $('#<?php echo $form_id; ?>').submit(function(event){
        split(visibleTags.val())
          .map(function(val){return features[val]})
          .filter(function(val){return !!val})
          .map(function (val) {
            $('<input type="hidden" value="1" name="detail_cbs[' + val + ']"/>')
              .appendTo('#<?php echo $form_id; ?>');
          });
    });
  });
</script>
            <?php
            }

            if (isset($append_html) && $append_html != '')
                echo '<div class="form-group">' . $append_html . '</div>';
            ?>
        <div class="form-group">
            <button type="submit" class="btn btn-default btn-block"><?php _e( 'Search', 'real-estate-manager' ); ?></button>
        </div>
    </form>
</div><!-- /.ich-settings-main-wrap -->
<?php
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        extract($instance);
        global $rem_ob;
        $all_fields = $rem_ob->single_property_fields();
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title','real-estate-manager' ); ?></label>
            <input
                class="widefat"
                id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                type="text" value="<?php echo (isset($instance['title'])) ? $instance['title'] : '' ; ?>"
            >
        </p>
        <p>
            <input
                class="widefat"
                id="<?php echo esc_attr( $this->get_field_id( 'search_field' ) ); ?>"
                name="<?php echo esc_attr( $this->get_field_name( 'search_field' ) ); ?>"
                type="checkbox" value="on" <?php echo (isset($instance['search_field']) && $instance['search_field'] == 'on') ? 'checked' : '' ;  ?>
            >
            <label for="<?php echo esc_attr( $this->get_field_id( 'search_field' ) ); ?>"><?php _e( 'Search Field','real-estate-manager' ); ?></label>
        </p>
        <?php foreach ($all_fields as $field) { ?>
            <p>
                <input
                    class="widefat"
                    id="<?php echo esc_attr( $this->get_field_id( $field['key'] ) ); ?>"
                    name="<?php echo esc_attr( $this->get_field_name( $field['key'] ) ); ?>"
                    type="checkbox" value="on" <?php echo (isset($instance[$field['key']]) && $instance[$field['key']] == 'on') ? 'checked' : '' ;  ?>
                >
                <label for="<?php echo esc_attr( $this->get_field_id( $field['key'] ) ); ?>"><?php echo $field['title']; ?></label>
            </p>
        <?php } ?>
        <p>
            <label>
            <input
                class="widefat"
                name="<?php echo esc_attr( $this->get_field_name('features') ); ?>"
                type="checkbox" value="on" <?php echo (isset($instance['features']) && $instance['features'] == 'on') ? 'checked' : '' ;  ?>
            >
            <?php echo __('Features', 'real-estate-manager'); ?></label>
            </p>
        <p>
            <label><?php echo __('Append HTML', 'real-estate-manager'); ?>
            <textarea name="<?php echo esc_attr( $this->get_field_name( 'append_html' ) ); ?>" class="widefat"><?php echo @$instance['append_html']; ?></textarea>
            </label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'result_page' ) ); ?>"><?php _e( 'Search Results Page','real-estate-manager' ); ?></label>
            <?php
                $args = array(
                    'post_type'   => 'page',
                    'posts_per_page'         => -1,
                );
                $the_query_pages = new WP_Query( $args );

                // The Loop
                if ( $the_query_pages->have_posts() ) {
                    echo '<select class="widefat" id="'.esc_attr( $this->get_field_id( 'result_page' ) ).'" name="'.esc_attr( $this->get_field_name( 'result_page' ) ).'">';
                    while ( $the_query_pages->have_posts() ) {
                        $the_query_pages->the_post();
                        ?>
                            <option value="<?php the_id(); ?>" <?php echo (isset($instance['result_page']) && $instance['result_page'] == get_the_id()) ? 'selected' : '' ; ?>><?php the_title(); ?></option>
                        <?php
                    }
                    echo '</select>';
                    /* Restore original Post Data */
                    wp_reset_postdata();
                } else {
                    echo __( 'No Pages Found!', 'real-estate-manager' );
                }
            ?>
            <span><?php _e( 'Paste following shortcode in selected page to display results', 'real-estate-manager' ); ?>
            <code>[rem_search_results]</code></span>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {

        return $new_instance;
    }

}

if (! function_exists ( 'rem_register_widget_search_property2' )) :
    function rem_register_widget_search_property2() {
        register_widget( 'REM_Search_Property_Widget2' );
    }
endif;
add_action( 'widgets_init', 'rem_register_widget_search_property2' );
?>