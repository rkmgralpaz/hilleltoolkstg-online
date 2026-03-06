
<div id="block-<?php echo $block_index; ?>" class="js-module block-reels theme theme--blue theme--mode-neutral">
    <div class="block-reels__items-wrapper">

        <?php

        $block_html = "";
        $num = 0;
        foreach($block['items'] as $item):
            $delay = $num * 100 + 200;
            $item['user_link'] = str_replace('@','',$item['user']);

            //clean IG URL
            if(strpos($item['url'], 'instagram') !== -1):
                $item['url'] = clean_instagram_url($item['url']);
            endif;

            $item['url'] = str_replace('/embed/','/',$item['url']).'embed/';
            //$item['text'] = truncate_words($item['text'], 15);
            if(!isset($item['image']['url'])):
                $item['image'] = array(
                    'url' => ''
                );
            endif;

            $name =  get_dynamic_heading(
                $item['name'],
                $item['heading_tag'],
                'item-data__name theme__text--primary',
            
            );



            $block_html .= "
            <div class='block-reels__item type-{$item['type']}'>
                <div class='block-reels__item-embed-wrapper instagram' data-src='{$item['url']}' data-animate='fade-in-up' data-animate-delay='{$delay}'></div>
                <div class='block-reels__item-data'>
                    <div class='item-data__header' data-animate='fade-in-up' data-animate-delay='100'>
                        <div class='item-data__image' style='background-image:url({$item['image']['url']})'></div>
                        <div class='item-data__header-txt font-body-md'>
                            {$name}
                            <div class='item-data__user theme__text--secondary'>
                                <a href='https://www.instagram.com/{$item['user_link']}' target='_blank'>{$item['user']}</a>
                            </div>
                        </div>
                    </div>
                    <div class='item-data__text font-body-sm theme__text--secondary' data-animate='fade-in-up' data-animate-delay='100'>
                        {$item['text']}
                    </div>
                </div>
            </div>
            ";
            $num ++;
        endforeach;
        echo $block_html;

        ?>

    </div>
</div>

           