<?php
/**
 * This file is part of the LdapTools package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LdapTools\Event;

use PhpSpec\ObjectBehavior;

class LdapObjectCreationEventSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('foo');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('LdapTools\Event\LdapObjectCreationEvent');
    }

    public function it_should_have_type_Event()
    {
        $this->shouldHaveType('LdapTools\Event\Event');
    }

    public function it_should_implement_EventInterface()
    {
        $this->shouldImplement('LdapTools\Event\EventInterface');
    }

    public function it_should_get_the_event_name()
    {
        $this->getName()->shouldBeEqualTo('foo');
    }

    public function it_should_set_data()
    {
        $data = ['foo'];
        $this->setData($data);
        $this->getData()->shouldBeEqualTo($data);
    }

    public function it_should_set_the_container()
    {
        $container = 'dc=foo,dc=bar';
        $this->setContainer($container);
        $this->getContainer()->shouldBeEqualTo($container);
    }

    public function it_should_set_the_dn()
    {
        $dn = 'cn=foobar,dc=foo,dc=bar';
        $this->setDn($dn);
        $this->getDn()->shouldBeEqualTo($dn);
    }

    public function it_should_get_the_type()
    {
        $this->beConstructedWith('foo', 'bar');
        $this->getType()->shouldBeEqualTo('bar');
    }
}
