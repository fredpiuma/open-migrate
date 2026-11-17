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

// ================
// = Plugin Debug =
// ================
define( 'OPENMIGRATE_DEBUG', false );

// ==================
// = Plugin Version =
// ==================
define( 'OPENMIGRATE_VERSION', '1.0.0' );

// ================================
// = Upstream Version (compat)    =
// ================================
define( 'OPENMIGRATE_UPSTREAM_VERSION', '7.113' );

// ===============
// = Plugin Name =
// ===============
define( 'OPENMIGRATE_PLUGIN_NAME', 'open-migrate' );

// ================
// = Storage Path =
// ================
define( 'OPENMIGRATE_STORAGE_PATH', OPENMIGRATE_PATH . DIRECTORY_SEPARATOR . 'storage' );

// ==================
// = Error Log Path =
// ==================
define( 'OPENMIGRATE_ERROR_FILE', OPENMIGRATE_STORAGE_PATH . DIRECTORY_SEPARATOR . 'error.log' );

// ===============
// = Status Path =
// ===============
define( 'OPENMIGRATE_STATUS_FILE', OPENMIGRATE_STORAGE_PATH . DIRECTORY_SEPARATOR . 'status.js' );

// ============
// = Lib Path =
// ============
define( 'OPENMIGRATE_LIB_PATH', OPENMIGRATE_PATH . DIRECTORY_SEPARATOR . 'lib' );

// ===================
// = Controller Path =
// ===================
define( 'OPENMIGRATE_CONTROLLER_PATH', OPENMIGRATE_LIB_PATH . DIRECTORY_SEPARATOR . 'controller' );

// ==============
// = Model Path =
// ==============
define( 'OPENMIGRATE_MODEL_PATH', OPENMIGRATE_LIB_PATH . DIRECTORY_SEPARATOR . 'model' );

// =============
// = View Path =
// =============
define( 'OPENMIGRATE_TEMPLATES_PATH', OPENMIGRATE_LIB_PATH . DIRECTORY_SEPARATOR . 'view' );

// ===================
// = Set Bandar Path =
// ===================
define( 'OPENMIGRATE_BANDAR_TEMPLATES_PATH', OPENMIGRATE_TEMPLATES_PATH );

// ===============
// = Vendor Path =
// ===============
define( 'OPENMIGRATE_VENDOR_PATH', OPENMIGRATE_LIB_PATH . DIRECTORY_SEPARATOR . 'vendor' );

// =========================
// = ServMask Table Prefix =
// =========================
define( 'OPENMIGRATE_TABLE_PREFIX', 'SERVMASK_PREFIX_' );

// ========================
// = Archive Backups Name =
// ========================
define( 'OPENMIGRATE_BACKUPS_NAME', 'ai1wm-backups' );

// =========================
// = Archive Database Name =
// =========================
define( 'OPENMIGRATE_DATABASE_NAME', 'database.sql' );

// ========================
// = Archive Package Name =
// ========================
define( 'OPENMIGRATE_PACKAGE_NAME', 'package.json' );

// ==========================
// = Archive Multisite Name =
// ==========================
define( 'OPENMIGRATE_MULTISITE_NAME', 'multisite.json' );

// ======================
// = Archive Blogs Name =
// ======================
define( 'OPENMIGRATE_BLOGS_NAME', 'blogs.json' );

// =========================
// = Archive Settings Name =
// =========================
define( 'OPENMIGRATE_SETTINGS_NAME', 'settings.json' );

// ==========================
// = Archive Multipart Name =
// ==========================
define( 'OPENMIGRATE_MULTIPART_NAME', 'multipart.list' );

// =============================
// = Archive Content List Name =
// =============================
define( 'OPENMIGRATE_CONTENT_LIST_NAME', 'content.list' );

// ===========================
// = Archive Media List Name =
// ===========================
define( 'OPENMIGRATE_MEDIA_LIST_NAME', 'media.list' );

// =============================
// = Archive Plugins List Name =
// =============================
define( 'OPENMIGRATE_PLUGINS_LIST_NAME', 'plugins.list' );

