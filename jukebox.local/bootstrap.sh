#!/usr/bin/env bash

# nginx
sudo apt-get update
sudo apt-get install -y mpd mpc

cp ~/sites/jukebox/mpd.conf /etc/mpd.conf
sudo service mpd restart

mpc -h '5!r$OLPeCv#h1v1!@localhost' update