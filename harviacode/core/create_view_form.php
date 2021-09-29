<?php

$string = "<!-- <!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel=\"stylesheet\" href=\"<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>\"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style=\"margin-top:0px\">".ucfirst($table_name)." <?php echo \$button ?></h2> -->
        <div class=\"box box-info\">
            <div class=\"box-header with-border\">
                <h3 class=\"box-title\"><?php echo \$this->uri->segment(2) == 'create' ? 'Tambah' : 'Ubah' ?></h3>
            </div>
            <form action=\"<?php echo \$action; ?>\" method=\"post\" class=\"form-horizontal\">
                <div class=\"box-body\">";
foreach ($non_pk as $row) {
    if ($row["data_type"] == 'text')
    {
    $string .= "\n\t\t\t\t\t<div class=\"form-group\">
                        <label class=\"col-sm-2 control-label\" for=\"".$row["column_name"]."\">".label($row["column_name"])." </label>
                        <div class=\"col-sm-3\">
                            <textarea class=\"form-control\" rows=\"3\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\"><?php echo $".$row["column_name"]."; ?></textarea> <?php echo form_error('".$row["column_name"]."') ?>
                        </div>
                    </div>";
    } else
    {
    $string .= "\n\t\t\t\t\t<div class=\"form-group\">
                        <label class=\"col-sm-2 control-label\" for=\"".$row["data_type"]."\">".label($row["column_name"])." </label>
                        <div class=\"col-sm-3\">
                            <input type=\"text\" class=\"form-control\" name=\"".$row["column_name"]."\" id=\"".$row["column_name"]."\" placeholder=\"".label($row["column_name"])."\" value=\"<?php echo $".$row["column_name"]."; ?>\" /> <?php echo form_error('".$row["column_name"]."') ?>
                        </div>
                    </div>";
    }

}
$string .= "
                </div>
                <!-- /.box-body -->
                <div class=\"box-footer\">
                    <button type=\"submit\" class=\"btn btn-primary\"><?php echo \$button ?></button>
                    <a href=\"<?php echo site_url('".$c_url."') ?>\" class=\"btn btn-default\">Batal</a>
                </div>
";
$string .= "\n\t\t\t\t<input type=\"hidden\" name=\"".$pk."\" value=\"<?php echo $".$pk."; ?>\" /> ";
$string .= "\n\t\t\t</form>
        </div>
    <!-- </body>
</html> -->";

$hasil_view_form = createFile($string, $target."views/" . $c_url . "/" . $v_form_file);

?>
