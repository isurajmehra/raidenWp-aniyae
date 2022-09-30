<?php
get_header(); ?>

<?php if (!is_user_logged_in()) {?>
<?php Kiranime_Utility::template('homeLogin'); ?>
<?php } else {?>
<?php Kiranime_Utility::template('homepage'); ?>
<?php }?>

<?php get_footer(); ?>