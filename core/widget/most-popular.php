<?php

class Kiranime_Most_Popular extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(

            'Kiranime_Most_Popular',

            'Kiranime Most Popular List',

            array('description' => 'Show Most popular list.')
        );
    }

    // Creating widget front-end

    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title)) {?>
<div class="mr-4 md:px-5 px-0 lg:px-0">
    <h2 class="text-2xl leading-10 font-semibold lg:p-0 m-0 text-sky-400 mb-4"><?php echo $title; ?></h2>
</div>
<?php }

        // This is where you run the code and display the output
        $animes = Kiranime_Anime::by_view('total');
        ?>
<div class="w-full">
    <ul class="bg-overlay px-5 py-4">
        <?php foreach ($animes as $anime): ?>
        <li class="flex gap-5 border-b border-white border-opacity-5 py-4 relative">
            <div class="relative w-12 h-16  overflow-hidden flex-shrink-0">
                <img class="absolute inset-0 w-full h-auto object-cover" alt="<?php echo $anime['title'] ?>"
                    src="<?php echo $anime['featured'] ?>">
            </div>
            <div class="flex-auto w-9/12 text-sm">
                <h3 class="mb-1 font-medium leading-6 line-clamp-2 ">
                    <a href="<?php echo $anime['url'] ?>" title="<?php echo $anime['title'] ?>"
                        class="hover:text-sky-500"><?php echo $anime['title'] ?></a>
                </h3>
                <div class="text-spec flex gap-1 items-center">
                    <span class="inline-block"><?php echo $anime['type'][0]->name ?></span>
                    <span class="w-1 h-1 bg-white bg-opacity-10 inline-block"></span>
                    <span class="inline-block"><?php echo $anime['meta']['episodes'] ?> eps</span>
                    <span class="w-1 h-1 bg-white bg-opacity-10 inline-block"></span>
                    <span class="inline-block fdi-duration"><?php echo $anime['meta']['duration'] ?></span>

                </div>
            </div>
            <!-- <div class="film-fav list-wl-item" data-id="60"><i class="fa fa-plus"></i></div> -->
        </li>
        <?php endforeach;?>
    </ul>
</div>

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

    // Class Kiranime_Most_Popular ends here
}