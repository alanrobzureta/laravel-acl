<?php

declare(strict_types=1);

namespace EPSJV\Acl\Traits;

trait HasPapeis
{
    /**
     * @param mixed $papeis
     */
    public function hasPapeis(mixed $papeis): bool
    {
        if (is_array($papeis) || is_object($papeis)) {
            return (bool) $papeis->intersect($this->papeis)->count();
        }
        
        return $this->papeis->contains('nome', $papeis);        
    }
}