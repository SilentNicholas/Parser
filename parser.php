<?php
require_once './saver.php';
require_once __DIR__. './vendor/autoload.php';
use GuzzleHttp\Client as Client;

if($argc != 2){
    die(PHP_EOL . 'Use: php parser.php URL' . PHP_EOL);
}

$new = $argv[1];

class Parser
{
    private $url;
    private $pictures = [];


    /**
     * Parser constructor.
     * @param string $url
     * @throws Exception
     */
    public function __construct(string $url)
    {
        /** @var string $url */
        $this->validate();
        $this->url = $url;
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function getArrOfPictures()
    {
        preg_match_all('#src="[0-9a-z-/=.,?]+"#i', $this->getBody(), $this->pictures);
        return $this->pictures[0];
    }


    /**
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBody()
    {
        return (new Client)->request('GET', $this->url)->getBody();
    }

    /**
     * @return false|int
     */
    private function isCorrectUrl()
    {
        return preg_match('#^https?[0-9a-z-=+_/\\\\:,.?]+\.[a-z]{2,3}/?$#i', $this->url);
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
echo (new Save($new))->saveToFile();