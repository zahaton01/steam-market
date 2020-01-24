<?php

namespace App\Domain\Entity;

use App\Domain\Traits\CreationDateTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 *
 * @ORM\Table(name="logs")
 * @ORM\Entity(repositoryClass="App\Repository\LogRepository")
 */
class Log extends AbstractEntity
{
    use CreationDateTrait;

    const LEVEL_INFO = 'info';
    const LEVEL_WARNING = 'warning';
    const LEVEL_ERROR = 'error';

    const SOURCE_CONSOLE = 'console';
    const SOURCE_ADMIN = 'admin';

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="level", nullable=false)
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="source", nullable=false)
     */
    private $source;

    /**
     * @var array
     *
     * @ORM\Column(type="json", name="extras", nullable=true)
     */
    private $extras;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="message", nullable=true)
     */
    private $message;

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
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @param string $source
     *
     * @return self
     */
    public function setSource(?string $source): self
    {
        $this->source = $source;
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
    public static function getPossibleLevels(): array
    {
        return [
            self::LEVEL_ERROR,
            self::LEVEL_WARNING,
            self::LEVEL_INFO
        ];
    }

    /**
     * @return array
     */
    public static function getPossibleSources(): array
    {
        return [
            self::SOURCE_CONSOLE,
            self::SOURCE_ADMIN,
        ];
    }
}
