<?php
/**
 * This file is part of the LdapTools package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LdapTools;

use LdapTools\Cache\CacheInterface;
use LdapTools\Event\SymfonyEventDispatcher;
use LdapTools\Exception\ConfigurationException;
use LdapTools\Log\EchoLdapLogger;
use PhpSpec\ObjectBehavior;
use LdapTools\DomainConfiguration;

class ConfigurationSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(new DomainConfiguration('foo.bar'), new DomainConfiguration('example.local'));
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('LdapTools\Configuration');
    }

    public function it_is_initializable_with_no_domain_configurations()
    {
        $this->beConstructedWith();
        $this->shouldHaveType('LdapTools\Configuration');
    }

    public function it_should_return_self_when_adding_domain_configuration()
    {
        $domain = new DomainConfiguration('example.com');
        $this->addDomain($domain)->shouldReturnAnInstanceOf('\LdapTools\Configuration');
    }

    public function it_should_load_configuration_files()
    {
        $this->load(__DIR__.'/../../resources/config/example.yml')->shouldReturnAnInstanceOf('\LdapTools\Configuration');
    }

    public function it_should_error_when_the_configuration_file_is_not_found()
    {
        $this->shouldthrow('\LdapTools\Exception\ConfigurationException')->duringLoad(__DIR__.'/thisisasuperlongfilenamethatshouldneverexist.yml');
    }

    public function it_should_load_from_an_array_of_config_values()
    {
        $config = [
            'general' => [
                'schema_folder' => '/foo/bar',
            ],
            'domains' => [
                'foobar' => [
                    'domain_name' => 'foo.bar',
                    'username' => 'foo',
                    'password' => 'bar',
                ]
            ]
        ];

        $this->loadFromArray($config)->shouldReturnAnInstanceOf('\LdapTools\Configuration');
        $this->loadFromArray($config)->getSchemaFolder()->shouldBeEqualTo('/foo/bar');
        $this->loadFromArray($config)->getDomainConfiguration('foo.bar')->shouldReturnAnInstanceOf('\LdapTools\DomainConfiguration');
    }

    public function it_should_allow_loading_from_an_array_with_no_domains_set()
    {
        $config = [
            'general' => [
                'schema_folder' => '/foo/bar',
            ],
        ];
        $this->beConstructedWith();
        $this->loadFromArray($config)->shouldReturnAnInstanceOf('\LdapTools\Configuration');
        $this->loadFromArray($config)->getDomainConfiguration()->shouldBeEqualTo([]);
    }

    public function it_should_return_self_when_calling_setDefaultDomain()
    {
        $this->setDefaultDomain('foo.bar')->shouldReturnAnInstanceOf('\LdapTools\Configuration');
    }

    public function it_should_return_correct_domain_when_calling_getDefaultDomain()
    {
        $this->setDefaultDomain('foo.bar');
        $this->getDefaultDomain()->shouldBeEqualTo('foo.bar');
    }

    public function it_should_return_an_array_when_calling_getDomainConfiguration()
    {
        $this->getDomainConfiguration()->shouldBeArray();
    }

    public function it_should_return_a_DomainConfiguration_when_calling_getDomainConfiguration_with_a_domain_name()
    {
        $this->getDomainConfiguration('foo.bar')->shouldReturnAnInstanceOf('\LdapTools\DomainConfiguration');
    }

    public function it_should_throw_InvalidArgumentException_when_calling_getDomainConfiguration_with_an_invalid_name()
    {
        $this->shouldThrow('\LdapTools\Exception\InvalidArgumentException')->duringGetDomainConfiguration('happyfuntime');
    }

    public function it_should_return_the_correct_number_of_domains_when_calling_getDomainConfiguration()
    {
        $this->getDomainConfiguration()->shouldHaveCount(2);
    }

    public function it_should_return_a_string_when_calling_getSchemaFolder()
    {
        $this->getSchemaFolder()->shouldBeString();
    }

    public function it_should_return_the_correct_schema_folder_after_calling_setSchemaFolder()
    {
        $this->setSchemaFolder('/dev/null');
        $this->getSchemaFolder()->shouldBeEqualTo('/dev/null');
    }

    public function it_should_return_a_string_when_calling_getCacheType()
    {
        $this->getCacheType()->shouldBeString();
    }

    public function it_should_throw_ConfigurationException_when_loading_a_domain_config_with_an_unknown_option()
    {
        $e = new ConfigurationException('Error in domain config section: Option "user" not recognized.');
        $this->shouldThrow($e)->duringLoad(__DIR__.'/../resources/config/unknown_directive.yml');
    }

    public function it_should_have_an_array_as_the_attribute_converters()
    {
        $this->getAttributeConverters()->shouldBeArray();
    }

    public function it_should_be_able_to_properly_set_the_attribute_converters()
    {
        $converters = ['foo' => '\Bar'];
        $this->setAttributeConverters($converters);
        $this->getAttributeConverters()->shouldBeEqualTo($converters);
    }

    public function it_should_return_self_after_calling_set_attribute_converters()
    {
        $this->setAttributeConverters(['foo' => 'bar'])->shouldReturnAnInstanceOf('\LdapTools\Configuration');
    }

    public function it_should_set_an_event_dispatcher()
    {
        $this->getEventDispatcher()->shouldReturnAnInstanceOf('\LdapTools\Event\SymfonyEventDispatcher');
        $this->setEventDispatcher(new SymfonyEventDispatcher())->shouldReturnAnInstanceOf('\LdapTools\Configuration');
    }

    public function it_should_set_a_logger()
    {
        $this->getLogger()->shouldBeEqualTo(null);
        $this->setLogger(new EchoLdapLogger())->shouldReturnAnInstanceOf('\LdapTools\Configuration');
        $this->getLogger()->shouldReturnAnInstanceOf('\LdapTools\Log\EchoLdapLogger');
    }

    public function it_should_set_and_get_the_cache(CacheInterface $cache)
    {
        $this->setCache($cache)->getCache()->shouldBeEqualTo($cache);
    }
}
