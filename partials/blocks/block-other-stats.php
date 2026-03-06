<?php

if (!empty($data['other_stats']) && array_sum(array_column($data['other_stats'], 'total')) > 0): ?>
    <div class="js-module block-other-stats">

        <h2 class="block-other-stats__header font-heading-lg theme__text--primary" data-animate="fade-in-up">
            <?php
            $other_stats = get_field('other_stats');
            if (!empty($other_stats['subtitle'])) {
                echo $other_stats['subtitle'];
            }
            ?>
        </h2>

        <ul class="block-other-stats__list block-other-stats__list--items-<?= !empty($data['other_stats']) ? count(array_filter($data['other_stats'], fn($stat) => !empty($stat['total']))) : 0 ?>">
            <?php foreach ($data['other_stats'] as $index => $stat) {
                if (strtolower($stat['name']) === 'bds votes') {
                    $stat['name'] = 'BDS Votes';
                } elseif (strtolower($stat['name']) === 'anti israel legislation') {
                    $stat['name'] = 'Anti-Israel Legislation';
                } elseif (strtolower($stat['name']) === 'commencement disruptions') {
                    $stat['name'] = 'Commencement Disruptions';
                } elseif (strtolower($stat['name']) === 'encampments') {
                    $stat['name'] = 'Encampments';
                }

                if ($stat['total'] > 0): ?>
                    <li class="other-stats__item <?= empty($stat['description']) ? 'no-description' : '' ?>" data-animate="fade-in-up" data-animate-delay="<?= $index * 200 ?>">

                        <?php if (!empty($stat['description'])): ?>
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

                        <div class="other-stats__item-wrap">
                            <h3 class="other-stats__item-value font-heading-3xl theme__text--primary" aria-label="<?= esc_attr($stat['name']) ?> value">
                                <?= $stat['total'] ?>
                            </h3>
                            <div class="other-stats__item-bottom">
                                <div class="other-stat__title font-body-md theme__text--primary">
                                    <?= $stat['name'] ?>
                                </div>
                                <div class="other-stat__desc font-body-sm theme__text--secondary">
                                    <?= $stat['context'] ?>
                                </div>
                            </div>
                        </div>
                    </li>
            <?php endif;
            } ?>
        </ul>

    </div>
<?php endif; ?>