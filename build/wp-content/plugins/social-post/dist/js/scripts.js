/*jslint browser: true*/
/*global $, jQuery, Modernizr, enquire, audiojs*/

(function($) {

  function DownloadDemo(field_id) {
    var facebook_type = $('#_cmb2_facebook_type').val();
    var parent_group = $(field_id).parent('.cmb-td');
    var facebook_media = $(field_id).val();

    if (facebook_type == 'type_video_share') {
      parent_group.find('.download-files a').attr('href', facebook_media).removeAttr('download');
    } else if(facebook_type == 'type_gallery') {
      parent_group.find('.download-files a').remove();
    } else {
      parent_group.find('.download-files a').attr('href', facebook_media);
    }

    if (facebook_type == 'type_image') {
      parent_group.find('.demo-field').append('<img src="'+facebook_media+'">');
    }
    if (facebook_type == 'type_video') {
      parent_group.find('.demo-field').append('<video controls="" name="media"><source src="'+facebook_media+'" type="video/mp4"></video>');
    }
    if (facebook_type == 'type_video_share') {
      parent_group.find('.demo-field').append('<iframe width="560" height="315" src="'+facebook_media+'" frameborder="0" allowfullscreen></iframe>');
    }
    if (facebook_type == 'type_gallery') {
      var link_array = facebook_media.split("{next_image}");

      arr = $.grep(link_array,function(n){
        return(n);
      });
      //console.log(arr);
      media_link = '<ul>';
      $.each(arr, function( index, value ) {
        console.log(value);
        media_link += '<li><img src="' + value + '" width=100 height=100 ><a href="' + value + '" target="_blank" download>Download</a></li>';
      });
      media_link += '</ul>';
      parent_group.find('.demo-field').append(media_link);
    }
  }

  $(document).ready(function() {
    // Call to function
    DownloadDemo('#_cmb2_facebook_media');
  });

  $(window).load(function() {
    // Call to function
  });

  $(window).resize(function() {
    // Call to function
  });
})(jQuery);
