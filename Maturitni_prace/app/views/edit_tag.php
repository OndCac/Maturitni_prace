<?php
$con = ConnectDB() or die ('Could not connect to the database server' .
                            mysqli_connect_error());
$uuid = $_SESSION['LecId'];

$lecturersTags = GetLecturersTags($con, $uuid);
$availableTags = GetTags($con);
?>


<script>
function sendAjax(action, data = {}) {
    data.action = action;
    data.uuid = <?= $uuid ?>;
    $.ajax({
        type: "POST",
        url: "../app/controllers/edit_tag_api.php",
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

    loadScript("jquery-3.7.1.min.js", () => {
        loadScript("jquery.dataTables.min.js", () => {
            $('#availableTags').DataTable();
            $('#chosenTags').DataTable();
        });
    });

    document.getElementById("btn-finish").addEventListener("click", () => {
        window.location.href = "index.php?page=edit_pic";
    });

    document.querySelectorAll(".btn-link-tag").forEach(btn =>
        btn.addEventListener("click", () =>
            sendAjax("linkTag", { id: btn.dataset.id })
        )
    );

    document.querySelectorAll(".btn-unlink-tag").forEach(btn =>
        btn.addEventListener("click", () =>
            sendAjax("unlinkTag", { id: btn.dataset.id })
        )
    );
});
</script>


<table id='chosenTags' class='display'>
    <thead>
        <tr>
            <th>Navolené Tagy</th>
            <th>Odstranit Tag</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lecturersTags as $tag): ?>
        <?php if (!is_array($tag)) continue; ?>
        <tr>
            <td>
                <?= $tag["Name"] ?>
            </td>
            <td>
                <button class="btn-unlink-tag" data-id="<?= $tag['UUID'] ?>">
                    Smazat
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br/><br/><br/>

<table id='availableTags' class='display'>
    <thead>
        <tr>
            <th>Dostupné Tagy</th>
            <th>Přidat Tag</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($availableTags as $tag): ?>
        <?php if (!is_array($tag)) continue; ?>
        <tr>
            <td>
                <?= $tag["Name"] ?>
            </td>
            <td>
                <button class="btn-link-tag" data-id="<?= $tag['UUID'] ?>">
                    Přidat
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br/><br/><br/>

<button id='btn-finish' type='button' class='button'>Pokračovat</button>
