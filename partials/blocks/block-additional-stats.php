<?php

// 1. tomar los ultimos 3 años
// 2. obtener los valores de las posiciones 8 a 11
// 3. pasaremos el nombre sin guiones y con la primer letra mayuscula (para colocar en 'title')
// 4. en year rangue, el valor que tenga 'year'
// 5. en value, colocaremos el valor de esa columna
// generar todo esto en el array $additional_stats.
//
$additional_stats = [];

$last_3_years = array_slice($incidents_data, -3);

$stats_titles = [
    'bds_votes' => 'BDS Votes',
    'anti_israel_legislation' => 'Anti-Israel Legislation',
    'commencement_disruptions' => 'Commencement Disruptions',
    'encampments' => 'Encampments'
];

foreach ($stats_titles as $key => $title) {
    $field_name = 'additional_stats_' . $key;
    $stat = [
        'title' => $title,
        'description' => get_field($field_name, 'data_interactive')['description'] ?? '',
        'context' => get_field($field_name, 'data_interactive')['context'] ?? '',
        'data' => []
    ];

    foreach ($last_3_years as $year_data) {
        $stat['data'][] = [
            'year_range' => $year_data['year'],
            'value' => $year_data[$key] ?? 0,
            'original_value' => $year_data[$key]
        ];
    }

    $additional_stats[] = $stat;
}

?>
<div class="js-module block-additional-stats theme theme--neutral theme--light">

    <div class="block-additional-stats__inner">

        <h2 class="block-additional-stats__title font-heading-lg theme__text-primary" data-animate="fade-in-up" data-animate-mode="inside-module">
            <?php echo get_field('additional_stats_title', 'data_interactive'); ?>
        </h2>

        <div class="block-additional-stats__content" data-animate="fade-in-up" data-animate-mode="inside-module">

            <!-- Column of years (desktop only) -->
            <div class="block-additional-stats__years font-body-xs theme__text-primary">
                <?php foreach ($additional_stats[0]['data'] as $item): ?>
                    <div class="stat__year stat__year--desktop"><?= $item['year_range'] ?></div>
                <?php endforeach; ?>
            </div>

            <!-- Stat columns -->
            <?php foreach ($additional_stats as $stat): ?>

                <div class="stat <?php if (empty($stat['description'])) echo 'stat--no-description'; ?>">

                    <h3 class="stat__title font-body-md theme__text--primary"><?= $stat['title'] ?></h3>

                    <div class="stat__bars">
                        <div class="stat__bar-group-wrap">
                            <?php foreach ($stat['data'] as $item): ?>
                                <div class="stat__bar-group">
                                    <div class="stat__year stat__year--mobile font-body-xs theme__text--primary"><?= $item['year_range'] ?></div>
                                    <div class="stat__bar-container" style="position: relative;">
                                        <div class="stat__bar font-body-xs <?php if ($item['value'] < 20) echo 'stat__bar--external-value'; ?>" style="--value: <?= (int)$item['value'] > 0 ? (int)$item['value'] : 0 ?>;">
                                            <span class="stat__bar-value <?php if ((int)$item['value'] === 0) echo 'stat__bar-value--zero'; ?>">
                                                <?= $item['original_value'] == '-' || empty($item['original_value']) ? 'No data available' : (int)$item['value'] ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if (!empty($stat['description'])): ?>
                            <?php
                            echo get_button(array(
                                'html_text' => 'About ' . $stat['title'],
                                'tag' => 'button',
                                'class' => 'stat__more-info btn--secondary btn--small btn--icon-after',
                                'icon' => 'plus',
                                'data-tooltip' => $stat['description'],
                            ));
                            ?>

                            <div class="stat__tooltip">
                                <div class="stat__tooltip-notch" aria-hidden="true"></div>
                                <div class="stat__tooltip-notch-2" aria-hidden="true"></div>
                                <div class="stat__tooltip-notch-3" aria-hidden="true"></div>

                                <div class="stat__tooltip-content font-body-xs">
                                    <div class="stat__tooltip-content-block-additional-stats">
                                        <div class="theme__text--secondary">
                                            <?= $stat['description'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="stat__info">
                        <div class="stat__description font-body-sm theme__text--secondary"><?= $stat['context'] ?></div>

                        <?php if (!empty($stat['description'])): ?>
                            <!-- Desktop button -->
                            <button
                                type="button"
                                class="stat__more-info-desktop font-body-sm theme__text-primary"
                                aria-label="Open modal with more information about <?= esc_attr($stat['title']) ?>">
                                About <?= $stat['title'] ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


    </div>

    <!-- Desktop Modal -->
    <div class="stat-modal" role="dialog" aria-modal="true" aria-hidden="true" style="display: none;">
        <div class="stat-modal__overlay" aria-hidden="true"></div>
        <div class="stat-modal__container">
            <div class="stat-modal__content" role="document">
                <button
                    type="button"
                    class="stat-modal__close"
                    aria-label="Close modal">
                    <span aria-hidden="true">
                        <?php include get_template_directory() . '/icons/close.php'; ?>
                    </span>
                </button>
                <h3 class="font-body-md theme__text--primary stat-modal__title"></h3>
                <div class="stat-modal__body"></div>
            </div>
        </div>
    </div>
</div>