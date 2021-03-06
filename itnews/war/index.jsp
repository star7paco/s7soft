<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page import="org.apache.commons.lang.StringUtils"%>
<%@ page import="com.google.appengine.api.users.User" %>
<%@ page import="com.google.appengine.api.users.UserService" %>
<%@ page import="com.google.appengine.api.users.UserServiceFactory" %>
<%@ page import="com.s7soft.gae.itnews.db.ItemDao"%>
<%@ page import="com.s7soft.gae.itnews.bean.Item"%>
<%@ page import="java.util.List"%>
<%@ page import="java.util.Locale"%>
<%@page import="com.s7soft.gae.itnews.util.AdSense"%>

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


<%@page import="com.s7soft.gae.itnews.db.BoardDao"%>
<%@page import="com.s7soft.gae.itnews.bean.Title"%><html>
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


<% String pageString = request.getParameter("p"); %>
<% int p = (pageString != null ? Integer.parseInt(pageString) : 1 ); %>
<% int listcount = 10; %>

<% int from = 1; %>
<% int to = listcount; %>

<%
if(p > 1) {
	from = from +( p * listcount );
	to = to + ( p * listcount );
}
%>

<div data-role="page" data-theme="a" >
	<div data-role="header" data-position="fixed">
		<h1>s7soft</h1>
		<a href="index.jsp?&<%= "lang="+lang %>" data-icon="home" rel="external">Home</a>
	</div><!-- /header -->

	<div data-role="content">

	<ul data-role="listview"  data-inset="true">
	<% List<Title> list = BoardDao.getList( from , to ); %>
	<% if(list != null && list.size() > 0) { %>
		<% for(Title title : list){ %>

			<li><a href="v.jsp?k=<%= title.getKey() + "&lang="+lang %>" rel="external"><%= title.getTitle(lang) %></a></li>

		<% } %>



	<% }else{ %>

	not item

	<% } %>
</ul>
<br />
<fieldset class="ui-grid-a">

	<div class="ui-block-a">
		<a href="index.jsp?&p=<%= (p-1) + "&lang="+lang %>" data-role="button" data-icon="arrow-l" rel="external"  <%= (p > 1 ? "" : " class=\"ui-disabled\"" ) %>>back</a></div>


	<div class="ui-block-b">
		<a href="index.jsp?&p=<%= (p+1) + "&lang="+lang %>" data-role="button" data-icon="arrow-r" rel="external" data-iconpos="right" >next</a></div>

</fieldset><!-- /ui-grid-a -->

	</div><!-- /content -->

	<div data-role="footer" data-theme="d" data-position="fixed">
		<center><%= adFooter %></center>
	</div><!-- /footer -->

</div><!-- /page -->

</body>
</html>
