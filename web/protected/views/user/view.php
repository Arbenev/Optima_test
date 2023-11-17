<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = [
    'Users' => ['index'],
    $model->id,
];

$this->menu = [
    ['label' => 'List User', 'url' => ['index']],
    ['label' => 'Create User', 'url' => ['create']],
    ['label' => 'Update User', 'url' => ['update', 'id' => $model->id]],
    ['label' => 'Delete User', 'url' => '#', 'linkOptions' => ['submit' => ['delete', 'id' => $model->id], 'confirm' => 'Are you sure you want to delete this item?']],
    ['label' => 'Manage User', 'url' => ['admin']],
];
?>

<h1>View User #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', [
    'data' => $model,
    'attributes' => [
        'id',
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'email',
        'login',
    ],
]);

