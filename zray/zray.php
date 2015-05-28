<?php
namespace ZRayListeners;

require_once 'EventManagerListener.php';
$emListener = new EventManagerListener();
$zrayExtension = new \ZRayExtension('zf2-listeners');
$zrayExtension->setEnabledAfter('Zend\Mvc\Application::init');
$zrayExtension->traceFunction('Zend\Stdlib\CallbackHandler::getCallback',function(){},array($emListener,'onGetCallBack'));
$zrayExtension->traceFunction('Zend\EventManager\EventManager::triggerListeners',function(){},array($emListener,'onPostTriggerListener'));
$zrayExtension->traceFunction('ZRayListeners\ZrayShutdown',array($emListener,'onShutdown'),function(){});
function ZrayShutdown(){}
register_shutdown_function('ZRayListeners\ZrayShutdown');


