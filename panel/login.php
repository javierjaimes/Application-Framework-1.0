<? $this->getHeader() ?>
            	<div id="login">
                	<?php if(isset($_GET['error'])): ?>
                	<div id="error">
                    	<p>Error ingresando, vuelva a intentarlo...</p>
                    </div>
                    <? endif ?>
                	<div id="formlogin">
                    	<form action="<?= $this->app['siteurl'] ?>/login.php" method="post">
                        	<p>
                        	<label for="usuario">Usuario:</label>
                            <input type="text" name="usuario" style="width:95%;" />
                            </p>
                            <p>
                            <label for="clave">Clave:</label>
                            <input type="password" name="clave" style="width:95%;" />
                            </p>
                            <p style="text-align:right;">
                            <input type="submit" value="entrar" id="botonenviar" />
                            </p>
                        </form>
                    </div>
                </div>
<? $this->getFooter() ?>