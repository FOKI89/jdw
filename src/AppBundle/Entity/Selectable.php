<?php

namespace AppBundle\Entity;


interface Selectable
{

    public function checkChoice($value, $parameters);

}