<div class="js-module block-overview">

    <?php
    $trend_class = empty($delta) ? ' block-overview__content--two-columns' : '';
    ?>
    <div class="block-overview__content<?= $trend_class; ?>">

        <div class="block-overview__metric xf" data-animate="fade-in-up" data-animate-delay="200">

            <div class="block-overview__metric-top block-overview__metric-1 theme__text--primary">
                Total Incidents
            </div>

            <div class="block-overview__metric--value font-heading-3xl theme__text--primary">
                <?php echo number_format($data['total_incidents']); ?>
            </div>

        </div>

        <?php if (!empty($delta)) : ?>
            <div class="block-overview__metric block-overview__metric--trend" data-animate="fade-in-up" data-animate-delay="400">
                <div class="block-overview__metric-top">
                    <div class="block-overview__metric-2  theme__text--primary">
                        Trend
                    </div>
                    <div>
                        <?php
                        $trend_percent = ($delta['type'] === 'equal') ? 'same' : $delta['percent_txt'];
                        $trend_text = ($delta['type'] === 'equal') ? 'as previous year' : 'from previous year';
                        get_template_part('partials/components/component', 'trend-data', [
                            'type' => $delta['type'],
                            'layout' => 'double-line',
                            'percent' => $trend_percent,
                            'text' => $trend_text,
                            'size' => 'large',
                        ]);
                        ?>
                    </div>
                </div>
                <div class="block-overview__metric-bottom">
                    <?php
                    get_template_part('partials/components/component', 'trend-icon', [
                        'type' => ($delta['type'] === 'equal') ? 'equal' : $delta['type'],
                        'size' => 'large',
                        'percent' => $trend_percent,
                        'text' => $trend_text
                    ]);
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="block-overview__metric block-overview__metric--comparison" data-animate="fade-in-up" data-animate-delay="600">
            <?php

            $data_table = get_field('data_table', 'data_interactive');
            $data_table_total = count($data_table);
            $slug = basename(get_permalink());
            $data_arr = [];
            for ($i = 0; $i < $data_table_total; $i++):
                if ($slug == $data_table[$i]['year']):
                    if ($i > 0 && $i < $data_table_total - 1):
                        $data_arr = [$data_table[$i - 1]['total_incidents'], $data_table[$i]['total_incidents'], $data_table[$i + 1]['total_incidents']];
                    elseif ($i == $data_table_total - 1):
                        $data_arr = [$data_table[$i - 1]['total_incidents'], $data_table[$i]['total_incidents'], null];
                    else:
                        $data_arr = [null, $data_table[$i]['total_incidents'], $data_table[$i + 1]['total_incidents']];
                    endif;
                endif;
            endfor;
            $data_arr_str = implode(',', $data_arr);

            ?>
            <div class="block-overview__metric-top block-overview__metric-3  theme__text--primary">
                <?php
                if (empty($delta)):
                    echo 'Comparison with next year';
                elseif (empty($delta_next)):
                    echo 'Comparison with previous year';
                else:
                    echo 'Comparison with previous and next years';
                endif;
                ?>
            </div>
            <div class="block-overview__metric-graphic" data-value="<?= $data_arr_str; ?>">
                <div class="block-overview__metric-graphic-svg-wrapper">
                    <svg width="100%" height="auto" viewBox="0 0 485 171">
                        <!-- El SVG se generará aquí -->
                    </svg>
                    <div class="block-overview__metric-graphic-circle"></div>
                </div>
            </div>
            <div class="block-overview__metric-bottom">

                <?php if (!empty($delta)) : ?>
                    <div>
                        <?php
                        $trend_percent = ($delta['type'] === 'equal') ? 'same' : $delta['percent_txt'];
                        $trend_difference = $delta['current'] - $delta['previous'];
                        $trend_difference_str = $trend_difference == 0 ? 'same' : str_replace('-', '', $trend_difference);
                        $trend_text = $trend_difference < 0 ? 'fewer incidents than previous year' : 'more incidents than previous year';
                        get_template_part('partials/components/component', 'trend-data', [
                            'type' => $delta['type'],
                            'layout' => 'double-line',
                            'percent' => $trend_difference_str, //$trend_percent,
                            'text' => ($delta['type'] === 'equal') ? 'as previous year' : $trend_text,
                            'size' => 'large',
                        ]);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($delta_next)) : ?>
                    <div>
                        <?php
                        $trend_percent_next = ($delta_next['type'] === 'equal') ? 'same' : $delta_next['percent_txt'];
                        $trend_difference_next = $delta_next['current'] - $delta_next['next'];
                        $trend_difference_str_next = $trend_difference_next == 0 ? 'same' : str_replace('-', '', $trend_difference_next);
                        $trend_text_next = $trend_difference_next < 0 ? 'fewer incidents than next year' : 'more incidents than next year';
                        get_template_part('partials/components/component', 'trend-data', [
                            'type' => $delta_next['type'],
                            'layout' => 'double-line',
                            'percent' => $trend_difference_str_next, //$trend_percent_next,
                            'text' => ($delta_next['type'] === 'equal') ? 'as next year' : $trend_text_next,
                            'size' => 'large',
                        ]);
                        ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </div>

    <div class="block-overview__blurb" data-animate="fade-in-up" data-animate-delay="300">
        <h2 class="font-body-xl theme__text--primary"><?php echo $data['intro_text']; ?></h2>
    </div>
</div>