#!/bin/bash
set -eux

apt-get update
apt-get install -y zlib1g-dev unzip
#apt-get install -y gcc g++ make autoconf automake libtool libc-dev pkg-config git-core zlib1g-dev 


pecl install protobuf-3.7.1
pecl install grpc-1.19.0

echo extension=grpc.so >  /usr/local/etc/php/conf.d/grpc.ini
echo extension=protobuf.so >  /usr/local/etc/php/conf.d/protobuf.ini

cd /tmp
curl --fail -L -O https://github.com/protocolbuffers/protobuf/releases/download/v3.7.1/protoc-3.7.1-linux-x86_64.zip
unzip protoc-3.7.1-linux-x86_64.zip
mv bin/protoc /usr/local/bin/

# needed to generate PHP gRPC libraries for services
#cd /tmp
#git clone -b v1.19.0 https://github.com/grpc/grpc
#cd /tmp/grpc
#git submodule update --init
#make grpc_php_plugin
#mv /tmp/grpc/bins/opt/grpc_php_plugin /usr/local/bin

#cd /tmp/grpc/third_party/protobuf
#./autogen.sh
#./configure
#make
#make install

#cd /tmp && git clone -b v1.19.0 https://github.com/grpc/grpc && cd grpc && git submodule update --init
#cd /tmp/grpc && make && make install
#cd /tmp/grpc && make grpc_php_plugin && mv /tmp/grpc/bins/opt/grpc_php_plugin /usr/local/bin
#cd /tmp/grpc/third_party/protobuf/ && ./autogen.sh && ./configure && make && make install
#cd /tmp/grpc/src/php/ext/grpc && phpize && ./configure && make && make install

cd /tmp
curl -L --fail -O https://getcomposer.org/installer
php installer
mv composer.phar /usr/local/bin/composer


cd / 
rm -rf /tmp/*

apt-get clean

