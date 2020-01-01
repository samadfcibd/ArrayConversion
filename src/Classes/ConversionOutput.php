<?php


namespace ArrayConversion\Classes;


use ArrayConversion\src\Contracts\OutputInterface;

class ConversionOutput implements OutputInterface
{
    public function toHtml()
    {
        if ($this->_input_type === 2) {
            $table_head_columns = '<thead><tr>';
            foreach (array_keys($this->_data[0]) as $key => $value) {
                $table_head_columns .= '<th>' . $value . '</th>';
            }
            $table_head_columns .= '</tr><thead>';

            $table_body_columns = '';
            foreach ($this->_data as $key => $value) {
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
            foreach ($this->_data as $key => $value) {
                $table_head_columns .= '<th>' . $key . '</th>';
                $table_body_columns .= '<td>' . $value . '</td>';
            }
            $table_head_columns .= '<tr></thead>';
            $table_body_columns .= '<tr></tbody>';
            return '<table class="table table-bordered">' .
                $table_head_columns . $table_body_columns . '</table>';
        }
    }

    public function toJson()
    {
        // TODO: Implement toJson() method.
    }

    public function toXml()
    {
        // TODO: Implement toXml() method.
    }
    
    public function toCSV()
    {
        // TODO: Implement toCSV() method.
    }
}