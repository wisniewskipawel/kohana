<?php if ($type == Model_Ad::TEXT_C): ?>
<option value="14"><?php echo ___('date.days_nb', 14, array(':nb' => 14)) ?></option>
<option value="30"><?php echo ___('date.days_nb', 30, array(':nb' => 30)) ?></option>
<?php elseif ($type == Model_Ad::TEXT_C1): ?>
<option value="1"><?php echo ___('date.months_nb', 1, array(':nb' => 1)) ?></option>
<option value="2"><?php echo ___('date.months_nb', 2, array(':nb' => 2)) ?></option>
<option value="3"><?php echo ___('date.months_nb', 3, array(':nb' => 3)) ?></option>
<option value="4"><?php echo ___('date.months_nb', 4, array(':nb' => 4)) ?></option>
<option value="5"><?php echo ___('date.months_nb', 5, array(':nb' => 5)) ?></option>
<option value="6"><?php echo ___('date.months_nb', 6, array(':nb' => 6)) ?></option>
<option value="12"><?php echo ___('date.months_nb', 12, array(':nb' => 12)) ?></option>
<?php endif; ?>
