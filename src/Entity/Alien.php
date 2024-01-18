<?php

namespace App\Entity;

class Alien
{
    private int $id;
    private string $name;
    private string $color;


    public function getId()
    {
       // dd("je passe par là");
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }




    public function getName()
    {
        return $this->name;
    }


    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


}