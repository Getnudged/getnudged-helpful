<?php
/**
 * Plugin Files
 * 
 * @author Getnudged
 */

/**
 * Add Ajaxurl to wp_head()
 */
function helpful_wphead()
{
	$options = get_option('helpful_options');	
	?>
<!-- Helpful Plugin -->
<script>var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";</script>
<style>
#helpful .helpful-button {
	color: <?php echo ($options['helpful_field_button_text_color'] ? $options['helpful_field_button_text_color'] : '#666'); ?>;
	background: <?php echo ($options['helpful_field_button_background_color'] ? $options['helpful_field_button_background_color'] : '#F5F5F5'); ?>;
	border: 2px solid <?php echo ($options['helpful_field_button_background_color'] ? $options['helpful_field_button_background_color'] : '#F5F5F5'); ?>;
	border-radius: <?php echo ($options['helpful_field_button_border_radius'] ? $options['helpful_field_button_border_radius'] : '3px'); ?>;
	-moz-border-radius: <?php echo ($options['helpful_field_button_border_radius'] ? $options['helpful_field_button_border_radius'] : '3px'); ?>;
	-webkit-border-radius: <?php echo ($options['helpful_field_button_border_radius'] ? $options['helpful_field_button_border_radius'] : '3px'); ?>;
}
#helpful .helpful-button:hover,
#helpful .helpful-button:active,
#helpful .helpful-button:focus {
	color: <?php echo ($options['helpful_field_button_text_color_h'] ? $options['helpful_field_button_text_color_h'] : '#FFF'); ?>;
	background: <?php echo ($options['helpful_field_button_background_color_h'] ? $options['helpful_field_button_background_color_h'] : '#333'); ?>;
	border: 2px solid <?php echo ($options['helpful_field_button_background_color_h'] ? $options['helpful_field_button_background_color_h'] : '#333'); ?>;
}
</style>
<!-- END Helpful Plugin -->
<?php
}
add_action( 'wp_head', 'helpful_wphead' );

/**
 * Get stats count from post $id
 */
function helpful_counter() 
{
	global $wpdb;
	
	$options = get_option('helpful_options');

	$single = __('1 Person fand diesen Artikel hilfreich');	
	if($options['helpful_field_count_single']) $single = $options['helpful_field_count_single'];

	$more = __('%d Personen fanden diesen Artikel hilfreich');	
	if($options['helpful_field_count_more']) $more = $options['helpful_field_count_more'];
	
	$post_id = get_the_ID();
	
	$table_name = $wpdb->prefix . 'helpful';
	
	$result = $wpdb->get_results("SELECT * FROM $table_name WHERE post_id = $post_id;");
	
	foreach($result as $r) if($r->status == 1) $result[] = $r->status;	
	
	$amount = array_sum($result);	
	
	if($amount == 1) 
		return '<p class="helpful-counter">'. __($single) .'</p>';	
	if($amount >= 1) 
		return '<p class="helpful-counter">'. sprintf(__($more, '%d = Personenanzahl'), $amount) .'</p>';
}

/**
 * Get the form
 */
function helpful_form() 
{
	global $wpdb;
	
	$options = get_option('helpful_options');

	$headline = __('War dieser Artikel hilfreich?');	
	if($options['helpful_field_question_text']) $headline = $options['helpful_field_question_text'];
	
	$yes = __('Ja');
	if($options['helpful_field_button_text_y']) $yes = $options['helpful_field_button_text_y'];
	
	$no = __('Nein');
	if($options['helpful_field_button_text_n']) $no = $options['helpful_field_button_text_n'];

	$table_name = $wpdb->prefix . 'helpful';
	
	$post_id = get_the_ID();
	$user    = md5($_SERVER['REMOTE_ADDR']);
	
	$result = $wpdb->get_results("SELECT * FROM $table_name WHERE post_id = $post_id;");
	
	foreach($result as $r) $result[] = $r->user;
	
	if( in_array( $user, $result ) ) :
	
	else :
	
	$form = '
	<div id="helpful-content">
	<span class="helpful-content-heading">'.$headline.'</span>
	
	<a class="helpful-button helpful-button-y" 
	href="' . admin_url( 'admin-ajax.php?action=helpful_ajax_form&post_id=' . $post_id .'&user=' . $user . '&stat=1' ) . '"
	data-id="' . get_the_ID() . '"
	data-user="'.$user.'"
	data-stat="1">'.$yes.'</a>
	
	<a class="helpful-button helpful-button-n" 
	href="' . admin_url( 'admin-ajax.php?action=helpful_ajax_form&post_id=' . $post_id .'&user=' . $user . '&stat=2' ) . '"
	data-id="' . get_the_ID() . '"
	data-user="'.$user.'"
	data-stat="2">'.$no.'</a>
	</div>
	';
	
	return $form;
	
	endif;
}

/**
 * Plugin after post content (single)
 */
function helpful_content( $content ) 
{
	global $post;
	
	$post_type = apply_filters( 'helpful_post_type', $value );
	
	if(!$post_type) {
		$post_type = 'posts';
	}

    if ( is_single() && $post_type) :
		$content .= '<div id="helpful">';
        $content .= helpful_form();
		$content .= helpful_counter();
		$content .= '</div>';
	endif;
	
    return $content;
}
add_filter( 'the_content', 'helpful_content', 99 );

