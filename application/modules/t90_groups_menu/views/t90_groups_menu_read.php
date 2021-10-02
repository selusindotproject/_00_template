<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">T90_groups_menu Read</h2>
        <table class="table">
	    <tr><td>Idgroups</td><td><?php echo $idgroups; ?></td></tr>
	    <tr><td>Idmenu</td><td><?php echo $idmenu; ?></td></tr>
	    <tr><td>Rights</td><td><?php echo $rights; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('t90_groups_menu') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>