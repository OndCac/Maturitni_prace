<?php

class Database {
    private PDO $pdo;

    public function __construct() {
        $host = "localhost";
        $dbname = "TeacherDigitalAgency";
        $user = "root";
        $password = "root";

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // throws exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $this->pdo = new PDO($dsn, $user, $password, $options);
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }
}

class UserManager {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function register(array $user): void {
        $email = $user['email'];
        $password = $user['password1'];
        $hash = hash('sha256', $password);

        $stmt = $this->pdo->prepare("SELECT email FROM user WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            echo "Účet s tímto emailem již existuje.";
            return;
        }

        $insert = $this->pdo->prepare("INSERT INTO User (Email, Password, role) VALUES (?, ?, 'host')");
        if ($insert->execute([$email, $hash])) {
            $_SESSION["logged_in"] = true;
            $_SESSION["role"] = "host";
            header("Location: index.php?page=home_page");
            exit;
        } else {
            echo "Chyba při registraci.";
        }
    }
}

class LecturerManager {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function addLecturer(array $data): bool {
        $sql = "INSERT INTO Lecturer 
                (TitleBefore, FirstName, MiddleName, LastName, TitleAfter, Location, Claim, Bio, PricePerHour, TelephoneNumber, Email)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['TitleBefore'], $data['FirstName'], $data['MiddleName'],
            $data['LastName'], $data['TitleAfter'], $data['Location'],
            $data['Claim'], $data['Bio'], $data['PricePerHour'],
            $data['TelephoneNumber'], $data['Email']
        ]);
    }

    public function getLecturerUUIDByEmail(string $email): string {
        $stmt = $this->pdo->prepare("SELECT uuid FROM Lecturer WHERE Email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row['uuid'] ?? '';
    }

    public function deleteLecturer(int $uuid): void {
        $stmt = $this->pdo->prepare("SELECT name FROM ProfPic WHERE LecturerUUID = ?");
        $stmt->execute([$uuid]);
        if ($row = $stmt->fetch()) {
            @unlink("../database/images/" . $row["name"]);
        }

        $this->pdo->prepare("DELETE FROM ProfPic WHERE LecturerUUID = ?")->execute([$uuid]);
        $this->pdo->prepare("DELETE FROM LecturerTag WHERE LecturerUUID = ?")->execute([$uuid]);
        $this->pdo->prepare("DELETE FROM Lecturer WHERE UUID = ?")->execute([$uuid]);
    }

    public function addProfilePicture(int $uuid, string $pic): bool {
        $stmt = $this->pdo->prepare("INSERT INTO ProfPic (Name, LecturerUUID) VALUES (?, ?)");
        return $stmt->execute([$pic, $uuid]);
    }

    public function getAllLecturers(): array {
        $stmt = $this->pdo->query("SELECT * FROM Lecturer");
        return $stmt->fetchAll();
    }
}

class TagManager {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function linkTag(int $tagId, int $uuid): bool {
        $check = $this->pdo->prepare("SELECT TagUUID FROM LecturerTag WHERE LecturerUUID = ? AND TagUUID = ?");
        $check->execute([$uuid, $tagId]);
        if ($check->fetch()) return true;

        $stmt = $this->pdo->prepare("INSERT INTO LecturerTag (LecturerUUID, TagUUID) VALUES (?, ?)");
        return $stmt->execute([$uuid, $tagId]);
    }

    public function unlinkTag(int $tagId, int $uuid): bool {
        $stmt = $this->pdo->prepare("DELETE FROM LecturerTag WHERE LecturerUUID = ? AND TagUUID = ?");
        return $stmt->execute([$uuid, $tagId]);
    }

    public function getAllTags(): array {
        $stmt = $this->pdo->query("SELECT * FROM Tag");
        return $stmt->fetchAll();
    }

    public function getTagsByLecturer(int $uuid): array {
        $stmt = $this->pdo->prepare("
            SELECT t.* 
            FROM LecturerTag lt
            LEFT JOIN Tag t ON lt.TagUUID = t.UUID
            WHERE lt.LecturerUUID = ?
        ");
        $stmt->execute([$uuid]);
        return $stmt->fetchAll() ?: [];
    }
}
