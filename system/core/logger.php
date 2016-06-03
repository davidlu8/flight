<?php
/**
 * Logger �ռǳ�����
 *
 * - ��ϵͳ�ĸ���������м�¼������洢ý����ʵ���ඨ��
 * - ��־�����ͣ��������ȼ����������Ϳɰ������
 *
 * <br>�ӿ�ʵ��ʾ����<br>
```
 *      class Logger_Mock extends Logger {
 *          public function log($type, $msg, $data) {
 *              //nothing to do here ...
 *          }
 *      }
 *
 *      //����ȫ�����͵��ռ�
 *      $logger = new Logger_Mock(
 *          Logger::LOG_LEVEL_DEBUG | Logger::LOG_LEVEL_INFO | Logger::LOG_LEVEL_ERROR);
 *
 *      //��������ʹ�ã��Ҵ�������Ϣ
 *      $logger->debug('this is bebug test', array('name' => 'mock', 'ver' => '1.0.0'));
 *
 *      //ҵ�񳡾�ʹ��
 *      $logger->info('this is info test', 'and more detail here ...');
 *
 *      //һЩ���÷���������
 *      $logger->error('this is error test');
 */
abstract class log {

    /**
     * @var int $logLevel ����ռǼ���
     */
    protected $logLevel = 0;

    /**
     * @var int LOG_LEVEL_DEBUG ���Լ���
     */
    const LOG_LEVEL_DEBUG = 1;

    /**
     * @var int LOG_LEVEL_INFO ��Ʒ����
     */
    const LOG_LEVEL_INFO = 2;

    /**
     * @var int LOG_LEVEL_ERROR ���󼶱�
     */
    const LOG_LEVEL_ERROR = 4;


    public function __construct($level) {
        $this->logLevel = $level;
    }

    /**
     * �ռǼ�¼
     *
     * �ɸ��ݲ�ͬ��Ҫ�����ռ�д�벻ͬ��ý��
     *
     * @param string $type �ռ����ͣ��磺info/debug/error, etc
     * @param string $msg �ռǹؼ�����
     * @param string/array $data ������������Ϣ
     * @return NULL
     */
    abstract public function log($type, $msg, $data);

    /**
     * Ӧ�ò�Ʒ���ռ�
     * @param string $msg �ռǹؼ�����
     * @param string/array $data ������������Ϣ
     * @return NULL
     */
    public function info($msg, $data = NULL) {
        if (!$this->isAllowToLog(self::LOG_LEVEL_INFO)) {
            return;
        }

        $this->log('info', $msg, $data);
    }

    /**
     * �������Լ��ռ�
     * @param string $msg �ռǹؼ�����
     * @param string/array $data ������������Ϣ
     * @return NULL
     */
    public function debug($msg, $data = NULL) {
        if (!$this->isAllowToLog(self::LOG_LEVEL_DEBUG)) {
            return;
        }

        $this->log('debug', $msg, $data);
    }

    /**
     * ϵͳ�����ռ�
     * @param string $msg �ռǹؼ�����
     * @param string/array $data ������������Ϣ
     * @return NULL
     */
    public function error($msg, $data = NULL) {
        if (!$this->isAllowToLog(self::LOG_LEVEL_ERROR)) {
            return;
        }

        $this->log('error', $msg, $data);
    }

    /**
     * �Ƿ�����д���ռǣ�������
     * @param int $logLevel
     * @return boolean
     */
    protected function isAllowToLog($logLevel) {
        return (($this->logLevel & $logLevel) != 0) ? TRUE : FALSE;
    }

}// end class

/**
 * LoggerFile �ļ��ռǼ�¼��
 *
 * - ���ռ�д���ļ����ļ�Ŀ¼�����Զ���
 *
 * <br>ʹ��ʾ����<br>
```
 *      //Ŀ¼Ϊ./Runtime���ұ���ȫ�����͵��ռ�
 *      $logger = new LoggerFile('./Runtime',
 * 	        Logger::LOG_LEVEL_DEBUG | Logger::LOG_LEVEL_INFO | Logger::LOG_LEVEL_ERROR);
 *
 *      //�ռǻᱣ������./Runtime/debug_log/Ŀ¼��
 *      $logger->debug('this is bebug test');
```
 *
 */
class logger extends log {

    protected $logFolder;
    protected $dateFormat;

    protected $logFile;

    public function __construct($logFolder, $level, $dateFormat = 'Y-m-d H:i:s') {
        $this->logFolder = $logFolder;
        $this->dateFormat = $dateFormat;

        parent::__construct($level);

        $this->init();
    }

    protected function init() {
        if (!CFG_LOG_WRITE) return;

        $folder = $this->logFolder
            . DIRECTORY_SEPARATOR . 'log'
            . DIRECTORY_SEPARATOR . date('Ym', $_SERVER['REQUEST_TIME']);

        if (!file_exists($folder)) {
            mkdir($folder . '/', 0777, TRUE);
        }

        $this->logFile = $folder
            . DIRECTORY_SEPARATOR . date('Ymd', $_SERVER['REQUEST_TIME']) . '.log';

        if (!file_exists($this->logFile)) {
            touch($this->logFile);
            chmod($this->logFile, 0777);
        }
    }

    public function log($type, $msg, $data) {
        if (!CFG_LOG_WRITE) return;

        $msgArr = array();
        $msgArr[] = date($this->dateFormat, $_SERVER['REQUEST_TIME']);
        $msgArr[] = strtoupper($type);
        $msgArr[] = str_replace(PHP_EOL, '\n', $msg);
        if ($data !== NULL) {
            $msgArr[] = is_array($data) ? json_encode($data) : $data;
        }

        $content = implode('|', $msgArr) . PHP_EOL;

        file_put_contents($this->logFile, $content, FILE_APPEND);
    }

}