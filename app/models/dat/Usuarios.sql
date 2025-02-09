-- tabla de usuarios
    CREATE TABLE IF NOT EXISTS Usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        login VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        rol TINYINT(1) NOT NULL  -- 0 = Usuario, 1 = Administrador
    );

    -- usuarios de ejemplo
    INSERT INTO Usuarios (login, password, rol) VALUES
    ('admin', '$2y$10$qOCIBWKXwZDNL3mLyp1qPOCcAsmqS1xJWGqeUKVqmhZWML8aT8yE', 1), -- admin
    ('user', '$2y$10$SFn1N96q8qo355Sbcd8LHu4k6cASKBOb3TeRFYYlAncbdBOQ6VGLm', 0); -- user