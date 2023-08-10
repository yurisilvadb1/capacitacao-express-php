# Sobre

Projeto prático da Capacitação Express PHP - DB1. 

# Instalação

Acesse a pasta do projeto e efetue os passos seguintes:

**Instalando as dependências**
```
docker run --rm -v $(pwd):/app -w /app laravelsail/php81-composer:latest composer install
```

**Subindo os containers Docker:**
```
./vendor/bin/sail up -d
```

Com isso a aplicação já estará disponível em `http://localhost`.
Para o caso de fazer reset no banco de dados, basta acessar o container PHP da aplicação Laravel
e executar o comando das migrations:
```
docker exec -it <LARAVEL_PHP_CONTAINER_ID> bash

php artisan migrate:fresh
```

# Testes automatizados

Para fazer execução os testes automatizados com PHPUnit, utilize do seguinte comando:
```
./vendor/bin/phpunit
```

Adicione a flag `--coverage-html=coverage` para gerar o code coverage dos testes.
Estes estão disponíveis na pasta `coverage` gerada após execução do processo.

# Requisições HTTP

Para efetuar requisições HTTP nos endpoints da API, 
basta importar a [collection do Postman](Capacitacao_Express_PHP.postman_collection.json) disponível na raiz do projeto .
