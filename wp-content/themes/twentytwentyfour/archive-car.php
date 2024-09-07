<?php get_header(); ?>

<div class="container">
    <h1>All Cars</h1>
    <?php if ( have_posts() ) : ?>
        <div class="car-list-grid">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="car-list-item">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'medium' );
                    } ?>
                    <p><strong>Make:</strong> <?php echo get_the_term_list( get_the_ID(), 'make', '', ', ' ); ?></p>
                    <p><strong>Model:</strong> <?php echo get_the_term_list( get_the_ID(), 'model', '', ', ' ); ?></p>
                    <p><strong>Year:</strong> <?php echo get_the_term_list( get_the_ID(), 'year', '', ', ' ); ?></p>
                    <p><strong>Fuel Type:</strong> <?php echo get_the_term_list( get_the_ID(), 'fuel_type', '', ', ' ); ?></p>
                </div>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination(); ?>

    <?php else : ?>
        <p>No cars found.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
