<?php

use Nacosvel\Utils\Emitter;
use PHPUnit\Framework\TestCase;

class EmitterTest extends TestCase
{
    protected Emitter $emitter;
    protected Emitter $emit;

    protected function setUp(): void
    {
        $this->emitter = new Emitter('emitter');
        $this->emit    = new Emitter();
    }

    protected function tearDown(): void
    {
        $this->emitter->clear();
        $this->emit->clear();
    }

    public function test_get_event_key()
    {
        $this->assertTrue($this->emitter->getEventKey('test') == 'emitter:test');
        $this->assertTrue($this->emit->getEventKey('test') == "{$this->emit->getHash()}:test");
    }

    public function test_get_events_keys()
    {
        $this->assertTrue($this->emitter->getEventsKeys() == []);
        $this->emit->on('test', function () {
            return 'test';
        });
        $this->assertTrue($this->emit->getEventsKeys() == [$this->emit->getEventKey('test')]);
    }

    public function test_has_event_key()
    {
        $this->assertTrue($this->emitter->hasEventsKeys() === false);
        $this->emitter->on('test', function () {
            return 'test';
        });
        $this->assertTrue($this->emitter->hasEventsKeys('test') === false);
        $this->assertTrue($this->emitter->hasEventsKeys($this->emitter->getEventKey('test')) === true);
    }

    public function test_get_events()
    {
        $this->assertTrue($this->emitter->getEvents() == []);
        $this->emitter->on('test', $callback1 = function () {
            return 'test';
        });
        $this->emitter->on('test', $callback2 = function () {
            return 'test';
        });
        $this->assertTrue($this->emitter->getEvents() == [
                $this->emitter->getEventKey('test') => [$callback1, $callback2],
            ]);
    }

    public function test_on()
    {
        $eventKey1 = $this->emitter->getEventKey('*');

        $this->emitter->on('*', function () {
            return 'test';
        });
        $this->assertTrue(count($this->emitter->getEvents($eventKey1)[$eventKey1]) === 1);

        $this->emitter->on('*', function () {
            return 'test';
        });
        $this->assertTrue(count($this->emitter->getEvents($eventKey1)[$eventKey1]) === 2);


        $eventKey2 = $this->emitter->getEventKey('on');

        $this->emitter->on('on', function () {
            return 'test';
        });
        $this->assertTrue(count($this->emitter->getEvents($eventKey2)[$eventKey2]) === 1);

        $this->emitter->on('on', function () {
            return 'test';
        });
        $this->assertTrue(count($this->emitter->getEvents($eventKey2)[$eventKey2]) === 2);


        $this->assertTrue($this->emitter->getEventsKeys() === [$eventKey1, $eventKey2]);
    }

    public function test_on_more()
    {
        $eventKey1 = $this->emitter->getEventKey('on1');
        $eventKey2 = $this->emitter->getEventKey('on2');

        $this->emitter->on('on1,', function () {
            return 'test';
        });
        $this->assertTrue($this->emitter->getEventsKeys() === [$eventKey1]);

        $this->emitter->clear();

        $this->emitter->on(',on2', function () {
            return 'test';
        });
        $this->assertTrue($this->emitter->getEventsKeys() === [$eventKey2]);

        $this->emitter->clear();

        $this->emitter->on('on1,,on2', function () {
            return 'test';
        });
        $this->assertTrue($this->emitter->getEventsKeys() === [$eventKey1, $eventKey2]);

        $this->emitter->on('on1,on2', function () {
            return 'test';
        });
        $this->assertTrue($this->emitter->getEventsKeys() === [$eventKey1, $eventKey2]);

        $this->emitter->on(['on1', 'on2'], function () {
            return 'test';
        });
        $this->assertTrue($this->emitter->getEventsKeys() === [$eventKey1, $eventKey2]);

        $this->emitter->on(['on1', '', 'on2'], function () {
            return 'test';
        });
        $this->assertTrue($this->emitter->getEventsKeys() === [$eventKey1, $eventKey2]);
    }

