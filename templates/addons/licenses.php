<div class="wrap">
    <div class="wpspear-license-wrap">
        <form method="post" action="">
            <table>
                <?php foreach ( $licenses as $key => $license ) {?>

                    <tr>
                        <th scope="row"><?php echo esc_attr( $license['item_name'] ) . ' Licensing'; ?></th>
                        <td>
                            <?php 

                            ( new $license['class_name'] )->license_key_callback( $license ); 
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <input type="submit" class="button button-primary" name="woogool_license_submi" value="Save Changes">
        </form>
    </div>
</div>

<style type="text/css">
    .wpspear-license-wrap table {
        width: 100%;
    }
    .wpspear-license-wrap table td {
        display: block;
    }
    .wpspear-license-wrap tr {
        float: left;
        margin: 0 15px 15px 0;
        background: #fff;
        border: 1px solid #ccc;
        width: 30.5%;
        max-width: 350px;
        padding: 14px;
        min-height: 220px;
        position: relative;
        box-sizing: border-box;
    }

    .wpspear-license-wrap th {
        background: #f9f9f9;
        padding: 14px;
        border-bottom: 1px solid #ccc;
        margin: -14px -14px 20px;
        width: 100%;
        display: block;
    }

    .wpspear-license-wrap td input.regular-text {
        margin: 0 0 8px;
        width: 100%;
    }

    .wpspear-license-wrap .edd-license-data {
        background: #fafafa; 
        padding: 0px 8px 6px 15px;
        margin: 20px -15px -14px;
        border-top: 1px solid #eee; 
        min-height: 67px;
        bottom: 14px;
        box-sizing: border-box;
    }

</style>
