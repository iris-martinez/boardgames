<?php

class punctuation
{
    private $id;
    private $user_id;
    private $game_id;
    private $punctuation;
    private $date;
    private $user_level_id;

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
    public function get_punctuation()
    {
        return $this->punctuation;
    }

    /**
     * @param mixed $punctuation
     */
    public function set_punctuation($punctuation): void
    {
        $this->punctuation = $punctuation;
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

    /**
     * @return mixed
     */
    public function get_user_level_id()
    {
        return $this->user_level_id;
    }

    /**
     * @param mixed $user_level_id
     */
    public function set_user_level_id($user_level_id): void
    {
        $this->user_level_id = $user_level_id;
    }

    
    public function __toString()
    {
        return "userpunctuategame[id=".$this->get_id().", userid=".$this->get_user_id().", gameid=".$this->get_game_id().", punctuation=".$this->get_punctuation().", date=".$this->get_date().", userlevelid=".$this->get_user_level_id()."]";
    }



}