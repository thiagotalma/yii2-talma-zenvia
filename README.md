yii2-talma-zenvia
===========
Módulo para integração com API da Zenvia

Instalação
------------

A melhor forma para instação é utilizando o [composer](http://getcomposer.org/download/).

Então execute:

```
php composer.phar require --prefer-dist thiagotalma/yii2-zenvia "*"
```

ou acrescente

```
"thiagotalma/yii2-zenvia": "*"
```

no seu arquivo `composer.json`.

Configuração
-----

No seu arquivo de configuração, acrescente o módulo:

```php
<?php
return [
    'modules' => [
        'zenvia' => [
            'class' => 'talma\zenvia\Module',
            'account' => 'suaconta',
            'password' => 'suasenha',
        ],
    ],
];
?>
```

Uso
-----

Após a instalação, use esse código:

```php
<?php
use talma\zenvia\ZenviaModule;

$zenvia = ZenviaModule::getInstance();
if (!$zenvia) {
    $zenvia = Yii::$app->getModule('zenvia');
}

$responses = $zenvia->api->send('Texto da Mensagem', '5511988885555');
?>;
```