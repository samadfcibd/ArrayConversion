<?php

namespace ArrayConversion\Classes;


use SimpleXMLElement;
use InvalidArgumentException;

class ArrayConversion
{

    /*
     * 1 = Single array
     * 2 = Multidimensional array
     */
    private $input_type;

    private $data;

    public function __construct($data)
    {
        // if the data is object type then convert it into array
//        if (is_object($data)) {
//            $data = (array)$data;
//        }

        // Check data type
        if (!is_array($data)) {
//            return trigger_error('Data type should be array or object ', E_USER_ERROR);
            throw new InvalidArgumentException("Error");
        }

        if (count($data) != count($data, COUNT_RECURSIVE)) {
            $this->input_type = 2;
            $this->data = $data;
        } else {
            $this->input_type = 1;
            $this->data = $data;
        }
    }

    public function toTable()
    {
        if ($this->input_type === 2) {

            $table_head_columns = '<thead><tr>';
            foreach (array_keys($this->data[0]) as $key => $value) {
                $table_head_columns .= '<th>' . $value . '</th>';
            }
            $table_head_columns .= '</tr><thead>';

            $table_body_columns = '';
            foreach ($this->data as $key => $value) {
                $table_body_columns .= '<tr>';
                foreach ($value as $key => $value) {
                    $table_body_columns .= '<td>' . $value . '</td>';
                }
                $table_body_columns .= '</tr>';
            }
            $table_body_columns = '<tbody>' . $table_body_columns . '</tbody>';
            return '<table class="table table-bordered">' . $table_head_columns . $table_body_columns . '</table>';

        } else {

            $table_head_columns = '<thead><tr>';
            $table_body_columns = '<tbody><tr>';
            foreach ($this->data as $key => $value) {
                $table_head_columns .= '<th>' . $key . '</th>';
                $table_body_columns .= '<td>' . $value . '</td>';
            }
            $table_head_columns .= '<tr></thead>';
            $table_body_columns .= '<tr></tbody>';
            return '<table class="table table-bordered">' . $table_head_columns . $table_body_columns . '</table>';
        }
    }

    public function addColumn($column_name, $user_function)
    {
        if ($this->input_type === 1) {
            //$this->data[$column_name] = $user_function($this->data);
            $this->data[$column_name] = call_user_func($user_function, $this->data);
        } else {
            foreach ($this->data as $key => $row) {
                //$this->data[$key][$column_name] = $user_function->__invoke($row);
                $this->data[$key][$column_name] = call_user_func($user_function, $row);
            }
        }
        return $this;
    }

    public function removeColumn()
    {
        $arguments = func_get_args();

        if (!empty($arguments)) {
            if ($this->input_type === 1) {
                foreach ($arguments as $column) {
                    unset($this->data[$column]);
                }
            } else {
                foreach ($this->data as $key => $row) {
                    foreach ($arguments as $column) {
                        //unset($row[$column]);
                        unset($this->data[$key][$column]);
                    }
                }
            }
        }

//        echo '<pre>';
//        print_r($arguments);
//        exit;
        return $this;
    }

    public function editColumn($column_name, $user_function)
    {
        if ($this->input_type === 1) {
            $this->data[$column_name] = $user_function($this->data);
        } else {
            foreach ($this->data as $key => $row) {
                $this->data[$key][$column_name] = $user_function($row);
            }
        }

        return $this;
    }

    public function toJson()
    {
        return json_encode($this->data);
    }

    public function toXml()
    {
        // Creating a object of simple XML element
        $xml = new SimpleXMLElement('<?xml version="1.0"?><dataTable></dataTable>');

        // Visit all key value pair
        foreach ($this->data as $k => $v) {

            // If there is nested array then
            if (is_array($v)) {
                $child = $xml->addChild("row_$k");
                foreach ($v as $key => $value) {
                    $child->addChild($key, $value);
                }
            } else {
                $xml->addChild($k, $v);
            }
        }
        return $xml->saveXML();
    }

    public function toCSV()
    {

        $fileName = 'ArrayConversion.csv';

        header("Content-Type: application/csv; charset=UTF-8");
        header("Content-Disposition: attachment; filename={$fileName}");

        // Open file with write mode
        $f = fopen('php://output', 'w');

        // Set first row as header
        $set_column_name = false;
        if ($this->input_type === 1) {
            fputcsv($f, array_keys($this->data));
            $set_column_name = true;
        }

        foreach ($this->data as $row) {
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
