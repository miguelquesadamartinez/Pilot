# Pilot none - Sistema de Gestión de Pedidos y Ticketing

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.1.9+-777BB4?style=flat&logo=php&logoColor=white" alt="PHP Version">
  <img src="https://img.shields.io/badge/Laravel-10.24.0-FF2D20?style=flat&logo=laravel&logoColor=white" alt="Laravel Version">
  <img src="https://img.shields.io/badge/Vite-4.0-646CFF?style=flat&logo=vite&logoColor=white" alt="Vite">
  <img src="https://img.shields.io/badge/TailwindCSS-3.1-38B2AC?style=flat&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
</p>

## 📋 Descripción

**Pilot** es una aplicación empresarial desarrollada en Laravel 10 que gestiona pedidos, ticketing, logística y recuperación de datos. El sistema integra múltiples bases de datos (PILOT, ECOMMERCE, ORDER_CONTROLLER, SAGE, COMMANDES) y servicios externos como GLS, Hermes FTP, Adare FTP, y sistemas de autenticación LDAP.

## 🌐 Entornos

- **Producción:** [http://pilot.none-services.fr/](http://pilot.none-services.fr/)
- **Desarrollo:** http://127.0.0.1:84/
- **Controller:** http://127.0.0.1:83

## 🚀 Características Principales

### Módulos Principales

1. **Sistema de Ticketing Multi-nivel**
    - Gestión de tickets con 5 niveles jerárquicos (Level A-E)
    - Categorización personalizada por tipo de cliente (Biogyne, etc.)
    - Estados personalizables (abierto/cerrado + estados adicionales)
    - Sistema de recordatorios y marcado de urgencia
    - Adjuntos de archivos y seguimiento de acciones
    - Dashboard con métricas de tickets (últimos 60 días/3 meses)

2. **Gestión de Pedidos (Orders)**
    - Integración con múltiples bases de datos de pedidos
    - Tracking de ítems de pedidos
    - Gestión de entregas y archivos de entrega
    - Sistema de disputas de pedidos con descuentos
    - Control de stock y productos faltantes

3. **Sistema de Scoring**
    - Scoring por laboratorio
    - Scoring por farmacia
    - Puntuaciones personalizadas por laboratorio
    - Posible integración futura con Recovery

4. **Recovery (Recuperación)**
    - Sistema de recuperación de datos
    - Integración con sistema de scoring

5. **Gestión de Grabaciones (Recordings)**
    - Indexación de grabaciones desde Hermes FTP
    - Búsqueda avanzada de grabaciones
    - Descarga de archivos desde servidores FTP

6. **Integración de Documentos**
    - Carga y gestión de archivos Proof
    - Integración con archivos SAGE
    - Gestión de facturas (SAGE y CMC)

7. **Sistema de Administración**
    - Gestión de usuarios con autenticación LDAP
    - Sistema de roles y permisos (Spatie Laravel Permission)
    - Control de acceso granular
    - Perfiles de usuario personalizables

8. **Data Loader**
    - Integración con SAGE
    - Integración con GLS (envíos y tracking)
    - Carga de datos de Proof

## 🛠️ Stack Tecnológico

### Backend

- **PHP:** ^8.1.9
- **Framework:** Laravel 10.24.0
- **Base de datos:** SQL Server (Microsoft SQL Server)
- **ORM:** Eloquent
- **Autenticación:** Laravel Breeze + LDAP (adldap2/adldap2-laravel)
- **Permisos:** Spatie Laravel Permission

### Frontend

- **Build Tool:** Vite 4.0
- **CSS Framework:** Tailwind CSS 3.1
- **JavaScript:** Alpine.js 3.4.2
- **HTTP Client:** Axios 1.1.2

### Librerías Principales

- **dompdf/dompdf:** Generación de PDFs
- **maatwebsite/excel:** Exportación/Importación de Excel
- **guzzlehttp/guzzle:** Cliente HTTP para APIs externas
- **simplesoftwareio/simple-qrcode:** Generación de códigos QR
- **league/flysystem-ftp:** Manejo de archivos FTP/SFTP

## 📦 Requisitos del Sistema

- PHP >= 8.1.9
- Composer
- Node.js y npm
- SQL Server
- Extensiones PHP:
    - PDO SQL Server
    - OpenSSL
    - LDAP
    - GD/Imagick
    - Mbstring
    - XML

## 🔧 Instalación

### 1. Clonar el repositorio

```bash
git clone <repository-url>
cd Pilot
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de Node.js

```bash
npm install
```

### 4. Configurar variables de entorno

```bash
cp .env.example .env
```

Editar `.env` con las configuraciones apropiadas:

- Configuración de bases de datos (LOCAL/PROD/DEV)
- Credenciales LDAP
- Configuración de email (Brevo)
- Configuración FTP (Hermes, Adare)
- Credenciales GLS
- Rutas de archivos

### 5. Generar clave de aplicación

```bash
php artisan key:generate
```

### 6. Ejecutar migraciones

```bash
php artisan migrate
```

### 7. Compilar assets

```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

### 8. Iniciar servidor de desarrollo

```bash
php artisan serve --port=84
```

## ⚙️ Configuración

### Bases de Datos

El sistema se conecta a múltiples bases de datos:

- **PILOT:** Base de datos principal
- **ECOMMERCE:** Datos de e-commerce
- **ORDER_CONTROLLER:** Control de pedidos
- **SAGE:** Sistema ERP SAGE
- **COMMANDES:** Base de datos de comandas

### Integraciones Externas

#### GLS (Gestión de Envíos)

- Tracking de paquetes
- Proof of delivery (POD)
- End of day reports
- Detalles de envío

#### Hermes FTP

- Descarga de grabaciones (V5/)
- Servidor: 172.20.0.79
- Retención de grabaciones: 7 días

#### Adare FTP

- Servidor Cloud: cloud.laphal.com
- Directorio: /adare/OUT/

#### LDAP

- Autenticación corporativa
- Sincronización de usuarios
- Dominio: noneroup.local

### Emails y Notificaciones

Sistema de emails configurado con Brevo (SMTP):

- Errores de aplicación
- Reportes
- Validaciones
- Tickets abiertos/cerrados
- Problemas por laboratorio (Theramex, Aginax, BNSante, Lifestyles, Havea)
- Notificaciones de logística y ventas

## 📁 Estructura del Proyecto

```
Pilot/
├── app/
│   ├── Console/          # Comandos Artisan
│   ├── Exceptions/       # Manejadores de excepciones
│   ├── Exports/          # Clases de exportación
│   ├── Helpers/          # Helpers personalizados
│   ├── Http/
│   │   ├── Controllers/  # Controladores
│   │   └── Middleware/   # Middleware
│   ├── Ldap/             # Configuración LDAP
│   ├── Mail/             # Clases de email
│   ├── Models/           # Modelos Eloquent
│   │   └── Ecommerce/    # Modelos de E-commerce
│   ├── Providers/        # Service Providers
│   └── View/             # View Composers
├── config/               # Archivos de configuración
├── CronJobs/             # Scripts batch para tareas programadas
├── database/
│   ├── migrations/       # Migraciones de BD
│   ├── seeders/          # Seeders
│   └── factories/        # Factories
├── lang/                 # Traducciones (en, es, fr, pt)
├── public/               # Archivos públicos
├── resources/
│   ├── css/              # Estilos
│   ├── js/               # JavaScript
│   └── views/            # Vistas Blade
├── routes/               # Definición de rutas
│   ├── web.php           # Rutas web
│   ├── api.php           # Rutas API
│   └── auth.php          # Rutas de autenticación
├── storage/              # Almacenamiento
└── tests/                # Tests
```

## 🔄 Tareas Programadas (CronJobs)

El sistema incluye múltiples tareas batch ejecutables:

- `adare.bat` - Procesamiento de archivos Adare
- `cmc.bat` - Integración CMC
- `commandes.bat` - Sincronización de comandas
- `delete_tmp.bat` - Limpieza de archivos temporales
- `ecommerce.bat` / `ecommerce-clients.bat` - Sincronización E-commerce
- `hermes.bat` - Descarga de grabaciones Hermes
- `index-recordings.bat` - Indexación de grabaciones
- `ldap.bat` - Sincronización LDAP
- `product-discounts.bat` - Actualización de descuentos
- `proof.bat` - Procesamiento de pruebas
- `sage.bat` - Sincronización SAGE
- `send-customer-accepts-mail.bat` - Envío de confirmaciones

## 🔐 Roles y Permisos

Sistema basado en roles con los siguientes roles principales:

- **SuperAdmin:** Acceso completo al sistema
- **Admin:** Gestión de usuarios y configuración
- **IT:** Soporte técnico y mantenimiento
- **DataLoader:** Carga de datos
- **Searcher:** Búsqueda de información
- **Supervisor:** Supervisión de tickets

Los permisos son granulares y se pueden asignar individualmente a roles.

## 🌍 Internacionalización

Soporta 4 idiomas:

- 🇬🇧 Inglés (en)
- 🇪🇸 Español (es)
- 🇫🇷 Francés (fr)
- 🇵🇹 Portugués (pt)

Zona horaria: Europe/Paris

## 📊 Dashboard y Métricas

- Alertas de tickets antiguos (configurables)
- Métricas de últimos 60 días por defecto
- Vista de 3 meses para análisis histórico
- Límite de resultados de consultas: 250 registros

## 🐛 Problemas Conocidos

1. **Búsqueda por CIP:** Puede aparecer farmacia con pedidos de otra (ID 2138151)
2. **Espacios en IDs:** Los IDs de productos en `order_items` contienen espacios (heredado de DB COMMANDES)
3. **FTP Offline:** Las descargas de grabaciones pueden fallar si el FTP está offline (posiblemente resuelto)

## 📝 Notas Técnicas

### Sistema de Ticketing

- **ticket_type** (DB) = **Category** (Vista) - Solo para Biogyne
- **category** (DB) = **Status** (Vista)
- **status_id** (DB) = **Level 0** (Vista) - 1000 = abierto, 0 = cerrado
- **level_a_id** (DB) = **Level 1** (Vista) - Niveles originales

### Configuraciones Importantes

- `MAX_EXECUTION_TIME`: 1200 segundos
- `SESSION_LIFETIME`: 1440 minutos (24 horas)
- `QUERY_LIMIT_RESULT`: 250 registros
- `TICKETING_DAYS_FOR_ALERT`: 2 días
- `GET_ORDERS_FROM_DAYS`: 1 día
- `GET_ORDERS_FROM_DAYS_HERMES`: 7 días

## 🚧 Desarrollo Futuro

### Ideas Pendientes

- Mezclar Pilot Scoring con Pilot Recovery
- Mejoras en el sistema de recordatorios
- Optimización de búsquedas
- Mejoras en el dashboard de supervisión

---

**Última actualización:** Enero 2026
**Versión del sistema:** 2.0

### Cron Jobs

- **[Orders from Ecommerce](http://pilot.none-services.fr/get-orders-from-ecommerce)**
  http://pilot.none-services.fr/get-orders-from-ecommerce
- **[Update Orders status from Sage](http://pilot.plateformeos.fr/get-orders-from-sage)**
  http://pilot.none-services.fr/get-orders-from-sage
- **[Hermes Recording](pilot.none-services.fr/get-recordings-from-hermes)**
  http://pilot.none-services.fr/get-recordings-from-hermes
- **[Orders from Commandes](http://pilot.none-services.fr/get-orders-from-comandes)**
  http://pilot.none-services.fr/get-orders-from-comandes
- **[Orders from CMC](http://pilot.none-services.fr/get-orders-from-cmc)**
  http://pilot.none-services.fr/get-orders-from-cmc
- **[Parse the pdf´s at the folder, for adding to order](http://pilot.none-services.fr/get-proof-of-delivery)**
  http://pilot.none-services.fr/get-proof-of-delivery
- **[Delete temporary downloaded recordings](http://pilot.none-services.fr/delete-temp-recordings)**
  http://pilot.none-services.fr/delete-temp-recordings
- **[LDAP sync](http://pilot.none-services.fr/ldapSynchronization)**
  http://pilot.none-services.fr/ldapSynchronization

### WebService

- **[Score data from Pilot](http://pilot.none-services.fr/scoring/get-score/{pharmacy_id})**
  http://pilot.none-services.fr/scoring/get-score/{pharmacy_id}

### Seeders

php artisan db:seed --class=Initial

php artisan db:seed --class=CategoriesAndStatus_LAST

### Seeders - Not needed now

php artisan db:seed --class=LanguagesSeeder

### Old Seeders - Not use

php artisan db:seed --class=CategoriesAndStatusAll

php artisan db:seed --class=CategoriesAndStatus

php artisan db:seed --class=LevelsSeeder

php artisan db:seed --class=LevelsSeeder_2

php artisan db:seed --class=LevelsSeeder_3

php artisan db:seed --class=LevelsSeeder_4

php artisan db:seed --class=LevelsSeeder_5

php artisan db:seed --class=LevelsSeeder_6

### Install

composer update --ignore-platform-reqs

### FTP

composer require league/flysystem-ftp "^3.0"

### SFTP

composer require league/flysystem-sftp-v3 --ignore-platform-reqs

### LDAP

composer require adldap2/adldap2

php artisan migrate:refresh --path=/database/migrations/2014_10_12_000000_create_users_table.php

### QRcode

composer require simplesoftwareio/simple-qrcode

composer require dompdf/dompdf

#### Download php imagick extension, depending on PhP version, thread safety and architecture at:

https://mlocati.github.io/articles/php-windows-imagick.html

1. Extract from php_imagick-….zip the php_imagick.dll file, and save it to the ext directory of your PHP installation
2. Extract from php_imagick-….zip the other DLL files (they may start with CORE_RL, FILTER, IM_MOD_RL, or ImageMagickObject depending on the version), and save them to the PHP root directory (where you have php.exe), or to a directory in your PATH variable
3. Add this line to your php.ini file:
   extension=imagick

# Vendor code modification

## Role model

### Path: Pilot\vendor\spatie\laravel-permission\src\Models\Role.php

### add:

```php
    public $timestamps = false;
```

### Excel

composer require phpoffice/phpspreadsheet

### Excel Wrong

composer require maatwebsite/excel --ignore-platform-reqs

composer remove maatwebsite/excel --ignore-platform-reqs

### php.ini

enable: extension=zip
