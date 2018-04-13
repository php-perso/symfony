<?php
// src/OC/PlatformBundle/Antispam/NRXAntispam.php

namespace NRX\PlatformBundle\Antispam;

class NRXAntispam
{
    /**
   * Vérifie si le texte est un spam ou non
   *
   * @param string $text
   * @return bool
   */
  public function isSpam($text)
  {
    return strlen($text) < 50;
  }
}

?>