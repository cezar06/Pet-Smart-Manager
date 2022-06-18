Share = {
    twitter: function(purl, ptitle) {
    url = 'http://twitter.com/share?';
    url += 'text=' + encodeURIComponent(ptitle);
    url += '&url=' + encodeURIComponent(purl);
    url += '&counturl=' + encodeURIComponent(purl);
    Share.popup(url);
    },
    popup: function(url) {
    window.open(url,'','toolbar=0,status=0,width=626, height=436');
    }
    };