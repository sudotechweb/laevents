const jQuery = require('jquery');

var mycal = jQuery('#calendar').calendar({events_source: '/api'})
// jquery.getJSON('/api',(data)=>{
// })