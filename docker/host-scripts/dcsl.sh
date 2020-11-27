#!/usr/bin/env bash
usage="Input piped docker-compose logs -t, or a file created from this command, to show logs lines sorted by time.\n\n   Usage:\n\n        $(basename "$0") [-h|--help] - this message\n        $(basename "$0") - runs default docker-compose logs -t and sorts'em\n        docker-compose logs -t|$(basename "$0") - pipe logs to this command\n        $(basename "$0") my-compose.log - or choose file with logs to display\n\n"
[ $# -ge 1 -a -f "$1" ] && input="$1" || input="-"
case "$1" in
  -h|--help) printf "$usage"
     exit
     ;;
esac
if [ -t 0 ]; then
  docker-compose logs -t|sort -t "|" -k +2d
else
  sort -t "|" -k +2d $input
fi