/**
 * Ajax Form
 */
function helpful_ajax_form()
{
	global $wpdb;
	
	$options = get_option('helpful_options');

	$thx = __('Vielen Dank. Ihre Bewertung wurde gespeichert.');	
	if($options['helpful_field_message_save']) $thx = $options['helpful_field_message_save'];

	$table_name = $wpdb->prefix . 'helpful';

	$post_id = $_REQUEST['post_id'];
	$user    = $_REQUEST['user'];
	$status  = $_REQUEST['stat'];
	
	$wpdb->insert( 
		$table_name, 
		array( 
			'post_id' => $post_id, 
			'user' => $user, 
			'status' => $status, 
		)
	);
		
	$table_name = $wpdb->prefix . 'helpful';	
	$result = $wpdb->get_results("SELECT * FROM $table_name WHERE post_id = $post_id;");	
	foreach($result as $r) if($r->status == 1) $result[] = $r->status;	
	$amount_pro = array_sum($result);	
		
	$table_name = $wpdb->prefix . 'helpful';	
	$result = $wpdb->get_results("SELECT * FROM $table_name WHERE post_id = $post_id;");	
	foreach($result as $r) if($r->status == 2) $result[] = $r->status-1;	
	$amount_contra = array_sum($result);	
	
	if ( ! add_post_meta( $post_id, 'helpful_counter_pro', $amount_pro, true ) ) :
		update_post_meta( $post_id, 'helpful_counter_pro', $amount_pro );
	endif;
	
	if ( ! add_post_meta( $post_id, 'helpful_counter_contra', $amount_contra, true ) ) :
		update_post_meta( $post_id, 'helpful_counter_contra', $amount_contra );
	endif;
	
	echo $thx;
		
	exit();	
}
add_action( 'wp_ajax_helpful_ajax_form', 'helpful_ajax_form' );
add_action( 'wp_ajax_nopriv_helpful_ajax_form', 'helpful_ajax_form' );

/**
 * Get stats count from post $id for post list (wp-admin)
 */
function helpful_backend_counter($id, $status = 'pro') 
{
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'helpful';
	
	$results = $wpdb->get_results("SELECT * FROM $table_name WHERE post_id = $id;");
	
	if($status == 'pro') :	
	
		foreach($results as $key) :
			if($key->status == 1) $pro[] = $key->status;
		endforeach;
		
		$amount = array_sum($pro);
		
	endif;
	
	if($status == 'contra') :	
	
		foreach($results as $key) :	
			if($key->status == 2) $contra[] = $key->status-1;	
		endforeach;
		
		$amount = array_sum($contra);
		
	endif;
		
	if( $amount == 0 ) echo 0;
	if( $amount !== 0 ) echo $amount;
}

/**
 * New column in post list
 */
add_filter('manage_posts_columns', 'helpful_columns_head');
function helpful_columns_head($columns) 
{
	$new = array();
	
	$post_type = apply_filters( 'helpful_post_type', $value );
	
	$options = get_option('helpful_options');

	$pro = __('Hilfreich');	
	if($options['helpful_field_table_pro']) $pro = $options['helpful_field_table_pro'];

	$con = __('Nicht hilfreich');	
	if($options['helpful_field_table_con']) $con = $options['helpful_field_table_con'];
	
	if(strlen($post_type) >= 0) :
	
		if($_GET['post_type'] == $post_type) :
		
			foreach($columns as $key => $title) {
				if ($key == 'date' ) :
					$new['helpful_pro'] = $pro;
					$new['helpful_con'] = $con;
				endif;
				$new[$key] = $title;
			}
			
		else :
		
			foreach($columns as $key => $title) {
				$new[$key] = $title;
			}
			
		endif;
	
	else : 	
		
		foreach($columns as $key => $title) {
			if ($key == 'date' ) :
				$new['helpful_pro'] = $pro;
				$new['helpful_con'] = $con;
			endif;
			$new[$key] = $title;
		}
		
	endif;
	
	return $new;
}

/**
 * New column content in post list
 */
add_action('manage_posts_custom_column', 'helpful_columns_content', 10, 2);
function helpful_columns_content($column_name, $post_ID) 
{
	$post_type = apply_filters( 'helpful_post_type', $value );
	
	if(strlen($post_type) >= 0) :
	
		if($_GET['post_type'] == $post_type) :
			if ($column_name == 'helpful_pro') echo intval(get_post_meta( $post_ID, 'helpful_counter_pro', true ));
			if ($column_name == 'helpful_con') echo intval(get_post_meta( $post_ID, 'helpful_counter_contra', true ));
		endif;
	
	else : 	
	
		if ($column_name == 'helpful_pro') echo intval(get_post_meta( $post_ID, 'helpful_counter_pro', true ));
		if ($column_name == 'helpful_con') echo intval(get_post_meta( $post_ID, 'helpful_counter_contra', true ));
		
	endif;
}
