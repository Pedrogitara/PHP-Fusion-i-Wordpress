<?php if(function_exists('register_field_group')){ ?>
<section class="section-slider">
		
    
		<div class="flexslider">
          <ul class="slides">           

            <?php $slider=get_posts(array(
              'numberposts' => -1,
              'post_type' => 'post',
              'meta_key' => 'featured_slider'
             )); ?>


            <?php foreach($slider as $slide){ ?>

             <?php if(function_exists('get_field')){
               $click=get_field('featured_slider',$slide->ID);
             } ?>

           
            <?php if($click){ ?>              
            
             <li>   

             <?php $image=get_field('slider_image',$slide->ID); ?>

             <img src="<?php echo $image['url']; ?>" />                   
                
              <h2><a href="<?php echo get_the_permalink($slide->ID); ?>"><?php echo get_the_title($slide->ID); ?></a></h2>

             </li>           

            <?php } 

            }?>
 		
          

          
          </ul>
        </div>
      

</section> <!-- end section-slider -->
<?php } ?>