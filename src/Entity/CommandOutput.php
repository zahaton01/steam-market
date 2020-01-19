<?php

namespace App\Entity;

use App\Traits\CreationDateTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CommandOutput
 * @package App\Entity
 *
 * @ORM\Table("command_outputs")
 * @ORM\Entity()
 */
class CommandOutput extends AbstractEntity
{
    use CreationDateTrait;

    const LEVEL_COMMENT = 'comment';
    const LEVEL_INFO = 'info';
    const LEVEL_ERROR = 'error';

    /**
     * @var string
     *
     * @ORM\Column(name="command", type="string", nullable=false)
     */
    private $command;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", nullable=false)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", nullable=false)
     */
    private $level;

    /**
     * @var array
     *
     * @ORM\Column(name="extras", type="json", nullable=true)
     */
    private $extras;

    /**
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return self
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return array
     */
    public function getExtras(): ?array
    {
        return $this->extras;
    }

    /**
     * @param array $extras
     *
     * @return self
     */
    public function setExtras(?array $extras): self
    {
        $this->extras = $extras;
        return $this;
    }

    /**
     * @return string
     */
    public function getLevel(): ?string
    {
        return $this->level;
    }

    /**
     * @param string $level
     *
     * @return self
     */
    public function setLevel(?string $level): self
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommand(): ?string
    {
        return $this->command;
    }

    /**
     * @param string $command
     *
     * @return self
     */
    public function setCommand(?string $command): self
    {
        $this->command = $command;
        return $this;
    }
}