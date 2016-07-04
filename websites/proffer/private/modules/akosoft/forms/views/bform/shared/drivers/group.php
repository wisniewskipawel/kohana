<?php if ($driver->data('is_array') === TRUE): ?>
    <div class="col50">
        <?php $i = 1; ?>
        <?php foreach ($driver->data('elements') as $d): ?>
            <?php if ($i % 2 == 1): ?>
                <p>
                    <?php echo $d->render() ?>
                </p>
            <?php endif ?>
            <?php $i++ ?>
        <?php endforeach ?>
    </div>
    <div class="col50">
        <?php $i = 1; ?>
        <?php foreach ($driver->data('elements') as $d): ?>
            <?php if ($i % 2 == 0): ?>
                <p>
                    <?php echo $d->render() ?>
                </p>
            <?php endif ?>
            <?php $i++ ?>
        <?php endforeach ?>
    </div>
    <div class="clear"></div>
<?php elseif ($driver->data('is_array') === FALSE): ?>
    <div class="col50">
        <?php $i = 1; ?>
        <?php foreach ($driver->data('elements') as $d): ?>
            <?php if ($i % 2 == 1): ?>
                <p>
                    <?php echo $d->render() ?>
                </p>
            <?php endif ?>
            <?php $i++ ?>
        <?php endforeach ?>
    </div>
    <div class="col50">
        <?php $i = 1; ?>
        <?php foreach ($driver->data('elements') as $d): ?>
            <?php if ($i % 2 == 0): ?>
                <p>
                    <?php echo $d->render() ?>
                </p>
            <?php endif ?>
            <?php $i++ ?>
        <?php endforeach ?>
    </div>
    <div class="clear"></div>
<?php endif ?>
