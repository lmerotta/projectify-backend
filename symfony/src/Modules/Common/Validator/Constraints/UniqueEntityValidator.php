<?php

namespace App\Modules\Common\Validator\Constraints;

use App\Modules\Common\Traits\EntityManager;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueEntityValidator extends ConstraintValidator
{
    use EntityManager;

    public function validate($value, Constraint $constraint): void
    {
        // @codeCoverageIgnoreStart
        if (!$value || !($constraint instanceof UniqueEntity)) {
            return;
        }
        // @codeCoverageIgnoreEnd

        $propertyAccess = PropertyAccess::createPropertyAccessor();
        $mapping = [];

        foreach ($constraint->fields as $entityField => $valueField) {
            $mapping[$entityField] = $propertyAccess->getValue($value, $valueField);
        }

        $entity = $this->em->getRepository($constraint->class)->findOneBy($mapping);

        if (!is_null($entity)) {
            $this->context->buildViolation($constraint->message)
                ->atPath($constraint->propertyPath)
                ->setParameter('{{ fields }}', implode(',', array_keys($constraint->fields)))
                ->addViolation();
        }
    }
}
