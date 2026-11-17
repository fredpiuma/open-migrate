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

// Include all the files that you want to load in here
if ( defined( 'WP_CLI' ) ) {
	require_once OPENMIGRATE_VENDOR_PATH . '/servmask/command/class-openmigrate-wp-cli-command.php';
}

require_once OPENMIGRATE_VENDOR_PATH . '/bandar/bandar/lib/Bandar.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/cron/class-openmigrate-cron.php';

require_once OPENMIGRATE_VENDOR_PATH . '/servmask/filesystem/class-openmigrate-directory.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/filesystem/class-openmigrate-file-htaccess.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/filesystem/class-openmigrate-file-index.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/filesystem/class-openmigrate-file-robots.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/filesystem/class-openmigrate-file-webconfig.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/filesystem/class-openmigrate-file.php';

require_once OPENMIGRATE_VENDOR_PATH . '/servmask/filter/class-openmigrate-recursive-exclude-filter.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/filter/class-openmigrate-recursive-extension-filter.php';

require_once OPENMIGRATE_VENDOR_PATH . '/servmask/iterator/class-openmigrate-recursive-directory-iterator.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/iterator/class-openmigrate-recursive-iterator-iterator.php';

require_once OPENMIGRATE_VENDOR_PATH . '/servmask/archiver/class-openmigrate-archiver.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/archiver/class-openmigrate-compressor.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/archiver/class-openmigrate-extractor.php';

require_once OPENMIGRATE_VENDOR_PATH . '/servmask/checksum/class-openmigrate-crc.php';

require_once OPENMIGRATE_VENDOR_PATH . '/servmask/database/class-openmigrate-database.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/database/class-openmigrate-database-mysql.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/database/class-openmigrate-database-mysqli.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/database/class-openmigrate-database-sqlite.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/database/class-openmigrate-database-mariadb.php';
require_once OPENMIGRATE_VENDOR_PATH . '/servmask/database/class-openmigrate-database-utility.php';

require_once OPENMIGRATE_CONTROLLER_PATH . '/class-openmigrate-backups-controller.php';
require_once OPENMIGRATE_CONTROLLER_PATH . '/class-openmigrate-export-controller.php';
require_once OPENMIGRATE_CONTROLLER_PATH . '/class-openmigrate-import-controller.php';
require_once OPENMIGRATE_CONTROLLER_PATH . '/class-openmigrate-main-controller.php';
require_once OPENMIGRATE_CONTROLLER_PATH . '/class-openmigrate-rest-controller.php';
require_once OPENMIGRATE_CONTROLLER_PATH . '/class-openmigrate-status-controller.php';

require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-archive.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-archive-crc.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-clean.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-config-file.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-config.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-content.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-database-file.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-database.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-download.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-enumerate-content.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-enumerate-media.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-enumerate-plugins.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-enumerate-tables.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-enumerate-themes.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-init.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-media.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-plugins.php';
require_once OPENMIGRATE_MODEL_PATH . '/export/class-openmigrate-export-themes.php';

require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-blogs.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-check-compression.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-check-encryption.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-clean.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-confirm.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-content.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-database-file.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-database.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-done.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-enumerate.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-mu-plugins.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-options.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-permalinks.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-upload.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-users.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-validate.php';
require_once OPENMIGRATE_MODEL_PATH . '/import/class-openmigrate-import-validate-crc.php';

require_once OPENMIGRATE_MODEL_PATH . '/class-openmigrate-backups.php';
require_once OPENMIGRATE_MODEL_PATH . '/class-openmigrate-compat.php';
require_once OPENMIGRATE_MODEL_PATH . '/class-openmigrate-deprecated.php';
require_once OPENMIGRATE_MODEL_PATH . '/class-openmigrate-handler.php';
require_once OPENMIGRATE_MODEL_PATH . '/class-openmigrate-log.php';
require_once OPENMIGRATE_MODEL_PATH . '/class-openmigrate-message.php';
require_once OPENMIGRATE_MODEL_PATH . '/class-openmigrate-notification.php';
require_once OPENMIGRATE_MODEL_PATH . '/class-openmigrate-status.php';
require_once OPENMIGRATE_MODEL_PATH . '/class-openmigrate-template.php';
