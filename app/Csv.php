<?php

namespace App;

class Csv
{
    /** @var string */
    public $filePath;

    /**
     * Csv constructor.
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Read Csv file and return result in array
     *
     * @return array
     */
    public function readCSV()
    {
        $result = [];

        $handle = fopen($this->filePath, 'r');

        while (($data = fgetcsv($handle, 0, ',')) !== false) {
            $result[] = $data;
        }

        $result = call_user_func_array('array_merge', $result);
        $result = array_filter($result); // remove empty elements

        fclose($handle);

        return $result;
    }
}
