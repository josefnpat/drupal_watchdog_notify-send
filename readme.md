Description
==========

This script watches for new entires on the watchdog table and pushes them to notify-send.

Configuration
=============

Edit `config.php` and fill out the MySQL database information.

Usage
=====

Run in the background; e.g. `nohup ./drupal_watchdog_notify-send.php &`

Dependencies
============

You will need <a href="http://manpages.ubuntu.com/manpages/gutsy/man1/notify-send.1.html">`notify-send`</a> from libnotify installed.

Usually, `notify-send` is installed on ubuntu due to gnome, but if it isn't, `sudo apt-get install libnotify-bin` will get you what you need.