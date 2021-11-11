# biera / array-accessor
Tiny lib which lets you access object graph with ease. 

### usage
Just `use Biera\ArrayAccessor` trait. Don't forget to make your class `implements \ArrayAcccess` interface.  
```php
use ArrayAccess;
use Biera\ArrayAccessor;

class User implements ArrayAccess 
{
    use ArrayAccessor;

    private Address $address;    
    ...
        
    public function getAddress(): Address
    {
        return $this->address;
    }
    ...
}

class Address implements ArrayAccess
{
    use ArrayAccessor;

    private string $street;
    private string $zipCode;    
    ...
    
    public function getZipCode(): string
    {
        return $this->zipCode; 
    }
    ...
}

...

/** @var User $user */
assert($user['address']['zipCode'] ==  $user->getAddress()->getZipCode());
```

### installation
The lib is distributed as composer package.

```shell 
composer req biera/array-accessor
```
