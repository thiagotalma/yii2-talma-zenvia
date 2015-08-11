yii2-talma-zenvia
===========
Módulo para integração com API da Zenvia

[![Latest Stable Version](https://poser.pugx.org/thiagotalma/yii2-zenvia/v/stable)](https://packagist.org/packages/thiagotalma/yii2-zenvia) [![Total Downloads](https://poser.pugx.org/thiagotalma/yii2-zenvia/downloads)](https://packagist.org/packages/thiagotalma/yii2-zenvia) [![Monthly Downloads](https://poser.pugx.org/thiagotalma/yii2-zenvia/d/monthly)](https://packagist.org/packages/thiagotalma/yii2-zenvia) [![Daily Downloads](https://poser.pugx.org/thiagotalma/yii2-zenvia/d/daily)](https://packagist.org/packages/thiagotalma/yii2-zenvia) [![Latest Unstable Version](https://poser.pugx.org/thiagotalma/yii2-zenvia/v/unstable)](https://packagist.org/packages/thiagotalma/yii2-zenvia) [![License](https://poser.pugx.org/thiagotalma/yii2-zenvia/license)](https://packagist.org/packages/thiagotalma/yii2-zenvia)

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
