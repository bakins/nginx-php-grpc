FROM php:7-fpm
COPY build.sh /tmp
RUN bash /tmp/build.sh
