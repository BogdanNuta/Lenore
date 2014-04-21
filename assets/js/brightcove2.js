String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g,""); }

$(document).ready(function()
{

    // $('#add-comment').live('click', function() {
    // 	var comment = $('#comments_input').val();
    // 	if(comment.length > 0) Brightcove.AddComment(comment);
    // });

    $('.rating img').live('click', function() {
<<<<<<< HEAD
    	var elem = $(this);
    	var rating = $(this).attr('alt');
    	var id = elem.closest(".meta").data("id");
    	if(rating) Brightcove.RateVideo(id, rating);
    })
	
    $('.grid-sort-options').live('click', function() {
    	var data = $(this).attr('id').split('-');
    	$('#grid-sort-label').html($(this).html())
    	$('#grid-sort-label').removeAttr('class').attr('class',data[1]);
    	Brightcove.SortGrid(data[1]);
    })

    $('.grid-filter-provider').live('click', function() {
    	var data = $(this).attr('id').split('-');
    	$('#grid-filter-label').html($(this).html());
    	if(data[1] == "all") {
	    	$('#grid-filter-label').removeAttr('class').attr('class','');		
    	} else {
	    	$('#grid-filter-label').removeAttr('class').attr('class',data[1]);
    	}
    	Brightcove.FilterGridByProvider(data[1]);
=======
      var elem = $(this);
      var rating = elem.attr('alt');
      var id = elem.closest(".meta").data("id");
      if(rating) Brightcove.RateVideo(id, rating);
    });

    $('.grid-sort-options').live('click', function() {
      var data = $(this).attr('id').split('-');
      $('#grid-sort-label').html($(this).html())
      $('#grid-sort-label').removeAttr('class').attr('class',data[1]);
      Brightcove.SortGrid(data[1]);
    })

    $('.grid-filter-provider').live('click', function() {
      var data = $(this).attr('id').split('-');
      $('#grid-filter-label').html($(this).html());
      if(data[1] == "all") {
        $('#grid-filter-label').removeAttr('class').attr('class','');
      } else {
        $('#grid-filter-label').removeAttr('class').attr('class',data[1]);
      }
      Brightcove.FilterGridByProvider(data[1]);
>>>>>>> c9d61af3bf276d9214f945322994066b0035e7e7
    })

});

function onTemplateLoaded(pExperienceID) {
    Brightcove.playerAPIInit(pExperienceID);
}

function onTemplateReady(e) {
	Brightcove.socialModule.setLink($('#video-url').attr('value'));
        Brightcove.videoPlayerModule.setVolume(.5);
}

function onMediaComplete() {
	Brightcove.PlayNext();
};

