<div class="js-module block-data-interactive-main-graphs theme theme--neutral">

    <?php

    $block_external_content = array(
        'module_color_settings' => array(
            'color_palette' => 'pink;',
            'color_mode' => 'bright',
            'alignment' => 'block--align-center',
            'title' => 'font-heading-lg'
        ),
        'title' => get_field('data_interactive_landing_page_title', 'data_interactive'),
        'heading_tag' => 'h1',
        'text' => get_field('data_interactive_landing_page_intro_text', 'data_interactive'),
        'tagline' => get_field('data_interactive_landing_page_tagline', 'data_interactive'),
        'note' => '',
        /* 
        'button_1' => array(
            'html_text' => 'Show more cards',
            'class' => 'more-cards-btn btn--primary btn--large btn--icon-after',
            'icon' => 'chevron-right',
        ),
        'button_2' => array(
            'html_text' => 'Share',
            'class' => 'share-btn btn--secondary btn--large btn--icon-after',
            'icon' => 'chevron-right',
        ), */
        'button_1' => 0,
        'button_2' => 0,
        'button_3' => 0
    );

    $block_index = 0;

    include 'blocks/block-heading.php';

    $graph_1_id = 'graph-incidents-' . uniqid();
    $graph_2_id = 'graph-incidents-subtypes-' . uniqid();

    ?>

    <div class="main-graphs font-body-sm" data-animate="fade-up" data-animate-delay="500">

        <div class="main-graphs__tabs">
            <button class="main-graphs__tab main-graphs__tab--selected" data-target="<?= $graph_1_id; ?>" aria-label="Explore trends by year">Total Incidents</button>
            <button class="main-graphs__tab" data-target="<?= $graph_2_id; ?>" aria-label="Explore trends by subtype of incident">Incidents subtypes</button>
            <div class="main-graphs__tabs-tooltip font-body-xs"></div>
        </div>

        <div class="main-graphs__holder">

            <!-- GRAPH INCIDENTS -->

            <div id="<?= $graph_1_id; ?>" class="graph-incidents">

                <div class="graph-incidents__scroller hide-scrollbar">
                    <div class="graph-incidents__wrapper">
                        <svg class="graph-incidents__svg" width="700" height="300" viewBox="0 0 700 300"></svg>
                        <div class="graph-incidents__timeline-labels"></div>
                        <div class="graph-incidents__dotted-line"></div>
                    </div>

                    <div class="graph-incidents__progress-bar"></div>
                    <div class="graph-incidents__pulse">
                        <div class="graph-incidents__pulse-circle"></div>
                    </div>
                </div>

                <div class="graph-incidents__details-wrapper">
                    <div class="graph-incidents__details">
                        <div class="graph-incidents__details-info">
                            <?= get_field('total_incidents_graph_blurb', 'data_interactive'); ?>
                        </div>
                        <div class="graph-incidents__controls">
                            <button class="pause-btn" aria-label="Play/Pause Animation">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M3.33398 3.32642C3.33398 2.67898 3.33398 2.35526 3.46898 2.17681C3.58658 2.02135 3.76633 1.92515 3.96092 1.91353C4.18427 1.9002 4.45363 2.07977 4.99233 2.4389L12.0027 7.11248C12.4478 7.40923 12.6704 7.55761 12.7479 7.74462C12.8158 7.90813 12.8158 8.09188 12.7479 8.25538C12.6704 8.4424 12.4478 8.59077 12.0027 8.88752L4.99233 13.5611C4.45363 13.9202 4.18427 14.0998 3.96092 14.0865C3.76633 14.0749 3.58658 13.9787 3.46898 13.8232C3.33398 13.6447 3.33398 13.321 3.33398 12.6736V3.32642Z" stroke="#121F41" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                            <button class="reset-btn" aria-label="Reset Animation">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M1.33398 6.66667C1.33398 6.66667 2.67064 4.84548 3.75654 3.75883C4.84244 2.67218 6.34305 2 8.00065 2C11.3144 2 14.0007 4.68629 14.0007 8C14.0007 11.3137 11.3144 14 8.00065 14C5.7798 14 3.84077 12.7934 2.80334 11M1.33398 6.66667V2.66667M1.33398 6.66667H5.33398" stroke="#B0A7A6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <div class="graph-incidents__details-period">Incidents on <span></span></div>
                        <div class="graph-incidents__details-number">2,103</div>
                        <div class="graph-incidents__details-percent">
                            <div class="graph-incidents__details-percent-num">
                                <div class="graph-incidents__details-percent-num-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="13" viewBox="0 0 10 13" fill="none">
                                        <path d="M5 11.4999V2.23096" stroke="#FF1C20" stroke-width="1.5" stroke-linecap="square" />
                                        <path d="M1.13867 5.36207L5.00075 1.5L8.86282 5.36207" stroke="#FF1C20" stroke-width="1.5" stroke-linecap="square" />
                                    </svg>
                                </div>
                                <div class="graph-incidents__details-percent-num-txt"></div>
                            </div>
                            <div class="graph-incidents__details-percent-text">from previous year</div>
                        </div>
                    </div>
                </div>

                <div class="graph-incidents__tooltip font-body-xs">
                    <div class="graph-incidents__tooltip-holder">
                        <div class="graph-incidents__tooltip-period">Total incidents <span></span></div>
                        <div class="graph-incidents__tooltip-number"></div>
                        <div class="graph-incidents__tooltip-percent-num">
                            <div class="graph-incidents__tooltip-percent-num-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="13" viewBox="0 0 10 13" fill="none">
                                    <path d="M5 11.4999V2.23096" stroke="#FF1C20" stroke-width="1.5" stroke-linecap="square" />
                                    <path d="M1.13867 5.36207L5.00075 1.5L8.86282 5.36207" stroke="#FF1C20" stroke-width="1.5" stroke-linecap="square" />
                                </svg>
                            </div>
                            <div class="graph-incidents__tooltip-percent-num-txt"><span></span> from previous year</div>
                        </div>
                        <?php
                        echo get_button(array(
                            'href' => '#',
                            'html_text' => 'Go deeper into this year',
                            'class' => 'graph-incidents__tooltip-btn btn--secondary btn--small btn--icon-after',
                            'icon' => 'chevron-right',
                            'aria-label' => 'Go deeper into this year',
                        ));
                        ?>
                    </div>
                </div>

            </div>

            <!-- GRAPH SUBTYPES -->

            <div id="<?= $graph_2_id; ?>" class="graph-incidents-subtypes">

                <div class="graph-incidents-subtypes__scroller hide-scrollbar">
                    <div class="graph-incidents-subtypes__wrapper">
                        <svg class="graph-incidents-subtypes__svg" width="700" height="300" viewBox="0 0 700 300"></svg>
                        <div class="graph-incidents-subtypes__timeline-labels"></div>
                        <div class="graph-incidents-subtypes__dotted-line"></div>
                        <div class="graph-incidents-subtypes__solid-line font-body-xs">
                            <div class="graph-incidents-subtypes__solid-line-line"></div>
                            <div class="graph-incidents-subtypes__tooltip">
                                <div class="graph-incidents-subtypes__tooltip-holder">
                                    <?php
                                    echo get_button(array(
                                        'href' => '#',
                                        'html_text' => 'Go deeper into this year',
                                        'class' => 'graph-incidents-subtypes__tooltip-btn btn--secondary btn--small btn--icon-after',
                                        'icon' => 'chevron-right',
                                        'aria-label' => 'Go deeper into this year',
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="graph-incidents-subtypes__filter-scroller hide-scrollbar">
                    <div class="graph-incidents-subtypes__filter-wrapper font-body-sm">
                        <?php
                        $filters_html = '';
                        for ($n = 0; $n < count($subtype_data); $n++) {
                            $subtype = $subtype_data[$n];
                            $filters_html .= "<button class='graph-incidents-subtypes__filter-btn' data-index='{$n}'><span></span>{$subtype['title']}</button>";
                        }
                        echo $filters_html;
                        ?>
                    </div>
                </div>

                <div class="graph-incidents-subtypes__disclaimer font-body-xs">
                    <p>*No information on incident type prior to 2022</p>
                </div>

                <div class="graph-incidents-subtypes__details-wrapper">
                    <div class="graph-incidents-subtypes__details">
                        <div class="graph-incidents-subtypes__details-info">
                            <p class="graph-incidents-subtypes__details-title"><?= $subtype_data[0]['subtitle']; ?></p>
                            <?= $subtype_data[0]['text']; ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script>
        /* window.mainGraphsData = [
            { year: '2015-2016', total: 23, article: null, assault: null, physical_harassmen: null},
            { year: '2016-2017', total: 69, article: null, assault: null, physical_harassmen: null },
            { year: '2017-2018', total: 108, article: null, assault: null, physical_harassmen: null },
            { year: '2018-2019', total: 168, article: null, assault: null, physical_harassmen: null },
            { year: '2019-2020', total: 180, article: null, assault: null, physical_harassmen: null },
            { year: '2020-2021', total: 254, article: 100, assault: 150, physical_harassmen: 50 },
            { year: '2021-2022', total: 225, article: 200, assault: 180, physical_harassmen: 10 },
            { year: '2022-2023', total: 289, article: 150, assault: 200, physical_harassmen: 120 },
            { year: '2023-2024', total: 1853, article: 1500, assault: 1000, physical_harassmen: 300 },
            { year: '2024-2025', total: 2103, article: 1900, assault: 2000, physical_harassmen: 1000 },
        ]; */
        window.mainGraphsData = <?php echo str_replace('total_incidents', 'total', json_encode($incidents_data)); ?>;
        window.subtypeData = <?php echo json_encode($subtype_data); ?>
    </script>

</div>