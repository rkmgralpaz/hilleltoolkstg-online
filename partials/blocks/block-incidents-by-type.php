<?php
if (!get_field('other_stats_show')) {
    return; // Do not display the block if the custom field 'other_stats_show' is false
}

$has_valid_incidents = array_reduce($data['incidents'], function ($carry, $incident) {
    return $carry || ($incident['name'] !== 'others' && $incident['total'] > 0);
}, false);

if ($has_valid_incidents): ?>
    <div class="js-module block-incidents-by-type">

        <?php
        echo get_dynamic_heading(
            $data['incidents_by_type']['subtitle'],
            'h2',
            'block-incidents-by-type__title font-heading-lg theme__text--primary',
            ['data-animate' => 'fade-in-up']
        );
        ?>

        <div class="block-incidents-by-type__bar-wrapper">
            <div class="block-incidents-by-type__bar" role="list" data-animate="fade-in-up" data-animate-mode="inside-module">
                <?php
                // Usar el payload ya normalizado: filtrar segmentos con porcentaje > 0
                $segments = array_values(array_filter($data['incidents'], function ($it) {
                    $pct = isset($it['percent_of_total']) ? floatval(str_replace('%', '', $it['percent_of_total'])) : 0;
                    return $pct > 0;
                }));
                $total = count($segments);
                ?>
                <?php foreach ($segments as $index => $incident): ?>
                    <?php
                    $percent_num = isset($incident['percent_of_total']) ? floatval(str_replace('%', '', $incident['percent_of_total'])) : 0;
                    // Clases first/last calculadas sobre los segmentos realmente visibles
                    $is_first = ($index === 0) ? ' is-first' : '';
                    $is_last  = ($index === $total - 1) ? ' is-last' : '';
                    // Si hay una única barra, debe tener ambas clases
                    if ($total === 1) {
                        $is_first = ' is-first';
                        $is_last  = ' is-last';
                    }

                    // Clase adicional para porcentajes menores al 10%
                    $highlight_class = ($percent_num < 4) ? ' block-incidents-by-type__bar-percent--hidden' : '';
                    ?>
                    <div
                        class="block-incidents-by-type__bar-segment<?= $is_first . $is_last ?>"
                        style="width: <?= $percent_num ?>%; background-color: <?= $incident['color'] ?>;"
                        data-index="<?= $index ?>"
                        data-label="<?= esc_attr($incident['name']) ?>"
                        data-count="<?= esc_attr($incident['total']) ?>"
                        data-percent="<?= esc_attr($incident['percent_of_total']) ?>"
                        data-trend="<?= esc_attr($incident['trend_type']) ?>"
                        data-change="<?= esc_attr($incident['trend_percent']) ?>">

                        <span class="block-incidents-by-type__bar-percent font-body-md theme__text--primary <?= $highlight_class ?>">
                            <?= $incident['percent_of_total'] ?>
                        </span>


                        <div class="block-incidents-by-type__tooltip--responsive">
                            <div>
                                <?php
                                get_template_part('partials/components/component', 'color-key-item', [
                                    'label' => get_subtype_title($incident['name']),
                                    'color' => $incident['color'],
                                ]);

                                ?>
                            </div>
                            <div class="incident-popup__middle">
                                <div class="incident-popup__left">
                                    <span class="incident-popup__count font-heading-3xl theme__text--primary"><?php echo $incident['total']; ?></span>
                                    <span class="theme__text--secondary font-body-sm">Incidents</span>
                                </div>
                                <div class="incident-popup__right">
                                    <div class="incident-popup__stats-group font-body-sm">
                                        <span class="incident-popup__percent theme__text--primary"><?php echo $incident['percent_of_total']; ?></span>
                                        <span class="theme__text--secondary">of all incidents this year</span>
                                    </div>
                                    <div class="incident-popup__trend">
                                        <?php if (!empty($incident['trend_type']) && !empty($incident['trend_percent'])): ?>
                                            <?php
                                            get_template_part('partials/components/component', 'trend-data', [
                                                'type'    => $incident['trend_type'],
                                                'layout'  => 'double-line',
                                                'percent' => $incident['trend_percent'],
                                                'text'    => ($incident['trend_type'] === 'equal') ? 'As previous year' : 'from previous year',
                                                'size'    => 'large',
                                            ]);
                                            ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="block-incidents-by-type__tooltip">
                            <div class="block-incidents-by-type__tooltip-notch" aria-hidden="true"></div>
                            <div class="block-incidents-by-type__tooltip-notch-2" aria-hidden="true"></div>
                            <div class="block-incidents-by-type__tooltip-notch-3" aria-hidden="true"></div>
                            <div class="block-incidents-by-type__tooltip-inner">
                                <?php
                                get_template_part('partials/components/component', 'color-key-item', [
                                    'label' => get_subtype_title($incident['name']),
                                    'color' => $incident['color'],
                                ]);
                                ?>
                                <div class="block-incidents-by-type__tooltip-stats font-body-sm">
                                    <div class="block-incidents-by-type__tooltip-stats-group">
                                        <span class="block-incidents-by-type__tooltip-count theme__text--primary"><?php echo $incident['total']; ?></span>
                                        <span class="theme__text--secondary">Incidents</span>
                                    </div>
                                    <div class="block-incidents-by-type__tooltip-stats-group">
                                        <span class="block-incidents-by-type__tooltip-percent theme__text--primary"><?php echo $incident['percent_of_total']; ?></span>
                                        <span class="theme__text--secondary">of all incidents this year</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="block-incidents-by-type__tooltip-trend">
                                        <?php if (!empty($incident['trend_type']) && !empty($incident['trend_percent'])): ?>
                                            <?php
                                            get_template_part('partials/components/component', 'trend-data', [
                                                'type'    => $incident['trend_type'],
                                                'layout'  => 'single-line',
                                                'percent' => $incident['trend_percent'],
                                                'text'    => ($incident['trend_type'] === 'equal') ? 'As previous year' : 'from previous year',
                                                'size'    => 'small',
                                            ]);
                                            ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php
            $color_labels = array_map(function ($incident) {
                // percent_of_total viene con '%', lo pasamos a número para no duplicar el símbolo en el HTML
                $pct = isset($incident['percent_of_total'])
                    ? floatval(str_replace('%', '', $incident['percent_of_total']))
                    : 0;

                return [
                    'label'      => get_subtype_title( $incident['name']),
                    'color'      => $incident['color'],
                    'percentage' => $pct, // sin el símbolo; el HTML ya agrega %
                ];
            }, $data['incidents']);
            ?>
            <div class="block-incidents-by-type__color-keys" data-animate="fade-in-up" data-animate-delay="200" data-animate-mode="inside-module">

                <div class="color-key color-key--horizontal color-key--not-clickable theme--neutral theme--mode-light">
                    <?php
                    $current_index = 0; // Inicializar el índice manualmente
                    foreach ($color_labels as $item): ?>
                        <?php
                        $label = $item['label'];
                        $color = $item['color'];
                        $percentage = isset($item['percentage']) ? floatval($item['percentage']) : 0;

                        // Mostrar solo si el porcentaje es mayor a 0
                        if ($percentage > 0):
                            $percentage_attr = ' data-percentage="' . esc_attr($percentage) . '"';
                        ?>
                            <div
                                class="color-key__item"
                                data-index="<?= $current_index ?>"
                                <?= $percentage_attr ?>
                                data-label="<?= $label ?>">
                                <!-- Usar el índice manual -->
                                <div>
                                    <span class="color-key__item-dot" style="background-color: <?= $color ?>;"></span>
                                    <span class="color-key__item-text font-body-sm theme__text--primary"><?= esc_html($label) ?></span>
                                </div>
                                <div class="color-key__item-percentage-wrapper">
                                    <span class="color-key__item-percentage font-body-sm theme__text--primary"><?= esc_html($percentage) ?>%</span>
                                </div>
                            </div>
                            <?php
                            $current_index++; // Incrementar el índice solo si se muestra el elemento
                            ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>

        <div class="block-incidents-by-type__blurb font-body-md theme__text--primary" data-animate="fade-in-up" data-animate-delay="300" data-animate-mode="inside-module">
            <?php echo $data['incidents_by_type']['context']; ?>
        </div>
    </div>
<?php endif; ?>
