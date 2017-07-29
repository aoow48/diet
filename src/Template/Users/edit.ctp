<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('メニュー') ?></li>
        <li><?= $this->Form->postLink(
                __('登録削除'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('登録を削除してもよろしいですか？ # {0}?', $user->userid)]
            )
        ?></li>
        <li><?= $this->Html->link(__('データリスト'), ["controller" => "Dietdata", 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('登録情報の変更') ?></legend>
        <?php
        echo $this->Form->control('password', ["label" => "パスワード"]);
        echo $this->Form->control('passwordcheck', ["type" => "password", "label" => "パスワード確認"]);
        echo $this->Form->control('height', [ "label" => "身長"]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('変更確定')) ?>
    <?= $this->Form->end() ?>
</div>