    public function test_once()
    {
        $eventKey1 = $this->emitter->getEventKey('*');

        $this->emitter->once('*', function () {
            return 'test';
        });
        $this->assertTrue(count($this->emitter->getEvents($eventKey1)[$eventKey1]) === 1);

        $this->emitter->once('*', function () {
            return 'test';
        });
        $this->assertTrue(count($this->emitter->getEvents($eventKey1)[$eventKey1]) === 2);


        $eventKey2 = $this->emitter->getEventKey('once');

        $this->emitter->once('once', function () {
            return 'test';
        });
        $this->assertTrue(count($this->emitter->getEvents($eventKey2)[$eventKey2]) === 1);

        $this->emitter->once('once', function () {
            return 'test';
        });
        $this->assertTrue(count($this->emitter->getEvents($eventKey2)[$eventKey2]) === 2);


        $this->assertTrue($this->emitter->getEventsKeys() === [$eventKey1, $eventKey2]);
    }

    public function test_once_more()
    {
        $eventKey1 = $this->emitter->getEventKey('once1');
        $eventKey2 = $this->emitter->getEventKey('once2');

        $this->emitter->once('once1,once2,', function () {
            return 'test';
        });
        $this->assertTrue($this->emitter->getEventsKeys() === [$eventKey1, $eventKey2]);

        $this->emitter->once(['', 'once1', 'once2'], function () {
            return 'test';
        });
        $this->assertTrue($this->emitter->getEventsKeys() === [$eventKey1, $eventKey2]);
    }

    public function test_off()
    {
        $eventKey1 = $this->emitter->getEventKey('on');
        $this->emitter->on('on', function () {
            return 'on';
        });
        $this->emitter->once('once', function () {
            return 'once';
        });
        $this->assertTrue($this->emitter->emit('once') == ['once']);
        $this->assertTrue($this->emitter->emit('once') == []);
        $this->assertTrue($this->emitter->getEventsKeys() === [$eventKey1]);

        $this->emitter->off('on');
        $this->assertTrue($this->emitter->emit('on') == []);
        $this->assertTrue($this->emitter->getEventsKeys() === []);
    }

    public function test_emit_on()
    {
        $this->emitter->on('on', function () {
            return 'on';
        });
        $this->emitter->on('on', function () {
            return 'on';
        });
        $this->emitter->on('on1', function () {
            return 'on1';
        });
        $this->emitter->on('on2', function () {
            return 'on2';
        });

        $this->assertTrue($this->emitter->emit('on') == ['on', 'on']);
        $this->assertTrue($this->emitter->emit('on1') == ['on1']);
        $this->assertTrue($this->emitter->emit('on2') == ['on2']);
        $this->assertTrue($this->emitter->emit('on*') == ['on', 'on', 'on1', 'on2']);

        $this->assertTrue($this->emit->emit('on') == []);
        $this->assertTrue($this->emit->emit('on1') == []);
        $this->assertTrue($this->emit->emit('on2') == []);
        $this->assertTrue($this->emit->emit('on*') == []);

        $this->assertTrue($this->emitter->emit('on1,') == ['on1']);
        $this->assertTrue($this->emitter->emit(['on2']) == ['on2']);
        $this->assertTrue($this->emitter->emit('on*') == ['on', 'on', 'on1', 'on2']);
    }

    public function test_emit_once()
    {
        $this->emitter->once('once', function () {
            return 'once';
        });
        $this->emitter->once('once', function () {
            return 'once';
        });
        $this->emitter->once('once1', function () {
            return 'once1';
        });
        $this->emitter->once('once2', function () {
            return 'once2';
        });

        $this->assertTrue($this->emitter->emit('once') == ['once', 'once']);
        $this->assertTrue($this->emitter->emit('once1') == ['once1']);
        $this->assertTrue($this->emitter->emit('once2') == ['once2']);

        $this->assertTrue($this->emit->emit('once*') == []);

        $this->assertTrue($this->emitter->emit('once,') == []);
        $this->assertTrue($this->emitter->emit(['once1']) == []);
        $this->assertTrue($this->emitter->emit('once2') == []);
    }

