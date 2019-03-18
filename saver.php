<?php
require_once  './parser.php';
require_once __DIR__. './vendor/autoload.php';
use GuzzleHttp\Client as Client;

class Save
{
    private $url;
    private $pictures;
    private $file;


    /**
     * Save constructor.
     * @param $url
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->pictures = (new Parser($url))->getArrOfPictures();
        $this->file = fopen( 'pictures.csv', 'w+');
    }


    /**
     * Save pictures to the 'pictures.csv'.
     */
    public function saveToFile()
    {
        $this->dataForSave();
        echo 'Path: '. __DIR__.'\pictures.csv' . PHP_EOL. 'Pictures: ' .count($this->pictures);
        fclose($this->file);
    }


    /**
     * @return string
     * @throws Exception
     */
    private function dataForSave()
    {
        $this->validate();
        return fwrite($this->file, $this->url. PHP_EOL). fputcsv($this->file, $this->pictures). PHP_EOL;
    }

    /**
     * @throws Exception
     */
    private function validate()
    {
        if(count($this->pictures) === 0 ){
            throw new Exception('Not found pictures for your URL');
        }
    }
}
