<?php
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
}

function uploadFoto($file) {
    // Buat direktori jika belum ada
    $target_dir = __DIR__ . "/../assets/uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // Generate nama file unik untuk menghindari duplikasi
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $fileName = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $fileName;
    
    // Validasi tipe file
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowed)) {
        return false;
    }
    
    // Upload file
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $fileName;
    }
    
    return false;
}

function exportToExcel($data, $filename) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
    header('Cache-Control: max-age=0');
    
    echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel">';
    echo '<head>';
    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
    echo '<!--[if gte mso 9]>';
    echo '<xml>';
    echo '<x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
    echo '<x:Name>Sheet1</x:Name>';
    echo '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>';
    echo '</x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook>';
    echo '</xml>';
    echo '<![endif]-->';
    echo '</head>';
    echo '<body>';
    
    echo '<table border="1" cellspacing="0" cellpadding="5">';
    
    if (!empty($data)) {
        // Style untuk header
        echo '<tr style="background-color: #4CAF50; color: white; font-weight: bold;">';
        foreach(array_keys($data[0]) as $key) {
            echo '<th style="text-align: center; vertical-align: middle;">' . ucwords(str_replace('_', ' ', $key)) . '</th>';
        }
        echo '</tr>';
        
        // Data
        foreach($data as $row) {
            echo '<tr>';
            foreach($row as $cell) {
                if (strtotime($cell)) {
                    // Format tanggal
                    echo '<td style="text-align: center;">' . date('d/m/Y', strtotime($cell)) . '</td>';
                } else {
                    echo '<td>' . $cell . '</td>';
                }
            }
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="' . count(array_keys($data[0])) . '">No data available</td></tr>';
    }
    
    echo '</table>';
    echo '</body>';
    echo '</html>';
}
?>
