<article id="post-<?php the_ID(); ?>" class="link clearfix" <?php post_class('link'); ?>>
		
		<div class="col-xs-1 col-sm-1">			
											
			<div class="date-field">
			
				<i class="fa fa-link"></i>
			</div> <!-- end date-field -->
		</div>							
		<div class="post-single col-xs-11 col-sm-11">								
									
			<?php the_content(); ?>			
			
		</div> <!-- end post-single -->
</article>