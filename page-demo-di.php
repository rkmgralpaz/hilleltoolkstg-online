<?php get_header(); ?>

<div class="theme theme--neutral theme--mode-light max-width">

    <!-- <div class="font-heading-3xl theme__text--primary site-padding" data-animate="fade-in-up">
        Heading 3XL
    </div> -->

    <?php include 'partials/blocks/block-tiles.php'; ?>

    <div class="site-padding">

        <?php
        $color_labels = [
            ['label' => 'Article/Publication', 'color' => '#729AFD'],
            ['label' => 'Assault', 'color' => '#C08963'],
            ['label' => 'Physical Harassment', 'color' => '#F7BE74'],
            ['label' => 'Vandalism/Graffiti', 'color' => '#7DB39A'],
            ['label' => 'Social Media/Email', 'color' => '#A47BDA'],
            ['label' => 'Hate Speech', 'color' => '#FFCCFF'],
        ];
        ?>

        <div class="demo-margin" data-animate="fade-in-up">
            <?php
            get_template_part('partials/components/component', 'color-key', [
                'group_orientation' => 'horizontal',
                'clickable' => false,
                'labels' => $color_labels
            ]);
            ?>
        </div>

        <div class="demo-margin" data-animate="fade-in-up">
            <?php
            get_template_part('partials/components/component', 'color-key', [
                'group_orientation' => 'horizontal',
                'clickable' => true,
                'labels' => $color_labels
            ]);
            ?>
        </div>

        <div class="wrap-vertical-labels" data-animate="fade-in-up">
            <div class="demo-margin">
                <?php
                get_template_part('partials/components/component', 'color-key', [
                    'group_orientation' => 'vertical',
                    'clickable' => false,
                    'labels' => $color_labels
                ]);
                ?>
            </div>

            <div class="demo-margin">
                <?php
                get_template_part('partials/components/component', 'color-key', [
                    'group_orientation' => 'vertical',
                    'clickable' => true,
                    'labels' => $color_labels
                ]);
                ?>
            </div>

        </div>

        <div class="wrap-vertical-labels" data-animate="fade-in-up">
            <div>
                <div class="demo-margin">
                    <?php
                    get_template_part('partials/components/component', 'trend-icon', [
                        'type' => 'increase',
                        'size' => 'small'
                    ]);
                    ?>
                </div>
                <div class="demo-margin">
                    <?php
                    get_template_part('partials/components/component', 'trend-icon', [
                        'type' => 'increase',
                        'size' => 'large'
                    ]);
                    ?>
                </div>
            </div>
            <div>
                <div class="demo-margin">
                    <?php
                    get_template_part('partials/components/component', 'trend-icon', [
                        'type' => 'decrease',
                        'size' => 'small'
                    ]);
                    ?>
                </div>
                <div class="demo-margin">
                    <?php
                    get_template_part('partials/components/component', 'trend-icon', [
                        'type' => 'decrease',
                        'size' => 'large'
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <div class="wrap-vertical-labels wrap-vertical-labels--data-trend" data-animate="fade-in-up">
            <div class="demo-margin">
                <?php
                get_template_part('partials/components/component', 'trend-data', [
                    'type' => 'increase',
                    'layout' => 'single-line',
                    'percent' => '230%',
                    'text' => 'from previous year',
                    'size' => 'small',
                ]);
                ?>
            </div>

            <div class="demo-margin">
                <?php
                get_template_part('partials/components/component', 'trend-data', [
                    'type' => 'decrease',
                    'layout' => 'single-line',
                    'percent' => '230%',
                    'text' => 'from previous year',
                    'size' => 'small',
                ]);
                ?>
            </div>
        </div>

        <div class="wrap-vertical-labels wrap-vertical-labels--data-trend" data-animate="fade-in-up">
            <div class="demo-margin">
                <?php
                get_template_part('partials/components/component', 'trend-data', [
                    'type' => 'increase',
                    'layout' => 'single-line',
                    'percent' => '230%',
                    'text' => 'from previous year',
                    'size' => 'large',
                ]);
                ?>
            </div>

            <div class="demo-margin">
                <?php
                get_template_part('partials/components/component', 'trend-data', [
                    'type' => 'decrease',
                    'layout' => 'single-line',
                    'percent' => '230%',
                    'text' => 'from previous year',
                    'size' => 'large',
                ]);
                ?>
            </div>
        </div>

        <div class="wrap-vertical-labels wrap-vertical-labels--data-trend" data-animate="fade-in-up">
            <div class="demo-margin">
                <?php
                get_template_part('partials/components/component', 'trend-data', [
                    'type' => 'increase',
                    'layout' => 'double-line',
                    'percent' => '230%',
                    'text' => 'from previous year',
                    'size' => 'small',
                ]);
                ?>
            </div>
            <div class="demo-margin">
                <?php
                get_template_part('partials/components/component', 'trend-data', [
                    'type' => 'decrease',
                    'layout' => 'double-line',
                    'percent' => '230%',
                    'text' => 'from previous year',
                    'size' => 'small',
                ]);
                ?>
            </div>

        </div>

        <div class="wrap-vertical-labels wrap-vertical-labels--data-trend" data-animate="fade-in-up">
            <div class="demo-margin">
                <?php
                get_template_part('partials/components/component', 'trend-data', [
                    'type' => 'increase',
                    'layout' => 'double-line',
                    'percent' => '230%',
                    'text' => 'from previous year',
                    'size' => 'large',
                ]);
                ?>
            </div>
            <div class="demo-margin">
                <?php
                get_template_part('partials/components/component', 'trend-data', [
                    'type' => 'decrease',
                    'layout' => 'double-line',
                    'percent' => '230%',
                    'text' => 'from previous year',
                    'size' => 'large',
                ]);
                ?>
            </div>

        </div>

    </div>

</div>

<div class="theme theme--neutral theme--mode-light max-width">

    <div class="site-padding">

        <div class="wrap-incidents-by-type demo-margin">
            <?php include 'partials/blocks/block-incidents-by-type.php'; ?>

        </div>

    </div>

    <?php include 'partials/blocks/block-additional-stats.php'; ?>
</div>


<div class="theme theme--neutral theme--mode-light max-width">

    <?php include 'partials/blocks/block-overview.php'; ?>
</div>

<div class="theme theme--neutral theme--mode-light max-width">

    <?php include 'partials/blocks/block-other-stats.php'; ?>
</div>

<?php get_footer(); ?>