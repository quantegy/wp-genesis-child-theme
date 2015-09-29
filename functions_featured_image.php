<?php

/**
 * @return bool True is featured image is square or portrait aspect ratio
 */
function ucinews_is_featured_portrait()
{
    $isPortrait = false;
    $thumbID = get_post_thumbnail_id();
    $thumbURL = wp_get_attachment_image_src($thumbID, 'full-size-image');
    $width = $thumbURL[1];
    $height = $thumbURL[2];
    if ($height / $width >= 1) {
        $isPortrait = true;
    }
    return $isPortrait;
}

/**
 * Add Featured Image support with landscape images
 * spanning content area and portrait images floating
 * right with the content wrapping around
 */
add_action( 'genesis_before_entry_content', 'featured_post_image', 8 );
function featured_post_image() {
    if(has_post_thumbnail()):
        if ( is_singular() ): ?>
            <?php if (ucinews_is_featured_portrait()): ?>
                <div class="uci-post-image-portrait">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php else: ?>
                <div class="uci-post-image-landscape">
                <?php the_post_thumbnail(); ?>
                </div>
            <?php endif; ?>

        <?php else : ?>
            <?php if (ucinews_is_featured_portrait()): ?>
                <div class="uci-post-image-portrait">
                    <a href="<?php the_permalink(); ?>" aria-hidden="true">
                        <?php
                        the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
                        ?>
                    </a>
                </div>
            <?php else: ?>
                <div class="uci-post-image-landscape">
                    <a href="<?php the_permalink(); ?>" aria-hidden="true">
                        <?php
                        the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
                        ?>
                    </a>
                </div>
            <?php endif;
        endif;
    endif;
}
?>