var Brightcove = {

	parentTabIndex : 0,
    // load video in player
    loadVideo: function(pVideoID) {
        if (Brightcove.menuModule.isMenuPageShowing()) {
            Brightcove.menuModule.closeMenuPage();
        }
        this.videoPlayerModule.loadVideo(pVideoID);
    },
    // initialize experience
    playerAPIInit: function(pExperienceID) {
        this.bcPlayer;
        this.videoPlayerModule;
        this.bcPlayer = brightcove.getExperience(pExperienceID);
        this.videoPlayerModule = this.bcPlayer.getModule(APIModules.VIDEO_PLAYER);
        this.experienceModule = this.bcPlayer.getModule(APIModules.EXPERIENCE);
        this.menuModule = this.bcPlayer.getModule(APIModules.MENU);
		this.socialModule = this.bcPlayer.getModule(APIModules.SOCIAL);
        this.experienceModule.addEventListener(BCExperienceEvent.TEMPLATE_READY, onTemplateReady);
        this.videoPlayerModule.addEventListener(BCMediaEvent.COMPLETE, onMediaComplete);
    },
    // Load comments for video
    LoadComments: function(video_id) {
    	var currentVideoUrl = $("#video-url").attr("value");
    	if($("#video-url").length == 0) {
    		currentVideoUrl = window.location.href;
    	}

    	if(currentVideoUrl.indexOf('?') > -1) {
    		currentVideoUrl = currentVideoUrl.substring(0, currentVideoUrl.indexOf('?'));
    	}

    	/*
    	$("#comments-list").html("");
    	$("#facebook-jssdk").remove();
    	var mydiv = document.getElementById('comments-list');
		mydiv.innerHTML = '<div id="fb-root"></div><div class="fb-comments" data-href="' + currentVideoUrl + '" data-num-posts="1" data-width="283" data-colorscheme="dark"></div>';

		var d = document;
		var s = "script";
	  	var id = "facebook-jssdk";
	  	var js, fjs = d.getElementsByTagName(s)[0];
	    if (d.getElementById(id)) {return;}
	    js = d.createElement(s); js.id = id;
	    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=452560464757998";
	    fjs.parentNode.insertBefore(js, fjs);

		jQuery.get("https://graph.facebook.com", { "ids": currentVideoUrl },function(data) {
			if(data[currentVideoUrl]["comments"]) {
				var numCount = data[currentVideoUrl]["comments"];
				$("#myCommentsCount").html(numCount);
			}
			else {
				$("#myCommentsCount").html("0");
			}
		},"json");
		*/
        // $.ajax({
        //     url: base_url + 'comments/get/',
        //     data: ({ id: video_id }),
        //     success: function(data) {
        //         var content = data.trim();
        //         $('#comments-list').html(content);
        //     }
        // });
    },
	PlayNext: function() {

		$('.grid li').removeClass('selected');
		$('#up-next-videos li ul li').removeClass('selected');
		$('#related-videos li ul li').removeClass('selected');

		var data = '';
		var currentVideo = this.videoPlayerModule.getCurrentVideo();
		//var elms = $('#up-next-videos li ul li, #related-videos li ul li');
		var upNextElms = $('#up-next-videos li ul li');
		var relatedElms = $('#related-videos li ul li');
		var elms = $.merge(upNextElms, relatedElms);

		// loop through all up-next videos
		for (var i=0; i < elms.length; i++) {
			// if element has an id
			if(elms[i].id != "") {
				var elm = $('#' + elms[i].id);
			    var elmId = elm.attr("id");
			    // if element id starts with v-
			    if(elmId.indexOf('v-') == 0)
			    {
			    	data = elmId.split('-');
			    	var vid = data[1];
					// only play this up-next video if it's not the active video and if it hasn't been played yet
			    	if(currentVideo.id != vid && !elm.hasClass("played"))
			    	{
			    		// page scroller based on video positioning
			    		if(Brightcove.parentTabIndex != elm.parent().parent().index()) {
			    			Brightcove.parentTabIndex = elm.parent().parent().index();
			    			$("#player-tabs .next a").trigger("click");
			    		}

			    		// set the share link
			    		var vid_url = $('#v-' + vid + ' .thumb').attr('href');
			    		$('#video-url').attr('value',vid_url);
			    		Brightcove.socialModule.setLink($('#video-url').attr('value'));

			    		// get the rating from the db for video
			    		var vid_rating = this.GetRating(vid);
			    		elm.addClass("played");
			    		elm.addClass('selected');

			    		$('#video_id').attr('value', vid);

						this.upnextVideoId = vid;
			    		this.loadVideo(vid);
			    		$('#video-meta').html('');
			    		$('#video-meta').html($('#video-meta-'+vid).html());
			    		addthis.toolbox('#add_this-'+vid);
			    		$('#related-link-details').html('').html($('#related-link-'+vid).html());

			    		// init raty library for video
<<<<<<< HEAD
						$('#rating-active').ifExists(function(){
							this.raty({
							path: base_url + "assets/images/",
							starOn: "star-on.gif",
							starOff: "star-off.gif",
							width: 91,
							start: vid_rating,
							hintList: lang_ratings_text.split(',')
							});
						});
						
=======
              $('#rating-active').ifExists(function(){
                this.raty({
                  path: base_url + "assets/images/",
                  starOn: "star-on.gif",
                  starOff: "star-off.gif",
                  width: 91,
                  start: vid_rating,
                  hintList: lang_ratings_text.split(',')
                });
              });

>>>>>>> c9d61af3bf276d9214f945322994066b0035e7e7
						// load comments for video
						$('#comments-list').html('');
						//$('#comments-list').html($('#comments-list-'+vid).html());
						var currentVideoUrl = $("#video-url").attr("value");
				    	if($("#video-url").length == 0) {
				    		currentVideoUrl = window.location.href;
				    	}

				    	if(currentVideoUrl.indexOf('?') > -1) {
				    		currentVideoUrl = currentVideoUrl.substring(0, currentVideoUrl.indexOf('?'));
				    	}

				    	var fbUrl = encodeURIComponent(currentVideoUrl);
				    	var tempFBUrlArray = [];
		                var sses = fbUrl.split("%2F");
		                var encodeNext = false;
		                for(var i in sses)
		                {
		                	if(encodeNext == true)
		                	{
		                		sses[i] = encodeURIComponent(sses[i]);
		                	}
		                	if(sses[i] == "watch")
		                	{
		                		encodeNext = true;
		                	}

		                	tempFBUrlArray.push(sses[i]);
		                }

				    	$("#comments-list").html('<div class="fb-comments" data-href="' + tempFBUrlArray.join("%2F") + '" data-num-posts="1" data-width="298" data-colorscheme="dark"></div>');
				    	FB.XFBML.parse($("#comments-list").get(0));

						$("#comment-count").html('0');
						$("#comment-count").html($("#comment-count-"+vid).html());

						//this.LoadComments(vid);
                        //put your code for FB here
			    		return false;
			    	}
			    }
			}
		}
	},
    SortGrid: function(val) {
        $.ajax({
            url: base_url + 'ajax/grid/',
            data: ({ sort: val, filter: $('#grid-filter-label').attr('class'), path:encodeURIComponent(pagepath), tags:encodeURIComponent(pagetags) }),
            success: function(data) {
                var content = data.trim();
                $('#grid-wrapper').html(content);
		        setTimeout($('.tooltip-box').hide(),1000);
            }
        });
        setTimeout($('.tooltip-box').hide(),1000);
    },
    FilterGridByProvider: function(val) {
    	if(val == "all") val = "";
        $.ajax({
            url: base_url + 'ajax/grid/',
            data: ({ filter: val, sort: $('#grid-sort-label').attr('class'), path:encodeURIComponent(pagepath), tags:encodeURIComponent(pagetags) }),
            success: function(data) {
                var content = data.trim();
                $('#grid-wrapper').html(content);
		        setTimeout($('.tooltip-box').hide(),1000);
            }
        });
        setTimeout($('.tooltip-box').hide(),1000);
    },
    ValidateSearch: function() {
        var term = $('#term').val();
        if (term.trim().length == 0 || term.trim() == 'Search Videos' || term.trim() == 'Recherche vidéos') {
            alert(lang_enter_search_term);
            return false;
        } else {
           // $('#term').val(escape(term));
            $('#term').val(term);
            return true;
        }
    },
    AddComment: function(comment) {
    // 	var vid = $('#video_id').val();
    // 	$('#be-first').remove();
    //     $.ajax({
    //         url: base_url + 'comments/post/',
    //         data: ({ id: vid, comment: comment}),
    //         success: function(data) {
    //             var content = data.trim();
    //             $('.count').html(parseInt($('.count').html())+1);

				// var d = new Date();
				// var curr_date = d.getDate();
				// var curr_month = d.getMonth(); //months are zero based
				// var curr_year = d.getFullYear();

				// var month=new Array(12);
				// month[0]="January";
				// month[1]="February";
				// month[2]="March";
				// month[3]="April";
				// month[4]="May";
				// month[5]="June";
				// month[6]="July";
				// month[7]="August";
				// month[8]="September";
				// month[9]="October";
				// month[10]="November";
				// month[11]="December";

				// if(lang == "fr") {
				// 	month=new Array(12);
				// 	month[0]="janvier";
				// 	month[1]="février";
				// 	month[2]="mars";
				// 	month[3]="avril";
				// 	month[4]="mai";
				// 	month[5]="juin";
				// 	month[6]="juillet";
				// 	month[7]="août";
				// 	month[8]="septembre";
				// 	month[9]="octobre";
				// 	month[10]="novembre";
				// 	month[11]="décembre";
				// }

				// var display = month[curr_month] + ' ' + curr_date + ', ' + curr_year;
    //             comment = comment.replace('>','&gt;').replace('<','&lt;');
    //             $('#comments-list ul').prepend('<li><p>' + comment + '</p><em>' + display + '</em></li>');
    //             $('#comments_input').val('');
    //         }
    //     });
    },
<<<<<<< HEAD
	RateVideo: function(id, rating) {
        $.ajax({
            url: base_url + 'ratings/rate/',
			data: { item: id, rating: rating }
        });
=======
    RateVideo: function(id, rating) {
      $.ajax({
        url: base_url + 'ratings/rate/',
        data: { item: id, rating: rating }
      });
>>>>>>> c9d61af3bf276d9214f945322994066b0035e7e7
    },
    GetRating: function(id) {
    	var rateVal = 0;
        $.ajax({
        	async: false,
            url: base_url + 'ratings/get/',
            data: ({ items: id }),
            success: function(data) {
                var content = data.trim();
                rateVal = content;

            }
        });
        return rateVal;
    }
};

