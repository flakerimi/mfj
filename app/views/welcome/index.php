<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    
    <h1>Welcome to Our Application</h1>
    <!-- Render data here -->

    Welcome, <?php foreach ($data as $key => $value): ?>
    <?php echo $value; ?>
    <?php endforeach; ?>

</body>
</html>