<?php
$con = ConnectDB();
$uuid = $_SESSION['LecId'];
$pic = '';
const UPLOAD_DIR = "../database/images/";

function StorePicture($con, $uuid, $image): bool {
    $image_name = $image['name'];

    // store file on the disk
    if (!move_uploaded_file($image['tmp_name'], UPLOAD_DIR . $image_name))
    {
        error_log("cannot upoad file");
        return false;
    }

    // create link in the database
    if (!AddLecPic($con, $uuid, $image_name))
    {
        unlink(UPLOAD_DIR . $image_name);
        error_log("Error: " . mysqli_error($con));
        return false;
    }

    return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']))
{
    if (!StorePicture($con, $uuid, $_FILES['image']))
        echo "Chyba";
}

?>


<script>
function sendAjax(data = {}) {
    $.ajax({
        type: "POST",
        url: "../app/controllers/edit_pic_api.php",
        data: data,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                location.reload();
            } else {
                console.warn("Unexpected response:", response);
            }
        },
        error: function (xhr) {
            console.error('action failed', xhr.responseText);
        }
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("btn-delete");
    if (btn != null)
    {
        btn.addEventListener("click", function() {
            sendAjax({ name: this.dataset.name });
        });
    }

    document.getElementById("btn-finish").addEventListener("click", () => {
        window.location.href = "index.php?page=admin";
    });
});
</script>


<button class="button" type="button" id="btn-finish">Dokončit</button>

<br />

<?php if (GetLecPic($con, $uuid, $pic)): ?>
    <img width="200" src='<?= UPLOAD_DIR . $pic ?>'>
    <br />

    <button class="button" type="button" id="btn-delete" data-name="<?= $pic ?>">
        Odstranit obrázek
    </button>

    <br />
<?php else: ?>
    <br />
    <br />

    <h4>Vyberte soubor (název ve tvaru: krestni_prijmeni.img)</h4>

    <form action="index.php?page=edit_pic" method="post" enctype="multipart/form-data">
        <label class="pic-button" for="img">Vybrat</label>
        <input id="img" type="file" name="image" />
        <br />
        <input class="pic-button" type="submit" name="submit" value="Upload" />
    </form>
<?php endif; ?>
