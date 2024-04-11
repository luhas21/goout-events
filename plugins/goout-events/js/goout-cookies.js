// Cookies Scripts

console.log('COOKIES SCRIPT');

lang = 'cs';
function trackingAccepted() {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://c.seznam.cz/js/rc.js';

    document.head.appendChild(script);
    var retargetingConf = {
        rtgId: 21191,
    };
    if (window.rc && window.rc.retargetingHit) {
        window.rc.retargetingHit(retargetingConf);
    }
}

goOutCookie.init({
    lang: lang,
    accepted: trackingAccepted,
    dataLayer: window.dataLayer,
    showSettingsButton: true,
    showSettingsID: 'cookie-settings',
    customLink: '/cookie-policy/',
});

/*
function loadCookieScripts() {

    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', get_field('google_analytics_id'), {
        'ad_storage': getCookie('goout-tracking_ad_storage') || 'denied',
        'analytics_storage': getCookie('goout-tracking_analytics_storage') || 'denied',
        'ad_user_data': getCookie('goout-tracking_ad_user_data') || 'denied',
        'ad_personalization': getCookie('goout-tracking_ad_personalization') || 'denied',
    });

    ga('send', 'pageview');
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');

    fbq('init', '862504247105662');
    fbq('track', "PageView");

    var script = document.createElement("script");
        script.type = "text/javascript";
        script.innerHTML = "(function(w,d,s,l,i){w[l]=w[l]||[];var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-NGVQ6TQ');";
        document.body.appendChild(script);
}
loadCookieScripts();
*/
