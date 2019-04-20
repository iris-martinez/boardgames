<?php


class game
{
    private $id;
    private $name;
    private $author;
    private $number_players;
    private $description;
    private $duration;
    private $image;
    private $punctuation;
    private $category;
    private $user;

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
    public function set_id($id)
    {
        $this->id = $id;
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
    public function set_name($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function get_author()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function set_author($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function get_number_players()
    {
        return $this->number_players;
    }

    /**
     * @param mixed $number_players
     */
    public function set_number_players($number_players)
    {
        $this->number_players = $number_players;
    }

    /**
     * @return mixed
     */
    public function get_description()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function set_description($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function get_duration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function set_duration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function get_image()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function set_image($image)
    {
        $this->image = $image;
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
    public function set_punctuation($punctuation)
    {
        $this->punctuation = $punctuation;
    }

    /**
     * @return mixed
     */
    public function get_category()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function set_category($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function get_user()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function set_user($user)
    {
        $this->user = $user;
    }



}