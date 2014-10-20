<?php

namespace talma\zenvia;

use yii\base\InvalidParamException;
use yii\base\Module as BaseModule;

/**
 * Módulo para Integração com Zenvia
 *
 * @property ApiComponent       $api
 *
 * @author Thiago Talma <http://www.thiagomt.com>
 */
class ZenviaModule extends BaseModule
{
    const VERSION = '0.0.1-dev';

    public $account;

    public $password;

    public $from = '_hide';

    public $callBack = 0; // HumanSimpleSend::CALLBACK_INACTIVE

    public $simulate = false;


    public function init()
    {
        parent::init();

        if ($this->account === null || $this->password === null) {
            throw new InvalidParamException('Não foram informados a conta e/ou a senha.');
        }
    }

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, $config = [])
    {
        foreach ($this->getModuleComponents() as $name => $component) {
            if (!isset($config['components'][$name])) {
                $config['components'][$name] = $component;
            } elseif (is_array($config['components'][$name]) && !isset($config['components'][$name]['class'])) {
                $config['components'][$name]['class'] = $component['class'];
            }
        }
        parent::__construct($id, $parent, $config);
    }

    /**
     * Returns module components.
     * @return array
     */
    protected function getModuleComponents()
    {
        return [
            'api' => [
                'class' => 'talma\zenvia\ApiComponent'
            ]
        ];
    }
}
