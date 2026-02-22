<?php

declare(strict_types=1);

namespace EPSJV\Acl\Traits;

use App\Models\User;
use EPSJV\Acl\Permissao;
use Illuminate\Support\Facades\Gate;

trait MakeAuthorizations
{
    /**
     * Criação das Regras de Controle de acesso baseadas em papéis
     * 
     * Cria dinamicamente a regra de autorização de acordo com cada item de permissão. Ex.: editar_curso
     */
    public function makeAuthorizations(): void
    {
        $permissoes = Permissao::with('papeis')->get();
        
        foreach ($permissoes as $permissao) {
            Gate::define($permissao->nome, function(User $user) use ($permissao): bool {                                        
                return clone $user->hasPapeis($permissao->papeis); 
            });            
        }
    }
}
