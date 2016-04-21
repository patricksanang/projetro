    <title><?= isset($title) ? $title : 'SMS' ?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/sms/Web/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/sms/Web/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/sms/Web/css/local.css" />

    <script type="text/javascript" src="/sms/Web/js/propre/autre.js"></script>
    <script type="text/javascript" src="/sms/Web/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/sms/Web/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/sms/Web/bootstrap/js/bootstrap.min.js"></script>   

    <script src="/sms/Web/js/jquery.dataTables.min.js"></script>
    <script src="/sms/Web/js/dataTables.bootstrap.min.js"></script>
    <script>
	$(document).ready(function(){$('#table_id').DataTable({
		responsive : true
	});
	});

    </script>