import jQuery from 'jquery';
import underscore from 'underscore';
import calendar from 'bootstrap-calendar';

jQuery(()=>{
    var cal = jQuery('#calendar').calendar({
        events_source: '/event/api',
        // events_source: [
        //     {
        //         "id": 293,
        //         "title": "Event 1",
        //         "url": "http://example.com",
        //         "class": "event-important",
        //         "start": 12039485678000, // Milliseconds
        //         "end": 1234576967000 // Milliseconds
        //     },
        //     // ...
        // ],
        // tmpl_path: './assets/lib/calendar/tmpls/'
    });
    // console.log(cal);
})

// console.log(jQuery,underscore);