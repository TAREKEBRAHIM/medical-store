<!DOCTYPE html>
<html lang="en">

<head>

    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?= $this->fetch('title') ?: 'Medifit Store' ?>
    </title>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <?= $this->Html->css('common/fonts') ?>
    <?= $this->Html->css('common/style') ?>
    <?= $this->Html->css('common/footer') ?>
    <?= $this->Html->css('common/header') ?>

</head>

<body>

    <?php
    $isLoginPage = $this->request->getParam('controller') === 'Users'
        && $this->request->getParam('action') === 'login';
    ?>

    <?php if (!$isLoginPage): ?>
        <?= $this->element('header') ?>
    <?php endif; ?>
    <main>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</main>
    <?php if (!$isLoginPage): ?>
        <?= $this->element('footer') ?>
    <?php endif; ?>

</body>

</html>