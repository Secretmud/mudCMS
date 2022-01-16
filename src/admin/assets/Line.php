<?php

namespace Secret\MudCms\admin\assets;

class Line extends GraphicsObject
{
    private $color;
    private $sx;
    private $sy;
    private $ex;
    private $ey;

    public function __construct($color, $sx, $sy, $ex, $ey)
    {
        $this->color = $color;
        $this->sx = $sx;
        $this->sy = $sy;
        $this->ex = $ex;
        $this->ey = $ey;
    }

    public function render($ge)
    {
        imageline($ge->getGraphicObject(),
            $this->sx, $this->sy,
            $this->ex, $this->ey,
            $ge->getColor($this->color));
    }
}