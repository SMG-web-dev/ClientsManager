<?php
class Cliente
{

    private $id;

    // Mejora anterior/siguiente
    private $idAnterior;
    private $idSiguiente;

    private $first_name;
    private $last_name;
    private $email;
    private $gender;
    private $ip_address;
    private $telefono;



    function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    public function setNavegacion($db)
    {
        $this->idAnterior = $db->getIdAnterior($this->id);
        $this->idSiguiente = $db->getIdSiguiente($this->id);
    }
}
