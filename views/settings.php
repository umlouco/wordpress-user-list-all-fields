<div class="wrap">
    <h2>User Fields to display in the list</h2>
    <form action="options.php" method="post">
        <?php settings_fields('mf_all_userfields');
        do_settings_sections('mf-all-userfields');
        submit_button('Save Changes', 'primary');
        ?>
    </form>
</div>