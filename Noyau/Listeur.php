<?php

abstract class Listeur {

    protected $_O_mapper;

    public function __construct($O_mapper)
    {
        $this->_O_mapper = $O_mapper;
    }

    public function recupererNbEnregistrements() {
        return $this->_O_mapper->recupererNbEnregistrements();
    }
}