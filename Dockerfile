FROM ubuntu/apache2
COPY ./*.php /var/www/html/
COPY ./index.html /var/www/html/index.html
