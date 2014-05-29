<style>
.left{
    width:20%;
    border:1px solid black;
    float:left;
}
.right{
     width:70%;
     float:left;
     border:1px solid black;
     margin-left:60px;
}
/*.plus, .plus_skill{
    width:30px;
    float:right;
}*/

form div{
     float:left;
}
.add_industry, .add_skills, .add_education{
    width:100%;
}
.add_indus{
    width:75%;
}
</style>

<div class="left">
<?php
    echo $this->Html->image($details['pictureUrl'],array('style'=>'width:200px'));
?>
</div>
<div class="right">
   <?php
    echo $this->Session->flash('auth');
    echo $this->Form->create('User',array('controller'=>'Users','action'=>'publicProfile','enctype' => 'multipart/form-data'));
    echo $this->Form->input('User.firstname',array('div'=>false,'class' => 'validate[required]'));
    echo $this->Form->input('User.lastname',array('div'=>false,'class' => 'validate[required]'));
    echo $this->Form->input('User.aboutme',array('div'=>false,'class' => 'validate[required]'));
    echo $this->Form->input('User.email',array('div'=>false,'class' => 'validate[required]'));
    echo $this->Form->input('User.location',array('div'=>false,'class' => 'validate[required]'));
    echo $this->Form->input('User.summary_details',array('div'=>false,'class' => 'validate[required]'));
    ?>
     <label>Education</label>
    <?php
    echo $this->Form->input('Education.school.',array('div'=>false,'placeholder'=>'School/College','class' => 'validate[required]'));
    echo $this->Form->input('Education.program.',array('div'=>false,'placeholder'=>'Program','class' => 'validate[required]'));
    ?><?php echo $this->Html->image('/img/frontend/Plus.png',array('style'=>'width:36px;','class'=>'plus_education'));?>
    <div class="add_education" ></div>
    <label>Industry</label>
    <?php
    echo $this->Form->input('User.industry.',array('div'=>false,'class' => 'validate[required]'));
    ?><?php echo $this->Html->image('/img/frontend/Plus.png',array('style'=>'width:36px;','class'=>'plus'));?>
    <div class="add_industry" ></div>
    <?php
    echo $this->Form->input('User.designation',array('div'=>false,'class' => 'validate[required]'));
    echo $this->Form->input('User.designation_details',array('div'=>false,'class' => 'validate[required]'));
    echo $this->Form->input('User.industry_experiance',array('div'=>false,'class' => 'validate[required]'));
    ?>
    <label>Skills</label>
    <?php 
    echo $this->Form->input('User.skill.',array('div'=>false,'class' => 'validate[required]'));
    ?><?php echo $this->Html->image('/img/frontend/Plus.png',array('style'=>'width:36px;','class'=>'plus_skill'));?>
    <div class="add_skills"></div>
    <?php
    echo $this->Form->input('User.video_profile',array('div'=>false,'type'=>'file','class' => 'validate[required]'));
    echo $this->Form->input('User.resume.',array('div'=>false,'type'=>'file','class' => 'validate[required]'));
    echo $this->Form->end('Save changes');
?> 
</div>
    <script>
        $(document).ready(function(){
           $("#UserLoginForm").validationEngine();
           
            $(document).on('click','.plus',function(){
            var htm = '<div ><?php echo $this->Form->input("User.industry.",array("div"=>false,"class" => "add_indus validate[required]")); echo $this->Html->image("/img/frontend/cross.png",array("style"=>"width:20px;",'class'=>'cross'));?></div>';
            $('.add_industry').append(htm);
            });
            $(document).on('click','.cross',function(){
                $(this).parent('div').remove();
            });
            
            $(document).on('click','.plus_skill',function(){
            var htm = '<div ><?php echo $this->Form->input("User.skill.",array("div"=>false,"class" => "add_indus validate[required]")); echo $this->Html->image("/img/frontend/cross.png",array("style"=>"width:20px;",'class'=>'cross_skill'));?></div>';
            $('.add_skills').append(htm);
            });
            $(document).on('click','.cross_skill',function(){
                $(this).parent('div').remove();
            });
            
            $(document).on('click','.plus_education',function(){
            var htm = '<div ><?php echo $this->Form->input('Education.school.',array('div'=>false,'placeholder'=>'School/College','class' => 'add_indus validate[required]')); echo $this->Form->input('Education.program.',array('div'=>false,'placeholder'=>'Program','class' => 'add_indus validate[required]')); echo $this->Html->image("/img/frontend/cross.png",array("style"=>"width:20px;",'class'=>'cross_education'));?></div>';
            $('.add_education').append(htm);
            });
            $(document).on('click','.cross_education',function(){
                $(this).parent('div').remove();
            });
        });
    </script>