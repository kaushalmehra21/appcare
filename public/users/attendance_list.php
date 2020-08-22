<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php is($userData->type) and breadcrumb_start($userData->type, 'add/user', 'admin_add');

?>
<div class="row" id="cancel-row">
	<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
		<div class="widget-content widget-content-area br-6">

			<div class="table-responsive mb-4 mt-4">
				<h1>Attendance Data: <?= ucfirst($userData->user->first_name) ?></h1>
				<table id="multi-column-ordering" class="style-3 table table-hover" style="width:100%">
					<thead>
						<tr>
							<th style="width: 1%">#</th>
							<th class="text-center">Attendance</th>
							<th>Created date</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($userData) and !empty($userData->data)) :
							$i = 1;
							foreach ($userData->data as $key => $value) : ?>
								<tr>
									<td><?php echo $i++; ?>.</td>

									<td class="text-center">

										<?php
										if ($value->present_status == 0) {
										?>
											<span class="badge px-2 py-1 badge-danger">
												<?php echo 'absent'; ?>
											</span>
										<?php
										} else if ($value->present_status == 1) {
										?>
											<span class="badge px-2 py-1 badge-success">
												<?php echo 'present'; ?>
											</span>
										<?php
										} else if ($value->present_status == 3) {
										?>
											<span class="badge px-2 py-1 badge-danger">
												<?php echo 'absent'; ?>
											</span>
										<?php
										}
										?>
									</td>
									<td>
										<?php if (is_numeric($value->created_date)) : ?>
											<?php echo date('M d, Y', $value->created_date),
												' At<br>',
												date('h: i A', $value->created_date); ?>
										<?php else : ?>
											<?php echo date('M d, Y', strtotime($value->created_date)),
												' At<br>',
												date('h: i A', strtotime($value->created_date)); ?>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
					<tfoot>
						<tr>
							<th style="width: 1%">#</th>
							<th class="text-center">Attendance</th>
							<th>Created date</th>
						</tr>
					</tfoot>
				</table>
			</div>