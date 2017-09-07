DROP TABLES tuturado_reunion_atendence,tuturado_student,tuturado_reunion,tuturado_tutor;
--drop table tuturado_tutor;
CREATE TABLE IF NOT EXISTS tuturado_tutor (
    istid VARCHAR(255) PRIMARY KEY NOT NULL,
    tutor_name VARCHAR(255)
);
--drop table tuturado_reunion;
CREATE TABLE IF NOT EXISTS  tuturado_reunion (
    reunion_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,

    responsible_tutor VARCHAR(255),
    FOREIGN KEY (responsible_tutor) REFERENCES tuturado_tutor (istid) ON DELETE RESTRICT ON UPDATE CASCADE,

    date VARCHAR(255),
    local VARCHAR(255),
    meio VARCHAR(255),

    extra_info TEXT,

    time_created DATETIME DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY (responsible_tutor,date,local,meio)
);
--drop table tuturado_student;
CREATE TABLE IF NOT EXISTS tuturado_student(
    istid VARCHAR(255) PRIMARY KEY NOT NULL,
    ist_number VARCHAR(255),
    name VARCHAR(255),


    email VARCHAR(255),
    telefone VARCHAR(255),
    other VARCHAR(255),

    preferencial_contact VARCHAR(255),
    entry_grade VARCHAR(255),
    deslocated BOOLEAN,
    entry_phase VARCHAR(255),
    option_number VARCHAR(255),
    entry_year VARCHAR(50),

    tutor_id VARCHAR(255),
    FOREIGN KEY (tutor_id) REFERENCES tuturado_tutor (istid) ON DELETE RESTRICT ON UPDATE CASCADE,

    extra_info TEXT

);
--drop table tuturado_reunion_atendence;
CREATE TABLE tuturado_reunion_atendence(
    reunion_atendence_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,

    reunion_id INT,
    FOREIGN KEY (reunion_id) REFERENCES tuturado_reunion (reunion_id) ON DELETE RESTRICT ON UPDATE CASCADE,

    student_id VARCHAR(255),
    FOREIGN KEY (student_id) REFERENCES tuturado_student (istid) ON DELETE RESTRICT ON UPDATE CASCADE,

    present BOOLEAN DEFAULT 0,

    extra_info TEXT,

    UNIQUE KEY (reunion_id,student_id)
);
-- source inserts_ist178865.sql;
