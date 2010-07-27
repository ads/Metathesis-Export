=== Metathesis ===

Contributors: xenlab,adsdevshop
Tags: postmeta, custom fields, seo, thesis, export, data
Requires at least: 3.0
Tested up to: 3.0
Stable tag: trunk
 
Migrate your SEO goodness and other meta-data from one theme or plugin to another WordPress theme or plugin.

== Description ==

Easily export the metadata stored by one plugin or theme to another plugin or theme. 

Data Portability is important. Data Portability allows you to easily move from one system to another and take your content with you. Metathesis allows you to do just that.

This plugin provides an easily extensible system for registering import and export sources. Out of the box it exports the Search Engine Optimized Title, Description, and Keywords data stored by the Thesis Theme a CSV file. It also ships with a second and third adapter to export the Thesis SEO data to the All in One SEO Pack plugin and vice versa. 

More adapters are planned, and new ones can be written very easily by extending the Metathesis class and registering your adaptor via a WordPress filter provided by Metathesis. (Documentation forthcoming).

== Installation ==

1. Download the metathesis-export.zip file, unzip and upload the whole directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Visit the Metathesis panel under the Tools submenu and follow the onscreen instructions.

== Frequently Asked Questions ==

= Why Would I Want This? =

Your metadata should be portable to other plugins or themes (or even systems). This plugin helps you do just that.

= I need help creating my own adaptor. =

Documentation will be forthcoming, but take a look at one of the classes in the adaptors folder.

= I want to help with development of this Plugin! =

The project is now hosted on [github.com](http://github.com/ads/Metathesis-Export). Just fork the project and send a pull request.

[New to git?](http://delicious.com/ericmarden/git)

== Screenshots ==

1. Metathesis Panel under the Tools Submenu

== Changelog ==

= 1.1.1 =

Internal Housekeeping.

= 1.1 =

Added new Adaptor. All in One SEO export to CSV. General code clean up and formatting. New Screenshot.

= 1.0.2 =

Tweaking the readme and ensuring we get a clean build of the software on WordPress.org

= 1.0 =

Released!

== Upgrade Notice ==

= 1.1.1 =

Internal Housekeeping.

== License ==

The Metathesis plugin was developed by Eric Marden on behalf of Robert Dempsey and Atlantic Dominion Solutions, LLC and is provided with out warranty under the GPLv2 License.

Copyright 2010 Robert Dempsey

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA