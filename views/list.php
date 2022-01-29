<div style="overflow-x:scroll">
<table id="all_userfields">
    <thead>
    <tr>
        <th>Name</th>
        <?php foreach($columns as $c): ?>
            <th>
                <?php 
                    $slug = str_replace('wpcf-', '', $c); 
                    if(array_key_exists($slug, $meta_data)){
                        $title =  $meta_data[$slug]['name']; 
                    } else {
                        $title  =  $slug; 
                    }
                    echo substr($title, 0, 20); 
                    if(strlen($title) > 20){
                        echo '...'; 
                    }
                ?>
            </th>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($user as $u) : ?>
            <?php $user_meta = get_user_meta($u['ID']); ?>
            <tr>
                <td>
                <?php echo empty($user_meta['first_name'][0]) ? '' : $user_meta['first_name'][0]; ?>
                <?php echo empty($user_meta['last_name'][0]) ? '' : $user_meta['last_name'][0]; ?>
                </td>
                <?php foreach($columns as $c): ?>
                    <td>
                        <?php echo empty($user_meta[$c][0]) ? '' : $user_meta[$c][0]; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
<script>
    jQuery(function ($) {
      var dataTable = $('#all_userfields').DataTable(); 
    }); 
</script>