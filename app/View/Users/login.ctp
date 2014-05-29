<?php
    echo $this->Session->flash('auth');
    echo $this->Form->create('User');
    echo $this->Form->input('User.username',array('class' => 'validate[required]'));
    echo $this->Form->input('User.password',array('class' => 'validate[required]'));
    echo $this->Form->end('Login');
?>
    <script>
        $(document).ready(function(){
           $("#UserLoginForm").validationEngine();
           
        });
    </script>
