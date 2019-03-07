<?php 
/*
 Plugin Name: Aagaz Startup Pro Posttype
 Plugin URI: https://www.themeseye.com/
 Description: Creating new post type for Aagaz Startup Pro Theme.
 Author: Themeseye Themes
 Version: 1.0
 Author URI: https://www.themeseye.com/
*/

define( 'AAGAZ_STARTUP_PRO_POSTTYPE_VERSION', '1.0' );
add_action( 'init', 'createcategory');
add_action( 'init', 'aagaz_startup_pro_posttype_create_post_type' );

function aagaz_startup_pro_posttype_create_post_type() {
  register_post_type( 'portfolio',
    array(
      'labels' => array(
        'name' => __( 'Our Portfolio','aagaz-startup-pro-posttype' ),
        'singular_name' => __( 'Our Portfolio','aagaz-startup-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-portfolio',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );

  register_post_type( 'faq',
    array(
      'labels' => array(
        'name' => __( 'Faq','aagaz-startup-pro-posttype' ),
        'singular_name' => __( 'Faq','aagaz-startup-pro-posttype' )
      ),
      'capability_type' => 'post',
      'menu_icon'  => 'dashicons-editor-help',
      'public' => true,
      'supports' => array(
        'title',
        'editor',
        'thumbnail'
      )
    )
  );

  register_post_type( 'testimonials',
    array(
  		'labels' => array(
  			'name' => __( 'Testimonials','aagaz-startup-pro-posttype' ),
  			'singular_name' => __( 'Testimonials','aagaz-startup-pro-posttype' )
  		),
  		'capability_type' => 'post',
  		'menu_icon'  => 'dashicons-businessman',
  		'public' => true,
  		'supports' => array(
  			'title',
  			'editor',
  			'thumbnail'
  		)
		)
	);

  register_post_type( 'team',
    array(
      'labels' => array(
        'name' => __( 'Our Experts','aagaz-startup-pro-posttype' ),
        'singular_name' => __( 'Our Team','aagaz-startup-pro-posttype' )
      ),
        'capability_type' => 'post',
        'menu_icon'  => 'dashicons-awards',
        'public' => true,
        'supports' => array( 
          'title',
          'editor',
          'thumbnail'
      )
    )
  );
}

/*--------------- Our Portfolio section ----------------*/
function createcategory() {
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name'              => __( 'Portfolio Category', 'aagaz-startup-pro-posttype' ),
    'singular_name'     => __( 'Portfolio Category', 'aagaz-startup-pro-posttype' ),
    'search_items'      => __( 'Search Ccats', 'aagaz-startup-pro-posttype' ),
    'all_items'         => __( 'All Portfolio Category', 'aagaz-startup-pro-posttype' ),
    'parent_item'       => __( 'Parent Portfolio Category', 'aagaz-startup-pro-posttype' ),
    'parent_item_colon' => __( 'Parent Portfolio Category:', 'aagaz-startup-pro-posttype' ),
    'edit_item'         => __( 'Edit Portfolio Category', 'aagaz-startup-pro-posttype' ),
    'update_item'       => __( 'Update Portfolio Category', 'aagaz-startup-pro-posttype' ),
    'add_new_item'      => __( 'Add New Portfolio Category', 'aagaz-startup-pro-posttype' ),
    'new_item_name'     => __( 'New Portfolio Category Name', 'aagaz-startup-pro-posttype' ),
    'menu_name'         => __( 'Portfolio Category', 'aagaz-startup-pro-posttype' ),
  );
  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'createcategory' ),
  );
  register_taxonomy( 'createcategory', array( 'portfolio' ), $args );
}
/* Adds a meta box to the portfolio editing screen */
function aagaz_startup_pro_posttype_bn_work_meta_box() {
  add_meta_box( 'aagaz-startup-pro-posttype-portfolio-meta', __( 'Enter Details', 'aagaz-startup-pro-posttype' ), 'aagaz_startup_pro_posttype_bn_work_meta_callback', 'portfolio', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'aagaz_startup_pro_posttype_bn_work_meta_box');
}
/* Adds a meta box for custom post */
function aagaz_startup_pro_posttype_bn_work_meta_callback( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'te_portfolio_meta_nonce' );
  $bn_stored_meta = get_post_meta( $post->ID );
  //date details
  if(!empty($bn_stored_meta['aagaz_startup_pro_url'][0]))
    $bn_aagaz_startup_pro_url = $bn_stored_meta['aagaz_startup_pro_url'][0];
  else
    $bn_aagaz_startup_pro_url = '';
  ?>
  <div id="portfolios_custom_stuff">
    <table id="list">
      <tbody id="the-list" data-wp-lists="list:meta">
        <tr id="meta-1">
          <td class="left">
            <?php esc_html_e( 'Poertfolio Url', 'aagaz-startup-pro-posttype' )?>
          </td>
          <td class="left" >
            <input type="url" name="aagaz_startup_pro_url" id="aagaz_startup_pro_url" value="<?php echo esc_attr( $bn_aagaz_startup_pro_url ); ?>" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php
}

