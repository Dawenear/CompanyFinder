<?php
error_reporting(-1);
ini_set('display_errors', 'On');

use App\Models\CompanyFinder;

require_once('vendor/autoload.php');
$html = '';
$error = '';

if (isset($_POST['searchCompany'])) {
    if ($_POST['ico'] !== '' && !is_int((int)$_POST['ico']) && ((int)$_POST['ico'] == $_POST['ico'])) {
        $error = 'IČO musí být číslo';
    } elseif ($_POST['ico'] == '' && $_POST['companyName'] == '') {
        $error = 'Musí být zadáno ičo nebo jméno firmy';
    } else {
        $companyFinder = new CompanyFinder();
        $html = $companyFinder->handleForm($_POST);
    }
}
echo <<<HTML
<html>
    <head>
        <title>Vyhledávač firem z ARESu</title>
        <link rel="stylesheet" type="text/css" href="css/index.css">
<!--        <script src="http://code.jquery.com/jquery-latest.min.js"></script>-->
<!--        <script src="js/jquery.tablesort.js"></script>-->
        <script src="js/sorttable.js"></script>
<!--        <script>-->
<!--            $('table.sortable').tablesort();-->
<!--         </script>-->
    </head>
    <body>
        <form method="post">
            {$error}
            <table>
                <tr>
                    <td>
                        IČO:
                    </td>
                    <td>
                        <input type="number" name="ico">
                    </td>
                </tr>
                <tr>
                    <td>
                        Jméno firmy:
                    </td>
                    <td>
                        <input type="text" name="companyName">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button name="searchCompany">Hledat</button>
                    </td>
                </tr>
            </table>
        </form>
        {$html}
    </body>
</html>
HTML;
