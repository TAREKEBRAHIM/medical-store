<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') ?: 'Medifit Store' ?></title>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <?= $this->Html->css('common/fonts') ?>
    <?= $this->Html->css('common/style') ?>
    <?= $this->Html->css('common/footer') ?>
    <?= $this->Html->css('common/header') ?>
</head>

<body>
    <?= $this->element('header') ?>
    <main>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>
    <?= $this->element('footer') ?>
</body>

</html>
