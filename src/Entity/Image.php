<?php


namespace App\Entity;


class Image
{
    protected $path;

    /**
     * Image constructor.
     * @param $path
     */
    public function __construct( $path )
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }
}