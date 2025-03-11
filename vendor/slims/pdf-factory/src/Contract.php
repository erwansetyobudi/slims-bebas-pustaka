<?php
namespace SLiMS\Pdf;

use Closure;

abstract class Contract
{
    protected static string $name = '';
    protected ?object $pdf = null;

    public function __construct()
    {
        if (empty(self::$name)) {
            self::$name = '123';
        }
        $this->setPdf();
    }

    /**
     * PDF report in other place have
     * different fields. So provide yours
     * in this method.
     *
     * @return array
     */
    protected function getCustomFields():array
    {
        return [];
    }

    /**
     * Preview data without parsing content
     * a.k.d designer mode
     *
     * @return void
     */
    public function preview()
    {
        $this->setContent()->stream();
    }

    /**
     * Set your PDF Core Engine instance
     * to $pdf property
     *
     * @return void
     */
    abstract protected function setPdf():void;

    /**
     * Prepare and setup your content in 
     * this method. Create it and generate!
     *
     * @param array $data
     * @return self
     */
    abstract protected function setContent(array $data = []):self;

    /**
     * Generate PDF output and download it
     * as file
     *
     * @param string $filname
     * @return void
     */
    abstract protected function download(string $filname):void;

    /**
     * Stream your PDF report on browser
     * without download it
     *
     * @param string|null $filname
     * @param array|null $options
     * @return void
     */
    abstract protected function stream(?string $filname = null, ?array $options = null):void;

    /**
     * Generate PDF to save it into
     * file.
     *
     * @param string $filepath
     * @param Closure|null $callback
     * @return void
     */
    abstract protected function saveToFile(string $filepath, ?Closure $callback = null):void;
}
