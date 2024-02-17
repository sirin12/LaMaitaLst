<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<title>La maitrise</title>
	<!-- Favicon
	<link rel="icon" href="../../assets/images/favicon.ico" type="image/x-icon">-->

	<!-- Plugins Core Css -->
	<?php echo admin_assests('assets/css/app.min.css','css') ?>

	<!-- Custom Css -->
	<?php echo admin_assests('assets/css/style.css','css') ?>
	<?php echo admin_assests('assets/css/pages/extra_pages.css','css') ?>
	<style>
	/* ---- particles.js container ---- */

		#particles-js {
		  position: absolute;
		  width: 100%;
		  height: 100vh;
		  background-color: #F47A38;
		  background-image: url("");
		  background-repeat: no-repeat;
		  background-size: cover;
		  background-position: 50% 50%;
		}
	</style>
</head>

<body class="login-page">
	<div class="limiter">
		<div id="particles-js"></div>
		<div class="container-login100 page-background">
			
			<div class="wrap-login100">
				<form action="<?php echo admin_url('login'); ?>" method="post" class="login100-form validate-form">
					<span class="login100-form-logo">
						<center><img alt="" src="<?php echo admin_img('logo.png');?>"></center>
					</span>
					<span class="login100-form-title p-b-34 p-t-27" style="font-weight:bold">
						CHECK-NOTES
					</span>
					<div class="wrap-input100 validate-input" data-validate="Enter username">
						<input class="input100" type="text" name="username" placeholder="Identifiant">
						<i class="material-icons focus-input1001">person</i>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Mot de passe">
						<i class="material-icons focus-input1001">lock</i>
					</div>
					<div class="contact100-form-checkbox">
						<div class="form-check">
							<label class="form-check-label">
								<input class="form-check-input" name="remember" type="checkbox" value=""> Remember me
								<span class="form-check-sign">
									<span class="check"></span>
								</span>
							</label>
						</div>
					</div>
					<div class="container-login100-form-btn">
						
						<input type="hidden" value="<?php echo $redirect; ?>" name="redirect"/>
						<input type="hidden" value="submitted" name="submitted"/>
						<button type="submit" class="login100-form-btn">Connexion</button>
					</div>
					<div style="width:100%;height:70px;">
						<div style="margin-top: 10px; margin-bottom: 10px;height: 70px; background-size: cover;background-repeat: no-repeat; background-position: bottom;background-image:url(http://www.lamaitrise.tn/smart/themes/default/assets/img/bannière.png)"></div>
					</div>
					<!--<div class="text-center p-t-50">
						<a class="txt1" href="forgot-password.html">
							Forgot Password?
						</a>
					</div>-->
				</form>
			</div>
		</div>
	</div>

	<!-- Plugins Js -->
	<?php echo admin_assests('assets/js/app.min.js','js') ?>
	<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> 
	<script>
	/* ---- particles.js config ---- */

		particlesJS("particles-js", {
		  "particles": {
			"number": {
			  "value":300,
			  "density": {
				"enable": true,
				"value_area": 800
			  }
			},
			"color": {
			  "value": "#ffffff"
			},
			"shape": {
			  "type": "circle",
			  "stroke": {
				"width": 0,
				"color": "#000000"
			  },
			  "polygon": {
				"nb_sides": 5
			  },
			 
			},
			"opacity": {
			  "value": 0.5,
			  "random": false,
			  "anim": {
				"enable": false,
				"speed": 1,
				"opacity_min": 0.1,
				"sync": false
			  }
			},
			"size": {
			  "value": 3,
			  "random": true,
			  "anim": {
				"enable": false,
				"speed": 40,
				"size_min": 0.1,
				"sync": false
			  }
			},
			"line_linked": {
			  "enable": true,
			  "distance": 150,
			  "color": "#ffffff",
			  "opacity": 0.4,
			  "width": 1
			},
			"move": {
			  "enable": true,
			  "speed": 6,
			  "direction": "none",
			  "random": false,
			  "straight": false,
			  "out_mode": "out",
			  "bounce": false,
			  "attract": {
				"enable": false,
				"rotateX": 600,
				"rotateY": 1200
			  }
			}
		  },
		  "interactivity": {
			"detect_on": "canvas",
			"events": {
			  "onhover": {
				"enable": true,
				"mode": "grab"
			  },
			  "onclick": {
				"enable": true,
				"mode": "push"
			  },
			  "resize": true
			},
			"modes": {
			  "grab": {
				"distance": 140,
				"line_linked": {
				  "opacity": 1
				}
			  },
			  "bubble": {
				"distance": 400,
				"size": 40,
				"duration": 2,
				"opacity": 8,
				"speed": 3
			  },
			  "repulse": {
				"distance": 200,
				"duration": 0.4
			  },
			  "push": {
				"particles_nb": 4
			  },
			  "remove": {
				"particles_nb": 2
			  }
			}
		  },
		  "retina_detect": true
		});

		$("#search_form").validate({
			rules: {
				search: "required",
			},
			messages: {
					search: "search",
			},
			submitHandler: function(form) {
			  form.submit();
			}
		});
	
	</script>
	<!-- Extra page Js -->
	<?php echo admin_assests('assets/js/pages/examples/pages.js','jss') ?>

</body>
</html>