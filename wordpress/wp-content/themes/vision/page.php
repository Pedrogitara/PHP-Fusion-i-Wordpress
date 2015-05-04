<?php get_header(); ?>

<section class="section-content-area">
		
		<div class="container">
			
			<div class="row">
				
				<div class="col-sm-9">
					
					<div class="posts-area">						

						<?php while(have_posts()):the_post(); ?>

							<article class="clearfix vision-page">
								
								<div class="post-single col-xs-11 col-sm-11">									
									
									<h1 class="uppercase-class"><?php the_title(); ?></h1>

									<ul class="content-detail">
			
										<?php edit_post_link(__('Edit','vision'),'<li class="edit-class" style="margin-left:.1em;">', '</li>' ); ?>

										<?php if(comments_open()) { ?>
										<li class="comment-span"><?php comments_number(__('No Comments', 'vision'),__('1 Comment', 'vision'),__('% Comments', 'vision')); ?></li>
										<?php } ?>

									</ul>
									<br>
									<p class="article-p "><?php the_content(); ?></p>
									
								</div> <!-- end post-single -->

								<div class="tag-div col-xs-10">
									<?php echo get_the_tag_list('Tags : ',' | ', ''); ?>
								</div> <!-- end tag-div -->

							</article>

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