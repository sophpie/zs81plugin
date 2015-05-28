<?php
namespace ZRayRouter;

class EventManagerListener
{
    protected $currentTriggerredEvent;
    
    protected $eventStorage=array();
    
    public function onPostTriggerListener($context,&$storage)
    {
        $eventName = $context['functionArgs'][0];
        $this->currentTriggerredEvent = $eventName;
        $this->eventStorage[$eventName] = array();
    }
    
    public function onGetCallback($context,&$storage)
    {
       $listener = $context['returnValue'];
       $listenerName = 'undefined';
       $listenerName = self::getListenerName($listener);
       $this->eventStorage[$this->currentTriggerredEvent][] = array('name' => $listenerName);
    }
    
    protected static function getListenerName($listener = null)
    {
        if (!$listener) return 'null';
        if (is_array($listener)) {
            return get_class($listener[0]) . '::' . $listener[1];
        }
        if ($listener instanceof \Closure) return 'Closure';
        if (is_object($listener)) return get_class($listener) . '::__invoke()';
    }
    
    public function onShutdown($context,&$storage)
    {
        $storage['Listeners'] = $this->eventStorage;
    }
}