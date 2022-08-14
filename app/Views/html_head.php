<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $sPageTitle ?></title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
    <link
        rel="stylesheet"
        href="Resources/bootstrap-5.2.0-dist/css/bootstrap.min.css"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
        crossorigin="anonymous" />
        <link
            rel="stylesheet"
            href="Resources/DataTables/datatables.min.css"/>
    <script type="text/javascript">
        const SESSION_ID = <?php if(isset($session)) :?>
        '<?= $session['uidPK'] ?>'
        <?php else : ?>
        null
        <?php endif; ?>
        ;
    </script>
</head>
<body>
    <div class="container-fluid"><!-- START OF MAIN CONTAINER -->
