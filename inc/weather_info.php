<div class="card my-2 p-3">
    <div>
        <?= $weather_info['info'] ?>
    </div>

    <div class="d-flex align-items-center">

        <!-- icon -->
        <div class="me-5">
            <img src="<?= $weather_info['condition_icon'] ?>" class="img-fluid d-block">
        </div>
        <?php if (!empty($weather_info['temperature'])) : ?>
            <div class="me-5">
                <h3><?= $weather_info['temperature'] ?>&deg;</h3>
            </div>
        <?php endif; ?>
        <div class="me-5">
            <?= $weather_info['condition'] ?>
        </div>

        <?php if (!empty($weather_info['max_temp'])) : ?>
            <div class="me-5">
                Day: <?= $weather_info['date'] ?>
            </div>
            <div class="me-5">
                Max. Temperature: <?= $weather_info['max_temp'] ?>&deg;
            </div>
            <div class="me-5">
                Min. Temperature: <?= $weather_info['min_temp'] ?>&deg;
            </div>
        <?php endif; ?>

    </div>

</div>