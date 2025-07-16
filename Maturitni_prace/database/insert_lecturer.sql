USE TeacherDigitalAgency;

-- Seed data for the provided lecturer
DELETE FROM Lecturer;
DELETE FROM Tag;
DELETE FROM ProfPic;


INSERT INTO Lecturer (TitleBefore, FirstName, MiddleName, LastName, TitleAfter, Location, Claim, Bio, PricePerHour, Email, TelephoneNumber) VALUES (
    'Mgr.',
    'Petra',
    'Swil',
    'Plachá',
    'MBA',
    'Brno',
    'Aktivní studentka / Předsedkyně spolku / Projektová manažerka',
    '<p>Baví mě organizovat věci. Ať už to bylo vyvíjení mobilních aplikací ve Futured, pořádání konferencí, spolupráce na soutěžích Prezentiáda, pIšQworky, <b>Tour de App</b> a Středoškolák roku, nebo třeba dobrovolnictví, vždycky jsem skončila u projektového managementu, rozvíjení soft-skills a vzdělávání. U studentských projektů a akcí jsem si vyzkoušela snad všechno od marketingu po logistiku a moc ráda to předám dál. Momentálně studuji Pdf MUNI a FF MUNI v Brně.</p>',
    1200,
    'predseda@scg.cz',
    "+420 722 482 974"
);

INSERT INTO ProfPic (Name, LecturerUUID) VALUES (
    'big.png.webp',
    1
);


-- Seed data for tags

INSERT INTO Tag (Name) VALUES ('Dobrovolnictví');

INSERT INTO Tag (Name) VALUES ('Studentské spolky');

INSERT INTO Tag (Name) VALUES ('Efektivní učení');

INSERT INTO Tag (Name) VALUES ('Prezentační dovednosti');

INSERT INTO Tag (Name) VALUES ('Marketing pro neziskové studentské projekty');

INSERT INTO Tag (Name) VALUES ('Mimoškolní aktivity');

INSERT INTO Tag (Name) VALUES ('Projektový management, event management');

INSERT INTO Tag (Name) VALUES ('Fundraising pro neziskové studentské projekty');


-- Seed data for the relationship

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES (1, 1);

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES (1, 2);

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES (1, 3);

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES (1, 4);

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES (1, 5);

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES (1, 6);

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES (1, 7);

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES (1, 8);


-- User

-- Admin
INSERT INTO User (email, password, role) VALUES (
    'admin@gmail.com',
    '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5',
    'admin'
);
