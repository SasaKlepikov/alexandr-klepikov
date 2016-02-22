<?php
/**
 * @file
 * Theme implementation to display day cell.
 *
 * Variables:
 * - $number: Day number from beginning of month
 * - $date: Day number from beginning of month
 * - $delta: Day number from beginning of week
 * - $class: Default cell class
 * - $count: Node counter
 * - $using_tooltip: Using tooltips (boolean)
 * - $is_empty: Blank cell (boolean)
 *
 * Note:
 *   We can use l() function to generate a link, but in that case,
 *   the resulting code is very difficult to read.
 */
?>

<?php if ($count > 0) : ?>
<a class="tooltip" title="<?php
  print pretty_calendar_plural($count);
?>" href="<?php
  global $base_path;
  print variable_get('clean_url') ? '' : '/q?=';
  print $base_path;
?>calendar/<?php
  print $date;
?>"<?php 
  print ($using_tooltip ? ' rel="' . $date . '"' : '');
?>>
<?php endif; ?>
  <div class="<?php print $class . ($is_empty ? ' blank' : ''); ?>">
    <div class="calendar-value"><?php print $number; ?></div>
  </div>
<?php if ($count > 0) : ?>
</a>
<?php endif; ?>
