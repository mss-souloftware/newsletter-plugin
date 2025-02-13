<?php
if (!defined('ABSPATH'))
    exit;

function newsletter_form_shortcode()
{
    ob_start();
    ?>
    <section class="newsletterSec">
        <div class="wrapper">
            <div class="newsletterPanel">
                <div class="textData">
                    <h2>¡Suscríbete y Obtén un 10% de Descuento!</h2>
                    <p>Sé el primero en recibir ofertas exclusivas y novedades deliciosas directamente en tu bandeja de
                        entrada.</p>
                </div>
                <div class="formData">
                    <form id="newsletter-form">
                        <input type="email" id="newsletter-email" placeholder="Escribe tu correo electrónico" required>
                        <button type="submit" id="newsletter-submit">
                            Suscríbete ahora
                            <span class="spinner" style="display:none;"></span>
                        </button>
                    </form>
                    <div id="newsletter-message"></div>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('newsletter_form', 'newsletter_form_shortcode');


function contact_form_shortcode()
{
    ob_start();
    ?>

    <form id="contactForm">
        <div class="fieldWrapper">
            <input type="text" placeholder="Nombre" id="contact_name" required>
        </div>
        <div class="fieldWrapper">
            <input type="email" placeholder="Email" id="contact_email" required>
        </div>
        <div class="fieldWrapper">
            <input type="tel" placeholder="Teléfono" id="contact_phone" required>
        </div>
        <textarea name="message" id="contact_message" rows="4" placeholder="Déjanos tu mensaje"></textarea>
        <div class="fieldWrapper">
            <button id="contactFormSubmit" type="submit">
                Entregar
                <span class="spinner" style="display:none;"></span>
            </button>
        </div>
    </form>
    <div id="contact-message"></div>
    <?php
    return ob_get_clean();
}
add_shortcode('contact_form', 'contact_form_shortcode');

// Enqueue JavaScript & CSS file
function newsletter_enqueue_assets()
{
    wp_enqueue_script('newsletter-script', plugins_url('../assets/script.js', __FILE__), array('jquery'), null, true);
    wp_localize_script('newsletter-script', 'newsletter_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));

    wp_enqueue_style('newsletter-style', plugins_url('../assets/style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'newsletter_enqueue_assets');