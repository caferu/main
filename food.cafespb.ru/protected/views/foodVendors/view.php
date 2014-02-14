<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'name',
        'identity',
        'delivery_price',
        'free_delivery_sum',
        'description',
        'logo',
        'created_at',
        'updated_at',
        'status',
    ),
));
