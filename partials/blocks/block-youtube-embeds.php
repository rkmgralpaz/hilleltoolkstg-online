
<div id="block-<?php echo $block_index; ?>" class="js-module block-youtube-embeds theme theme--blue theme--mode-neutral">
    <div class="block-youtube-embeds__items-wrapper">

        <?php

        $block_html = "";
        $num = 0;
        foreach($block['items'] as $item):
            $delay = $num * 100 + 200;

            // Determine mode and video source
            $mode = $item['mode'] ?? 'url';
            $video_url = $item['video_url'] ?? '';
            $video_file = $item['video_file'] ?? null;
            $adds = $item['adds'] ?? [];
            $poster_field = $item['image'] ?? null;
            $poster_default = $item['poster_default'] ?? '';
            $video_thumb = $item['video_thumb'] ?? null;
            $autoplay_loop = !empty($item['autoplay_loop']) ? '1' : '0';

            // Video source
            $video_src = ($mode === 'file' && !empty($video_file)) ? $video_file['url'] : $video_url;

            // Poster image
            $poster_img = '';
            if (in_array('poster', $adds) && !empty($poster_field)) {
                $poster_img = $poster_field['url'];
            } elseif (!empty($poster_default)) {
                $poster_img = $poster_default;
            }

            // Video thumb
            $video_thumb_url = '';
            if (in_array('video_thumb', $adds) && !empty($video_thumb)) {
                $video_thumb_url = $video_thumb['url'];
            }

            // Detect platform and video ID
            $platform = $item['plattform'] ?? '';
            $video_id = '';
            if ($platform === 'youtube' && !empty($video_url)) {
                // Extract YouTube ID
                if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $video_url, $yt_match)) {
                    $video_id = $yt_match[1];
                }
            }
            if (empty($platform)) {
                $platform = ($mode === 'file') ? 'html5' : 'youtube';
            }

            // Parse subtitles
            $subs_json = '[]';
            if (in_array('subs', $adds) && !empty($item['subs'])) {
                $subs_json = subs_to_json($item['subs']);
            }

            // Profile image
            $profile_image_url = '';
            if (!empty($item['profile_image']) && isset($item['profile_image']['url'])) {
                $profile_image_url = $item['profile_image']['url'];
            }

            // Name with dynamic heading
            $name = get_dynamic_heading(
                $item['name'] ?? '',
                $item['heading_tag'] ?? 'none',
                'item-data__name theme__text--primary',
            );

            $block_html .= "
            <div class='block-youtube-embeds__item'>
                <div class='block-youtube-embeds__item-video-wrapper'
                    data-mode='{$mode}'
                    data-video-src='" . esc_url($video_src) . "'
                    data-poster='" . esc_url($poster_img) . "'
                    data-video-thumb='" . esc_url($video_thumb_url) . "'
                    data-subs=\"" . esc_attr($subs_json) . "\"
                    data-platform='{$platform}'
                    data-video-id='{$video_id}'
                    data-autoplay-loop='{$autoplay_loop}'
                    data-animate='fade-in-up' data-animate-delay='{$delay}'>
                </div>
                <div class='block-youtube-embeds__item-data'>
                    <div class='item-data__header' data-animate='fade-in-up' data-animate-delay='100'>
                        <div class='item-data__image' style='background-image:url({$profile_image_url})'></div>
                        <div class='item-data__header-txt font-body-md'>
                            {$name}
                            <div class='item-data__user theme__text--secondary'>
                                {$item['user']}
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

