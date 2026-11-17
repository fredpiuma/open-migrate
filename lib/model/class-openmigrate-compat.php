<?php
/**
 * Copyright (C) 2026 Frederico de Castro
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Kangaroos cannot jump here' );
}

/**
 * Interoperability with the original All-in-One WP Migration plugin.
 *
 * Open Migrate only ever reads the options of the original. This class lists them, keeps them
 * untouched across an import, and keeps the original plugin active if it was active before.
 */
class OpenMigrate_Compat {

	/**
	 * Options of the original plugin that hold its own state (never exported, preserved on import).
	 *
	 * @return array
	 */
	public static function original_state_options() {
		return array(
			'ai1wm_status',
			'ai1wm_secret_key',
			'ai1wm_auth_user',
			'ai1wm_auth_password',
			'ai1wm_auth_header',
			'ai1wm_backups_labels',
			'ai1wm_backups_path',
			'ai1wm_sites_links',
		);
	}

	/**
	 * Basenames (folder/file.php) of the original plugin and its extensions.
	 *
	 * @return array
	 */
	public static function original_plugin_basenames() {
		$basenames = array();
		foreach ( openmigrate_original_plugin_dirs() as $dir ) {
			$basenames[] = $dir . '/' . $dir . '.php';
		}

		return $basenames;
	}

	/**
	 * Remember the original plugin state before the options table is replaced.
	 *
	 * @return array
	 */
	public static function capture() {
		$missing = '__openmigrate_missing__';
		$options = array();
		foreach ( self::original_state_options() as $name ) {
			$options[ $name ] = get_option( $name, $missing );
		}

		$active = (array) get_option( OPENMIGRATE_ACTIVE_PLUGINS, array() );

		return array(
			'missing' => $missing,
			'options' => $options,
			'plugins' => array_values( array_intersect( self::original_plugin_basenames(), $active ) ),
		);
	}

	/**
	 * Put the original plugin state back after the import.
	 *
	 * @param  array $state Result of capture()
	 * @return void
	 */
	public static function restore( $state ) {
		foreach ( $state['options'] as $name => $value ) {
			if ( $value === $state['missing'] ) {
				delete_option( $name );
			} else {
				update_option( $name, $value );
			}
		}

		if ( ! empty( $state['plugins'] ) ) {
			openmigrate_activate_plugins( $state['plugins'] );
		}
	}
}
