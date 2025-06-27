<aside>

<?php if(is_active_sidebar('lateral_superior_disctrap')): ?>
    <div class="<?php apply_filters('filtro-clase-widget-ls', 'hidden-sm hidden-xs') ?>">
        <?php dynamic_sidebar('lateral_superior_disctrap'); ?>
        <br />
    </div>
<?php endif;?>

<?php get_secondary_menu(); ?>
    
<?php if(is_active_sidebar('lateral_inferior_disctrap')): ?>
<div class="<?php apply_filters('filtro-clase-widget-li', 'hidden-sm hidden-xs') ?>">
    <?php dynamic_sidebar('lateral_inferior_disctrap'); ?>
</div>
<?php endif;?>
       
</aside>
