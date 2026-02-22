# EPSJV Acl Laravel


## Descrição

laravel-acl é um pacote criado para facilitar o processo de criação das regras de controle de acesso baseado em papéis de usuários, possibilitando o controle de acesso de usuários com multipos papéis.


## Requisitos
* [PHP](https://php.net) 8.4+
* [Laravel](https://laravel.com/) 12.x


## Instalação 

+ Execute o seguinte comando:
```php
composer require epsjv/acl
```

* Baseado em uma instalação limpa abra o arquivo `config/app.php` navegue até a seção `providers` e insira no final
```php
 EPSJV\Acl\Providers\ServiceProvider::class,
 ``` 
 
* Publicar:
```php
 php artisan vendor:publish --provider="EPSJV\Acl\Providers\ServiceProvider"
```
* Registrar as Seeds básicas de permissões no database/seeders/DatabaseSeeder.php:
```php
public function run()
{
        // $this->call(UsersTableSeeder::class);
        $this->call(AclPapelTableSeeder::class);
        $this->call(AclPermissaoTableSeeder::class);
        $this->call(AclPapelUserTableSeeder::class);
        $this->call(AclPapelPermissaoTableSeeder::class);
}
```

* Executar o seguinte comando para rodar a seed:
```php
 php artisan migrate --seed
```

* Abra o arquivo App\Providers\AuthServiceProvider.php da aplicação para configurar conforme abaixo:
```php
namespace App\Providers;

use EPSJV\Acl\Traits\MakeAuthorizations; // Importar a Trait MakeAuthorizations do pacote
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    use MakeAuthorizations;
    
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => 'EPSJV\Acl\Policies\UserPolicy', // Registrar a policy
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
       $this->makeAuthorizations(); // Invocar o método makeAuthorizations
    }
}

```

* Incluir as Traits "HasPapeis" e "WithPapeis" no model User (App\Models\User.php) conforme abaixo:
```php
 
use EPSJV\Acl\Traits\HasPapeis;
use EPSJV\Acl\Traits\WithPapeis;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasPapeis, WithPapeis;
    
}
```

> O pacote conta com uma estrutura de dados pronta e simples para trabalhar as permissões e os papéis de usuário.


## Como utilizar
A forma de utilização é a mesma de qualquer outra regra pré-existente, pois para o controle de acesso, basta usar os próprios métodos fornecidos pelo laravel para isso: GATES e POLICIES.


Você pode projeger suas rotas das seguintes formas:

Proteção das Rotas:

```php
    /**
     * Verifica se a permission encontrada está contida na lista de permissions associada ao papel do usuário
     *
     * @param Permissao $permissao
     * @return true
     * 
     * @example rota - Para usar na rota, basta chamar uma middleware, passando a chave 'can' e o nome da permission que deseja autorizar
     * 
     *           Route::get('edit/{curso}', 'CursoController@edit')->name('curso.edit')->middleware('can:editar_curso');
     *
     */

```


Proteção dos Controllers:

```php
    /**
     * Verifica se a permission encontrada está contida na lista de permissions associada ao papel do usuário
     *
     * @param Permissao $permissao
     * @return true
     * 
     * @example controller - Para usar no controller, basta chamar o método authorize no início de cada action, passando o nome da permission e o $model
     * 
     *           public function edit(Curso $curso)
     *           {
     *                  $this->authorize('editar_curso', $curso);
     *           }
    */

```


Proteção das Views:

```php
    /**
     * Verifica se a permission encontrada está contida na lista de permissions associada ao papel do usuário
     *
     * @param Permissao $permissao
     * @return true
     * 
     * @example view - Para usar na view blade, é necessário envolver o trecho de código que deseja autorizar 
     *              com o nome da permission usando a facade @can ou @cannot    
     * 
     *          @can('editar_curso', $cursos) 
     *                  {{-- código aqui --}}
     *          @endcan
     */

```

## E se eu quiser carregar uma sessão com o papel?
A implementação desse pacote é para um cenário onde são carregados todos os papéis e permissões associados ao usuário. Porém você pode implementar sua própria lógica para carregar um papel por acesso. 

Um exemplo dessa implementação pode ser feito da seguinte forma:

1) Dentro do Diretório "app" da sua aplicação, crie uma pasta chamada "Traits".

2) Dentro dessa nova pasta, crie uma Trait chamada MakeAuthorizations.php com o seguinte conteudo:

```php
    <?php

namespace App\Traits;

use App\Models\User;
use EPSJV\Acl\Permissao;
use Illuminate\Support\Facades\Gate;

trait MakeAuthorizations
{
    public function makeAuthorizations(): void
    {
        $permissoes = Permissao::with('papeis')->get();
        
        foreach ($permissoes as $permissao) {
            Gate::define($permissao->nome, function(User $user) use ($permissao): bool {                                        
                return $permissao->papeis->pluck('id')->contains(session('session_papel_id'));  
            });            
        }
    }
    
}

```

3) No AuhServiceProvider de sua aplicação, altere o import da Trait para passar a utilizar Trait criada ao invés da Trait do pacote:

 - Substituir em App\Providers\AuhServiceProvider.php:
```php

use EPSJV\Acl\Traits\MakeAuthorizations;

```
 - para:
```php

use App\Traits\MakeAuthorizations;

```

#

Veja tudo sobre a utilização de [AUTHORIZATIONS](https://laravel.com/docs/12.x/authorization).

Para mais informações sobre o laravel, consulte a [documentação oficial](https://laravel.com/docs/12.x) 12.x do Laravel.

#### Licença
MIT


## Atualizando para a versão 2.0.0 (GitHub / Packalyst)

O pacote agora exige PHP 8.4 e Laravel 12. Para publicar essa nova versão, siga os passos abaixo:

**No GitHub:**
1. Faça o commit de todas as alterações feitas na base de código.
   ```bash
   git add .
   git commit -m "feat: atualização para Laravel 12 e PHP 8.4 v2.0.0"
   ```
2. Crie uma nova tag para a versão `2.0.0`.
   ```bash
   git tag 2.0.0
   ```
3. Faça o push da tag e dos commits para o GitHub.
   ```bash
   git push origin main
   git push origin 2.0.0
   ```
4. Navegue até a página de **Releases** no seu repositório no GitHub e crie uma nova Release utilizando a tag `2.0.0`.

**No Packagist / Packalyst:**
1. Se o seu pacote possui a integração de Webhook ativa com o GitHub, o **Packagist** reconhecerá automaticamente a tag `2.0.0` e a disponibilizará em instantes.
2. Caso não esteja automatizado, acesse sua conta no [Packagist.org](https://packagist.org/), busque pelo seu pacote `epsjv/acl` e clique no botão **Update**. O Packalyst se alimenta do Packagist, então a atualização refletirá lá também.
