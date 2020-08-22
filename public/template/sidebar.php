<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container sidebar-closed sbar-open" id="container">

	<div class="overlay"></div>
	<div class="cs-overlay"></div>
	<div class="search-overlay"></div>

	<!--  BEGIN SIDEBAR  -->
	<div class="sidebar-wrapper sidebar-theme">
		<nav id="sidebar">
			<ul class="navbar-nav theme-brand flex-row  text-center" style="background: #3a4161">
				<li class="nav-item theme-logo">
					<a href="<?php echo SITE_URL; ?>dashboard">
						<img src="<?php echo SITE_URL; ?>assets/img/logo.svg" class="navbar-logo" alt="logo">
					</a>
				</li>
				<li class="nav-item theme-text">
					<a href="<?php echo SITE_URL; ?>dashboard" class="nav-link">
						<?php echo ucwords(SITE_NAME); ?>
					</a>
				</li>
			</ul>

			<ul class="list-unstyled menu-categories" id="mainMenu">
				<li class="menu active">
					<a href="<?php echo SITE_URL; ?>dashboard" aria-expanded="true" class="dropdown-toggle">
						<div class="">
							<?php echo ICONS['dashboard']; ?>
							<span>Dashboard</span>
						</div>
					</a>
				</li>


				<li class="menu menu-heading">
					<div class="heading">
						<?php echo ICONS['dot']; ?>
						<span>App Care</span>
					</div>
				</li>
				<?php if ($_SESSION['USER_TYPE'] == 'TEACHER') : ?>
					<li class="menu">
						<a href="<?php echo SITE_URL; ?>list/users/student " aria-expanded="false" class="dropdown-toggle">
							<div class="">
								<?php echo ICONS['project']; ?>
								<span>Students</span>
							</div>
						</a>
					</li>
					<li class="menu">
						<a href="<?php echo SITE_URL; ?>list/users/teacher " aria-expanded="false" class="dropdown-toggle">
							<div class="">
								<?php echo ICONS['property']; ?>
								<span>Teachers</span>
							</div>
						</a>
					</li>
				<?php endif; ?>
				<?php if ($_SESSION['USER_TYPE'] == 'STUDENT') : ?>
					<li class="menu">
						<a href="<?php echo SITE_URL . 'user/view_attandence/' . $_SESSION['USER_ID']; ?> " aria-expanded="false" class="dropdown-toggle">
							<div class="">
								<?php echo ICONS['property']; ?>
								<span>Attandence</span>
							</div>
						</a>
					</li>
				<?php endif; ?>
			</ul>

		</nav>

	</div>
	<!--  END SIDEBAR  -->

	<!--  BEGIN CONTENT AREA  -->
	<div id="content" class="main-content">
		<div class="layout-px-spacing">