FROM debian
RUN apt update && apt install apache2 -y && apt install php-mysql -y
COPY ./*.php /var/www/html/
COPY ./index.html /var/www/html/index.html
EXPOSE 80
CMD ["apache2ctl","-D","FOREGROUND"]
