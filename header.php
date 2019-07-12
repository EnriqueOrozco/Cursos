<div class="container-header">
	<div class="container-logo"><a href="home.php">Logo</a></div>
	<div class="container-search"><input type="text" placeholder="Buscar" name=""></div>
	<div class="menu_bar">
		<a href="#" class="bt-menu">
			<i class="icon-menu"></i>
		</a>
	</div>
	<div class="container-count">
		<a href="profile.php?username=<?php echo $_SESSION['username'];?>">
			<i class="icon-user"></i><span class="config">Perfil</span>
		</a>
		<a href="configuration.php">
			<i class="icon-cog"></i><span class="config">Configuración</span>
		</a>
		<a href="class/logout.php">
			<i class="icon-switch"></i><span class="config">Cerrar sesión</span>
		</a>
	</div>
</div>