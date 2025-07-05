------------------------Usuarios--------------------------------------

CREATE TABLE usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,  -- ID único, numérico e crescente
    nome VARCHAR(100) NOT NULL,                  -- Nome obrigatório, até 100 caracteres
    email VARCHAR(255) NOT NULL UNIQUE,          -- Email obrigatório e único
    senha VARCHAR(100) NOT NULL                  -- Senha obrigatória
    funcao VARCHAR(50) NOT NULL,                 -- Função obrigatória (ex: gerente, caixa, etc.)
    foto VARCHAR(255)                            -- Caminho da foto, opcional
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
