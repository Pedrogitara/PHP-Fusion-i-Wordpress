<?php get_header(); ?>

<section class="section-content-area">
		
		<div class="container">
			
			<div class="row">
				
				<div class="col-sm-9">
					
					<div class="posts-area">						

						<?php while(have_posts()):the_post(); ?>

							<article class="clearfix">
	
								<div class="col-xs-1 col-sm-1">
									
									<div class="date-field">									
										<p><?php the_time('M'); ?></p>
										<p><?php the_time('d'); ?></p>
									</div> <!-- end date-field -->									
									
								</div>
								
								<div class="post-single col-xs-11 col-sm-11">									
									
									<h1 class="uppercase-class"><?php the_title(); ?></h1>
									
									<ul class="content-detail">
			
										<li class="uppercase-class"><?php _e('POSTED BY','vision'); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php the_author(); ?></a> <?php _e('IN','vision'); ?> <span><?php the_category(' | '); ?></span></li>

										<?php edit_post_link(__('Edit','vision'),'<li class="edit-class">', '</li>' ); ?>

										<?php if(comments_open()) { ?>
										<li class="comment-span"><?php comments_number(__('No Comments', 'vision'),__('1 Comment', 'vision'),__('% Comments', 'vision')); ?></li>
										<?php } ?>

									</ul>
									<br>
									<div class="article-p "><?php the_content(); ?></div>
									
								</div> <!-- end post-single -->

								<div class="tag-div col-xs-10">
									<?php echo get_the_tag_list('Tags : ',' | ', ''); ?>
								</div> <!-- end tag-div -->								

							</article>


								<div class="prev-next-posts">
									
									<div class="previous-post">
										<?php previous_post_link(); ?>
									</div> <!-- end previous-post -->


									<div class="next-post">
										<?php next_post_link(); ?>
									</div> <!-- end next-post -->

								</div> <!-- end prev-next-posts -->

							<?php comments_template(); ?>			

						<?php endwhile; ?>	


					</div> <!-- end posts-area -->

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