#!/usr/bin/env bash

block="enable_on_nfs = true
"

echo "$block" > "/etc/hh.conf"

echo "xdebug.enable = 1" >> /etc/hhvm/php.ini
echo "date.timezone = Asia/Tokyo" >> /etc/hhvm/php.ini
echo "xdebug.remote_enable = 1" >> /etc/hhvm/php.ini
echo "xdebug.remote_connect_back = 1" >> /etc/hhvm/php.ini
echo "xdebug.remote_port = 9080" >> /etc/hhvm/php.ini
echo "xdebug.idekey = GARDENING" >> /etc/hhvm/php.ini
echo "xdebug.remote_autostart = 1" >> /etc/hhvm/php.ini
