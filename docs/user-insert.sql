/*
-- Query: SELECT * FROM homestead.Person
LIMIT 0, 1000

-- Date: 2017-05-23 23:06
*/
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (1,'Tadej','Pečar','041251879','Slovenska cesta 1',1000,NULL);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (2,'Aljaž','Markežič','051387921','Metelkova ulica 9',1000,NULL);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (3,'Adam','Prestor','031264392','Metelkova ulica 9',1000,NULL);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (4,'Lara','Avsec','041852741','Metelkova ulica 9',1000,47207);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (5,'Vida','Jelenc','031963258','Kržičeva ulica 10',1000,58492);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (6,'Mateja','Suhadolc','041741258','Derčeva 5',1000,13169);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (7,'Rožle','Potočnik','031369852','Čopova ulica 1',1000,47207);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (8,'Metka','Kos','051147852','Einspielerjeva ulica 8',1000,58492);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (9,'Karli','Kos','051147852','Einspielerjeva ulica 8',1000,58492);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (10,'Frida','Kos','051147852','Einspielerjeva ulica 8',1000,58492);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (11,'Vili','Vidmar','031258741','Vodnikova cesta 55',1000,13169);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (12,'Mitja','Kovačič','041963147','Trubarjeva ulica 123',1000,47207);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (13,'Melisa','Kovačič','041963147','Trubarjeva ulica 123',1000,47207);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (14,'Barbara','Zupančič','051741258','Za vasjo 18',1000,13169);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (15,'Gabrijel','Zupančič','051741258','Za vasjo 18',1000,13169);
INSERT INTO `Person` (`person_id`,`name`,`surname`,`phone_num`,`address`,`post_number`,`region_id`) VALUES (16,'Žiga','Kosmač','051741258','Za vasjo 4',1000,13169);

