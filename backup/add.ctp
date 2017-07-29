<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('データリスト'), ['action' => 'index']) ?></li>
         <li><?= $this->Html->link(__('ログアウト'), ["controller" => "Users", 'action' => 'logout']) ?></li>
    </ul>
</nav>
<div class="dietdata form large-9 medium-8 columns content">
    <?= $this->Form->create($dietdata) ?>
    <fieldset>
        <legend><?= __('データ登録') ?></legend>
        <?php
            //echo $this->Form->control('userid' ,["label" => "ユーザーID", "value" => $userid]);
            echo $this->Form->control('weight' ,["label" => "体重(kg)"]);
            echo $this->Form->control('date' ,["label" => "計測日(年/月/日)"]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('登録')) ?>
    <?= $this->Form->end() ?>
</div>
