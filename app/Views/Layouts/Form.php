<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>
    <link id="form-theme-style" rel="stylesheet" href="<?= base_url('CSS/BlackForm.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('Images/Logo.png') ?>">
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <?= $this->renderSection('content') ?>
    <script src="<?= base_url('Scripts/ThemeSwitcher.js') ?>"></script>
    <script src="<?= base_url('Scripts/Form.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>