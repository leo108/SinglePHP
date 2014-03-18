<?php
/**
 * 获取和设置配置参数 支持批量定义
 * 如果$key是关联型数组，则会按K-V的形式写入配置
 * 如果$key是数字索引数组，则返回对应的配置数组
 * @param string|array $name 配置变量
 * @param mixed $value 配置值
 * @return mixed
 */
function C($key,$value=null){
    static $_config = array();
    $args = func_num_args();
    if($args == 1){
        if(is_string($key)){  //如果传入的key是字符串
            return isset($_config[$key])?$_config[$key]:null;
        }
        if(is_array($key)){
            if(array_keys($key) !== range(0, count($key) - 1)){  //如果传入的key是关联数组
                $_config = array_merge($_config, $key);
            }else{
                $ret = array();
                foreach ($key as $k) {
                    $ret[$k] = isset($_config[$k])?$_config[$k]:null;
                }
                return $ret;
            }
        }
    }else{
        if(is_string($key)){
            $_config[$key] = $value;
        }else{
            halt('传入参数不正确');
        }
    }
    return null;
}

/**
 * 调用Widget
 * @param string $name widget名
 * @param array $data 传递给widget的变量列表，key为变量名，value为变量值
 * @return void
 */
function W($name, $data = array()){
    $fullName = $name.'Widget';
    if(!class_exists($fullName)){
        halt('Widget '.$name.'不存在');
    }
    $widget = new $fullName();
    $widget->invoke($data);
}

/**
 * 终止程序运行
 * @param string $str 终止原因
 * @return void
 */
function halt($str){
    Log::fatal($str.' debug_backtrace:'.var_export(debug_backtrace(), true));
    header("Content-Type:text/html; charset=utf-8");
    echo "<pre>";
    debug_print_backtrace();
    echo "</pre>";
    echo $str;
    exit;
}

/**
 * 根据配置生成action的url地址
 * @param string $controller 控制器
 * @param string $action 行为
 * @return string
 */
function url($controller='Index', $action='Index'){
    $pathMod = C('PATH_MOD');
    if(strcmp(strtoupper($pathMod),'NORMAL') === 0){
        $url = "c={$controller}&a={$action}";
    }else{
        $url = "{$controller}/{$action}";
    }
    return $url;
}

/**
 * 获取数据库实例
 * @return DB_Instance
 */
function M(){
    $dbConf = C(array('DB_HOST','DB_PORT','DB_USER','DB_PWD','DB_NAME','DB_CHARSET'));
    return DB::getInstance($dbConf);
}

/**
 * 如果文件存在就include进来
 * @param string $path 文件路径
 * @return void
 */
function includeIfExist($path){
    if(file_exists($path)){
        include $path;
    }
}

class SinglePHP {
    private $c;
    private $a;
    private static $_instance;
    private function __construct($conf){
        C($conf);
    }
    private function __clone(){}
    public static function getInstance($conf){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self($conf);
        }
        return self::$_instance;
    }
    /**
     * 运行应用实例
     * @access public
     * @return void
     */
    public function run(){
        if(C('USE_SESSION') == true){
            session_start();
        }
        C('APP_FULL_PATH', getcwd().'/'.C('APP_PATH').'/');
        includeIfExist( C('APP_FULL_PATH').'/common.php');
        $pathMod = C('PATH_MOD');
        $pathMod = empty($pathMod)?'NORMAL':$pathMod;
        spl_autoload_register(array('SinglePHP', 'autoload'));
        if(strcmp(strtoupper($pathMod),'NORMAL') === 0 || !isset($_SERVER['PATH_INFO'])){
            $this->c = isset($_GET['c'])?$_GET['c']:'Index';
            $this->a = isset($_GET['a'])?$_GET['a']:'Index';
        }else{
            $pathInfo = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'';
            $pathInfoArr = explode('/',trim($pathInfo,'/'));
            if(isset($pathInfoArr[0]) && $pathInfoArr[0] !== ''){
                $this->c = $pathInfoArr[0];
            }else{
                $this->c = 'Index';
            }
            if(isset($pathInfoArr[1])){
                $this->a = $pathInfoArr[1];
            }else{
                $this->a = 'Index';
            }
        }
        if(!class_exists($this->c.'Controller')){
            halt('控制器'.$this->c.'不存在');
        }
        $controllerClass = $this->c.'Controller';
        $controller = new $controllerClass();
        if(!method_exists($controller, $this->a.'Action')){
            halt('方法'.$this->a.'不存在');
        }
        call_user_func(array($controller,$this->a.'Action'));
    }
    public static function autoload($class){
        if(substr($class,-10)=='Controller'){
            includeIfExist(C('APP_FULL_PATH').'/Controller/'.$class.'.class.php');
        }elseif(substr($class,-6)=='Widget'){
            includeIfExist(C('APP_FULL_PATH').'/Widget/'.$class.'.class.php');
        }else{
            includeIfExist(C('APP_FULL_PATH').'/Lib/'.$class.'.class.php');
        }
    }
}