/* Saves the custom meta input */
function aagaz_startup_pro_posttype_bn_meta_work_save( $post_id ) {
  if (!isset($_POST['te_porfolio_meta_nonce']) || !wp_verify_nonce($_POST['te_portfolio_meta_nonce'], basename(__FILE__))) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

   // Save desig.
  if( isset( $_POST[ 'aagaz_startup_pro_url' ] ) ) {
    update_post_meta( $post_id, 'aagaz_startup_pro_url', esc_url($_POST[ 'aagaz_startup_pro_url']) );
  }
}

add_action( 'save_post', 'aagaz_startup_pro_posttype_bn_meta_work_save' );

/*----------------------Testimonial section ----------------------*/
/* Adds a meta box to the Testimonial editing screen */
function aagaz_startup_pro_posttype_bn_testimonial_meta_box() {
	add_meta_box( 'aagaz-startup-pro-posttype-testimonial-meta', __( 'Enter Details', 'aagaz-startup-pro-posttype' ), 'aagaz_startup_pro_posttype_bn_testimonial_meta_callback', 'testimonials', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'aagaz_startup_pro_posttype_bn_testimonial_meta_box');
}
/* Adds a meta box for custom post */
function aagaz_startup_pro_posttype_bn_testimonial_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'aagaz_startup_pro_posttype_posttype_testimonial_meta_nonce' );
  $bn_stored_meta = get_post_meta( $post->ID );
  if(!empty($bn_stored_meta['aagaz_startup_pro_posttype_testimonial_desigstory'][0]))
      $bn_aagaz_startup_pro_posttype_testimonial_desigstory = $bn_stored_meta['aagaz_startup_pro_posttype_testimonial_desigstory'][0];
    else
      $bn_aagaz_startup_pro_posttype_testimonial_desigstory = '';
	?>
	<div id="testimonials_custom_stuff">
		<table id="list">
			<tbody id="the-list" data-wp-lists="list:meta">
				<tr id="meta-1">
					<td class="left">
						<?php _e( 'Designation', 'aagaz-startup-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="text" name="aagaz_startup_pro_posttype_testimonial_desigstory" id="aagaz_startup_pro_posttype_testimonial_desigstory" value="<?php echo esc_attr( $bn_aagaz_startup_pro_posttype_testimonial_desigstory ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
}

/* Saves the custom meta input */
function aagaz_startup_pro_posttype_bn_metadesig_save( $post_id ) {
	if (!isset($_POST['aagaz_startup_pro_posttype_posttype_testimonial_meta_nonce']) || !wp_verify_nonce($_POST['aagaz_startup_pro_posttype_posttype_testimonial_meta_nonce'], basename(__FILE__))) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Save desig.
	if( isset( $_POST[ 'aagaz_startup_pro_posttype_testimonial_desigstory' ] ) ) {
		update_post_meta( $post_id, 'aagaz_startup_pro_posttype_testimonial_desigstory', sanitize_text_field($_POST[ 'aagaz_startup_pro_posttype_testimonial_desigstory']) );
	}
}

