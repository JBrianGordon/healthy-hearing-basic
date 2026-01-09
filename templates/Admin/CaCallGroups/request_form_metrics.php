<?php
use Cake\Core\Configure;
$startDate = isset($startDate) ? date('Y-m-d', strtotime($startDate)) : null;
$endDate = isset($endDate) ? date('Y-m-d', strtotime($endDate)) : null;

$this->Vite->script('admin_common','admin-vite');
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Ca Calls Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->element('ca_calls/action_bar') ?>
			</div>
		</div>
	</div>
</header>						
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
				<h2>Appt Request Form Metrics</h2>
				<div class="caCalls index content">
					<?= $this->Form->create() ?>
						<fieldset class="w-50">
							<?php
								echo $this->Form->control('start_date', ['type' => 'date', 'required' => true]);
								echo $this->Form->control('end_date', ['type' => 'date', 'required' => true]);
							?>
						</fieldset>
						<div class="form-actions tar">
							<?= $this->Form->button('Find Report', ['class' => 'btn btn-primary btn-lg']) ?>
						</div>
					<?= $this->Form->end() ?>

					<?php if (!empty($results)): ?>
						<hr>
						<h4>Report for dates: <?= date('Y-m-d', strtotime($startDate)) ?> to <?= date('Y-m-d', strtotime($endDate)) ?></h4>
						<?php foreach ($results as $key => $result): ?>
							<div class="row">
								<div class="col-md-12">
									<table class="table table-striped table-bordered table-condensed">
										<tr>
											<th colspan="3">
												<h4 class="pull-left d-inline"><?= $filters[$key];?></h4>
												<?php
												if ($key == 'businessHours') {
													echo $this->Html->link(' Export',
														['action' => 'forms_export', '?' => ['startDate' => $startDate, 'endDate' => $endDate]],
														['escape' => false, 'class' => 'btn btn-default btn-sm pull-right bi bi-download mb20']);
												}
												?>
											</th>
										</tr>
										<tr>
											<th width="50%">Form submissions</th>
											<td colspan="2"><?= $result['total'] ?></td>
										</tr>
										<tr>
											<th>Average time until initial call back</th>
											<?php
											$totalMinutes = round($result['averageInitTimeDiff']/60);
											$hours = floor($result['averageInitTimeDiff']/3600);
											$minutes = $totalMinutes - ($hours * 60);
											?>
											<td colspan="2">
												<?= $totalMinutes.' minutes' ?>
												<?= $hours > 0 ? ' ('.$hours.' hours, '.$minutes.' minutes)' : '' ?>
											</td>
										</tr>
										<tr>
											<th>Initial call back within 1 hour</th>
											<td width="20%"><?= $result['callback1Hour'] ?></td>
											<td width="30%"><?= empty($result['total']) ? 0 : round(($result['callback1Hour']/$result['total'])*100, 1).'%' ?></td>
										</tr>
										<tr>
											<th>Initial call back same day</th>
											<td><?= $result['callbackSameDay'] ?></td>
											<td><?= empty($result['total']) ? 0 : round(($result['callbackSameDay']/$result['total'])*100, 1).'%' ?></td>
										</tr>
										<tr>
											<th>Initial call back after 1 day</th>
											<td><?= $result['callbackAfter1Day'] ?></td>
											<td><?= empty($result['total']) ? 0 : round(($result['callbackAfter1Day']/$result['total'])*100, 1).'%' ?></td>
										</tr>
										<tr>
											<th>Initial call back never</th>
											<td><?= $result['callbackNever'] ?></td>
											<td><?= empty($result['total']) ? 0 : round(($result['callbackNever']/$result['total'])*100, 1).'%' ?></td>
										</tr>
										<tr>
											<th># tentative</th>
											<td colspan="2"><?= $result['tentative'] ?></td>
										</tr>
										<tr>
											<th># completed</th>
											<td colspan="2"><?= $result['completed'] ?></td>
										</tr>
										<tr>
											<th>Average time until completion</th>
											<?php
											$days =  floor($result['averageFinalTimeDiff']/86400);
											$hours = round(($result['averageFinalTimeDiff'] - ($days * 86400))/3600, 1);
											?>
											<td colspan="2">
												<?php if (!empty($days)): ?>
													<?= $days.' days, ' ?>
												<?php endif; ?>
												<?= $hours.' hours' ?>
											</td>
										</tr>
										<tr>
											<th>Average calls until completion</th>
											<td colspan="2"><?= round($result['averageCallsUntilComplete'], 1) ?></td>
										</tr>
										<tr>
											<th>Completed with initial call back</th>
											<td colspan="2"><?= $result['completedWithInitialCall'] ?></td>
										</tr>
										<tr>
											<th>Completed with subsequent call back</th>
											<td colspan="2"><?= $result['completedWithSubsequentCall'] ?></td>
										</tr>
										<tr>
											<th>Complete - Non-prospect</th>
											<td><?= $result['nonProspect'] ?></td>
											<td><?= empty($result['completed']) ? 0 : round(($result['nonProspect']/$result['completed'])*100, 1).'% of completed' ?></td>
										</tr>
										<tr>
											<th>Complete - Prospect</th>
											<td><?= $result['prospect'] ?></td>
											<td><?= empty($result['completed']) ? 0 : round(($result['prospect']/$result['completed'])*100, 1).'% of completed' ?></td>
										</tr>
										<tr>
											<th>Complete/Prospect - Disconnected</th>
											<td><?= $result['disconnect'] ?></td>
											<td><?= empty($result['prospect']) ? 0 : round(($result['disconnect']/$result['prospect'])*100, 1).'% of prospects' ?></td>
										</tr>
										<tr>
											<th>Complete/Prospect - Missed Opportunity</th>
											<td><?= $result['missedOpportunity'] ?></td>
											<td><?= empty($result['prospect']) ? 0 : round(($result['missedOpportunity']/$result['prospect'])*100, 1).'% of prospects' ?></td>
										</tr>
										<tr>
											<th>Complete/Prospect - Appointments set</th>
											<td><?= $result['apptSet'] ?></td>
											<td><?= empty($result['prospect']) ? 0 : round(($result['apptSet']/$result['prospect'])*100, 1).'% of prospects' ?></td>
										</tr>
									</table>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
</div>