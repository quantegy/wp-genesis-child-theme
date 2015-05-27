<?php

add_action( 'genesis_before_entry_content', 'featured_post_image', 8 );
function featured_post_image() {
    //the_post_thumbnail();

    $thumbID = get_post_thumbnail_id();
    $thumbURL = wp_get_attachment_image_src($thumbID, 'post-thumbnail');
    $imgSize = getimagesize($thumbURL[0]);
    $width = $imgSize[0];
    $height = $imgSize[1];
    /*
    if($height/$width < 1){
        echo "<img class='uci-post-image-landscape' src='".$thumbURL[0]."' />";
    }
    else {
        echo "<img class='uci-post-image-portrait' src='" . $thumbURL[0] . "' />";
    }
    */
    if ( is_singular() ): ?>
        <?php if ($height/$width < 1): ?>
            <div class="uci-post-image-landscape">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php else: ?>
            <div class="uci-post-image-portrait">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <?php if ($height/$width < 1): ?>
            <div class="uci-post-image-landscape">
                <a href="<?php the_permalink(); ?>" aria-hidden="true">
                    <?php
                    the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
                    ?>
                </a>
            </div>
        <?php else: ?>
            <div class="uci-post-image-portrait">
                <a href="<?php the_permalink(); ?>" aria-hidden="true">
                    <?php
                    the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
                    ?>
                </a>
            </div>
        <?php endif; ?>



    <?php endif; // End is_singular()
}

?>