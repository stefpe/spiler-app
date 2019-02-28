<?php

namespace App\Twig;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class PropertyAccessorExtension
 * @package App\Twig
 */
class PropertyAccessorExtension extends AbstractExtension
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $propertyAccessor;

    /**
     * PropertyAccessorExtension constructor.
     */
    public function __construct()
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_property', [$this, 'doSomething']),
        ];
    }

    /**
     * @param $data
     * @param $property
     * @return mixed
     */
    public function doSomething($data, $property)
    {
        return $this->propertyAccessor->getValue($data, $property);
    }
}
