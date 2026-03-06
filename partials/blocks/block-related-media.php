<div id="block-<?php echo $block_index; ?>" class="theme <?php echo explode(';', $block['module_configuration']['color_palette'])[0]; ?> <?php echo isset($block['module_configuration']['color_mode']) ? $block['module_configuration']['color_mode'] : 'theme--light'; ?>">

    <div class="block-related-media max-width">

        <div>
            <div>
                <?php if (!empty($block['tagline'])): ?>
                    <?php
                    echo get_dynamic_heading(
                        $block['tagline'],
                        $block['heading_tag_tagline'],
                        'font-label-lg theme__text--secondary font-uppercase',
                        ['data-animate' => 'fade-in-up',]
                    );
                    ?>
                <?php endif; ?>

                <?php if (!empty($block['title'])): ?>
                    <?php
                    echo get_dynamic_heading(
                        $block['title'],
                        $block['heading_tag'],
                        'theme__text--primary ' . $block['module_configuration']['title_type'],
                        ['data-animate' => 'fade-in-up',]
                    );
                    ?>
                <?php endif; ?>
            </div>

            <?php if (!empty($block['text'])): ?>
                <div class="block-related-media__main-text font-body-md theme__text--secondary" data-animate="fade-in-up" data-animate-delay="100">
                    <?php echo $block['text']; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php
        $resources = isset($block['resources']) ? $block['resources'] : []; // Obtener los elementos del custom field relationship "resources"
        if (!empty($resources) && is_array($resources)) :
        ?>
            <div class="block-related-media__resources">
                <?php foreach ($resources as $post_id) : ?>
                    <?php
                    if (get_post($post_id)) { // Verificar que el post existe
                        // Configurar el contexto del post actual
                        $post = get_post($post_id);
                        setup_postdata($post);
                        // Incluir la tarjeta de recurso
                        get_template_part('partials/resources/components/resource-card');
                    }
                    ?>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); // Restaurar el contexto global del post 
                ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($block['show_media_library_button'])) : ?>
            <div class="block-related-media__cta" data-animate="fade-in-up">
                <?php
                echo get_button(array(
                    'html_text' => 'Explore our library test',
                    'href'      => home_url('/medialibrary/'),
                    'target'    => '_self',
                    'class'     => 'btn--primary btn--large btn--icon-after',
                    'icon'      => 'chevron-right',
                ));
                ?>
            </div>
        <?php endif; ?>

    </div>

</div>