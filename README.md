# BanquitoBank

Sistema bancario desarrollado en PHP con PostgreSQL.

## Requisitos

- PHP 8+
- PostgreSQL 16
- XAMPP o servidor Apache

## Instalación

1. Clona el repositorio
2. Copia `db.example.php` como `db.php` y completa tus datos
3. Crea la base de datos en PostgreSQL:

```sql
CREATE DATABASE banquitobank;
```

4. Ejecuta el siguiente script para crear las tablas:

```sql
CREATE TABLE usuarios (
    id        SERIAL PRIMARY KEY,
    usuario   VARCHAR(50) UNIQUE NOT NULL,
    password  VARCHAR(255) NOT NULL,
    nombre    VARCHAR(100) NOT NULL,
    tipo      INTEGER NOT NULL DEFAULT 2,
    saldo     NUMERIC(14,2) NOT NULL DEFAULT 0.00
);

CREATE TABLE transacciones (
    id            SERIAL PRIMARY KEY,
    usuario_id    INTEGER NOT NULL REFERENCES usuarios(id),
    tipo          VARCHAR(10) NOT NULL CHECK (tipo IN ('deposito', 'retiro')),
    monto         NUMERIC(14,2) NOT NULL CHECK (monto > 0),
    saldo_antes   NUMERIC(14,2) NOT NULL,
    saldo_despues NUMERIC(14,2) NOT NULL,
    fecha         TIMESTAMP NOT NULL DEFAULT now()
);
```

5. Inserta el usuario admin:

```sql
INSERT INTO usuarios (usuario, password, nombre, tipo, saldo)
VALUES ('admin', '123', 'User Admin', 1, 0.00);
```

## Tecnologías

- PHP 8
- PostgreSQL 16
- Tailwind CSS
- PDO
