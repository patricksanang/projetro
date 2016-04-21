<! DOCTYPE html>
<html>
    <head>
        <?= $header; ?>

    </head>

    <body>
        <div class="login">
            <div class="login-screen">
                <div class="app-title">
                    <h1>SMS</h1>
                </div>
                <?= $content; ?>
                <ul class="nav masthead-nav">
                    <li class="active"><a href="#" data-toggle="modal" data-target="#myModal">Contact</a></li>
                </ul>

            </div>
        </div>



    </div>

</div>

</div>

</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <center> <h4 class="modal-title" id="myModalLabel">  A Propos </h4> </center>
            </div>
            <div class="modal-body">

                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-4"> <b> Authors : </b></div>
                        <div class="col-md-8 col-md-offset-4"> Patrick Sanang (ENSP, GI, promotion 2017) </div>
                        <div class="col-md-8 col-md-offset-4"> <b> Tel : </b> 698-158-390 </div>
                        <div class="col-md-8 col-md-offset-4"> <b> Email : </b> patrick.sanang@gmail.com</div>
                    </div>
                    <div class="row">
                        <hr/>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-4"> Noyessie Hubert (ENSP, GI, promotion 2017) </div>
                        <div class="col-md-8 col-md-offset-4"> <b> Tel : </b> 695-749-759 </div>
                        <div class="col-md-8 col-md-offset-4"> <b> Email : </b> hubertnoyessie@gmail.com</div>
                    </div>

                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</body>
</html>