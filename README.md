
# Projeto LaravelControlAFC

Esse pequeno projeto gerencia funcionários e clientes onde o administrador tem acesso total ao CRUD do projeto via API.

Utilizando Laravel + sanctum


#### criar o banco de dados e configurar o mesmo em .env 

#### Utilizar os comandos

# php artisan migrate
# php artisan db:seed
# php artisan serve

Os dados principais são:

- Administrador
	E-mail: admin@admin.com
	Senha: password
- Funcionario
	E-mail: funcionario@funcionario.com
	Senha: password
- Cliente
	E-mail: cliente@cliente.com
	Senha: password




Geralmente a URL e PORTA é "http://127.0.0.1:8000"





{{url_base}} = 127.0.0.1:8000/api
{{token}} - token gerado



## Documentação da API

#### Login que gera token de acesso

```http
  POST {{url_base}}/login [email e password]
```


| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `email` | `string` | **Obrigatório**. |
| `password` | `string` | **Obrigatório**. |

####  retorno
{'access_token' => $token,
'token_type' => 'Bearer' }



#### Rotas do Administrador

```http
  GET /admin
  GET /admin/${id}
  POST /admin/${id}
  PUT /admin/${id}

 ## funcionários
  GET /admin/funcionarios
  GET /admin/funcionario/{id}
  POST /admin/funcionario
  PUT /admin/funcionario/{id}
  DELETE /admin/funcionario/{id}


  ## clientes
    GET /admin/funcionario/{id}/clientes
    GET /admin/funcionario/{id}/cliente/{client_id}
    POST /admin/funcionario/{id}/cliente
    PUT /admin/funcionario/{id}/cliente/{client_id}
    DELETE /admin/funcionario/{id}/cliente/{client_id}
```


#### Rotas do Funcionário

```http
  GET /funcionario/
  PUT /funcionario/

 GET /funcionario/clientes
 GET /funcionario/cliente/{client_id}
 POST /funcionario/cliente
 PUT /funcionario/cliente/{client_id}
 DELETE /funcionario/cliente/{client_id}
```


#### Rotas do Clientes

```http
  GET /cliente/
  PUT /cliente/
```




<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
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

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Autores

- leonardo alves da silva [https://github.com/leeooallves]
- mariana lacerda borges [https://github.com/MarianaLacerda013]
