CKEDITOR.editorConfig = function(config) {
    // Язык интерфейса
    config.language = 'ru';

    // Цвет интерфейса (по желанию)
    config.uiColor = '#f5f5f5';

    // Убираем низовую строку статуса
    config.removePlugins = 'elementspath';

    // Отключаем изменение размера
    config.resize_enabled = false;

    // Высота поля
    config.height = 300;
    config.licenseKey = 'GPL';

    // Настройка панели инструментов
    config.toolbar = [
        { name: 'document', items: [ 'Source', '-', 'Preview' ] },
        { name: 'clipboard', items: [ 'Cut','Copy','Paste','Undo','Redo' ] },
        { name: 'editing', items: [ 'Find','Replace','SelectAll' ] },
        { name: 'basicstyles', items: [ 'Bold','Italic','Underline','Strike','RemoveFormat' ] },
        { name: 'paragraph', items: [ 'NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
        { name: 'links', items: [ 'Link','Unlink' ] },
        { name: 'insert', items: [ 'Image','Table','HorizontalRule','SpecialChar' ] },
        { name: 'styles', items: [ 'Format','Font','FontSize' ] },
        { name: 'colors', items: [ 'TextColor','BGColor' ] },
        { name: 'tools', items: [ 'Maximize' ] }
    ];
};
