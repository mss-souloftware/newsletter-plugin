<?php
if (!defined('ABSPATH'))
    exit;

function newsletter_submit()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    $email = sanitize_email($_POST['email']);

    if (!is_email($email)) {
        echo 'Email no válido';
        wp_die();
    }

    $exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE email = %s", $email));
    if ($exists) {
        echo 'Ya estás suscrito';
        wp_die();
    }

    // Insert into database
    $wpdb->insert($table_name, ['email' => $email]);

    // Send email notification
    newsletter_send_email($email);

    echo '¡Suscripción exitosa! Revisa tu correo electrónico para tu descuento.';
    wp_die();
}

add_action('wp_ajax_newsletter_submit', 'newsletter_submit');
add_action('wp_ajax_nopriv_newsletter_submit', 'newsletter_submit');

function newsletter_send_email($email)
{
    $subject = "¡Gracias por unirte! Aquí tienes tu 10% 🎉";

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: Crea Tu Brownie <info@creatubrownie.com>'
    ];

    $message = '
    <table cellspacing="0" style="max-width: 650px; width: 100%; margin: 0 auto; border: 1px solid #CCCCCC; padding: 15px; font-family: Arial, Helvetica, sans-serif; background:#fff;">
        <thead>
            <tr style="border-bottom: 2px solid #CCCCCC;">
                <td>
                    <a style="max-width: 150px;" href="https://creatubrownie.com/" target="_blank">
                        <img style="max-width: 150px;" src="https://creatubrownie.com/wp-content/uploads/2025/02/creatubrownie-logo.png" alt="Creatubrownie">
                    </a>
                </td>
            </tr>
            <tr>
                <td colspan="2"><div style="border-bottom: 1px solid #CCCCCC;"></div></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <img style="max-width: 150px; margin:auto; margin-bottom:30px;" src="https://chocoletra.com/wp-content/uploads/2024/12/272535.png" alt="Creatubrownie">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <span style="background:#DDDDDD; color:#000; padding:5px 15px; border-radius:5px; margin-top:10px; font-weight:bold; text-transform:uppercase;">BIENVENIDO10</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="text-align: center; font-size: 16px; margin: 40px 0px;">
                        ¡Bienvenido a nuestra familia de amantes del brownie! 🍫
                        Estamos emocionados de tenerte aquí, y como agradecimiento, aquí tienes tu 10% de descuento para tu próxima compra.

                        Aprovecha ahora y descubre la magia de nuestros bombones personalizados. 🛍✨
                        👉 <a href="https://creatubrownie.com/tienda-brownies-personalizados/">Compra ahora y disfruta de tu descuento</a>

                        Gracias por confiar en nosotros,
                        El equipo Crea Tu Brownie ❤
                    </p>
                    <p style="text-align: center; font-size: 16px; margin-bottom: 40px;">
                        ¿Tienes alguna pregunta? Contáctanos al siguiente email: <strong><em>info@creatubrownie.com</em></strong>
                    </p>
                </td>
            </tr>
        </tbody>
        <tfoot style="background: #000; padding: 20px;">
            <tr>
                <td colspan="2">
                    <p style="text-align: center; margin: 25px 0;">
                        <span style="color: #ffffff; line-height: 1; font-size: 14px;">
                            <a rel="noopener" href="https://creatubrownie.com/tienda-brownies-personalizados/" target="_blank" style="color: #ffffff;">Tienda</a> |
                            <a rel="noopener" href="https://creatubrownie.com/crea-tu-brownie/" target="_blank" style="color: #ffffff;">Frase</a> |
                            <a rel="noopener" href="https://creatubrownie.com/my-account/" target="_blank" style="color: #ffffff;">Cuenta</a> |
                            <a rel="noopener" href="https://creatubrownie.com/quienes-somos/" target="_blank" style="color: #ffffff;">Quienes somos</a> |
                            <a rel="noopener" href="https://creatubrownie.com/contactanos/" target="_blank" style="color: #ffffff;">Contacto</a>
                        </span>
                    </p>
                    <p style="font-size: 14px; line-height: 1; text-align: center; color: #fff; margin-bottom: 30px;">
                        Copyright © 2024 <span style="color: #ffffff; line-height: 1;">
                            <a rel="noopener" href="https://creatubrownie.com/" target="_blank" style="color: #ffffff;">Crea Tu Brownie</a>.
                        </span>
                    </p>
                </td>
            </tr>
        </tfoot>
    </table>';

    wp_mail($email, $subject, $message, $headers);
}
