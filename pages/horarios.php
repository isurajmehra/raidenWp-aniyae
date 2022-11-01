<?php
/**
 * Template Name: Streamed anime archive
 *
 * @package Kiranime
 */ 

get_header('single'); ?>

        <!-- Imports Went Repo -->
        <link href="https://went.vercel.app/src/css/kXZDcx0D.css" rel="stylesheet">
        <script src="https://went.vercel.app/src/js/jCxWEDx.js"></script>
        <script async src="https://went.vercel.app/src/js/txVzFg2.js"></script>
        <script async src="https://went.vercel.app/src/js/jquery.min.js"></script>
        <script async src="https://went.vercel.app/src/js/jquery.nice-select.min.js"></script>
        <!-- End -->

        <!-- Imports Went local -->
<div class="container-md">
        <div class="row">
                <div class="col">
                    <?php Kiranime_Utility::template('calendary'); ?>
                </div>
                <div class="col">
                    <?php Kiranime_Utility::template('calendary2'); ?>
                </div>
        </div>
</div>
        <div class="py-5 my-5">
            <?php Kiranime_Utility::template('comentarios');?>
        </div>
        <!-- End -->
<?php get_footer()?>