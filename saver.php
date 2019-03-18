<?php
require_once './backup.php';
require_once  './parser.php';
require_once __DIR__. './vendor/autoload.php';
use GuzzleHttp\Client as Client;

class Save extends Parser
{
    private $file;

    /**
     * Save constructor.
     * @param string $url
     * @throws Exception
     */
    public function __construct(string $url)
    {
        parent::__construct($url);
        $this->file = fopen(__DIR__. '\pictures.csv', 'w+');
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function saveToFile()
    {
        $this->dataForSave();
        echo 'Path: '. __DIR__.'\pictures.csv' . PHP_EOL. 'Pictures: ' .count($this->getArrOfPictures()[0]);
        fclose($this->file);
    }

    /**
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function dataForSave()
    {
        return fwrite($this->file, $this->url. PHP_EOL). fputcsv($this->file, $this->getArrOfPictures()[0]). PHP_EOL;
    }

}
