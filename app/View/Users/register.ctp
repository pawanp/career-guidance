<style>
/* Style for password strength meter */
.is0{background:url('../img/frontend/password_strength.png') no-repeat 0 0;width:138px;}
.is10{background-position:0 -14px;}
.is20{background-position:0 -14px;}
.is30{background-position:0 -28px;}
.is40{background-position:0 -28px;}
.is50{background-position:0 -42px;}
.is60{background-position:0 -42px;}
.is70{background-position:0 -56px;}
.is80{background-position:0 -56px;}
.is90{background-position:0 -70px;}
.is100{background-position:0 -70px;}
.is110{background-position:0 -84px;}
.is120{background-position:0 -84px;}
</style>
<?php  echo $this->Html->script('password_strength.js');?>
<?php
    echo $this->Form->create('User', array('action' => 'register','novalidate'));
    echo $this->Form->input('User.email');
    echo $this->Form->input( 'User.username',array('class' => 'validate[required]'));
    echo $this->Form->input( 'User.password');
?>
<div>
    <div id="passwordStrengthDiv" class="is0" style="float:left;"></div>
    <div id="strengthWords" class="" ></div>
</div>
<?php
    echo $this->Form->input('User.location',array('class' =>'validate[required]','id'=>'location'));

?>
<?php
    echo  $recaptcha;
    echo $this->Form->end('Register');
?>
    <script>
        $(document).ready(function(){
           $('#UserPassword').passwordStrength();
           $("#UserRegisterForm").validationEngine();
           
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
   <script type="text/javascript">
        function initialize() {
            var input = document.getElementById('location');
            var options = {};
            new google.maps.places.Autocomplete(input, options);
        }     
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>