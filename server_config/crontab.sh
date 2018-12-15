0 5 * * * /usr/bin/php /var/www/html/resources/fetchdailystockvalues.php > /var/log/stocklogs/`date +\%Y\%m\%d\%H\%M\%S`-cron.log

