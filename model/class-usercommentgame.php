<?php

class comments
{
    private $id;
    private $user_id;
    private $game_id;
    private $comment;
    private $date;

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
    public function get_user_id()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function set_user_id($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function get_game_id()
    {
        return $this->game_id;
    }

    /**
     * @param mixed $game_id
     */
    public function set_game_id($game_id): void
    {
        $this->game_id = $game_id;
    }

    /**
     * @return mixed
     */
    public function get_comment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function set_comment($comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function get_date()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function set_date($date): void
    {
        $this->date = $date;
    }

    
    public function __toString()
    {
        return "usercommentgame[id=".$this->get_id().", userid=".$this->get_user_id().", gameid=".$this->get_game_id().", comment=".$this->get_comment().", date=".$this->get_date()."]";
    }



}