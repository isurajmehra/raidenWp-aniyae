<?php

class Kiranime_Popular_List extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(

            'Kiranime_Popular_List',

            'Kiranime Popular List', 'Kiranime_Popular_List_domain',

            array('description' => 'Show popular list.', 'Kiranime_Popular_List_domain')
        );
    }

    // Creating widget front-end

    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title)) {?>
<div class="mr-4 md:px-5 lg:px-0">
    <h2 class="text-2xl leading-10 font-semibold lg:p-0 m-0 text-sky-400 mb-4"><?php echo $title; ?></h2>
</div>
<?php }

        $day = Kiranime_Anime::by_view('day');
        $week = Kiranime_Anime::by_view('week');
        $month = Kiranime_Anime::by_view('month');

        $posts_data = [$day, $week, $month];
        ?>
<div class="w-full">
    <div class="grid grid-cols-3 bg-gray-800">
        <div data-tab-id="1"
            class="w-full p-2 py-3 text-sm font-medium cursor-pointer rounded-tl-md bg-secondary text-center"
            onClick="JavaScript:selectPopularTab(0);">
            <?php _e('Today', 'kiranime');?>
        </div>
        <div data-tab-id="2" class="w-full p-2 py-3 text-sm font-medium cursor-pointer text-center"
            onClick="JavaScript:selectPopularTab(1);">
            <?php _e('Week', 'kiranime');?>
        </div>
        <div data-tab-id="3" class="w-full p-2 py-3 text-sm font-medium cursor-pointer text-center rounded-tr-md"
            onClick="JavaScript:selectPopularTab(2);">
            <?php _e('Month', 'kiranime');?>
        </div>
    </div>

    <?php foreach ($posts_data as $index => $posts): ?>
    <div data-tab-content="<?=$index + 1?>" class="p-4 bg-overlay w-full <?=$index === 0 ? '' : 'hidden'?>">
        <ul class="grid grid-cols-1 gap-5">
            <?php foreach ($posts as $key => $post) {?>
            <li class=" flex items-center gap-5">
                <div data-popular-add-to-list="<?php echo $post['id']; ?>"
                    class=" w-10 transform -translate-y-1 text-center flex-shrink-0 flex-grow-0 group">
                    <span
                        class="text-xl font-semibold pb-2 border-b-2 border-accent-3 group-hover:hidden"><?php $index = $key + 1;if ($index < 10) {echo '0' . $index;} else {echo $index;}?></span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 mx-auto hidden group-hover:block cursor-pointer" viewBox="0 0 448 512">
                        <path fill="currentColor"
                            d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" />
                    </svg>
                </div>
                <div data-popular-add-to-list-for="<?php echo $post['id'] ?>" class="w-max h-auto">
                    <?php $lists = Kiranime_Watchlist::get_types();?>
                    <?php foreach ($lists as $list): ?>
                    <span data-add-to-watch-list data-watch-list-key="<?php echo $list['key'] ?>"
                        data-watch-list-id="<?php echo $post['id'] ?>"
                        class="block bg-overlay cursor-pointer text-left px-4 py-2 text-sm font-light hover:font-medium <?php echo $list['key'] == 'remove' ? 'text-color-error-accent-3' : ''; ?>"><?php echo $list['name']; ?></span>
                    <?php endforeach;?>
                </div>
                <div class="flex-auto flex gap-2 overflow-hidden">
                    <img class="w-12 h-16 object-cover rounded shadow" alt="<?php echo $post['title']; ?>"
                        src="<?php echo $post['featured']; ?>">
                    <div>
                        <h3 class="line-clamp-2 text-sm leading-6">
                            <a href="<?=$post['url']?>"
                                title="<?php echo $post['title'] ?>"><?php echo $post['title'] ?></a>
                        </h3>
                        <div class="text-xs">
                            <span class="flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-3 h-3 " viewBox="0 0 576 512">
                                    <path fill="currentColor"
                                        d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z" />
                                </svg></i><?php echo $post['views'] ?> <?php _e('views', 'kiranime')?></span>
                        </div>
                    </div>
                </div>
                <div class="film-fav list-wl-item" data-id="100"><i class="fa fa-plus"></i></div>
            </li>
            <?php }?>

        </ul>
    </div>
    <?php endforeach;?>
</div>
<script>
function selectPopularTab(index) {
    const tabs = document.querySelectorAll('[data-tab-id]')
    const contents = document.querySelectorAll('[data-tab-content]')

    tabs.forEach(e => e.classList.remove('bg-secondary'))
    contents.forEach(e => e.classList.add('hidden'));

    tabs[index].classList.add('bg-secondary');
    contents[index].classList.remove('hidden');
}
</script>
<?php echo $args['after_widget'];
    }

    // Widget Backend
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title');
        }
        // Widget admin form
         ?>
<p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:');?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
        name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>
<?php
}

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

    // Class Kiranime_Popular_List ends here
}