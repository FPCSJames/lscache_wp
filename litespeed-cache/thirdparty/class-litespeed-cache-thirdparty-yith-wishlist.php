<?php

/**
 * The Third Party integration with the YITH WooCommerce Wishlist plugin.
 *
 * @since		1.1.0
 * @package		LiteSpeed_Cache
 * @subpackage	LiteSpeed_Cache/thirdparty
 * @author		LiteSpeed Technologies <info@litespeedtech.com>
 */
if (!defined('ABSPATH')) {
    die();
}

class LiteSpeed_Cache_ThirdParty_Yith_Wishlist
{
	const ESI_PARAM_ATTS = 'yith_wcwl_atts';
	const ESI_PARAM_POSTID = 'yith_wcwl_post_id';
	private static $atts = null; // Not currently used. Depends on how YITH adds attributes

	/**
	 * Detects if YITH WooCommerce Wishlist and WooCommerce are installed.
	 *
	 * @since 1.1.0
	 * @access public
	 */
	public static function detect()
	{
		if ((!defined('WOOCOMMERCE_VERSION')) || (!defined('YITH_WCWL'))) {
			return;
		}
		add_action('litespeed_cache_is_not_esi_template',
			'LiteSpeed_Cache_ThirdParty_Yith_Wishlist::is_not_esi');
		add_action('litespeed_cache_load_esi_block-yith-wcwl-add',
			'LiteSpeed_Cache_ThirdParty_Yith_Wishlist::load_add_to_wishlist');
	}

	public static function is_not_esi()
	{
		add_filter('yith_wcwl_add_to_wishlisth_button_html',
			'LiteSpeed_Cache_ThirdParty_Yith_Wishlist::sub_add_to_wishlist', 999);

	}

	public static function sub_add_to_wishlist($template)
	{
		global $post;
		$params = array(
			self::ESI_PARAM_POSTID => $post->ID
		);
		LiteSpeed_Cache_Esi::build_url('yith-wcwl-add', 'YITH ADD TO WISHLIST',
			$params, LiteSpeed_Cache_Esi::CACHECTRL_PRIV);
		return '';
	}

	public static function load_add_to_wishlist($params)
	{
		global $post, $wp_query;
		$post = get_post($params[self::ESI_PARAM_POSTID]);
		$wp_query->setup_postdata($post);
		echo YITH_WCWL_Shortcode::add_to_wishlist(/*$params[self::ESI_PARAM_ATTS]*/array());
		LiteSpeed_Cache::plugin()->set_cachectrl(LiteSpeed_Cache::CACHECTRL_PRIVATE);
	}

}

add_action('litespeed_cache_detect_thirdparty', 'LiteSpeed_Cache_ThirdParty_Yith_Wishlist::detect');
