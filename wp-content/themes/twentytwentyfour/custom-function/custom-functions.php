<?php 

function addweb_solution_enqueue_car_scripts() {

	wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/assets/css/custom-style.css' );

    wp_enqueue_script( 'car-entry-ajax', get_template_directory_uri() . '/assets/js/car-entry.js', array( 'jquery' ), '', true );

    wp_localize_script( 'car-entry-ajax', 'car_entry', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'car_entry_nonce' ),
    ));
}
add_action( 'wp_enqueue_scripts', 'addweb_solution_enqueue_car_scripts' );

function addweb_solution_register_car_post_type() {
    $labels = array(
        'name'               => _x('Cars','post type general name'),
        'singular_name'      => _x('Car','post type singular name'),
        'menu_name'          => _x('Cars','admin menu'),
        'name_admin_bar'     => _x('Car','add new on admin bar'),
        'add_new'            => _x('Add New','car'),
        'add_new_item'       => __('Add New Car'),
        'new_item'           => __('New Car'),
        'edit_item'          => __('Edit Car'),
        'view_item'          => __('View Car'),
        'all_items'          => __('All Cars'),
        'search_items'       => __('Search Cars'),
        'parent_item_colon'  => __('Parent Cars:'),
        'not_found'          => __('No cars found.'),
        'not_found_in_trash' => __('No cars found in Trash.' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'car'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title','editor', 'thumbnail' ),
    );

    register_post_type( 'car', $args );
}

function addweb_solution_register_car_taxonomies() {
  
    register_taxonomy(
        'make',
        'car',
        array(
            'label' => __( 'Make' ),
            'rewrite' => array( 'slug' => 'make' ),
            'hierarchical' => true,
        )
    );

    register_taxonomy(
        'model',
        'car',
        array(
            'label' => __( 'Model' ),
            'rewrite' => array( 'slug' => 'model' ),
            'hierarchical' => true,
        )
    );

    register_taxonomy(
        'year',
        'car',
        array(
            'label' => __( 'Year' ),
            'rewrite' => array( 'slug' => 'year' ),
            'hierarchical' => false,
        )
    );

    register_taxonomy(
        'fuel_type',
        'car',
        array(
            'label' => __( 'Fuel Type' ),
            'rewrite' => array( 'slug' => 'fuel-type' ),
            'hierarchical' => false,
        )
    );
}
add_action( 'init', 'addweb_solution_register_car_post_type' );
add_action( 'init', 'addweb_solution_register_car_taxonomies' );


function addweb_solution_car_entry_form() {
    $makes = get_terms( array( 'taxonomy' => 'make', 'hide_empty' => false ) );
    $models = get_terms( array( 'taxonomy' => 'model', 'hide_empty' => false ) );
    $years = get_terms( array( 'taxonomy' => 'year', 'hide_empty' => false ) );
    $fuel_types = get_terms( array( 'taxonomy' => 'fuel_type', 'hide_empty' => false ) );

    ob_start(); ?>
    <form id="car-entry-form" enctype="multipart/form-data">
    	<div class="form-group">
	        <label for="car_name">Car Name</label>
	        <input type="text" id="car_name" name="car_name" required />
    	</div>

	    <div class="form-group">
	        <label for="make">Make</label>
	        <select id="make" name="make" required>
	            <option value="">Select Make</option>
	            <?php foreach ( $makes as $make ) : ?>
	                <option value="<?php echo $make->term_id; ?>"><?php echo $make->name; ?></option>
	            <?php endforeach; ?>
	        </select>
	    </div>

	    <div class="form-group">
	        <label for="model">Model</label>
	        <select id="model" name="model" required>
	            <option value="">Select Model</option>
	            <?php foreach ( $models as $model ) : ?>
	                <option value="<?php echo $model->term_id; ?>"><?php echo $model->name; ?></option>
	            <?php endforeach; ?>
	        </select>
	    </div>
	     <div class="form-group">
            <label for="year">Year</label>
            <select id="year" name="year" required>
                <option value="">Select Year</option>
                <?php foreach ( $years as $year ) : ?>
                    <option value="<?php echo $year->term_id; ?>"><?php echo $year->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

	    <div class="form-group fueltype">
	        <label for="fuel_type">Fuel Type</label>
	        <div class="radio-group">
	            <?php foreach ( $fuel_types as $fuel_type ) : ?>
	                <input type="radio" name="fuel_type" value="<?php echo $fuel_type->term_id; ?>" required /> 
	                <label><?php echo $fuel_type->name; ?></label>
	            <?php endforeach; ?>
	        </div>
	    </div>

	    <div class="form-group">
	        <label for="car_image">Upload Image</label>
	        <input type="file" id="car_image" name="car_image" accept="image/*" required />
	    </div>

	    <div class="form-group">
	        <button type="submit">Submit</button>
	    </div>

	    <div id="form-response"></div>
</form>

    <?php
    return ob_get_clean();
}
add_shortcode( 'car_entry', 'addweb_solution_car_entry_form' );

function addweb_solution_car_entry_form_submission() {
    check_ajax_referer('car_entry_nonce', 'nonce');
    $car_name = sanitize_text_field($_POST['car_name']);
    $make = intval($_POST['make']);
    $model = intval($_POST['model']);
    $year = intval($_POST['year']);
    $fuel_type = intval($_POST['fuel_type']);

    $new_car = array(
        'post_title'  => $car_name,
        'post_status' => 'publish',
        'post_type'   => 'car',
    );
    $post_id = wp_insert_post($new_car);

    if (!is_wp_error($post_id)) {
        
        wp_set_object_terms($post_id, $make, 'make');
        wp_set_object_terms($post_id, $model, 'model');
        wp_set_object_terms($post_id, $year, 'year');
        wp_set_object_terms($post_id, $fuel_type, 'fuel_type');

   
        if (isset($_FILES['car_image'])) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');

            $attachment_id = media_handle_upload('car_image', $post_id);
            if (is_wp_error($attachment_id)) {
                echo json_encode(array('error' => 'Image upload failed'));
                wp_die();
            } else {
                set_post_thumbnail($post_id, $attachment_id);
            }
        }


        echo json_encode(array('success' => 'Car added successfully'));
    } else {
        
        echo json_encode(array('error' => 'Failed to add car'));
    }

    wp_die();
}
add_action('wp_ajax_addweb_solution_car_entry_form_submission', 'addweb_solution_car_entry_form_submission');
add_action('wp_ajax_nopriv_addweb_solution_car_entry_form_submission', 'addweb_solution_car_entry_form_submission');
function addweb_solution_car_list_shortcode() {
    $args = array(
        'post_type' => 'car',
        'posts_per_page' => -1,
    );

    $cars = new WP_Query( $args );

    if ( $cars->have_posts() ) {
        ob_start();

        echo '<div class="car-list-grid">';
        while ( $cars->have_posts() ) {
            $cars->the_post();
            $make_terms = get_the_terms( get_the_ID(), 'make' );
            $model_terms = get_the_terms( get_the_ID(), 'model' );
            $year_terms = get_the_terms( get_the_ID(), 'year' );
            $fuel_type_terms = get_the_terms( get_the_ID(), 'fuel_type' );

            $make_list = '';
            if ( is_array( $make_terms ) ) {
                foreach ( $make_terms as $term ) {
                    $make_list .= $term->name . ', ';
                }
                $make_list = rtrim( $make_list, ', ' );
            }

            $model_list = '';
            if ( is_array( $model_terms ) ) {
                foreach ( $model_terms as $term ) {
                    $model_list .= $term->name . ', ';
                }
                $model_list = rtrim( $model_list, ', ' );
            }

            $year_list = '';
            if ( is_array( $year_terms ) ) {
                foreach ( $year_terms as $term ) {
                    $year_list .= $term->name . ', ';
                }
                $year_list = rtrim( $year_list, ', ' );
            }

            $fuel_type_list = '';
            if ( is_array( $fuel_type_terms ) ) {
                foreach ( $fuel_type_terms as $term ) {
                    $fuel_type_list .= $term->name . ', ';
                }
                $fuel_type_list = rtrim( $fuel_type_list, ', ' );
            }

            ?>
            <div class="car-list-item">
                <h2><?php the_title(); ?></h2>
                <?php if ( has_post_thumbnail() ) {
                    the_post_thumbnail( 'medium' );
                } ?>
                <?php if ( $make_list ) : ?>
                    <p><strong>Make:</strong> <?php echo $make_list; ?></p>
                <?php endif; ?>
                <?php if ( $model_list ) : ?>
                    <p><strong>Model:</strong> <?php echo $model_list; ?></p>
                <?php endif; ?>
                <?php if ( $year_list ) : ?>
                    <p><strong>Year:</strong> <?php echo $year_list; ?></p>
                <?php endif; ?>
                <?php if ( $fuel_type_list ) : ?>
                    <p><strong>Fuel Type:</strong> <?php echo $fuel_type_list; ?></p>
                <?php endif; ?>
            </div>
            <?php
        }
        echo '</div>';

        wp_reset_postdata();

        return ob_get_clean();
    } else {
        return '<p>No cars found.</p>';
    }
}
add_shortcode( 'car-list', 'addweb_solution_car_list_shortcode' );


