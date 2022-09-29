<?php

/**
 * Template Name: User Profile Page
 *
 * @package Kiranime
 */

get_header('single');

$user_info = get_userdata(get_current_user_id());
$display_name = esc_attr($user_info->user_login);
$avatars = Kiranime_User::list_avatar();
$current_avatar = Kiranime_User::get_avatar(get_current_user_id());
$chibi = $avatars['chibi'];
$dragonball = $avatars['dragonball'];
$onepiece = $avatars['onepiece'];

?>
<?php Kiranime_Utility::template('user');?>
<section class="lg:w-6/12 w-11/12 mx-auto">
    <h2 class="text-2xl leading-10 font-medium mb-5 flex items-center gap-4">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-7 h-7">
            <path fill="currentColor"
                d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" />
        </svg>
        <?php the_title()?>
    </h2>
    <div class="w-full h-full rounded shadow bg-overlay flex gap-2">
        <div class="w-8/12 p-4">
            <form class="space-y-5">
                <div class="">
                    <label for="username" class="text-sm font-medium block mb-2 uppercase">
                        <?php _e('Nombre de usuario', 'kiranime')?>
                    </label>
                    <input type="text" name="username" id="username"
                        class="px-4 py-2 bg-overlay bg-opacity-5 text-sm rounded outline-none border-none ring-1 focus:ring block focus:ring-accent-3 w-full"
                        value="<?php echo $display_name; ?>">
                </div>
                <div class="">
                    <label for="email" class="text-sm font-medium block mb-2 uppercase">
                        Email
                    </label>
                    <input type="email" name="email" id="email"
                        class="px-4 py-2 bg-overlay bg-opacity-5 text-sm rounded outline-none border-none ring-1 focus:ring block focus:ring-accent-3 w-full"
                        value="<?php echo $user_info->user_email; ?>">
                </div>
                <div class="">
                    <label for="joined" class="text-sm font-medium block mb-2 uppercase">
                        <?php _e('Registrado el', 'kiranime')?>
                    </label>
                    <input type="joined" name="joined" id="joined" disabled
                        class="px-4 py-2 bg-overlay bg-opacity-5 text-sm rounded outline-none border-none ring-1 focus:ring block focus:ring-accent-3 w-full"
                        value="<?php echo $user_info->user_registered; ?>">
                </div>
                <span data-show-change-password class="cursor-pointer opacity-50 text-xs my-5 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-3 h-3">
                        <path fill="currentColor"
                            d="M512 176.001C512 273.203 433.202 352 336 352c-11.22 0-22.19-1.062-32.827-3.069l-24.012 27.014A23.999 23.999 0 0 1 261.223 384H224v40c0 13.255-10.745 24-24 24h-40v40c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24v-78.059c0-6.365 2.529-12.47 7.029-16.971l161.802-161.802C163.108 213.814 160 195.271 160 176 160 78.798 238.797.001 335.999 0 433.488-.001 512 78.511 512 176.001zM336 128c0 26.51 21.49 48 48 48s48-21.49 48-48-21.49-48-48-48-48 21.49-48 48z" />
                    </svg>
                    <?php _e('Cambiar contraseña', 'kiranime')?></span>
                <div data-change-password-fields class="w-full space-y-2 hidden transition-all duration-200">
                    <div class="">
                        <label for="current_password" class="text-sm font-medium block mb-2 uppercase">
                            <?php _e('Contraseña actual', 'kiranime')?>
                        </label>
                        <input data-change-password="current" type="password" name="current_password"
                            id="current_password"
                            class="px-4 py-2 bg-overlay bg-opacity-5 text-sm rounded outline-none border-none ring-1 focus:ring block focus:ring-accent-3 w-full"
                            value="<?php echo $user_info->user_pass; ?>">
                    </div>
                    <div class="">
                        <label for="new_password" class="text-sm font-medium block mb-2 uppercase">
                            <?php _e('Nueva contraseña', 'kiranime')?>
                        </label>
                        <input data-change-password="new" type="password" name="new_password" id="new_password"
                            class="px-4 py-2 bg-overlay bg-opacity-5 text-sm rounded outline-none border-none ring-1 focus:ring block focus:ring-accent-3 w-full"
                            value="" placeholder="<?php _e('Tu nueva contraseña', 'kiranime')?>">
                    </div>
                    <div class="">
                        <label for="confirm_new_password" class="text-sm font-medium block mb-2 uppercase">
                            <?php _e('Confirmar nueva contraseña', 'kiranime')?>
                        </label>
                        <input data-change-password="confirm" type="password" name="confirm_new_password"
                            id="confirm_new_password"
                            class="px-4 py-2 bg-overlay bg-opacity-5 text-sm rounded outline-none border-none ring-1 focus:ring block focus:ring-accent-3 w-full"
                            value="" placeholder="<?php _e('Confirma la nueva contraseña', 'kiranime')?>">
                    </div>
                </div>
                <button
                    class="bg-sky-400 px-4 py-2 w-full rounded-md text-gray-900"><?php _e('Guardar', 'kiranime')?></button>
            </form>
        </div>
        <div class="w-4/12 h-full min-h-full bg-gradient-to-b from-secondary p-4">
            <div data-avatar-holder style="background-image: url('<?=$current_avatar?>');"
                class="w-24 h-24 rounded-full mx-auto relative bg-no-repeat bg-cover bg-center">
                <div data-change-avatar
                    class="absolute right-0 bottom-0 rounded-full w-7 h-7 flex items-center justify-center bg-white cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="text-gray-900 w-4 h-4">
                        <path fill="currentColor"
                            d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="fixed hidden inset-0 items-center justify-center bg-opacity-50 z-40" data-avatar-select-wrapper>
    <div data-close-avatar-select class="absolute inset-0 bg-overlay bg-opacity-60 z-40">

    </div>
    <div class="w-11/12 md:w-8/12 lg:w-4/12 max-h-96 shadow-lg drop-shadow-md bg-overlay rounded-lg z-50">
        <h3 class="text-center pt-5 px-0 text-3xl font-medium mb-4">
            <?php _e('Choose Avatar', 'kiranime')?>
        </h3>
        <div class="w-full h-full">
            <div class="flex items-center justify-between text-sm font-light">
                <span data-selectable-type-id="1" class="selected-avatar-type py-2 px-4">#DragonBall</span>
                <span data-selectable-type-id="2" class="avatar py-2 px-4">#Chibi</span>
                <span data-selectable-type-id="3" class="avatar py-2 px-4">#One
                    Piece</span>
            </div>
            <div data-selected-id="1"
                class="mt-5 grid-cols-3 justify-around active-avatar-display max-h-56 overflow-y-scroll gap-5">
                <?php foreach ($dragonball as $c): ?>
                <img data-avatar-url="<?php echo $c ?>" src="<?php echo $c ?>"
                    class="cursor-pointer w-24 h-24 hover:scale-100 mx-auto col-span-1 rounded-full hover:shadow-lg relative after:absolute after:inset-0 after:bg-overlay after:bg-opacity-25 hover:after:bg-opacity-0 <?php if ($c == $current_avatar) {echo 'selected-avatar';} else {echo 'avatar-image';}?>">
                <?php endforeach;?>
            </div>
            <div data-selected-id="2"
                class="mt-5 grid-cols-3 justify-around avatar-display max-h-56 overflow-y-scroll gap-5">
                <?php foreach ($chibi as $c): ?>
                <img data-avatar-url="<?php echo $c ?>" src="<?php echo $c ?>"
                    class="cursor-pointer w-24 h-24 hover:scale-100 mx-auto col-span-1 rounded-full hover:shadow-lg relative after:absolute after:inset-0 after:bg-overlay after:bg-opacity-25 hover:after:bg-opacity-0 <?php if ($c == $current_avatar) {echo 'selected-avatar';} else {echo 'avatar-image';}?>">
                <?php endforeach;?>
            </div>

            <div data-selected-id="3"
                class="mt-5 grid-cols-3 justify-around avatar-display max-h-56 overflow-y-scroll gap-5">
                <?php foreach ($onepiece as $c): ?>
                <img data-avatar-url="<?php echo $c ?>" src="<?php echo $c ?>"
                    class="cursor-pointer w-24 h-24 hover:scale-100 mx-auto col-span-1 rounded-full hover:shadow-lg relative after:absolute after:inset-0 after:bg-overlay after:bg-opacity-25 hover:after:bg-opacity-0 <?php if ($c == $current_avatar) {echo 'selected-avatar';} else {echo 'avatar-image';}?>">
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
<?php get_footer()?>