<?php


class user_level
{
    private $id;
    private $user_level;

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
    public function get_user_level()
    {
        return $this->user_level;
    }

    /**
     * @param mixed $user_level
     */
    public function set_user_level($user_level): void
    {
        $this->user_level = $user_level;
    }
}