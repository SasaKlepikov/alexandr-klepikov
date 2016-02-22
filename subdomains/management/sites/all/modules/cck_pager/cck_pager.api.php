<?php

/**
 * @file
 * API documentation for CCK Pager.
 */

/**
 * Implementation of hook_cck_pager_alter().
 *
 * Alter pager elements before they are rendered.
 * @param array $data
 *   Array of pager elements to render.
 * @param array $field
 *   The CCK field the pager is displayed for.
 * @param array $context
 *   Array of contextual elements to determin the context
 */
//&$pager_items, $field, $num_pages, $page, $pager_type, $query_param
function example_cck_pager_alter($data, $field, $context) {
  extract($data, EXTR_REFS);
  extract($context);
  // In case of mini pager, replace "‹" with  "Start" for the first delta.
  // Otherwise replace '‹' with '‹previous' and  '›' with "next ›"
  if($pager_type == 1) {
    foreach ($pager as $key => $item) {
      $link = $pager[$key]['data'];
      switch ($item['class'][0]) {
        case 'pager-previous':
          $pager[$key]['data'] = str_replace('‹', '‹ previous', $link);
          break;
        case 'pager-next':
          if ($page == 0) {
            $pager[$key]['data'] = str_replace('›', 'start', $link);
        break;
          }
          $pager[$key]['data'] = str_replace('›', 'next ›', $link);
        break;
    }
  }
}
}
