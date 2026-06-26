<?php 
	$field_sections = rem_get_single_property_settings_tabs();

	$accessibilities = array(
		'public'		=> __('Public', 'real-estate-manager' ),
		'agent'			=> __('Agent', 'real-estate-manager' ),
		'registered'	=> __('Registered Users', 'real-estate-manager' ),
		'admin'			=> __('Administrator', 'real-estate-manager' ),
		'disable'		=> __('Disable', 'real-estate-manager' ),
	);
?>

<div class="wrap ich-settings-main-wrap">
	<h2><?php esc_attr_e( 'Property Field Sections', 'real-estate-manager' ); ?></h2>
        <div class="alert alert-danger">
            <span class="glyphicon glyphicon-info-sign"></span>
            <?php esc_attr_e( 'This feature is available in the pro version.', 'real-estate-manager' ); ?>
			<a href="http://1.envato.market/01W74" target="_blank" class="btn btn-success btn-sm">
				Explore Pro Features
			</a>			
        </div>
    	<div class="row">
    	<div class="col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
	                <h3 class="panel-title"><?php esc_attr_e( 'Create Section', 'real-estate-manager' ); ?></h3>
                </div>
                <div class="panel-body">
                	<p class="text-center"><?php esc_attr_e( 'Here you can create, delete or sort the sections for the property fields.', 'real-estate-manager' ); ?></p>
                	<p class="text-center">
                		<button class="button btn-info rem-create-field-section"><?php esc_attr_e( 'Create New', 'real-estate-manager' ); ?></button>
                	</p>
                </div>
            </div>   
            <div class="row">
            	<div class="col-sm-6">
					<button class="button btn-danger btn-block rem-reset-field-section"><?php esc_attr_e( 'Reset Sections', 'real-estate-manager' ); ?></button>
            	</div>
            	<div class="col-sm-6">
					<button class="button btn-success btn-block rem-save-field-section"><?php esc_attr_e( 'Save Sections', 'real-estate-manager' ); ?></button>
            	</div>
            </div> 		
    	</div>
        <div class="col-sm-9">
            <div class="panel panel-primary">
                <div class="panel-heading">
	                <h3 class="panel-title">
	                	<?php esc_attr_e( 'Property Field Sections', 'real-estate-manager' ); ?>
	                </h3>
                </div>
                <div class="panel-body" id="field-sections-panel">
		                <?php foreach ($field_sections as $index => $tab) { ?>
						<div class="panel panel-default">
						    <div class="panel-heading">
						        <b><?php echo esc_attr($tab['title']); ?>  - </b>  <span class="key"> <?php echo esc_attr($tab['key']); ?> </span>
						        <span class="pull-right btn btn-xs btn-default trigger-sort">
						            <span class="glyphicon glyphicon-move"></span>
						        </span>
						        <a href="#" class="btn btn-xs btn-default pull-right trigger-toggle">
						            <span class="glyphicon glyphicon-menu-down"></span>
						        </a>
						        <a href="#" class="pull-right btn btn-xs btn-danger remove-field">
						            <span class="glyphicon glyphicon-remove-sign"></span>
						        </a>
						    </div>
						    <div class="panel-body inside-contents form-horizontal">
						        <div class="form-group">
								    <label class="col-sm-4 control-label"><?php esc_attr_e( 'Section Title', 'real-estate-manager' ); ?></label>
								    <div class="col-sm-8">
								        <input type="text" class="form-control input-sm section_title" value="<?php echo esc_attr($tab['title']); ?>">
								    </div>
								</div>
								<div class="form-group">
								    <label class="col-sm-4 control-label"><?php esc_attr_e( 'Data Name (lowercase without spaces)', 'real-estate-manager' ); ?></label>
								    <div class="col-sm-8">
								        <input type="text" class="form-control input-sm section_key" value="<?php echo esc_attr($tab['key']); ?>">
								    </div>
								</div>
								<div class="form-group">
								    <label class="col-sm-4 control-label"><?php esc_attr_e( 'Icon Class or Image URL', 'real-estate-manager' ); ?></label>
								    <div class="col-sm-8">
								        <input type="text" class="form-control input-sm section_icon" value="<?php echo esc_attr($tab['icon']); ?>">
								    </div>
								</div>
								<div class="form-group">
								    <label class="col-sm-4 control-label"><?php esc_attr_e( 'Accessibility', 'real-estate-manager' ); ?></label>
								    <div class="col-sm-8">
								        <select class="form-control input-sm section_accessibility">
								        	<?php foreach ($accessibilities as $key => $value) { ?>
												<option value="<?php echo esc_attr($key); ?>" <?php echo selected( $tab['accessibility'], $key, 'selected' ); ?>><?php echo esc_attr($value); ?></option>
								        	<?php } ?>
										</select>
								    </div>
								</div>
						    </div>
						</div>
		                <?php } ?>
                </div>
            </div>
			
        </div>
    </div>
</div>