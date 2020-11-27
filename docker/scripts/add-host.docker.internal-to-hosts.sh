#!/usr/bin/env bash
# @TODO: one should check if the host is accessible and if it is - do nothing
echo $(printf "%d.%d.%d.%d" $(awk '$2 == 00000000 && $7 == 00000000 { for (i = 8; i >= 2; i=i-2) { print "0x" substr($3, i-1, 2) } }' /proc/net/route)) host.docker.internal >> /etc/hosts