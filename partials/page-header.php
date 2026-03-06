<?php
    $current_id = get_the_ID();
    $ancestors = get_post_ancestors($current_id);
    $ancestors_total = count($ancestors);
    if($ancestors_total):
        $header_id = end($ancestors);
    else:
        $header_id = $current_id;
    endif;
    if($ancestors_total && !get_field('redirect_to_first_child', $header_id)):
        $link_to_ancestor = get_permalink($header_id);
    endif;
    $childrens = get_pages('child_of='.$header_id.'&sort_column=menu_order&post_status=publish');

    //

    if(!isset($header_modules)):
        $header_modules = get_field('header_modules',$header_id);
    endif;
    if($header_modules):       
        $tabs_classes = 'theme ';
        if($header_modules && isset($header_modules[0]['module_color_settings']) && isset($header_modules[0]['module_color_settings']['color_palette']) && isset($header_modules[0]['module_color_settings']['color_mode'])):
            $tabs_classes .= explode(';',$header_modules[0]['module_color_settings']['color_palette'])[0].' '.$header_modules[0]['module_color_settings']['color_mode'];
        elseif($tabs_classes && isset($header_modules[0]['module_configuration']) && isset($header_modules[0]['module_configuration']['color_palette']) && isset($header_modules[0]['module_configuration']['color_mode'])):
            $tabs_classes .= explode(';',$header_modules[0]['module_configuration']['color_palette'])[0].' '.$header_modules[0]['module_configuration']['color_mode'];
        else:
            $tabs_classes .= 'theme--neutral theme--mode-light theme--surface-primary';
        endif;
        if($header_modules && ((isset($header_modules[0]['module_color_settings']) && isset($header_modules[0]['module_color_settings']['background']) && !$header_modules[0]['module_color_settings']['background']) || (isset($header_modules[0]['module_configuration']) && isset($header_modules[0]['module_configuration']['background']) && !$header_modules[0]['module_configuration']['background']))):
            $tabs_classes = str_replace('theme--surface-primary', '', $tabs_classes);
            $tabs_classes .= ' theme--surface-secondary';
        endif;

        $block_index = 0;

        foreach($header_modules as $block):
            $block_id = 'block-' . $block_index;
            $block_remove_transitions = $ancestors_total;
            $block_name = str_replace('_','-',$block['acf_fc_layout']);
            $block_path = "blocks/block-{$block_name}.php";
            require $block_path;
            unset($block_remove_transitions);
            //$block_index++;
        endforeach;
    else:
        $this_modules = get_field('global_modules');
        $tabs_classes = 'theme ';
        if($this_modules && isset($this_modules[0]['module_color_settings']) && isset($this_modules[0]['module_color_settings']['color_palette']) && isset($this_modules[0]['module_color_settings']['color_mode'])):
            $tabs_classes .= explode(';',$this_modules[0]['module_color_settings']['color_palette'])[0].' '.$this_modules[0]['module_color_settings']['color_mode'];
        elseif($this_modules && isset($this_modules[0]['module_configuration']) && isset($this_modules[0]['module_configuration']['color_palette']) && isset($this_modules[0]['module_configuration']['color_mode'])):
            $tabs_classes .= explode(';',$this_modules[0]['module_configuration']['color_palette'])[0].' '.$this_modules[0]['module_configuration']['color_mode'];
        else:
            $tabs_classes .= 'theme--neutral theme--mode-light theme--surface-primary';
        endif;
        if($this_modules && ((isset($this_modules[0]['module_color_settings']) && isset($this_modules[0]['module_color_settings']['background']) && !$this_modules[0]['module_color_settings']['background']) || (isset($this_modules[0]['module_configuration']) && isset($this_modules[0]['module_configuration']['background']) && !$this_modules[0]['module_configuration']['background']))):
            $tabs_classes = str_replace('theme--surface-primary', '', $tabs_classes);
            $tabs_classes .= ' theme--surface-secondary';
        endif;
        $tabs_classes .= ' page-header__tabs--space-top';
    endif;

    if(count($childrens)):
    ?>
    <div class="page-header__tabs <?php echo $tabs_classes; ?>">
        <ul class="page-header__tabs-ul">
            <?php 
            
            $html = "";
            foreach($childrens as $child):
                if(count(get_post_ancestors($child->ID)) < 2):
                    if($child->ID == $current_id):
                        $a_class = 'tabs-item--selected';
                    elseif($ancestors_total > 1 && $child->ID == $ancestors[$ancestors_total - 2]):
                        $a_class = 'tabs-item--selected';
                    else:
                        $a_class = '';
                    endif;
                    $permalink = get_permalink($child);
                    $child_title = $child->post_title;
                    /* $child_modules = get_field('global_modules',$child->ID);
                    if(isset($child_modules) && isset($child_modules[0]['title'])):
                        $child_title = $child_modules[0]['title'];
                    endif; */
                    $html .= "<li class='page-header__tabs-item theme__text--primary font-body-md'><a href='{$permalink}' class='{$a_class}'>{$child_title}</a></li>";
                endif;
            endforeach;
            echo $html;

            ?>
        </ul>
    </div>
    <?php
    endif;
    ?>
