<?php

declare(strict_types=1);

namespace EPSJV\Acl;

use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{

    protected $fillable = ['nome', 'descricao'];

    protected $table = 'permissoes';

    /**
     * Retorna todos os papeis com a permissão.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function papeis(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Papel::class, PapelPermissao::class);
    }
}
