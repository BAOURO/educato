/**
 * Created by emmanuelkwene on 18/04/2016.
 */

jQuery(document).ready(function ($) {
    'use strict';

    var navLinks = $('#panel-navigation').find('a');
    var sections = $('#panel-content').find('.panel-content-section');
    var mediaUploader;


    navLinks.each(function () {
        var link = $(this);

        link.on('click', function (event) {
            event.stopPropagation();
            event.preventDefault();

            // When click, we get the targeted section id
            // We loop into sections looking for the section that has that id
            var targetedSection = link.data('section-target');

            sections.each(function () {
                var section = $(this);

                if(targetedSection == section.data('section-id')) section.addClass('display-section');
                else  section.removeClass('display-section');
            });

            // Now we can add .selected class to the current link
            // and we make sure that the link having this class is unique
            navLinks.each(function () {
                var otherLink = $(this);
                otherLink.removeClass('selected');
            });
            link.addClass('selected');

            return false;
        });
    });


    $('#header_logo_url_chooser').on('click', function (event) {
        event.preventDefault();
        
        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        
        // Extend the wp.media object
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false });

        // When a file is selected, grab the URL and set it as the text field's value
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#header_logo').attr('src',attachment.url);
            $('#header_logo_url').val(attachment.url);
        });
        
        // Open the uploader dialog
        mediaUploader.open();

        return false;
    });

});