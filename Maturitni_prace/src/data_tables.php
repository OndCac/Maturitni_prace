<?php

function DataTablesHeader($check) {
    if ($check) {
        $dataTables = '<script src="jquery/jquery-3.7.1.min.js"></script>
        <link rel="stylesheet" href="DataTables/DataTables-1.13.8/css/jquery.dataTables.min.css" />
        <script src="DataTables/DataTables-1.13.8/js/jquery.dataTables.min.js"></script>';

        echo $dataTables;
    }
}

function LecList($profileData) {
    echo "<table id='lecTable' class='display'>
                <thead>
                    <tr>
                        <th>Jméno</th>
                        <th>Poloha</th>
                        <th>Cena za hodinu (CZK)</th>
                    </tr>
                </thead>
                <tbody>";
        for ($i=0; $i < count($profileData); $i++) { 
            echo '<tr class="lec-list" id="' . $profileData[$i]["UUID"] . '">
                    <td>' . $profileData[$i]["TitleBefore"] . ' ' . $profileData[$i]["FirstName"] . ' ' . $profileData[$i]["MiddleName"] . ' ' . $profileData[$i]["LastName"] . ' ' . $profileData[$i]["TitleAfter"] . '</td>
                    <td>' . $profileData[$i]["Location"] . '</td>
                    <td>' . $profileData[$i]["PricePerHour"] . '</td>
                    </tr>';
        }
        echo "</tbody>
        <script>
            $(document).ready( function () {
                $('#lecTable').DataTable();
                $('article').after('<footer>Vytvořil Ondřej Cacek 2024 </footer>');
            } );
                
            $( '#lecTable tbody tr' ).on( 'click', function() {
                createCookie('uuid', this.id, 1)
                window.location.href = 'lecturer.php';
            });
        </script>
        ";
}

function AdminLecList($profileData) {
    echo "</br></br></br><table id='lecTable' class='display'>
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
            <tbody>";
    for ($i=0; $i < count($profileData); $i++) { 
        echo '<tr>
                <td>' . $profileData[$i]["TitleBefore"] . ' ' . $profileData[$i]["FirstName"] . ' ' . $profileData[$i]["MiddleName"] . ' ' . $profileData[$i]["LastName"] . ' ' . $profileData[$i]["TitleAfter"] . '</td>
                <td>' . $profileData[$i]["Location"] . '</td>
                <td>' . $profileData[$i]["PricePerHour"] . '</td>
                <td><button onclick="showLec('.$profileData[$i]["UUID"].')" type="button">Show</button></td>
                <td><button onclick="editLec('.$profileData[$i]["UUID"].')" type="button">Edit</button></td>
                <td><button onclick="deleteLec('.$profileData[$i]["UUID"].')" type="button">Delete</button></td>
                </tr>';
    }
    echo "</tbody></table></br></br>
    $(document).ready( function () {
        $('#lecTable').DataTable();
        $('#tagTable').DataTable();
        $('article').after('<footer>Vytvořil Ondřej Cacek 2024 </footer>');
    } );
";
}
?>