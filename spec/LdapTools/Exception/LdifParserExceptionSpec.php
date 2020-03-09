<?php
/**
 * This file is part of the LdapTools package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LdapTools\Exception;

use PhpSpec\ObjectBehavior;

class LdifParserExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('foo', 'foo: bar', 1);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('LdapTools\Exception\LdifParserException');
    }


    public function it_should_have_the_base_exception_type()
    {
        $this->shouldHaveType('\LdapTools\Exception\Exception');
    }

    public function it_should_generate_a_message()
    {
        $this->getMessage()->shouldBeEqualTo('foo on line number 1 near "foo: bar"');
    }
}
