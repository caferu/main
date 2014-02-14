<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'name',
        'category_id',
        'price',
        'picture',
        'store',
        'pickup',
        'delivery',
        'vendor_id',
        'description',
        'url',
        'created_at',
        'updated_at',
        'status',
    ),
));
