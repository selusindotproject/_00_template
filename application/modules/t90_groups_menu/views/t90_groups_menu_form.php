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
        <h2 style="margin-top:0px">T90_groups_menu <?php echo $button ?></h2> -->
        <div class="box box-info">
            <div class="box-header with-border">
                <!-- <h3 class="box-title"><?php echo $this->uri->segment(2) == 'create' ? 'Tambah' : 'Ubah' ?></h3> -->
                <p class="box-title"><small>Group:</small> <?php echo $dataGroups[0]->description ?></p>
            </div>
            <form action="<?php echo $action; ?>" method="post" class="form-horizontal">
                <div class="box-body">
					<!-- <div class="form-group">
                        <label class="col-sm-2 control-label" for="mediumint">Idgroups </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="idgroups" id="idgroups" placeholder="Idgroups" value="<?php echo $idgroups; ?>" /> <?php echo form_error('idgroups') ?>
                        </div>
                    </div> -->
					<!-- <div class="form-group">
                        <label class="col-sm-2 control-label" for="int">Idmenu </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="idmenu" id="idmenu" placeholder="Idmenu" value="<?php echo $idmenu; ?>" /> <?php echo form_error('idmenu') ?>
                        </div>
                    </div> -->
					<!-- <div class="form-group">
                        <label class="col-sm-2 control-label" for="int">Rights </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="rights" id="rights" placeholder="Rights" value="<?php echo $rights; ?>" /> <?php echo form_error('rights') ?>
                        </div>
                    </div> -->

                    <!-- <?php foreach($dataGroups as $data) { ?>
                    <div class="row">
                        <div class="col-sm-1">
                            Groups:
                        </div>
                        <div class="col-sm-3">
                            <?php echo $data->description ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                            &nbsp;
                        </div>
                        <div class="col-sm-3">
                            &nbsp;
                        </div>
                    </div>
                    <?php break ?>
                    <?php } ?> -->
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered" style="margin-bottom: 10px">
                                <tr>
                                    <th>MODUL</th>
                                    <th class="text-center">TAMBAH</th>
                                    <th class="text-center">UBAH</th>
                                    <th class="text-center">HAPUS</th>
                                </tr>
                                <?php foreach($dataGroups as $data) { ?>
                                    <input type="hidden" name="idgroupsmenu[]" value="<?php echo $data->id ?>" />
                                    <input type="hidden" name="idgroups" value="<?php echo $data->idgroups ?>" />
                                    <tr>
                                        <td>
                                            <?php echo $data->nama ?>
                                        </td>
                                        <?php
                                        $tambah = "";
                                        $ubah = "";
                                        $hapus = "";
                                        switch ($data->rights) {
                                            case 1:
                                                $tambah = "checked";
                                                break;
                                            case 2:
                                                $ubah = "checked";
                                                break;
                                            case 3:
                                                $tambah = "checked";
                                                $ubah = "checked";
                                                break;
                                            case 4:
                                                $hapus = "checked";
                                                break;
                                            case 5:
                                                $tambah = "checked";
                                                $hapus = "checked";
                                                break;
                                            case 6:
                                                $ubah = "checked";
                                                $hapus = "checked";
                                                break;
                                            case 7:
                                                $tambah = "checked";
                                                $ubah = "checked";
                                                $hapus = "checked";
                                                break;
                                        }
                                        ?>
                                        <td class="text-center">
                                            <input value="1" name="_1_<?php echo $data->id ?>" class="form-check-input" type="checkbox" <?php echo $tambah ?>>
                                        </td>
                                        <td class="text-center">
                                            <input value="2" name="_2_<?php echo $data->id ?>" class="form-check-input" type="checkbox" <?php echo $ubah ?>>
                                        </td>
                                        <td class="text-center">
                                            <input value="4" name="_4_<?php echo $data->id ?>" class="form-check-input" type="checkbox" <?php echo $hapus ?>>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                    <a href="<?php echo site_url('t86_groups') ?>" class="btn btn-default">Batal</a>
                </div>

				<!-- <input type="hidden" name="id" value="<?php echo $id; ?>" /> -->
			</form>
        </div>
    <!-- </body>
</html> -->
