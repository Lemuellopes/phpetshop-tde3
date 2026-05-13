# PHPet Shop (PHP POO + MVC + PDO)

Sistema didático de Pet Shop em PHP puro, com arquitetura MVC e PDO.

## Como rodar

1. Importe `database/petshop.sql` no MySQL (cria o BD `petshop` com tabelas e dados de exemplo).
2. Ajuste credenciais em `config/database.php` (host, user, pass).
3. Aponte o servidor (Apache/PHP built-in) para a pasta `public/`:
   ```
   php -S localhost:8000 -t public
   ```
4. Acesse: http://localhost:8000

## Login padrão

- **Admin:** admin@petshop.com / `admin123`
- **Cliente:** cadastre-se pela tela de cadastro.

## Estrutura

```
petshop/
├── app/
│   ├── controllers/   # AuthController, ServicoController, AgendamentoController, UsuarioController, DashboardController
│   ├── models/        # Usuario, Servico, Agendamento (CRUD com PDO)
│   └── views/         # Telas separadas por perfil (admin/cliente)
├── config/
│   └── database.php   # Classe Database (conexão PDO)
├── public/
│   ├── css/style.css  # Estilo simples
│   └── index.php      # Front Controller (mapa de ações)
└── database/
    └── petshop.sql    # Script SQL completo
```

## Como funciona

- **public/index.php** é a ÚNICA porta de entrada. Recebe `?action=xxx` e
  chama o controller/método correspondente (mapa de ações).
- **Models** encapsulam SQL com **prepared statements** (`PDO`).
- **Controllers** validam dados, chamam o model e carregam a view.
- **Views** apenas exibem HTML, recebendo variáveis dos controllers.
- **Auth** (em `index.php`) controla sessão e perfis (admin/cliente).
- Senhas usam `password_hash()` + `password_verify()`.

## Funcionalidades

- Login / logout / cadastro de cliente
- CRUD de Serviços (admin)
- CRUD de Usuários (admin)
- Agendamentos: cliente cria/edita/cancela os seus; admin vê todos com filtro por data
- Dashboard com totais
