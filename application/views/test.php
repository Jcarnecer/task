<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="<?= base_url('tasks/test'); ?>" method="post">
        <input type="text" name="text" value="1">
        <input type="hidden" name="tags[]" value="2">
        <input type="hidden" name="tags[]" value="3">
        <input type="hidden" name="tags[]" value="4">
        <input type="hidden" name="tags[]" value="5">
        <input type="submit" name="submit" value="Test">
    </form>
</body>
</html>