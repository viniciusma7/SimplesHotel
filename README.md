## SimplesHotel (instruções do projeto)

Este repositório contém um projeto de teste de estágio para SimplesHotel.

### Requisitos

- PHP 8.x
- Composer
- Node.js (para assets via Vite)
- um servidor de banco de dados compatível (MySQL, PostgreSQL, SQLite, etc.)

### Instalação local

1. Clone o repositório e entre na pasta do projeto:

```bash
git clone https://github.com/viniciusma7/SimplesHotel && cd SimplesHotel
```

2. Instale as dependências PHP e JavaScript:

```bash
composer install
npm install
```

3. Copie o arquivo de ambiente e gere a chave da aplicação:

```bash
cp .env.example .env
php artisan key:generate
```

4. Configure as variáveis do banco de dados em `.env` (DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD). Exemplo usando MySQL:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=simpleshotel
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

5. Rode as migrations e seeders (se desejar):

```bash
php artisan migrate
# opcional: php artisan db:seed
```

6. Compile os assets (desenvolvimento):

```bash
npm run dev
```

7. Inicie o servidor local:

```bash
php artisan serve
# Acesse em http://127.0.0.1:8000
```

Observação: este projeto também inclui rotas protegidas por autenticação (middleware `auth`). Rode o seeder de usuários ou registre um usuário via interface para acessar as funcionalidades de tarefas.

### Comandos úteis

- php artisan migrate:fresh --seed  # recria o banco e popula com seeders
- php artisan route:list            # lista as rotas registradas
- php artisan tinker                # console interativo

### O que foi implementado (decisões principais)

- CRUD completo para tarefas usando `Route::resource()` e `TarefasController`.
- Validação de entrada realizada com `FormRequest` (`app/Http/Requests/TarefaRequest.php`) — título obrigatório e com máximo de 255 caracteres.
- Persistência com Eloquent (`app/Models/Tarefa.php`) com suporte a `SoftDeletes` e `$fillable` configurado.
- Listagem paginada (`paginate(15)`) com filtro por `status` (pendente / concluída).
- Soft delete ativado na migration e na model; implementei também uma rota e ação para `restore` (restaurar) tarefas excluídas.
- A interface foi construída com Blade e componentes/layouts para evitar repetição (`resources/views/pages/tarefas/*`).
- Rotas protegidas pelo middleware `auth` (apenas usuários autenticados podem gerenciar tarefas).

### Melhorias futuras (priorizadas)

- Testes automatizados: adicionar testes Feature cobrindo criação, edição, exclusão (soft delete) e restauração.
- Políticas (Policies) e autorização fina: usar `TarefaPolicy` para centralizar autorização de ações (view, update, delete, restore).
- Excluir permanentemente (force delete) via interface para administradores ou fluxos especiais.
- Página separada para itens excluídos com ações em lote (restaurar / apagar permanentemente).
- Melhorias de UX: ordenação, busca por título, atalhos de teclado e feedbacks (toasts) mais claros.

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
