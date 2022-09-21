<div
    class="relative z-50 h-auto p-8 py-10 overflow-hidden bg-primary border-b-2 border-secondary rounded-lg shadow-2xl px-7 w-full container lg:max-w-md md:max-w-xs">
    <input type="hidden" name="login_nonce" value="<?php echo wp_create_nonce('ajax-login-nonce') ?>">
    <h3 class="mb-6 text-2xl font-medium text-center"><?php _e('Sign in to your Account', 'kiranime')?></h3>
    <input type="text" name="username"
        class="block w-full px-4 py-3 mb-4 border  border-transparent border-secondary rounded-lg focus:ring focus:ring-sky-500 focus:outline-none text-primary"
        placeholder="Username">
    <input type="password" name="password"
        class="block w-full px-4 py-3 mb-4 border  border-transparent border-secondary rounded-lg focus:ring focus:ring-sky-500 focus:outline-none text-primary"
        placeholder="Password">
    <div class="block">
        <button data-login-button class="w-full px-3 py-4 font-medium text-white bg-accent-3 rounded-lg">
            <?php _e('Log Me In', 'kiranime');?>
        </button>
    </div>
    <p data-login-error-info class="w-full mt-4 text-sm text-center text-rose-500"></p>
    <p class="w-full mt-4 text-sm text-center text-gray-400"><?php _e("Don't have an account?", 'kiranime')?> <button
            data-to-register-button class="text-sky-500 underline"><?php _e('Sign up here', 'kiranime')?></button></p>

</div>