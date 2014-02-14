<?php
class EAjaxUpload extends CWidget
{
    public $id         = 'file_uploader';
    public $postParams = array();
    public $config     = array();
    public $css        = null;

    public function run()
    {
        if (empty($this->config['action'])) {
            throw new CException('EAjaxUpload: параметр "action" не может быть пустым.');
        }

        echo '<div id="' . $this->id . '"><noscript><p>Включите JavaScript, чтобы использовать загрузчик.</p></noscript></div>';
        $assets  = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);

        Yii::app()->clientScript->registerScriptFile($baseUrl . '/fileuploader.js', CClientScript::POS_HEAD);

        $this->css = (!empty($this->css)) ? $this->css : $baseUrl . '/fileuploader.css';
        Yii::app()->clientScript->registerCssFile($this->css);

        $postParams = array(
            'PHPSESSID'      => session_id() ,
            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
        );
        if (isset($this->postParams)) {
            $postParams = array_merge($postParams, $this->postParams);
        }

        $config           = array(
            'element'      => 'js:document.getElementById("' . $this->id . '")',
            'debug'        => false,
            'multiple'     => false,
            'template'     => '<div class="qq-uploader">
                <div class="qq-upload-drop-area"><span>Перетащите сюда файлы для загрузки</span></div>
                <div class="qq-upload-button btn">Загрузить файлы</div>
                <ul class="qq-upload-list"></ul></div>',
            'fileTemplate' => '<li>
                <span class="qq-upload-file"></span>
                <span class="qq-upload-spinner"></span>
                <span class="qq-upload-size"></span>
                <a class="qq-upload-cancel" href="#">Отмена</a>
                <span class="qq-upload-failed-text">Ошибка</span>
                </li>',
            'messages'     => array(
                'typeError'    => '{file} имеет не верное расширение. Разрешены файлы с расширениями {extensions}.',
                'sizeError'    => '{file} слишком большой, максимальный размер файла {sizeLimit}.',
                'minSizeError' => '{file} слишком мал, минимальный размер файла {minSizeLimit}.',
                'emptyError'   => '{file} пуст, пожалуйста выберите файлы заново.',
                'onLeave'      => 'Файлы загружаются, если Вы покините страницу, загрузка будет остановлена.'
            ),
            //'onComplete' => "js:function(id, fileName, responseJSON){ alert(fileName); }",
            'showMessage'  => 'js:function(message){ alert(message); }',
        );
        $config           = array_merge($config, $this->config);
        $config['params'] = $postParams;
        $config           = CJavaScript::encode($config);
        Yii::app()->getClientScript()->registerScript('FileUploader_' . $this->id, 'var FileUploader_' . $this->id . " = new qq.FileUploader($config); ", CClientScript::POS_LOAD);
    }
}
