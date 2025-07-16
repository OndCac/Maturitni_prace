<?php
$con = ConnectDB();
$profileData = GetLecturers($con);
$con->close();
?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const loadCSS = (href) => {
        const link = document.createElement("link");
        link.rel = "stylesheet";
        link.href = 'assets/vendor/' + href;
        document.head.appendChild(link);
    };

    const loadScript = (src, callback) => {
        const script = document.createElement("script");
        script.src = 'assets/vendor/' + src;
        script.onload = callback;
        document.head.appendChild(script);
    };

    loadCSS("jquery.dataTables.min.css");

    loadScript("jquery.dataTables.min.js", () => {
        $('#lecTable').DataTable();
        $('#tagTable').DataTable();
    });

    document.querySelectorAll(".btn-show").forEach(btn =>
        btn.addEventListener("click", () =>
            window.location.href = "index.php?page=lecturer&lec=" + btn.dataset.id
        )
    );
});
</script>


<table id="lecTable" class="display">
    <thead>
        <tr>
            <th>Jméno</th>
            <th>Poloha</th>
            <th>Cena za hodinu (CZK)</th>
            <th>Ukázat</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($profileData as $profile): ?>
        <?php if (!is_array($profile)) continue; ?>
        <tr>
            <td>
                <?= $profile["TitleBefore"] . ' ' .
                    $profile["FirstName"] . ' ' .
                    $profile["MiddleName"] . ' ' .
                    $profile["LastName"] . ' ' .
                    $profile["TitleAfter"]
                ?>
            </td>
            <td>
                <?= $profile["Location"] ?>
            </td>
            <td>
                <?= $profile["PricePerHour"] ?>
            </td>
            <td>
                <button class="btn-show" data-id="<?= $profile['UUID'] ?>">
                    Show
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