add_action( 'save_post', 'aagaz_startup_pro_posttype_bn_metadesig_save' );

/*------------------------- Team Section-----------------------------*/
/* Adds a meta box for Designation */
function aagaz_startup_pro_posttype_bn_team_meta() {
    add_meta_box( 'aagaz_startup_pro_posttype_bn_meta', __( 'Enter Details','aagaz-startup-pro-posttype' ), 'aagaz_startup_pro_posttype_ex_bn_meta_callback', 'team', 'normal', 'high' );
}
// Hook things in for admin
if (is_admin()){
    add_action('admin_menu', 'aagaz_startup_pro_posttype_bn_team_meta');
}
/* Adds a meta box for custom post */
function aagaz_startup_pro_posttype_ex_bn_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'aagaz_startup_pro_posttype_bn_nonce' );
    $bn_stored_meta = get_post_meta( $post->ID );

    //Email details
    if(!empty($bn_stored_meta['meta-desig'][0]))
      $bn_meta_desig = $bn_stored_meta['meta-desig'][0];
    else
      $bn_meta_desig = '';

    //Phone details
    if(!empty($bn_stored_meta['meta-call'][0]))
      $bn_meta_call = $bn_stored_meta['meta-call'][0];
    else
      $bn_meta_call = '';

    //facebook details
    if(!empty($bn_stored_meta['meta-facebookurl'][0]))
      $bn_meta_facebookurl = $bn_stored_meta['meta-facebookurl'][0];
    else
      $bn_meta_facebookurl = '';

    //linkdenurl details
    if(!empty($bn_stored_meta['meta-linkdenurl'][0]))
      $bn_meta_linkdenurl = $bn_stored_meta['meta-linkdenurl'][0];
    else
      $bn_meta_linkdenurl = '';

    //twitterurl details
    if(!empty($bn_stored_meta['meta-twitterurl'][0]))
      $bn_meta_twitterurl = $bn_stored_meta['meta-twitterurl'][0];
    else
      $bn_meta_twitterurl = '';

    //twitterurl details
    if(!empty($bn_stored_meta['meta-googleplusurl'][0]))
      $bn_meta_googleplusurl = $bn_stored_meta['meta-googleplusurl'][0];
    else
      $bn_meta_googleplusurl = '';

    //instagramurl details
    if(!empty($bn_stored_meta['meta-instagramurl'][0]))
      $bn_meta_instagramurl = $bn_stored_meta['meta-instagramurl'][0];
    else
      $bn_meta_instagramurl = '';

    //youtubeurl details
    if(!empty($bn_stored_meta['meta-youtubeurl'][0]))
      $bn_meta_youtubeurl = $bn_stored_meta['meta-youtubeurl'][0];
    else
      $bn_meta_youtubeurl = '';

     //pinteresturl details
    if(!empty($bn_stored_meta['meta-pinteresturl'][0]))
      $bn_meta_pinteresturl = $bn_stored_meta['meta-pinteresturl'][0];
    else
      $bn_meta_pinteresturl = '';

    //designation details
    if(!empty($bn_stored_meta['meta-designation'][0]))
      $bn_meta_designation = $bn_stored_meta['meta-designation'][0];
    else
      $bn_meta_designation = '';

    ?>
    <div id="agent_custom_stuff">
        <table id="list-table">         
            <tbody id="the-list" data-wp-lists="list:meta">
                <tr id="meta-1">
                    <td class="left">
                        <?php esc_html_e( 'Email', 'aagaz-startup-pro-posttype' )?>
                    </td>
                    <td class="left" >
                        <input type="text" name="meta-desig" id="meta-desig" value="<?php echo esc_attr($bn_meta_desig); ?>" />
                    </td>
                </tr>
                <tr id="meta-2">
                    <td class="left">
                        <?php esc_html_e( 'Phone Number', 'aagaz-startup-pro-posttype' )?>
                    </td>
                    <td class="left" >
                        <input type="text" name="meta-call" id="meta-call" value="<?php echo esc_attr($bn_meta_call); ?>" />
                    </td>
                </tr>
                <tr id="meta-3">
                  <td class="left">
                    <?php esc_html_e( 'Facebook Url', 'aagaz-startup-pro-posttype' )?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-facebookurl" id="meta-facebookurl" value="<?php echo esc_url($bn_meta_facebookurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-4">
                  <td class="left">
                    <?php esc_html_e( 'Linkedin URL', 'aagaz-startup-pro-posttype' )?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-linkdenurl" id="meta-linkdenurl" value="<?php echo esc_url($bn_meta_linkdenurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-5">
                  <td class="left">
                    <?php esc_html_e( 'Twitter Url', 'aagaz-startup-pro-posttype' ); ?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-twitterurl" id="meta-twitterurl" value="<?php echo esc_url( $bn_meta_twitterurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-6">
                  <td class="left">
                    <?php esc_html_e( 'GooglePlus URL', 'aagaz-startup-pro-posttype' ); ?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-googleplusurl" id="meta-googleplusurl" value="<?php echo esc_url($bn_meta_googleplusurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-7">
                  <td class="left">
                    <?php esc_html_e( 'Instagram Url', 'aagaz-startup-pro-posttype' ); ?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-instagramurl" id="meta-instagramurl" value="<?php echo esc_url( $bn_meta_instagramurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-8">
                  <td class="left">
                    <?php esc_html_e( 'Youtube Url', 'aagaz-startup-pro-posttype' ); ?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-youtubeurl" id="meta-youtubeurl" value="<?php echo esc_url( $bn_meta_youtubeurl); ?>" />
                  </td>
                </tr>
                <tr id="meta-9">
                  <td class="left">
                    <?php esc_html_e( 'Pinterest Url', 'aagaz-startup-pro-posttype' ); ?>
                  </td>
                  <td class="left" >
                    <input type="url" name="meta-pinteresturl" id="meta-pinteresturl" value="<?php echo esc_url( $bn_meta_pinteresturl); ?>" />
                  </td>
                </tr>
                <tr id="meta-10">
                  <td class="left">
                    <?php esc_html_e( 'Designation', 'aagaz-startup-pro-posttype' ); ?>
                  </td>
                  <td class="left" >
                    <input type="text" name="meta-designation" id="meta-designation" value="<?php echo esc_attr($bn_meta_designation); ?>" />
                  </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
}
/* Saves the custom Designation meta input */
function aagaz_startup_pro_posttype_ex_bn_metadesig_save( $post_id ) {
    if( isset( $_POST[ 'meta-desig' ] ) ) {
        update_post_meta( $post_id, 'meta-desig', esc_html($_POST[ 'meta-desig' ]) );
    }
    if( isset( $_POST[ 'meta-call' ] ) ) {
        update_post_meta( $post_id, 'meta-call', esc_html($_POST[ 'meta-call' ]) );
    }
    // Save facebookurl
    if( isset( $_POST[ 'meta-facebookurl' ] ) ) {
        update_post_meta( $post_id, 'meta-facebookurl', esc_url($_POST[ 'meta-facebookurl' ]) );
    }
    // Save linkdenurl
    if( isset( $_POST[ 'meta-linkdenurl' ] ) ) {
        update_post_meta( $post_id, 'meta-linkdenurl', esc_url($_POST[ 'meta-linkdenurl' ]) );
    }
    if( isset( $_POST[ 'meta-twitterurl' ] ) ) {
        update_post_meta( $post_id, 'meta-twitterurl', esc_url($_POST[ 'meta-twitterurl' ]) );
    }
    // Save googleplusurl
    if( isset( $_POST[ 'meta-googleplusurl' ] ) ) {
        update_post_meta( $post_id, 'meta-googleplusurl', esc_url($_POST[ 'meta-googleplusurl' ]) );
    }
    // Save instagramurl
    if( isset( $_POST[ 'meta-instagramurl' ] ) ) {
        update_post_meta( $post_id, 'meta-instagramurl', esc_url($_POST[ 'meta-instagramurl' ]) );
    }
    // Save youtubeurl
    if( isset( $_POST[ 'meta-youtubeurl' ] ) ) {
        update_post_meta( $post_id, 'meta-youtubeurl', esc_url($_POST[ 'meta-youtubeurl' ]) );
    }
     // Save pinteresturl
    if( isset( $_POST[ 'meta-pinteresturl' ] ) ) {
        update_post_meta( $post_id, 'meta-pinteresturl', esc_url($_POST[ 'meta-pinteresturl' ]) );
    }
    // Save designation
    if( isset( $_POST[ 'meta-designation' ] ) ) {
        update_post_meta( $post_id, 'meta-designation', esc_html($_POST[ 'meta-designation' ]) );
    }
}
add_action( 'save_post', 'aagaz_startup_pro_posttype_ex_bn_metadesig_save' );




/*------------------- Testimonial Shortcode -------------------------*/
function aagaz_startup_pro_posttype_testimonials_func( $atts ) {
    $testimonial = ''; 
    $testimonial = '<div id="testimonials"><div class="row testimonial_shortcodes">';
      $new = new WP_Query( array( 'post_type' => 'testimonials') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = aagaz_startup_pro_string_limit_words(get_the_excerpt(),20);
          $designation = get_post_meta($post_id,'aagaz_startup_pro_posttype_testimonial_desigstory',true);

          $testimonial .= '<div class="col-lg-4 col-md-6 col-sm-6 mb-4"><div class="testimonial_box">';
                if (has_post_thumbnail()){
                    $testimonial.= '<img src="'.esc_url($url).'">';
                    }
               $testimonial .= '<div class="qoute_text shortcode pb-3">'.$excerpt.'</div>
                <h4 class="testimonial_name"><a href="'.get_the_permalink().'">'.get_the_title().'</a> <cite>'.esc_html($designation).'</cite></h4>
              </div></div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
      else :
        $testimonial = '<div id="testimonial" class="testimonial_wrap col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','aagaz-startup-pro-posttype').'</h2></div>';
      endif;
    $testimonial .= '</div></div>';
    return $testimonial;
}
add_shortcode( 'aagaz-startup-pro-testimonials', 'aagaz_startup_pro_posttype_testimonials_func' );

/*---------------- Our Portfolio Shortcode ---------------------*/
function aagaz_startup_pro_posttype_portfolio_func( $atts ) {
    $portfolio = ''; 
    $portfolio = '<div id="portfolio_tab_content" class="row portfolio_tab_content">';
      $new = new WP_Query( array( 'post_type' => 'portfolio') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = aagaz_startup_pro_string_limit_words(get_the_excerpt(),20);
          $portfolio .= '<div class="col-lg-4 col-md-6 col-sm-6 mb-4">
              <div class="box">';
                if (has_post_thumbnail()){
                  $portfolio.= '<img src="'.esc_url($url).'">';
                  }
                $portfolio.= '<div class="box-content">
                <div class="row">
                  <div class="col-lg-9 col-md-9 col-sm-9 col-12">
                      <h4 class="title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-3 col-12">
                      <a class="arrow-icon" href="'.get_the_permalink() .'"><i class="fas fa-angle-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
        $portfolio.= '</div>';
      else :
        $portfolio = '<div id="portfolio_tab_content" class="col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','aagaz-startup-pro-posttype').'</h2></div>';
      endif;
      $portfolio.= '</div>';
    return $portfolio;
}
add_shortcode( 'aagaz-startup-pro-portfolio', 'aagaz_startup_pro_posttype_portfolio_func' );

/*---------------- FAQ Shortcode ---------------------*/
function aagaz_startup_pro_posttype_faq_func( $atts ) {
    $faq = ''; 
    $faq = '<div id="our_faq" class="faq_tab_content">';
      $new = new WP_Query( array( 'post_type' => 'faq') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = aagaz_startup_pro_string_limit_words(get_the_excerpt(),20);
          $faq .= '<div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading'.esc_attr($k).'">
                  <h4 class="panel-title">
                  <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.esc_attr($k).'" aria-expanded="false" aria-controls="collapse'.esc_attr($k).'">
                    '.get_the_title().'
                  </a>
                </h4>
                </div>
                <div id="collapse'.esc_attr($k).'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading'.esc_attr($k).'">
                  <div class="panel-body">
                    <p>'.get_the_content().'</p>
                  </div>
                </div>
              </div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
        $faq.= '</div>';
      else :
        $faq = '<div id="our_faq" class="col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','aagaz-startup-pro-posttype').'</h2></div>';
      endif;
      $faq.= '</div>';
    return $faq;
}
add_shortcode( 'aagaz-startup-pro-faq', 'aagaz_startup_pro_posttype_faq_func' );

/*------------------------ Team Shortcode --------------------------*/
function aagaz_startup_pro_posttype_team_func( $atts ) {
    $team = ''; 
    $team = '<section id="our_team"><div class="container"><div class="row">';
      $new = new WP_Query( array( 'post_type' => 'team') );
      if ( $new->have_posts() ) :
        $k=1;
        while ($new->have_posts()) : $new->the_post();
          $post_id = get_the_ID();
          $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
          $url = $thumb['0'];
          $excerpt = aagaz_startup_pro_string_limit_words(get_the_excerpt(),5);
          $call = get_post_meta($post_id,'meta-call',true);
          $email = get_post_meta($post_id,'meta-desig',true);
          $facebookurl = get_post_meta($post_id,'meta-facebookurl',true);
          $linkedin = get_post_meta($post_id,'meta-linkdenurl',true);
          $twitter = get_post_meta($post_id,'meta-twitterurl',true);
          $googleplus = get_post_meta($post_id,'meta-googleplusurl',true);
          $team_designation = get_post_meta($post_id,'team_designation',true);
          $excerpt = aagaz_startup_pro_string_limit_words(get_the_excerpt(),15);
          $team .= '<div class="col-lg-3 col-md-6 col-sm-6">
            <div class="box">
              <div class="image-box media">';
                  if (has_post_thumbnail()){
                    $team .= '<img src="'.esc_url($url).'">
                      <div class="overlay">
                        <div class="box-content">
                          <p>'.$excerpt.'</p>
                          <div class="socialbox">';
                            if($facebookurl != '' || $linkedin != '' || $twitter != '' || $googleplus != ''){?>
                              <?php if($facebookurl != ''){
                                $team .= '<a class="" href="'.esc_url($facebookurl).'" target="_blank"><i class="fab fa-facebook-f"></i></a>';
                               } if($twitter != ''){
                                $team .= '<a class="" href="'.esc_url($twitter).'" target="_blank"><i class="fab fa-twitter"></i></a>';                          
                               } if($linkedin != ''){
                               $team .= ' <a class="" href="'.esc_url($linkedin).'" target="_blank"><i class="fab fa-linkedin-in"></i></a>';
                              }if($googleplus != ''){
                                $team .= '<a class="" href="'.esc_url($googleplus).'" target="_blank"><i class="fab fa-google-plus-g"></i></a>';
                              }
                            }
                          $team .= '</div>
                          <h5 class="teamtitle"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h5>
                          <h4 class="border_heading">'.esc_html($team_designation).'</h4>
                        </div>
                     </div>
                  </div>';
              }
            $team .= '</div>
            </div>';
          $k++;         
        endwhile; 
        wp_reset_postdata();
      else :
        $team = '<div id="team" class="team_wrap col-md-3 mt-3 mb-4"><h2 class="center">'.__('Not Found','aagaz-startup-pro-posttype').'</h2></div>';
      endif;
    $team .= '</div></div></section>';
    return $team;
}
add_shortcode( 'aagaz-startup-pro-team', 'aagaz_startup_pro_posttype_team_func' );
