-- Seed data for the provided lecturer
INSERT INTO Lecturer (TitleBefore, FirstName, MiddleName, LastName, TitleAfter, PictureURL, Location, Claim, Bio, PricePerHour) VALUES (
    'Mgr.',
    'Petra',
    'Swil',
    'Plachá',
    'MBA',
    'https://tourdeapp.cz/storage/images/2023_02_25/412ff296a291f021bbb6de10e8d0b94863fa89308843b/big.png.webp',
    'Brno',
    'Aktivní studentka / Předsedkyně spolku / Projektová manažerka',
    '<p>Baví mě organizovat věci. Ať už to bylo vyvíjení mobilních aplikací ve Futured, pořádání konferencí, spolupráce na soutěžích Prezentiáda, pIšQworky, <b>Tour de App</b> a Středoškolák roku, nebo třeba dobrovolnictví, vždycky jsem skončila u projektového managementu, rozvíjení soft-skills a vzdělávání. U studentských projektů a akcí jsem si vyzkoušela snad všechno od marketingu po logistiku a moc ráda to předám dál. Momentálně studuji Pdf MUNI a FF MUNI v Brně.</p>',
    1200
);

UPDATE Lecturer SET PRIMARY_CONTACT_UUID = 1 WHERE UUID = 1;

DELETE FROM Lecturer WHERE UUID = 2;

-- Seed data for tags
INSERT INTO Tag (Name) VALUES ('Dobrovolnictví');

INSERT INTO Tag (Name) VALUES ('Studentské spolky');

INSERT INTO Tag (Name) VALUES ('Efektivní učení');

INSERT INTO Tag (Name) VALUES ('Prezentační dovednosti');

INSERT INTO Tag (Name) VALUES ('Marketing pro neziskové studentské projekty');

INSERT INTO Tag (Name) VALUES ('Mimoškolní aktivity');

INSERT INTO Tag (Name) VALUES ('Projektový management, event management');

INSERT INTO Tag (Name) VALUES ('Fundraising pro neziskové studentské projekty');

INSERT INTO Contact (LecturerUUID, TelephoneNumbers, Emails) VALUES (
    '1',
    '["+420 722 482 974"]',
    '["placha@scg.cz", "predseda@scg.cz"]'
);

DELETE FROM Contact WHERE UUID = 2;

-- Seed data for the relationship
INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES ('1', '1');

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES ('1', '2');

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES ('1', '3');

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES ('1', '4');

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES ('1', '5');

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES ('1', '6');

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES ('1', '7');

INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES ('1', '8');