<?php
/**
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

class OpenMigrate_Main_Controller {

	/**
	 * Main Application Controller
	 *
	 * @return OpenMigrate_Main_Controller
	 */
	public function __construct() {
		register_activation_hook( OPENMIGRATE_PLUGIN_BASENAME, array( $this, 'activation_hook' ) );

		// Activate hooks
		$this->activate_actions();
		$this->activate_filters();
	}

	/**
	 * Activation hook callback
	 *
	 * @return void
	 */
	public function activation_hook() {
		if ( extension_loaded( 'litespeed' ) ) {
			$this->create_litespeed_htaccess( OPENMIGRATE_WORDPRESS_HTACCESS );
		}

		$this->setup_backups_folder();
		$this->setup_storage_folder();
		$this->setup_secret_key();
	}

	/**
	 * Initializes language domain for the plugin
	 *
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain( OPENMIGRATE_PLUGIN_NAME, false, false );
	}

	/**
	 * Register listeners for actions
	 *
	 * @return void
	 */
	private function activate_actions() {
		// Load admin header styles
		add_action( 'admin_head', array( $this, 'admin_head' ) );

		// Load core functionality
		add_action( 'cli_init', array( $this, 'cli_init' ) );
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_init', array( $this, 'router' ) );
		add_action( 'admin_init', array( $this, 'wp_importing' ), 5 );
		add_action( 'admin_init', array( $this, 'setup_backups_folder' ) );
		add_action( 'admin_init', array( $this, 'setup_storage_folder' ) );
		add_action( 'admin_init', array( $this, 'setup_secret_key' ) );
		add_action( 'admin_init', array( $this, 'check_auto_increment' ) );
		add_action( 'admin_init', array( $this, 'check_user_role_capability' ) );
		add_action( 'admin_notices', array( $this, 'environment_notices' ) );
		add_action( 'admin_init', array( $this, 'schedule_crons' ) );
		add_action( 'admin_init', array( $this, 'load_textdomain' ) );

		// Load commands and buttons
		add_action( 'plugins_loaded', array( $this, 'openmigrate_loaded' ), 10 );
		add_action( 'plugins_loaded', array( $this, 'openmigrate_commands' ), 10 );

		// Register scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'register_servmask_scripts_and_styles' ), 5 );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_export_scripts_and_styles' ), 5 );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_import_scripts_and_styles' ), 5 );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_backups_scripts_and_styles' ), 5 );

		// Enqueue scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_export_scripts_and_styles' ), 5 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_import_scripts_and_styles' ), 5 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backups_scripts_and_styles' ), 5 );

		// Render the bulk delete button below the backups list
		add_action( 'openmigrate_backups_left_end', 'OpenMigrate_Backups_Controller::bulk_delete_button' );

		// Handle export/import exceptions (errors)
		add_action( 'openmigrate_status_export_error', array( $this, 'handle_error_cleanup' ), 5, 2 );
		add_action( 'openmigrate_status_import_error', array( $this, 'handle_error_cleanup' ), 5, 2 );
	}

	/**
	 * Register listeners for filters
	 *
	 * @return void
	 */
	private function activate_filters() {

		// Add custom schedules
		add_filter( 'cron_schedules', array( $this, 'add_cron_schedules' ), 9999 );

		// Map the full-site import meta capability
		add_filter( 'map_meta_cap', array( $this, 'add_map_meta_cap' ), 9999, 4 );
	}

	/**
	 * Export and import commands
	 *
	 * @return void
	 */
	public function openmigrate_commands() {
		// Add export commands
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Init::execute', 5 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Archive::execute', 30 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Config::execute', 50 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Config_File::execute', 60 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Enumerate_Content::execute', 100 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Enumerate_Media::execute', 110 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Enumerate_Plugins::execute', 120 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Enumerate_Themes::execute', 130 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Enumerate_Tables::execute', 140 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Content::execute', 150 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Media::execute', 160 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Plugins::execute', 170 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Themes::execute', 180 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Database::execute', 200 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Database_File::execute', 220 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Archive_Crc::execute', 240 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Download::execute', 250 );
		add_filter( 'openmigrate_export', 'OpenMigrate_Export_Clean::execute', 300 );

		// Add import commands
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Upload::execute', 5 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Validate::execute', 10 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Validate_Crc::execute', 55 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Check_Compression::execute', 70 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Check_Encryption::execute', 75 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Confirm::execute', 100 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Blogs::execute', 150 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Permalinks::execute', 170 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Enumerate::execute', 200 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Content::execute', 250 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Mu_Plugins::execute', 270 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Database_File::execute', 295 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Database::execute', 300 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Users::execute', 310 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Options::execute', 330 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Done::execute', 350 );
		add_filter( 'openmigrate_import', 'OpenMigrate_Import_Clean::execute', 400 );
	}

	/**
	 * All-in-One WP Migration loaded
	 *
	 * @return void
	 */
	public function openmigrate_loaded() {
		if ( ! defined( 'OPENMIGRATEME_PLUGIN_NAME' ) ) {
			if ( is_multisite() ) {
				add_action( 'network_admin_notices', array( $this, 'multisite_notice' ) );
			} else {
				add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			}
		} else {
			if ( is_multisite() ) {
				add_action( 'network_admin_menu', array( $this, 'admin_menu' ) );
			} else {
				add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			}
		}

		// Add HTTP export headers
		add_filter( 'openmigrate_http_export_headers', 'openmigrate_auth_headers' );

		// Add HTTP import headers
		add_filter( 'openmigrate_http_import_headers', 'openmigrate_auth_headers' );

		// Add chunk size limit
		add_filter( 'openmigrate_max_chunk_size', 'OpenMigrate_Import_Controller::max_chunk_size' );

		// Add storage folder daily cleanup cron
		add_action( 'openmigrate_storage_cleanup', 'OpenMigrate_Export_Controller::cleanup' );

		// Register REST API routes
		if ( defined( 'OPENMIGRATE_REST_ENABLED' ) && OPENMIGRATE_REST_ENABLED ) {
			add_action( 'rest_api_init', 'OpenMigrate_Rest_Controller::register_routes' );

			// Let a valid secret_key authenticate read-only poll/log routes after an import wipes user credentials
			add_filter( 'rest_authentication_errors', 'OpenMigrate_Rest_Controller::allow_secret_key_auth', 1000 );
		}
	}

	/**
	 * WP CLI commands
	 *
	 * @return void
	 */
	public function cli_init() {
		if ( defined( 'WP_CLI' ) ) {
			WP_CLI::add_command( 'openmigrate', 'OpenMigrate_WP_CLI_Command', array( 'shortdesc' => __( 'Open Migrate commands', 'open-migrate' ) ) );

			// Legacy alias, only when the original plugin is not active
			if ( ! defined( 'AI1WM_PLUGIN_NAME' ) ) {
				WP_CLI::add_command( 'ai1wm', 'OpenMigrate_WP_CLI_Command', array( 'shortdesc' => __( 'Open Migrate commands (alias)', 'open-migrate' ) ) );
			}
		}
	}

	/**
	 * Create backups folder with index.php, index.html, .htaccess and web.config files
	 *
	 * @return void
	 */
	public function setup_backups_folder() {
		$this->create_backups_folder( OPENMIGRATE_BACKUPS_PATH );
		$this->create_backups_htaccess( OPENMIGRATE_BACKUPS_HTACCESS );
		$this->create_backups_webconfig( OPENMIGRATE_BACKUPS_WEBCONFIG );
		$this->create_backups_index_php( OPENMIGRATE_BACKUPS_INDEX_PHP );
		$this->create_backups_index_html( OPENMIGRATE_BACKUPS_INDEX_HTML );
		$this->create_backups_robots_txt( OPENMIGRATE_BACKUPS_ROBOTS_TXT );
	}

	/**
	 * Create storage folder with index.php and index.html files
	 *
	 * @return void
	 */
	public function setup_storage_folder() {
		$this->create_storage_folder( OPENMIGRATE_STORAGE_PATH );
		$this->create_storage_htaccess( OPENMIGRATE_STORAGE_HTACCESS );
		$this->create_storage_webconfig( OPENMIGRATE_STORAGE_WEBCONFIG );
		$this->create_storage_index_php( OPENMIGRATE_STORAGE_INDEX_PHP );
		$this->create_storage_index_html( OPENMIGRATE_STORAGE_INDEX_HTML );
	}

	/**
	 * Create secret key if they don't exist yet
	 *
	 * @return void
	 */
	public function setup_secret_key() {
		if ( ! get_option( OPENMIGRATE_SECRET_KEY ) ) {
			update_option( OPENMIGRATE_SECRET_KEY, openmigrate_generate_random_string( 12 ) );
		}
	}

	/**
	 * Warn about a 32-bit PHP and about the original plugin being active at the same time
	 *
	 * @return void
	 */
	public function environment_notices() {
		$screen = get_current_screen();
		if ( ! $screen || strpos( (string) $screen->id, 'openmigrate_' ) === false ) {
			return;
		}

		if ( PHP_INT_SIZE < 8 ) {
			echo '<div class="notice notice-warning"><p>' . esc_html__( 'Open Migrate: this PHP is 32-bit, so backups larger than 2 GB cannot be handled. Use a 64-bit PHP.', 'open-migrate' ) . '</p></div>';
		}

		if ( defined( 'AI1WM_PLUGIN_NAME' ) ) {
			echo '<div class="notice notice-info"><p>' . esc_html__( 'The original All-in-One WP Migration is also active. Both plugins share the same backups folder; avoid running an export or import in both at the same time.', 'open-migrate' ) . '</p></div>';
		}
	}

	/**
	 * Check auto increment
	 *
	 * @return void
	 */
	public function check_auto_increment() {
		global $wpdb;

		$db_client = OpenMigrate_Database_Utility::get_client();
		if ( ! $db_client->has_auto_increment( $wpdb->options ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'missing_auto_increment' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'missing_auto_increment' ) );
			}
		}
	}

	/**
	 * Check user role capability
	 *
	 * Only administrators are warned. is_super_admin() covers both installs: the
	 * super admin list on multisite, and delete_users, meaning an administrator, on
	 * a standalone install.
	 *
	 * @return void
	 */
	public function check_user_role_capability() {
		if ( is_super_admin() ) {
			if ( ! ( current_user_can( 'openmigrate_export_site' ) || current_user_can( 'openmigrate_import_site' ) ) ) {
				if ( is_multisite() ) {
					return add_action( 'network_admin_notices', array( $this, 'missing_role_capability_notice' ) );
				} else {
					return add_action( 'admin_notices', array( $this, 'missing_role_capability_notice' ) );
				}
			}
		}
	}

	/**
	 * Schedule cron tasks for plugin operation, if not done yet
	 *
	 * @return void
	 */
	public function schedule_crons() {
		if ( ! OpenMigrate_Cron::exists( 'openmigrate_storage_cleanup' ) ) {
			OpenMigrate_Cron::add( 'openmigrate_storage_cleanup', 'daily', time() );
		}

		OpenMigrate_Cron::clear( 'openmigrate_cleanup_cron' );
	}

	/**
	 * Create storage folder
	 *
	 * @param  string Path to folder
	 * @return void
	 */
	public function create_storage_folder( $path ) {
		if ( ! OpenMigrate_Directory::create( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'storage_path_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'storage_path_notice' ) );
			}
		}
	}

	/**
	 * Create backups folder
	 *
	 * @param  string Path to folder
	 * @return void
	 */
	public function create_backups_folder( $path ) {
		if ( ! OpenMigrate_Directory::create( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'backups_path_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'backups_path_notice' ) );
			}
		}
	}

	/**
	 * Create storage .htaccess file
	 *
	 * @param  string Path to file
	 * @return void
	 */
	public function create_storage_htaccess( $path ) {
		if ( ! OpenMigrate_File_Htaccess::storage( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'storage_htaccess_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'storage_htaccess_notice' ) );
			}
		}
	}

	/**
	 * Create storage web.config file
	 *
	 * @param  string Path to file
	 * @return void
	 */
	public function create_storage_webconfig( $path ) {
		if ( ! OpenMigrate_File_Webconfig::storage( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'storage_webconfig_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'storage_webconfig_notice' ) );
			}
		}
	}

	/**
	 * Create storage index.php file
	 *
	 * @param  string Path to file
	 * @return void
	 */
	public function create_storage_index_php( $path ) {
		if ( ! OpenMigrate_File_Index::create( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'storage_index_php_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'storage_index_php_notice' ) );
			}
		}
	}

	/**
	 * Create storage index.html file
	 *
	 * @param  string Path to file
	 * @return void
	 */
	public function create_storage_index_html( $path ) {
		if ( ! OpenMigrate_File_Index::create( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'storage_index_html_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'storage_index_html_notice' ) );
			}
		}
	}

	/**
	 * Create backups .htaccess file
	 *
	 * @param  string Path to file
	 * @return void
	 */
	public function create_backups_htaccess( $path ) {
		if ( ! OpenMigrate_File_Htaccess::backups( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'backups_htaccess_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'backups_htaccess_notice' ) );
			}
		}
	}

	/**
	 * Create backups web.config file
	 *
	 * @param  string Path to file
	 * @return void
	 */
	public function create_backups_webconfig( $path ) {
		if ( ! OpenMigrate_File_Webconfig::backups( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'backups_webconfig_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'backups_webconfig_notice' ) );
			}
		}
	}

	/**
	 * Create backups index.php file
	 *
	 * @param  string Path to file
	 * @return void
	 */
	public function create_backups_index_php( $path ) {
		if ( ! OpenMigrate_File_Index::create( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'backups_index_php_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'backups_index_php_notice' ) );
			}
		}
	}

	/**
	 * Create backups index.html file
	 *
	 * @param  string Path to file
	 * @return void
	 */
	public function create_backups_index_html( $path ) {
		if ( ! OpenMigrate_File_Index::create( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'backups_index_html_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'backups_index_html_notice' ) );
			}
		}
	}

	/**
	 * Create backups robots.txt file
	 *
	 * @param  string Path to file
	 * @return void
	 */
	public function create_backups_robots_txt( $path ) {
		if ( ! OpenMigrate_File_Robots::create( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'backups_robots_txt_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'backups_robots_txt_notice' ) );
			}
		}
	}

	/**
	 * If the "noabort" environment variable has been set,
	 * the script will continue to run even though the connection has been broken
	 *
	 * @return void
	 */
	public function create_litespeed_htaccess( $path ) {
		if ( ! OpenMigrate_File_Htaccess::litespeed( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'wordpress_htaccess_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'wordpress_htaccess_notice' ) );
			}
		}
	}

	/**
	 * Display multisite notice
	 *
	 * @return void
	 */
	public function multisite_notice() {
		OpenMigrate_Template::render( 'main/multisite-notice' );
	}

	/**
	 * Display notice for storage directory
	 *
	 * @return void
	 */
	public function storage_path_notice() {
		OpenMigrate_Template::render( 'main/storage-path-notice' );
	}

	/**
	 * Display notice for .htaccess file in storage directory
	 *
	 * @return void
	 */
	public function storage_htaccess_notice() {
		OpenMigrate_Template::render( 'main/storage-htaccess-notice' );
	}

	/**
	 * Display notice for web.config file in storage directory
	 *
	 * @return void
	 */
	public function storage_webconfig_notice() {
		OpenMigrate_Template::render( 'main/storage-webconfig-notice' );
	}

	/**
	 * Display notice for index.php file in storage directory
	 *
	 * @return void
	 */
	public function storage_index_php_notice() {
		OpenMigrate_Template::render( 'main/storage-index-php-notice' );
	}

	/**
	 * Display notice for index.html file in storage directory
	 *
	 * @return void
	 */
	public function storage_index_html_notice() {
		OpenMigrate_Template::render( 'main/storage-index-html-notice' );
	}

	/**
	 * Display notice for backups directory
	 *
	 * @return void
	 */
	public function backups_path_notice() {
		OpenMigrate_Template::render( 'main/backups-path-notice' );
	}

	/**
	 * Display notice for .htaccess file in backups directory
	 *
	 * @return void
	 */
	public function backups_htaccess_notice() {
		OpenMigrate_Template::render( 'main/backups-htaccess-notice' );
	}

	/**
	 * Display notice for web.config file in backups directory
	 *
	 * @return void
	 */
	public function backups_webconfig_notice() {
		OpenMigrate_Template::render( 'main/backups-webconfig-notice' );
	}

	/**
	 * Display notice for index.php file in backups directory
	 *
	 * @return void
	 */
	public function backups_index_php_notice() {
		OpenMigrate_Template::render( 'main/backups-index-php-notice' );
	}

	/**
	 * Display notice for index.html file in backups directory
	 *
	 * @return void
	 */
	public function backups_index_html_notice() {
		OpenMigrate_Template::render( 'main/backups-index-html-notice' );
	}

	/**
	 * Display notice for robots.txt file in backups directory
	 *
	 * @return void
	 */
	public function backups_robots_txt_notice() {
		OpenMigrate_Template::render( 'main/backups-robots-txt-notice' );
	}

	/**
	 * Display notice for .htaccess file in WordPress directory
	 *
	 * @return void
	 */
	public function wordpress_htaccess_notice() {
		OpenMigrate_Template::render( 'main/wordpress-htaccess-notice' );
	}

	/**
	 * Display notice for missing auto increment
	 *
	 * @return void
	 */
	public function missing_auto_increment() {
		OpenMigrate_Template::render( 'main/missing-auto-increment' );
	}

	/**
	 * Display notice for missing role capability
	 *
	 * @return void
	 */
	public function missing_role_capability_notice() {
		OpenMigrate_Template::render( 'main/missing-role-capability-notice' );
	}

	/**
	 * Register plugin menus
	 *
	 * @return void
	 */
	public function admin_menu() {
		add_menu_page(
			'Open Migrate',
			'Open Migrate',
			'openmigrate_export_site',
			'openmigrate_export',
			'OpenMigrate_Export_Controller::index',
			'',
			'76.295'
		);

		add_submenu_page(
			'openmigrate_export',
			__( 'Export', 'open-migrate' ),
			__( 'Export', 'open-migrate' ),
			'openmigrate_export_site',
			'openmigrate_export',
			'OpenMigrate_Export_Controller::index'
		);

		add_submenu_page(
			'openmigrate_export',
			__( 'Import', 'open-migrate' ),
			__( 'Import', 'open-migrate' ),
			'openmigrate_import_site',
			'openmigrate_import',
			'OpenMigrate_Import_Controller::index'
		);

		add_submenu_page(
			'openmigrate_export',
			__( 'Backups', 'open-migrate' ),
			__( 'Backups', 'open-migrate' ) . ' ' . OpenMigrate_Template::get_content( 'main/backups', array( 'count' => OpenMigrate_Backups::count_files() ) ),
			'openmigrate_import_site',
			'openmigrate_backups',
			'OpenMigrate_Backups_Controller::index'
		);
	}

	/**
	 * Register ServMask scripts and styles
	 *
	 * @return void
	 */
	public function register_servmask_scripts_and_styles() {
		openmigrate_register_style(
			'openmigrate_servmask',
			OpenMigrate_Template::asset_link( 'css/servmask.min.css' )
		);

		openmigrate_register_script(
			'openmigrate_util',
			OpenMigrate_Template::asset_link( 'javascript/util.min.js' ),
			array( 'jquery' ),
			OPENMIGRATE_VERSION,
			false
		);

		openmigrate_register_script(
			'openmigrate_servmask',
			false,
			array( 'openmigrate_util' ),
			OPENMIGRATE_VERSION,
			false
		);

		wp_localize_script(
			'openmigrate_servmask',
			'openmigrate_locale',
			array(
				// Export
				'stop_exporting_your_website'         => __( 'Are you sure you want to stop the export?', 'open-migrate' ),
				'preparing_to_export'                 => __( 'Preparing to export...', 'open-migrate' ),
				'unable_to_export'                    => __( 'Export failed', 'open-migrate' ),
				'unable_to_start_the_export'          => __( 'Could not start the export. Please refresh and try again.', 'open-migrate' ),
				'unable_to_run_the_export'            => __( 'Could not run the export. Please refresh and try again.', 'open-migrate' ),
				'unable_to_stop_the_export'           => __( 'Could not stop the export. Please refresh and try again.', 'open-migrate' ),
				'please_wait_stopping_the_export'     => __( 'Stopping the export, please wait...', 'open-migrate' ),
				'close_export'                        => __( 'Close', 'open-migrate' ),
				'stop_export'                         => __( 'Stop export', 'open-migrate' ),
				/* translators: 1: Number of backups. */
				'backups_count_singular'              => __( 'You have %d backup', 'open-migrate' ),
				/* translators: 1: Number of backups. */
				'backups_count_plural'                => __( 'You have %d backups', 'open-migrate' ),
				'archive_browser_download_error'      => __( 'Could not download backup', 'open-migrate' ),
				'view_error_log_button'               => __( 'View Error Log', 'open-migrate' ),

				// Import
				'stop_importing_your_website'         => __( 'Are you sure you want to stop the import?', 'open-migrate' ),
				'preparing_to_import'                 => __( 'Preparing to import...', 'open-migrate' ),
				'unable_to_import'                    => __( 'Import failed', 'open-migrate' ),
				'unable_to_start_the_import'          => __( 'Could not start the import. Please refresh and try again.', 'open-migrate' ),
				'unable_to_confirm_the_import'        => __( 'Could not confirm the import. Please refresh and try again.', 'open-migrate' ),
				'unable_to_check_decryption_password' => __( 'Could not check the decryption password. Please refresh and try again.', 'open-migrate' ),
				'unable_to_prepare_blogs_on_import'   => __( 'Could not prepare blogs for import. Please refresh and try again.', 'open-migrate' ),
				'unable_to_stop_the_import'           => __( 'Could not stop the import. Please refresh and try again.', 'open-migrate' ),
				'please_wait_stopping_the_import'     => __( 'Stopping the import, please wait...', 'open-migrate' ),
				'close_import'                        => __( 'Close', 'open-migrate' ),
				'stop_import'                         => __( 'Stop import', 'open-migrate' ),
				'finish_import'                       => __( 'Finish', 'open-migrate' ),
				'confirm_import'                      => __( 'Proceed', 'open-migrate' ),
				'confirm_disk_space'                  => __( 'I have enough disk space', 'open-migrate' ),
				'continue_import'                     => __( 'Continue', 'open-migrate' ),
				'please_do_not_close_this_browser'    => __( 'Please do not close this browser window or your import will fail', 'open-migrate' ),
				'backup_encrypted'                    => __( 'The backup is encrypted', 'open-migrate' ),
				'backup_encrypted_message'            => __( 'Please enter a password to restore the backup', 'open-migrate' ),
				'unlock'                              => __( 'Unlock', 'open-migrate' ),
				'enter_password'                      => __( 'Enter a password', 'open-migrate' ),
				'repeat_password'                     => __( 'Repeat the password', 'open-migrate' ),
				'passwords_do_not_match'              => __( 'The passwords do not match', 'open-migrate' ),
				'upload_failed_connection_lost'       => __( 'Upload failed - connection lost or timeout. Try uploading the file again.', 'open-migrate' ),
				'upload_failed'                       => __( 'Upload failed', 'open-migrate' ),
				/* translators: Disk space to free up. */
				'out_of_disk_space'                   => __( 'Not enough disk space.<br /> Free up %s before restoring.', 'open-migrate' ),
				'invalid_archive_extension'           => __( 'Invalid file type. Please ensure that your file is a <strong>.wpress</strong> backup.', 'open-migrate' ),

				// Backups
				'want_to_delete_this_file'            => __( 'Are you sure you want to delete this backup?', 'open-migrate' ),
				'want_to_delete_selected_singular'    => __( 'Are you sure you want to delete %d selected backup?', 'open-migrate' ),
				'want_to_delete_selected_plural'      => __( 'Are you sure you want to delete %d selected backups?', 'open-migrate' ),
				'delete_selected'                     => __( 'Delete (%d selected)', 'open-migrate' ),
				'session_expired'                     => __( 'Your session has expired. The page will reload so you can log in again.', 'open-migrate' ),
				'archive_browser_error'               => __( 'Error', 'open-migrate' ),
				'archive_browser_list_error'          => __( 'Could not read backup content', 'open-migrate' ),
				'archive_browser_title'               => __( 'List the content of the backup', 'open-migrate' ),
				'progress_bar_title'                  => __( 'Reading...', 'open-migrate' ),
				'close_encryption'                    => __( 'Close', 'open-migrate' ),
				'check_encryption'                    => __( 'Submit', 'open-migrate' ),
			)
		);
	}

	/**
	 * Register export scripts and styles
	 *
	 * @return void
	 */
	public function register_export_scripts_and_styles() {
		openmigrate_register_style(
			'openmigrate_export',
			OpenMigrate_Template::asset_link( 'css/export.min.css' )
		);

		openmigrate_register_script(
			'openmigrate_export',
			OpenMigrate_Template::asset_link( 'javascript/export.min.js' ),
			array( 'openmigrate_servmask' ),
			OPENMIGRATE_VERSION,
			false
		);

		wp_localize_script(
			'openmigrate_export',
			'openmigrate_export',
			array(
				'ajax'            => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_export' ) ) ),
				),
				'download_backup' => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_backup_download_backup' ) ) ),
				),
				'status'          => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1, 'secret_key' => get_option( OPENMIGRATE_SECRET_KEY ) ), admin_url( 'admin-ajax.php?action=openmigrate_status' ) ) ),
				),
				'storage'         => array(
					'url' => OPENMIGRATE_STORAGE_URL,
				),
				'error_log'       => array(
					'pattern' => OPENMIGRATE_ERROR_NAME,
				),
				'secret_key'      => get_option( OPENMIGRATE_SECRET_KEY ),
			)
		);
	}

	/**
	 * Register import scripts and styles
	 *
	 * @return void
	 */
	public function register_import_scripts_and_styles() {
		openmigrate_register_style(
			'openmigrate_import',
			OpenMigrate_Template::asset_link( 'css/import.min.css' )
		);

		openmigrate_register_script(
			'openmigrate_import',
			OpenMigrate_Template::asset_link( 'javascript/import.min.js' ),
			array( 'openmigrate_servmask' ),
			OPENMIGRATE_VERSION,
			false
		);

		wp_localize_script(
			'openmigrate_import',
			'openmigrate_uploader',
			array(
				'url'           => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1, 'openmigrate_manual_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_import' ) ) ),
				'chunk_size'    => max( 65536, (int) apply_filters( 'openmigrate_max_chunk_size', OPENMIGRATE_MAX_CHUNK_SIZE ) - 65536 ),
				'params'        => array(
					'priority'   => 5,
					'secret_key' => get_option( OPENMIGRATE_SECRET_KEY ),
				),
			)
		);

		wp_localize_script(
			'openmigrate_import',
			'openmigrate_import',
			array(
				'ajax'       => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_import' ) ) ),
				),
				'status'     => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1, 'secret_key' => get_option( OPENMIGRATE_SECRET_KEY ) ), admin_url( 'admin-ajax.php?action=openmigrate_status' ) ) ),
				),
				'storage'    => array(
					'url' => OPENMIGRATE_STORAGE_URL,
				),
				'error_log'  => array(
					'pattern' => OPENMIGRATE_ERROR_NAME,
				),
				'secret_key' => get_option( OPENMIGRATE_SECRET_KEY ),
			)
		);

		wp_localize_script(
			'openmigrate_import',
			'openmigrate_compatibility',
			array(
				'messages' => array(),
			)
		);

		wp_localize_script(
			'openmigrate_import',
			'openmigrate_disk_space',
			array(
				'free'   => openmigrate_disk_free_space( OPENMIGRATE_STORAGE_PATH ),
				'factor' => OPENMIGRATE_DISK_SPACE_FACTOR,
				'extra'  => OPENMIGRATE_DISK_SPACE_EXTRA,
			)
		);
	}

	/**
	 * Register backups scripts and styles
	 *
	 * @return void
	 */
	public function register_backups_scripts_and_styles() {
		openmigrate_register_style(
			'openmigrate_backups',
			OpenMigrate_Template::asset_link( 'css/backups.min.css' )
		);

		openmigrate_register_script(
			'openmigrate_restore',
			OpenMigrate_Template::asset_link( 'javascript/restore.js' ),
			array( 'openmigrate_import' ),
			OPENMIGRATE_VERSION,
			false
		);

		openmigrate_register_script(
			'openmigrate_chunk_upload',
			OpenMigrate_Template::asset_link( 'javascript/chunk-upload.js' ),
			array( 'openmigrate_import' ),
			OPENMIGRATE_VERSION,
			false
		);

		openmigrate_register_script(
			'openmigrate_backups',
			OpenMigrate_Template::asset_link( 'javascript/backups.min.js' ),
			array( 'openmigrate_export', 'openmigrate_import', 'openmigrate_restore' ),
			OPENMIGRATE_VERSION,
			false
		);

		wp_localize_script(
			'openmigrate_backups',
			'openmigrate_backups',
			array(
				'clean'            => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_backup_clean' ) ) ),
				),
				'delete'           => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_backup_delete' ) ) ),
				),
				'list'             => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_backup_list' ) ) ),
				),
				'add_label'        => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_backup_add_label' ) ) ),
				),
				'get_config'       => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_backup_get_config' ) ) ),
				),
				'check_encryption' => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_backup_check_encryption' ) ) ),
				),
				'list_content'     => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_backup_list_content' ) ) ),
				),
				'download_file'    => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_backup_download_file' ) ) ),
				),
				'download_backup'  => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'openmigrate_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_backup_download_backup' ) ) ),
				),
				'secret_key'       => get_option( OPENMIGRATE_SECRET_KEY ),
			)
		);
	}

	/**
	 * Enqueue scripts and styles for Export Controller
	 *
	 * @param  string $hook Hook suffix
	 * @return void
	 */
	public function enqueue_export_scripts_and_styles( $hook ) {
		if ( stripos( 'toplevel_page_openmigrate_export', $hook ) === false ) {
			return;
		}

		// We don't want heartbeat to occur when exporting
		wp_deregister_script( 'heartbeat' );

		// We don't want auth check for monitoring whether the user is still logged in
		remove_action( 'admin_enqueue_scripts', 'wp_auth_check_load' );

		// Load scripts and styles
		openmigrate_enqueue_style( 'openmigrate_export' );
		openmigrate_enqueue_script( 'openmigrate_export' );
	}

	/**
	 * Enqueue scripts and styles for Import Controller
	 *
	 * @param  string $hook Hook suffix
	 * @return void
	 */
	public function enqueue_import_scripts_and_styles( $hook ) {
		if ( stripos( 'open-migrate_page_openmigrate_import', $hook ) === false ) {
			return;
		}

		// We don't want heartbeat to occur when importing
		wp_deregister_script( 'heartbeat' );

		// We don't want auth check for monitoring whether the user is still logged in
		remove_action( 'admin_enqueue_scripts', 'wp_auth_check_load' );

		// Load scripts and styles
		openmigrate_enqueue_style( 'openmigrate_import' );
		openmigrate_enqueue_script( 'openmigrate_import' );
		openmigrate_enqueue_script( 'openmigrate_chunk_upload' );
	}

	/**
	 * Enqueue scripts and styles for Backups Controller
	 *
	 * @param  string $hook Hook suffix
	 * @return void
	 */
	public function enqueue_backups_scripts_and_styles( $hook ) {
		if ( stripos( 'open-migrate_page_openmigrate_backups', $hook ) === false ) {
			return;
		}

		// We don't want heartbeat to occur when restoring
		wp_deregister_script( 'heartbeat' );

		// We don't want auth check for monitoring whether the user is still logged in
		remove_action( 'admin_enqueue_scripts', 'wp_auth_check_load' );

		// Load scripts and styles
		openmigrate_enqueue_style( 'openmigrate_backups' );
		openmigrate_enqueue_script( 'openmigrate_backups' );
	}

	/**
	 * Outputs menu icon between head tags
	 *
	 * @return void
	 */
	public function admin_head() {
		global $wp_version;

		// Admin header
		OpenMigrate_Template::render( 'main/admin-head', array( 'version' => $wp_version ) );
	}

	/**
	 * Register initial parameters
	 *
	 * @return void
	 */
	public function init() {
		// Capture the HTTP Basic credentials so a loopback export/import/reset can replay them past
		// a server-level auth wall. Restrict the capture to a user who can run a migration: init()
		// runs on admin_init, which also fires on admin-ajax.php and admin-post.php requests that
		// have not authenticated.
		if ( current_user_can( 'openmigrate_export_site' ) || current_user_can( 'openmigrate_import_site' ) ) {
			$user = $password = false;

			// Set username
			if ( isset( $_SERVER['PHP_AUTH_USER'] ) ) {
				$user = $_SERVER['PHP_AUTH_USER'];
			} elseif ( isset( $_SERVER['REMOTE_USER'] ) ) {
				$user = $_SERVER['REMOTE_USER'];
			}

			// Set password
			if ( isset( $_SERVER['PHP_AUTH_PW'] ) ) {
				$password = $_SERVER['PHP_AUTH_PW'];
			}

			if ( $user !== false && $password !== false ) {
				update_option( OPENMIGRATE_AUTH_HEADER, base64_encode( sprintf( '%s:%s', $user, $password ) ) );
			}
		}
	}

	/**
	 * Register initial router
	 *
	 * @return void
	 */
	public function router() {
		// Public actions
		add_action( 'wp_ajax_nopriv_openmigrate_export', 'OpenMigrate_Export_Controller::export' );
		add_action( 'wp_ajax_nopriv_openmigrate_import', 'OpenMigrate_Import_Controller::import' );
		add_action( 'wp_ajax_nopriv_openmigrate_status', 'OpenMigrate_Status_Controller::status' );

		// Private actions
		add_action( 'wp_ajax_openmigrate_export', 'OpenMigrate_Export_Controller::export' );
		add_action( 'wp_ajax_openmigrate_import', 'OpenMigrate_Import_Controller::import' );
		add_action( 'wp_ajax_openmigrate_status', 'OpenMigrate_Status_Controller::status' );

		if ( current_user_can( 'openmigrate_import_site' ) ) {
			add_action( 'wp_ajax_openmigrate_backup_clean', 'OpenMigrate_Backups_Controller::clean' );
			add_action( 'wp_ajax_openmigrate_backup_delete', 'OpenMigrate_Backups_Controller::delete' );
			add_action( 'wp_ajax_openmigrate_backup_list', 'OpenMigrate_Backups_Controller::backup_list' );
			add_action( 'wp_ajax_openmigrate_backup_get_config', 'OpenMigrate_Backups_Controller::backup_get_config' );
			add_action( 'wp_ajax_openmigrate_backup_check_encryption', 'OpenMigrate_Backups_Controller::backup_check_encryption' );
			add_action( 'wp_ajax_openmigrate_backup_list_content', 'OpenMigrate_Backups_Controller::backup_list_content' );
			add_action( 'wp_ajax_openmigrate_backup_add_label', 'OpenMigrate_Backups_Controller::add_label' );
			add_action( 'wp_ajax_openmigrate_backup_download_file', 'OpenMigrate_Backups_Controller::download_file' );
		}

		if ( current_user_can( 'openmigrate_export_site' ) || current_user_can( 'openmigrate_import_site' ) ) {
			add_action( 'wp_ajax_openmigrate_backup_download_backup', 'OpenMigrate_Backups_Controller::download_backup' );
		}
	}

	/**
	 * Enable WP importing
	 *
	 * @return void
	 */
	public function wp_importing() {
		if ( isset( $_GET['openmigrate_import'] ) ) {
			if ( ! defined( 'WP_IMPORTING' ) ) {
				define( 'WP_IMPORTING', true );
			}
		}
	}

	/**
	 * Add custom cron schedules
	 *
	 * @param  array $schedules List of schedules
	 * @return array
	 */
	public function add_cron_schedules( $schedules ) {
		$schedules['weekly']  = array(
			'display'  => __( 'Weekly', 'open-migrate' ),
			'interval' => 60 * 60 * 24 * 7,
		);
		$schedules['monthly'] = array(
			'display'  => __( 'Monthly', 'open-migrate' ),
			'interval' => ( strtotime( '+1 month' ) - time() ),
		);

		return $schedules;
	}

	/**
	 * Add map meta capabilities
	 *
	 * @param  array<int, string> $caps    Primitive capabilities required of the user
	 * @param  string             $cap     Capability being checked
	 * @param  int                $user_id The user ID
	 * @param  array<int, mixed>  $args    Adds context to the capability check, typically starting with an object ID
	 * @return array<int, string>
	 */
	public function add_map_meta_cap( $caps, $cap, $user_id, $args ) {
		if ( $cap === 'openmigrate_export_site' ) {
			if ( is_multisite() ) {
				return array( 'export', 'manage_network' );
			}

			return array( 'export', 'manage_options' );
		}

		if ( $cap === 'openmigrate_import_site' ) {
			if ( is_multisite() ) {
				return array( 'import', 'manage_network' );
			}

			return array( 'import', 'manage_options' );
		}

		return $caps;
	}

	/**
	 * Handles openmigrate_status_export_error hook
	 *
	 * @param $params
	 * @param $exception
	 *
	 * @return void
	 */
	public function handle_error_cleanup( $params, $exception = null ) {
		OpenMigrate_Directory::delete( openmigrate_storage_path( $params ) );
	}
}
