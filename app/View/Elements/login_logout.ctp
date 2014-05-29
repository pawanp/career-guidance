<?php
    if(isset($Acive_user) && !empty($Acive_user)){
        if(!empty($Acive_user['User']['firstname'])){
             echo "Welocme ".$Acive_user['User']['firstname'];
        }else{
            echo "Welocme ".$Acive_user['firstname'];
        }
        echo $this->Html->link('   Logout   ',array('controller'=>'users','action'=>'logout'),array('class'=>'linked_logout superlogout','style'=>'float:right;color:#fff'));
    }else{
        echo $this->Html->link(' Register',array('controller'=>'users','action'=>'register'),array('style'=>'float:right;color:#fff'));
        echo $this->Html->link('Login  |',array('controller'=>'users','action'=>'login'),array('style'=>'float:right;color:#fff;margin-left'));
        echo $this->Html->image('/img/frontend/facebook_gray.png',array('style'=>'float:right;width:60px;cursor:pointer','onclick'=>"javascript:login();",'id'=>"fb-auth"));
        echo $this->Html->image('/img/frontend/linkedin_gray.png',array('class'=>'linked_login','style'=>'float:right;width:60px;cursor:pointer'));
    }
?>
<script>
    $(document).ready(function(){
	$('.linked_login').click(function() {
            onLinkedInLoad();
        });
          $('logout-link').click(function() {
            IN.Event.on(IN,'logout', function() {
                window.location.href = ['<?php echo BASE_URL ?>/users/linkedIn_connect'];
            });

    IN.User.logout();
    });
    });
</script>
<script type="text/javascript" src="http://platform.linkedin.com/in.js">
    api_key:759sg2v6ug2bje
    authorize: false
    //onLoad: onLinkedInLoad
    scope: r_basicprofile r_emailaddress r_fullprofile
</script>
<script>
function onLinkedInLoad() {
        IN.ENV.js.scope = new Array();
        IN.ENV.js.scope[0] = 'r_emailaddress';
	IN.ENV.js.scope[1] = 'r_basicprofile';
	IN.ENV.js.scope[2] = 'r_fullprofile';
	
        IN.User.authorize();
        IN.Event.on(IN, "auth", onLinkedIn);
    }
    
    function onLinkedIn(){
        window.close();
        IN.API.Profile("me").fields("id","firstName", "lastName", "industry", "location:(name)", "picture-url", "headline", "summary", "num-connections", "public-profile-url", "distance", "positions", "email-address", "educations:(field-of-study,degree,school-name)", "date-of-birth","skills","certifications").result(function(me) {
            var profile = me.values[0];
            //info = [];
            //info[0] = profile.id;
            //info[1] = profile.firstName;
            //info[2] = profile.lastName;
            //info[3] = profile.emailAddress;
            //info[4] = profile.location.name;
            //alert(info);return false;
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {info: me},
                url: '<?php echo BASE_URL ?>users/linkedIn_connect',
                success: function(msg) {

                    if (msg == 1) {
                        window.location.href = '<?php echo BASE_URL ?>users/publicProfile/';
                    } else if (msg == 2) {
                         alert('Some Error Occured!')
                      //  window.location.href = '<?php echo BASE_URL ?>/users/login';
                    } else {
                         alert('Success Login');
                      //  window.location.href = '<?php echo BASE_URL ?>/users/linkedIn_connect';
                    }
                }
            });
        });
    }

</script>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId: '255506401319669', // App ID
            //channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel File
            status: true, // check login status
            cookie: true, // enable cookies to allow the server to access the session
            xfbml: true  // parse XFBML
        });

        // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
        // for any auth related change, such as login, logout or session refresh. This means that
        // whenever someone who was previously logged out tries to log in again, the correct case below
        // will be handled.

        FB.Event.subscribe('auth.authResponseChange', function(response) {
            // Here we specify what we do with the response anytime this event occurs.

           /* if (response.status === 'connected') {
                // The response object is returned with a status field that lets the app know the current
                // login status of the person. In this case, we're handling the situation where they
                // have logged in to the app.


                testAPI();
            } else if (response.status === 'not_authorized') {
                // In this case, the person is logged into Facebook, but not into the app, so we call
                // FB.login() to prompt them to do so.
                // In real-life usage, you wouldn't want to immediately prompt someone to login
                // like this, for two reasons:
                // (1) JavaScript created popup windows are blocked by most browsers unless they
                // result from direct user interaction (such as a mouse click)
                // (2) it is a bad experience to be continually prompted to login upon page load.
                FB.login();
            } else {
                // In this case, the person is not logged into Facebook, so we call the login()
                // function to prompt them to do so. Note that at this stage there is no indication
                // of whether they are logged into the app. If they aren't then they'll see the Login
                // dialog right after they log in to Facebook.
                // The same caveats as above apply to the FB.login() call here.
                FB.login();
            }*/
        });
    };


    // Load the SDK asynchronously
    (function(d) {
	
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {
            return;
        }
	
        js = d.createElement('script');
        js.id = id;
        js.async = true;
        js.src = "//connect.facebook.net/en_US/all.js";
        ref.parentNode.insertBefore(js, ref);
    } (document));

    // Here we run a very simple test of the Graph API after login is successful.
    // This testAPI() function is only called in those cases.
    function testAPI() {
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me', function(response) {
	    
            $.post("<?php echo $this->Html->url(array('controller'=>'users','action'=>'fb_connect'));?>",{"data[User]":response},function(data) {
		
               if(data==1){
		window.location.href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'publicProfile'));?>";
	       }
               if(data==2){
		window.location.href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'login'));?>";
	       }
            });
        });
    }
    
    function login() {

        FB.getLoginStatus(function(response) {
            
            
            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token
                // and signed request each expire
                var uid = response.authResponse.userID;
                var accessToken = response.authResponse.accessToken;
                testAPI();
            } else if (response.status === 'not_authorized') {
                // the user is logged in to Facebook,
                // but has not authenticated your app
                FB.login(function(response) {
                // handle the response
                testAPI();
                }, {scope: 'email,user_likes'});
            } else {
                // the user isn't logged in to Facebook.
                FB.login(function(response) {
                    // handle the response
                    testAPI();
                }, {scope: 'email,user_likes'});
            }
        });
    }
      $(".superlogout").on('click',function(e){
	e.preventDefault();
		fbLogoutUser();
	});
    
    function fbLogoutUser() {
		//check if logout is 
		FB.getLoginStatus(function(ret) {
			/// are they currently logged into Facebook?
			if(ret.authResponse) {
				//they were authed so do the logout
				FB.logout(function(response) {
					window.location.href="/users/logout";
				});
			} else {
				///do something if they aren't logged in
				//or just get rid of this if you don't need to do something if they weren't logged in
				 window.location.href="/users/logout";
			}
		});
	}
</script>
