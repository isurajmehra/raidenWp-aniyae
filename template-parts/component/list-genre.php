<?php

/**
 * genre list for header (sidebar)
 */

$genres = get_terms([
    'taxonomy' => 'genre',
    'hide_empty' => true,
]);?>
<li class="menu-item menu-item-type-post_type">
    <div class="nav-link">
        <?php _e('Generos', 'kiranime');?>
    </div>
    <ul class="grid grid-cols-2">
        <?php foreach ($genres as $genre): ?>
        <li class="inline-block col-span-1 text-xs font-semibold font-montserrat genre-list">
            <a class="block py-2 px-4 whitespace-nowrap overflow-ellipsis max-w-full rounded"
                href="<?php echo get_term_link($genre); ?>"><?php echo $genre->name; ?></a>
        </li>
        <?php endforeach?>
    </ul>
</li>