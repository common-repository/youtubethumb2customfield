<?php
/*
Plugin Name: YouTubeThumb2CustomField
Plugin URI: http://herrpfleger.de/wp-plugin
Description: Inserts URL to YouTube-thumbnail into Custom Field when you embed YouTube video into your post. 
Author: Herr Pfleger
Version: 0.8
Author URI: http://herrpfleger.de
*/

add_action('save_post','find_ytid', 10, 2);

function find_ytid($postID, $post) {		
	if($parent_id = wp_is_post_revision($postID))
		{
		$postID = $parent_id;
		}
		$content = $_POST['content'];			
		if (preg_match('/http:\/\/www.youtube\.com\/v\/([a-zA-Z0-9\-\_]{11})/', $content, $yturl) !='') {	
		$ytid = substr($yturl[0], 25, 31);		
		$custom = 'http://img.youtube.com/vi/'.$ytid.'/hqdefault.jpg';
		update_custom_meta($postID, $custom ,'ytthumb_url');
		}
		elseif (preg_match('/http(v|vh|vhd):\/\/([a-zA-Z0-9\-\_]+\.|)youtube\.com\/watch(\?v\=|\/v\/)([a-zA-Z0-9\-\_]{11})([^<\s]*)/', $content, $yturl) !='') {
		$custom = 'http://img.youtube.com/vi/'.$yturl[4].'/hqdefault.jpg';
		update_custom_meta($postID, $custom ,'ytthumb_url');	
		}	
}

function update_custom_meta($postID, $newvalue, $field_name) {
// To create new meta
if(!get_post_meta($postID, $field_name)){
add_post_meta($postID, $field_name, $newvalue);
}else{
// or to update existing meta
update_post_meta($postID, $field_name, $newvalue);
}
}
?>
