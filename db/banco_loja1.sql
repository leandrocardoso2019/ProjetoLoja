create database dbloja;
use dbloja;
create table usuario(
id int auto_increment primary key,
nomeusuario varchar (30) not null unique,
senha varchar (200) not null
)engine InnoDB;
create table contato(
id int auto_increment primary key,
telefone varchar(15) not null,
email varchar (100) not null unique
)engine InnoDB;
 create table endereco(
 id int auto_increment primary key,
 logradouro varchar (200) not null,
 numero varchar(10) not null,
 complemento varchar (20) not null,
 bairro varchar (50) not null,
 cep varchar (10) not null
 )engine InnoDB;
 
 create table cliente(
 id int auto_increment primary key,
 nome varchar (50) not null,
 cpf varchar (13) not null unique,
 id_endereco int not null,
 id_contato int not null,
 id_usuario int not null 
  )engine InnoDB;
  
  create table produto(
 id int auto_increment primary key,
  nome varchar (100) not null,
  descricao text not null,
  preco decimal (10,2) not null
 )engine InnoDB;
 
   create table estoque(
 id int auto_increment primary key,
id_produto int not null,
quantidade int not null,
alterado timestamp default current_timestamp()
)engine InnoDB;

create table pedido(
 id int auto_increment primary key,
id_cliente int not null,
data_pedido timestamp default current_timestamp()
)engine InnoDB;

create table detalhepedido(
id int auto_increment primary key,
id_pedido int not null,
id_produto int not null,
quantidade int not null
)engine InnoDB;

create table pagamento(
id int auto_increment primary key,
id_pedido int not null,
valor decimal (10,2) not null,
formapagamento varchar (20) not null,
descricao text not null,
numeroparcelas int not null,
valorparcela decimal (10,2) not null
)engine InnoDB;
use dbloja;
select * from usuario;

insert into usuario(nomeusuario, senha, foto)
values('admin',md5('123'),'imgusuario/admin.png');

select * from contato;

insert into contato(telefone,email)
values('11-5569-2235','admin@admin.com.br');


select * from endereco;

insert into endereco(logradouro, numero, complemento,bairro,cep)
values('Rua Nova','23','Casa dos fundos','Bairro de Lá','03566-270');


select * from cliente;

insert into cliente(nome,cpf,id_endereco,id_contato,id_usuario)
values('Afonso','11144477735',1,1,1);


select * from produto;

insert into produto(nome,descricao,preco,imagem1,imagem2,imagem3,imagem4)
values('mouse','mouse sem fio Microsoft', 100.90,'imgproduto/mouse1.png','imgproduto/mouse2.png','imgproduto/mouse3.png','imgproduto/mouse4.png');

select * from estoque;

insert into estoque(id_produto,quantidade)
values(1,10),(2,30);


select * from pedido;

insert into pedido(id_cliente) values(1);

select * from detalhepedido;

#Da tabela produto(nomeproduto, preco)
#Da tabela detalhepedido(quantidade)
#A amarração entre as tabelas será feita pelo campo
#id_produto
select d.id_pedido,p.nome, p.preco,d.quantidade, p.preco*d.quantidade 'total' 
from produto p inner join detalhepedido d on p.id = d.id_produto;

#Vamos realizar a soma da coluna total(quantidade do detalhepedido
#vezes o preco do produto) e para isso iremos usar o comando
#sum(soma). Para a função realizar esta operação, nós teremos
# de agrupar as linhas referentes a este pedido com todos
#os seus produto. Sendo assim iremos usar outro comando de 
#agrupamento chamado group by(agrupar por) e passar como 
#parametro o campo id_pedido.

select sum(p.preco*d.quantidade) 'Total a pagar' from 
produto p inner join detalhepedido d on p.id=d.id_produto 
group by d.id_pedido;



select sum(p.preco*d.quantidade) 'Total a pagar',
(sum(p.preco*d.quantidade))/5 'Valor da parcela' from 
produto p inner join detalhepedido d on p.id=d.id_produto 
group by d.id_pedido;



insert into detalhepedido(id_pedido,id_produto,quantidade)
values(1,1,3) , (1,2,2);




select * from pagamento;

insert into pagamento(id_pedido, valor,formapagamento,descricao, numeroparcelas,
valorparcela)
values(1,484.50,'Cartão de Crédito','N.141-Edilson',5,96);



select * from estoque;

select e.quantidade 'Estoque', d.quantidade 'Vendido', e.quantidade-d.quantidade 'Atual' 
from estoque e inner join produto p on p.id = e.id_produto 
inner join detalhepedido d on d.id_produto=p.id where d.id_produto=2;


select e.quantidade-d.quantidade 
from estoque e inner join produto p on p.id = e.id_produto 
inner join detalhepedido d on d.id_produto=p.id where d.id_produto=2;

update estoque
 set quantidade=quantidade-
 (select d.quantidade
from detalhepedido d where d.id_produto=2
)
where id_produto=2;

select * from estoque;

select * from detalhepedido;




  

 
 