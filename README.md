<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Sobre o Projeto

<h1>Desafio Técnico</h1>

Um projeto que utiliza requisições de API e banco de dados.

<h3>Prequisitos</h3>

- Composer (https://getcomposer.org/).
- Framework Laravel.
- SGBD que utilize mySQL.

<h3>Observações</h3>

- Para mudar as configurações da conexão com o banco de dados, mude as propriedades da conexão no arquivo .env.
- Para realizar as migrations, execute "php artisan migrate".
- Para ativar o servidor, execute "php artisan serve".
- Para reiniciar o banco de dados, execute "php artisan migrate:reset" e em seguida "php artisan migrate". Depois disso, "php artisan serve" para ativar o servidor novamente.
- A dependência "Guzzle" foi incluida através de instalação pelo composer no projeto (composer require guzzlehttp/guzzle), porém não foi utilizada.
- É importante o consumo da API ("127.0.0.1:8000/api/popular") ocorrer somente uma vez por execução das migrations, para evitar dados duplicados no banco de dados. "127.0.0.1:8000/api/ranking" e "127.0.0.1:8000/api/reembolso" podem ser acessados quantas vezes quiser. Caso o consumo não ocorra corretamente, execute "php artisan migrate:reset" e em seguida "php artisan migrate". Depois disso, "php artisan serve" para ativar o servidor novamente.

<h3>Execução</h3>

- Crie o banco de dados definido no arquivo .env (por padrão, "desafiotecnico_laravel").
- Execute as migrations para criar as tabelas (php artisan migrate).
- Inicie o servidor (php artisan serve).
- Acesse "127.0.0.1:8000/api/popular", para consumir dados da API e armazenar no banco de dados. Caso o consumo não ocorra corretamente, execute "php artisan migrate:reset" e em seguida "php artisan migrate". Depois disso, "php artisan serve" para ativar o servidor novamente.
- Após a execução do script, vá para "127.0.0.1:8000/api/ranking" para fazer a requisição do ranking das redes
sociais mais utilizadas dentre os deputados em ordem decrescente, e para "127.0.0.1:8000/api/reembolso" para
mostrar os top 5 deputados que mais pediram reembolso de verbas indenizatórias registradas no banco de dados.

<h3>Rotas</h3>

- "127.0.0.1:8000/api/popular": consumir dados da API.
- "127.0.0.1:8000/api/ranking": obter o ranking das redes sociais mais utilizadas dentre os deputados.
- "127.0.0.1:8000/api/reembolso": obter os top 5 deputados que mais pediram reembolso de verbas indenizatórias.

<h3>Importante</h3>

- Por padrão, com o consumo correto da API, o banco terá 77 itens na tabela "deputados" e 222 itens na tabela "rede_socials".
- Por padrão, o script consumirá dados do mês 4 para cada candidato (haverá 389 itens na tabela "verba_indenizatorias" caso o script execute com sucesso). Para mudar o mês que o script usará para buscar
informações na API, mude o parâmetro da função da linha 160 do arquivo "app/Http/Controllers/PopulateController.php".
- Para cada mês existente na lista de meses da linha 160 do arquivo "app/Http/Controllers/PopulateController.php", serão feitas 77 requisições de API simultâneas, e caso essa lista seja muito grande (mais que 1 mês), haverá a chance do script falhar, pois devido ao número de requisições, a API pode rejeitar as requisições e prejudicar o funcionamento do sistema inteiro. Em meus testes, 1 mês obteve 60% de chance de sucesso e o tempo médio de resposta foi 5.8 segundos. Com mais de 1 mês, 100% das vezes as requisições foram rejeitadas.
- O objetivo era pegar informações dos 77 deputados nos 12 meses do ano, porém as requisições sempre acabavam
rejeitadas, devido ao fato de serem 924 (77 * 12) requisições simultâneas à API. O único jeito que achei para resolver este problema foi limitar a quantidade de meses a serem verificados.
- Caso os dados não sejam consumidos corretamente, execute "php artisan migrate:reset" e em seguida "php artisan migrate". Depois disso, "php artisan serve" para ativar o servidor novamente.

Autor: Lucas Vinícius.<br>
Dados Abertos ALMG: http://dadosabertos.almg.gov.br/ws/ajuda/sobre.<br>
Link para obter lista de deputados: https://dadosabertos.almg.gov.br/ws/deputados/ajuda#Lista%20Telef%C3%B4nica%20de%20Deputados.<br>
Link para obter informações de verbas: https://dadosabertos.almg.gov.br/ws/prestacao_contas/verbas_indenizatorias/ajuda#Lista%20de%20Datas%20de%20Verbas%20Indenizat%C3%B3rias%20de%20um%20Deputado%20na%20legislatura%20atual.<br>
Link para obter Composer: https://getcomposer.org/.<br>
fevereiro de 2020.

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

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)
- [Appoly](https://www.appoly.co.uk)
- [OP.GG](https://op.gg)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
