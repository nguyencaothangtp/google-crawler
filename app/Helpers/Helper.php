<?php

namespace App\Helpers;


class Helper
{
    /**
     * Read Csv file and return result in array
     *
     * @param string $filePath
     * @return array
     */
    public static function readCSV(string $filePath) {
        $result = [];

        $handle = fopen($filePath, 'r');

        while (($data = fgetcsv($handle, 0, ',')) !== false) {
            $result[] = $data;
        }

        $result = call_user_func_array('array_merge', $result);
        $result = self::removeEmptyElement($result);

        fclose($handle);

        return $result;
    }

    /**
     * Remove empty element in an array
     *
     * @param array $arr
     * @return array
     */
    public static function removeEmptyElement(array $arr) {
        foreach ($arr as $index => $element) {
            if (empty($element) || $element === '') {
                unset($arr[$index]);
            }
        }

        return array_values($arr);
    }
}
