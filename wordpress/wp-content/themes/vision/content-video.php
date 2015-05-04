<article id="post-<?php the_ID(); ?>" class="video clearfix" <?php post_class('video'); ?>>
	
	<div class="col-xs-1 col-sm-1">
		
		<div class="date-field">
		
			<p><?php the_time('M'); ?></p>
			<p><?php the_time('d'); ?></p>
			
		</div> <!-- end date-field -->
		
		<div class="date-field">	

			<i class="fa fa-video-camera"></i>

		</div> <!-- end date-field -->

	</div>
	
	<div class="post-single col-xs-11 col-sm-11">
		
		<h1 class="uppercase-class"><?php the_title(); ?></h1>		
		
		<p class="article-p"><?php the_content(); ?></p>
		
	</div> <!-- end post-single -->

</article>