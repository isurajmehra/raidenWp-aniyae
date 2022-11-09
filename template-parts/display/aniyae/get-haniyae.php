<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <div class="haniyae-answer" style="display: flex; justify-content: center;">
            <div class="w-full mb-4 flex items-center justify-between mt-10 px-4 sm:px-0">
                        <div class="mr-4">
                            <h2 class="text-2xl leading-10 font-semibold p-0 m-0" style="color: #ff0080;">Para ver el contenido de Haniyae, debes confirmar.</h2>
                        </div>
                            <button id="haniyae" class="px-4 py-2 rounded-full w-max max-w-max flex items-center gap-3 bg-opacity-20 font-medium text-sm my-5 mx-3" style="background-color: #bf266e">Confirmo</button>
            </div>
        </div>
        <script type="text/javascript">
                    $("#haniyae").on("click", function(event){
                    $(".haniyae-container").css("display", "block");
                    $(".haniyae-answer").css("display", "none");
                    });
        </script>
    <div class="haniyae-container" style="display: none">
                    <!-- Start AnimeH -->
        <div class="w-full mb-4 flex items-center justify-between mt-10 px-4 sm:px-0">
                        <div class="mr-4">
                            <h2 class="text-2xl leading-10 font-semibold p-0 m-0" style="color: #ff0080;">H-Aniyae - Obras hentai disponibles</h2>
                        </div>
            <div class="text-sm font-normal text-opacity-75">
                <a class="px-4 py-2 rounded-full w-max max-w-max flex items-center gap-3 bg-opacity-20 font-medium text-sm my-5 mx-3" href="<?=Kiranime_Utility::page_url('pages/haniyae.php');?>" style="background-color: #bf266e">
                    Quiero ver mas
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" class="w-5 h-5 inline-block">
                        <path fill="currentColor"
                            d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z" />
                    </svg>
                </a>
            </div>
        </div>
        <!-- Start Latest id="AnimeH" -->
        <section class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6 gap-2 sm:gap-4 lg:gap-5 justify-evenly w-full flex-auto">
            <?php
                $new_animes = new Kiranime_Query();
                $new_animes = $new_animes->haniyae();
                    if ($new_animes->have_posts()):
                while ($new_animes->have_posts()):
                $new_animes->the_post();
                    get_template_part('template-parts/display/aniyae/list', 'view-haniyae');
                endwhile;
            endif;?>
        </section>
        <!-- End AnimeH -->        
    </div>
    <!-- End Haniyae -->