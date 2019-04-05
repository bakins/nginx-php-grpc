<?php
http_response_code(204);
header("grpc-status: 14");
header("grpc-message: unavailable");
header("Content-Type: application/grpc+proto");

