<?php $__env->startSection('content'); ?>
    <h1>Welcome to Our HOME</h1>
    <!-- Render data here -->
    Welcome, <?php echo e($name); ?>!
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/flakerimi/Projects/PHP/mfj/app/views/home/index.blade.php ENDPATH**/ ?>