<?php
/**SCRIPT TO SAVE CUSTOM METADATA**/
function bc_save_team_member_meta($post_id, $post) {
	/**authentication, is the user allowed to save data to this post?**/
	if (!current_user_can('edit_post', $post->ID))
			return $post->ID;

		$team_member_meta['_job_title'] = $_POST['_job_title'];
		$team_member_meta['_department'] = $_POST['_department'];
		$team_member_meta['_twitter'] = $_POST['_twitter'];
		$team_member_meta['_linkedin'] = $_POST['_linkedin'];
		$team_member_meta['_email'] = $_POST['_email'];


		foreach ($team_member_meta as $key => $value) {
			if($post->post_type=='revision') return; /**dont store custom data if post is currently in revision**/
			$value = implode(',',(array)$value); /**turn values that are arrays into CSV**/
			if(get_post_meta($post->ID, $key, FALSE)) { /**checks to see if the custom field already has a value, does it need to save or update**/
					update_post_meta($post->ID, $key, $value);
				}
			else {
					add_post_meta($post->ID, $key, $value);
				}
			if(!value) delete_post_meta($post->ID, $key);
		}

	}

add_action('save_post', 'bc_save_team_member_meta', 1, 2);





/**create custom fields for custom post types**/

/**define job title field for team member post type**/
function add_tm_metaboxes() {
	add_meta_box('tm_job_title', 'Job Title', 'tm_job_title', 'team-member', 'normal', 'default');
	add_meta_box('tm_department', 'Department/Role', 'tm_department', 'team-member', 'normal', 'default');
	add_meta_box('tm_twitter', 'Twitter Username', 'tm_twitter', 'team-member', 'normal', 'default');
	add_meta_box('tm_linkedin', 'Linkedin Username', 'tm_Linkedin', 'team-member', 'normal', 'default');
	add_meta_box('tm_email', 'Email', 'tm_email', 'team-member', 'normal', 'default');
}


/**define html for job title field**/
function tm_job_title() {
	/**get the post being worked on**/
	global $post;
	/**get the value of the field if it's already been entered**/
	$job_title = get_post_meta($post->ID, '_job_title', true);
	/**echo the field**/
	echo '<input type="text" name="_job_title" value="'.$job_title.'"class="widefat"/>';
}

/**define html for twitter field**/
function tm_twitter() {
	/**get the post being worked on**/
	global $post;
	/**get the value of the field if it's already been entered**/
	$twitter = get_post_meta($post->ID, '_twitter', true);
	/**echo the field**/
	echo '<input type="text" name="_twitter" value="'.$twitter.'"class="widefat"/>';
}

/**define html for linkedin field**/
function tm_linkedin() {
	/**get the post being worked on**/
	global $post;
	/**get the value of the field if it's already been entered**/
	$linkedin = get_post_meta($post->ID, '_linkedin', true);
	/**echo the field**/
	echo '<input type="text" name="_linkedin" value="'.$linkedin.'"class="widefat"/>';
}

/**define html for email field**/
function tm_email() {
	/**get the post being worked on**/
	global $post;
	/**get the value of the field if it's already been entered**/
	$email = get_post_meta($post->ID, '_email', true);
	/**echo the field**/
	echo '<input type="text" name="_email" value="'.$email.'"class="widefat"/>';
}

/**define html for department field**/
function tm_department() {
	global $post;
	$department = get_post_meta($post->ID, '_department', true);
	$deptlist = array('Creative', 'Development');
	foreach ($deptlist as $value) {
		echo '<input type="checkbox" name="_department" value="'.$value.'"';
		if ($value == $department) {
				echo 'checked="checked"';
		}
		echo '>'.$value.'<br  />';
	}
	
}

add_action('init', 'bcdev_register_custom_post_types');

/**Team member Custom post definition**/
function bcdev_register_custom_post_types() {
	$args = array(
			'public' => true,
			/**labels for team member post type**/
			'labels' => array(
				'name' => 'Team Members', 
				'singular_name' => 'Team Member', 
				'add_new' => 'Add New Team Member',
				'add_new_item' => 'Add New Team Member',
				'edit item' => 'Edit Team Member',
				'new_item' => 'New Team Member',
				'all_items' => 'All Team Members',
				'view_item' => 'View Team Member',
				'search_items' => 'Search Team Members',
				'not_found' => 'No Team Members found',
				'not_found_in_trash' => 'No Team Members found in trash',
				'menu_name' => 'Team Members'),
			/** fields the post type supports**/
			'supports' => array('title', 'thumbnail', 'editor'),
			/**defining custom fields**/
			'register_meta_box_cb' => 'add_tm_metaboxes',
			/**define category for this post type**/
			'taxonomies' => array('team-member'),
		);


	register_post_type('team-member', $args);

}
?>