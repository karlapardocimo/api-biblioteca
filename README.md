# API Biblioteca — Desenvolvimento Web III

API REST pública em **Laravel** para gerenciamento de **Livros, Autores, Categorias e Usuários**, com autenticação via **Laravel Sanctum** (bônus).

IF Sudeste MG — Campus Muriaé · Prof. Diego Rossi

## Tecnologias
PHP 8.2+ · Laravel · MySQL/MariaDB · Laravel Sanctum · JSON

## Modelo de dados
- `autor` (idautor, nome, nacionalidade, nascimento, biografia)
- `categoria` (idcategoria, nome, descricao)
- `livro` (idlivro, titulo, isbn, anopublicacao, descricao, paginas, idautor, idcategoria)
- Relacionamentos: 1 autor → N livros; 1 categoria → N livros (chaves estrangeiras com `restrict` na exclusão).

Todas as tabelas são criadas por **migrations**.

## Como rodar

```bash
# 1. Criar o projeto base
composer create-project laravel/laravel api-biblioteca
cd api-biblioteca

# 2. Instalar a camada de API + Sanctum (responda "no" se perguntar sobre rodar migrations agora)
php artisan install:api

# 3. Copiar os arquivos deste repositório por cima do projeto (substituindo quando pedir)
#    app/, bootstrap/app.php, database/, routes/api.php

# 4. Configurar o banco no .env
#    DB_CONNECTION=mysql
#    DB_HOST=127.0.0.1
#    DB_PORT=3306
#    DB_DATABASE=biblioteca
#    DB_USERNAME=root
#    DB_PASSWORD=

# 5. Criar tabelas e dados de exemplo
php artisan migrate --seed

# 6. Subir o servidor
php artisan serve
```

Usuário de teste criado pelo seeder: `admin@exemplo.com` / `password123`.

## Regras de acesso
- **GET** (consultas): públicos.
- **POST, PUT, DELETE**: exigem token no header `Authorization: Bearer {token}`.
- Envie também `Accept: application/json`.

## Endpoints

### Autenticação
| Método | Rota | Descrição |
|---|---|---|
| POST | `/api/register` | Cadastra usuário e retorna token |
| POST | `/api/login` | Retorna token |
| GET | `/api/me` | Usuário autenticado 🔒 |
| POST | `/api/logout` | Revoga o token atual 🔒 |

### Autores
| Método | Rota | Descrição |
|---|---|---|
| GET | `/api/autores` | Lista os autores |
| GET | `/api/autores/{id}` | Autor específico (com seus livros) |
| POST | `/api/autores` | Cadastra autor 🔒 |
| PUT | `/api/autores/{id}` | Atualiza autor 🔒 |
| DELETE | `/api/autores/{id}` | Remove autor 🔒 |

### Categorias
| Método | Rota | Descrição |
|---|---|---|
| GET | `/api/categorias` | Lista as categorias |
| GET | `/api/categorias/{id}` | Categoria específica (com seus livros) |
| POST | `/api/categorias` | Cadastra categoria 🔒 |
| PUT | `/api/categorias/{id}` | Atualiza categoria 🔒 |
| DELETE | `/api/categorias/{id}` | Remove categoria 🔒 |

### Livros
| Método | Rota | Descrição |
|---|---|---|
| GET | `/api/livros` | Lista livros **com autor e categoria** (filtros: `?idautor=`, `?idcategoria=`) |
| GET | `/api/livros/{id}` | Livro específico **com autor e categoria** |
| POST | `/api/livros` | Cadastra livro 🔒 |
| PUT | `/api/livros/{id}` | Atualiza livro 🔒 |
| DELETE | `/api/livros/{id}` | Remove livro 🔒 |

### Usuários 🔒
`GET /api/usuarios` · `GET /api/usuarios/{id}` · `POST /api/usuarios` · `PUT /api/usuarios/{id}` · `DELETE /api/usuarios/{id}`

## Exemplos

**POST /api/livros**
```json
{
  "titulo": "Quincas Borba",
  "isbn": "000-00-0000-005-0",
  "anopublicacao": 1891,
  "descricao": "Romance da fase realista.",
  "paginas": 320,
  "idautor": 1,
  "idcategoria": 1
}
```

**Resposta de GET /api/livros/1**
```json
{
  "idlivro": 1,
  "titulo": "Dom Casmurro",
  "isbn": "000-00-0000-001-0",
  "anopublicacao": 1899,
  "descricao": "Bentinho narra sua história com Capitu.",
  "paginas": 256,
  "idautor": 1,
  "idcategoria": 1,
  "autor": { "idautor": 1, "nome": "Machado de Assis", "nacionalidade": "Brasileira", "nascimento": "1839-06-21", "biografia": "..." },
  "categoria": { "idcategoria": 1, "nome": "Romance", "descricao": "Obras de ficção em prosa." }
}
```

## Códigos de resposta
`200` OK · `201` criado · `401` sem token/credenciais inválidas · `404` não encontrado · `409` exclusão bloqueada (autor/categoria com livros vinculados) · `422` erro de validação

## Testes
Importe `docs/API-Biblioteca.postman_collection.json` no Postman ou Insomnia. A requisição **Login** salva o token automaticamente na variável `token`; altere `base_url` para a URL pública após o deploy.
