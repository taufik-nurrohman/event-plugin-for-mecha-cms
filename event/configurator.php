<label class="grid-group">
  <span class="grid span-1 form-label"><?php echo $speak->title; ?></span>
  <span class="grid span-5">
  <?php echo Form::text('event[title]', $config->event->title, null); ?>
  </span>
</label>
<label class="grid-group">
  <span class="grid span-1 form-label"><?php echo $speak->slug; ?></span>
  <span class="grid span-5">
  <?php echo Form::text('event[slug]', $config->event->slug); ?>
  </span>
</label>
<label class="grid-group">
  <span class="grid span-1 form-label"><?php echo $speak->manager->title_per_page; ?></span>
  <span class="grid span-5">
  <?php echo Form::number('event[per_page]', $config->event->per_page, null, array(
      'min' => 1
  )); ?>
  </span>
</label>