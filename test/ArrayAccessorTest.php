<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Biera\ArrayAccessor;

class ArrayAccessorTest extends TestCase
{
    /**
     * @test
     * @covers ArrayAccessor::offsetExists
     * @covers ArrayAccessor::offsetGet
     * @covers ArrayAccessor::retrieve
     */
    public function itImplementsArrayAccess()
    {
        $address = new Address('Cracow', '30-701', 'Zabłocie 43A');
        $owner = new Human('John', $address);
        $pet = new Pet('Rex', $owner);

        $this->assertSame($owner, $pet['owner']);
        $this->assertSame($address, $pet['owner']['address']);
        $this->assertSame( 'Cracow', $pet['owner']['address']['city']);

        $this->assertSame($owner, $pet->get('owner'));
        $this->assertSame($address, $pet->get('/owner/address'));
        $this->assertSame( 'Cracow', $pet->get('/owner/address/city'));
    }

    /**
     * @test
     * @covers \Biera\ArrayAccessor::offsetSet
     */
    public function itRaisesErrorOnSet()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Read only');
        $address = new Address('Cracow', '30-701', 'Zabłocie 43A');
        $address['city'] = 'Lublin';
    }

    /**
     * @test
     * @covers \Biera\ArrayAccessor::offsetUnset
     */
    public function itRaisesErrorOnUnset()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Read only');
        $address = new Address('Cracow', '30-701', 'Zabłocie 43A');
        unset($address['city']);
    }
}

class Pet implements \ArrayAccess
{
    use ArrayAccessor;

    private $name;
    private $owner;

    public function __construct(string $name, Human $owner)
    {
        $this->name = $name;
        $this->owner = $owner;
    }

    public function get(string $path)
    {
        return $this->retrieve($path);
    }
}

class Human implements \ArrayAccess
{
    use ArrayAccessor;

    private $name;
    private $address;

    public function __construct(string $name, Address $address)
    {
        $this->name = $name;
        $this->address = $address;
    }
}

class Address implements \ArrayAccess
{
    use ArrayAccessor;

    private string $city;
    private string $code;
    private string $street;

    public function __construct(string $city, string $code, string $street)
    {
        $this->city = $city;
        $this->code = $code;
        $this->street = $street;
    }
}
