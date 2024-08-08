FROM ubuntu/apache2
COPY ./index.html && *.php /var/www/html/
