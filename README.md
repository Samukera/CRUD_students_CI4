# API RESTful CRUD estudantes (Backend)

Este projeto é uma API RESTful construída em CodeIgniter 4, um framework PHP moderno e poderoso que facilita o desenvolvimento de aplicações web. A API é capaz de gerenciar um sistema de cadastro de alunos, permitindo realizar as seguintes operações:

- Listar todos os alunos cadastrados, com seus respectivos dados, como nome, idade, curso, etc.

- Adicionar um novo aluno, informando todos os campos necessários, como nome, idade, curso, etc.

- Visualizar os detalhes de um aluno específico, buscando pelo seu identificador único.

- Atualizar as informações de um aluno, alterando os campos desejados, como nome, idade, curso, etc.

- Excluir um aluno do sistema, removendo todos os seus dados do banco de dados.

Além disso a API possui um sistema de autenticação, portanto todas as rotas do CRUD possuem controle de acesso as rotas.

**Collection Postman**: arquivo -> `CI4API.postman_collection.json`

## Informações extras

A API conta com medidas de segurança como `Token` de autenticação via JWT, Filtros de autenticação de rotas para controle de acesso do usuário, segurança contra ataque de força de bruta padrão onde se tenta estressar a API com muitas requisições por segundo, por isto o foram implementados filtros baseados na biblioteca Throttle.

## Instalação e configuração do projeto

### Clone o repositório do GitHub

Abra um terminal e navegue até o diretório onde deseja clonar o repositório. Em seguida, use o comando `git  clone` seguido da URL do repositório do GitHub.

### Instale as dependências

```bash
  composer install
```

### Configure o arquivo .env e execute o servidor

Use o arquivo `env-example` como referência para criar o seu `.env`.

Após isso, edite os constructs do controllers adicionando o seguinte código:

```bash
        header('Access-Control-Allow-Origin: url_project_frontend');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding');
```

Faça isso nos controllers: Login.php e Students.php

Além disso acesse o arquivo Cors.php localizado dentro da pasta app\Config e altere o valor da variável $allowedOrigins para:

```bash
public $allowedOrigins = ['url_project_frontend'];
```

OBS: url_project_frontend -> A URL em que está rodando o projeto frontend desta API.

Feita a configuração, você pode rodar o comando abaixo para rodar o projeto.

```bash
  php spark migrate
  php spark serve
```

## Documentação da API

## Auth

#### Cria conta administrativa

```http
  POST /api/auth/createLogin
```

**Cabeçalho**: 'Content-Type: application/json'

| Parâmetro  | Tipo     | Descrição                                         |
| :--------- | :------- | :------------------------------------------------ |
| `username` | `string` | **Obrigatório**.                                  |
| `email`    | `string` | **Obrigatório**. **E-mail válido e único**.       |
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

**Cabeçalho**: 'Content-Type: application/json'

**Limite de requisições por minuto**: 5 requisições por minuto.

| Parâmetro  | Tipo     | Descrição                                         |
| :--------- | :------- | :------------------------------------------------ |
| `email`    | `string` | **Obrigatório**. **E-mail válido**.               |
| `password` | `string` | **Obrigatório**. **Tamanho mínimo 6 caracteres**. |

**Body**:

```json
{
  "email": "testefim@admin.com",
  "password": "testefim1234"
}
```

## Students

**Limite de requisições por minuto**: 50 requisições por minuto.

#### Lista todos estudantes

```http
  GET /api/listStudents
```

**Cabeçalho**: 'Content-Type: application/json', 'Bearer Token'

#### Lista estudante específico

```http
  GET /api/listStudents/id
```

**Cabeçalho**: 'Content-Type: application/json', 'Bearer Token'

| Parâmetro | Tipo  | Descrição                                                        |
| :-------- | :---- | :--------------------------------------------------------------- |
| `id`      | `int` | **Obrigatório**. O ID do estudante que você quer puxar os dados. |

#### Cria novo estudante

```http
  POST /api/createStudent
```

**Cabeçalho**: 'Content-Type: application/json', 'Bearer Token'

| Parâmetro | Tipo      | Descrição                                         |
| :-------- | :-------- | :------------------------------------------------ |
| `name`    | `string`  | **Obrigatório**. **Tamanho mínimo 3 caracteres**. |
| `email`   | `string`  | **Obrigatório**. **E-mail válido e único**.       |
| `fone`    | `numeric` | **Obrigatório**.                                  |
| `address` | `string`  | **Obrigatório**.                                  |
| `picture` | `string`  | **Obrigatório**.                                  |

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

**Cabeçalho**: 'Content-Type: application/json', 'Bearer Token'

| Parâmetro | Tipo      | Descrição                                                            |
| :-------- | :-------- | :------------------------------------------------------------------- |
| `id`      | `int`     | **Obrigatório**. O ID do estudante que você quer atualizar os dados. |
| `name`    | `string`  | **Obrigatório**. **Tamanho mínimo 3 caracteres**.                    |
| `email`   | `string`  | **Obrigatório**. **E-mail válido e único**.                          |
| `fone`    | `numeric` | **Obrigatório**.                                                     |
| `address` | `string`  | **Obrigatório**.                                                     |
| `picture` | `string`  | **Obrigatório**.                                                     |

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

| Parâmetro | Tipo  | Descrição                                                          |
| :-------- | :---- | :----------------------------------------------------------------- |
| `id`      | `int` | **Obrigatório**. O ID do estudante que você quer excluir os dados. |

## Melhorias futuras e considerações

Nesta parte do README, vou deixar algumas considerações e comentários sobre a API:
Foi adicionado um nível de segurança csrf que tenta prevenir requisições simuladas de outros sites CSRF (Cross-Site Request Forgery), só que pra isso as requisições de tipo post/put/delete precisam de um token especial que se renova a cada requisição (por segurança) e aí foi um problema na questão do backend rodar separado do front end (cada requisição do front pro back fazia o token se alterar e aí para usar ele ficou bem complexo em relação ao tempo disponível). Essa tecnologia CSRF adiciona uma segurança adicional porém em API's rest ela se torna muito custosa pelo fato de que a obtenção do token especial na parte do front precisa de uma lógica mais complexa. E aí acabei percebendo isso de fato enquanto estava implementando, então tive uma ideia para resolver isso sem muito custo que foi substituindo esse nível adicional por algumas outras verificações mais específicas que eu já fazia (melhorei outras funções).
Além disso, gostaria de comentar que para aumentar a qualidade e segurança da API é possível futuramente refatorar a lógica de armazenamento das imagens dos estudantes, para uma estratégia que se baseia em salvar o arquivo no servidor e o no banco de dados apenas o caminho para o arquivo, pois dessa forma o banco de dados não se torna uma preocupação a longo prazo em questão de custo de processamento de imagens. Outra possível melhoria é a adição do CSRF e também a adição de uma lógica de fingerPrint do navegador do usuário que está consumindo a API, atualmente em casos de ataque de força ou a execução excessiva e repetitiva de requisições ocasiona no trancamento do IP do usuário por um breve intervalo de tempo. Porém com a melhoria dessa lógica e implantação de uma lógica de fingerPrint do navegador é possível bloquear diretamente o usuário sem correr risco de bloqueios em IP's falsos. Para projetos futuros é válido pensar nos pontos tirados deste projeto.

## Stack utilizada

**Back-end:** PHP 8.2 - CodeIgniter 4
