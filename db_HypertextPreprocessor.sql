create Database HypertextPreprocessor;

use HypertextPreprocessor;

create table login(
nome varchar(100),
senha varchar(100)
);

create table usuario(
id_usuario int not null auto_increment,
nome varchar(100),
email varchar(100),
senha varchar(100),
primary key (id_usuario)
);

create table produto(
id_produto int not null auto_increment,
nome varchar(100),
descricao varchar(100),
quantidade int(100),
valor decimal(10,2),
primary key (id_produto)
);

create table pedido(
id_pedido int not null auto_increment,
id_usuario int not null,
data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
status ENUM('pendente', 'pago', 'cancelado') DEFAULT 'pendente',
primary key(id_pedido),
FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario)
);

CREATE TABLE item_pedido (
id_item_pedido INT AUTO_INCREMENT,
pedido_id INT NOT NULL,
produto_id INT NOT NULL,
quantidade INT NOT NULL,
preco_unitario DECIMAL(10,2) NOT NULL,
preco_total DECIMAL(10,2) NOT NULL,
primary key (id_item_pedido),
FOREIGN KEY (pedido_id) REFERENCES pedido(id_pedido) ON DELETE CASCADE,
FOREIGN KEY (produto_id) REFERENCES produto(id_produto)
);

DELIMITER $$

CREATE TRIGGER before_insert_item_pedido
BEFORE INSERT ON item_pedido
FOR EACH ROW
BEGIN
DECLARE preco DECIMAL(10,2);


SELECT valor INTO preco FROM produto WHERE id_produto = NEW.produto_id;


SET NEW.preco_unitario = preco;


SET NEW.preco_total = NEW.quantidade * preco;
END $$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER after_insert_item_pedido
AFTER INSERT ON item_pedido
FOR EACH ROW
BEGIN
    
UPDATE produto 
SET quantidade = quantidade - NEW.quantidade
WHERE id_produto = NEW.produto_id;
END $$

DELIMITER ;


