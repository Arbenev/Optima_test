<?php
/* @var $this UserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Users',
);

$this->menu = [
    ['label' => 'Create User', 'url' => ['create']],
    ['label' => 'Manage User', 'url' => ['admin']],
];
?>

<h1>Users</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', [
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'email',
        'login',
        [
            'header' => 'Управление',
            'class' => 'CButtonColumn',
            'template' => '{view} {update} {delete}',
        ],
        [
            'header' => 'Сообщение',
            'class' => 'CButtonColumn',
            'template' => '{customButton}',
            'buttons' => [
                'customButton' => [
                    'label' => 'Send',
                    'url' => 'Yii::app()->createUrl("user/send", ["id"=>$data->id])',
                    'imageUrl' => '/images/gmail.png',
                    'click' => 'function(){
                        $.ajax({
                            type: "POST",
                            url: $(this).attr("href"),
                            success: function(data) {
                                alert(\'OK\');
                            },
                            error:function(data) {
                                alert(data.responseJSON.result);
                            },
                            dataType: \'json\'
                        });
                        return false;
                    }',
                ],
            ],
        ],
    ],
]);