// ============================
// = Archive Themes List Name =
// ============================
define( 'OPENMIGRATE_THEMES_LIST_NAME', 'themes.list' );

// ============================
// = Archive Tables List Name =
// ============================
define( 'OPENMIGRATE_TABLES_LIST_NAME', 'tables.list' );

// =================================
// = Incremental Content List Name =
// =================================
define( 'OPENMIGRATE_INCREMENTAL_CONTENT_LIST_NAME', 'incremental.content.list' );

// ===============================
// = Incremental Media List Name =
// ===============================
define( 'OPENMIGRATE_INCREMENTAL_MEDIA_LIST_NAME', 'incremental.media.list' );

// =================================
// = Incremental Plugins List Name =
// =================================
define( 'OPENMIGRATE_INCREMENTAL_PLUGINS_LIST_NAME', 'incremental.plugins.list' );

// ================================
// = Incremental Themes List Name =
// ================================
define( 'OPENMIGRATE_INCREMENTAL_THEMES_LIST_NAME', 'incremental.themes.list' );

// =================================
// = Incremental Backups List Name =
// =================================
define( 'OPENMIGRATE_INCREMENTAL_BACKUPS_LIST_NAME', 'incremental.backups.list' );

// =============================
// = Archive Cookies Text Name =
// =============================
define( 'OPENMIGRATE_COOKIES_NAME', 'cookies.txt' );

// =================================
// = Archive Must-Use Plugins Name =
// =================================
define( 'OPENMIGRATE_MUPLUGINS_NAME', 'mu-plugins' );

// ========================
// = Less Cache Extension =
// ========================
define( 'OPENMIGRATE_LESS_CACHE_EXTENSION', '.less.cache' );

// =============================
// = SQLite Database Extension =
// =============================
define( 'OPENMIGRATE_SQLITE_DATABASE_EXTENSION', '.sqlite' );

// =============================
// = SQLite Database Path Name =
// =============================
define( 'OPENMIGRATE_SQLITE_DATABASE_PATH_NAME', 'database' . DIRECTORY_SEPARATOR . 'db-path.php' );

// ============================
// = Elementor CSS Cache Name =
// ============================
define( 'OPENMIGRATE_ELEMENTOR_CSS_NAME', 'uploads' . DIRECTORY_SEPARATOR . 'elementor' . DIRECTORY_SEPARATOR . 'css' );

// =========================
// = CiviCRM Settings Name =
// =========================
define( 'OPENMIGRATE_CIVICRM_SETTINGS_NAME', 'uploads' . DIRECTORY_SEPARATOR . 'civicrm' . DIRECTORY_SEPARATOR . 'civicrm.settings.php' );

// ============================
// = CiviCRM Templates C Name =
// ============================
define( 'OPENMIGRATE_CIVICRM_TEMPLATES_C_NAME', 'uploads' . DIRECTORY_SEPARATOR . 'civicrm' . DIRECTORY_SEPARATOR . 'templates_c' );

// ===============================
// = CiviCRM Config And Log Name =
// ===============================
define( 'OPENMIGRATE_CIVICRM_CONFIG_AND_LOG_NAME', 'uploads' . DIRECTORY_SEPARATOR . 'civicrm' . DIRECTORY_SEPARATOR . 'ConfigAndLog' );

// =======================
// = CiviCRM Upload Name =
// =======================
define( 'OPENMIGRATE_CIVICRM_UPLOAD_NAME', 'uploads' . DIRECTORY_SEPARATOR . 'civicrm' . DIRECTORY_SEPARATOR . 'upload' );

// ========================
// = CiviCRM Dynamic Name =
// ========================
define( 'OPENMIGRATE_CIVICRM_DYNAMIC_NAME', 'uploads' . DIRECTORY_SEPARATOR . 'civicrm' . DIRECTORY_SEPARATOR . 'dynamic' );

