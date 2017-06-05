<form action="<?php print_r(HOST.$config['struct']['action']); ?>"
      method="<?php print_r($config['struct']['method']); ?>">
    <?php foreach ($config['data'] as $name => $attributs): ?>

        <?php if($attributs['rules']['type'] == 'repeated'): ?>
            <label>
                <?php echo $attributs['label'] ?>
                <input type="<?php echo $attributs['type'] ?>"
                       name="<?php echo $name.'_first' ?>"
                       value="<?php echo $attributs['value'] ?>"
                       placeholder="<?php echo $attributs['placeholder'] ?>"
                    <?php echo (isset($attributs["required"]))?"required":""; ?>>
                <input type="<?php echo $attributs['type'] ?>"
                       name="<?php echo $name.'_second' ?>"
                       value="<?php echo $attributs['value'] ?>"
                       placeholder="<?php echo $attributs['rules']['second_placeholder'] ?>"
                    <?php echo (isset($attributs["required"]))?"required":""; ?>>
            </label>
        <?php endif; ?>
        <?php if($attributs['type'] == 'text' or $attributs['type'] == 'email' or $attributs['type'] == 'date' or ($attributs['type'] == 'password') && $attributs['rules']['type'] != 'repeated'): ?>
            <input type="<?php echo $attributs['type'] ?>"
                   name="<?php echo $name ?>"
                   placeholder="<?php echo $attributs['placeholder'] ?>"
                   <?php echo (isset($attributs["required"]))?"required":""; ?>>
        <?php endif; ?>
        <?php if($attributs['type'] == 'checkbox'): ?>
            <label>
                <input type="<?php echo $attributs['type'] ?>"
                       name="<?php echo $name ?>"
                       value="<?php echo $attributs['value'] ?>"
                        <?php echo (isset($attributs["required"]))?"required":""; ?>>
                <?php echo $attributs['label'] ?>
            </label>
        <?php endif; ?>
    <?php endforeach; ?>
    <button type="submit"><?php print_r($config['struct']['submit']); ?></button>
</form>