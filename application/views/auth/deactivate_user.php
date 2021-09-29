<div class="box box-info">

    <div class="box-header with-border">
        <h3 class="box-title"><?php echo sprintf(lang('deactivate_subheading'), $user->{$identity}) ?></h3>
    </div>
    <!-- /.box-header -->

    <!-- form start -->
    <?php echo form_open("auth/deactivate/".$user->id, 'class="form-horizontal"');?>

        <div class="box-body">

            <div class="form-group">
                <div class="col-sm-8">
                    <?php echo lang('deactivate_confirm_y_label', 'confirm');?>
                    <input type="radio" name="confirm" value="yes" checked="checked" />
                    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
                    <input type="radio" name="confirm" value="no" />
                </div>
            </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><?php echo lang('deactivate_submit_btn') ?></button>
            <a href="<?php echo site_url() ?>auth" type="button" class="btn btn-danger">Cancel</a>
        </div>
        <!-- /.box-footer -->

        <?php echo form_hidden($csrf); ?>
        <?php echo form_hidden(['id' => $user->id]); ?>

    </form>

</div>
