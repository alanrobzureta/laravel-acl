<?php

declare(strict_types=1);

namespace EPSJV\Acl;

use Illuminate\Database\Eloquent\Model;

class Papel extends Model
{
    protected $fillable = ['nome', 'descricao'];
    
    protected $table = 'papeis';

    /**
     * Retorna todas as permissões com o papel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissoes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permissao::class, PapelPermissao::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, PapelUser::class);
    }
}
