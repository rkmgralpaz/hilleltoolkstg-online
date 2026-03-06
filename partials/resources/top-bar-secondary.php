<div class="top-bar-secondary">

    <div class="top-bar-secondary__sort">
        <div class="top-bar-secondary__sort--title font-label-md theme__text--primary">SORT</div>

        <?php
        $current_order = $_GET['orderby'] ?? 'alphabetically';

        function is_selected($val)
        {
            global $current_order;
            return $current_order === $val ? 'selected' : '';
        }
        function get_label($val)
        {
            switch ($val) {
                case 'alphabetically':
                    return 'ALPHABETICALLY';
                case 'topic':
                    return 'TOPIC';
                default:
                    return 'FORMAT';
            }
        }
        ?>

        <?php include 'resources-sort.php'; ?>

        <div class="custom-select-button-responsive">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="9" viewBox="0 0 16 9" fill="none">
                <path d="M0 1H16" stroke="#332933" stroke-width="1.5" />
                <path d="M2.66797 4.5H13.3346" stroke="#332933" stroke-width="1.5" />
                <path d="M5.33203 8H10.6654" stroke="#332933" stroke-width="1.5" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                <path d="M9.2793 3.65527L4.99902 7.93555L0.71875 3.65527L1.7793 2.59473L4.99902 5.81445L8.21875 2.59473L9.2793 3.65527Z" fill="#33312E" />
            </svg>
        </div>

        <select name="orderby" id="orderby">
            <option data-value="alphabetically" data-url="<?= build_url(['orderby' => 'alphabetically'], [], 'sort'); ?>" <?php echo is_selected('alphabetically'); ?>>ALPHABETICALLY</option>
            <option data-value="format" data-url="<?= build_url(['orderby' => 'format'], [], 'sort'); ?>" <?php echo is_selected('format'); ?>>FORMAT</option>
            <option data-value="topic" data-url="<?= build_url(['orderby' => 'topic'], [], 'sort'); ?>" <?php echo is_selected('topic'); ?>>TOPIC</option>
        </select>

    </div>

    <div class="top-bar-secondary__format">
        <div class="top-bar-secondary__format-title font-label-md theme__text--primary">FILTER BY FORMAT</div>

        <div class="top-bar-secondary__formats">

            <?php
            $terms = get_terms([
                'taxonomy' => 'resources_format',
                'post_type' => 'resources',
                'hide_empty' => false,
            ]);

            if (!is_wp_error($terms)) {
                foreach ($terms as $term) {
                    get_template_part('partials/components/component', 'format', [
                        'tooltip' => $term->name,
                        'slug' => $term->slug
                    ]);
                }
            }
            ?>
        </div>

    </div>

</div>