<?php if(is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')){ ?>

	<section class="section-main-footer">
		
		<div class="container">
			
			<div class="row">
				
				<div class="col-sm-4">

					<?php if(dynamic_sidebar('footer-1')); ?>																							
					
				</div> <!-- end col-sm-4 -->


				<div class="col-sm-4">

					<?php if(dynamic_sidebar('footer-2')); ?>					
					
				</div> <!-- end col-sm-4 -->


				<div class="col-sm-4">

					<?php if(dynamic_sidebar('footer-3')); ?>					
					
				</div> <!-- end col-sm-4 -->

			</div> <!-- end row -->

		</div> <!-- end container -->

	</section> <!-- end section-main-footer -->

<?php } ?>