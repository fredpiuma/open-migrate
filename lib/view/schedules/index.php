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
?>

<div class="openmigrate-schedules-container">
	<div class="openmigrate-schedules-content">
		<aside>
			<nav>
				<a href="#" class="active" data-tab="backup-scheduler"><?php esc_html_e( 'Backup Scheduler', 'open-migrate' ); ?></a>
				<a href="#" data-tab="notification-settings"><?php esc_html_e( 'Notification Settings', 'open-migrate' ); ?></a>
				<a href="#" data-tab="retention-settings"><?php esc_html_e( 'Retention Settings', 'open-migrate' ); ?></a>
				<a href="#" data-tab="google-drive-storage"><?php esc_html_e( 'Google Drive Storage', 'open-migrate' ); ?></a>
				<a href="#" data-tab="dropbox-storage"><?php esc_html_e( 'Dropbox Storage', 'open-migrate' ); ?></a>
				<a href="#" data-tab="onedrive-storage"><?php esc_html_e( 'OneDrive Storage', 'open-migrate' ); ?></a>
				<a href="#" data-tab="ftp-storage"><?php esc_html_e( 'FTP Storage', 'open-migrate' ); ?></a>
				<a href="#" data-tab="more-storage-providers"><?php esc_html_e( 'More Storage Providers', 'open-migrate' ); ?></a>
				<a href="#" data-tab="multisite-schedules"><?php esc_html_e( 'Multisite Schedules', 'open-migrate' ); ?></a>
			</nav>
		</aside>
		<section>
			<article>
				<a href="#" class="active" data-tab="backup-scheduler">
					<?php esc_html_e( 'Backup scheduler', 'open-migrate' ); ?>
					<span></span>
				</a>
				<div class="active" data-tab="backup-scheduler">
					<h2>
						<?php esc_html_e( 'Backup Scheduler', 'open-migrate' ); ?> <a href="https://servmask.com/products/unlimited-extension?utm_campaign=schedules&utm_source=wordpress&utm_medium=textlink" target="_blank"><?php esc_html_e( 'Enable this feature', 'open-migrate' ); ?></a>
					</h2>
					<img src="<?php echo esc_url( wp_make_link_relative( OPENMIGRATE_URL ) . '/lib/view/assets/img/schedules/backup-scheduler.png?v=' . OPENMIGRATE_VERSION ); ?>" />
					<p><?php esc_html_e( 'Never worry about forgetting to back up your site again. Choose from various scheduling options, from daily to monthly, and we\'ll automate the rest. Backups happen like clockwork, giving you peace of mind and a solid safety net', 'open-migrate' ); ?></p>
				</div>
			</article>
			<article>
				<a href="#" data-tab="notification-settings">
					<?php esc_html_e( 'Notification settings', 'open-migrate' ); ?>
					<span></span>
				</a>
				<div data-tab="notification-settings">
					<h2>
						<?php esc_html_e( 'Notification settings', 'open-migrate' ); ?> <a href="https://servmask.com/products/unlimited-extension?utm_campaign=schedules&utm_source=wordpress&utm_medium=textlink" target="_blank"><?php esc_html_e( 'Enable this feature', 'open-migrate' ); ?></a>
					</h2>
					<img src="<?php echo esc_url( wp_make_link_relative( OPENMIGRATE_URL ) . '/lib/view/assets/img/schedules/notification-settings.png?v=' . OPENMIGRATE_VERSION ); ?>" />
					<p><?php esc_html_e( 'Stay informed, not overwhelmed. Tailor your notification preferences to get updates that matter to you. Whether it\'s the status of each backup, or just critical alerts, control what you want to be notified about.', 'open-migrate' ); ?></p>
				</div>
			</article>
			<article>
				<a href="#" data-tab="retention-settings">
					<?php esc_html_e( 'Retention settings', 'open-migrate' ); ?>
					<span></span>
				</a>
				<div data-tab="retention-settings">
					<h2>
						<?php esc_html_e( 'Retention settings', 'open-migrate' ); ?> <a href="https://servmask.com/products/unlimited-extension?utm_campaign=schedules&utm_source=wordpress&utm_medium=textlink" target="_blank"><?php esc_html_e( 'Enable this feature', 'open-migrate' ); ?></a>
					</h2>
					<img src="<?php echo esc_url( wp_make_link_relative( OPENMIGRATE_URL ) . '/lib/view/assets/img/schedules/retention-settings.png?v=' . OPENMIGRATE_VERSION ); ?>" />
					<p><?php esc_html_e( 'Manage your storage effectively with our flexible retention settings. Decide how many backups you want to keep at a time. Old backups are automatically cleared, keeping your storage neat and efficient.', 'open-migrate' ); ?></p>
				</div>
			</article>
			<article>
				<a href="#" data-tab="google-drive-storage">
					<?php esc_html_e( 'Google Drive Storage', 'open-migrate' ); ?>
					<span></span>
				</a>
				<div data-tab="google-drive-storage">
					<h2>
						<?php esc_html_e( 'Google Drive Storage', 'open-migrate' ); ?> <a href="https://servmask.com/products/all-in-one-wp-migration-pro?utm_campaign=schedules&utm_source=wordpress&utm_medium=textlink" target="_blank"><?php esc_html_e( 'Enable this feature', 'open-migrate' ); ?></a>
					</h2>
					<img src="<?php echo esc_url( wp_make_link_relative( OPENMIGRATE_URL ) . '/lib/view/assets/img/schedules/google-drive-storage.png?v=' . OPENMIGRATE_VERSION ); ?>" />
					<p><?php esc_html_e( 'Benefit from the robustness of Google Drive. Schedule your backups to be saved directly to your Google Drive account. Simple, secure, and integrated into a platform you already use.', 'open-migrate' ); ?></p>
				</div>
			</article>
			<article>
				<a href="#" data-tab="dropbox-storage">
					<?php esc_html_e( 'Dropbox Storage', 'open-migrate' ); ?>
					<span></span>
				</a>
				<div data-tab="dropbox-storage">
					<h2>
						<?php esc_html_e( 'Dropbox Storage', 'open-migrate' ); ?> <a href="https://servmask.com/products/all-in-one-wp-migration-pro?utm_campaign=schedules&utm_source=wordpress&utm_medium=textlink" target="_blank"><?php esc_html_e( 'Enable this feature', 'open-migrate' ); ?></a>
					</h2>
					<img src="<?php echo esc_url( wp_make_link_relative( OPENMIGRATE_URL ) . '/lib/view/assets/img/schedules/dropbox-storage.png?v=' . OPENMIGRATE_VERSION ); ?>" />
					<p><?php esc_html_e( 'Leverage the simplicity of Dropbox for your backup needs. Direct your scheduled backups to be stored in Dropbox. It\'s secure, straightforward, and keeps your backups at your fingertips.', 'open-migrate' ); ?></p>
				</div>
			</article>
			<article>
				<a href="#" data-tab="onedrive-storage">
					<?php esc_html_e( 'OneDrive Storage', 'open-migrate' ); ?>
					<span></span>
				</a>
				<div data-tab="onedrive-storage">
					<h2>
						<?php esc_html_e( 'OneDrive Storage', 'open-migrate' ); ?> <a href="https://servmask.com/products/all-in-one-wp-migration-pro?utm_campaign=schedules&utm_source=wordpress&utm_medium=textlink" target="_blank"><?php esc_html_e( 'Enable this feature', 'open-migrate' ); ?></a>
					</h2>
					<img src="<?php echo esc_url( wp_make_link_relative( OPENMIGRATE_URL ) . '/lib/view/assets/img/schedules/onedrive-storage.png?v=' . OPENMIGRATE_VERSION ); ?>" />
					<p><?php esc_html_e( 'Harness the power of OneDrive for your backups. Set up your scheduled backups to be saved directly in your OneDrive. It\'s secure, integrated with your Microsoft account, and keeps your data readily accessible.', 'open-migrate' ); ?></p>
				</div>
			</article>
			<article>
				<a href="#" data-tab="ftp-storage">
					<?php esc_html_e( 'FTP Storage', 'open-migrate' ); ?>
					<span></span>
				</a>
				<div data-tab="ftp-storage">
					<h2>
						<?php esc_html_e( 'FTP Storage', 'open-migrate' ); ?> <a href="https://servmask.com/products/all-in-one-wp-migration-pro?utm_campaign=schedules&utm_source=wordpress&utm_medium=textlink" target="_blank"><?php esc_html_e( 'Enable this feature', 'open-migrate' ); ?></a>
					</h2>
					<img src="<?php echo esc_url( wp_make_link_relative( OPENMIGRATE_URL ) . '/lib/view/assets/img/schedules/ftp-storage.png?v=' . OPENMIGRATE_VERSION ); ?>" />
					<p><?php esc_html_e( 'Enjoy the flexibility of FTP storage. Direct your scheduled backups to your own FTP server. You\'ll have full control over your data, providing you with a versatile and private storage solution.', 'open-migrate' ); ?></p>
				</div>
			</article>
			<article>
				<a href="#" data-tab="more-storage-providers">
					<?php esc_html_e( 'More Storage Providers', 'open-migrate' ); ?>
					<span></span>
				</a>
				<div data-tab="more-storage-providers">
					<h2>
						<?php esc_html_e( 'More Storage Providers', 'open-migrate' ); ?> <a href="https://servmask.com/products/all-in-one-wp-migration-pro?utm_campaign=schedules&utm_source=wordpress&utm_medium=textlink" target="_blank"><?php esc_html_e( 'Enable this feature', 'open-migrate' ); ?></a>
					</h2>
					<img src="<?php echo esc_url( wp_make_link_relative( OPENMIGRATE_URL ) . '/lib/view/assets/img/schedules/more-storage-providers.png?v=' . OPENMIGRATE_VERSION ); ?>" />
					<p><?php esc_html_e( 'We\'ve got you covered with an array of supported storage providers. Whether you prefer Box, Amazon S3, WebDav or something else, you can choose the one that fits your needs best. Secure your backups exactly where you want them.', 'open-migrate' ); ?></p>
				</div>
			</article>
			<article>
				<a href="#" data-tab="multisite-schedules">
					<?php esc_html_e( 'Multisite Schedules', 'open-migrate' ); ?>
					<span></span>
				</a>
				<div data-tab="multisite-schedules">
					<h2>
						<?php esc_html_e( 'Multisite Schedules', 'open-migrate' ); ?> <a href="https://servmask.com/products/multisite-extension?utm_campaign=schedules&utm_source=wordpress&utm_medium=textlink" target="_blank"><?php esc_html_e( 'Enable this feature', 'open-migrate' ); ?></a>
					</h2>
					<img src="<?php echo esc_url( wp_make_link_relative( OPENMIGRATE_URL ) . '/lib/view/assets/img/schedules/multisite-schedules.png?v=' . OPENMIGRATE_VERSION ); ?>" />
					<p><?php esc_html_e( 'Tailor your backup schedules to fit the complexity of your WordPress Multisite. Choose to export the entire network or only a selection of subsites according to your requirements. Effortless management for even the most intricate site networks.', 'open-migrate' ); ?></p>
				</div>
			</article>
		</section>
	</div>
</div>
