<?php

/**
 * ArrayConversion class used for conversion given array.
 * PHP Version 5
 *
 * @param array|object
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


use ArrayConversion\Exceptions\InvalidInputException;

/**
 * ArrayConversion class used for conversion given array.
 *
 * At first input data will assigned to $data,
 * after that this data will be processed as per as user demand.
 *
 * @param array|object
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
     *
     * @param array|object $data data
     */
    public function __construct($data)
    {
        try {
            // if the data is object type then convert it into array
            if (is_object($data)) {
                $data = (array)$data;
            }

            // Check data type
            if (!is_array($data)) {
                throw new InvalidInputException('Data type should be array or object');
            }

            if (count($data) != count($data, COUNT_RECURSIVE)) {
                $this->_input_type = 2;
                $this->_data = $data;
            } else {
                $this->_input_type = 1;
                $this->_data = $data;
            }
        } catch (InvalidInputException $e) {
            $e->getError();
        }

    }

    /**
     * Add new column to data array
     *
     * @param string $column_name Column name
     * @param closure $user_function Column content
     *
     * @return $this
     */
    public function addColumn($column_name, $user_function)
    {
        if ($this->_input_type === 1) {
            $this->_data[$column_name] = $user_function->__invoke($this->_data);
        } else {
            foreach ($this->_data as $key => $row) {
                $this->_data[$key][$column_name] = $user_function->__invoke($row);
            }
        }
        return $this;
    }

    /**
     * Remove column from data array
     *
     * @return $this
     */
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
        return $this;
    }

    /**
     * Edit column of data array
     *
     * @param string $column_name Column name
     * @param closure $user_function Column content
     *
     * @return $this
     */
    public function editColumn($column_name, $user_function)
    {
        if ($this->_input_type === 1) {
            $this->_data[$column_name] = $user_function->__invoke($this->_data);
        } else {
            foreach ($this->_data as $key => $row) {
                $this->_data[$key][$column_name] = $user_function->__invoke($row);
            }
        }

        return $this;
    }

    /**
     * Convert data into html table
     *
     * @return string
     */
    public function toTable()
    {
        $conversionOutput = new HtmlOutput();
        return $conversionOutput->getOutput($this->_input_type, $this->_data);
    }

    /**
     * Convert data array into json format
     *
     * @return false|string
     */
    public function toJson()
    {
        $conversionOutput = new JsonOutput();
        return $conversionOutput->getOutput($this->_input_type, $this->_data);
    }

    /**
     * Convert data array into XML format
     *
     * @return mixed
     */
    public function toXml()
    {
        $conversionOutput = new XmlOutput();
        return $conversionOutput->getOutput($this->_input_type, $this->_data);
    }

    /**
     * Download CSV file
     *
     * @return csv
     */
    public function toCSV()
    {
        $conversionOutput = new CsvOutput();
        return $conversionOutput->getOutput($this->_input_type, $this->_data);
    }
}
