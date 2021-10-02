<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>T90_groups_menu List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Idgroups</th>
		<th>Idmenu</th>
		<th>Rights</th>
		
            </tr><?php
            foreach ($t90_groups_menu_data as $t90_groups_menu)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $t90_groups_menu->idgroups ?></td>
		      <td><?php echo $t90_groups_menu->idmenu ?></td>
		      <td><?php echo $t90_groups_menu->rights ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>