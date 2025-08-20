
# Contábil - Sistema de Gestão

## Sobre o Projeto

**Contábil** é uma aplicação web desenvolvida em Laravel para gerenciamento contábil, utilizando os recursos e bibliotecas mais modernas para oferecer uma solução robusta e escalável.

---

## Requisitos do Sistema

- **PHP:** >= 8.2  
- **Composer:** 2.0 ou superior  
- **Banco de Dados:** MySQL

---

## Dependências do Projeto

### Principais Bibliotecas Usadas
- [**laravel/framework**](https://laravel.com/) (^11.9): Framework principal.
- [**barryvdh/laravel-dompdf**](https://github.com/barryvdh/laravel-dompdf) (^3.0): Para geração de PDFs.
- [**jeroennoten/laravel-adminlte**](https://github.com/JeroenNoten/Laravel-AdminLTE) (^3.14): Tema AdminLTE para painéis administrativos.
- [**spatie/laravel-permission**](https://github.com/spatie/laravel-permission) (^6.10): Gerenciamento de permissões e papéis de usuários.
- [**silviolleite/laravelpwa**](https://github.com/SilvioMoreto/laravel-pwa) (^2.0): Funcionalidade de Progressive Web App (PWA).
- [**wavey/sweetalert**](https://github.com/WaveyTeam/sweetalert): Notificações personalizadas usando SweetAlert.

### Dependências de Desenvolvimento
- **fakerphp/faker** (^1.23): Geração de dados fictícios para testes e seeds.  
- **laravel/sail** (^1.26): Ambiente de desenvolvimento simplificado com Docker.  
- **phpunit/phpunit** (^11.0.1): Framework para testes automatizados.  
- **laravel/pint** (^1.13): Ferramenta para formatação de código.

---

## Como Configurar e Executar

### Passo 1: Clonar o Repositório
```bash
git clone <URL_DO_REPOSITORIO>
cd contábil
```

### Passo 2: Instalar as Dependências
Certifique-se de que o Composer está instalado. Em seguida, execute:
```bash
composer install
```

### Passo 3: Configuração do Ambiente
Crie o arquivo `.env` copiando o exemplo:
```bash
cp .env.example .env
```
Edite o arquivo `.env` com as informações de sua base de dados, por exemplo:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u114975982_gestao_contabi
DB_USERNAME=u114975982_gestao_contabi
DB_PASSWORD=Benicio@2018
```

### Passo 4: Gerar a Chave da Aplicação
```bash
php artisan key:generate
```

### Passo 5: Rodar as Migrações
Configure o banco de dados e execute as migrações:
```bash
php artisan migrate
```

### Passo 6: Iniciar o Servidor
```bash
php artisan serve
```
Acesse em seu navegador: [http://localhost:8000](http://localhost:8000).

---

## Recursos Principais

1. **Autenticação e Autorizações**  
   Gerenciamento de usuários com permissões e papéis usando a biblioteca **spatie/laravel-permission**.

2. **Relatórios em PDF**  
   Geração de relatórios contábeis usando **laravel-dompdf**.

3. **Interface Personalizada**  
   Painel administrativo estilizado com **Laravel AdminLTE**.

4. **Progressive Web App (PWA)**  
   Compatível para acesso offline e instalação como aplicativo em dispositivos móveis usando **laravelpwa**.

5. **Notificações Dinâmicas**  
   Alertas interativos integrados com **SweetAlert**.

---

## Configurações Adicionais

### PWA
Certifique-se de configurar corretamente o manifesto e os service workers gerados pelo pacote **silviolleite/laravelpwa**. Isso permitirá que sua aplicação funcione offline e seja instalável.

### Configuração de Sessão
Por padrão, a sessão está configurada para ser armazenada no banco de dados:
```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
```
Execute as migrações para criar a tabela de sessões, caso necessário:
```bash
php artisan session:table
php artisan migrate
```

### Gerenciamento de Cache
O cache está configurado para ser armazenado no banco de dados:
```env
CACHE_STORE=database
CACHE_PREFIX=
```
Certifique-se de executar as migrações relacionadas ao cache, se aplicável.

---

## Comandos Úteis

- **Geração de PDF:**
  ```bash
  php artisan dompdf:publish
  ```
- **Limpeza do Cache da Aplicação:**
  ```bash
  php artisan cache:clear
  ```
- **Reaplicação de Migrações:**
  ```bash
  php artisan migrate:fresh --seed
  ```

---

## Licença

Este projeto está licenciado sob a **MIT License**. Veja o arquivo LICENSE para mais detalhes.

--- 

### Contato

Caso tenha dúvidas ou sugestões, entre em contato:
- **Email:** fsoftsistemas@gmail.com  
- **Telefone:** (87) 98175-3993
# Fox-imperium
