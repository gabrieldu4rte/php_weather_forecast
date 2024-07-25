<?php
require_once 'inc/config.php';
require_once 'inc/api.php';

$city = 'Ananindeua';
if (isset($_GET['city'])) {
    $city = $_GET['city'];
}
$days = 5;

$results = Api::get($city, $days);

if ($results['status'] == 'error') {
    echo $results['message'];
    exit;
}

$data = json_decode($results['data'], true);


//location data
$location = [];
$location['name'] = $data['location']['name'];
$location['region'] = $data['location']['region'];
$location['country'] = $data['location']['country'];
$location['current_time'] = $data['location']['localtime'];


//current wheater data
$current = [];
$current['info'] = 'Right now:';
$current['temperature'] = $data['current']['temp_c'];
$current['condition'] = $data['current']['condition']['text'];
$current['condition_icon'] = $data['current']['condition']['icon'];
$current['wind_speed'] = $data['current']['wind_kph'];

//forecast weather data
$forecast = [];
foreach ($data['forecast']['forecastday'] as $day) {
    $forecast_day = [];
    $forecast_day['info'] = null;
    $forecast_day['date'] = $day['date'];
    $forecast_day['condition'] = $day['day']['condition']['text'];
    $forecast_day['condition_icon'] = $day['day']['condition']['icon'];
    $forecast_day['max_temp'] = $day['day']['maxtemp_c'];
    $forecast_day['min_temp'] = $day['day']['mintemp_c'];
    $forecast[] = $forecast_day;

}

function city_selected($city, $selected_city){
    if ($city == $selected_city) {
        return 'selected';
    }
    return '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-dark text-white">
    <div class="container-fluid mt5">
        <div class="row justify-content-center mt-5">
            <div class="col-10 p-5 bg-light text-black">

                <div class="row">
                    <div class="col-9">
                        <h3><h3>Weather on <strong><?= $location['name'] ?></strong></h3></h3>
                        <p class="my-2">Region: <?= $location['region'] ?> | <?= $location['country'] ?> | <?= $location['current_time'] ?> | Forecast to: <strong><?= $days ?></strong> days</p>
                    </div>
                </div>
                <div class="col-3 text-end">
                    <select class="form-select">
                        <option value="Ananindeua" <?= city_selected('Ananindeua', $city) ?>>Ananindeua</option>
                        <option value="Xerem"<?= city_selected('Xerem', $city) ?>>Xerem</option>
                        <option value="Itapeva"<?= city_selected('Itapeva', $city) ?>>Itapeva</option>
                        <option value="Pomerode"<?= city_selected('Pomerode', $city) ?>>Pomerode</option>
                        <option value="Joinville"<?= city_selected('Joinville', $city) ?>>Joinville</option>
                        <option value="Caucaia"<?= city_selected('Caucaia', $city) ?>>Caucaia</option>
                    </select>
                </div>

                <!-- current -->
                <?php
                $weather_info = $current;
                include 'inc/weather_info.php';
                ?>
                <!-- forecast -->
                <?php foreach($forecast as $day): ?>
                <?php 
                $weather_info = $day;
                include 'inc/weather_info.php';
                ?>
                <?php endforeach;?>
            </div>
        </div>
    </div>

<script>
    const select = document.querySelector('select');
    select.addEventListener('change', (e)=>{
        const city = e.target.value;
        window.location.href = `index.php?city=${city}`;
    })
</script>


</body>

</html>