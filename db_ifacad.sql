create database db_ifacad;

use db_ifacad;

create table tb_cursos(
	c_id int not null primary key auto_increment,
    c_nome varchar (100)
);

create table tb_user(
	u_id int not null primary key auto_increment,
    u_nome VARCHAR(100),
    u_email VARCHAR(50),
    u_senha VARCHAR(100),
    u_user boolean
);

create table tb_professores(
	p_id int not null primary key auto_increment,
    p_ciap varchar (15),
    p_block boolean,
    u_id  int,
    FOREIGN KEY (u_id) REFERENCES tb_user (u_id)
);

create table tb_administradores(
	ad_id int not null primary key auto_increment,
    u_id  int,
    FOREIGN KEY (u_id) REFERENCES tb_user (u_id)
);


create table tb_academicos(
	ac_id int not null primary key auto_increment,
    ac_nome varchar (100),
    ac_ra varchar (10),
    ac_curso int,
    FOREIGN KEY (ac_curso) REFERENCES tb_cursos(c_id)
);

create table tb_trabalhos(
	t_id int not null primary key auto_increment,
    t_titulo varchar(300),
	t_data_def date,
    t_palavra_c varchar (150),
    t_banca text,
    t_resumo text,
    t_citar text,
    t_idioma varchar (2),
    t_doc varchar (200),
    t_tipo varchar (50),
    t_acad int,
    t_acad2 varchar (150),
    t_prof int,
    FOREIGN KEY (t_acad) REFERENCES tb_academicos(ac_id),
    FOREIGN KEY (t_prof) REFERENCES tb_professores(p_id)
);

SELECT t.t_titulo, a.ac_nome, t.t_data_def, tb_cursos.c_nome as nome_curso 
FROM tb_trabalhos t
LEFT JOIN tb_academicos a ON t.t_acad = a.ac_id
LEFT JOIN tb_professores p ON t.t_prof = p.p_id
INNER JOIN tb_cursos ON a.ac_curso = tb_cursos.c_id
WHERE t.t_prof = 26;


SELECT tb_trabalhos.t_id, tb_trabalhos.t_titulo, tb_academicos.ac_nome, tb_trabalhos.t_data_def, tb_cursos.c_nome as nome_curso, tb_trabalhos.t_doc
          FROM tb_trabalhos 
          INNER JOIN tb_academicos ON tb_trabalhos.t_acad = tb_academicos.ac_id
          INNER JOIN tb_cursos ON tb_academicos.ac_curso = tb_cursos.c_id
          ORDER BY tb_trabalhos.t_id DESC
          LIMIT 3;


INSERT INTO tb_trabalhos (t_titulo, t_data_def, t_palavra_c, t_banca, t_resumo, t_citar, t_idioma, t_tipo, t_acad, t_prof) VALUES
('ADOÇÃO DE AUTOMAÇÃO DE TESTES NO DESENVOLVIDO MÓVEL EM FLUTTER: UM PROCESSO PARA GARANTIR QUALIDADE E INTEGRIDADE DO CÓDIGO', '2021-11-11', 'Aplicativo, Flutter, Mobile, Automação de Teste, Widget, Integridade', 'Fábiana de Castro, Julia Pereira Gomes, Bruno Gomes de Souza', 'A crescente demanda por novos aplicativos aumenta a cada dia pelos consumidores. O conceito 80/20 nas soluções digitais aliada ao mobile first tem despertado o interesse em melhor interface e experiência do usuário para este segmento de mercado. O presente trabalho tem como objetivo realizar testes de renderização de Widgets para verificar o funcionamento do código de componentes, sua resposta a interações, e seu comportamento visual em um aplicativo desenvolvido em Flutter. Levando em consideração os objetivos e relevância de teste aplicado ao contexto do cenário pretendido, visto que correspondam ou não à resposta para qual foram aplicados. Capturando todas exceções registradas com feedback ágil assegurando reduzir esforços de teste manuais em ambientes de constante evolução ou mudança. Este trabalho propôs o uso de elementos essenciais de acordo com os requisitos do negócio, software e compõem as etapas de planejamento, implementação, execução do projeto e avaliação dos critérios de saída dos processos anteriores. Como resultados, as variáveis do objeto de estudo consistiram em simular interação, comportamento e dados no teste, sem alterar o modelo ou interface do aplicativo, a fim de se obter a garantia do funcionamento de comportamento nos cenários possíveis de aceitação e falha de testes e análise das saídas nos resultados encontrados. Assim é válido ressaltar o potencial uso e extensão desta pesquisa como ferramenta de trabalho para outros projetos, este não discutiu problemas da simulação, análise de performance e desempenho em ambiente de testes local, trabalhos futuros podem avaliar e diagnosticar.', 'Oliveira, Carlos. ADOÇÃO DE AUTOMAÇÃO DE TESTES NO DESENVOLVIDO MÓVEL EM FLUTTER: UM PROCESSO PARA GARANTIR QUALIDADE E INTEGRIDADE DO CÓDIGO. 2023. Trabalho de Conclusão de Curso (Bacharelado em Sistemas de Informação). Instituto Federal do Paraná, Palmas, Paraná, 2023. Disponível em: <http://repositorioif/bibliotecadigital/publico/home/documento/2286>. Acesso em: 15 set. 2023', 'PT', 'TRABALHO DE CONCLUSÃO DE CURSO', 5, 6);

