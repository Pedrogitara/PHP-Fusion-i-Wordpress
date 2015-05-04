<?php get_header(); ?>

<section class="section-content-area">
		
		<div class="container">
			
			<div class="row">
				
				<div class="col-sm-9">					

						<div class="error-page">						

							<h1><i class="fa fa-chain-broken"></i>&nbsp;404</h1>

							<p><?php _e('Page not found. You can search below', 'vision'); ?></p>

							<?php get_search_form(); ?>	

						</div> <!-- end error-page -->



				</div> <!-- end col-sm-9 -->
	
				<div class="col-sm-3">
	
					<div class="sidebar">
						
						<?php get_sidebar(); ?>
			
					</div> <!-- end sidebar -->

				</div> <!-- end col-sm-3 -->

			</div> <!-- end row -->

		</div> <!-- end container -->

	</section> <!-- end section-content-area -->

<?php get_template_part('footer', 'main'); ?>

<?php get_footer(); ?>

