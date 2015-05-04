<article id="post-<?php the_ID(); ?>" class="aside clearfix" <?php post_class('aside'); ?>>
							
		<div class="col-xs-1 col-sm-1">
		
			<div class="date-field">
			
				<p><?php the_time('M'); ?></p>
				<p><?php the_time('d'); ?></p>
			</div> <!-- end date-field -->
			
			<div class="date-field">
			
				<i class="fa fa-file-text-o"></i>
			</div> <!-- end date-field -->
		</div>	

		<div class="post-single col-xs-11 col-sm-11">			
			
			<ul class="content-detail">
			
				<li class="uppercase-class"><?php _e('POSTED BY','vision'); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php the_author(); ?></a> <?php _e('IN','vision'); ?> <span><?php the_category(' | '); ?></span></li>

				<?php edit_post_link(__('Edit','vision'),'<li class="edit-class">', '</li>' ); ?>

				<?php if(comments_open()) { ?>
				<li class="comment-span"><?php comments_number(__('No Comments', 'vision'),__('1 Comment', 'vision'),__('% Comments', 'vision')); ?></li>
				<?php } ?>

			</ul>

			<p class="article-p"><?php the_content(); ?></p>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'vision' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
			

	</div> <!-- end post-single -->

</article>



