<?php /** Template version: 1.0.0 */ ?>

<div class="wrap cuar-content-list">
    <h2><?php
        echo $post_type_object->labels->name;
        foreach ($title_links as $label => $url)
        {
            printf(' <a href="%2$s" class="add-new-h2">%1$s</a>', $label, $url);
        }
        ?></h2>
    <?php
    do_action('cuar/core/admin/' . $private_type_group . '-list-page/after-title');
    do_action('cuar/core/admin/' . $private_type_group . '-list-page/after-title?post_type=' . $post_type);
    ?>
    <form method="GET" action="<?php echo admin_url('admin.php'); ?>">
        <input type="hidden" name="referrer" value="<?php echo admin_url('admin.php?post_type=' . $post_type); ?>"/>
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>

        <div class="cuar-list-table-filter">
            <?php do_action('cuar/core/admin/' . $private_type_group . '-list-page/before-filters'); ?>

            <?php include($default_filter_template); ?>

            <?php do_action('cuar/core/admin/' . $private_type_group . '-list-page/after-filters'); ?>
        </div>

        <?php $list_table->views(); ?>

        <?php do_action('cuar/core/admin/' . $private_type_group . '-list-page/before-table'); ?>
        <?php do_action('cuar/core/admin/' . $private_type_group . '-list-page/before-table?post_type=' . $post_type); ?>

        <?php $list_table->display(); ?>

        <?php do_action('cuar/core/admin/' . $private_type_group . '-list-page/after-table?post_type=' . $post_type); ?>
        <?php do_action('cuar/core/admin/' . $private_type_group . '-list-page/after-table'); ?>
    </form>
</div>