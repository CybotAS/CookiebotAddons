<?php

namespace cookiebot_addons_framework\lib;

class Settings_Service implements Settings_Service_Interface {

	protected $container;

	protected  $test = 'test';

	public function __construct( $container ) {
		$this->container = $container;
	}

	/**
	 * Returns true if the addon is enabled in the backend
	 *
	 * @param $addon
	 *
	 * @return mixed
	 *
	 * @since 1.3.0
	 */
	public function is_addon_enabled( $addon ) {

	}

}