<?php

$main_news = get_field('main_featured_news_item', 'news');
$left_columns_news = get_field('featured_news_left_column', 'news');
$right_columns_news = get_field('featured_news_right_column', 'news');
$bottom_row = get_field('featured_news_bottom_row', 'news');

?>

<article class="news__featured" data-animate="fade-in-up" data-animate-delay="100">

    <div class="news__featured-holder">

        <div class="news__featured-col">
            <?php
            foreach($left_columns_news as $index => $post_id):
                include 'news-featured-item.php';
            endforeach;
            ?>
        </div>

        <div class="news__featured-col">
            <?php include 'news-featured-item-main.php'; ?>
        </div>

        <div class="news__featured-col">
            <?php
            foreach($right_columns_news as $index => $post_id):
                include 'news-featured-item.php';
            endforeach;
            ?>
        </div>

    </div>

    <?php if(!empty($bottom_row)): ?>

    <div class="news__featured-holder-bottom" data-animate="fade-in-up" data-animate-delay="200">
    
    <?php
    foreach($bottom_row as $index => $post_id):
        include 'news-featured-item-bottom-row.php';
    endforeach;
    ?>

    <?php endif; ?>

</article>



