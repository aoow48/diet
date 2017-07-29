<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('ログイン'), ['action' => 'login']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('新規登録') ?></legend>
        <?php
        echo $this->Form->control('userid', ["label" => "ユーザーID"]);
        echo $this->Form->control('password', ["label" => "パスワード"]);
        echo $this->Form->control("passwordcheck" ,["type" => "password", "label" => "パスワード確認"]);
        echo $this->Form->control('height', ["label" => "身長"]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('登録')) ?>
    <?= $this->Form->end() ?>
</div>
