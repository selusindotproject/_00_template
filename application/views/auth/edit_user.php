<div class="box box-info">

    <div class="box-header with-border">
        <h3 class="box-title"><?php echo lang('edit_user_subheading') ?></h3>
    </div>
    <!-- /.box-header -->

    <!-- form start -->
    <?php echo form_open(uri_string(), 'class="form-horizontal"');?>

        <div class="box-body">

            <div class="row col-sm-12">
                <div id="infoMessage"><?php echo $message;?></div>
            </div>

            <div class="form-group">
                <?php echo lang('edit_user_fname_label', 'first_name', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($first_name, '', 'class="form-control"');?>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('edit_user_lname_label', 'last_name', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($last_name, '', 'class="form-control"');?>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('edit_user_company_label', 'company', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($company, '', 'class="form-control"');?>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('edit_user_phone_label', 'phone', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($phone, '', 'class="form-control"');?>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('edit_user_password_label', 'password', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($password, '', 'class="form-control"');?>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('edit_user_password_confirm_label', 'password_confirm', 'class="col-sm-2 control-label"');?>
                <div class="col-sm-8">
                    <?php echo form_input($password_confirm, '', 'class="form-control"');?>
                </div>
            </div>

            <?php if ($this->ion_auth->is_admin()): ?>

                <div class="form-group">
                    <?php echo lang('edit_user_groups_heading', 'groups', 'class="col-sm-2 control-label"');?>
                    <div class="col-sm-8">
                        <?php foreach ($groups as $group):?>
                            <!-- <input type="checklist" name="groups[]" value="<?php echo $group['id'];?>" <?php echo (in_array($group, $currentGroups)) ? 'checked="checked"' : null; ?>>
                            <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                            <br> -->
                            <div class="radio">
                                <label>
                                    <input type="radio" name="groups" value="<?php echo $group['id'];?>" <?php echo (in_array($group, $currentGroups)) ? 'checked="checked"' : null; ?>>
                                    <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                                </label>
                            </div>
                        <?php endforeach?>
                    </div>
                </div>

            <?php endif ?>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><?php echo lang('edit_user_submit_btn') ?></button>
            <a href="<?php echo site_url() ?>auth" type="button" class="btn btn-danger">Cancel</a>
        </div>
        <!-- /.box-footer -->

        <?php echo form_hidden('id', $user->id);?>
        <?php echo form_hidden($csrf); ?>

    </form>

</div>
