<?php

namespace Secret\MudCms\admin\assets;


class Graphing
{
  public $width;
  public $height;
  public $gdo;
  public $colors = array();
 
  public function __construct( $width, $height )
  {
    $this->width = $width;
    $this->height = $height;
    $this->gdo = imagecreatetruecolor( $width, $height );
    $this->addColor( "white", 255, 255, 255 );
    imagefilledrectangle( $this->gdo, 0, 0,
      $width, $height,
      $this->getColor( "white" ) );
  }
 
  public function width() { return $this->width; }
 
  public function height() { return $this->height; }
 
  public function addColor( $name, $r, $g, $b )
  {
    $this->colors[ $name ] = imagecolorallocate(
      $this->gdo,
      $r, $g, $b );
  }
 
  public function getGraphicObject()
  {
    return $this->gdo;
  }
 
  public function getColor( $name )
  {
    return $this->colors[ $name ];
  }
 
  public function saveAsPng( $filename )
  {
    imagepng( $this->gdo, $filename );
  }
}

?>