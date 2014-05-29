
<title>::Login::</title>
<!--[if lt IE 9]>

	<!--Login Wrapper Starts-->
	 
        <?php echo $this->Form->create('User',array('url'=>'/admin/admins/login','admin'=>true));
	?>
    <section id="login_wrapper">
	<?php echo $this->Session->flash('auth');?>
        <ul class="login_form">
        	<li>
            	<label>Username :</label>
		<?php echo $this->Form->input('User.username',array('label'=>false,'div'=>false,'placeholder'=>'Username','class'=>'input'));?>
               <!-- <input class="input" type="text" placeholder="Username"/>-->
            </li>
            <li>
            	<label>Password :</label>
		<?php echo $this->Form->input('User.password',array('label'=>false,'div'=>false,'placeholder'=>'Password','class'=>'input','type'=>'password'));?>
              <!--  <input class="input" type="password" placeholder="Password"/>-->
            </li>
        </ul>
        <section class="rmbr_frgt">
        	<p class="rmbr"><input type="checkbox"/><span>Remember Me</span></p>
            <p class="pswrd"><a id="paswrd" href="#">Forgot password ?</a></p>
        </section>
        <section class="login_btn">
        	<span class="blu_btn_lt"><?php echo $this->Form->input('Login',array('label'=>false,'div'=>false,'class'=>'blu_btn_rt','type'=>'submit'));?></span>
        </section>
        <section class="clr_bth"></section>
    </section>
  
    <!--Login Wrapper Ends-->
    
    <!--Forgot Wrapper Starts-->
    <section style="display:none;" id="forgot_wrapper">   
    	<p class="send">Please send us your email and we'll reset your password.</p>
        <ul class="login_form">
        	<li>
            	<label>Email :</label>
                <input class="input" type="text" placeholder="Email"/>
            </li>
        </ul>
        <section class="login_btn">
        	<span class="blu_btn_lt"><input class="blu_btn_rt" value="Submit" type="submit"/></span>
        </section>
        <p class="back"><a id="back" href="#">Back to login form</a></p>
        <section class="clr_bth"></section>
    </section>
       <?php echo $this->Form->end();?>
    <!--Forgot Wrapper Ends-->
