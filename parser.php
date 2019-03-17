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
        return $this->pictures;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function saveToFile()
    {
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'pictures.csv', $this->dataForSave());
        echo 'Path: '. __FILE__ . PHP_EOL. 'Pictures: ' .count($this->getArrOfPictures()[0]);
    }

    /**
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function dataForSave()
    {
        return $this->url. PHP_EOL. implode(';', $this->getArrOfPictures()[0]);
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
var_dump((new Parser($new))->saveToFile());