SELECT tb_trabalhos.t_titulo, tb_trabalhos.t_data_def, tb_trabalhos.t_palavra_c, tb_trabalhos.t_banca, tb_trabalhos.t_resumo, tb_trabalhos.t_citar, tb_trabalhos.t_idioma, tb_trabalhos.t_doc, tb_trabalhos.t_tipo, tb_academicos.ac_nome, tb_trabalhos.t_prof
                FROM tb_trabalhos 
                INNER JOIN tb_academicos ON tb_trabalhos.t_acad = tb_academicos.ac_id
                INNER JOIN tb_professores ON tb_trabalhos.t_prof = tb_professores.p_id;

SELECT 
    tb_trabalhos.t_titulo,
    tb_academicos.ac_nome,
    tb_cursos.c_nome as nome_curso,
    tb_trabalhos.t_data_def,
    tb_trabalhos.t_doc
FROM 
    tb_trabalhos
INNER JOIN 
    tb_academicos ON tb_trabalhos.t_acad = tb_academicos.ac_id
INNER JOIN 
    tb_professores ON tb_trabalhos.t_prof = tb_professores.p_id
INNER JOIN 
    tb_cursos ON tb_academicos.ac_curso = tb_cursos.c_id;

SELECT tb_academicos.ac_id, tb_academicos.ac_nome, tb_cursos.c_nome FROM tb_academicos
INNER JOIN 
    tb_cursos ON tb_academicos.ac_curso = tb_cursos.c_id;


SELECT tb_professores.p_id, tb_user.u_nome, tb_user.u_email, tb_user.u_senha, tb_user.u_user, tb_professores.p_ciap, tb_professores.p_block 
FROM tb_user 
INNER JOIN tb_professores ON tb_user.u_id = tb_professores.u_id;

SELECT tb_professores.p_id, tb_user.u_nome, tb_user.u_email, tb_professores.p_ciap
FROM tb_user 
INNER JOIN tb_professores ON tb_user.u_id = tb_professores.u_id;

select * from tb_trabalhos;

insert tb_user (u_nome, u_email , u_senha, u_user)
VALUES ('Administrador IFAcad', 'adm_ifacad@gmail.com','admifacad123',true);


insert tb_administradores (u_id)
VALUES (1);

SELECT tb_administradores.ad_id, tb_administradores.u_id, tb_user.u_nome, tb_user.u_email,  tb_user.u_user 
FROM tb_user 
INNER JOIN tb_administradores ON tb_user.u_id = tb_administradores.u_id;


SELECT tb_academicos.ac_id, tb_academicos.ac_nome, tb_academicos.ac_ra, tb_cursos.c_nome
FROM tb_academicos 
INNER JOIN tb_cursos ON tb_academicos.ac_curso = tb_cursos.c_id;


INSERT INTO tb_user (u_nome, u_email, u_senha, u_user) VALUES
('João Silva', 'joao.silva@email.com', 'senha1', false),
('Maria Santos', 'maria.santos@email.com', 'senha2', false),
('Carlos Oliveira', 'carlos.oliveira@email.com', 'senha3', false),
('Ana Pereira', 'ana.pereira@email.com', 'senha4', false),
('Ricardo Martins', 'ricardo.martins@email.com', 'senha5', false),
('Fernanda Lima', 'fernanda.lima@email.com', 'senha6', false),
('Lucas Rocha', 'lucas.rocha@email.com', 'senha7', false),
('Juliana Almeida', 'juliana.almeida@email.com', 'senha8', false),
('Pedro Costa', 'pedro.costa@email.com', 'senha9', false),
('Amanda Oliveira', 'amanda.oliveira@email.com', 'senha10', false),
('Gabriel Pereira', 'gabriel.pereira@email.com', 'senha41', false),
('Mariana Santos', 'mariana.santos@email.com', 'senha42', false),
('José Lima', 'jose.lima@email.com', 'senha43', false),
('Isabela Martins', 'isabela.martins@email.com', 'senha44', false),
('Anderson Silva', 'anderson.silva@email.com', 'senha45', false),
('Camila Costa', 'camila.costa@email.com', 'senha46', false),
('Bruno Oliveira', 'bruno.oliveira@email.com', 'senha47', false),
('Carla Pereira', 'carla.pereira@email.com', 'senha48', false),
('Roberto Lima', 'roberto.lima@email.com', 'senha49', false),
('Beatriz Costa', 'beatriz.costa@email.com', 'senha50', false);