    public function test_emit_once_wildcard()
    {
        $this->emitter->once('once', function () {
            return 'once';
        });
        $this->emitter->once('once', function () {
            return 'once';
        });
        $this->emitter->once('once1', function () {
            return 'once1';
        });
        $this->emitter->once('once2', function () {
            return 'once2';
        });

        $this->assertTrue($this->emitter->emit('once*') == ['once', 'once', 'once1', 'once2']);

        $this->assertTrue($this->emit->emit('once*') == []);

        $this->assertTrue($this->emitter->emit('once') == []);
        $this->assertTrue($this->emitter->emit('once1') == []);
        $this->assertTrue($this->emitter->emit('once2') == []);
    }

    public function test_clear()
    {
        $this->emitter->on('on', function () {
            return 'on_emitter';
        });
        $this->emit->on('on', function () {
            return 'on_emit';
        });

        $this->assertTrue($this->emitter->getEventsKeys() == [$this->emitter->getEventKey('on')]);
        $this->assertTrue($this->emit->getEventsKeys() == [$this->emit->getEventKey('on')]);
        $this->emitter->clear();
        $this->assertTrue($this->emitter->getEventsKeys() == []);
        $this->assertTrue($this->emit->getEventsKeys() == []);
    }

    public function test_reset()
    {
        $this->emitter->on('on', function () {
            return 'on_emitter';
        });
        $this->emit->on('on', function () {
            return 'on_emit';
        });

        $this->assertTrue($this->emitter->getEventsKeys() == [$this->emitter->getEventKey('on')]);
        $this->assertTrue($this->emit->getEventsKeys() == [$this->emit->getEventKey('on')]);
        $this->emitter->reset();
        $this->assertTrue($this->emitter->getEventsKeys() == []);
        $this->assertTrue($this->emit->getEventsKeys() == [$this->emit->getEventKey('on')]);
        $this->emit->reset();
        $this->assertTrue($this->emitter->getEventsKeys() == []);
        $this->assertTrue($this->emit->getEventsKeys() == []);
    }

    public function test_static()
    {
        $eventKey1 = \Nacosvel\Utils\Facades\Emitter::getEventKey('on');
        $eventKey2 = $this->emitter->getEventKey('on');
        $eventKey3 = $this->emit->getEventKey('on');

        \Nacosvel\Utils\Facades\Emitter::on('on', function () {
            return 'on_static';
        });

        $this->emitter->on('on', function () {
            return 'on_emitter';
        });
        $this->emitter->on('on', function () {
            return 'on_emitter';
        });

        $this->emit->on('on', function () {
            return 'on_emit';
        });

        $this->assertTrue(\Nacosvel\Utils\Facades\Emitter::emit('on,') == ['on_static']);
        $this->assertTrue($this->emitter->emit(',on') == ['on_emitter', 'on_emitter']);
        $this->assertTrue($this->emit->emit(['on']) == ['on_emit']);

        $this->assertTrue(\Nacosvel\Utils\Facades\Emitter::getEventsKeys($eventKey1) == [$eventKey1]);
        $this->assertTrue($this->emitter->getEventsKeys($eventKey2) == [$eventKey2]);
        $this->assertTrue($this->emit->getEventsKeys($eventKey3) == [$eventKey3]);

        $this->assertTrue(\Nacosvel\Utils\Facades\Emitter::getEventsKeys() == [$eventKey1]);
        $this->assertTrue($this->emitter->getEventsKeys() == [$eventKey2]);
        $this->assertTrue($this->emit->getEventsKeys() == [$eventKey3]);
    }

}
