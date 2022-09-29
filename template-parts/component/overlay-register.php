<div
    class="relative z-50 h-auto p-8 py-10 overflow-hidden bg-primary border-b-2 border-secondary rounded-lg shadow-2xl px-7">
    <?php if (get_option('users_can_register')): ?>
    <input type="hidden" name="register_nonce" value="<?php echo wp_create_nonce('ajax-register-nonce') ?>">
    <h3 class="mb-6 text-2xl font-medium text-center"><?php _e('Otra cuenta mas | Aniyae', 'kiranime');?></h3>
    <input type="text" name="register_username"
        class="block w-full px-4 py-3 mb-4 border  border-transparent border-secondary rounded-lg focus:ring focus:ring-sky-500 focus:outline-none text-primary"
        placeholder="Nombre de usuario">
    <input type="email" name="register_email"
        class="block w-full px-4 py-3 mb-4 border  border-transparent border-secondary rounded-lg focus:ring focus:ring-sky-500 focus:outline-none text-primary"
        placeholder="Direccion de correo">
    <input type="password" name="register_password" autocomplete="off"
        class="block w-full px-4 py-3 mb-4 border  border-transparent border-secondary rounded-lg focus:ring focus:ring-sky-500 focus:outline-none text-primary"
        placeholder="Contraseña">
    <input type="password" name="register_confirm_password" autocomplete="off"
        class="block w-full px-4 py-3 mb-4 border  border-transparent border-secondary rounded-lg focus:ring focus:ring-sky-500 focus:outline-none text-primary"
        placeholder="Confirmar contraseña">
    <div class="block">
        <button data-register-button class="w-full px-3 py-4 font-medium text-white bg-accent-3 rounded-lg">
            <?php _e('Registrarme', 'kiranime');?>
        </button>
    </div>
    <p data-register-error-info class="w-full mt-4 text-sm text-center text-rose-500"></p>
    <p class="w-full mt-4 text-sm text-center text-gray-400">
        <?php _e('Ya tienes una cuenta?', 'kiranime');?>
        <button data-to-login-button class="text-sky-500 underline">
            <?php _e('Inicia sesión', 'kiranime');?>
        </button>
    </p>
    <?php else: ?>
    <p class="w-full mt-4 text-xsm text-center text-rose-500"><?php _e('El registro de nuevos usuarios esta deshabilitado por el adimistrador,
    Si ya tienes una cuenta, Inicia sesión', 'kiranime')?>, <button data-to-login-button
            class="text-sky-500 underline"><?php _e('Iniciar sesión', 'kiranime')?></button>.
    </p>
    <?php endif;?>
</div>