<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Edit a contest</h1>

    <div>
        <?php if($errors->any()): ?>
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <?php endif; ?>
    </div>
    <form method="post" action="<?php echo e(route('contests.update',['contests' => $contests ])); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>
        <div>
            <label> Title </label>
            <input type="text" name="title" placeholder="title" value="<?php echo e($contests-> title); ?>"/>
        </div>
        <div>
            <label> title_locale </label>
            <input type="text" name="title_locale" placeholder="title_locale" value="<?php echo e($contests->title_locale); ?>"/>
        </div>
        <div>
            <label> Submit </label>
            <input type="submit" value="Update" />
        </div>
    </form>
</body>
</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/book/resources/views/contests/edit.blade.php ENDPATH**/ ?>