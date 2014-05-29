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
        IN.API.Profile("me").fields("firstName", "lastName", "industry", "location:(name)", "picture-url", "headline", "summary", "num-connections", "public-profile-url", "distance", "positions", "email-address", "educations:(field-of-study,degree,school-name)", "date-of-birth","skills","certifications").result(function(me) {

            var profile = me.values[0];
            //alert(me);return false;
            //info = [];
            //info[0] = profile.id;
            //info[1] = profile.firstName;
            //info[2] = profile.lastName;
            //info[3] = profile.emailAddress;
            //info[4] = profile.location.name;
            //alert(info);return false;
            $.ajax({
                type: "POST",
                data: {me: me},
                url: '<?php echo BASE_URL ?>users/linkedin_callback',
                success: function(msg) {

                    if (msg == 1) {
                        //alert('Success Registered');
                        window.location.href = '<?php echo BASE_URL ?>/users/linkedIn_connect';
                    } else if (msg == 2) {
                        // alert('Some Error Occured!')
                        window.location.href = '<?php echo BASE_URL ?>/users/login';
                    } else {
                        // alert('Success Login');
                        window.location.href = '<?php echo BASE_URL ?>/users/linkedIn_connect';
                    }
                }
            });
        });
    }
    
     function onLinkedIn1() {
	IN.API.Raw("/company-search:(companies:(id,name,website-url,logo-url))").result(function(data) {
	      var profile = data;
	     //  info = [];
	     //info[0] = profile.id;
	      $.ajax({
                type: "POST",
                data: {profile: profile},
                url: '<?php echo BASE_URL ?>users/linkedin_callback',
                success: function(msg) {

                    if (msg == 1) {
                        //alert('Success Registered');
                        window.location.href = '<?php echo BASE_URL ?>/members/dashboard';
                    } else if (msg == 2) {
                        // alert('Some Error Occured!')
                        window.location.href = '<?php echo BASE_URL ?>/users/login';
                    } else {
                        // alert('Success Login');
                        window.location.href = '<?php echo BASE_URL ?>/members/dashboard';
                    }
                }
            });
	    
	});
	
    }
    function onLinkedInJob() {
    //IN.API.Raw("/companies:(id,name,description,industry,logo-url)").method("GET").result(function(resultCallback){
	IN.API.Raw("people-search:(people:(id,first-name,last-name,public-profile-url,three-current-positions:(title,company:(name,industry)),distance,picture-url))").result(function(data) {
	    var profile = data;
	     //  info = [];
	     //info[0] = profile.id;
	    $.ajax({
                type: "POST",
                data: {profile: profile},
                url: '<?php echo BASE_URL ?>users/linkedin_callback',
                success: function(msg) {

                    if (msg == 1) {
                        //alert('Success Registered');
                        window.location.href = '<?php echo BASE_URL ?>/members/dashboard';
                    } else if (msg == 2) {
                        // alert('Some Error Occured!')
                        window.location.href = '<?php echo BASE_URL ?>/users/login';
                    } else {
                        // alert('Success Login');
                        window.location.href = '<?php echo BASE_URL ?>/members/dashboard';
                    }
                }
            });
	    
	});
	
    }