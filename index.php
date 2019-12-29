<?php

require_once 'vendor/autoload.php';

use ArrayConversion\Classes\ArrayConversion;



// Multiple array
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

// Object
//$data = (object) $data;

// Single array
//$data = [
//        'name' => 'Abdus Samad',
//        'email' => 'samadocpl@gmail.com'
//];


if (isset($_POST['downloadCSV'])) {
    $table = new ArrayConversion($data);
    $table->toCSV();
}

$toTableInitiate = new ArrayConversion($data);
$toTable = $toTableInitiate->toTable();


$toTableInitiate = new ArrayConversion($data);
$toJson = $toTableInitiate->toJson();


$toTableInitiate = new ArrayConversion($data);
$toXml = $toTableInitiate->toXml();

$value = 'Edit';
$sl = 0;
$toTableInitiate = new ArrayConversion($data);
$table_after_addcolumn = $toTableInitiate->addColumn('#SL', function () use (&$sl) {
    return ++$sl;
})
    ->addColumn('Action', function ($data) use ($value) {
        return '<button class="btn btn-success btn-xs" title="' . $data['name'] . '">' . $value . '</button>';
    })
    ->toTable();


$sl1 = 0;
$toTableInitiate = new ArrayConversion($data);
$table_after_removeColumn = $toTableInitiate->addColumn('#SL', function () use (&$sl1) {
    return ++$sl1;
})
    ->addColumn('Action', function ($data) use ($value) {
        return '<button class="btn btn-success btn-xs" title="' . $data['name'] . '">' . $value . '</button>';
    })
    ->removeColumn('email')
    ->toTable();


$toTableInitiate = new ArrayConversion($data);
$table_with_editColumn = $toTableInitiate->editColumn('email', function ($data) {
    return 'Email: ' . $data['email'];
})->toTable();
?>


<!DOCTYPE html>
<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

<div class="container" id="main-content">
    <h3>Data-<?php echo gettype($data); ?></h3>
    <pre>
        <?php print_r($data); ?>
    </pre>

    <h3>To Table</h3>
    <?php print_r($toTable); ?>

    <h3>To Json</h3>
    <?php print_r($toJson); ?>

    <h3>To XML</h3>
    <textarea rows="10" cols="40">
    <?php echo $toXml; ?>
    </textarea>


    <h3>To CSV</h3>
    <form method="post">
        <button class="btn btn-success" type="submit" value="downloadCSV" name="downloadCSV">Download CSV file</button>
    </form>

    <h3>Add Column</h3>
    <?php print_r($table_after_addcolumn); ?>

    <h3>Remove Column</h3>
    <?php print_r($table_after_removeColumn); ?>

    <h3>Edit Column</h3>
    <?php print_r($table_with_editColumn); ?>

</div>

<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</body>
</html>


