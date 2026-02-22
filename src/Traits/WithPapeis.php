<?php

declare(strict_types=1);

namespace EPSJV\Acl\Traits;

use EPSJV\Acl\Papel;
use EPSJV\Acl\PapelUser;

trait WithPapeis
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function papeis(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Papel::class, PapelUser::class);
    }
}
