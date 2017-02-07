<?php
namespace App\Http;

use Illuminate\Http\Request as SymfonyRequest;

class Request extends SymfonyRequest {

    public static function fromString($string){
        $method = $baseUrl = $fullUrl = $get = $post = $body = null;

        $lines = explode(PHP_EOL,$string,1);
        preg_match('/^([\w]+) ([\d\w\/\.\?\-_=]+) /',$lines[0],$matches);//HTTP\/\d\.\d
        $method = $matches[1];
        $fullUrl = $matches[2];
        $getMatches = explode('?',$matches[2]);
        parse_str($getMatches[1],$get);
        $baseUrl = $getMatches[0];

        $lines = explode(PHP_EOL.PHP_EOL,$string,2);

        $body = $lines[1];

        if($method == 'POST'){
            parse_str($body,$post);
        }
        //TODO:: support of _method field to override browser method

        return static::create($fullUrl,$method, ($method=='GET' ? $get : $post));
    }

}