<?php namespace OnChainPay;

class Exception extends \Exception
{
    protected $message = 'Unknown exception';
    protected $code    = 0;
    protected string $file;
    protected int $line;

    /**
     * @throws Exception
     */
    public function __construct(string $message = null, int $code = 0)
    {
        if (!$message) {
            throw new $this('Unknown '. get_class($this));
        }
        parent::__construct($message, $code);
    }

    public function __toString(): string
    {
        return sprintf(
            "%s '%s' in %s(%s)\n%s",
            get_class($this),
            $this->message,
            $this->file,
            $this->line,
            $this->getTraceAsString()
        );
    }
}
