<?php

//FUNCTION TO CALCULATE ELECTRICITY RATE WITH GIVEN FORMULA
function calculateElectricityRates($voltage, $current, $rate) {
    $power = ($voltage * $current) / 1000 ; // Power in kWh
    $rateRM = $rate/100; // Rate in RM

    return [
        'power' => $power,
        'rateRM' => $rateRM,
    ]; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //This line checks if the parameter is set in the POST request.
    //If it is set, it converts the value to a float using (float); 
    //otherwise, it assigns the default value. 
    $voltage = isset($_POST['voltage']) ? (float)$_POST['voltage'] : 0;
    $current = isset($_POST['current']) ? (float)$_POST['current'] : 0;
    $rate = isset($_POST['rate']) ? (float)$_POST['rate'] : 0;

    $result = calculateElectricityRates($voltage, $current, $rate);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Electricity Rates Calculator</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Electricity Rates Calculator</h2>
        <!-- METHOD POST -->
        <form method="post">
            <div class="form-group">
                <label for="voltage">Voltage (V):</label>
                <input type="text" class="form-control" id="voltage" name="voltage" required>
            </div>
            <div class="form-group">
                <label for="current">Current (A):</label>
                <input type="text" class="form-control" id="current" name="current" required>
            </div>
            <div class="form-group">
                <label for="rate">Current Rate (sen/kWh):</label>
                <input type="text" class="form-control" id="rate" name="rate" required>
            </div>
            <button type="submit" class="btn btn-primary">Calculate</button>
        </form>

        <?php if(isset($result)): ?>
            <div class="mt-3">
                <h4>Results:</h4>
                <p>Power: <?php echo $result['power']; ?> kw</p>
                <p>Rate: RM <?php echo $result['rateRM']; ?> </p>
            </div>
        <?php endif; ?>
    </div>

    <div class="container mt-5">
        <!--Electricity Rates Table-->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hour</th>
                    <th>Energy (kWh)</th>
                    <th>Total (RM)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $num = 1;
                while ($num <= 24) {
                    $energy = $result['power'] * $num ; // Power * hour (as the power is alr in kw unit)
                    $total = number_format($energy* $result['rateRM'],2); // Energy(kWh) * Rate(sen)

                    echo "<tr>
                            <td>$num</td>
                            <td>$energy</td>
                            <td>$total</td>
                          </tr>";

                    $num++;
                }
                ?>
            </tbody>
        </table>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
