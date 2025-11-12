<?php
$title = $title ?? config('app.name');
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/app.css'); ?>">
</head>
<body>
<header>
    <div class="container">
        <h1><?= htmlspecialchars(config('app.name')) ?></h1>
        <p>پلتفرم جامع مدیریت حقوق و دستمزد، حضور و غیاب و منابع انسانی با پشتیبانی کامل از استانداردهای ایران.</p>
    </div>
</header>
<main class="container">
    <?php if (! empty($breadcrumbs)): ?>
        <nav class="breadcrumbs" aria-label="breadcrumbs">
            <?php foreach ($breadcrumbs as $crumb): ?>
                <span><?= htmlspecialchars($crumb) ?></span>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>
    <?= $slot ?? '' ?>
</main>
</body>
</html>