class Controller {
    private $_view;
    public function __construct(){
        $this->_view = new View();
        $this->_init();
    }
    protected function _init(){}
    /**
     * 渲染模板并输出
     * @param null|string $tpl 模板文件路径
     * 参数为相对于App/View/文件的相对路径，不包含后缀名，例如index/index
     * 如果参数为空，则默认使用$controller/$action.php
     * 如果参数不包含"/"，则默认使用$controller/$tpl
     * @return void
     */
    protected function display($tpl=''){
        if($tpl === ''){
            $trace = debug_backtrace();
            $controller = substr($trace[1]['class'], 0, -10);
            $action = substr($trace[1]['function'], 0 , -6);
            $tpl = $controller . '/' . $action;
        }elseif(strpos($tpl, '/') === false){
            $trace = debug_backtrace();
            $controller = substr($trace[1]['class'], 0, -10);
            $tpl = $controller . '/' . $tpl;
        }
        $this->_view->display($tpl);
    }
    /**
     * 为视图引擎设置一个模板变量
     * @param string $name 要在模板中使用的变量名
     * @param mixed $value 模板中该变量名对应的值
     * @return void
     */
    protected function assign($name,$value){
        $this->_view->assign($name,$value);
    }
    /**
     * 将数据用json格式输出至浏览器，并停止执行代码
     * @param array $data 要输出的数据
     */
    protected function ajaxReturn($data){
        echo json_encode($data);
        exit;
    }
    /**
     * 重定向至指定url
     * @param string $url 要跳转的url
     * @param void
     */
    protected function redirect($url){
        header("Location: $url");
        exit;
    }
}
class View {
    private $_tplDir;
    private $_viewPath;
    private $_data = array();
    private static $tmpData;
    public function __construct($tplDir=''){
        if($tplDir == ''){
            $this->_tplDir = './'.C('APP_PATH').'/View/';
        }else{
            $this->_tplDir = $tplDir;
        }

    }
    /**
     * 为视图引擎设置一个模板变量
     * @param string $name 要在模板中使用的变量名
     * @param mixed $value 模板中该变量名对应的值
     * @return void
     */
    public function assign($key, $value) {
        $this->_data[$key] = $value;
    }
    /**
     * 渲染模板并输出
     * @param null|string $tpl 模板文件路径，相对于App/View/文件的相对路径，不包含后缀名，例如index/index
     * @return void
     */
    public function display($tplFile) {
        $this->_viewPath = $this->_tplDir . $tplFile . '.php';
        unset($tplFile);
        extract($this->_data);
        include $this->_viewPath;
    }
    /**
     * 用于在模板文件中包含其他模板
     * @param string $path 相对于View目录的路径
     * @return void
     */
    public static function tplInclude($path, $data=array()){
        self::$tmpData = array(
            'path' => C('APP_FULL_PATH') . '/View/' . $path . '.php',
            'data' => $data,
        );
        unset($path);
        unset($data);
        extract(self::$tmpData['data']);
        include self::$tmpData['path'];
    }
}

class Widget {
    protected $_view;
    protected $_widgetName;
    public function __construct(){
        $this->_widgetName = get_class($this);
        $dir = C('APP_FULL_PATH') . '/Widget/Tpl/';
        $this->_view = new View($dir);
    }

    public function invoke($data){}

    protected function display($tpl=''){
        if($tpl == ''){
            $tpl = $this->_widgetName;
        }
        $this->_view->display($tpl);
    }

    protected function assign($name,$value){
        $this->_view->assign($name,$value);
    }
}

/**
 * 数据库操作类
 * 使用方法：
 * DB::getInstance($conf)->query('select * from table');
 * 其中$conf是一个关联数组，需要包含以下key：
 * DB_HOST DB_USER DB_PWD DB_NAME
 * 可以用DB_PORT和DB_CHARSET来指定端口和编码，默认3306和utf8
 */
