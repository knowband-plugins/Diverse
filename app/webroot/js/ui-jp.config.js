// lazyload config

var jp_config = {
  easyPieChart:   [ siteURL + 'js/easypiechart/jquery.easy-pie-chart.js' ],
  sparkline:      [ siteURL + 'js/sparkline/jquery.sparkline.min.js' ],
  plot:           [ siteURL + 'js/flot/jquery.flot.min.js',
                    siteURL + 'js/flot/jquery.flot.resize.js',
                    siteURL + 'js/flot/jquery.flot.tooltip.min.js',
                    siteURL + 'js/flot/jquery.flot.spline.js',
                    siteURL + 'js/flot/jquery.flot.orderBars.js',
                    siteURL + 'js/flot/jquery.flot.pie.min.js' ],
  slimScroll:     [ siteURL + 'js/slimscroll/jquery.slimscroll.min.js' ],
  vectorMap:      [ siteURL + 'js/jvectormap/jquery-jvectormap.min.js',
                    siteURL + 'js/jvectormap/jquery-jvectormap-world-mill-en.js',
                    siteURL + 'js/jvectormap/jquery-jvectormap-us-aea-en.js',
                    siteURL + 'js/jvectormap/jquery-jvectormap.css' ]
};

function gritter_success(msg,refresh){
    $.gritter.add({
            title: 'Notification!',
            text: msg,
            class_name:'gritter-success',
            time:3000,
            after_open:function(){
                if(refresh){
                    location.reload();
                }
            }
    });
}
function gritter_danger(msg){
    $.gritter.add({
            title: 'Notification!',
            text: msg,
            class_name:'gritter-danger',
            time:3000
    });
}
function gritter_info(msg){
    $.gritter.add({
            title: 'Notification!',
            text: msg,
            class_name:'gritter-light',
            time:2000
    });
}