<?php

class user
{
    private $id;
    private $name;
    private $surname;
    private $email;
    private $password;
    private $birth_date;
    private $register_date;
    private $role;
    private $user_level;
    private $counter_punctuation;

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

    /**
     * @return mixed
     */
    public function get_surname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function set_surname($surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function get_email()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function set_email($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function get_password()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function set_password($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function get_birthDate()
    {
        return $this->birth_date;
    }

    /**
     * @param mixed $birth_date
     */
    public function set_birthDate($birth_date): void
    {
        $this->birth_date = $birth_date;
    }

    /**
     * @return mixed
     */
    public function get_registerDate()
    {
        return $this->register_date;
    }

    /**
     * @param mixed $register_date
     */
    public function set_registerDate($register_date): void
    {
        $this->register_date = $register_date;
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

    /**
     * @return mixed
     */
    public function get_userLevel()
    {
        return $this->user_level;
    }

    /**
     * @param mixed $user_level
     */
    public function set_userLevel($user_level): void
    {
        $this->user_level = $user_level;
    }

    /**
     * @return mixed
     */
    public function get_counterPunctuation()
    {
        return $this->counter_punctuation;
    }

    /**
     * @param mixed $counter_punctuation
     */
    public function set_counterPunctuation($counter_punctuation): void
    {
        $this->counter_punctuation = $counter_punctuation;
    }

}

