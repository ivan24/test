<?php
namespace Iterators;

class FileReader extends \SplFileObject
{
    protected $start;

    public function __construct
    (
        $fileName,
        $start = 0,
        $openMode = 'r'
    ){
        $this->start = $start;
        parent::__construct($fileName, $openMode);
    }

    public function readFile()
    {

     $this->seek($this->start);
        $response = '';
        while ($this->valid()) {
            $response .= $this->fgets();
        }
        return $response;
    }
}