// =========================
// = Themes Functions Name =
// =========================
define( 'OPENMIGRATE_THEMES_FUNCTIONS_NAME', 'themes' . DIRECTORY_SEPARATOR . 'functions.php' );

// =============================
// = Endurance Page Cache Name =
// =============================
define( 'OPENMIGRATE_ENDURANCE_PAGE_CACHE_NAME', 'endurance-page-cache.php' );

// ===========================
// = Endurance PHP Edge Name =
// ===========================
define( 'OPENMIGRATE_ENDURANCE_PHP_EDGE_NAME', 'endurance-php-edge.php' );

// ================================
// = Endurance Browser Cache Name =
// ================================
define( 'OPENMIGRATE_ENDURANCE_BROWSER_CACHE_NAME', 'endurance-browser-cache.php' );

// =========================
// = GD System Plugin Name =
// =========================
define( 'OPENMIGRATE_GD_SYSTEM_PLUGIN_NAME', 'gd-system-plugin.php' );

// =======================
// = WP Stack Cache Name =
// =======================
define( 'OPENMIGRATE_WP_STACK_CACHE_NAME', 'wp-stack-cache.php' );

// ===========================
// = WP.com Site Loader Name =
// ===========================
define( 'OPENMIGRATE_WP_COMSH_LOADER_NAME', 'wpcomsh-loader.php' );

// ===========================
// = WP.com Site Helper Name =
// ===========================
define( 'OPENMIGRATE_WP_COMSH_HELPER_NAME', 'wpcomsh' );

// ====================================
// = SQLite Database Integration Name =
// ====================================
define( 'OPENMIGRATE_SQLITE_DATABASE_INTEGRATION_NAME', 'sqlite-database-integration' );

// =============================
// = SQLite Database Zero Name =
// =============================
define( 'OPENMIGRATE_SQLITE_DATABASE_ZERO_NAME', '0-sqlite.php' );

// ================================
// = WP Engine System Plugin Name =
// ================================
define( 'OPENMIGRATE_WP_ENGINE_SYSTEM_PLUGIN_NAME', 'mu-plugin.php' );

// ===========================
// = WPE Sign On Plugin Name =
// ===========================
define( 'OPENMIGRATE_WPE_SIGN_ON_PLUGIN_NAME', 'wpe-wp-sign-on-plugin.php' );

// ===================================
// = WP Engine Security Auditor Name =
// ===================================
define( 'OPENMIGRATE_WP_ENGINE_SECURITY_AUDITOR_NAME', 'wpengine-security-auditor.php' );

// ===========================
// = WP Cerber Security Name =
// ===========================
define( 'OPENMIGRATE_WP_CERBER_SECURITY_NAME', 'aaa-wp-cerber.php' );

// =============================
// = EOS Deactivate Plugins Name
// =============================
define( 'OPENMIGRATE_EOS_DEACTIVATE_PLUGINS_NAME', 'eos-deactivate-plugins.php' );

// ===============================
// = W3TC config file to exclude =
// ===============================
define( 'OPENMIGRATE_W3TC_CONFIG_FILE', 'w3tc-config' . DIRECTORY_SEPARATOR . 'master.php' );

// ==================
// = Error Log Name =
// ==================
define( 'OPENMIGRATE_ERROR_NAME', 'error-log-%s.log' );

// ==============
// = Secret Key =
// ==============
define( 'OPENMIGRATE_SECRET_KEY', 'openmigrate_secret_key' );

// =============
// = Auth User =
// =============
define( 'OPENMIGRATE_AUTH_USER', 'openmigrate_auth_user' );

// =================
// = Auth Password =
// =================
define( 'OPENMIGRATE_AUTH_PASSWORD', 'openmigrate_auth_password' );

// ===============
// = Auth Header =
// ===============
define( 'OPENMIGRATE_AUTH_HEADER', 'openmigrate_auth_header' );

// ============
// = Site URL =
// ============
define( 'OPENMIGRATE_SITE_URL', 'siteurl' );

// ============
// = Home URL =
// ============
define( 'OPENMIGRATE_HOME_URL', 'home' );

