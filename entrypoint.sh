#!/bin/sh

set -e

if [ -z "${DVBLINK_DVBPLEX_URL}" ]; then
  echo 'Missing required environment variable DVBLINK_DVBPLEX_URL';
  exit 1;
fi

if [ -z "${DVBLINK_SERVER}" ]; then
  echo 'Missing required environment variable DVBLINK_SERVER';
  exit 1;
fi

if [ -z "${DVBLINK_PORT}" ]; then
  echo 'Missing required environment variable DVBLINK_PORT';
  exit 1;
fi

exec /usr/local/bin/docker-php-entrypoint "$@";
