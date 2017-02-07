<?php
require_once __DIR__.'/vendor/autoload.php';
require_once (__DIR__.'/multicast/src/MulticastMessage.php');
require_once (__DIR__.'/multicast/src/MulticastPacket.php');
require_once (__DIR__.'/multicast/src/MulticastServer.php');
require_once (__DIR__.'/multicast/src/MulticastServerConfig.php');

$request =
"GET /whitelist?var1=val1 HTTP/1.1
Host: www.nowhere123.com
Accept: image/gif, image/jpeg, */*
Accept-Language: en-us
Accept-Encoding: gzip, deflate
User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)

<html><body><h1>It works!</h1></body></html>
";


try {
    (new Dotenv\Dotenv(__DIR__.'/'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/')
);
$app->withEloquent();
$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__.'/app/Http/routes.php';
});

var_dump('Quering request');

$t = microtime(1);
for($i=0;$i<1000;$i++){
//    $response = $app->handle(\App\Http\Request::create('/whitelist', 'GET'));
    $response = $app->handle(\App\Http\Request::fromString($request));
    var_dump($response->__toString());
}
$app->flush();//close app and close all connections including mysql/db
var_dump(microtime(1) - $t);



return;

    $server = new \OVM\Multicast\MulticastServer(
        new \OVM\Multicast\MulticastServerConfig(
            [
                'serviceName'    => '004',
                'serviceVersion' => '001',
                'mode'           => \OVM\Multicast\MulticastServer::SERVER_MODE_SERVER,
            ]
        )
    );
    $server->onRead(
        function ($data_resp) {
            global $server;
    
            $timeStart = microtime(true);
            if (!$data = self::parseRequest($data_resp['message'])) {
                $this->logger->warning('failed to parse request');
    
                return;
            }
    
            list($path, $method, $parameters) = $data;
    
            $this->logger->info(sprintf("Incoming request: %s %s %s", $method, $path, json_encode($parameters)));
    
            $response = $this->kernel->handle(
                $request = Request::create(
                    $path,
                    $method,
                    $parameters
                )
            );
    
            $body = $response->getContent();
            $code = $response->getStatusCode();
    
            $raw   = [];
            $raw[] = $code;
            $raw[] = "Content-Type: application/json";
            $raw[] = "Content-Length: ".strlen($body);
            $raw[] = "\r\n".$body;
    
            $this->logger->info('Response: '.$code.'. Memory used: '.$this->convert(memory_get_usage()).' Time: '.(microtime(true) - $timeStart));
    
            $server->addMessage(
                new \OVM\Multicast\MulticastMessage(
                    "HTTP/1.1 ".implode("\r\n", $raw),
                    \OVM\Multicast\MulticastMessage::TYPE_RESPONSE,
                    $data_resp['meta']['uuid'],
                    '005',
                    '001'
                )
            );
        }
    );
    
    $server->run();
    
    while ($server->getState()) {
        $server->serve();
    }



    $response = $app->handle(\App\Http\Request::fromString($request));

var_dump(\App\Http\Request::fromString($request));

die();


/*
//$result = '';
//var_dump(mb_parse_str("/docs/index.html?1=2&7=4",$result));
//var_dump($result);
//var_dump($_GET);
//var_dump($_POST);

class RequestParser {
    private $method,$url,$_get,$_post,$body;

    public function parse($string){
        $lines = explode(PHP_EOL,$string,1);
        preg_match('/^([\w]+) ([\d\w\/\.\?\-_=]+) /',$lines[0],$matches);//HTTP\/\d\.\d
        $this->method = $matches[1];
        $getMatches = explode('?',$matches[2]);
        parse_str($getMatches[1],$this->_get);
        $this->url = $getMatches[0];

        $lines = explode(PHP_EOL.PHP_EOL,$string,2);

        $this->body = $lines[1];

        if($this->method == 'POST'){
            parse_str($this->body,$this->_post);
        }


//        var_dump($matches);
//        var_dump($lines);
//        var_dump($this);

        return $this;
    }
}*/