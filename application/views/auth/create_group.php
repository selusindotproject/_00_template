<div class="box box-info">

    <div class="box-header with-border">
        <h3 class="box-title"><?php echo lang('create_group_subheading') ?></h3>
    </div>
    <!-- /.box-header -->

    <!-- form start -->
    <?php echo form_open("auth/create_group", 'class="form-horizontal"');?>

        <div class="box-body">

            <div class="row col-sm-12">
                <div id="infoMessage"><?php echo $message;?></div>
            </div>

            <div class="form-group">
                <?php echo lang('create_group_name_label', 'group_name', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($group_name, '', 'class="form-control"');?>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('create_group_desc_label', 'description', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($description, '', 'class="form-control"');?>
                </div>
            </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><?php echo lang('create_group_submit_btn') ?></button>
            <a href="<?php echo site_url() ?>auth" type="button" class="btn btn-danger">Cancel</a>
        </div>
        <!-- /.box-footer -->

    </form>

</div>
