<?php
$con = ConnectDB() or die('Could not connect to the database server' . mysqli_connect_error());

$Tags = GetTags($con);
$profileData = GetLecturers($con);
?>

<script>
function sendAjax(action, data = {}) {
    data.action = action;
    $.ajax({
        type: "POST",
        url: "../app/controllers/admin_api.php",
        data: data,
        dataType: "json",
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                console.warn("Unexpected response:", response);
            }
        },
        error: function(xhr) {
            console.error(`${action} failed`, xhr.responseText);
        }
    });
}

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

    // Redirect buttons (JS handles navigation directly)
    document.getElementById("btn-add-lec").addEventListener("click", () => {
        window.location.href = "index.php?page=add_lec";
    });

    document.getElementById("btn-create-tag").addEventListener("click", () => {
        window.location.href = "index.php?page=create_tag";
    });

    document.querySelectorAll(".btn-show").forEach(btn =>
        btn.addEventListener("click", () =>
            window.location.href = "index.php?page=lecturer&lec=" + btn.dataset.id
        )
    );

    document.querySelectorAll(".btn-edit").forEach(btn =>
        btn.addEventListener("click", () =>
            window.location.href = "index.php?page=edit_lec&lec=" + btn.dataset.id
        )
    );

    // AJAX buttons for data modification
    document.querySelectorAll(".btn-delete").forEach(btn =>
        btn.addEventListener("click", () =>
            sendAjax("deleteLec", { id: btn.dataset.id })
        )
    );

    document.querySelectorAll(".btn-delete-tag").forEach(btn =>
        btn.addEventListener("click", () =>
            sendAjax("deleteTag", { id: btn.dataset.id })
        )
    );
});
</script>


<button id="btn-add-lec" class="button" type="button">Přidat lektora</button>
<br>
<button id="btn-create-tag" class="button" type="button">Nový Tag</button>
<br /><br /><br />

<table id="lecTable" class="display">
    <thead>
        <tr>
            <th>Jméno</th>
            <th>Poloha</th>
            <th>Cena za hodinu (CZK)</th>
            <th>Ukázat</th>
            <th>Změnit</th>
            <th>Smazat</th>
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
            <td>
                <button class="btn-edit" data-id="<?= $profile['UUID'] ?>">
                    Edit
                </button>
            </td>
            <td>
                <button class="btn-delete" data-id="<?= $profile['UUID'] ?>">
                    Delete
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br /><br /><br />

<table id="tagTable" class="display" style="margin-top:15px">
    <thead>
        <tr>
            <th>Tag</th>
            <th>Smazat Tag</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($Tags as $tag): ?>
        <?php if (!is_array($tag)) continue; ?>
        <tr>
            <td>
                <?= $tag["Name"] ?>
            </td>
            <td>
                <button class="btn-delete-tag" data-id="<?= $tag['UUID'] ?>">
                    Smazat
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
