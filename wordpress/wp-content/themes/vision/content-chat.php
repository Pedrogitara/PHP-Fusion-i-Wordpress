<article id="post-<?php the_ID(); ?>" class="chat clearfix" <?php post_class('chat'); ?>>
	
	<div class="col-xs-1 col-sm-1">
		
		<div class="date-field">
		
			<p><?php the_time('M'); ?></p>
			<p><?php the_time('d'); ?></p>
		</div> <!-- end date-field -->
		
		<div class="date-field">
		
			<i class="fa fa-comments"></i>
		</div> <!-- end date-field -->
	</div>
	
	<div class="post-single col-xs-11 col-sm-11">
		
		<ul class="content-detail">
			
			<li class="uppercase-class"><?php _e('POSTED BY','vision'); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php the_author(); ?></a> <?php _e('IN','vision'); ?> <span><?php the_category(' | '); ?></span></li>

			<?php edit_post_link(__('Edit','vision'),'<li class="edit-class">', '</li>' ); ?>

		</ul>
			
			<div class="chat-content clearfix">
				<?php the_content(); ?>	
			</div>
				
		
	</div> <!-- end post-single -->
</article>