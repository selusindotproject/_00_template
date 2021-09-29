<div class="box box-info">

    <div class="box-header with-border">
        <h3 class="box-title"><?php echo lang('edit_group_subheading') ?></h3>
    </div>
    <!-- /.box-header -->

    <!-- form start -->
    <?php echo form_open(current_url(), 'class="form-horizontal"');?>

        <div class="box-body">

            <div class="row col-sm-12">
                <div id="infoMessage"><?php echo $message;?></div>
            </div>

            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang('edit_group_name_label') ?></label>
                <div class="col-sm-8">
                    <!-- <input type="email" class="form-control" id="inputEmail3" placeholder="Email"> -->
                    <?php echo form_input($group_name, '', 'class="form-control"');?>
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label"><?php echo lang('edit_group_desc_label') ?></label>
                <div class="col-sm-8">
                    <!-- <input type="password" class="form-control" id="inputPassword3" placeholder="Password"> -->
                    <?php echo form_input($group_description, '', 'class="form-control"');?>
                </div>
            </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><?php echo lang('edit_group_submit_btn') ?></button>
            <a href="<?php echo site_url() ?>auth" type="button" class="btn btn-danger">Cancel</a>
        </div>
        <!-- /.box-footer -->

    </form>

</div>
