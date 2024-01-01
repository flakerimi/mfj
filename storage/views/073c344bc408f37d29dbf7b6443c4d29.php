<!DOCTYPE html>
<html>
<head>
    <title><?php echo e(config('application.name')); ?></title>
</head>
<body>
    <header>
        <!-- Your header content here -->
    </header>

    <nav>
        <!-- Your navigation menu here -->
    </nav>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer>
        <!-- Your footer content here -->
    </footer>
</body>
</html>
<?php /**PATH /Users/flakerimi/Projects/PHP/mfj/app/views/layout/default.blade.php ENDPATH**/ ?>