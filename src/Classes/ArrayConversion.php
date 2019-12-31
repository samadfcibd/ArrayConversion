<?php

/**
 * ArrayConversion class used for conversion given array.
 * PHP Version 5
 *
 * @param array | object
 *
 * @category Php-package
 *
 * @package ArrayConversion
 *
 * @author Abdus Samad <samadocpl@gmail.com>
 *
 * @copyright 2019-2020 Abdus Samad
 *
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @link https://github.com/samadfcibd/ArrayConversion
 *
 * @note This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace ArrayConversion\Classes;

use SimpleXMLElement;
use InvalidArgumentException;

/**
 * ArrayConversion class used for conversion given array.
 *
 * At first input data will assigned to $data,
 * after that this data will be processed as per as user demand.
 *
 * @param array | object
 *
 * @category Php-package
 *
 * @package ArrayConversion
 *
 * @author Abdus Samad <samadocpl@gmail.com>
 *
 * @license https://opensource.org/licenses/MIT MIT
 *
 * @Release: <package_version> 1.0.0
 *
 * @link https://github.com/samadfcibd/ArrayConversion
 *
 * @since 011219
 */
class ArrayConversion
{

    /**
     * Input data type
     * 1 = single array
     * 2 = Multidimensional array
     *
     * @var array
     */
    private $_input_type;

    /**
     * Input data
     *
     * @var array
     */
    private $_data;

    /**
     * ArrayConversion constructor.
     * @param $data
     */
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
            $this->_input_type = 2;
            $this->_data = $data;
        } else {
            $this->_input_type = 1;
            $this->_data = $data;
        }
    }

    public function toTable()
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
            return '<table class="table table-bordered">' . $table_head_columns . $table_body_columns . '</table>';

        } else {

            $table_head_columns = '<thead><tr>';
            $table_body_columns = '<tbody><tr>';
            foreach ($this->_data as $key => $value) {
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
        if ($this->_input_type === 1) {
            //$this->_data[$column_name] = $user_function($this->_data);
            $this->_data[$column_name] = call_user_func($user_function, $this->_data);
        } else {
            foreach ($this->_data as $key => $row) {
                //$this->_data[$key][$column_name] = $user_function->__invoke($row);
                $this->_data[$key][$column_name] = call_user_func($user_function, $row);
            }
        }
        return $this;
    }

    public function removeColumn()
    {
        $arguments = func_get_args();

        if (!empty($arguments)) {
            if ($this->_input_type === 1) {
                foreach ($arguments as $column) {
                    unset($this->_data[$column]);
                }
            } else {
                foreach ($this->_data as $key => $row) {
                    foreach ($arguments as $column) {
                        //unset($row[$column]);
                        unset($this->_data[$key][$column]);
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
        if ($this->_input_type === 1) {
            $this->_data[$column_name] = $user_function($this->_data);
        } else {
            foreach ($this->_data as $key => $row) {
                $this->_data[$key][$column_name] = $user_function($row);
            }
        }

        return $this;
    }

    public function toJson()
    {
        return json_encode($this->_data);
    }

    public function toXml()
    {
        // Creating a object of simple XML element
        $xml = new SimpleXMLElement('<?xml version="1.0"?><dataTable></dataTable>');

        // Visit all key value pair
        foreach ($this->_data as $k => $v) {

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
        if ($this->_input_type === 1) {
            fputcsv($f, array_keys($this->_data));
            $set_column_name = true;
        }

        foreach ($this->_data as $row) {
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