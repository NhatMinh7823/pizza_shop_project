<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="Content-Security-Policy" content="
        default-src 'self'; 
        style-src 'self' https://stackpath.bootstrapcdn.com https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net 'unsafe-inline';
        font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com;
        script-src 'self' https://stackpath.bootstrapcdn.com https://cdn.jsdelivr.net;
        img-src 'self' data:;
        connect-src 'self';
        object-src 'none';
        frame-ancestors 'none';
    ">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/style.css?v=2.0">
    <link href="/css/style.css" rel="stylesheet">
</head>

<body>

    <?php $this->insert('shared/navbar'); ?>

    <main role="main" class="container">
        <?= $this->section('content') ?>
    </main>

    <?php $this->insert('shared/footer'); ?>

</body>

</html>