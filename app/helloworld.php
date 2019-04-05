<?php
require dirname(__FILE__).'/vendor/autoload.php';
require dirname(__FILE__).'/lib/Helloworld/HelloReply.php';
require dirname(__FILE__).'/lib/Helloworld/HelloRequest.php';
require dirname(__FILE__).'/lib/GPBMetadata/Helloworld.php';


$body = file_get_contents('php://input');

# see https://github.com/grpc/grpc/blob/master/doc/PROTOCOL-HTTP2.md
# each message is preceded by a flag that denotes if the message is compressed
# and the length of the message
$array = unpack("Cflag/Nlength", $body);

# message begins after the prefix, and should have the length
# defined in the prefix
$message = substr($body, 5, $array['length']);

$request = new \Helloworld\HelloRequest();
$request->mergeFromString($message);

$response = new \Helloworld\HelloReply();
$response->setMessage(sprintf("Hello %s", $request->getName()));

$out = $response->serializeToString();

# we add grpc-status as a trailer in the nginx configuration
header("grpc-status: 0");
header("Content-Type: application/grpc+proto");
echo pack("CN", 0, strlen($out));
echo $out;

