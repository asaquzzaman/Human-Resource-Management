<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'time' );

if ( file_exists( $header_path ) ) {
  require_once $header_path;
}
if ( ! hrm_user_can_access( $page, $tab, $subtab, 'view' ) ) {
    printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
    return;
}
?>
<div class="hrm-update-notification"></div>
<?php
$hidden_form['punch_without_frm'] = array(
    'label'      => __( 'Punch Form' ),
    'type'       => 'checkbox',
    'desc'       => 'Punch in/out with submit form',
    'wrap_class' => 'hrm-parent-field',
    'fields'     => array(
        array(
            'label' => __( 'Enabel', 'hrm' ),
            'value' => 'yes',
            'checked' => get_option( 'hrm_punch_form_status', true ),
            'class'  => 'hrm-punch-form-status'
        )
    )
);
$hidden_form['header'] = __( 'Punch Form Status', 'hrm' );
$hidden_form['class'] = 'postbox';

echo hrm_Settings::getInstance()->form_field_only( $hidden_form  );

$file_path = urlencode(__FILE__);
$url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab );
global $hrm_is_admin;
?>

<script type="text/javascript">
    jQuery(function($) {
        hrm_dataAttr = {
           add_form_generator_action : 'add_form',
           add_form_apppend_wrap : 'hrm-admin-role',
           class_name : 'Hrm_Time',
           redirect : '<?php echo $url; ?>',
           function_name : 'role_permission',
           tab: '<?php echo $tab; ?>',
           page: '<?php echo $page; ?>',
           tab: '<?php echo $tab; ?>',
           subtab: '<?php echo $subtab; ?>',
           req_frm: '<?php echo $file_path; ?>',
           is_admin: '<?php echo $hrm_is_admin; ?>',
        };
    });
</script>