class DB {
    private $_db;
    private $_lastSql;
    private $_rows;
    private $_error;
    private static $_instance = array();
    private function __construct($dbConf){
        if(!isset($dbConf['DB_CHARSET'])){
            $dbConf['DB_CHARSET'] = 'utf8';
        }
        $this->_db = mysql_connect($dbConf['DB_HOST'].':'.$dbConf['DB_PORT'],$dbConf['DB_USER'],$dbConf['DB_PWD']);
        if($this->_db === false){
            halt(mysql_error());
        }
        $selectDb = mysql_select_db($dbConf['DB_NAME'],$this->_db);
        if($selectDb === false){
            halt(mysql_error());
        }
        mysql_set_charset($dbConf['DB_CHARSET']);
    }
    private function __clone(){}
    static public function getInstance($dbConf){
        if(!isset($dbConf['DB_PORT'])){
            $dbConf['DB_PORT'] = '3306';
        }
        $key = $dbConf['DB_HOST'].':'.$dbConf['DB_PORT'];
        if(!isset(self::$_instance[$key]) || !(self::$_instance[$key] instanceof self)){
            self::$_instance[$key] = new self($dbConf);
        }
        return self::$_instance[$key];
    }
    /**
     * 转义字符串
     * @param string $str 要转义的字符串
     * @return string 转义后的字符串
     */
    public function escape($str){
        return mysql_real_escape_string($str, $this->_db);
    }
    /**
     * 查询，用于select语句
     * @param string $sql 要查询的sql
     * @return bool|array 查询成功返回对应数组，失败返回false
     */
    public function query($sql){
        $this->_rows = 0;
        $this->_error = '';
        $this->_lastSql = $sql;
        $this->logSql();
        $res = mysql_query($sql,$this->_db);
        if($res === false){
            $this->_error = mysql_error($this->_db);
            $this->logError();
            return false;
        }else{
            $this->_rows = mysql_num_rows($res);
            $result = array();
            if($this->_rows >0) {
                while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
                    $result[]   =   $row;
                }
                mysql_data_seek($res,0);
            }
            return $result;
        }
    }
    /**
     * 查询，用于insert/update/delete语句
     * @param string $sql 要查询的sql
     * @return bool|int 查询成功返回影响的记录数量，失败返回false
     */
    public function execute($sql) {
        $this->_rows = 0;
        $this->_error = '';
        $this->_lastSql = $sql;
        $this->logSql();
        $result =   mysql_query($sql, $this->_db) ;
        if ( false === $result) {
            $this->_error = mysql_error($this->_db);
            $this->logError();
            return false;
        } else {
            $this->_rows = mysql_affected_rows($this->_db);
            return $this->_rows;
        }
    }
    /**
     * 获取上一次查询影响的记录数量
     * @return int 影响的记录数量
     */
    public function getRows(){
        return $this->_rows;
    }
    /**
     * 获取上一次insert后生成的自增id
     * @return int 自增ID
     */
    public function getInsertId() {
        return mysql_insert_id($this->_db);
    }
    /**
     * 获取上一次查询的sql
     * @return string sql
     */
    public function getLastSql(){
        return $this->_lastSql;
    }
    /**
     * 获取上一次查询的错误信息
     * @return string 错误信息
     */
    public function getError(){
        return $this->_error;
    }
    private function logSql(){
        Log::sql($this->_lastSql);
    }
    private function logError(){
        $str = '[SQL ERR]'.$this->_error.' SQL:'.$this->_lastSql;
        Log::warn($str);
    }
}

/**
 * 日志类
 * 使用方法：Log::fatal('error msg');
 * 保存路径为 App/Log，按天存放
 * fatal和warning会记录在.log.wf文件中
 */
class Log{
    /**
     * 打日志
     * @param string $msg 日志内容
     * @param string $level 日志等级
     * @param bool $wf 是否为错误日志
     */
    public static function write($msg, $level='DEBUG', $wf=false){
        $msg = date('[ Y-m-d H:i:s ]')."[{$level}]".$msg."\r\n";
        $logPath = C('APP_FULL_PATH').'/Log/'.date('Ymd').'.log';
        if($wf){
            $logPath .= '.wf';
        }
        file_put_contents($logPath, $msg, FILE_APPEND);
    }
    public static function fatal($msg){
        self::write($msg, 'FATAL', true);
    }
    public static function warn($msg){
        self::write($msg, 'WARN', true);
    }
    public static function notice($msg){
        self::write($msg, 'NOTICE');
    }
    public static function debug($msg){
        self::write($msg, 'DEBUG');
    }
    public static function sql($msg){
        self::write($msg, 'SQL');
    }
}
