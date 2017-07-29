<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Dietdata[]|\Cake\Collection\CollectionInterface $dietdata
  */
?>
<style>
body{
	min-width: 700px !important;
     overflow: auto;
}
</style>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('メニュー') ?></li>
        <li><?= $this->Html->link(__('データ登録'), ['action' => 'add', $userid]) ?></li>
        <li><?= $this->Html->link(__("ユーザー情報変更"), ["controller" => "Users", "action" => "edit"]) ?></li>
        <li><?= $this->Html->link(__("ログアウト"), ["controller" => "Users", "action" => "logout"]) ?></li>
    </ul>
</nav>
<div class="dietdata index large-9 medium-8 columns content">
    <h3><?= __($userid.'の体重データ') ?></h3>
    <div id="graph1">
    	<canvas id="graph-area" height="450" width="700"></canvas>
		<script type="text/javascript">
			//グラフのY座標に使用する体重データ
			var pointY = JSON.parse('<?php echo $weight; ?>');
		</script>
		<?= $this->Html->script("graph") ?>
	</div>
	<div id="data1">
		<h2>現在のBMI : <?= round($bmi, 2) ?></h2>
		<h2>あなたの体重は</h2>
		<h1><span class="deco_1" id=<?= $colorid ?>><?= $result ?></span></h1>
		<h2>です。</h2>
	</div>
    <table>
        <thead>
            <tr>
                <th scope="col">登録番号</th>
                <th scope="col">体重(kg)</th>
                <th scope="col">計測日(月/日/年)</th>
                <th scope="col">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dietdata as $dietdata): ?>
            <tr>
                <td><?= $this->Number->format($dietdata->id) ?></td>
                <td><?= $this->Number->format($dietdata->weight) ?></td>
                <td><?= h($dietdata->date) ?></td>
                <td><?= $this->Html->link(__("編集"), ["action" => "edit", $dietdata->id])?>|
                <?= $this->Form->postLink(__("削除"),
                		["action" => "delete", $dietdata->id],
                		['confirm' => __('登録を削除してもよろしいですか？ # {0}?', $dietdata->id)]) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
