=== Open Migrate ===
Contributors: fredericodecastro
Tags: migration, backup, export, import, wpress
Requires at least: 5.8
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.2
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Import, export and manage .wpress backups with no file size limit, no telemetry and no external connections.

== Description ==

Open Migrate is a free fork of All-in-One WP Migration and Backup 7.113 (ServMask). It keeps the backup format and the backups folder (`wp-content/ai1wm-backups`), so backups move in both directions between this plugin and the original.

* Export the site to a `.wpress` file, with advanced options, find and replace, encryption and compression.
* Import a `.wpress` file with no size limit (chunked upload), or restore one from the backups list.
* Manage backups: restore, download, delete, label, browse the content.
* WP-CLI: `wp openmigrate backup`, `restore`, `import`, `list-backups`, `delete`.
* No telemetry, no licence, no connection to external services.

Credits: ServMask Inc., authors of All-in-One WP Migration. Open Migrate is not affiliated with or endorsed by them.

== Changelog ==

= 1.0.2 =
* Export: single "Export File" button starts the export right away (no dropdown).

= 1.0.1 =
* New plugin logo.

= 1.0.0 =
* First release, based on All-in-One WP Migration 7.113.
