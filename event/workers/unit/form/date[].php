<div class="grid-group">
  <span class="grid span-1 form-label"><?php echo $speak->date; ?></span>
  <span class="grid span-5">
    <span class="grid-group">
      <?php

      $s = File::N($page->path);
      $s = explode('_', $s, 3);
      $date = explode('-', date('Y-m-d-H-i'));
      $date = array_replace($date, explode('-', $s[0]));
      $years = $months = array();
      for($i = -10; $i < 20; ++$i) {
          $years[$date[0] + $i] = $date[0] + $i;
      }
      $months_text = (array) $speak->month_names;
      for($i = 1; $i < 13; ++$i) {
          $months[$i < 10 ? '0' . $i : $i] = $months_text[$i - 1];
      }
      $days = array(
          '01' => '01',
          '02' => '02',
          '03' => '03',
          '04' => '04',
          '05' => '05',
          '06' => '06',
          '07' => '07',
          '08' => '08',
          '09' => '09',
          '10' => '10',
          '11' => '11',
          '12' => '12',
          '13' => '13',
          '14' => '14',
          '15' => '15',
          '16' => '16',
          '17' => '17',
          '18' => '18',
          '19' => '19',
          '20' => '20',
          '21' => '21',
          '22' => '22',
          '23' => '23',
          '24' => '24',
          '25' => '25',
          '26' => '26',
          '27' => '27',
          '28' => '28',
          '29' => '29',
          '30' => '30',
          '31' => '31'
      );

      ?>
      <span class="grid span-1"><?php echo Form::select('date[0]', $years, $date[0], array('class' => 'input-block')); ?></span>
      <span class="grid span-3"><?php echo Form::select('date[1]', $months, $date[1], array('class' => 'input-block')); ?></span>
      <span class="grid span-1"><?php echo Form::select('date[2]', $days, $date[2], array('class' => 'input-block')); ?></span>
      <span class="grid span-1"><?php echo Form::text('date[3-4]', $date[3] . ':' . $date[4], date('H:i'), array('class' => 'input-block', 'pattern' => '\d+:\d+')); ?></span>
    </span>
  </span>
</div>