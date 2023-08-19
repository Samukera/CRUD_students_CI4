
# API RESTful CRUD estudantes (Backend)

Este projeto é uma API RESTful construída em CodeIgniter 4, um framework PHP moderno e poderoso que facilita o desenvolvimento de aplicações web. A API é capaz de gerenciar um sistema de cadastro de alunos, permitindo realizar as seguintes operações:

- Listar todos os alunos cadastrados, com seus respectivos dados, como nome, idade, curso, etc.

- Adicionar um novo aluno, informando todos os campos necessários, como nome, idade, curso, etc.

- Visualizar os detalhes de um aluno específico, buscando pelo seu identificador único.

- Atualizar as informações de um aluno, alterando os campos desejados, como nome, idade, curso, etc.

- Excluir um aluno do sistema, removendo todos os seus dados do banco de dados.

Além disso a API possui um sistema de autenticação, portanto todas as rotas do CRUD possuem controle de acesso as rotas.



## Informações extras

A API conta com medidas de segurança como `Token` de autenticação via JWT, Filtros de autenticação de rotas para controle de acesso do usuário, segurança contra ataques do tipo CSRF (Cross-Site Request Forgery), segurança contra ataque de força de bruta padrão onde se tenta estressar a API com muitas requisições por segundo, por isto o foram implementados filtros baseados na biblioteca Throttle.

## Instalação e configuração do projeto

### Clone o repositório do GitHub
Abra um terminal e navegue até o diretório onde deseja clonar o repositório. Em seguida, use o comando `git  clone` seguido da URL do repositório do GitHub.

### Instale as dependências

```bash
  composer install
```
### Configure o arquivo .env e execute o servidor

Use o arquivo ```env-example``` como referência para criar o seu ```.env```.

Feita a configuração, você pode rodar o comando abaixo para rodar o projeto.
```bash
  php spark serve
```    
## Documentação da API

## Auth

#### Cria conta administrativa

```http
  POST /api/auth/createLogin
```

**Cabeçalho**: 'Content-Type: application/json'

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `username` | `string` | **Obrigatório**. |
| `email` | `string` | **Obrigatório**. **E-mail válido e único**.|
| `password` | `string` | **Obrigatório**. **Tamanho mínimo 6 caracteres**. |

**Body**:
```json
{
    "username": "testefim",
    "email": "testefim@admin.com",
    "password": "testefim1234"
}
```

#### Login

```http
  POST /api/auth/login
```

**Cabeçalho**: 'Content-Type: application/json', 'X-CSRF-TOKEN: [valor_token]'

**Limite de requisições por minuto**: 5 requisições por minuto.

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `email`      | `string` | **Obrigatório**. **E-mail válido**. |
| `password`      | `string` | **Obrigatório**. **Tamanho mínimo 6 caracteres**. |

**Body**:
```json
{
    "email": "testefim@admin.com",
    "password": "testefim1234"
}
```

## Students
**Limite de requisições por minuto**: 30 requisições por minuto.
#### Lista todos estudantes

```http
  GET /api/listStudents
```

**Cabeçalho**: 'Content-Type: application/json', 'X-CSRF-TOKEN: [valor_token]', 'Bearer Token'

#### Lista estudante específico

```http
  GET /api/listStudents/id
```

**Cabeçalho**: 'Content-Type: application/json', 'X-CSRF-TOKEN: [valor_token]', 'Bearer Token'

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `int` | **Obrigatório**. O ID do estudante que você quer puxar os dados. |

#### Cria novo estudante

```http
  POST /api/createStudent
```

**Cabeçalho**: 'Content-Type: application/json', 'X-CSRF-TOKEN: [valor_token]', 'Bearer Token'

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `name`      | `string` | **Obrigatório**. **Tamanho mínimo 3 caracteres**. |
| `email`      | `string` | **Obrigatório**. **E-mail válido e único**. |
| `fone`      | `numeric` | **Obrigatório**. |
| `address`      | `string` | **Obrigatório**. |
| `picture`      | `string` | **Obrigatório**. |


**Body**:
```json
{
    "name": "teste2",
    "email": "samu7@gmail.com",
    "fone": "1234567890",
    "address": "blablalblablalblablal",
    "picture": "blalblalblalllblalbl"
}
```

#### Edita estudante existente

```http
  PUT /api/updateStudent/id
```
**Cabeçalho**: 'Content-Type: application/json', 'X-CSRF-TOKEN: [valor_token]', 'Bearer Token'

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `int` | **Obrigatório**. O ID do estudante que você quer atualizar os dados. |
| `name`      | `string` | **Obrigatório**. **Tamanho mínimo 3 caracteres**. |
| `email`      | `string` | **Obrigatório**. **E-mail válido e único**. |
| `fone`      | `numeric` | **Obrigatório**. |
| `address`      | `string` | **Obrigatório**. |
| `picture`      | `string` | **Obrigatório**. |

**Body**:
```json
{
    "fone": "2244557891",
    "address": "rua piaui 110, parque pinheiro machado, 97030-470"
}
```

#### Deleta estudante

```http
  DELETE /api/deleteStudent/id
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `int` | **Obrigatório**. O ID do estudante que você quer excluir os dados. |
| `email`      | `string` | **Obrigatório**. O ID do item que você quer |
| `password`      | `string` | **Obrigatório**. O ID do item que você quer |





## Stack utilizada

**Back-end:** PHP 8.2 - CodeIgniter 4

