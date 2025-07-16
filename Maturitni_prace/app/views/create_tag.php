<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["NewTag"])) {
    $con = ConnectDB();
    $tag_name = $_POST['NewTag'];

    if (CreateTag($con, $tag_name))
    {
        $con->close();
        header("Location: index.php?page=admin");
        exit();
    } else {
        echo "error:".mysqli_error($con);
        $con->close();
    }
}
?>


<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btn-back").addEventListener("click", () => {
        window.location.href = "index.php?page=admin";
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


<button class="button" type="button" id="btn-back">Zpět na seznam lektorů</button>

<br><br><br>

<form method="POST" class="flex-container">
    <input type="hidden" name="action" value="submited"/>
    <!-- id -- nutne mit sekvenci -->

    <label for="NewTag">Tag:</label>
    <input id="NewTag" name="NewTag" />
    <br/>

    <input class="button" type="submit" value="Vytvořit">
</form>