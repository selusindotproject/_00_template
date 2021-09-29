<div class="box box-info">

    <div class="box-header with-border">
        <h3 class="box-title"><?php echo lang('create_user_subheading') ?></h3>
    </div>
    <!-- /.box-header -->

    <!-- form start -->
    <?php echo form_open("auth/create_user", 'class="form-horizontal"');?>

        <div class="box-body">

            <div class="row col-sm-12">
                <div id="infoMessage"><?php echo $message;?></div>
            </div>

            <div class="form-group">
                <?php echo lang('create_user_fname_label', 'first_name', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($first_name, '', 'class="form-control"');?>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('create_user_lname_label', 'last_name', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($last_name, '', 'class="form-control"');?>
                </div>
            </div>

            <?php
            if($identity_column!=='email') {
            ?>
                <div class="form-group">
                    <?php echo lang('create_user_identity_label', 'identity', 'class="col-sm-2 control-label"');?>
                    <div class="col-sm-8">
                        <?php echo form_input($identity, '', 'class="form-control"');?>
                        <?php echo form_error('identity') ?>
                    </div>
                </div>
            <?php
            }
            ?>

            <div class="form-group">
                <?php echo lang('create_user_company_label', 'company', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($company, '', 'class="form-control"');?>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('create_user_email_label', 'email', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($email, '', 'class="form-control"');?>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('create_user_phone_label', 'phone', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($phone, '', 'class="form-control"');?>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('create_user_password_label', 'password', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($password, '', 'class="form-control"');?>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('create_user_password_confirm_label', 'password_confirm', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($password_confirm, '', 'class="form-control"');?>
                </div>
            </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><?php echo lang('create_user_submit_btn') ?></button>
            <a href="<?php echo site_url() ?>auth" type="button" class="btn btn-danger">Cancel</a>
        </div>
        <!-- /.box-footer -->

    </form>

</div>
