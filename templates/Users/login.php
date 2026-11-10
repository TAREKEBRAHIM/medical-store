<?php
$this->assign('title', 'Login - Medical Store');
$this->Html->css('login', ['block' => true]);
?>

<div class="login-page">

    <div class="login-card">

        <div class="login-logo">
            <div class="logo-icon">
                <i class="bi bi-heart-pulse-fill"></i>
            </div>
            <h2>Medical<span>Store</span></h2>
            <p>Your Health, Our Priority</p>
        </div>

        <div class="login-heading">
            <h3>Welcome Back!</h3>
            <p>Please login to your account</p>
        </div>

        <?= $this->Flash->render() ?>

        <?= $this->Form->create(null, ['class' => 'login-form']) ?>

        <div class="login-field">
            <?= $this->Form->control('email', [
                'type' => 'email',
                'class' => 'form-control',
                'label' => 'Email Address',
                'placeholder' => 'Enter your email',
                'required' => true
            ]) ?>
        </div>

        <div class="login-field">
            <?= $this->Form->control('password', [
                'type' => 'password',
                'class' => 'form-control',
                'label' => 'Password',
                'placeholder' => 'Enter your password',
                'required' => true
            ]) ?>
        </div>

        <?= $this->Form->button('Sign In', [
            'class' => 'login-btn'
        ]) ?>

        <?= $this->Form->end() ?>

        <div class="login-footer">
            <p>© <?= date('Y') ?> Medical Store. All rights reserved.</p>
        </div>

    </div>

</div>
