<?php
$year_class = $hit ? '' : 'page-years-comparison__graphs-desktop-year--empty';
?>
<div class="page-years-comparison__graphs-desktop-year page-years-comparison__graphs-desktop-y<?= $i ?> <?= $year_class ?>" data-animate="fade-up">

    <?php if($hit): ?>

    <div class="graphs-desktop-year__top">
        <div class="top__text font-body-sm" data-default='Total Incidents'>Total Incidents</div>
        <hr>
        <div class="top__num font-body-xl" data-default='<?= $row['total_incidents']; ?>'><?= $row['total_incidents']; ?></div>
    </div>
    <div class="graphs-desktop-year__middle">
        <div class="graphs-desktop-year__bars">
            <?php
            $year = (int)(explode('-',$row['year'])[0]);
            if($is_subtype && $year < $subtypes_start_year):
                echo "<div class='graphs-desktop-year__no-information font-body-xs theme__text--secondary'>{$subtypes_disclaimer_text}</div>";
            elseif($is_subtype):
                $j = 0;
                foreach($subtype_data as $subtype):
                    //echo "{$subtype['title']}:{$row[str_replace('all', 'total_incidents', $subtype['name'])]}<br>";
                    if($subtype['name'] != 'all'):
                        $column = $row[$subtype['name']] ?? '';
                        //$percent = !is_nan((int)$column) ? 100 / (int)$row['total_incidents'] * (int)$column : 0;
                        $percent = !is_nan((int)$column) ? 100 / $max_value * (int)$column : 0;
                        $percent = $percent * $y_axis_zoom;
                        echo "<div data-index='{$j}' class='graphs-desktop-year__bar graphs-desktop-year__bar--subtype' data-name='{$subtype['name']}' data-title='{$subtype['title']}' data-total='{$column}' style='height:{$percent}%'></div>";
                        $j++;
                    endif;
                endforeach;
            else:
                $percent = 100 / $max_value * (int)$row['total_incidents'];
                echo "<div class='graphs-desktop-year__bar graphs-desktop-year__bar--total' data-name='total' data-title='Total' data-total='{$row['total_incidents']}' style='height:{$percent}%'></div>";
            endif;
            ?>
        </div>
    </div>
    <div class="graphs-desktop-year__bottom">
        <?php if($is_subtype && $year < $subtypes_start_year): ?>
        <div class="bottom__year font-body-xl"><?= $row['year'].'*'; ?></div>
        <?php else: ?>
        <div class="bottom__year font-body-xl"><?= $row['year']; ?></div>
        <?php endif; ?>
        <div class="bottom__buttons">
            <div class="easy-custom-select" data-current-year="<?= $row['year'] ?>">
                <div class="easy-custom-select__btn">
                    <?php 
                    echo get_button(array(
                        'html_text' => 'Add another year',
                        'tag' => 'div',
                        'class' => 'btn--secondary btn--small btn--icon-only',
                        'icon' => 'chevron-down',
                    ));
                    ?>
                </div>
                <?php
                echo $years_selects[($i-1)];
                ?>
            </div>
            <?php 
            if($sorted_years_total > 1):
                $year_to_remove = remove_year($sorted_years,($i-1)) ?? null;
                echo get_button(array(
                    'aria-label' => 'Remove year',
                    'href' => str_replace('%2C',',',htmlspecialchars(update_url_param('y', $year_to_remove))),
                    'tag' => 'button',
                    'class' => 'bottom__remove-btn btn--secondary btn--small btn--icon-only',
                    'icon' => 'close',
                ));
            endif;
            ?>
        </div>
    </div>

    <?php else: ?>

    <div class="easy-custom-select">
        <div class="easy-custom-select__btn">
            <?php 
            echo get_button(array(
                'html_text' => 'Add another year',
                'tag' => 'div',
                'class' => 'btn--secondary btn--small btn--icon-after',
                'icon' => 'plus',
            ));
            ?>
        </div>
        <?php
        echo $years_selects[($i-1)]; 
        ?>
    </div>

    <?php endif; ?>
    
</div>