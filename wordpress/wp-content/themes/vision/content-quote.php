<article id="post-<?php the_ID(); ?>" class="quote clearfix" <?php post_class('quote'); ?>>
	
	<div class="col-xs-1 col-sm-1">								
										
		<div class="date-field">
		
			<i class="fa fa-quote-left"></i>

		</div> <!-- end date-field -->

	</div>
								
	<div class="post-single col-xs-11 col-sm-11">	

		<blockquote>
			<?php the_content(); ?>
		</blockquote>	
								
	</div> <!-- end post-single -->

</article>