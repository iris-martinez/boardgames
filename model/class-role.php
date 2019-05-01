<?php


class role
{

    private $id;
    private $role;

    /**
     * @return mixed
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function set_id($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function get_role()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function set_role($role): void
    {
        $this->role = $role;
    }

    public function __toString()
    {
        return "role[id=".$this->get_id().", role=".$this->get_role()."]";
    }

}