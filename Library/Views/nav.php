			
            <?php
            if(!isset($_SESSION['user'])||$_SESSION['user']==null||$_SESSION['user']==''){
                header('Location: /sms/authentification/login/');      
            }
?>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/sms/home/">Sms</a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li><a href="/sms/home/"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="/sms/test/message/"><i class="fa fa-envelope"></i> Messagerie </a></li>
                    <li><a href="/sms/test/contact/"><i class="fa fa-users"></i> Contacts </a></li>
                    <li><a href="/sms/creation/carnet/index"><i class="fa fa-pencil"></i> Gerer le carnet d'adresses</a></li>
                    <li><a href="/sms/settings/"><i class="fa fa-cog"></i> Parametres </a></li>
                    <li><a href="/sms/authentification/logout/"><i class="fa fa-power-off"></i> Se deconnecter </a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right navbar-user">
                    <li class="dropdown messages-dropdown">
                        <?php 
                        $api=new \Library\Api();
                        $config=new \Library\Config($this->app());
                        //$credit=$api->getCredit('patricksanang', 'cYiTdXqX');
                        $credit=$api->getCredit($config->get('usernameAPI'), $config->get('passwordAPI'));
            
                        $credit=$credit/1000;
                        ?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope"></i> Il vous reste: <?=$credit;?> sms </a>
                        
                    </li>
                    
                     <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Bonjour <?= isset($_SESSION['user']) ? $_SESSION['user'] : 'user' ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/sms/authentification/logout/"><i class="fa fa-power-off"></i> Se deconnecter</a></li>
                        </ul>
                    </li>
                </ul>
            </div>