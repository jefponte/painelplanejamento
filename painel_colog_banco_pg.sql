
CREATE TABLE usuario (
        id serial NOT NULL, 
        CONSTRAINT pk_usuario PRIMARY KEY (id), 
        nome character varying(400), 
        nivel integer
);
