<div class="w-full mb-4 flex items-center justify-between mt-10 px-4 sm:px-0">
    <div class="mr-4">
        <h2 class="text-2xl leading-10 font-semibold p-0 m-0 text-sky-400">
            <?php $title = get_theme_mod('__show_scheduled_label');if ($title) {echo $title;} else {_e('Scheduled Episodes', 'kiranime');}?>
        </h2>
    </div>
</div>
<div id="scheduled-anime" class="bg-overlay rounded-sm shadow drop-shadow-sm"></div>