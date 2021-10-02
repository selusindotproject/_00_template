<!-- <!doctype html>
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
        <h2 style="margin-top:0px">T86_groups <?php echo $button ?></h2> -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $this->uri->segment(2) == 'create' ? 'Tambah' : 'Ubah' ?></h3>
            </div>
            <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
                <div class="box-body">
					<div class="form-group">
                        <label class="col-sm-2 control-label" for="varchar">Name </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" /> <?php echo form_error('name') ?>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-2 control-label" for="varchar">Description </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="<?php echo $description; ?>" /> <?php echo form_error('description') ?>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                    <a href="<?php echo site_url('t86_groups') ?>" class="btn btn-default">Batal</a>
                </div>

				<input type="hidden" name="id" value="<?php echo $id; ?>" /> 
			</form>
        </div>
    <!-- </body>
</html> -->