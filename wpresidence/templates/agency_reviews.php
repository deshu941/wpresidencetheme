<div class="property_reviews_wrapper">
    
    <h3><?php _e('Agency Reviews ','wpestate');?></h3>


    <?php 
    $args = array(
        'number' => '15',
        'post_id' => $post->ID, // use post_id, not post_ID
       
    );


    $comments   =   get_comments($args);
    
    $coments_no =   0;
    $stars_total=   0;
    $review_templates=' ';

    foreach($comments as $comment) :
        if(wp_get_comment_status($comment->comment_ID)!='unapproved'){
        
        $coments_no++;

        $userId         =   $comment->user_id;

        if($userId == 1){
            $reviewer_name="admin";
            $userid_agent   =   get_user_meta($userId, 'user_agent_id', true);
        }else{
            $userid_agent   =   get_user_meta($userId, 'user_agent_id', true);
            $reviewer_name  =   get_the_title($userid_agent); 
            
            if($userid_agent==''){
                $reviewer_name=   $comment->comment_author;
            }

        }


        if($userid_agent==''){
            $user_small_picture_id     =    get_the_author_meta( 'small_custom_picture' ,  $comment->user_id,true  );
            $preview                   =    wp_get_attachment_image_src($user_small_picture_id,'agent_picture_thumb');
            $preview_img               =    $preview[0];
        }else{
            $thumb_id           = get_post_thumbnail_id($userid_agent);
            $preview            = wp_get_attachment_image_src($thumb_id, 'thumbnail');
            $preview_img        = $preview[0];
        }

        if($preview_img==''){
            $preview_img    =   get_template_directory_uri().'/img/default_user_agent.gif';
        }
        $current_user       =   wp_get_current_user();
        $userID             =   $current_user->ID;
     
        $review_title       =   get_comment_meta( $comment->comment_ID, 'review_title',true  );
        $rating= get_comment_meta( $comment->comment_ID , 'review_stars', true );
        $stars_total+=$rating;
        $review_templates.='  
             <div class="listing-review">


                            <div class=" review-list-content norightpadding">
                                <div class="reviewer_image"  style="background-image: url('.$preview_img.');"></div>
                            
                                <div class="reviwer-name">'.esc_html__( 'Posted by ','wpestate' ). ''.$reviewer_name.'</div>
                                <div class="review-title">'.$review_title.'</div>
                                <div class="property_ratings">';

                                    $counter=0; 
                                        while($counter<5){
                                            $counter++;
                                            if( $counter<=$rating ){
                                                $review_templates.=' <i class="fa fa-star"></i>';
                                            }else{
                                               $review_templates.=' <i class="fa fa-star-o"></i>'; 
                                            }

                                        }
                                $review_templates.=' <span class="ratings-star">('. $rating.' ' .esc_html__( 'of','wpestate').' 5)</span> 
                                </div>
                                
                                <div class="review-date">
                                    '.esc_html__( 'Posted on ','wpestate' ). ' '. get_comment_date('j F Y',$comment->comment_ID).' 
                                </div>


                                <div class="review-content">
                                    '. $comment->comment_content .'


                                </div>



                            </div>
                        </div>       ';
        }
    endforeach;
?>




    <?php 
    if($coments_no>0){
        $list_rating= ceil($stars_total/$coments_no);

    ?>
    <div class="property_page_container for_reviews">
        <div class="listing_reviews_wrapper">
                <div class="listing_reviews_container">
                    <h3 id="listing_reviews" class="panel-title">
                            <?php
                            print $coments_no.' ';
                            esc_html_e('Reviews', 'wpestate');
                            ?>
                            <span class="property_ratings">
                                 <?php 
                                $counter=0; 
                                    while($counter<5){
                                        $counter++;
                                        if( $counter<=$list_rating ){
                                            print '<i class="fa fa-star"></i>';
                                        }else{
                                            print '<i class="fa fa-star-o"></i>'; 
                                        }

                                    }
                                ?>
                            </span>
                    </h3>

                    <?php     print $review_templates; ?>   
            </div>
        </div>
    </div>
    <?php } ?>
    
    
        
    <?php   
    if ( is_user_logged_in() ) {   
        $current_user       =   wp_get_current_user();
        $userID             =   $current_user->ID;
        $review_title       =   '';
        $review_stars       =   '';
        $comment_content    =   '';
        $user_posted_coment =   0;
        $args=array(
            'author__in'        => array($userID),
            'post_id'           => $post->ID,
            'comment_approved'  =>1,
            'number'            =>1,
            
        );
    
        $comments = get_comments( $args );
        
        foreach($comments as $comment) :
            $user_posted_coment =   $comment->comment_ID;
            $review_title       =   get_comment_meta( $comment->comment_ID, 'review_title',true  );
	 
            $review_stars       =   get_comment_meta( $comment->comment_ID, 'review_stars',true  );
            $comment_content    =   get_comment_text( $comment->comment_ID );
        endforeach;
       
        ?>
        <h5><?php    
            if( $user_posted_coment!=0 ){
                print '<div class="review_tag">'.__('Update Review ','wpestate');
                if(wp_get_comment_status($user_posted_coment)=='unapproved'){
                   print ' - '. __('pending approval','wpestate');
                }
                print '</div>';                
            }else{
                print '<div class="review_tag">'.__('Write a Review ','wpestate').'</div>';
            }
            ?>
        </h5>
        <div class="add_review_wrapper">
            
            <div class="rating">
                <span class="rating_legend"><?php _e( 'Your Rating & Review','wpestate');?></span>
                
                <?php 
                
                $i=1;
                $j=1;
                while ($i<=5):
                    echo '<span class="empty_star';
                        if( $j<=$review_stars){
                            echo ' starselected starselected_click';
                        }
                    echo' "></span>';
                    $i++;
                    $j++;
                endwhile;
                ?>
               
            </div>
            
            <input type="text" id="wpestate_review_title" name="wpestate_review_title" value="<?php echo $review_title;?>" class="form-control" placeholder="<?php _e('Review Title','wpestate');?>">
            <textarea rows="8" id="wpestare_review_content" name="wpestare_review_content" class="form-control" placeholder="<?php  _e('Your Review','wpestate'); ?>"><?php 
                if( $user_posted_coment!=0  ){
                    echo $comment_content;
                } 
                ?></textarea>
            <?php 
           

          
               
            if( $user_posted_coment!=0){ ?>
                <input type="submit" class="wpresidence_button col-md-3" id="edit_review" data-coment_id="<?php echo $user_posted_coment;?>" data-listing_id="<?php echo $post->ID;?>" value="<?php _e('Edit Review','wpestate');?>">
            <?php
            }else{?>
                <input type="submit" class="wpresidence_button col-md-3" id="submit_review" data-listing_id="<?php echo $post->ID;?>" value="<?php _e('Submit Review','wpestate');?>">
            <?php   
                }
            ?>
        </div>
    <?php
    }else{ 
    ?>
        <h5 class="review_notice"><?php _e('You need to ','wpestate');echo '<span id="login_trigger_modal">'.__('login','wpestate').'</span> ';_e('in order to post a review ','wpestate');?></h5>
    <?php
    }
    ?>

</div>