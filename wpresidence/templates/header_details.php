<?php
$social_facebook    =  esc_html( get_option('wp_estate_facebook_link','') );
$social_tweet       =  esc_html( get_option('wp_estate_twitter_link','') );
$social_google      =  esc_html( get_option('wp_estate_google_link','') );
$linkedin_link      =  esc_html ( get_option('wp_estate_linkedin_link','') );
$pinterest_link     =  esc_html ( get_option('wp_estate_pinterest_link','') );
<<<<<<< HEAD
    
=======
$instagram_link     =   esc_html ( get_option('wp_estate_instagram_link','') );  
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
?>

<div class="header_social">

<?php
if($social_facebook!=''){
    print '<a href="'.$social_facebook.'" class="social_facebook" target="_blank"></a>';
}

if($social_tweet!=''){
    print '<a href="'.$social_tweet.'" class="social_tweet" target="_blank"></a>';
}

if($social_google!=''){
    print '<a href="'.$social_google.'" class="social_google" target="_blank"></a>';
}

if($linkedin_link!=''){
    print '<a href="'.$linkedin_link.'" class="social_linkedin" target="_blank"></a>';
}

if($pinterest_link!=''){
    print '<a href="'.$pinterest_link.'" class="social_pinterest" target="_blank"></a>';
}

<<<<<<< HEAD
=======
if($instagram_link!=''){
    print '<a href="'.$instagram_link.'" class="social_instagram" target="_blank"></a>';
}
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
?>
</div>    