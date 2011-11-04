package com.s7soft.gae.itnews;

import java.io.IOException;
import java.util.Date;
import java.util.List;

import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.google.appengine.api.datastore.Text;
import com.s7soft.gae.itnews.bean.Item;
import com.s7soft.gae.itnews.db.ItemDao;
import com.s7soft.gae.itnews.rss.RssReader;
import com.sun.syndication.feed.synd.SyndContent;
import com.sun.syndication.feed.synd.SyndEntry;

public class CronServlet extends HttpServlet {

	private static final long serialVersionUID = 1L;

	String rssUrl = "http://www.google.com/reader/public/atom/user%2F01437305406524732423%2Fbundle%2Fja";

	public void doGet(HttpServletRequest req, HttpServletResponse resp)
			throws IOException {
		resp.setContentType("text/plain");

		RssReader rss = new RssReader(rssUrl);

		List<SyndEntry> list = rss.getRss();

		int i = 0;
		if (list != null) {
			for (SyndEntry rssEntry : list) {

				if(rssEntry.getTitle().startsWith("PR:")){continue;}

				Item item = ItemDao.get("ja_"+rssEntry.getLink());

				if(item != null){continue;}
				item = new Item();


				String body = "";
				List<SyndContent> contents = (List<SyndContent>)rssEntry.getContents();
				for( SyndContent content : contents){
					body = body + content.getValue();
				}
				if(rssEntry.getDescription() != null ){
					body = body + rssEntry.getDescription().getValue();
				}


				while ( body.indexOf("<iframe") >= 0) {

					body = body.substring(0 , body.indexOf("<iframe")) + body.substring(body.indexOf("iframe>") + 7);

				}

				item.setKey("ja_"+rssEntry.getLink());
				item.setTitle(rssEntry.getTitle());
				item.setLang("ja");
				item.setUrl(rssEntry.getLink());
				item.setBody(new Text(body));
				item.setInsDate(new Date());
				ItemDao.add(item);

				i ++;

			}
			resp.getWriter().println(i + " ok");
		}


	}
}