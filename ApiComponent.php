<?php

namespace talma\zenvia;

use yii\base\Component;
use Yii;
use yii\helpers\VarDumper;

include_once 'clientApi/HumanClientMain.php';

/**
 * ZenviaComponent é usado para executar a API
 *
 * @property \HumanSimpleSend       $humanSimpleSend Objeto para enviar uma mensagem.
 * @property \HumanMultipleSend     $humanMultipleSend Objeto para enviar várias mensagens.
 * @property \HumanQueryMessage     $humanQueryMessage Objeto para consultar mensagens.
 *
 * @author Thiago Talma <http://www.thiagomt.com>
 * @since 0.1
 */
class ApiComponent extends Component
{
    /**
     * @var ZenviaModule
     */
    private $_module;

    /**
     * @var \HumanSimpleSend
     */
    private $_humanSimpleSend;

    /**
     * @var \HumanMultipleSend
     */
    private $_humanMultipleSend;

    /**
     * @var \HumanQueryMessage
     */
    private $_humanQueryMessage;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_module = Yii::$app->getModule('zenvia');
    }

    /**
     * @param string $body Texto da mensagem
     * @param string $to Destinatário da mensagem
     * @param string $msgId ID da mensagem
     * @param string $from Remetente da mensagem
     * @param string $schedule Agendamento da mensagem
     * @param string $callbackOption Callback da mensagem
     *
     * @return \HumanResponse
     */
    public function send($body, $to, $msgId = null, $from = null, $schedule = null, $callbackOption = null)
    {
        $message = new \HumanSimpleMessage();
        $message->setBody($body);
        $message->setTo($to);
        $message->setFrom(($from ? : $this->_module->from));
        $message->setMsgId($msgId);
        $message->setSchedule($schedule);

        if ($this->_module->simulate === true) {
            $response = new \HumanResponse();
            $response->setCode('000');
            $response->setMessage('Simulado');
            Yii::trace(VarDumper::dumpAsString($message));
        } else {
            $response = $this->humanSimpleSend->sendMessage($message, ($callbackOption ?: $this->_module->callBack));
        }

        return $response;
    }

    /**
     * @param $arquivo
     *
     * @param null|int $callbackOption
     *
     * @return \HumanResponse
     */
    public function sendMultipleFileCSV($arquivo, $callbackOption = null)
    {
        $response = $this->humanMultipleSend->sendMultipleFileCSV(\HumanMultipleSend::TYPE_C, $arquivo, ($callbackOption ?: $this->_module->callBack));

        return $response;
    }

    /**
     * @param array $msg_list
     *
     * @param null|int $callbackOption
     *
     * @return \HumanResponse[]
     */
    public function sendMultipleList(array $msg_list, $callbackOption = null)
    {
        $msg_list = implode("\n", $msg_list);
        $response = $this->humanMultipleSend->sendMultipleList(\HumanMultipleSend::TYPE_C, $msg_list, ($callbackOption ?: $this->_module->callBack));

        return $response;
    }

    public function queryMultipleStatus($msg_list = [])
    {
        $response = $this->humanMultipleSend->queryMultipleStatus($msg_list);

        return $response;
    }

    public function listReceivedSMS()
    {
        $messages = $this->humanQueryMessage->listReceivedSMS();

        return $messages;
    }

    public function __get($name)
    {
        $property = '_' . $name;
        if (property_exists($this, $property) && $this->$property === null) {
            $className = '\\' . ucfirst($name);
            $this->$property = new $className($this->_module->account, $this->_module->password);

            return $this->$property;
        }

        return parent::__get($name);
    }
}
