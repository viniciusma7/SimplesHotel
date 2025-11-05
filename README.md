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
