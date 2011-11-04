<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page import="com.google.appengine.api.users.User" %>
<%@ page import="com.google.appengine.api.users.UserService" %>
<%@ page import="com.google.appengine.api.users.UserServiceFactory" %>
<%@ page import="com.s7soft.gae.itnews.rss.RssReader" %>


<%@page import="java.util.List"%>
<%@page import="com.sun.syndication.feed.synd.SyndEntry"%>
<%@page import="com.sun.syndication.feed.synd.SyndContent"%>
<%@page import="org.apache.commons.lang.builder.ToStringBuilder"%>
<%@page import="org.apache.commons.lang.builder.ToStringStyle"%>
<%@page import="com.s7soft.gae.itnews.db.ItemDao"%>
<%@page import="com.s7soft.gae.itnews.bean.Item"%>

<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Hello App Engine</title>
  </head>

  <body>
    <h1><a href="http://www.s7soft.com">s7soft!</a></h1>

  <hr>

<% String pageString = request.getParameter("page"); %>
<% int p = (pageString != null ? Integer.parseInt(pageString) : 1 ); %>
<% int listcount = 5; %>

<% int from = 1; %>
<% int to = listcount; %>

<%
if(p > 1) {
	from = from +( p * listcount );
	to = to + ( p * listcount );
}
%>

<% List<Item> list = ItemDao.getList( from , to ); %>
     <table border="0">
<% if(list != null || list.size() > 0) { %>
	<% for(Item item : list){ %>
	      <tr><td>

	      <table border="1">
			<tr>
				<td>Title : <%= item.getTitle() %></td>
			</tr>
			<tr>
				<td><%= item.getBody().getValue() %></td>
			</tr>
   		  </table>
   		  <br>

	      </td></tr>

	<% } %>

	<tr><td>
	<table>
	<tr>
	<% if(p > 1){ %><td><a href="index.jsp?page=<%= (p-1) %>"> < </a></td><% } %><td><a href="index.jsp?page=<%= (p+1) %>"> > </a></td>
	</tr>
	</table>
	</td></tr>

<% }else{ %>
	<tr><td>データがありません</td></tr>
<% } %>
    </table>


  </body>
</html>
