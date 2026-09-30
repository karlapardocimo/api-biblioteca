# API Biblioteca

Trabalho da disciplina de Desenvolvimento Web III - IF Sudeste MG, Campus Muriaé.
Professor: Diego Rossi
Aluna: Karla Pardocimo

## Sobre o trabalho

API publicada: https://api-biblioteca-production-iogz2l.laravel.cloud/api/livros
API REST feita em Laravel para cadastrar livros, autores, categorias e usuários.
Os dados ficam em um banco MySQL e as tabelas foram criadas com migrations.

Cada livro pertence a um autor e a uma categoria. Na consulta de livros, a API
também retorna os dados do autor e da categoria.

Como bônus, usei o Laravel Sanctum para autenticação. As consultas (GET) são
públicas, mas para cadastrar, alterar ou excluir é preciso fazer login e usar o token.

## Tecnologias

- PHP
- Laravel
- MySQL
- Laravel

## Como rodar

1. Instalar as dependências: `composer install`
2. Copiar o `.env.example` para `.env` e configurar o banco de dados
3. Gerar a chave: `php artisan key:generate`
4. Criar as tabelas com dados de exemplo: `php artisan migrate --seed`
5. Iniciar o servidor: `php artisan serve`

Usuário de teste: admin@exemplo.com / senha: password123

## Endpoints

Autores: `GET /api/autores`, `GET /api/autores/{id}`, `POST /api/autores`, `PUT /api/autores/{id}`, `DELETE /api/autores/{id}`

Categorias: `GET /api/categorias`, `GET /api/categorias/{id}`, `POST /api/categorias`, `PUT /api/categorias/{id}`, `DELETE /api/categorias/{id}`

Livros: `GET /api/livros`, `GET /api/livros/{id}`, `POST /api/livros`, `PUT /api/livros/{id}`, `DELETE /api/livros/{id}`

Login: `POST /api/register`, `POST /api/login`, `POST /api/logout`

## Testes

Testei a API no Postman. A coleção está na pasta `docs`.