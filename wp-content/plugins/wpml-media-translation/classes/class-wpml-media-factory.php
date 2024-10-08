<?php

/**
 * Class WPML_Media_Factory
 */
class WPML_Media_Factory implements IWPML_Frontend_Action_Loader, IWPML_Backend_Action_Loader {

	public function create() {
		global $sitepress, $wpdb;

		$wpml_wp_api = $sitepress->get_wp_api();

		$template_service_loader  = new WPML_Twig_Template_Loader(
			array( $wpml_wp_api->constant( 'WPML_MEDIA_PATH' ) . '/templates/menus/' )
		);
		$wpml_media_menus_factory = new WPML_Media_Menus_Factory();

		$image_translator = new WPML_Media_Image_Translate(
			$sitepress,
			new WPML_Media_Attachment_By_URL_Factory(),
			new \WPML\Media\Factories\WPML_Media_Attachment_By_URL_Query_Factory()
		);

		return new WPML_Media( $sitepress, $wpdb, $wpml_media_menus_factory, $image_translator );
	}

}
