<?php
/** Template version: 3.0.0
 *
 * -= 3.0.0 =-
 * - Bootstrap support
 *
 * -= 1.0.0 =-
 * - First template version
 *
 */ ?>

<ul class="list-group">
    <?php
    foreach ($terms as $term) :
        $link = $this->get_link($term);
        ?>
        <li><?php
            // Print the current term
            printf('<a href="%1$s" title="%3$s" class="list-group-item">%2$s</a>',
                $link,
                $term->name,
                sprintf(esc_attr__('Show all content categorized under %s', 'cuar'), $term->name)
            );
            ?>

            <?php
            // Print all child terms in a sublist
            $children = get_terms($this->get_taxonomy(), array(
                'parent'     => $term->term_id,
                'hide_empty' => $hide_empty
            ));
            if (count($children) > 0)
            {
                $this->print_term_list($children, $hide_empty);
            }
            ?>
        </li>
    <?php
    endforeach;
    ?>
</ul>