<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Contest</h1>
    <div>
        <?php if(session()->has('success')): ?>
            <div>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
    </div>
    <div>
        <div>
            <a href="<?php echo e(route('contests.create')); ?>"> Create another contest </a>
        </div>
    <table class="table table-striped table-dark" border="10">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Title_locale</th>
      <th scope="col">Contest start</th>
      <th scope="col">Contest end</th>
      <th scope="col">Contest display start</th>
      <th scope="col">Contest display end</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <?php $__currentLoopData = $contests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <tbody>
    <tr>
      <td><?php echo e($contest->id); ?></td>
      <td><?php echo e($contest->title); ?></td>
      <td><?php echo e($contest->title_locale); ?></td>
      <td>
        <a href="<?php echo e(route('contests.edit',['contests'=>$contest])); ?>"> EDIT</a>
      </td>
      <td>
        <form method="post" action="<?php echo e(route('contests.delete',['contests' => $contest])); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('delete'); ?>
            <input type="submit" value="Delete"/>
        </form>
      </td>

    </tr>
  </tbody>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
    </div>
</body>
</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/book/resources/views/contests/index.blade.php ENDPATH**/ ?>