/*
-- Query: SELECT * FROM homestead.User
LIMIT 0, 1000

-- Date: 2017-05-23 23:07
*/
INSERT INTO `User` (`user_id`,`email`,`password`,`created_at`,`last_login`,`active`,`remember_token`,`user_role_id`,`person_id`) VALUES (1,'admin@patronaza.tpo','$2y$10$YRKAGEl0cbmIrCLOr8rtb.6xPFCm66/w6/VdFDNT.Vtdcg54v7kOy','2017-05-23 19:07:37','2017-05-23 21:25:33',1,'I306FRYWGgSlsv2tdl0vDBGHiR2CqDLIRACcJUSyfW2tWc0yy8zP9Nfd7Gfv',10,1);
INSERT INTO `User` (`user_id`,`email`,`password`,`created_at`,`last_login`,`active`,`remember_token`,`user_role_id`,`person_id`) VALUES (2,'zdravnik@patronaza.tpo','$2y$10$zH0rLruNkYn6WtTQTgCLWeBmlwU07Vmiv/q3sK6F4w4GM9j7hpXsC','2017-05-23 21:13:26','2017-05-23 22:52:41',1,'zhFr40oYwAy1wkTRVw3gjLPgUy3qp1w4eRaZ0rhy0fZ1VXBBDcL8f7BqNko7',21,2);
INSERT INTO `User` (`user_id`,`email`,`password`,`created_at`,`last_login`,`active`,`remember_token`,`user_role_id`,`person_id`) VALUES (3,'vodjaps@patronaza.tpo','$2y$10$ZiByYUMHyDinPOw2h8cuQu/k7jdCQ6MAxFXjMNYwc7ZY79eSlLsIO','2017-05-23 21:15:37',NULL,1,NULL,22,3);
INSERT INTO `User` (`user_id`,`email`,`password`,`created_at`,`last_login`,`active`,`remember_token`,`user_role_id`,`person_id`) VALUES (4,'sestra-center@patronaza.tpo','$2y$10$52A5bCh8eJis9b.v3vohZ.Zt92D3oYl8NteO/OftBnbgU9sGnitGC','2017-05-23 21:18:45',NULL,1,NULL,23,4);
INSERT INTO `User` (`user_id`,`email`,`password`,`created_at`,`last_login`,`active`,`remember_token`,`user_role_id`,`person_id`) VALUES (5,'sestra-bezigrad@patronaza.tpo','$2y$10$jBqmKMix12OMsM3EldlhhuULiYiukhDaj4AJoKMq2zRTrDA.JLUMq','2017-05-23 21:23:10',NULL,1,NULL,23,5);
INSERT INTO `User` (`user_id`,`email`,`password`,`created_at`,`last_login`,`active`,`remember_token`,`user_role_id`,`person_id`) VALUES (6,'sestra-siska@patronaza.tpo','$2y$10$Xr/iKQuZXTVkE7CyXknU1On2VgmYPzgWIQbSFPQuSdv8lJUeSHEU.','2017-05-23 21:25:04',NULL,1,NULL,23,6);
INSERT INTO `User` (`user_id`,`email`,`password`,`created_at`,`last_login`,`active`,`remember_token`,`user_role_id`,`person_id`) VALUES (7,'rozle.potocnik@patronaza.tpo','$2y$10$CyvAlNdMdjzRvTVbcyoMFO5kghO.7E5GvkgT/LW08JMFLm0RtwjFS','2017-05-23 21:31:22','2017-05-23 22:53:55',1,'sSrOVZknyQIZalX8jkQEHR4uhUM5n48nEzmzg4EVrzDf3CLks9Sub81PH3TS',30,7);
INSERT INTO `User` (`user_id`,`email`,`password`,`created_at`,`last_login`,`active`,`remember_token`,`user_role_id`,`person_id`) VALUES (8,'metka.kos@patronaza.tpo','$2y$10$6lLhxv4JmZxI7stEGyYTreEiPvnPTvSe70xnGXtplTKp8ds2ayBke','2017-05-23 21:34:17','2017-05-23 22:56:07',1,'U535MlkTFNPd4HIp5aAuRI8sN31ZrlwQkntM9LTmq4k4rLSFHY4CqwBr4Za5',30,8);
INSERT INTO `User` (`user_id`,`email`,`password`,`created_at`,`last_login`,`active`,`remember_token`,`user_role_id`,`person_id`) VALUES (9,'vili.vidmar@patronaza.tpo','$2y$10$Hz.RFw6KnwXcqRd8SYCpp.7gI14RQdZB9loebFWsrXDfJCZTPbGH2','2017-05-23 21:51:12','2017-05-23 22:56:36',1,'fhY9KNIDh90Yf90YpSSZgIZ3m0PyevK9bWKNhBCcXfgoLp81ubit8rXyUhzz',30,11);
INSERT INTO `User` (`user_id`,`email`,`password`,`created_at`,`last_login`,`active`,`remember_token`,`user_role_id`,`person_id`) VALUES (10,'mitja.kovacic@patronaza.tpo','$2y$10$gNsKz9cdvR8zN3Igmi4Vie0SK2/Zb9gkXihaMhHRImfeidW5JCVKa','2017-05-23 22:11:25','2017-05-23 22:55:38',1,'J1fvxKdbfvm86MlH6PRuv8w7HrtNt3CrmCDBN8cAKBxm6HoraSwm1wRsqZKp',30,12);
INSERT INTO `User` (`user_id`,`email`,`password`,`created_at`,`last_login`,`active`,`remember_token`,`user_role_id`,`person_id`) VALUES (11,'barbara.zupancic@patronaza.tpo','$2y$10$6kW35oD4Kji8pKzAMZ8x5uxHG2UFPqJ3iSDVReFyJeBfGfGtLgbMG','2017-05-23 22:18:40','2017-05-23 22:22:00',1,'q0ATL4qMcpg2StYM21p6Elony8xeaXW9e8zLZ5j0zfDvJp1IQLVggpUAwkUH',30,14);

