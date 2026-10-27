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
define( 'OPENMIGRATE_VERSION', '7.113' );

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
// = ServMask Feedback URL =
// =========================
define( 'OPENMIGRATE_FEEDBACK_URL', 'https://servmask.com/openmigrate/feedback/create' );

// ==============================
// = ServMask Archive Tools URL =
// ==============================
define( 'OPENMIGRATE_ARCHIVE_TOOLS_URL', 'https://servmask.com/archive/tools' );

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

// ==============================
// = Last Check For Updates Key =
// ==============================
define( 'OPENMIGRATE_LAST_CHECK_FOR_UPDATES', 'openmigrate_last_check_for_updates' );

// ===============
// = Updater Key =
// ===============
define( 'OPENMIGRATE_UPDATER', 'openmigrate_updater' );

// ==============
// = Status Key =
// ==============
define( 'OPENMIGRATE_STATUS', 'openmigrate_status' );

// ================
// = Messages Key =
// ================
define( 'OPENMIGRATE_MESSAGES', 'openmigrate_messages' );

// =================
// = Support Email =
// =================
define( 'OPENMIGRATE_SUPPORT_EMAIL', 'support@servmask.com' );

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

// ======================================
// = Microsoft Azure Extension Base Dir =
// ======================================
if ( defined( 'OPENMIGRATEZE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEZE_PLUGIN_BASEDIR', dirname( OPENMIGRATEZE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEZE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-azure-storage-extension' );
}

// ===================================
// = Microsoft Azure Extension Title =
// ===================================
if ( ! defined( 'OPENMIGRATEZE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEZE_PLUGIN_TITLE', 'Microsoft Azure Storage Extension' );
}

// ===================================
// = Microsoft Azure Extension About =
// ===================================
if ( ! defined( 'OPENMIGRATEZE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEZE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/microsoft-azure-storage-extension.json' );
}

// ===================================
// = Microsoft Azure Extension Check =
// ===================================
if ( ! defined( 'OPENMIGRATEZE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEZE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/microsoft-azure-storage-extension' );
}

// =================================
// = Microsoft Azure Extension Key =
// =================================
if ( ! defined( 'OPENMIGRATEZE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEZE_PLUGIN_KEY', 'openmigrateze_plugin_key' );
}

// ===================================
// = Microsoft Azure Extension Short =
// ===================================
if ( ! defined( 'OPENMIGRATEZE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEZE_PLUGIN_SHORT', 'azure-storage' );
}

// ===================================
// = Backblaze B2 Extension Base Dir =
// ===================================
if ( defined( 'OPENMIGRATEAE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEAE_PLUGIN_BASEDIR', dirname( OPENMIGRATEAE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEAE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-b2-extension' );
}

// ================================
// = Backblaze B2 Extension Title =
// ================================
if ( ! defined( 'OPENMIGRATEAE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEAE_PLUGIN_TITLE', 'Backblaze B2 Extension' );
}

// ================================
// = Backblaze B2 Extension About =
// ================================
if ( ! defined( 'OPENMIGRATEAE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEAE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/backblaze-b2-extension.json' );
}

// ================================
// = Backblaze B2 Extension Check =
// ================================
if ( ! defined( 'OPENMIGRATEAE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEAE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/backblaze-b2-extension' );
}

// ==============================
// = Backblaze B2 Extension Key =
// ==============================
if ( ! defined( 'OPENMIGRATEAE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEAE_PLUGIN_KEY', 'openmigrateae_plugin_key' );
}

// ================================
// = Backblaze B2 Extension Short =
// ================================
if ( ! defined( 'OPENMIGRATEAE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEAE_PLUGIN_SHORT', 'b2' );
}

// ==========================
// = Backup Plugin Base Dir =
// ==========================
if ( defined( 'OPENMIGRATEVE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEVE_PLUGIN_BASEDIR', dirname( OPENMIGRATEVE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEVE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-backup' );
}

// =======================
// = Backup Plugin Title =
// =======================
if ( ! defined( 'OPENMIGRATEVE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEVE_PLUGIN_TITLE', 'Backup Plugin' );
}

// =======================
// = Backup Plugin About =
// =======================
if ( ! defined( 'OPENMIGRATEVE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEVE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/backup-plugin.json' );
}

// =======================
// = Backup Plugin Check =
// =======================
if ( ! defined( 'OPENMIGRATEVE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEVE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/backup-plugin' );
}

// =====================
// = Backup Plugin Key =
// =====================
if ( ! defined( 'OPENMIGRATEVE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEVE_PLUGIN_KEY', 'openmigrateve_plugin_key' );
}

// =======================
// = Backup Plugin Short =
// =======================
if ( ! defined( 'OPENMIGRATEVE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEVE_PLUGIN_SHORT', 'backup' );
}

// ==========================
// = Box Extension Base Dir =
// ==========================
if ( defined( 'OPENMIGRATEBE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEBE_PLUGIN_BASEDIR', dirname( OPENMIGRATEBE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEBE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-box-extension' );
}

// =======================
// = Box Extension Title =
// =======================
if ( ! defined( 'OPENMIGRATEBE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEBE_PLUGIN_TITLE', 'Box Extension' );
}

// =======================
// = Box Extension About =
// =======================
if ( ! defined( 'OPENMIGRATEBE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEBE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/box-extension.json' );
}

// =======================
// = Box Extension Check =
// =======================
if ( ! defined( 'OPENMIGRATEBE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEBE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/box-extension' );
}

// =====================
// = Box Extension Key =
// =====================
if ( ! defined( 'OPENMIGRATEBE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEBE_PLUGIN_KEY', 'openmigratebe_plugin_key' );
}

// =======================
// = Box Extension Short =
// =======================
if ( ! defined( 'OPENMIGRATEBE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEBE_PLUGIN_SHORT', 'box' );
}

// ==========================================
// = DigitalOcean Spaces Extension Base Dir =
// ==========================================
if ( defined( 'OPENMIGRATEIE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEIE_PLUGIN_BASEDIR', dirname( OPENMIGRATEIE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEIE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-digitalocean-extension' );
}

// =======================================
// = DigitalOcean Spaces Extension Title =
// =======================================
if ( ! defined( 'OPENMIGRATEIE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEIE_PLUGIN_TITLE', 'DigitalOcean Spaces Extension' );
}

// =======================================
// = DigitalOcean Spaces Extension About =
// =======================================
if ( ! defined( 'OPENMIGRATEIE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEIE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/digitalocean-spaces-extension.json' );
}

// =======================================
// = DigitalOcean Spaces Extension Check =
// =======================================
if ( ! defined( 'OPENMIGRATEIE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEIE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/digitalocean-spaces-extension' );
}

// =====================================
// = DigitalOcean Spaces Extension Key =
// =====================================
if ( ! defined( 'OPENMIGRATEIE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEIE_PLUGIN_KEY', 'openmigrateie_plugin_key' );
}

// =======================================
// = DigitalOcean Spaces Extension Short =
// =======================================
if ( ! defined( 'OPENMIGRATEIE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEIE_PLUGIN_SHORT', 'digitalocean' );
}

// =============================
// = Direct Extension Base Dir =
// =============================
if ( defined( 'OPENMIGRATEXE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEXE_PLUGIN_BASEDIR', dirname( OPENMIGRATEXE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEXE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-direct-extension' );
}
// ==========================
// = Direct Extension Title =
// ==========================
if ( ! defined( 'OPENMIGRATEXE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEXE_PLUGIN_TITLE', 'Direct Extension' );
}
// ==========================
// = Direct Extension About =
// ==========================
if ( ! defined( 'OPENMIGRATEXE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEXE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/direct-extension.json' );
}

// ==========================
// = Direct Extension Check =
// ==========================
if ( ! defined( 'OPENMIGRATEXE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEXE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/direct-extension' );
}

// ========================
// = Direct Extension Key =
// ========================
if ( ! defined( 'OPENMIGRATEXE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEXE_PLUGIN_KEY', 'openmigratexe_plugin_key' );
}
// ==========================
// = Direct Extension Short =
// ==========================
if ( ! defined( 'OPENMIGRATEXE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEXE_PLUGIN_SHORT', 'direct' );
}

// ==============================
// = Dropbox Extension Base Dir =
// ==============================
if ( defined( 'OPENMIGRATEDE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEDE_PLUGIN_BASEDIR', dirname( OPENMIGRATEDE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEDE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-dropbox-extension' );
}

// ===========================
// = Dropbox Extension Title =
// ===========================
if ( ! defined( 'OPENMIGRATEDE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEDE_PLUGIN_TITLE', 'Dropbox Extension' );
}

// ===========================
// = Dropbox Extension About =
// ===========================
if ( ! defined( 'OPENMIGRATEDE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEDE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/dropbox-extension.json' );
}

// ===========================
// = Dropbox Extension Check =
// ===========================
if ( ! defined( 'OPENMIGRATEDE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEDE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/dropbox-extension' );
}

// =========================
// = Dropbox Extension Key =
// =========================
if ( ! defined( 'OPENMIGRATEDE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEDE_PLUGIN_KEY', 'openmigratede_plugin_key' );
}

// ===========================
// = Dropbox Extension Short =
// ===========================
if ( ! defined( 'OPENMIGRATEDE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEDE_PLUGIN_SHORT', 'dropbox' );
}

// ===========================
// = File Extension Base Dir =
// ===========================
if ( defined( 'OPENMIGRATETE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATETE_PLUGIN_BASEDIR', dirname( OPENMIGRATETE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATETE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-file-extension' );
}

// ========================
// = File Extension Title =
// ========================
if ( ! defined( 'OPENMIGRATETE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATETE_PLUGIN_TITLE', 'File Extension' );
}

// ========================
// = File Extension About =
// ========================
if ( ! defined( 'OPENMIGRATETE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATETE_PLUGIN_ABOUT', 'https://import.wp-migration.com/file-extension.json' );
}

// ========================
// = File Extension Check =
// ========================
if ( ! defined( 'OPENMIGRATETE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATETE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/file-extension' );
}

// ======================
// = File Extension Key =
// ======================
if ( ! defined( 'OPENMIGRATETE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATETE_PLUGIN_KEY', 'openmigratete_plugin_key' );
}

// ========================
// = File Extension Short =
// ========================
if ( ! defined( 'OPENMIGRATETE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATETE_PLUGIN_SHORT', 'file' );
}

// ==========================
// = FTP Extension Base Dir =
// ==========================
if ( defined( 'OPENMIGRATEFE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEFE_PLUGIN_BASEDIR', dirname( OPENMIGRATEFE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEFE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-ftp-extension' );
}

// =======================
// = FTP Extension Title =
// =======================
if ( ! defined( 'OPENMIGRATEFE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEFE_PLUGIN_TITLE', 'FTP Extension' );
}

// =======================
// = FTP Extension About =
// =======================
if ( ! defined( 'OPENMIGRATEFE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEFE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/ftp-extension.json' );
}

// =======================
// = FTP Extension Check =
// =======================
if ( ! defined( 'OPENMIGRATEFE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEFE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/ftp-extension' );
}

// =====================
// = FTP Extension Key =
// =====================
if ( ! defined( 'OPENMIGRATEFE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEFE_PLUGIN_KEY', 'openmigratefe_plugin_key' );
}

// =======================
// = FTP Extension Short =
// =======================
if ( ! defined( 'OPENMIGRATEFE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEFE_PLUGIN_SHORT', 'ftp' );
}

// ===========================================
// = Google Cloud Storage Extension Base Dir =
// ===========================================
if ( defined( 'OPENMIGRATECE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATECE_PLUGIN_BASEDIR', dirname( OPENMIGRATECE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATECE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-gcloud-storage-extension' );
}

// ========================================
// = Google Cloud Storage Extension Title =
// ========================================
if ( ! defined( 'OPENMIGRATECE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATECE_PLUGIN_TITLE', 'Google Cloud Storage Extension' );
}

// ========================================
// = Google Cloud Storage Extension About =
// ========================================
if ( ! defined( 'OPENMIGRATECE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATECE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/google-cloud-storage-extension.json' );
}

// ========================================
// = Google Cloud Storage Extension Check =
// ========================================
if ( ! defined( 'OPENMIGRATECE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATECE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/google-cloud-storage-extension' );
}

// ======================================
// = Google Cloud Storage Extension Key =
// ======================================
if ( ! defined( 'OPENMIGRATECE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATECE_PLUGIN_KEY', 'openmigratece_plugin_key' );
}

// ========================================
// = Google Cloud Storage Extension Short =
// ========================================
if ( ! defined( 'OPENMIGRATECE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATECE_PLUGIN_SHORT', 'gcloud-storage' );
}

// ===================================
// = Google Drive Extension Base Dir =
// ===================================
if ( defined( 'OPENMIGRATEGE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEGE_PLUGIN_BASEDIR', dirname( OPENMIGRATEGE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEGE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-gdrive-extension' );
}

// ================================
// = Google Drive Extension Title =
// ================================
if ( ! defined( 'OPENMIGRATEGE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEGE_PLUGIN_TITLE', 'Google Drive Extension' );
}

// ================================
// = Google Drive Extension About =
// ================================
if ( ! defined( 'OPENMIGRATEGE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEGE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/google-drive-extension.json' );
}

// ================================
// = Google Drive Extension Check =
// ================================
if ( ! defined( 'OPENMIGRATEGE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEGE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/google-drive-extension' );
}

// ==============================
// = Google Drive Extension Key =
// ==============================
if ( ! defined( 'OPENMIGRATEGE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEGE_PLUGIN_KEY', 'openmigratege_plugin_key' );
}

// ================================
// = Google Drive Extension Short =
// ================================
if ( ! defined( 'OPENMIGRATEGE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEGE_PLUGIN_SHORT', 'gdrive' );
}

// =====================================
// = Amazon Glacier Extension Base Dir =
// =====================================
if ( defined( 'OPENMIGRATERE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATERE_PLUGIN_BASEDIR', dirname( OPENMIGRATERE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATERE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-glacier-extension' );
}

// ==================================
// = Amazon Glacier Extension Title =
// ==================================
if ( ! defined( 'OPENMIGRATERE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATERE_PLUGIN_TITLE', 'Amazon Glacier Extension' );
}

// ==================================
// = Amazon Glacier Extension About =
// ==================================
if ( ! defined( 'OPENMIGRATERE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATERE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/amazon-glacier-extension.json' );
}

// ==================================
// = Amazon Glacier Extension Check =
// ==================================
if ( ! defined( 'OPENMIGRATERE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATERE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/amazon-glacier-extension' );
}

// ================================
// = Amazon Glacier Extension Key =
// ================================
if ( ! defined( 'OPENMIGRATERE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATERE_PLUGIN_KEY', 'openmigratere_plugin_key' );
}

// ==================================
// = Amazon Glacier Extension Short =
// ==================================
if ( ! defined( 'OPENMIGRATERE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATERE_PLUGIN_SHORT', 'glacier' );
}

// ===========================
// = Mega Extension Base Dir =
// ===========================
if ( defined( 'OPENMIGRATEEE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEEE_PLUGIN_BASEDIR', dirname( OPENMIGRATEEE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEEE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-mega-extension' );
}

// ========================
// = Mega Extension Title =
// ========================
if ( ! defined( 'OPENMIGRATEEE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEEE_PLUGIN_TITLE', 'Mega Extension' );
}

// ========================
// = Mega Extension About =
// ========================
if ( ! defined( 'OPENMIGRATEEE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEEE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/mega-extension.json' );
}

// ========================
// = Mega Extension Check =
// ========================
if ( ! defined( 'OPENMIGRATEEE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEEE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/mega-extension' );
}

// ======================
// = Mega Extension Key =
// ======================
if ( ! defined( 'OPENMIGRATEEE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEEE_PLUGIN_KEY', 'openmigrateee_plugin_key' );
}

// ========================
// = Mega Extension Short =
// ========================
if ( ! defined( 'OPENMIGRATEEE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEEE_PLUGIN_SHORT', 'mega' );
}

// ================================
// = Multisite Extension Base Dir =
// ================================
if ( defined( 'OPENMIGRATEME_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEME_PLUGIN_BASEDIR', dirname( OPENMIGRATEME_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEME_PLUGIN_BASEDIR', 'all-in-one-wp-migration-multisite-extension' );
}

// =============================
// = Multisite Extension Title =
// =============================
if ( ! defined( 'OPENMIGRATEME_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEME_PLUGIN_TITLE', 'Multisite Extension' );
}

// =============================
// = Multisite Extension About =
// =============================
if ( ! defined( 'OPENMIGRATEME_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEME_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/multisite-extension.json' );
}

// =============================
// = Multisite Extension Check =
// =============================
if ( ! defined( 'OPENMIGRATEME_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEME_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/multisite-extension' );
}

// ===========================
// = Multisite Extension Key =
// ===========================
if ( ! defined( 'OPENMIGRATEME_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEME_PLUGIN_KEY', 'openmigrateme_plugin_key' );
}

// =============================
// = Multisite Extension Short =
// =============================
if ( ! defined( 'OPENMIGRATEME_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEME_PLUGIN_SHORT', 'multisite' );
}

// ===============================
// = OneDrive Extension Base Dir =
// ===============================
if ( defined( 'OPENMIGRATEOE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEOE_PLUGIN_BASEDIR', dirname( OPENMIGRATEOE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEOE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-onedrive-extension' );
}

// ============================
// = OneDrive Extension Title =
// ============================
if ( ! defined( 'OPENMIGRATEOE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEOE_PLUGIN_TITLE', 'OneDrive Extension' );
}

// ============================
// = OneDrive Extension About =
// ============================
if ( ! defined( 'OPENMIGRATEOE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEOE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/onedrive-extension.json' );
}

// ============================
// = OneDrive Extension Check =
// ============================
if ( ! defined( 'OPENMIGRATEOE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEOE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/onedrive-extension' );
}

// ==========================
// = OneDrive Extension Key =
// ==========================
if ( ! defined( 'OPENMIGRATEOE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEOE_PLUGIN_KEY', 'openmigrateoe_plugin_key' );
}

// ============================
// = OneDrive Extension Short =
// ============================
if ( ! defined( 'OPENMIGRATEOE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEOE_PLUGIN_SHORT', 'onedrive' );
}

// =============================
// = pCloud Extension Base Dir =
// =============================
if ( defined( 'OPENMIGRATEPE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEPE_PLUGIN_BASEDIR', dirname( OPENMIGRATEPE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEPE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-pcloud-extension' );
}

// ==========================
// = pCloud Extension Title =
// ==========================
if ( ! defined( 'OPENMIGRATEPE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEPE_PLUGIN_TITLE', 'pCloud Extension' );
}

// ==========================
// = pCloud Extension About =
// ==========================
if ( ! defined( 'OPENMIGRATEPE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEPE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/pcloud-extension.json' );
}

// ==========================
// = pCloud Extension Check =
// ==========================
if ( ! defined( 'OPENMIGRATEPE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEPE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/pcloud-extension' );
}

// ========================
// = pCloud Extension Key =
// ========================
if ( ! defined( 'OPENMIGRATEPE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEPE_PLUGIN_KEY', 'openmigratepe_plugin_key' );
}

// ==========================
// = pCloud Extension Short =
// ==========================
if ( ! defined( 'OPENMIGRATEPE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEPE_PLUGIN_SHORT', 'pcloud' );
}

// =======================
// = Pro Plugin Base Dir =
// =======================
if ( defined( 'OPENMIGRATEKE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEKE_PLUGIN_BASEDIR', dirname( OPENMIGRATEKE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEKE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-pro' );
}

// ====================
// = Pro Plugin Title =
// ====================
if ( ! defined( 'OPENMIGRATEKE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEKE_PLUGIN_TITLE', 'All-in-One WP Migration Pro' );
}

// ====================
// = Pro Plugin About =
// ====================
if ( ! defined( 'OPENMIGRATEKE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEKE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/all-in-one-wp-migration-pro.json' );
}

// ====================
// = Pro Plugin Check =
// ====================
if ( ! defined( 'OPENMIGRATEKE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEKE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/all-in-one-wp-migration-pro' );
}

// ==================
// = Pro Plugin Key =
// ==================
if ( ! defined( 'OPENMIGRATEKE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEKE_PLUGIN_KEY', 'openmigrateke_plugin_key' );
}

// ====================
// = Pro Plugin Short =
// ====================
if ( ! defined( 'OPENMIGRATEKE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEKE_PLUGIN_SHORT', 'pro' );
}

// ================================
// = S3 Client Extension Base Dir =
// ================================
if ( defined( 'OPENMIGRATENE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATENE_PLUGIN_BASEDIR', dirname( OPENMIGRATENE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATENE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-s3-client-extension' );
}

// =============================
// = S3 Client Extension Title =
// =============================
if ( ! defined( 'OPENMIGRATENE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATENE_PLUGIN_TITLE', 'S3 Client Extension' );
}

// =============================
// = S3 Client Extension About =
// =============================
if ( ! defined( 'OPENMIGRATENE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATENE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/s3-client-extension.json' );
}

// =============================
// = S3 Client Extension Check =
// =============================
if ( ! defined( 'OPENMIGRATENE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATENE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/s3-client-extension' );
}

// ===========================
// = S3 Client Extension Key =
// ===========================
if ( ! defined( 'OPENMIGRATENE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATENE_PLUGIN_KEY', 'openmigratene_plugin_key' );
}

// =============================
// = S3 Client Extension Short =
// =============================
if ( ! defined( 'OPENMIGRATENE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATENE_PLUGIN_SHORT', 's3-client' );
}

// ================================
// = Amazon S3 Extension Base Dir =
// ================================
if ( defined( 'OPENMIGRATESE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATESE_PLUGIN_BASEDIR', dirname( OPENMIGRATESE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATESE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-s3-extension' );
}

// =============================
// = Amazon S3 Extension Title =
// =============================
if ( ! defined( 'OPENMIGRATESE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATESE_PLUGIN_TITLE', 'Amazon S3 Extension' );
}

// =============================
// = Amazon S3 Extension About =
// =============================
if ( ! defined( 'OPENMIGRATESE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATESE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/amazon-s3-extension.json' );
}

// =============================
// = Amazon S3 Extension Check =
// =============================
if ( ! defined( 'OPENMIGRATESE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATESE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/amazon-s3-extension' );
}

// ===========================
// = Amazon S3 Extension Key =
// ===========================
if ( ! defined( 'OPENMIGRATESE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATESE_PLUGIN_KEY', 'openmigratese_plugin_key' );
}

// =============================
// = Amazon S3 Extension Short =
// =============================
if ( ! defined( 'OPENMIGRATESE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATESE_PLUGIN_SHORT', 's3' );
}

// ================================
// = Unlimited Extension Base Dir =
// ================================
if ( defined( 'OPENMIGRATEUE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEUE_PLUGIN_BASEDIR', dirname( OPENMIGRATEUE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEUE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-unlimited-extension' );
}

// =============================
// = Unlimited Extension Title =
// =============================
if ( ! defined( 'OPENMIGRATEUE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEUE_PLUGIN_TITLE', 'Unlimited Extension' );
}

// =============================
// = Unlimited Extension About =
// =============================
if ( ! defined( 'OPENMIGRATEUE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEUE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/unlimited-extension.json' );
}

// =============================
// = Unlimited Extension Check =
// =============================
if ( ! defined( 'OPENMIGRATEUE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEUE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/unlimited-extension' );
}

// ===========================
// = Unlimited Extension Key =
// ===========================
if ( ! defined( 'OPENMIGRATEUE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEUE_PLUGIN_KEY', 'openmigrateue_plugin_key' );
}

// =============================
// = Unlimited Extension Short =
// =============================
if ( ! defined( 'OPENMIGRATEUE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEUE_PLUGIN_SHORT', 'unlimited' );
}

// ==========================
// = URL Extension Base Dir =
// ==========================
if ( defined( 'OPENMIGRATELE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATELE_PLUGIN_BASEDIR', dirname( OPENMIGRATELE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATELE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-url-extension' );
}

// =======================
// = URL Extension Title =
// =======================
if ( ! defined( 'OPENMIGRATELE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATELE_PLUGIN_TITLE', 'URL Extension' );
}

// =======================
// = URL Extension About =
// =======================
if ( ! defined( 'OPENMIGRATELE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATELE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/url-extension.json' );
}

// =======================
// = URL Extension Check =
// =======================
if ( ! defined( 'OPENMIGRATELE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATELE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/url-extension' );
}

// =====================
// = URL Extension Key =
// =====================
if ( ! defined( 'OPENMIGRATELE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATELE_PLUGIN_KEY', 'openmigratele_plugin_key' );
}

// =======================
// = URL Extension Short =
// =======================
if ( ! defined( 'OPENMIGRATELE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATELE_PLUGIN_SHORT', 'url' );
}

// =============================
// = WebDAV Extension Base Dir =
// =============================
if ( defined( 'OPENMIGRATEWE_PLUGIN_BASENAME' ) ) {
	define( 'OPENMIGRATEWE_PLUGIN_BASEDIR', dirname( OPENMIGRATEWE_PLUGIN_BASENAME ) );
} else {
	define( 'OPENMIGRATEWE_PLUGIN_BASEDIR', 'all-in-one-wp-migration-webdav-extension' );
}

// ==========================
// = WebDAV Extension Title =
// ==========================
if ( ! defined( 'OPENMIGRATEWE_PLUGIN_TITLE' ) ) {
	define( 'OPENMIGRATEWE_PLUGIN_TITLE', 'WebDAV Extension' );
}

// ==========================
// = WebDAV Extension About =
// ==========================
if ( ! defined( 'OPENMIGRATEWE_PLUGIN_ABOUT' ) ) {
	define( 'OPENMIGRATEWE_PLUGIN_ABOUT', 'https://plugin-updates.wp-migration.com/webdav-extension.json' );
}

// ==========================
// = WebDAV Extension Check =
// ==========================
if ( ! defined( 'OPENMIGRATEWE_PLUGIN_CHECK' ) ) {
	define( 'OPENMIGRATEWE_PLUGIN_CHECK', 'https://redirect.wp-migration.com/v1/check/webdav-extension' );
}

// ========================
// = WebDAV Extension Key =
// ========================
if ( ! defined( 'OPENMIGRATEWE_PLUGIN_KEY' ) ) {
	define( 'OPENMIGRATEWE_PLUGIN_KEY', 'openmigratewe_plugin_key' );
}

// ==========================
// = WebDAV Extension Short =
// ==========================
if ( ! defined( 'OPENMIGRATEWE_PLUGIN_SHORT' ) ) {
	define( 'OPENMIGRATEWE_PLUGIN_SHORT', 'webdav' );
}
