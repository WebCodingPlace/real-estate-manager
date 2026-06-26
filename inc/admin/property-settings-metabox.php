<div class="rem-settings-box ich-settings-main-wrap">
	<div class="row">
		<div class="col-sm-3">
			<div class="list-group rem-field-sections">
				<?php
					$tabsData = rem_get_single_property_settings_tabs();
					global $post;
					$inputFields = $this->get_all_property_fields();
			        $valid_tabs = array();
			        foreach ($tabsData as $tabData) {
			        	$tab_key = $tabData['key'];
			            foreach ($inputFields as $field) {
			                if ($tab_key == $field['tab'] && !in_array($field['tab'], $valid_tabs)) {
			                   $valid_tabs[] = $field['tab']; 
			                }
			            }
			        }			
					foreach ($tabsData as $tabData) {
						$name = $tabData['key'];
						$title = $tabData['title'];
						if(in_array($name, $valid_tabs) && rem_is_tab_accessible($tabData, $post->ID)){
							echo '<a class="list-group-item" href="#'.$name.'">'.$title.'</a>';
						}
					}
				?>
			</div>
		</div>
		<div class="col-sm-9">
			<div class="tabs-data">
				<?php
					foreach ($tabsData as $tabData) {
						$name = $tabData['key'];
						$title = $tabData['title'];
						if(in_array($name, $valid_tabs) && rem_is_tab_accessible($tabData, $post->ID)){ ?>
						<div id="<?php echo esc_attr($name); ?>" class="tabs-panel panel panel-default">
							<div class="panel-heading">
								<?php echo esc_attr($title); ?>
							</div>
							<div class="panel-body form-horizontal">
								<?php
									do_action( 'rem_before_admin_tab_'.$name );

									foreach ($inputFields as $field) {
										$show_condition = isset($field['show_condition']) ? $field['show_condition'] : 'true' ; 
										$conditions = isset($field['condition']) ? $field['condition'] : array() ;
										
										if($field['tab'] == $name && rem_is_field_accessible($field, $post->ID)){ ?>
						                    <div class="form-group" data-condition_status="<?php echo esc_attr($show_condition); ?>" data-condition_bound="<?php echo isset($field['condition_bound']) ? esc_attr($field['condition_bound']) : 'all' ?>" data-condition='<?php echo json_encode($conditions); ?>'>
						                        <label for="<?php echo esc_attr($field['key']); ?>" class="col-sm-4 control-label">
						                            <?php echo rem_wpml_translate($field['title'], 'real-estate-manager-fields'); ?>
						                            <?php echo (isset($field['required']) && $field['required'] == 'true' ) ? '<span title="'.__( 'Required', 'real-estate-manager' ).'" class="glyphicon glyphicon-asterisk"></span>' : '' ; ?>
						                        </label>
						                        <div class="col-sm-8">
						                            <?php rem_render_field($field); ?>
						                            <p class="help-block"><?php echo rem_wpml_translate($field['help'], 'real-estate-manager-fields'); ?>	</p>
						                        </div>
						                    </div>

										<?php }
									}

									do_action( 'rem_after_admin_tab_'.$name ); ?>
							</div>
						</div>
					<?php }}
				?>	
			</div>
		</div>
	</div>
	
</div>