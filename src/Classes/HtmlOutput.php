<?php


namespace ArrayConversion\Classes;

use ArrayConversion\Contracts\OutputInterface;

class HtmlOutput implements OutputInterface
{

    public function getOutput($array_type, $array)
    {
        if ($array_type === 2) {
            $table_head_columns = '<thead><tr>';
            foreach (array_keys($array[0]) as $key => $value) {
                $table_head_columns .= '<th>' . $value . '</th>';
            }
            $table_head_columns .= '</tr><thead>';

            $table_body_columns = '';
            foreach ($array as $key => $value) {
                $table_body_columns .= '<tr>';
                foreach ($value as $key => $value) {
                    $table_body_columns .= '<td>' . $value . '</td>';
                }
                $table_body_columns .= '</tr>';
            }
            $table_body_columns = '<tbody>' . $table_body_columns . '</tbody>';
            return '<table class="table table-bordered">' .
                $table_head_columns . $table_body_columns . '</table>';
        } else {
            $table_head_columns = '<thead><tr>';
            $table_body_columns = '<tbody><tr>';
            foreach ($array as $key => $value) {
                $table_head_columns .= '<th>' . $key . '</th>';
                $table_body_columns .= '<td>' . $value . '</td>';
            }
            $table_head_columns .= '<tr></thead>';
            $table_body_columns .= '<tr></tbody>';
            return '<table class="table table-bordered">' .
                $table_head_columns . $table_body_columns . '</table>';
        }
    }
}