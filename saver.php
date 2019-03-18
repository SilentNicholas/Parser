<?php
require_once  './parser.php';
require_once __DIR__. './vendor/autoload.php';
use GuzzleHttp\Client as Client;

class Save
{
    private $data;
    private $name;
    private $file;


    /**
     * Save constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->name = $url. '.csv';
        $this->file = fopen( __DIR__. '\\'. $this->name, 'w+');
    }

    /**
     * Array of data to save.
     */
    public function getData()
    {
        echo'<pre>';
        print_r($this->data);
        echo'</pre>';
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }
    /**
     * Save data to the file.
     */
    public function saveToFile()
    {
        $this->dataForSave();
        echo 'Path: '. __DIR__.'\\'. $this->name. PHP_EOL. 'Pictures: ' .count($this->data);
        fclose($this->file);
    }


    /**
     * @return string
     * @throws Exception
     */
    private function dataForSave()
    {
        $this->validate();
        return fwrite($this->file, $this->name. PHP_EOL). fputcsv($this->file, $this->data). PHP_EOL;
    }


    /**
     * @throws Exception
     */
    private function validate()
    {
        if(count($this->data) === 0 ){
            throw new Exception('Not found pictures for your URL');
        }
    }
}
