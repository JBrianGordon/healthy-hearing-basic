<?php
use Cake\Utility\Inflector;
$displayTitle = isset($reportReadable[$title]) ? $reportReadable[$title] : Inflector::humanize($title);
?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered table-condensed">
            <tr>
                <th colspan="5">
                    <h4><?php echo $displayTitle; ?></h4>
                </th>
            </tr>
            <?php if ($title != 'other_brands'): ?>
                <?php foreach ($data as $key => $value): ?>
                    <?php
                    if ($title == 'purchased') {
                        if (isset(CaCallGroup::$questionBrandAnswers[$key])) {
                            $fieldTitle = CaCallGroup::$questionBrandAnswers[$key];
                        } else {
                            $fieldTitle = isset($reportReadable[$key]) ? $reportReadable[$key] : Inflector::humanize($key);
                        }
                    } else {
                        $fieldTitle = isset($reportReadable[$key]) ? $reportReadable[$key] : Inflector::humanize($key);
                    }
                    ?>
                    <tr>
                        <td width="28%"><?php echo $fieldTitle; ?></td>
                        <?php if (is_array($value)): ?>
                            <?php if ($key == 'title'): ?>
                                <td width="24%" colspan="2"><?php echo $value[0]; ?></td>
                                <td width="48%" colspan="3"><?php echo $value[1]; ?></td>
                            <?php elseif ($key == 'subtitle'): ?>
                                <td width="24%"><?php echo $value[0]; ?></td>
                                <td width="16%"><?php echo $value[1]; ?></td>
                                <td width="32%"><?php echo $value[2]; ?></td>
                            <?php elseif ($key == 'column_label'): ?>
                                <th width="36%" colspan="2"><?php echo $value[0]; ?></th>
                                <th width="36%" colspan="2" class="bl-dark"><?php echo $value[1]; ?></th>
                            <?php elseif (isset($value['sd_total'])): ?>
                                <td width="12%"><?php echo $value['sd_total']; ?></td>
                                <td width="12%"><?php echo round($value['sd_percent']*100, 2).'%'; ?></td>
                                <td width="16%"><?php echo isset($value['sd_estimate']) ? $value['sd_estimate'] : ''; ?></td>
                            <?php elseif (isset($value['percent_of_attempted'])): ?>
                                <td width="24%" colspan="2"><?php echo $value['total']; ?></td>
                                <td width="48%" colspan="3">
                                    <?php echo round($value['percent_of_attempted']*100, 2).'% of attempted'; ?><br>
                                    <?php echo round($value['percent_of_appt_set']*100, 2).'% of appointments set'; ?>
                                </td>
                            <?php elseif (isset($value['init_percent'])): ?>
                                <td width="18%"><?php echo $value['init_total']; ?></td>
                                <td width="18%"><?php echo round($value['init_percent']*100, 2).'%'; ?></td>
                                <td width="18%" class="bl-dark"><?php echo $value['final_total']; ?></td>
                                <td width="18%"><?php echo round($value['final_percent']*100, 2).'%'; ?></td>
                            <?php elseif (isset($value['init_total'])): ?>
                                <?php
                                $initClass = '';
                                if (($title=='call_groups' && $key=='adjusted_total') ||
                                    ($title=='prospects' && $key=='total')) {
                                    $initClass = 'metric-reported';
                                }
                                $finalClass = '';
                                if ($title=='appointments_set' && $key=='total') {
                                    $finalClass = 'metric-reported';
                                }
                                ?>
                                <td width="36%" colspan="2" class="<?php echo $initClass;?>"><?php echo $value['init_total']; ?></td>
                                <td width="36%" colspan="2" class="bl-dark <?php echo $finalClass;?>"><?php echo $value['final_total']; ?></td>
                            <?php else: ?>
                                <td width="24%" colspan="2"><?php echo $value['total']; ?></td>
                                <td width="48%" colspan="3"><?php echo round($value['percent']*100, 2).'%'; ?></td>
                            <?php endif; ?>
                        <?php else: ?>
                            <td width="72%" colspan="5"><?php echo $value; ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Other Brands -->
                <tr>
                    <td>
                        <ul>
                            <?php foreach ($data as $id => $otherBrand): ?>
                                <?php if (!empty($otherBrand)): ?>
                                    <li><?php echo $id.' : '.$otherBrand; ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
