<?php
if (!defined('ABSPATH'))
    exit;

function newsletter_admin_menu()
{
    add_menu_page('Newsletter Submissions', 'Newsletter', 'manage_options', 'newsletter_submissions', 'newsletter_admin_page');
}
add_action('admin_menu', 'newsletter_admin_menu');

function newsletter_admin_page()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    $subscribers = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");

    // Check if a delete action is requested
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $id_to_delete = intval($_GET['id']);

        // Perform the deletion
        $wpdb->delete($table_name, array('id' => $id_to_delete));

        // Redirect to avoid re-posting the form if the page is refreshed
        wp_redirect(admin_url('admin.php?page=newsletter_submissions'));
        exit;
    }
    ?>
    <div class="wrap">
        <h2>Newsletter Submissions</h2>
        <table class="widefat">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subscribers as $subscriber): ?>
                    <tr>
                        <td><?php echo esc_html($subscriber->id); ?></td>
                        <td><?php echo esc_html($subscriber->email); ?></td>
                        <td><?php echo esc_html(date('F j, Y, g:i a', strtotime($subscriber->created_at))); ?></td>
                        <td>
                            <!-- Delete button -->
                            <a href="<?php echo admin_url('admin.php?page=newsletter_submissions&action=delete&id=' . $subscriber->id); ?>"
                                class="button"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar este suscriptor?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>