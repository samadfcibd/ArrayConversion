<?php


namespace ArrayConversion\Classes;


use ArrayConversion\Contracts\OutputInterface;

class CsvOutput implements OutputInterface
{

    public function getOutput($array_type, $array)
    {
        $fileName = 'ArrayConversion.csv';

        header("Content-Type: application/csv; charset=UTF-8");
        header("Content-Disposition: attachment; filename={$fileName}");

        // Open file with write mode
        $f = fopen('php://output', 'w');

        // Set first row as header
        $set_column_name = false;
        if ($array_type === 1) {
            fputcsv($f, array_keys($array));
            $set_column_name = true;
        }

        foreach ($array as $row) {
            // Set first row as header, if it hasn't been added yet
            if (!$set_column_name) {
                fputcsv($f, array_keys($row));
                $set_column_name = true;
            }

            fputcsv($f, $row);
        }
        // Close the file
        fclose($f);
        // Make sure nothing else is sent, our file is done
        exit;
    }
}