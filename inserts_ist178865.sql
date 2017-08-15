INSERT INTO tuturado_tutor VALUES ('ist178865');
INSERT INTO tuturado_tutor VALUES ('ist175741');


INSERT INTO tuturado_student (istid,name,ist_number,tutor_id) VALUES
('ist123451','Ze das Couves',2528,'ist178865'),
('ist123452','Ze das Couves',31819,'ist178865'),
('ist123453','Ze das Couves',10089,'ist178865'),
('ist123454','Ze das Couves',12755,'ist178865'),
('ist123455','Ze das Couves',28578,'ist178865'),
('ist123456','Ze das Couves',4546,'ist178865'),
('ist123457','Ze das Couves',19590,'ist178865'),
('ist123458','Ze das Couves',19160,'ist178865'),
('ist123459','Ze das Couves',17406,'ist178865'),
('ist123460','Ze das Couves',13039,'ist178865'),
('ist123461','Ze das Couves',16021,'ist175741'),
('ist123462','Ze das Couves',30870,'ist175741'),
('ist123463','Ze das Couves',2943,'ist175741'),
('ist123464','Ze das Couves',6684,'ist175741'),
('ist123465','Ze das Couves',24988,'ist175741'),
('ist123466','Ze das Couves',2988,'ist175741'),
('ist123467','Ze das Couves',8441,'ist175741'),
('ist123468','Ze das Couves',10539,'ist175741'),
('ist123469','Ze das Couves',4082,'ist175741'),
('ist123470','Ze das Couves',27940,'ist175741');

INSERT INTO tuturado_reunion VALUES
(1,'ist178865',now(),'IST_1','cenas maradas',''),
(2,'ist178865',now(),'IST_2','slack','Comentario geral existente'),
(3,'ist175741',now(),'IST_3','slack2','Comentario geral existente');

INSERT INTO tuturado_reunion_atendence (reunion_id,student_id,extra_info,present) VALUES
(3,'ist123461','holy great student!',1),
(3,'ist123462','holy avg student!',1),
(3,'ist123463','holy terrible student!',1),
(3,'ist123464','holy damn.. student!',1),
(3,'ist123465','Could not see him!',1),
(3,'ist123466','Could not see him!',1),
(3,'ist123467','',0),
(3,'ist123468','',0),
(3,'ist123469','',0),
(3,'ist123470','',0),
(2,'ist123451','holy great student!',1),
(2,'ist123452','holy avg student!',1),
(2,'ist123453','holy terrible student!',1),
(2,'ist123454','holy damn.. student!',1),
(2,'ist123455','Could not see him!',1),
(2,'ist123455','holy great student!',1),
(2,'ist123456','',1),
(2,'ist123457','',1),
(2,'ist123458','',1),
(2,'ist123459','',0);

INSERT INTO menu_item (name,options, component, view, menu_id, enable, access) VALUES
('Tutorado','','com_tutorados','students',1,1,1),
('Tutorado','','com_tutorados','meetings',1,0,1),
('Tutorado','','com_tutorados','addMeeting',1,0,1),
('Tutorado','','com_tutorados','detailedStudent',1,0,1);