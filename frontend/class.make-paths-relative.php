<?php

/**
 * @package MakePathsRelative\Frontend
 */

class Make_Paths_Relative {
  private static $initiated = false;
  private static $make_paths_relative_url;

  /**
   * Call this method to make the URLs relative on page init
   */
  public static function init() {    
    if( !self::$initiated ) {
      self::$initiated = true;

      $make_relative_paths = unserialize( get_option('make_paths_relative') );
      

      $host_name = site_url();
      if( isset($make_relative_paths['site_url']) && !empty($make_relative_paths['site_url']) ) {
        $host_name = $make_relative_paths['site_url'];
      }
			if (strpos($host_name, 'http://') !== false) {
				$host_name = str_replace('http://', '', $host_name);	
			} else if (strpos($host_name, 'https://') !== false) {
				$host_name = str_replace('https://', '', $host_name);
			} else if (strpos($host_name, '//') !== false) {
				$host_name = str_replace('//', '', $host_name);
			}
			self::$make_paths_relative_url = $host_name; 
      
      if( isset($make_relative_paths) && !empty($make_relative_paths) ) {
        Make_Paths_Relative::make_paths_relative_applied($make_relative_paths);
      }
    }
  }

  /**
   * It makes the permalinks, scripts, styles and image URLs(srd) to relative
   */
  public static function make_paths_relative_remove($link) {
		$relative_link = $link;
    $relative_link = str_replace('https://' . self::$make_paths_relative_url, '', $relative_link);
		$relative_link = str_replace('http://' . self::$make_paths_relative_url, '', $relative_link);
		$relative_link = str_replace('//' . self::$make_paths_relative_url, '', $relative_link);
    return apply_filters('paths_relative', $relative_link);
  }
  
  public static function make_paths_relative_applied($make_relative_paths) {
   
    //Filters to make the permalinks to relative
    if( isset($make_relative_paths['post_permalinks']) && !empty($make_relative_paths['post_permalinks']) ) {
      add_filter( 'the_permalink', array('Make_Paths_Relative', 'make_paths_relative_remove') );
      add_filter( 'post_link', array('Make_Paths_Relative', 'make_paths_relative_remove') );
      add_filter( 'post_type_link', array('Make_Paths_Relative', 'make_paths_relative_remove'), 10, 2 );
    }

    if( isset($make_relative_paths['archive_permalinks']) && !empty($make_relative_paths['archive_permalinks']) ) {
      add_filter( 'get_archives_link', array('Make_Paths_Relative', 'make_paths_relative_remove') );
    }

    if( isset($make_relative_paths['author_permalinks']) && !empty($make_relative_paths['author_permalinks']) ) {
      add_filter( 'author_link', array('Make_Paths_Relative', 'make_paths_relative_remove') );
    }
    if( isset($make_relative_paths['category_permalinks']) && !empty($make_relative_paths['category_permalinks']) ) {
      add_filter( 'category_link', array('Make_Paths_Relative', 'make_paths_relative_remove') );
    }

    //Filters to make the scripts and style urls to relative
    if( isset($make_relative_paths['scripts_src']) && !empty($make_relative_paths['scripts_src']) ) {
      add_filter( 'script_loader_src', array('Make_Paths_Relative', 'make_paths_relative_remove') );
    }

    if( isset($make_relative_paths['styles_src']) && !empty($make_relative_paths['styles_src']) ) {
      add_filter( 'style_loader_src', array('Make_Paths_Relative', 'make_paths_relative_remove') );
    }

    //Filter to make the media(image) src to relative
    if( isset($make_relative_paths['image_paths']) && !empty($make_relative_paths['image_paths']) ) {
      add_filter( 'wp_get_attachment_url', array('Make_Paths_Relative', 'make_paths_relative_remove') );
			add_filter( 'wp_calculate_image_srcset', array('Make_Paths_Relative', 'make_paths_relative_remove_srcset') );
    }
  }

	/**
	 * Make the srcset to be relative for responsive images
	 */
	public function make_paths_relative_remove_srcset($image_srcset) {

		if (apply_filters('srcset_paths_relative', '__true')) {
			foreach($image_srcset as $key => $value) {
				if (isset($value['url'])) 
					$image_srcset[$key]['url'] = str_replace(self::$make_paths_relative_url, '', $value['url']);
			}
		}

		return $image_srcset;
	}

}
