<?php
$year_class = $hit ? '' : 'page-years-comparison__graphs-mobile-year--empty';
$year = (int)(explode('-',$row['year'])[0]);
?>
<div class="page-years-comparison__graphs-mobile-year page-years-comparison__graphs-mobile-y<?= $i ?> <?= $year_class ?>" data-animate="fade-up">

    <?php if($hit): ?>

    <div class="graphs-mobile-year__top">
        <?php if($is_subtype && $year < $subtypes_start_year): ?>
        <div class="top__year font-body-xl"><?= $row['year'].'*'; ?></div>
        <?php else: ?>
        <div class="top__year font-body-xl"><?= $row['year']; ?></div>
        <?php endif; ?>
        <div class="top__buttons">
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
                    'class' => 'top__remove-btn btn--secondary btn--small btn--icon-only',
                    'icon' => 'close',
                ));
            endif;
            ?>
        </div>
    </div>
    <div class="graphs-mobile-year__middle font-body-md">
        Total Incidents: <span><?= $row['total_incidents']; ?></span>
    </div>
    <?php
    if($is_subtype && $year < $subtypes_start_year):
        echo "<div class='graphs-mobile-year__no-information font-body-xs theme__text--secondary'>{$subtypes_disclaimer_text}</div>";
    else:
    ?>
    <div class="graphs-mobile-year__bottom">
        <div class="graphs-mobile-year__bars <?php if(!$is_subtype){echo 'graphs-mobile-year__bars--total';} ?>">
            <?php
            if($is_subtype):
                $j = 0;
                foreach($subtype_data as $subtype):
                    //echo "{$subtype['title']}:{$row[str_replace('all', 'total_incidents', $subtype['name'])]}<br>";
                    if($subtype['name'] != 'all'):
                        $column = $row[$subtype['name']] ?? '';
                        //$percent = !is_nan((int)$column) ? 100 / (int)$row['total_incidents'] * (int)$column : 0;
                        $percent = !is_nan((int)$column) ? 100 / $max_value * (int)$column : 0;
                        $percent = $percent * $y_axis_zoom;
                        $num_class = $percent < 14 ? 'graphs-mobile-year__bar-num--out' : '';
                        echo "<div data-index='{$j}' class='graphs-mobile-year__bar graphs-mobile-year__bar--subtype' data-name='{$subtype['name']}' data-title='{$subtype['title']}' data-total='{$column}' style='width:{$percent}%'><div class='graphs-mobile-year__bar-num font-body-md {$num_class}'>{$column}</div></div>";
                        $j++;
                    endif;
                endforeach;
            else:
                $percent = 100 / $max_value * (int)$row['total_incidents'];
                echo "<div class='graphs-mobile-year__bar graphs-mobile-year__bar--total' data-name='total' data-title='Total' data-total='{$row['total_incidents']}' style='width:{$percent}%'></div>";
            endif;
            ?>
        </div>
    </div>
    <?php endif; ?>

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
        echo str_replace("id='select-","id='select-mobile-",str_replace("name='select-","name='select-mobile-",$years_selects[($i-1)])); 
        ?>
    </div>

    <?php endif; ?>

</div>