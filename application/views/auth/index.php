<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?php echo lang('index_subheading') ?></h3>
    </div>
    <!-- /.box-header -->

    <div class="box-body">

      <div class="row col-sm-12">
          <div id="infoMessage"><?php echo $message;?></div>
      </div>

	<table id="example2" class="table table-bordered table-hover">
		<thead>
		<tr>
			<th><?php echo lang('index_fname_th');?></th>
			<th><?php echo lang('index_lname_th');?></th>
			<th><?php echo lang('index_email_th');?></th>
			<th><?php echo lang('index_groups_th');?></th>
			<th><?php echo lang('index_status_th');?></th>
			<th><?php echo lang('index_action_th');?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($users as $user):?>
			<tr>
				<td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
				<td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
				<td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
				<td>
					<?php foreach ($user->groups as $group):?>
						<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
					<?php endforeach?>
				</td>
				<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
				<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
  </div>
  <!-- /.box-body -->

  <div class="box-footer">
	<!-- <h3 class="box-title"><?php echo lang('index_subheading') ?></h3> -->
	<!-- <p><?php echo anchor('auth/create_user', lang('index_create_user_link'))?> | <?php echo anchor('auth/create_group', lang('index_create_group_link'))?></p> -->
    <p><?php echo anchor('auth/create_user', lang('index_create_user_link'))?></p>
  </div>
  <!-- /.box-footer -->
</div>
<!-- /.box -->

<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
