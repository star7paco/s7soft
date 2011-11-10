<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page import="org.apache.commons.lang.StringUtils"%>
<%@ page import="com.google.appengine.api.users.User" %>
<%@ page import="com.google.appengine.api.users.UserService" %>
<%@ page import="com.google.appengine.api.users.UserServiceFactory" %>
<%@ page import="com.s7soft.gae.itnews.db.ItemDao"%>
<%@ page import="com.s7soft.gae.itnews.bean.Item"%>
<%@ page import="java.util.List"%>
<%@ page import="java.util.Locale"%>
<%@ page import="com.s7soft.gae.itnews.util.AdSense"%>
<%@ page import="com.s7soft.gae.itnews.db.BoardDao"%>
<%@ page import="com.s7soft.gae.itnews.bean.Title"%>
<%@ page import="com.s7soft.gae.itnews.bean.Body"%>

<% log("Start v"); %>
<% String keyStr = request.getParameter("k"); %>
<% Long key = Long.valueOf(keyStr); %>
<% Locale locale = request.getLocale(); %>
<% String userAgent = request.getHeader("user-agent"); %>
<%

boolean mobile = false;
if(userAgent.indexOf("Android") > 0){
	mobile = true;
}else if( userAgent.indexOf("iPhone") > 0 ){
	mobile = true;
}else if( userAgent.indexOf("iPod") > 0 ){
	mobile = true;
}else if( userAgent.indexOf("ios") > 0 ){
	mobile = true;
}else{
	mobile = false;
}


String adTop = "";
String adFin = "";

String adFooter = "";

if(mobile){
	adFooter = AdSense.MbAdfin;
//	adFin = AdSense.MbAdfin;
}else{
	adFooter = AdSense.adfin;
	adTop = AdSense.adtop;
	adFin = AdSense.adfin;
}

%>



<% log("Locale : "+locale); %>
<% log("is mobile : "+mobile); %>

<% String lang = "ja"; %>
<% String localeString = request.getParameter("lang"); %>

<% if( StringUtils.isBlank(localeString) ){%>
	<% if( Locale.KOREAN.equals(locale) || Locale.KOREA.equals(locale) ){lang = "ko";} %>
<% } else { %>
	<% lang = localeString; %>
<% } %>
<!doctype html public "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html>
	<head>
	<title>s7soft</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0rc2/jquery.mobile-1.0rc2.min.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/mobile/1.0rc2/jquery.mobile-1.0rc2.min.js"></script>




<script type="text/javascript">
jQuery(function(){
    $('img').each(function(){
        var max = 0;
        if (navigator.userAgent.indexOf('iPhone') > 0) {
            max = 280; // iPhoneの最大幅
        } else if (navigator.userAgent.indexOf('iPad') > 0 ) {
            max = 768; // iPadの最大幅
        } else if (navigator.userAgent.indexOf('iPod') > 0 ) {
            max = 280; // iPodの最大幅
        } else if (navigator.userAgent.indexOf('Android') > 0) {
            max = 280; // Androidの最大幅
        }
        var w = $(this).width();
        var h = $(this).height();
        if (max != 0 && w > max) {
            $(this).width(max).height(Math.round((max/w)*h));
        }
    });
});
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-3871213-12']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>



<div data-role="page" data-theme="a" >

<%
Long max = BoardDao.getMaxID();
log("max : " + max);
Title title = BoardDao.get( key );
log("title : " + title);
if(title != null ) {
	Body body = BoardDao.getBody( lang , key );
	log("body : " + body);
%>

		<div data-role="header" data-position="fixed">
		<h1><%= title.getTitle(lang) %></h1>
		<a href="index.jsp?&<%= "lang="+lang %>" data-icon="home" rel="external">Home</a>
		</div><!-- /header -->
<div data-role="content">
<h6><%= title.getInsDate() %><br/><%= title.getTitle(lang) %></h6>
<% if(body != null ) { %>
		<%= adTop + body.getBody().getValue() + adFin %>
<% } else { %>
No data
<% } %>



<% }else{ %>

<div data-role="header">
<h1>not item</h1>
<a href="index.jsp?&<%= "lang="+lang %>" data-icon="home" rel="external">Home</a>
</div><!-- /header -->

<div data-role="content">
not item



<% } %>

<fieldset class="ui-grid-a">

	<div class="ui-block-a">
		<a href="v.jsp?&k=<%= (key-1) + "&lang="+lang %>" data-role="button" data-icon="arrow-l" rel="external" <%= (key <= 1 ? " class=\"ui-disabled\"" : "" ) %>>back</a></div>

	<% if(key < max){ %>
	<div class="ui-block-b">
		<a href="v.jsp?&k=<%= (key+1) + "&lang="+lang %>" data-role="button" data-icon="arrow-r" rel="external"  data-iconpos="right" >next</a></div>
	<% }else{ %>
	<div class="ui-block-b">
		<a href="v.jsp?&k=<%= (key+1) + "&lang="+lang %>" data-role="button" data-icon="arrow-r" rel="external" class="ui-disabled" data-iconpos="right" >next</a></div>
	<% } %>
</fieldset><!-- /ui-grid-a -->
</div><!-- /content -->

<div data-role="footer" data-theme="d" data-position="fixed">
	<center><%= adFooter %></center>
</div><!-- /footer -->

</div><!-- /page -->

</body>
</html>
