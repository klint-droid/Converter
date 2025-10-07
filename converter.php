<?php 

$value = filter_input(INPUT_GET, 'value', FILTER_VALIDATE_FLOAT);
$from = isset($_GET['from']) ? htmlspecialchars($_GET['from']) : '';
$to = isset($_GET['to']) ? htmlspecialchars($_GET['to']) : '';

$valid_units = ['km', 'mi', 'm'];

$result = "";
$error = "";

if (isset($_GET['value'], $_GET['from'], $_GET['to'])){
    if($value === false || !in_array($from, $valid_units) || !in_array($to, $valid_units)){
        $error = "Invalid Input. Please try again";
    }
    else{
        switch($from){
            case 'km': 
                $km_value = $value;
                break;
            case 'mi': 
                $km_value =  $value * 1.609;
                break;
            case 'm':
                $km_value = $value / 1000;
                break;
        }
        switch($to){
            case 'km':
                $converted = $km_value;
                break;
            case 'mi':
                $converted = $km_value / 1.609;
                break;
            case 'm':
                $converted = $km_value * 1000;
                break;
        }
        $result = "<p><strong>Result:</strong> " . htmlspecialchars($value) . " $from = <strong>" . round($converted, 2) . " $to</strong></p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Converter</title>
    <style>
        body {
            font-family: monospace;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 2px solid black;
            border-radius: 10px;
            background-color: azure;
        }

        h1 {
            text-align: center;
            color: blue;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        } 

        input, select, button {
            padding: 10px;
            font-size: 1em;
        }

        button {
            background-color: blue;
            color: whitesmoke;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover{
            background-color: black;
            color: white;
        }

        .error {
            color: red;
        }

        .result {
            text-align: center;
            margin-top: 15px;
            font-size: 1.5em;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h1>Unit Converter</h1>
        <form action="" method="get">
            <label>Value:</label>
            <input type="number" step="any" name="value" value="
            <?php
                echo htmlspecialchars($value ?? '');
            ?>
            " required/>

            <label>From:</label>
            <select name="from" required>
                <option value="">Select Unit</option>
                <option value="km" 
                <?php
                if($from == 'km') echo 'selected';
                ?>
                >Kilometers (km)</option>
                <option value="mi" 
                <?php
                if($from == 'mi') echo 'selected';
                ?>
                >Miles (Mi)</option>
                <option value="m" 
                <?php
                if($from == 'm') echo 'selected';
                ?>
                >Meters (m)</option>
            </select>
            <label>To:</label>
            <select name="to" required>
                <option value="">Select Unit</option>
                <option value="km" 
                <?php
                if($to == 'km') echo 'selected';
                ?>
                >Kilometers (km)</option>
                <option value="mi" 
                <?php
                if($to == 'mi') echo 'selected';
                ?>
                >Miles (Mi)</option>
                <option value="m" 
                <?php
                if($to == 'm') echo 'selected';
                ?>
                >Meters (m)</option>
            </select>
            <button type="submit">Submit</button>
        </form>

        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php elseif ($result): ?>
            <div class="result"><?php echo $result; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>