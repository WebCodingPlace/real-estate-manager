<div class="wrap ich-settings-main-wrap">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="col-sm-2">
				<img src="<?php echo REM_URL.'/assets/images/rem-icon.png'; ?>" alt="REM" class="img-responsive">
			</div>
			<div class="col-sm-10">
				<h1>Real Estate Manager <span class="badge bg-primary">v<?php echo REM_VERSION; ?></span></h1>
				<p class="text-info lead">
					Thank you for trying <b>Real Estate Manager</b>.
					We would love to hear your positive feedback <a target="_blank" href="https://wordpress.org/plugins/real-estate-manager/#reviews"><strong>here</strong></a> or if you have any issues beyond the scope of our documentation, just open a ticket <a target="_blank" href="https://wordpress.org/support/plugin/real-estate-manager/"><strong>following this URL</strong></a>.
				</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Create Essential Pages</h3>
				</div>
				<div class="panel-body">
					<p>
						Click on the following button if you want to create these pages automatically.
					</p>
					<ol>
						<li>All Listings Page</li>
						<li>Search Properties Page</li>
						<li>Create Property Page</li>
						<li>Agent Registration Page</li>
						<li>Agent Login Page</li>
						<li>Edit Profile Page</li>
						<li>Edit Property Page</li>
						<li>My Properties Page</li>
					</ol>
					<?php if(get_option( 'rem_basic_pages_created' )){ ?>
						<div class="alert alert-warning">You have already created these pages. It may add duplicate entries.</div>
					<?php } ?>
					<hr>
					<a href="#" class="btn btn-info rem-create-pages"> <span class="glyphicon glyphicon-refresh"></span> Create Pages</a>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Getting Started</h3>
				</div>
				<div class="panel-body">
					<div class="list-group">
						<a href="<?php echo admin_url('edit.php?post_type=rem_property&page=rem_settings'); ?>" class="list-group-item">
							<span class="glyphicon glyphicon-cog"></span> 
							Basic Settings
						</a>

						<a href="https://wp-rem.com/online-documentation/category/shortcodes/" target="_blank" class="list-group-item">
							<span class="glyphicon glyphicon-console"></span> 
							Shortcodes
						</a>

						<a href="https://wp-rem.com/online-documentation/" target="_blank" class="list-group-item">
							<span class="glyphicon glyphicon-book"></span> 
							Documentation
						</a>

						<a href="https://wp-rem.com/online-documentation/category/faqs/" target="_blank" class="list-group-item">
							<span class="glyphicon glyphicon-question-sign"></span> 
							FAQs
						</a>

						<a href="https://www.youtube.com/playlist?list=PLAyqGZN06NDryROa1PRrooHxpjOT1MRJV" target="_blank" class="list-group-item">
							<span class="glyphicon glyphicon-facetime-video"></span> 
							Video Tutorials
						</a>

						<a href="https://wordpress.org/plugins/real-estate-manager/#developers" target="_blank" class="list-group-item">
							<span class="glyphicon glyphicon-flag"></span> 
							Changelog
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>