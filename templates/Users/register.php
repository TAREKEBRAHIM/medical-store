<?= $this->Html->css('common/auth') ?>

<section class="auth-page">
    <div class="auth-container">

        <div class="auth-header">
            <p class="auth-eyebrow">JOIN MEDIFIT</p>
            <h1>Create Account</h1>
            <p>Create your customer account to start shopping.</p>
        </div>

        <?= $this->Form->create($user) ?>

        <div class="form-group">
            <?= $this->Form->control('name', [
                'label' => 'Full Name',
                'placeholder' => 'Enter your full name',
                'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->control('email', [
                'label' => 'Email Address',
                'type' => 'email',
                'placeholder' => 'Enter your email',
                'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->control('password', [
                'label' => 'Password',
                'placeholder' => 'Create a password',
                'required' => true
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->control('confirm_password', [
                'label' => 'Confirm Password',
                'type' => 'password',
                'placeholder' => 'Confirm your password',
                'required' => true
            ]) ?>
        </div>

        <button type="submit" class="auth-submit">
            Create Account
        </button>

        <?= $this->Form->end() ?>

        <p class="auth-footer">
            Already have an account?
            <a href="/login">Login</a>
        </p>

    </div>
</section>
