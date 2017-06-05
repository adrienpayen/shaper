<div class="row">
    <div class="container">
        <div class="card medium">
            <h1 class="txt-center">Reset Password</h1>
            <div class="errors">
                <?php if($errors): ?>
                    <?php foreach ($errors as $error): ?>
                        <div><?php echo $error; ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="form full-width">
                <?php $this->includeModal("form", $form); ?>
            </div>
            <div class="link">
                <a href="<?php echo HOST.'admin/login'; ?>">Login</a>
            </div>
        </div>
    </div>
</div>