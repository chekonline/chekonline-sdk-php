<?php

namespace Chekonline\Cashbox\Commands;

use Chekonline\Cashbox\Exceptions\ChekonlineCommandException;

class NoOperationCommand extends BaseCommand
{
    const NAME = 'NoOperation';

    /**
     * @var int|null
     */
    private $Password;

    public function getParams()
    {
        return get_object_vars($this);
    }

    /**
     * @param int $Password
     *
     * @return $this
     */
    public function setPassword($Password)
    {
        $this->Password = $Password;

        return $this;
    }

    /**
     * @return int
     */
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        parent::validate();
        if (isset($this->Password) == false) {
            throw new ChekonlineCommandException('The password must be determined', $this);
        }
    }
}