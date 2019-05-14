<?php

class category
{
    private $id_category;
    private $name;

    /**
     * @return mixed
     */
    public function get_id_category()
    {
        return $this->id_category;
    }

    /**
     * @param mixed $id
     */
    public function set_id($id_category): void
    {
        $this->id_category = $id_category;
    }

    /**
     * @return mixed
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function set_name($name): void
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return "category[id=".$this->get_id_category().", name=".$this->get_name()."]";
    }



}