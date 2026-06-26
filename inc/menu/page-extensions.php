<?php
$plugins_data = array(
	array(
		'title' => 'REM - XML, CSV Importer',
		'class_name' => 'RapidAddon',
		'button_url' => 'https://wp-rem.com/addons/rem-xml-csv-importer/',
	),
	array(
		'title' => 'REM - Conditional Fields',
		'class_name' => 'REM_CONDITIONAL_FIELDS',
		'button_url' => 'https://wp-rem.com/addons/rem-conditional-fields/',
	),
	array(
		'title' => 'REM - Currency Switcher',
		'class_name' => 'REM_Currency_Switcher',
		'button_url' => 'https://wp-rem.com/addons/rem-currency-switcher/',
	),
	array(
		'title' => 'REM - Saved Searches and Notify',
		'class_name' => 'REM_SSE',
		'button_url' => 'https://wp-rem.com/addons/rem-saved-searches-and-notify/',
	),
	array(
		'title' => 'REM - Wishlist',
		'class_name' => 'REM_WISHLIST',
		'button_url' => 'https://wp-rem.com/addons/rem-wish-list/',
	),
	array(
		'title' => 'REM - Export Import',
		'class_name' => 'REM_Export_Import',
		'button_url' => 'https://wp-rem.com/addons/rem-export-and-import/',
	),
	array(
		'title' => 'REM - Property Listing Styles',
		'class_name' => 'REM_Property_Styles',
		'button_url' => 'https://wp-rem.com/addons/rem-property-listing-styles/',
	),
	array(
		'title' => 'REM - Social Share',
		'class_name' => 'REM_Social_Share',
		'button_url' => 'https://wp-rem.com/addons/rem-social-share/',
	),
	array(
		'title' => 'REM - Google Map Filters',
		'class_name' => 'REM_Map_Filters',
		'button_url' => 'https://wp-rem.com/addons/rem-google-map-filters/',
	),
	array(
		'title' => 'REM - Filterable Properties Grid',
		'class_name' => 'REM_Filterable_Grid',
		'button_url' => 'https://wp-rem.com/addons/rem-filterable-grid/',
	),
	array(
		'title' => 'REM - Woo Estato',
		'class_name' => 'REM_WOO_ESTATO',
		'button_url' => 'https://wp-rem.com/addons/rem-woo-estato/',
	),
	array(
		'title' => 'REM - Guest Submission',
		'class_name' => 'RemGuestUserAddon',
		'button_url' => 'https://wp-rem.com/addons/rem-guest-submission/',
	),
);
?>

<div class="wrap ich-settings-main-wrap">
	<div class="row">
		<div class="col-sm-8">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                <h3 class="panel-title">Extend the functionality of Real Estate Manager using these addons</h3>
	            </div>
	            <div class="panel-body">
					<table class="table table-hover">
						<tr>
							<th>Name</th>
							<th>Status</th>
							<th>Details</th>
						</tr>
						<?php foreach ($plugins_data as $key => $plugin_data) { ?>
							<tr>
								<td><?php echo esc_attr($plugin_data['title']); ?></td>
								<td>
									<?php if (class_exists($plugin_data['class_name'])) { ?>
						                <span class="glyphicon glyphicon-ok"></span> Active
									<?php } ?>
								</td>
								<td>
									<a target="_blank" class="btn btn-sm btn-primary" href="<?php echo esc_url($plugin_data['button_url']); ?>">More Details</a>
								</td>
							</tr>
						<?php } ?>
					</table>
	            </div>
	        </div>
		</div>
	</div>
</div>