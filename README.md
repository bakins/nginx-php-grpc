# nginx-php-grpc

A simple [gRPC](https://grpc.io/) service written in PHP.  This example uses only nginx to expose the service and
does not require any special proxy.

## Motivation

In the past, I've used a [proxy](https://github.com/bakins/grpc-fastcgi-proxy) to help expose PHP services as gRPC.
Since nginx now supports HTTP2, I wondered if I could write a PHP service using just PHP and nginx.  It turns out, you can.

## Status

This is a very simple example. It has been tested using [grpcurl](https://github.com/fullstorydev/grpcurl) and the
example [greeter_client](https://github.com/grpc/grpc-go/tree/master/examples/helloworld/greeter_client).

This should work for unary gRPC, in general.  Streaming clients/servers would require more work and may not be possible. Simple streaming servers where the number of returned messages are known should theoretically work.

## Usage

This example requires [docker-compose](https://docs.docker.com/compose/).

Clone this repository and run docker-compose:

```shell
mkdir ~/src
cd ~/src
git clone https://github.com/bakins/nginx-php-grpc.git
cd nginx-php-grpc
docker-compose up
```

You should see two containers start: nginx and php-fpm

In another terminal, you can use [grpcurl](https://github.com/fullstorydev/grpcurl) to test:

```shell
cd ~/src/nginx-php-grpc
grpcurl -v -plaintext -d '{"name": "universe"}'  -proto ./helloworld.proto 127.0.0.1:8080 helloworld.Greeter/SayHello
```

You should see a response like:

```
Response contents:
{
  "message": "Hello universe"
}
```

## How does it work

The [gRPC wire protocol](https://github.com/grpc/grpc/blob/master/doc/PROTOCOL-HTTP2.md) is fairly straightforward. 
Basically, every message (requests and response) are prefixed with a flag and the length of the message.  gRPC responses
include an HTTP trailer indicating the status of the response.  gRPC is a layer on HTTP2.

nginx now supports [HTTP2 listeners](https://www.nginx.com/blog/http2-module-nginx/#config).  You can also [add trailers](http://nginx.org/en/docs/http/ngx_http_headers_module.html#add_trailer) to responses using configuration.

The [example PHP code here](./app/helloworld.php) handles the framing of the request and response messages.  It sets a `grpc-status` header that is added as a trailer by the [nginx configuration](./default.conf).

## Future work

We could develop a simple framework that handled the message framing and routing.

## LICENSE

See [LICENSE](./LICENSE)