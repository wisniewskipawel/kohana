<?php if (count($categories)): ?>
<span class="input">
    <select name="category<?php if ($nb_select == '2' OR $nb_select == '3'): ?><?php echo $nb_select ?><?php endif ?>">
        <option value=""><?php echo ___('select.choose') ?></option>
        <?php foreach ($categories as $c): ?>
            <option value="<?php echo $c->category_id ?>"><?php echo $c->category_name ?></option>
        <?php endforeach; ?>
    </select>
</span>
<?php endif ?>