// ================
// = Uploads Path =
// ================
define( 'OPENMIGRATE_UPLOADS_PATH', 'upload_path' );

// ====================
// = Uploads URL Path =
// ====================
define( 'OPENMIGRATE_UPLOADS_URL_PATH', 'upload_url_path' );

// ==================
// = Active Plugins =
// ==================
define( 'OPENMIGRATE_ACTIVE_PLUGINS', 'active_plugins' );

// ===========================
// = Active Sitewide Plugins =
// ===========================
define( 'OPENMIGRATE_ACTIVE_SITEWIDE_PLUGINS', 'active_sitewide_plugins' );

// ==========================
// = Jetpack Active Modules =
// ==========================
define( 'OPENMIGRATE_JETPACK_ACTIVE_MODULES', 'jetpack_active_modules' );

// ====================================
// = Swift Optimizer Plugin Organizer =
// ====================================
define( 'OPENMIGRATE_SWIFT_OPTIMIZER_PLUGIN_ORGANIZER', 'swift_performance_plugin_organizer' );

// ======================
// = MS Files Rewriting =
// ======================
define( 'OPENMIGRATE_MS_FILES_REWRITING', 'ms_files_rewriting' );

// ===================
// = Active Template =
// ===================
define( 'OPENMIGRATE_ACTIVE_TEMPLATE', 'template' );

// =====================
// = Active Stylesheet =
// =====================
define( 'OPENMIGRATE_ACTIVE_STYLESHEET', 'stylesheet' );

// ==============
// = DB Version =
// ==============
define( 'OPENMIGRATE_DB_VERSION', 'db_version' );

// ======================
// = Initial DB Version =
// ======================
define( 'OPENMIGRATE_INITIAL_DB_VERSION', 'initial_db_version' );

// ============
// = Cron Key =
// ============
define( 'OPENMIGRATE_CRON', 'cron' );

// =======================
// = Backups Path Option =
// =======================
define( 'OPENMIGRATE_BACKUPS_PATH_OPTION', 'openmigrate_backups_path' );

// ===================
// = Backups Labels  =
// ===================
define( 'OPENMIGRATE_BACKUPS_LABELS', 'openmigrate_backups_labels' );

// ===============
// = Sites Links =
// ===============
define( 'OPENMIGRATE_SITES_LINKS', 'openmigrate_sites_links' );

// ==============
// = Status Key =
// ==============
define( 'OPENMIGRATE_STATUS', 'openmigrate_status' );

// ================
// = Messages Key =
// ================
define( 'OPENMIGRATE_MESSAGES', 'openmigrate_messages' );

// ==================
// = Max Chunk Size =
// ==================
define( 'OPENMIGRATE_MAX_CHUNK_SIZE', 5 * 1024 * 1024 );

// =====================
// = Max Chunk Retries =
// =====================
define( 'OPENMIGRATE_MAX_CHUNK_RETRIES', 10 );

// ===============
// = CIPHER NAME =
// ===============
define( 'OPENMIGRATE_CIPHER_NAME', 'AES-256-CBC' );

// =============
// = SIGN TEXT =
// =============
define( 'OPENMIGRATE_SIGN_TEXT', '"How long do you want these messages to remain secret? I want them to remain secret for as long as men are capable of evil." - Neal Stephenson' );

// ===========================
// = Max Transaction Queries =
// ===========================
if ( ! defined( 'OPENMIGRATE_MAX_TRANSACTION_QUERIES' ) ) {
	define( 'OPENMIGRATE_MAX_TRANSACTION_QUERIES', 1000 );
}

// ======================
// = Max Select Records =
// ======================
if ( ! defined( 'OPENMIGRATE_MAX_SELECT_RECORDS' ) ) {
	define( 'OPENMIGRATE_MAX_SELECT_RECORDS', 1000 );
}

// =======================
// = Max Storage Cleanup =
// =======================
define( 'OPENMIGRATE_MAX_STORAGE_CLEANUP', 24 * 60 * 60 );

