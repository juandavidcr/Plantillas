//JALAMOS EL API DE JOOMLA
if (!defined('_JEXEC'))
    define('_JEXEC', 1);
//DEFINIMOS EL SEPARADOR
$DS = DIRECTORY_SEPARATOR;
define('DS', $DS);
//TOMAMOS LA DORECCION DEL COMPONENETE
preg_match("/\\{$DS}components\\{$DS}com_.*?\\{$DS}/", __FILE__, $matches, PREG_OFFSET_CAPTURE);
$component_path = substr(__FILE__, 0, strlen($matches[0][0]) + $matches[0][1]);
define('JPATH_COMPONENT', $component_path);
//TOMMAOS LA IDRECCION DE LA INSTALACION DE JOOMLA
define('JPATH_BASE', substr(__FILE__, 0, strpos(__FILE__, DS . 'components' . DS)));
//JALAMOS LA S LIBRERIAS Y EL FRAMEWORK
require_once ( JPATH_BASE . DS . 'includes' . DS . 'defines.php' );
require_once JPATH_BASE . DS . 'includes' . DS . 'framework.php';
jimport('joomla.environment.request');
$mainframe = & JFactory::getApplication('site');
$mainframe->initialise();
$user = & JFactory::getUser();
$db = & JFactory::getDBO();