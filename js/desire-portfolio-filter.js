/**
 * @author: Franck LEBAS
 * @package desire-portfolio-filter
 */

( function( $ ) {

    // Portfolio filtering
    var $container = $('.portfolio').isotope({
        itemSelector: '.portfolio-item',
        filter: '*',
        percentPosition: true,
        masonry: {
            // use outer width of grid-sizer for columnWidth
            columnWidth: '.grid-sizer',
            gutter: '.gutter-sizer'
        }
    } );
    // filter items when filter link is clicked
    $( '.filter-button-group' ).on('click', 'button', function(){
        var filterValue = $(this).attr('data-filter');
        $container.isotope({ filter: filterValue });
    } );

} )( jQuery );