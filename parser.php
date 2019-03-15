<?php
require_once './backup.php';
require_once __DIR__. './vendor/autoload.php';
use GuzzleHttp\Client as Client;

class Parser
{
    private $url;
    private $pictures = [];


    /**
     * Parser constructor.
     * @param string $url
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct(string $url)
    {
        /** @var string $url */
        $this->url = $url;
        $this->validate();
        $this->getArrOfPictures();
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getArrOfPictures()
    {
        preg_match_all('#src="[0-9a-z-/=.,?]+"#i', $this->getBody(), $this->pictures);
        return $this->pictures;
    }


    /**
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getBody()
    {
        return (new Client)->request('GET', $this->url)->getBody();
    }

    /**
     * @return false|int
     */
    private function isCorrectUrl()
    {
        return preg_match('#^http[0-9a-z-=+_/\\\\:,.?]+\.[a-z]{2,3}/?$#i', $this->url);
    }

    /**
     * @throws Exception
     */
    private function validate()
    {
        if(!$this->isCorrectUrl() === (int)1){
            throw new Exception('Entered URL is not correct!');
        }
    }
}

/** @var string $new */
var_dump(new Parser($new));