<?php
$util = new Kiranime_Utility(get_the_ID(), get_the_ID());
$downloads = $util->get_metadata('download', get_post_type(get_the_ID()));
?>

<h3 class="font-semibold text-accent-3 text-2xl leading-loose"><?php _e('Descargas', 'kiranime');?></h3>
<?php if (!empty($downloads) && 0 !== count($downloads)): ?>
<div class="space-y-1 lg:mt-5">
    <div class="w-full grid text-sm md:gap-5">
        <?php foreach ($downloads as $download): ?>
        <div class="flex flex-col lg:grid grid-cols-5 col-span-full w-full lg:gap-5 mb-5 lg:mb-0">
            <?php if (isset($download->links)): ?>
            <span
                class="col-span-full lg:col-span-1 mb-5 lg:mb-0 rounded-sm bg-accent-3 text-center px-5 py-1.5 font-semibold"><?=$download->resolution;?></span>
            <div
                class="grid grid-cols-3 md:grid-cols-4 lg:flex lg:flex-wrap justify-around lg:justify-start px-2 lg:px-0 items-center gap-2 col-span-4">
                <?php foreach ($download->links as $link): if ($link->link): ?>
	                <a class="rounded-sm download-list bg-secondary text-white col-span-1 bg-opacity-70 text-center px-5 py-1"
	                    target="_blank" href="<?=$link->link;?>">
	                    <?=$link->provider ? $link->provider : 'Here'?>
	                </a>
	                <?php endif;endforeach;?>
            </div>
            <?php else: ?>
            <span
                class="col-span-full lg:col-span-1 mb-5 lg:mb-0 rounded-sm bg-accent-3 text-center px-5 py-1.5 font-semibold"><?=$download['resolution'];?></span>
            <div
                class="grid grid-cols-3 md:grid-cols-4 lg:flex lg:flex-wrap justify-around lg:justify-start px-2 lg:px-0 items-center gap-2 col-span-4">
                <?php foreach ($download['data'] as $data): if ($data['url']): ?>
	                <a class="rounded-sm download-list bg-secondary text-white col-span-1 bg-opacity-70 text-center px-5 py-1.5"
	                    target="_blank" href="<?=$data['url'];?>">
	                    <?=$data['provider'] ? $data['provider'] : 'Here'?>
	                </a>
	                <?php endif;endforeach;?>
            </div>
            <?php endif;?>
        </div>
        <?php endforeach;?>
    </div>
</div>
<?php else: ?>
<span class="text-sm py-4 block"><?php _e('No hay descargas disponibles.', 'kiranime')?></span>
<?php endif;?>