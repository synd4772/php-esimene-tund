CREATE TABLE loomad(
   id int primary key AUTO_INCREMENT,
   loomanimi varchar(30),
   omnik varchar(30),
   varv varchar(20)
);
INSERT INTO loomad(loomanimi, omnik, varv) VALUES('kass Mark', 'Alex', 'Green');

SELECT * FROM loomad;


CREATE TABLE osalejad(
    id int primary key AUTO_INCREMENT,
    nimi varchar(60),
    telefon varchar(9),
    pilt text,
    synniaeg datetime
);