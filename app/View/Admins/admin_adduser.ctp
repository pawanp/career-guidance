
            <!--Content Wrapper Starts-->
            <section id="cont_wrapper">
            	<!--Content Starts-->
                <section class="content">
                	<!--Main Heading Starts-->
                    <h1 class="main_heading">Form</h1>
                    <!--Main Heading Ends-->
                    <!--Conetnt Info Starts Here-->
                    <section class="content_info">
                        <?php echo $this->Form->create('User',array('url'=>'/admin/admins/adduser','admin'=>true));?>
                    	<ul class="form">
                            <li>
                            	<label>First Name :</label>
                                <?php echo $this->Form->input('User.firstname',array('label'=>false,'div'=>false,'placeholder'=>'Firstname','class'=>'form_input'));?>
                            </li>
                            <li>
                            	<label>Last Name :</label>
                                <?php echo $this->Form->input('User.lastname',array('label'=>false,'div'=>false,'placeholder'=>'Lastname','class'=>'form_input'));?>
                            </li>
                            <li>
                            	<label>Email :</label>
                                <?php echo $this->Form->input('User.email',array('label'=>false,'div'=>false,'placeholder'=>'Enter your email','class'=>'form_input'));?>
                            </li>
                            <li>
                            	<label>Username :</label>
                                <?php echo $this->Form->input('User.username',array('label'=>false,'div'=>false,'placeholder'=>'Enter your username','class'=>'form_input'));?>
                               
                            </li>
                            <li>
                            	<label>Password :</label>
                                <?php echo $this->Form->input('User.password',array('type'=>'password','label'=>false,'div'=>false,'placeholder'=>'Enter your password','class'=>'form_input error'));?>
                            </li>
                            <li>
                            	<label>&nbsp;</label>
                                <?php echo $this->Form->input('Add',array('type'=>'submit','div'=>false,'label'=>false,'class'=>'blu_btn mar_rt'));?>
                                <?php echo $this->Form->input('Reset',array('label'=>false,'div'=>false,'class'=>'grey_btn','type'=>'Reset'));?>
                            </li>
                        </ul>
                         <?php echo $this->Form->end();?>
                        <section class="clr_bth"></section>
                    </section>
                    <!--Conetnt Info Ends Here-->
                </section>
                <!--Content Ends-->
            </section>
            <!--Content Wrapper Ends-->
            <section class="push"></section>