/*
-- Query: SELECT * FROM homestead.Employee
LIMIT 0, 1000

-- Date: 2017-05-23 23:11
*/
INSERT INTO `Employee` (`employee_id`,`person_id`,`institution_id`) VALUES (4880,4,5150);
INSERT INTO `Employee` (`employee_id`,`person_id`,`institution_id`) VALUES (8413,2,5150);
INSERT INTO `Employee` (`employee_id`,`person_id`,`institution_id`) VALUES (77109,6,5470);
INSERT INTO `Employee` (`employee_id`,`person_id`,`institution_id`) VALUES (91774,5,5030);
INSERT INTO `Employee` (`employee_id`,`person_id`,`institution_id`) VALUES (99436,3,5150);

/*
-- Query: SELECT * FROM homestead.Contact
LIMIT 0, 1000

-- Date: 2017-05-23 23:08
*/
INSERT INTO `Contact` (`contact_id`,`contact_name`,`contact_surname`,`contact_phone_num`,`contact_address`,`post_number`,`relationship_id`) VALUES (1,'Mici','Potočnik','041741854','Čopova ulica 1',1000,10);

/*
-- Query: SELECT * FROM homestead.Patient
LIMIT 0, 1000

-- Date: 2017-05-23 23:11
*/
INSERT INTO `Patient` (`patient_id`,`insurance_num`,`birth_date`,`sex`,`person_id`,`contact_id`) VALUES (1,'158756329','1990-05-15','m',7,1);
INSERT INTO `Patient` (`patient_id`,`insurance_num`,`birth_date`,`sex`,`person_id`,`contact_id`) VALUES (2,'245785439','1985-03-08','f',8,NULL);
INSERT INTO `Patient` (`patient_id`,`insurance_num`,`birth_date`,`sex`,`person_id`,`contact_id`) VALUES (3,'248675217','2015-10-01','m',9,NULL);
INSERT INTO `Patient` (`patient_id`,`insurance_num`,`birth_date`,`sex`,`person_id`,`contact_id`) VALUES (4,'513215687','2017-05-23','f',10,NULL);
INSERT INTO `Patient` (`patient_id`,`insurance_num`,`birth_date`,`sex`,`person_id`,`contact_id`) VALUES (5,'154387921','1952-01-01','m',11,NULL);
INSERT INTO `Patient` (`patient_id`,`insurance_num`,`birth_date`,`sex`,`person_id`,`contact_id`) VALUES (6,'134867526','1947-08-04','m',12,NULL);
INSERT INTO `Patient` (`patient_id`,`insurance_num`,`birth_date`,`sex`,`person_id`,`contact_id`) VALUES (7,'152497532','1948-08-05','f',13,NULL);
INSERT INTO `Patient` (`patient_id`,`insurance_num`,`birth_date`,`sex`,`person_id`,`contact_id`) VALUES (8,'531478560','1991-06-25','f',14,NULL);
INSERT INTO `Patient` (`patient_id`,`insurance_num`,`birth_date`,`sex`,`person_id`,`contact_id`) VALUES (9,'547823654','2017-04-04','m',15,NULL);
INSERT INTO `Patient` (`patient_id`,`insurance_num`,`birth_date`,`sex`,`person_id`,`contact_id`) VALUES (10,'234578923','1965-11-17','m',16,NULL);

/*
-- Query: SELECT * FROM homestead.DependentPatient
LIMIT 0, 1000

-- Date: 2017-05-23 23:12
*/
INSERT INTO `DependentPatient` (`dependent_patient_id`,`guardian_patient_id`,`relationship_id`) VALUES (3,2,13);
INSERT INTO `DependentPatient` (`dependent_patient_id`,`guardian_patient_id`,`relationship_id`) VALUES (4,2,12);
INSERT INTO `DependentPatient` (`dependent_patient_id`,`guardian_patient_id`,`relationship_id`) VALUES (7,6,1);
INSERT INTO `DependentPatient` (`dependent_patient_id`,`guardian_patient_id`,`relationship_id`) VALUES (9,8,13);
INSERT INTO `DependentPatient` (`dependent_patient_id`,`guardian_patient_id`,`relationship_id`) VALUES (10,8,11);
