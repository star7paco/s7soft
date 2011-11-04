<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page import="com.google.appengine.api.users.User" %>
<%@ page import="com.google.appengine.api.users.UserService" %>
<%@ page import="com.google.appengine.api.users.UserServiceFactory" %>
<%@ page import="com.s7soft.gae.itnews.rss.RssReader" %>


<%@page import="java.util.List"%>
<%@page import="com.sun.syndication.feed.synd.SyndEntry"%>
<%@page import="org.apache.commons.lang.builder.ToStringBuilder"%>
<%@page import="org.apache.commons.lang.builder.ToStringStyle"%><html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Hello App Engine</title>
  </head>

  <body>
    <h1>Hello App Engine!</h1>

    <table>
      <tr>
        <td colspan="2" style="font-weight:bold;">Available Servlets:</td>
      </tr>
      <tr>
        <td><a href="itnews">Itnews</a></td>
      </tr>
    </table>

<% RssReader rss = new RssReader("http://www.google.com/reader/public/atom/user%2F01437305406524732423%2Fbundle%2Fja"); %>
<% List<SyndEntry> list = rss.getRss(); %>


     <table>
<% if(list != null) { %>
<% for(SyndEntry item : list){ %>
      <tr>

        <td><%= ToStringBuilder.reflectionToString(item, ToStringStyle.SHORT_PREFIX_STYLE) %></td>
      </tr>

<% } %>
<% } %>
    </table>


  </body>
</html>
