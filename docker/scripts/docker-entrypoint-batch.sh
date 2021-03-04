#!/bin/sh
set -e

export PROGRAM=$1

#if [[ ! -z "${APP_STAGE}" ]]; then
#    eval $(curl -s env.getter/php-common?format=bash)
#    eval $(curl -s env.getter/${APP_NAME}?format=bash)
#fi

# newrelic
if test -f "/usr/local/etc/php/conf.d/newrelic.ini"; then
  NEWRELIC_INI=/usr/local/etc/php/conf.d/newrelic.ini
  sed -i \
     -e "s/newrelic.license =.*/newrelic.license = \"${PICPAY_NEWRELIC_LICENSE_KEY}\"/" \
     -e "s/newrelic.appname =.*/newrelic.appname = \"${PICPAY_NEWRELIC_APP_NAME}:${APP_ENV}\"/" \
     -e "s/;\?newrelic.framework =.*/newrelic.framework = \laravel/" \
     $NEWRELIC_INI;
  sed -i "s|;newrelic.daemon.app_timeout.*|newrelic.daemon.app_timeout = 12h|" $NEWRELIC_INI
  sed -i "s/;newrelic.daemon.app_connect_timeout =.*/newrelic.app_connect_timeout = 10s/" $NEWRELIC_INI
  sed -i "s/;newrelic.daemon.start_timeout =.*/newrelic.daemon.start_timeout = 5s/" $NEWRELIC_INI
  /usr/bin/newrelic-daemon -c /etc/newrelic/newrelic.cfg
fi

wait

php -i > /dev/null
sleep 1;

mkdir -p /app/storage/logs

touch /app/storage/logs/app.log && echo "." >> /app/storage/logs/app.log

chown -Rf www-data:www-data /app

supervisord -c /etc/supervisord/supervisord.conf -e error