INSERT INTO tb_professores (p_ciap, p_block, u_id) VALUES
	('612375', false, 2),
    ('12345', false, 3),
    ('67890', true, 4),
    ('54321', false, 5),
    ('98765', true, 6),
    ('11223', false, 7),
    ('44556', true, 8),
    ('77889', false, 9),
    ('99000', true, 10),
    ('33322', false, 11),
    ('44455', true, 12),
    ('66677', false, 13),
    ('88899', true, 14),
    ('10101', false, 15),
    ('20202', true, 16),
    ('30303', false, 17),
    ('40404', true, 18),
    ('50505', false, 19),
    ('60606', true, 20),
    ('70707', false, 21);

    INSERT INTO tb_academicos (ac_nome, ac_ra, ac_curso) VALUES
    ('Lucas Silva', 'RA12345', 5),
    ('Mariana Oliveira', 'RA67890',2),
    ('Gabriel Santos', 'RA54321', 10),
    ('Juliana Costa', 'RA98765', 4),
    ('Rafael Pereira', 'RA11223', 17),
    ('Amanda Lima', 'RA44556', 16),
    ('Diego Martins', 'RA77889', 15),
    ('Fernanda Souza', 'RA99000', 9),
    ('Matheus Oliveira', 'RA33322', 12),
    ('Carolina Santos', 'RA44455', 13),
    ('Thiago Silva', 'RA66677', 14),
    ('Larissa Pereira', 'RA88899', 15),
    ('Luciana Costa', 'RA10101', 16),
    ('Renato Lima', 'RA20202', 17),
    ('Fernanda Oliveira', 'RA30303', 10),
    ('Felipe Santos', 'RA40404', 9),
    ('Priscila Souza', 'RA50505', 14),
    ('Vinícius Lima', 'RA60606', 14),
    ('Camila Pereira', 'RA70707', 15),
    ('Gustavo Costa', 'RA80808', 5),
    ('Isabela Oliveira', 'RA90909', 9),
    ('Anderson Silva', 'RA11111', 4),
    ('Patrícia Lima', 'RA22222', 13),
    ('Roberto Santos', 'RA33333', 12),
    ('Daniela Oliveira', 'RA44444', 11),
    ('Alexandre Costa', 'RA55555', 5),
    ('Cláudia Pereira', 'RA66666', 2),
    ('Guilherme Lima', 'RA77777', 12),
    ('Aline Santos', 'RA88888', 13),
    ('José Oliveira', 'RA99999', 17),
    ('Bianca Costa', 'RA101010', 16),
    ('Felipe Pereira', 'RA111111', 5),
    ('Luana Lima', 'RA121212', 4),
    ('Ricardo Santos', 'RA131313', 4),
    ('Beatriz Oliveira', 'RA141414', 2),
    ('Lucas Costa', 'RA151515', 2),
    ('Larissa Santos', 'RA161616', 4),
    ('Renato Oliveira', 'RA171717', 17);
    
   
SELECT 
    tb_trabalhos.t_titulo,
    tb_trabalhos.t_tipo,
    tb_academicos.ac_nome as t_acad,
    tb_trabalhos.t_palavra_c,
    tb_trabalhos.t_data_def,
    tb_user.u_nome as t_prof,
    tb_trabalhos.t_banca,
    tb_cursos.c_nome,
    tb_trabalhos.t_doc,
    tb_trabalhos.t_resumo,
    tb_trabalhos.t_idioma,
    tb_trabalhos.t_citar
FROM 
    tb_trabalhos
INNER JOIN 
    tb_academicos ON tb_trabalhos.t_acad = tb_academicos.ac_id
INNER JOIN 
    tb_user ON tb_trabalhos.t_prof = tb_user.u_id
INNER JOIN 
    tb_cursos ON tb_academicos.ac_curso = tb_cursos.c_id;

SELECT 
     tb_trabalhos.t_titulo,
    tb_trabalhos.t_tipo,
    tb_academicos.ac_nome as t_acad,
    tb_trabalhos.t_palavra_c,
    tb_trabalhos.t_data_def,
    tb_user.u_nome as t_prof_nome,
    tb_trabalhos.t_banca,
    tb_cursos.c_nome as nome_curso,
    tb_trabalhos.t_doc,
    tb_trabalhos.t_resumo,
    tb_trabalhos.t_idioma,
    tb_trabalhos.t_citar
FROM 
    tb_trabalhos
INNER JOIN 
    tb_academicos ON tb_trabalhos.t_acad = tb_academicos.ac_id
INNER JOIN 
    tb_professores ON tb_trabalhos.t_prof = tb_professores.p_id
INNER JOIN 
    tb_user ON tb_professores.u_id = tb_user.u_id
INNER JOIN 
    tb_cursos ON tb_academicos.ac_curso = tb_cursos.c_id;
