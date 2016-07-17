<label class="grid-group">
  <span class="grid span-1 form-label"><?php echo $speak->title; ?></span>
  <span class="grid span-5">
  <?php echo Form::text('title', $config->index_event->title, null); ?>
  </span>
</label>
<label class="grid-group">
  <span class="grid span-1 form-label"><?php echo $speak->slug; ?></span>
  <span class="grid span-5">
  <?php echo Form::text('slug', $config->index_event->slug); ?>
  </span>
</label>
<label class="grid-group">
  <span class="grid span-1 form-label"><?php echo $speak->manager->title_per_page; ?></span>
  <span class="grid span-5">
  <?php echo Form::number('per_page', $config->index_event->per_page, null, array(
      'min' => 1
  )); ?>
  </span>
</label>