<?php
/**
 * @file
 * Theme implementation to display calendar block.
 *
 * Variables:
 * - $daynames: The array of day names
 *              By default starts from monday: $daynames[0] => 'Mon'
 * - $content: Rendered weeks.
 * - $month_name: Selected month name
 * - $month_prev: Previous month time (Unix)
 * - $month_next: Next month time (Unix)
 */
?>

<div class="block-calendar">
  <div class="calendar-container">
    <div class="calendar-daynames">
      <div class="pretty-calendar-day"><div class="calendar-value"><?php print $daynames[0]; ?></div></div>
      <div class="pretty-calendar-day"><div class="calendar-value"><?php print $daynames[1]; ?></div></div>
      <div class="pretty-calendar-day"><div class="calendar-value"><?php print $daynames[2]; ?></div></div>
      <div class="pretty-calendar-day"><div class="calendar-value"><?php print $daynames[3]; ?></div></div>
      <div class="pretty-calendar-day"><div class="calendar-value"><?php print $daynames[4]; ?></div></div>
      <div class="pretty-calendar-weekend"><div class="calendar-value"><?php print $daynames[5]; ?></div></div>
      <div class="pretty-calendar-weekend pretty-calendar-last"><div class="calendar-value"><?php print $daynames[6]; ?></div></div>
    </div>
    <?php print $content; ?>
    <div class="pretty-calendar-month">
      <a href="javascript:calendar_go('prev');" rel="<?php print $month_prev; ?>">
        <div class="calendar-prev">&nbsp;</div>
      </a>
      <div class="month-title"><?php print $month_name; ?></div>
      <a href="javascript:calendar_go('next');" rel="<?php print $month_next; ?>">
        <div class="calendar-next">&nbsp;</div>
      </a>
    </div>
  </div>
</div>
