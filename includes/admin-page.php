<?php
if (!defined('ABSPATH'))
    exit;

function newsletter_admin_menu()
{
    add_menu_page(
        'Form Submissions',
        'Form Submissions',
        'manage_options',
        'form_submissions',
        'newsletter_admin_page',
        'dashicons-email',
        25
    );

    add_submenu_page(
        'form_submissions',
        'Newsletter Submissions',
        'Newsletter Submissions',
        'manage_options',
        'newsletter_submissions',
        'newsletter_admin_page'
    );

    add_submenu_page(
        'form_submissions',
        'Contact Submissions',
        'Contact Submissions',
        'manage_options',
        'contact_submissions',
        'contact_admin_page'
    );
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
                    <th>Action</th>
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

// Contact Form Admin Page
function contact_admin_page()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_form_submissions';
    $submissions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");

    // Check if a delete action is requested
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $id_to_delete = intval($_GET['id']);

        // Perform the deletion
        $wpdb->delete($table_name, array('id' => $id_to_delete));

        // Redirect to avoid re-posting the form if the page is refreshed
        wp_redirect(admin_url('admin.php?page=contact_submissions'));
        exit;
    }
    ?>
    <div class="wrap">
        <h2>Contact Form Submissions</h2>
        <table class="widefat">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($submissions as $submission): ?>
                    <tr>
                        <td><?php echo esc_html($submission->id); ?></td>
                        <td><?php echo esc_html($submission->name); ?></td>
                        <td><?php echo esc_html($submission->email); ?></td>
                        <td><?php echo esc_html($submission->phone); ?></td>
                        <td><?php echo esc_html($submission->message); ?></td>
                        <td><?php echo esc_html(date('F j, Y, g:i a', strtotime($submission->created_at))); ?></td>
                        <td>
                            <!-- Delete button -->
                            <a href="<?php echo admin_url('admin.php?page=contact_submissions&action=delete&id=' . $submission->id); ?>"
                                class="button"
                                onclick="return confirm('¿Está seguro de que desea eliminar este envío?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>