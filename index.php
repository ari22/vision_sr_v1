<?php 
session_start(); 

if (!empty($_SESSION['C_USER'])) {
    header("location:main.php");
    return;
} 
?>
<html>
<head>
	<meta charset="UTF-8">
	<noscript>
	  Your browser doesn't support JavaScript or you 
	  have disabled JavaScript. Therefore, here's 
	  alternative content...
				  
	</noscript>
	<?php 
	$loc_jui = "../lib/jeasyui/"; 
        
        $loc_asset = "../lib/asset/";
	?>
	<script language=JavaScript> 
		var message="Function Disabled!"; 
		function clickIE4(){ if (event.button==2){ alert(message); return false; } } 
		function clickNS4(e){ if (document.layers||document.getElementById&&!document.all)
				{ if (e.which==2||e.which==3){ alert(message); return false; } } } 
		if (document.layers){ document.captureEvents(Event.MOUSEDOWN); document.onmousedown=clickNS4; } 
		else if (document.all&&!document.getElementById){ document.onmousedown=clickIE4; } 
		//document.oncontextmenu=new Function("alert(message);return false") 
		document.oncontextmenu=new Function("return false") ;
	</script>
	
	<title>Vision Showroom</title>
	<style type="text/css">
	
	h3 {
		font-size:8pt;
		font-family: Optima, Segoe, "Segoe UI", Candara, Calibri, Arial, sans-serif;
		text-decoration: none;
		background: inherit;
		}
	nav {
		line-height:30px;
		background-color:#eeeeee;
		height:150px;
		width:400px;
		float:right;
		padding:5px;
	}
	h4 { font-size:28pt; padding: 10px 0 0 8px; margin: 0; }
	
	.orange { font-size:29pt; color: #E0692A; }
	sup { font-size: 12pt; }
	.header { 
	height: 50px;
	//background: #fff url(img/headerbg.gif) repeat-x bottom;
	body {
		
		background-color: #026873;
		background-image: linear-gradient(90deg, rgba(255,255,255,.07) 50%, transparent 50%),
		linear-gradient(90deg, rgba(255,255,255,.13) 50%, transparent 50%),
		linear-gradient(90deg, transparent 50%, rgba(255,255,255,.17) 50%),
		linear-gradient(90deg, transparent 50%, rgba(255,255,255,.19) 50%);
		background-size: 13px, 29px, 37px, 53px;
	}
	
	</style>
	
	<link rel="stylesheet" type="text/css" href="<?php echo $loc_asset;?>css/style.css" />
	<script src="<?php echo $loc_asset;?>js/modernizr.custom.63321.js"></script>
	<script type="text/javascript" src=<?php echo $loc_jui."jquery.min.js";?>></script>
                <link rel="stylesheet" type="text/css" href=<?php echo $loc_jui . "themes/metro/easyui.css"; ?>>

        <script type="text/javascript" src=<?php echo $loc_jui . "jquery.easyui.min.js"; ?>></script>
	<!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
	
</head>

	 <body>
		
        <div class="container">
			<header>			
				<div class="Logo" id="my_form">					
					<h4>Vision<span class="orange">Showroom</span><sup>2nd edition</sup></h4>						
				</div>				
			</header>
			
			<section class="main">
				<form class="form-2" id="myForm" action="main.php" method="POST" target="_self" accept-charset="UTF-8">
					<h1><span class="log-in">Log in</span> </h1>
					<p class="float">
						<label for="login"><i class="icon-user"></i>Username</label>
						<input type="text" id="c_user" name="c_user" placeholder="Username or email">
					</p>
					<p class="float">
						<label for="password"><i class="icon-lock"></i>Password</label>
						<input type="password" id="c_password" name="c_password" placeholder="Password" class="showpassword">
					</p>
					<p class="clearfix"> 
						<input type="submit" class="log-twitter button_submit" value="Login"></input>					
						<!--<button type="button" class="log-twitter" name="login" onClick="doLogin()">Login</button>-->					
						<button type="reset" class="log-twitter" name="reset" value="Cancel">Cancel</button>						
					</p>
				</form>			</section>
			
        </div>
		
		<!-- jQuery if needed -->
        
		<script type="text/javascript">
			$("#myForm").submit(function(){
                           doLogin();
                           return false;
                        });

			var tryCnt = 1;
			$(function(){
			    $(".showpassword").each(function(index,input) {
			        var $input = $(input);
			        $("<p class='opt'/>").append(
			            $("<input type='checkbox' class='showpasswordcheckbox' id='showPassword' />").click(function() {
			                var change = $(this).is(":checked") ? "text" : "password";
			                var rep = $("<input placeholder='Password' type='" + change + "' />")
			                    .attr("id", $input.attr("id"))
			                    .attr("name", $input.attr("name"))
			                    .attr('class', $input.attr('class'))
			                    .val($input.val())
			                    .insertBefore($input);
			                $input.remove();
			                $input = rep;
			             })
			        ).append($("<label for='showPassword'/>").text("Show password")).insertAfter($input.parent());
			    });

			    $('#showPassword').click(function(){
					if($("#showPassword").is(":checked")) {
						$('.icon-lock').addClass('icon-unlock');
						$('.icon-unlock').removeClass('icon-lock');    
					} else {
						$('.icon-unlock').addClass('icon-lock');
						$('.icon-lock').removeClass('icon-unlock');
					}
			    });
			});
			function validate()
			{
				var c_user = $('#c_user').val();
				var c_password = $('#c_password').val();
				if (c_user.length == 0)	{alert("Username tidak boleh kosong");return false;}
				if (c_password.length == 0)	{alert("Password tidak boleh kosong");return false;}
			}
			function doLogin()
			{
				if (tryCnt>3)
				{
					alert("Anda sudah mencoba login 3x");
					$('#c_user').val('');
					$('#c_password').val('');
					return ;
				}else
				{
					//alert(tryCnt);
				}
				lStatus = validate();
				if (lStatus == false){return;}
				url = "services/runCRUD.php";
				var c_user = $('#c_user').val();
				var c_password = $('#c_password').val();
				data = "lookup=login"
					 + "&func=auth"
					 + "&c_user="+c_user
					 + "&c_password="+c_password;		
				
				$.post( url, data )
				.done(function( data ) { 
					tryCnt = tryCnt+1;
					obj = JSON.parse(data);
					//alert(obj.success);
					if (obj.success=='true'){
						showAlert('Login',obj.message);		
						//document.getElementById("myForm").submit();
                                                
                                                window.location.href = "main.php";
                                                	
					}else
					{
						showAlert('Login Failed','<font color="red">'+obj.message+'</font>');
					}
				})
				.fail(function() {
					showAlert('Login Failed','<font color="red">Tidak bisa melakukan koneksi</font>');
				})
			}
			function showAlert(title,msg){
                            $.messager.show({
                                title: title,
                                msg: msg,
                                showType: 'fade', //null,slide,fade,show
                                timeout: 800,
                                //showType:'fade',
                                style: {
                                    right: '',
                                    top: document.body.scrollTop + document.documentElement.scrollTop,
                                    bottom: ''
                                }
                            });
			}
			
			
			
		</script>
    </body>

</html>