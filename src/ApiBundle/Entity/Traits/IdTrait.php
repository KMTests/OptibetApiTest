<?php

namespace ApiBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class IdTrait
 * @package ApiBundle\Entity\Traits
 */
trait IdTrait {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}