// ===================
// = Max Log Cleanup =
// ===================
define( 'OPENMIGRATE_MAX_LOG_CLEANUP', 7 * 24 * 60 * 60 );

// =====================
// = Disk Space Factor =
// =====================
define( 'OPENMIGRATE_DISK_SPACE_FACTOR', 2 );

// ====================
// = Disk Space Extra =
//=====================
define( 'OPENMIGRATE_DISK_SPACE_EXTRA', 300 * 1024 * 1024 );

// ===========================
// = WP_CONTENT_DIR Constant =
// ===========================
if ( ! defined( 'WP_CONTENT_DIR' ) ) {
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
}

// ========================
// = Backups Default Path =
// ========================
if ( ! defined( 'OPENMIGRATE_DEFAULT_BACKUPS_PATH' ) ) {
	define( 'OPENMIGRATE_DEFAULT_BACKUPS_PATH', WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'ai1wm-backups' );
}

// ================
// = Backups Path =
// ================
define( 'OPENMIGRATE_BACKUPS_PATH', openmigrate_resolve_backups_path() );

// ==========================
// = Storage index.php File =
// ==========================
define( 'OPENMIGRATE_STORAGE_INDEX_PHP', OPENMIGRATE_STORAGE_PATH . DIRECTORY_SEPARATOR . 'index.php' );

// ===========================
// = Storage index.html File =
// ===========================
define( 'OPENMIGRATE_STORAGE_INDEX_HTML', OPENMIGRATE_STORAGE_PATH . DIRECTORY_SEPARATOR . 'index.html' );

// ==========================
// = Storage .htaccess File =
// ==========================
define( 'OPENMIGRATE_STORAGE_HTACCESS', OPENMIGRATE_STORAGE_PATH . DIRECTORY_SEPARATOR . '.htaccess' );

// ===========================
// = Storage web.config File =
// ===========================
define( 'OPENMIGRATE_STORAGE_WEBCONFIG', OPENMIGRATE_STORAGE_PATH . DIRECTORY_SEPARATOR . 'web.config' );

// ==========================
// = Backups index.php File =
// ==========================
define( 'OPENMIGRATE_BACKUPS_INDEX_PHP', OPENMIGRATE_BACKUPS_PATH . DIRECTORY_SEPARATOR . 'index.php' );

// ===========================
// = Backups index.html File =
// ===========================
define( 'OPENMIGRATE_BACKUPS_INDEX_HTML', OPENMIGRATE_BACKUPS_PATH . DIRECTORY_SEPARATOR . 'index.html' );

// ===========================
// = Backups robots.txt File =
// ===========================
define( 'OPENMIGRATE_BACKUPS_ROBOTS_TXT', OPENMIGRATE_BACKUPS_PATH . DIRECTORY_SEPARATOR . 'robots.txt' );

// ==========================
// = Backups .htaccess File =
// ==========================
define( 'OPENMIGRATE_BACKUPS_HTACCESS', OPENMIGRATE_BACKUPS_PATH . DIRECTORY_SEPARATOR . '.htaccess' );

// ===========================
// = Backups web.config File =
// ===========================
define( 'OPENMIGRATE_BACKUPS_WEBCONFIG', OPENMIGRATE_BACKUPS_PATH . DIRECTORY_SEPARATOR . 'web.config' );

// ============================
// = WordPress .htaccess File =
// ============================
define( 'OPENMIGRATE_WORDPRESS_HTACCESS', ABSPATH . DIRECTORY_SEPARATOR . '.htaccess' );

// =============================
// = WordPress web.config File =
// =============================
define( 'OPENMIGRATE_WORDPRESS_WEBCONFIG', ABSPATH . DIRECTORY_SEPARATOR . 'web.config' );

// ================================
// = WP Migration Plugin Base Dir =
// ================================
if ( defined( 'OPENMIGRATE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATE_PLUGIN_BASEDIR', dirname( OPENMIGRATE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATE_PLUGIN_BASEDIR', 'open-migrate' );
}

