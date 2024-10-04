<?php
use Cake\Core\Configure;
$startDate = isset($startDate) ? date('Y-m-d', strtotime($startDate)) : null;
$endDate = isset($endDate) ? date('Y-m-d', strtotime($endDate)) : null;
?>
<h1>Appt Request Form Metrics</h1>
<?= $this->Form->create() ?>
	<fieldset>
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
	<h4>Report for dates: <?php echo date('Y-m-d', strtotime($startDate)); ?> to <?php echo date('Y-m-d', strtotime($endDate)); ?></h4>
	<?php foreach ($results as $key => $result): ?>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-striped table-bordered table-condensed">
					<tr>
						<th colspan="3">
							<h4 class="pull-left"><?php echo $filters[$key]; ?></h4>
							<?php
							if ($key == 'businessHours') {
								echo $this->Html->link('<span class="glyphicon glyphicon-download-alt"></span> Export',
									['action' => 'forms_export', 'ext' => 'csv', 'startDate' => $startDate, 'endDate' => $endDate],
									['escape' => false, 'class' => 'btn btn-default btn-sm pull-right']);
							}
							?>
						</th>
					</tr>
					<tr>
						<th width="50%">Form submissions</th>
						<td colspan="2"><?php echo $result['total']; ?></td>
					</tr>
					<tr>
						<th>Average time until initial call back</th>
						<?php
						$totalMinutes = round($result['averageInitTimeDiff']/60);
						$hours = floor($result['averageInitTimeDiff']/3600);
						$minutes = $totalMinutes - ($hours * 60);
						?>
						<td colspan="2">
							<?php echo $totalMinutes.' minutes'; ?>
							<?php echo $hours > 0 ? ' ('.$hours.' hours, '.$minutes.' minutes)' : ''; ?>
						</td>
					</tr>
					<tr>
						<th>Initial call back within 1 hour</th>
						<td width="20%"><?php echo $result['callback1Hour']; ?></td>
						<td width="30%"><?php echo empty($result['total']) ? 0 : round(($result['callback1Hour']/$result['total'])*100, 1).'%'; ?></td>
					</tr>
					<tr>
						<th>Initial call back same day</th>
						<td><?php echo $result['callbackSameDay']; ?></td>
						<td><?php echo empty($result['total']) ? 0 : round(($result['callbackSameDay']/$result['total'])*100, 1).'%'; ?></td>
					</tr>
					<tr>
						<th>Initial call back after 1 day</th>
						<td><?php echo $result['callbackAfter1Day']; ?></td>
						<td><?php echo empty($result['total']) ? 0 : round(($result['callbackAfter1Day']/$result['total'])*100, 1).'%'; ?></td>
					</tr>
					<tr>
						<th>Initial call back never</th>
						<td><?php echo $result['callbackNever']; ?></td>
						<td><?php echo empty($result['total']) ? 0 : round(($result['callbackNever']/$result['total'])*100, 1).'%'; ?></td>
					</tr>
					<tr>
						<th># tentative</th>
						<td colspan="2"><?php echo $result['tentative']; ?></td>
					</tr>
					<tr>
						<th># completed</th>
						<td colspan="2"><?php echo $result['completed']; ?></td>
					</tr>
					<tr>
						<th>Average time until completion</th>
						<?php
						$days =  floor($result['averageFinalTimeDiff']/86400);
						$hours = round(($result['averageFinalTimeDiff'] - ($days * 86400))/3600, 1);
						?>
						<td colspan="2">
							<?php if (!empty($days)): ?>
								<?php echo $days.' days, '; ?>
							<?php endif; ?>
							<?php echo $hours.' hours'; ?>
						</td>
					</tr>
					<tr>
						<th>Average calls until completion</th>
						<td colspan="2"><?php echo round($result['averageCallsUntilComplete'], 1); ?></td>
					</tr>
					<tr>
						<th>Completed with initial call back</th>
						<td colspan="2"><?php echo $result['completedWithInitialCall']; ?></td>
					</tr>
					<tr>
						<th>Completed with subsequent call back</th>
						<td colspan="2"><?php echo $result['completedWithSubsequentCall']; ?></td>
					</tr>
					<tr>
						<th>Complete - Non-prospect</th>
						<td><?php echo $result['nonProspect']; ?></td>
						<td><?php echo empty($result['completed']) ? 0 : round(($result['nonProspect']/$result['completed'])*100, 1).'% of completed'; ?></td>
					</tr>
					<tr>
						<th>Complete - Prospect</th>
						<td><?php echo $result['prospect']; ?></td>
						<td><?php echo empty($result['completed']) ? 0 : round(($result['prospect']/$result['completed'])*100, 1).'% of completed'; ?></td>
					</tr>
					<tr>
						<th>Complete/Prospect - Disconnected</th>
						<td><?php echo $result['disconnect']; ?></td>
						<td><?php echo empty($result['prospect']) ? 0 : round(($result['disconnect']/$result['prospect'])*100, 1).'% of prospects'; ?></td>
					</tr>
					<tr>
						<th>Complete/Prospect - Missed Opportunity</th>
						<td><?php echo $result['missedOpportunity']; ?></td>
						<td><?php echo empty($result['prospect']) ? 0 : round(($result['missedOpportunity']/$result['prospect'])*100, 1).'% of prospects'; ?></td>
					</tr>
					<tr>
						<th>Complete/Prospect - Appointments set</th>
						<td><?php echo $result['apptSet']; ?></td>
						<td><?php echo empty($result['prospect']) ? 0 : round(($result['apptSet']/$result['prospect'])*100, 1).'% of prospects'; ?></td>
					</tr>
				</table>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>
