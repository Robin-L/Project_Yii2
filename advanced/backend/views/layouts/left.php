<?php
$callback = function ($menu) {
    $data = json_decode($menu['data'], true);
    $items = $menu['children'];
    $return = [
        'label' => $menu['name'],
        'url' => [$menu['route']],
    ];
    if ($data) {
        if(isset($data['visible'])) {
            // $return['visible'] = $data['visible'];
        }
        if(isset($data['icon']) && $data['icon']) {
            $return['icon'] = $data['icon'];
        }
        $return['options'] = $data;
    }
    if(!isset($return['icon']) || !$return['icon']) {
        $return['icon'] = 'fa fa-circle-o';
    }
    if($items) {
        $return['items'] = $items;
    }
    return $return;
}
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username; ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <?=
            \dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => \mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback),
                ]
            )
        ?>

    </section>

</aside>
