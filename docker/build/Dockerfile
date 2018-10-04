FROM ubuntu:18.04

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y software-properties-common curl gnupg less nano

RUN useradd -ms /bin/bash -U www
RUN mkdir /home/www/bin

# nginx
RUN curl http://nginx.org/keys/nginx_signing.key | apt-key add -
RUN echo "deb http://nginx.org/packages/ubuntu/ bionic nginx" >> /etc/apt/sources.list
RUN echo "deb-src http://nginx.org/packages/ubuntu/ bionic nginx" >> /etc/apt/sources.list
RUN apt-get update && apt-get install -y nginx



# php
RUN apt-get install -y php7.2-cli php7.2-curl php7.2-intl php7.2-fpm php7.2-mysql php7.2-gd php7.2-mbstring php7.2-xml php7.2-zip
RUN mkdir /run/php

# supervisor
RUN apt-get install -y supervisor
RUN mkdir -p /var/log/supervisor

WORKDIR /var/www/html

CMD ["/usr/bin/supervisord", "-n"]