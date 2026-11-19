<?php
/**
 * Plugin Name: Open Migrate
 * Plugin URI: https://www.fredericodecastro.com.br/links
 * Description: Import, export and manage .wpress backups with no file size limit, no telemetry and no external connections. Compatible with All-in-One WP Migration backups.
 * Author: Frederico de Castro
 * Author URI: https://www.fredericodecastro.com.br/links
 * Version: 1.0.2
 * Requires PHP: 7.4
 * Requires at least: 5.8
 * Text Domain: open-migrate
 * Domain Path: /languages
 * License: GPLv3
 *
 * Copyright (C) 2026 Frederico de Castro
 * Copyright (C) 2014-2025 ServMask Inc.
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
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Attribution: This code is part of the All-in-One WP Migration plugin, developed by
 *
 * ███████╗███████╗██████╗ ██╗   ██╗███╗   ███╗ █████╗ ███████╗██╗  ██╗
 * ██╔════╝██╔════╝██╔══██╗██║   ██║████╗ ████║██╔══██╗██╔════╝██║ ██╔╝
 * ███████╗█████╗  ██████╔╝██║   ██║██╔████╔██║███████║███████╗█████╔╝
 * ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██║╚██╔╝██║██╔══██║╚════██║██╔═██╗
 * ███████║███████╗██║  ██║ ╚████╔╝ ██║ ╚═╝ ██║██║  ██║███████║██║  ██╗
 * ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Kangaroos cannot jump here' );
}

// Check SSL mode
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && ( $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) ) {
	$_SERVER['HTTPS'] = 'on';
}

// Plugin basename
define( 'OPENMIGRATE_PLUGIN_BASENAME', basename( __DIR__ ) . '/' . basename( __FILE__ ) );

// Plugin path
define( 'OPENMIGRATE_PATH', __DIR__ );

// Plugin URL
define( 'OPENMIGRATE_URL', plugins_url( '', OPENMIGRATE_PLUGIN_BASENAME ) );

// Plugin storage URL
define( 'OPENMIGRATE_STORAGE_URL', plugins_url( 'storage', OPENMIGRATE_PLUGIN_BASENAME ) );

// Include functions
require_once __DIR__ . DIRECTORY_SEPARATOR . 'functions.php';

// Include constants
require_once __DIR__ . DIRECTORY_SEPARATOR . 'constants.php';

// Include deprecated
require_once __DIR__ . DIRECTORY_SEPARATOR . 'deprecated.php';

// Include exceptions
require_once __DIR__ . DIRECTORY_SEPARATOR . 'exceptions.php';

// Include loader
require_once __DIR__ . DIRECTORY_SEPARATOR . 'loader.php';

// Plugin initialization
$main_controller = new OpenMigrate_Main_Controller();
