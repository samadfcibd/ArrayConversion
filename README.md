# Test Webhook

# ArrayConversion

PHP Library for converting associative arrays as html table, XML, JSON, CSV. Also add, remove or edit column can be possible.

Inspired by [yajra/laravel-datatables](https://github.com/yajra/laravel-datatables)


## Installation

Install the library by composer with following command:
```bash
composer install samad/array-conversion
```


## Documentation
An associative/ multidimensional array or object can be manipulate with this script.
You can convert the array/ object to HTML table, CSV file, JSON or XML data.

Suppose, you have an array as like following:
```bash
$data = [
            [
                'name' => 'Abdus Samad',
                'email' => 'samadocpl@gmail.com'
            ],
            [
                'name' => 'Ibrahim Ahad',
                'email' => 'ahad@gmail.com'
            ]
        ];
```
now, you can convert this `$data` as HTML table
```bash
$toTableInitiate = new ArrayConversion($data);
$toTableInitiate->toTable()
```
also, this `$data` can be converted into following formats:

- CSV file `toCSV()`
- JSON format `toJson()`
- XML format `toXml()`

#### Add, Edit or Remove column

You can add an extra column by using closure. 
As like `Action` to each single array of `$data`
```bash
$addColumnToTable = new ArrayConversion($data);

$addColumnToTable->addColumn('Action', function ($data) {
    return '<button class="btn btn-success btn-xs">Action</button>';
})->toTable();
```
or you can remove single/ multiple column from each single array
```bash
$removeColumnFromTable = new ArrayConversion($data);

$removeColumnFromTable->removeColumn('email', 'name')
                      ->toTable();
```

also, you can edit column from each single array
```bash
$editColumn = new ArrayConversion($data);
$editColumn->editColumn('email', function ($data) {
    return 'Email: ' . $data['email'];
})->toTable();
```

After installation this library, you will see a file `index.php` with details example.

## License

The MIT License (MIT). Please see [License File](https://github.com/samadfcibd/ArrayConversion/blob/master/LICENSE) for more information.

