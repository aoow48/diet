<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('メニュー') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $dietdata->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $dietdata->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('データリスト'), ['action' => 'index']) ?></li>
         <li><?= $this->Html->link(__('ログアウト'), ["controller" => "Users", 'action' => 'logout']) ?></li>
    </ul>
</nav>
<div class="dietdata form large-9 medium-8 columns content">
    <?= $this->Form->create($dietdata) ?>
    <fieldset>
        <legend><?= __('データの編集') ?></legend>
        <?php
        echo $this->Form->control('weight' ,["label" => "体重(kg)"]);
        echo $this->Form->control('fat' ,["label" => "体脂肪(%)"]);
        echo $this->Form->control('date' ,["label" => "計測日(年/月/日)"]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('編集完了')) ?>
    <?= $this->Form->end() ?>
</div>
