jQuery.fn.passwordStrength = function( options ){
	return this.each(function(){
		var that = this;that.opts = {};
		that.opts = jQuery.extend({}, jQuery.fn.passwordStrength.defaults, options);
		
		that.div = jQuery(that.opts.targetDiv);
		that.defaultClass = that.div.attr('class');
		
		that.percents = (that.opts.classes.length) ? 100 / that.opts.classes.length : 100;

		 v = jQuery(this)
		.keyup(function(){
			if( typeof el == "undefined" )
				this.el = jQuery(this);
			var s = getPasswordStrength (this.value);
			
			var p = this.percents;
			var t = Math.floor( s / p );
			
			if( 100 <= s )
				t = this.opts.classes.length - 1;
				
			this.div
				.removeAttr('class')
				.addClass( this.defaultClass )
				.addClass( this.opts.classes[ t ] );
			
		/**** script to show week/moderate/strong in password (Modified by: Vikas Uniyal)****/
        jQuery(this).keypress(function(){
                  var strClasses = jQuery("#passwordStrengthDiv").attr("class");
                  if(strClasses == 'is0 is10' || strClasses == 'is0 is20' || strClasses == 'is0 is30' || strClasses == 'is0 is40')
                  {
                        jQuery("#strengthWords").html('<font color="#ff0000">Weak</font>');
                  }
                  else if(strClasses == 'is0 is50' || strClasses == 'is0 is60' || strClasses == 'is0 is70' || strClasses == 'is0 is80')
                  {
                        jQuery("#strengthWords").html('<font color="#FF8C39">Moderate</font>');
                  }
                  else if(strClasses == 'is0 is90' || strClasses == 'is0 is100' || strClasses == 'is0 is110' || strClasses == 'is0 is120')
                  {
                        jQuery("#strengthWords").html('<font color="green">Strong</font>');
                  }
            });
        
			var passlength = (jQuery("#password").val()).length;
			if(passlength < 1)
			{
				
				jQuery("#passwordStrengthDiv").attr('class','is0');
				jQuery("#strengthWords").html('');
			}
	/********************************************************/
	
		})
		
	});

	function getPasswordStrength(H){
		
		var D=(H.length);
		if(D>5){
			D=5
		}
		var F=H.replace(/[0-9]/g,"");
		var G=(H.length-F.length);
		if(G>3){G=3}
		var A=H.replace(/\W/g,"");
		var C=(H.length-A.length);
		if(C>3){C=3}
		var B=H.replace(/[A-Z]/g,"");
		var I=(H.length-B.length);
		if(I>3){I=3}
		var E=((D*10)-20)+(G*10)+(C*15)+(I*10);
		if(E<0){E=0}
		if(E>100){E=100}
		return E
	}

	function randomPassword() {
		var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$_+";
		var size = 10;
		var i = 1;
		var ret = ""
		while ( i <= size ) {
			$max = chars.length-1;
			$num = Math.floor(Math.random()*$max);
			$temp = chars.substr($num, 1);
			ret += $temp;
			i++;
		}
		return ret;
	}

};
	
$.fn.passwordStrength.defaults = {
	classes : Array('is10','is20','is30','is40','is50','is60','is70','is80','is90','is100','is110','is120'),
	targetDiv : '#passwordStrengthDiv',
	cache : {}
}
