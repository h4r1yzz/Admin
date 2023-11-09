<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Create a contest</h1>

    <div>
        <?php if($errors->any()): ?>
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <?php endif; ?>
    </div>
    <form method="post" action="<?php echo e(route('contests.store')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('post'); ?>
        <div>
            <label> Title </label>
            <input type="text" name="title" placeholder="title"/>
        </div>
        <div>
            <label> title_locale </label>
            <input type="text" name="title_locale" placeholder="title_locale"/>
        </div>
        <div>
            <label> contest start </label>
            <input type="date" name="title_locale" placeholder="title_locale"/>
        </div>
        <div>
            <label> contest end </label>
            <input type="date" name="title_locale" placeholder="title_locale"/>
        </div>
        <div>
            <label> contest display start </label>
            <input type="date" name="title_locale" placeholder="title_locale"/>
        </div>
        <div>
            <label> contest display end </label>
            <input type="date" name="title_locale" placeholder="title_locale"/>
        </div>
        
        <div>
            <label> Submit </label>
            <input type="submit" value="Save a new contest"/>
        </div>
    </form>
</body>
</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/book/resources/views/contests/create.blade.php ENDPATH**/ ?>