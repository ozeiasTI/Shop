------------------------Usuarios--------------------------------------
CREATE TABLE usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,         -- ID único, numérico e crescente
    nome VARCHAR(100) NOT NULL,                         -- Nome obrigatório, até 100 caracteres
    email VARCHAR(255) NOT NULL UNIQUE,                 -- Email obrigatório e único
    senha VARCHAR(100) NOT NULL,                        -- Senha obrigatória
    funcao VARCHAR(50) NOT NULL,                        -- Função obrigatória (ex: gerente, caixa, etc.)
    cpf VARCHAR(14) UNIQUE,                             -- CPF único, formato: 000.000.000-00
    data_nascimento VARCHAR(12),                        -- Data de nascimento, formato: DD/MM/AAAA
    endereco VARCHAR(255),                              -- Endereço completo, opcional
    foto VARCHAR(255),                                  -- Caminho da foto, opcional
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Data de cadastro, padrão é o momento              
    telefone VARCHAR(255),                              -- Caminho da foto, opcional
    ativo VARCHAR(5) DEFAULT 'SIM'                        -- Indica se o usuário está ativo (padrão é TRUE)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

------------------------Empresa------------------------------------------
CREATE TABLE empresa(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(50) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    cnpj VARCHAR(25) NOT NULL,
    logo VARCHAR(255)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
