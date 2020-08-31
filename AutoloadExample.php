<?php

namespace abolfaazl\productGrabber;

use Codeception\Module\Cli;
use Goutte\Client;

/**
 * This is just an example.
 */
class AutoloadExample
{

    private $data;
    private $url;

    /**
     * @param $url
     * @param $array
     * @return bool
     */
    public function setData($url , $array){
        if (is_array($array)){
            $this->data = $array;
            $this->url = $url;
            return true;
        }
        return false;
    }


    /**
     * @return array|string return a product
     */
    public function getProduct(){

        $client = new Client();
        $crawler = $client->request('GET' , $this->url);

        $product = [];
        foreach ($this->data as $selector => $mode) {
            array_push($product , self::getDetail($selector  , $mode , $crawler));
        }
        return $product;
    }


    /**
     * @param $selector
     * @param $mode
     * @return array|string|null
     */
    private function getDetail($selector , $mode ,$crawler){
        switch ($mode){
            case "img":
                return self::value_helper($crawler->filter($selector)->attr("src"));
                break;

            case "text":
                return self::value_helper($crawler->filter($selector)->extract("_text"));
                break;

            case "src":
                return self::value_helper($crawler->filter($selector)->attr('src'));
                break;

            case "href":
                return self::value_helper($crawler->filter($selector)->attr("href"));
                break;

            case "content":
                return self::value_helper($crawler->filter($selector)->attr("content"));
                break;

            case "alt":
                return self::value_helper($crawler->filter($selector)->attr("alt"));
                break;

            case "title":
                return self::value_helper($crawler->filter($selector)->attr("title"));
                break;

            case "lang":
                return self::value_helper($crawler->filter($selector)->attr("lang"));
                break;

            default:
                return self::value_helper($crawler->filter($selector)->attr($mode));
                break;
        }
    }

    /**
     * @param $value
     * @param bool $array
     */
    private function value_helper($value, $array = false){
        if (!$array){
            if (is_array($value)){
                return end($value);
            }
        }
        return $value;

    }


}
