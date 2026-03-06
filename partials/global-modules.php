<?php
    if(!isset($global_modules)):
        $global_modules = get_field('global_modules');
    endif;
    if($global_modules):       
        $block_index = 1; 
        foreach($global_modules as $block):
            $block_id = 'block-' . $block_index;
            $block_name = str_replace('_','-',$block['acf_fc_layout']);
            $block_path = "blocks/block-{$block_name}.php";
            require $block_path;
            $block_index++;
        endforeach;
        
    endif;
?>