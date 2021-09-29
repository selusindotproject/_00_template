<div class="box box-info">

    <!-- <div class="box-header with-border"> -->
        <!-- <h3 class="box-title"><?php echo lang('create_user_subheading') ?></h3> -->
    <!-- </div> -->
    <!-- /.box-header -->

    <!-- form start -->
    <?php echo form_open("auth/change_password", 'class="form-horizontal"');?>

        <div class="box-body">

            <div class="row col-sm-12">
                <div id="infoMessage"><?php echo $message;?></div>
            </div>

            <div class="form-group">
                <?php echo lang('change_password_old_password_label', 'old_password', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($old_password, '', 'class="form-control"');?>
                </div>
            </div>

            <div class="form-group">
                <?php echo sprintf(lang('change_password_new_password_label', 'new_password', 'class="col-sm-2 control-label"'), $min_password_length);?>
                <div class="col-sm-8">
                    <?php echo form_input($new_password, '', 'class="form-control"');?>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($new_password_confirm, '', 'class="form-control"');?>
                </div>
            </div>

            <?php echo form_input($user_id);?>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><?php echo lang('change_password_submit_btn') ?></button>
            <a href="<?php echo site_url() ?>" type="button" class="btn btn-danger">Cancel</a>
        </div>
        <!-- /.box-footer -->

    </form>

</div>
