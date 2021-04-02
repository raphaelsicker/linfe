#!/bin/sh
set -e

export PROGRAM=$1

#if [[ ! -z "${APP_STAGE}" ]]; then
#    eval $(curl -s env.getter/php-common?format=bash)
#    eval $(curl -s env.getter/${APP_NAME}?format=bash)
#fi

# newrelic
if test -f "/usr/local/etc/php/conf.d/newrelic.ini"; then
  sed -i \
     -e "s/newrelic.license =.*/newrelic.license = \"$PICPAY_NEWRELIC_LICENSE_KEY\"/" \
     -e "s/newrelic.appname =.*/newrelic.appname = \"$PICPAY_NEWRELIC_APP_NAME:$APP_ENV\"/" \
     -e "s/;\?newrelic.framework =.*/newrelic.framework = \laravel/" \
     /usr/local/etc/php/conf.d/newrelic.ini

  /usr/bin/newrelic-daemon -c /etc/newrelic/newrelic.cfg --pidfile /var/run/newrelic-daemon.pid
fi

php -i > /dev/null

sleep 1;

mkdir -p /app/storage/logs

touch /app/storage/logs/app.log && echo "." >> /app/storage/logs/app.log

chown -Rf www:www /app

supervisord -c /etc/supervisord/supervisord.conf -e error
