<?php
namespace AppBundle\Form\DataTransformer;
use AppBundle\Entity\Selectable;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class AjaxSelectTransformer implements DataTransformerInterface
{
    private $repository;

    private $parameters;

    public function __construct(Selectable $repository, $parameters)
    {
        $this->repository = $repository;
        $this->parameters = $parameters;
    }

    public function transform($value)
    {
        return $value;
    }

    public function reverseTransform($value)
    {
        $isValid = $this->repository->checkChoice($value, $this->parameters);
        if (!$isValid) {
            throw new TransformationFailedException(sprintf('The choice "%s" does not exist or is not unique', $value));
        }
        return $value;
    }

}